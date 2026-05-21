#!/usr/bin/env node
import { readFileSync } from 'node:fs';
import { basename, resolve } from 'node:path';

const root = process.cwd();
const siteUrl = (process.env.ROLLING_RENO_SITE_URL || 'https://rollingreno.com').replace(/\/$/, '');
const username = process.env.WP_USERNAME || process.env.WORDPRESS_USERNAME || process.env.ROLLING_RENO_WP_USERNAME;
const appPassword = process.env.WP_APP_PASSWORD || process.env.WORDPRESS_APP_PASSWORD || process.env.ROLLING_RENO_WP_APP_PASSWORD || process.env.WP_PASSWORD;
const dryRun = ['1', 'true', 'yes'].includes(String(process.env.DRY_RUN || '').toLowerCase());

if (!username || !appPassword) {
  console.error('Missing WordPress credentials. Set WP_USERNAME and WP_APP_PASSWORD (application password preferred).');
  process.exit(2);
}

const authHeader = `Basic ${Buffer.from(`${username}:${appPassword}`).toString('base64')}`;
const plan = JSON.parse(readFileSync('reports/rr103/update-plan.json', 'utf8'));

const contentAdditions = {
  291: `\n<h2>Quick cabinet zone check before you buy organizers</h2>\n<p>Before Mara adds a bin or hook, she checks how the galley actually moves during a normal day. Coffee gear, dish soap, towels, and the pan used most often stay in the first-reach zone. Backstock, picnic extras, and once-a-trip tools can live higher, deeper, or behind another item.</p>\n<p>Measure the cabinet opening, the usable interior depth, and any hinge or pipe that steals space. Then leave one small empty landing zone for the thing you are holding when the camper is moving, because a tiny kitchen gets frustrating fast when every inch is packed too perfectly.</p>\n`,
  289: `\n<h2>Make the demo mess prove something</h2>\n<p>A good camper demo day is not just about tearing material out. Mara treats each removed piece like evidence. If a panel is stained, swollen, rusty, or unexpectedly heavy, it goes into a pause pile long enough to check what caused the damage. That keeps hidden leaks, bad fasteners, and mystery wiring from getting buried under the excitement of a clean shell.</p>\n<p>End the day with a ten-minute reset: sweep the walking path, bag sharp debris, put reusable trim in one place, and photograph every open wall or floor area before it gets covered. Those photos become the map when you are trying to remember where a wire, brace, or wet corner lived two weekends later.</p>\n<h2>Safety gear that should stay visible</h2>\n<p>Keep gloves, eye protection, a dust mask or respirator, trash bags, a magnet, and a small first-aid kit where you can see them. If safety gear has to be dug out from under the project, it will not get used when the work gets annoying.</p>\n`,
  288: `\n<h2>Take photos before every label comes off</h2>\n<p>Mara’s safest electrical habit is boring and repeatable: photograph the wire path, label one thing at a time, then photograph it again. A phone picture is not a wiring diagram, but it is very good at answering the “wait, where did that blue wire go?” question after a cabinet, wall panel, or old fixture is out of the way.</p>\n<p>If you are not certain a circuit is disconnected, stop and verify before cutting, pulling, or capping anything. Labeling is a planning step, not permission to rush electrical work.</p>\n`,
  286: `\n<h2>Use a slow hose test, not a pressure blast</h2>\n<p>When Mara checks a suspicious roof seam, she does not blast it with a pressure nozzle. A hard stream can force water into places rain would not normally reach and make the test misleading. A slow hose test works better: start low, move upward in small sections, and give each area time to show itself inside.</p>\n<p>Have one person outside controlling water and one person inside with a flashlight. Check ceiling corners, cabinet backs, window frames, wall seams, and the floor line below the suspect area. Some leaks travel before they appear, so the wet spot inside may not be directly under the crack outside.</p>\n<h2>Know when to stop the remodel plan</h2>\n<p>If the inspection finds active moisture, soft decking, blackened wood, or a seam that has been leaking for a while, pause the pretty work. Paint, flooring, and wall panels can wait. Dry the area, find the path, repair the source, and retest before covering anything up. The cheapest time to fix a leak is before the new materials hide it.</p>\n<p>Keep a simple photo log with dates. One wide shot, one close-up, and one note about the weather will make the next inspection faster and less dramatic.</p>\n`,
};

async function wpJson(path, options = {}) {
  const res = await fetch(`${siteUrl}/wp-json/wp/v2${path}`, {
    ...options,
    headers: {
      Authorization: authHeader,
      'User-Agent': 'RollingRenoRR103Fix/1.0',
      ...(options.headers || {}),
    },
    signal: AbortSignal.timeout(30000),
  });
  const text = await res.text();
  let body;
  try { body = text ? JSON.parse(text) : {}; } catch { body = text; }
  if (!res.ok) throw new Error(`${options.method || 'GET'} ${path} failed: ${res.status} ${res.statusText} ${text.slice(0, 300)}`);
  return body;
}

async function uploadMedia(item) {
  const imagePath = resolve(root, item.image);
  const bytes = readFileSync(imagePath);
  const filename = basename(imagePath);
  if (dryRun) return { id: `dry-${filename}`, source_url: imagePath };
  const res = await fetch(`${siteUrl}/wp-json/wp/v2/media`, {
    method: 'POST',
    headers: {
      Authorization: authHeader,
      'User-Agent': 'RollingRenoRR103Fix/1.0',
      'Content-Disposition': `attachment; filename="${filename}"`,
      'Content-Type': 'image/jpeg',
    },
    body: bytes,
    signal: AbortSignal.timeout(60000),
  });
  const text = await res.text();
  let body;
  try { body = JSON.parse(text); } catch { body = text; }
  if (!res.ok) throw new Error(`media upload ${filename} failed: ${res.status} ${res.statusText} ${text.slice(0, 300)}`);
  await wpJson(`/media/${body.id}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ alt_text: item.alt, caption: '', description: item.alt }),
  });
  return body;
}

function contentWithAddition(postId, rendered) {
  const addition = contentAdditions[postId];
  if (!addition || rendered.includes(addition.trim().slice(0, 60))) return rendered;
  const finalThought = rendered.match(/<h2>Final thought[\s\S]*$/i);
  if (finalThought) return rendered.replace(finalThought[0], `${addition}\n${finalThought[0]}`);
  return `${rendered}\n${addition}`;
}

const results = [];
for (const item of plan.affectedPosts) {
  const post = dryRun
    ? await wpJson(`/posts/${item.id}`)
    : await wpJson(`/posts/${item.id}?context=edit`);
  const media = await uploadMedia(item);
  const nextContent = contentWithAddition(item.id, post.content?.raw || post.content?.rendered || '');
  const payload = { featured_media: media.id, content: nextContent };
  if (dryRun) {
    results.push({ post: item.id, dryRun: true, newMedia: media.id, alt: item.alt, oldWordsApprox: (post.content?.rendered || '').split(/\s+/).length, targetReadMinutes: item.targetReadMinutes });
  } else {
    const updated = await wpJson(`/posts/${item.id}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
    results.push({ post: item.id, link: updated.link, newMedia: media.id, mediaUrl: media.source_url, alt: item.alt, targetReadMinutes: item.targetReadMinutes });
  }
}

console.log(JSON.stringify({ siteUrl, dryRun, results }, null, 2));
