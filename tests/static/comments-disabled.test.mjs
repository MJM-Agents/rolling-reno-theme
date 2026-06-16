import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

const root = resolve(import.meta.dirname, '../..');
const singleTemplate = readFileSync(resolve(root, 'single.php'), 'utf8');
const functionsTemplate = readFileSync(resolve(root, 'functions.php'), 'utf8');
const postCardTemplates = [
  'front-page.php',
  'home.php',
  'page-start-here.php',
  'single.php',
].map((file) => [file, readFileSync(resolve(root, file), 'utf8')]);

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

assert(
  /function\s+rr_get_post_image_alt\s*\(/.test(functionsTemplate),
  'functions.php must provide rr_get_post_image_alt() for card image alt fallbacks.',
);

assert(
  /_wp_attachment_image_alt/.test(functionsTemplate) && /get_the_title\s*\(\s*\$post_id\s*\)/.test(functionsTemplate),
  'rr_get_post_image_alt() must prefer media alt text and fall back to the post title.',
);

for (const [file, template] of postCardTemplates) {
  assert(
    !/class="post-card__image"[\s\S]{0,220}alt=""/.test(template),
    `${file} must not render post-card images with an empty alt attribute.`,
  );
}
