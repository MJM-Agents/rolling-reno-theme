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
  'template-parts/content-card.php',
].map((file) => [file, readFileSync(resolve(root, file), 'utf8')]);
const homeTemplate = readFileSync(resolve(root, 'home.php'), 'utf8');
const mainScript = readFileSync(resolve(root, 'assets/js/main.js'), 'utf8');
const themeStyles = readFileSync(resolve(root, 'style.css'), 'utf8');
const contentCardTemplate = readFileSync(resolve(root, 'template-parts/content-card.php'), 'utf8');

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

assert(
  homeTemplate.includes('data-rr-infinite-grid') && homeTemplate.includes('data-rr-infinite-sentinel'),
  'home.php must expose the blog archive grid and sentinel for infinite scrolling.',
);

assert(
  /the_posts_pagination\s*\(/.test(homeTemplate),
  'home.php must keep server-side pagination as the no-JS/crawlable fallback.',
);

assert(
  functionsTemplate.includes('check_ajax_referer( \'rr_blog_infinite_scroll\', \'nonce\' )'),
  'blog infinite-scroll AJAX must verify its nonce.',
);

assert(
  functionsTemplate.includes('\'post_status\'   => \'publish\''),
  'blog infinite-scroll AJAX must only query published posts.',
);

assert(
  mainScript.includes('const loadedPostIds = new Set()') && mainScript.includes('loadedPostIds.has(postId)'),
  'blog infinite-scroll JS must guard against duplicate appended posts.',
);

assert(
  mainScript.includes('complete = !json.data.hasMore || currentPage >= maxPage'),
  'blog infinite-scroll JS must stop requesting after the final page.',
);

assert(
  themeStyles.includes('.rr-infinite-scroll-ready .blog-index .navigation.pagination') &&
    /display:\s*none\s*!important/.test(themeStyles),
  'enhanced blog archive CSS must force-hide fallback pagination only after JS initializes.',
);

assert(
  mainScript.includes("fallbackPagination.style.display = 'none'"),
  'blog infinite-scroll JS must inline-hide fallback pagination after enhancement initializes.',
);

assert(
  contentCardTemplate.includes('data-post-id="<?php the_ID(); ?>"'),
  'shared blog card template must expose post IDs for duplicate prevention.',
);

assert(
  !/alt=["']{2}/.test(contentCardTemplate) &&
    contentCardTemplate.includes('rr_get_post_image_alt( get_the_ID() )') &&
    contentCardTemplate.includes('esc_attr( $thumb_alt )'),
  'shared blog card images must use rr_get_post_image_alt() with escaped alt text.',
);
