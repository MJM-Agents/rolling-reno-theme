import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

const root = resolve(import.meta.dirname, '../..');
const singleTemplate = readFileSync(resolve(root, 'single.php'), 'utf8');
const functionsTemplate = readFileSync(resolve(root, 'functions.php'), 'utf8');

assert(
  !/\bcomments_template\s*\(/.test(singleTemplate),
  'single.php must not render the WordPress comments template on public posts.',
);

assert(
  !/wp_enqueue_script\s*\(\s*['"]comment-reply['"]/.test(functionsTemplate),
  'functions.php must not enqueue the WordPress comment-reply script.',
);

assert(
  /wp_dequeue_script\s*\(\s*['"]comment-reply['"]/.test(functionsTemplate),
  'functions.php must actively dequeue comment-reply for public single posts.',
);

for (const marker of ['Leave a Reply', 'Post Comment', 'commentform']) {
  assert(
    !singleTemplate.includes(marker),
    `single.php must not contain public comment form marker: ${marker}`,
  );
}
