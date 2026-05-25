#!/usr/bin/env node

const DEFAULT_TYPES = ['posts', 'pages', 'categories'];
const DEFAULT_PROD_URL = 'https://rollingreno.com';
const DEFAULT_STAGING_URL = 'https://rollingreno.flywheelstaging.com';
const targets = [
  targetFromEnv('prod', DEFAULT_PROD_URL),
  targetFromEnv('staging', DEFAULT_STAGING_URL),
].filter(Boolean);
const failures = [];

function targetFromEnv(label, fallbackUrl) {
  const upper = label.toUpperCase();
  const url = (process.env[`${upper}_URL`] || fallbackUrl || '').replace(/\/$/, '');
  if (!url) return null;
  return {
    label,
    url,
    authUser: process.env[`${upper}_AUTH_USER`] || '',
    authPass: process.env[`${upper}_AUTH_PASS`] || '',
  };
}

function authHeaders(target) {
  const headers = { 'User-Agent': 'RollingRenoContentDriftInventory/1.0' };
  if (target.authUser || target.authPass) {
    headers.Authorization = `Basic ${Buffer.from(`${target.authUser}:${target.authPass}`).toString('base64')}`;
  }
  return headers;
}

function stripHtml(value = '') {
  return String(value)
    .replace(/<script[\s\S]*?<\/script>/gi, ' ')
    .replace(/<style[\s\S]*?<\/style>/gi, ' ')
    .replace(/<[^>]+>/g, ' ')
    .replace(/&nbsp;/g, ' ')
    .replace(/&amp;/g, '&')
    .replace(/\s+/g, ' ')
    .trim();
}

function wordCount(value = '') {
  const text = stripHtml(value);
  if (!text) return 0;
  return text.split(/\s+/).length;
}

function endpoint(target, type, page) {
  const url = new URL(`/wp-json/wp/v2/${type}`, `${target.url}/`);
  url.searchParams.set('per_page', '100');
  url.searchParams.set('page', String(page));
  if (type !== 'categories') {
    url.searchParams.set('status', 'publish');
    url.searchParams.set('_fields', 'id,slug,link,modified_gmt,title,content,excerpt');
  } else {
    url.searchParams.set('_fields', 'id,slug,link,name,count');
  }
  return url;
}

async function fetchCollection(target, type) {
  const items = [];
  for (let page = 1; page <= 20; page += 1) {
    const url = endpoint(target, type, page);
    const res = await fetch(url, { headers: authHeaders(target), signal: AbortSignal.timeout(20000) });
    if (!res.ok) {
      const body = await res.text().catch(() => '');
      throw new Error(`${target.label} ${type}: HTTP ${res.status} at ${url.href}${body ? ` (${body.slice(0, 120).replace(/\s+/g, ' ')})` : ''}`);
    }
    const batch = await res.json();
    if (!Array.isArray(batch)) throw new Error(`${target.label} ${type}: expected array response`);
    items.push(...batch);
    const totalPages = Number(res.headers.get('x-wp-totalpages') || '1');
    if (page >= totalPages || batch.length === 0) break;
  }
  return items;
}

async function collect(target) {
  const data = {};
  for (const type of DEFAULT_TYPES) data[type] = await fetchCollection(target, type);
  return data;
}

function bySlug(items) {
  return new Map(items.map((item) => [item.slug, item]));
}

function compareSlugSet(type, leftLabel, leftItems, rightLabel, rightItems) {
  const left = bySlug(leftItems);
  const right = bySlug(rightItems);
  const leftOnly = [...left.keys()].filter((slug) => !right.has(slug)).sort();
  const rightOnly = [...right.keys()].filter((slug) => !left.has(slug)).sort();
  console.log(`\n### ${type}`);
  console.log(`${leftLabel}: ${leftItems.length}; ${rightLabel}: ${rightItems.length}`);
  if (leftOnly.length) console.log(`${leftLabel}-only: ${leftOnly.join(', ')}`);
  if (rightOnly.length) console.log(`${rightLabel}-only: ${rightOnly.join(', ')}`);
  if (!leftOnly.length && !rightOnly.length) console.log('Slug sets match.');
  return { left, right, leftOnly, rightOnly };
}

function compareSharedContent(type, leftLabel, left, rightLabel, right) {
  if (type === 'categories') return;
  const shared = [...left.keys()].filter((slug) => right.has(slug)).sort();
  const material = [];
  for (const slug of shared) {
    const a = left.get(slug);
    const b = right.get(slug);
    const aWords = wordCount(a.content?.rendered || a.excerpt?.rendered || '');
    const bWords = wordCount(b.content?.rendered || b.excerpt?.rendered || '');
    const max = Math.max(aWords, bWords, 1);
    const delta = Math.abs(aWords - bWords) / max;
    const titleA = stripHtml(a.title?.rendered || '');
    const titleB = stripHtml(b.title?.rendered || '');
    if (delta >= 0.1 || titleA !== titleB) {
      material.push({ slug, titleA, titleB, aWords, bWords, delta });
    }
  }
  if (!material.length) {
    console.log(`Shared ${type}: no material title/body word-count drift at 10% threshold.`);
    return;
  }
  console.log(`Shared ${type}: material title/body drift:`);
  for (const item of material) {
    console.log(`- ${item.slug}: ${leftLabel} ${item.aWords} words / ${JSON.stringify(item.titleA)}; ${rightLabel} ${item.bWords} words / ${JSON.stringify(item.titleB)} (${Math.round(item.delta * 100)}% delta)`);
  }
}

console.log('# Rolling Reno content drift inventory');
console.log('Read-only WP REST comparison. No CMS writes or DB sync attempted.');
console.log(`Targets: ${targets.map((target) => `${target.label}=${target.url}`).join(', ')}`);

if (targets.length < 2) failures.push('Need both PROD_URL and STAGING_URL targets for drift inventory.');

const results = new Map();
for (const target of targets) {
  try {
    console.log(`\n## Fetching ${target.label}`);
    const data = await collect(target);
    results.set(target.label, data);
    console.log(`Fetched posts=${data.posts.length}, pages=${data.pages.length}, categories=${data.categories.length}`);
  } catch (error) {
    failures.push(error.message);
  }
}

if (results.has('prod') && results.has('staging')) {
  console.log('\n## Drift comparison');
  const prod = results.get('prod');
  const staging = results.get('staging');
  for (const type of DEFAULT_TYPES) {
    const { left, right } = compareSlugSet(type, 'prod', prod[type], 'staging', staging[type]);
    compareSharedContent(type, 'prod', left, 'staging', right);
  }
}

if (failures.length) {
  console.log('\n## Blockers');
  for (const failure of failures) console.log(`❌ ${failure}`);
  process.exitCode = 1;
} else {
  console.log('\n## Result');
  console.log('✅ Content drift inventory completed. Use the slug/title/body deltas for targeted manual production → staging sync; do not full-overwrite either DB.');
}
