#!/usr/bin/env node

const siteUrl = (process.env.ROLLING_RENO_SITE_URL || process.env.SITE_URL || 'https://rollingreno.com').replace(/\/$/, '');
const limit = Number(process.env.ROLLING_RENO_QA_LIMIT || 10);
const maxSameReadTimeRatio = Number(process.env.ROLLING_RENO_MAX_SAME_READ_RATIO || 0.6);
const minDistinctReadTimes = Number(process.env.ROLLING_RENO_MIN_DISTINCT_READ_TIMES || 3);
const wordsPerMinute = Number(process.env.ROLLING_RENO_WORDS_PER_MINUTE || 200);

const failures = [];
const warnings = [];

function stripHtml(value = '') {
  return String(value)
    .replace(/<script[\s\S]*?<\/script>/gi, ' ')
    .replace(/<style[\s\S]*?<\/style>/gi, ' ')
    .replace(/<[^>]+>/g, ' ')
    .replace(/&nbsp;/g, ' ')
    .replace(/&amp;/g, '&')
    .replace(/&#8217;/g, '’')
    .replace(/\s+/g, ' ')
    .trim();
}

function wordCount(html = '') {
  const text = stripHtml(html);
  return (text.match(/\b[\w’'-]+\b/g) || []).length;
}

function readMinutes(words) {
  return Math.max(1, Math.round(words / wordsPerMinute));
}

function hasHumanActionAlt(alt = '') {
  const normalized = alt.toLowerCase();
  const hasMaraOrHuman = /\b(mara|woman|person|diyer|renovator|owner)\b/.test(normalized);
  const hasAction = /\b(cleaning|sealing|organizing|measuring|fitting|sorting|labeling|testing|inspecting|checking|using|marking|repairing|working|kneeling|standing)\b/.test(normalized);
  return hasMaraOrHuman && hasAction;
}

function looksGeneric(media = {}, alt = '') {
  const src = String(media.source_url || '').toLowerCase();
  const normalizedAlt = alt.toLowerCase();
  return (
    /rr-feature-|feature-|checklist|diagram|illustration|abstract|template|stock/.test(src) ||
    /\b(checklist|diagram|illustration|abstract|template|generic|distinct rv|setup with|prep checklist)\b/.test(normalizedAlt)
  );
}

async function getJson(url) {
  const res = await fetch(url, {
    headers: { 'User-Agent': 'RollingRenoPublisherQA/1.0' },
    signal: AbortSignal.timeout(20000),
  });
  if (!res.ok) throw new Error(`${res.status} ${res.statusText} for ${url}`);
  return res.json();
}

const postsUrl = `${siteUrl}/wp-json/wp/v2/posts?per_page=${limit}&_embed=1&orderby=date&order=desc`;
const posts = await getJson(postsUrl);

const rows = posts.map((post) => {
  const media = post._embedded?.['wp:featuredmedia']?.[0] || {};
  const words = wordCount(post.content?.rendered || '');
  const minutes = readMinutes(words);
  const alt = media.alt_text || '';
  const row = {
    id: post.id,
    date: post.date,
    title: stripHtml(post.title?.rendered || ''),
    link: post.link,
    featured_media: post.featured_media,
    media_url: media.source_url || '',
    alt,
    words,
    read_minutes: minutes,
    has_human_action_alt: hasHumanActionAlt(alt),
    generic_signal: looksGeneric(media, alt),
  };

  if (!row.featured_media || !row.media_url) failures.push(`${row.id}: missing featured media`);
  if (!alt || alt.trim().length < 35) failures.push(`${row.id}: featured image alt text is missing or too thin`);
  if (!row.has_human_action_alt) failures.push(`${row.id}: alt text does not confirm Mara/person + visible action`);
  if (row.generic_signal) failures.push(`${row.id}: featured media/alt has generic, abstract, diagram, or template signal`);
  return row;
});

const readTimeCounts = new Map();
for (const row of rows) readTimeCounts.set(row.read_minutes, (readTimeCounts.get(row.read_minutes) || 0) + 1);
const mostCommonReadTimeCount = Math.max(0, ...readTimeCounts.values());
const sameReadTimeRatio = rows.length ? mostCommonReadTimeCount / rows.length : 0;
const distinctReadTimes = readTimeCounts.size;

if (sameReadTimeRatio > maxSameReadTimeRatio) {
  failures.push(`latest ${rows.length} posts have uniform read times: ${Math.round(sameReadTimeRatio * 100)}% share one read-time label`);
}
if (distinctReadTimes < minDistinctReadTimes) {
  failures.push(`latest ${rows.length} posts only have ${distinctReadTimes} distinct read-time labels; expected at least ${minDistinctReadTimes}`);
}

const mediaUrls = rows.map((row) => row.media_url).filter(Boolean);
const duplicateMedia = mediaUrls.filter((url, index) => mediaUrls.indexOf(url) !== index);
if (duplicateMedia.length) failures.push(`duplicate featured media URLs found: ${[...new Set(duplicateMedia)].join(', ')}`);

console.log(JSON.stringify({
  siteUrl,
  postsUrl,
  checked: rows.length,
  read_time_distribution: Object.fromEntries([...readTimeCounts.entries()].sort((a, b) => a[0] - b[0])),
  rows,
  warnings,
  failures,
  pass: failures.length === 0,
}, null, 2));

if (failures.length) process.exitCode = 1;
