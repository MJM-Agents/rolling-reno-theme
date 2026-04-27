import { expect, type Locator, test } from '@playwright/test';

async function viewportMetrics(page) {
  return page.evaluate(() => ({
    scrollWidth: document.documentElement.scrollWidth,
    clientWidth: document.documentElement.clientWidth,
    bodyScrollWidth: document.body.scrollWidth,
    bodyClientWidth: document.body.clientWidth,
    viewportWidth: window.innerWidth,
  }));
}

async function expectNoHorizontalOverflow(page) {
  const metrics = await viewportMetrics(page);
  expect(metrics.scrollWidth, JSON.stringify(metrics)).toBeLessThanOrEqual(metrics.clientWidth);
  expect(metrics.bodyScrollWidth, JSON.stringify(metrics)).toBeLessThanOrEqual(metrics.bodyClientWidth + 1);
}

async function expectInsideViewport(locator: Locator, viewportWidth: number, label: string) {
  await expect(locator, label).toBeVisible();
  const box = await locator.boundingBox();
  expect(box, `${label} bounding box`).not.toBeNull();
  expect(box!.x, `${label} left edge`).toBeGreaterThanOrEqual(-1);
  expect(box!.x + box!.width, `${label} right edge`).toBeLessThanOrEqual(viewportWidth + 1);
}

test.describe('Rolling Reno regression guardrails', () => {
  test('mobile homepage loads closed, with no blank search/menu band and unclipped hero', async ({ page, isMobile }) => {
    test.skip(!isMobile, 'mobile-only regression from iOS screenshot');

    await page.goto('/');
    await expect(page.locator('#site-search')).toHaveAttribute('aria-hidden', 'true');
    await expect(page.locator('#mobile-menu')).toHaveAttribute('aria-hidden', 'true');
    await expect(page.locator('.site-nav__hamburger')).toHaveAttribute('aria-expanded', 'false');
    await expect(page.locator('.site-nav__search-btn').first()).toHaveAttribute('aria-expanded', 'false');
    await expectNoHorizontalOverflow(page);

    const hero = page.locator('.hero').first();
    const heroContent = page.locator('.hero__content').first();
    const heroTitle = page.locator('.hero__title').first();
    await expectInsideViewport(heroContent, 390, 'mobile hero content card');
    await expectInsideViewport(heroTitle, 390, 'mobile hero title');

    const navBox = await page.locator('#site-nav').boundingBox();
    const heroBox = await hero.boundingBox();
    expect(navBox).not.toBeNull();
    expect(heroBox).not.toBeNull();
    const gap = heroBox!.y - (navBox!.y + navBox!.height);
    expect(gap, 'no unexplained blank band between header and hero').toBeLessThanOrEqual(8);
  });

  test('mobile search opens with a visible input and closes without leaving a blank band', async ({ page, isMobile }) => {
    test.skip(!isMobile, 'mobile-only search regression');

    await page.goto('/');
    await page.locator('.site-nav__search-btn').first().click();
    await expect(page.locator('#site-search')).toHaveAttribute('aria-hidden', 'false');
    await expect(page.locator('#site-search-input')).toBeVisible();
    await expect(page.locator('.site-search__submit')).toBeVisible();
    await expect(page.locator('.site-search__close')).toBeVisible();
    await expectNoHorizontalOverflow(page);

    await page.locator('.site-search__close').click();
    await expect(page.locator('#site-search')).toHaveAttribute('aria-hidden', 'true');
    await expect(page.locator('.site-nav__search-btn').first()).toHaveAttribute('aria-expanded', 'false');
    await expectNoHorizontalOverflow(page);
  });

  test('mobile nav drawer opens as a full usable drawer and closes via Escape/link', async ({ page, isMobile }) => {
    test.skip(!isMobile, 'mobile-only nav regression');

    await page.goto('/blog/');
    await page.locator('.site-nav__hamburger').click();
    await expect(page.locator('#mobile-menu')).toHaveAttribute('aria-hidden', 'false');
    await expect(page.locator('#mobile-menu a')).toHaveCount(14);
    const box = await page.locator('#mobile-menu').boundingBox();
    expect(box).not.toBeNull();
    expect(box!.width).toBeGreaterThanOrEqual(389);
    expect(box!.height).toBeGreaterThan(600);
    await expectNoHorizontalOverflow(page);

    await page.keyboard.press('Escape');
    await expect(page.locator('#mobile-menu')).toHaveAttribute('aria-hidden', 'true');

    await page.locator('.site-nav__hamburger').click();
    await page.locator('#mobile-menu a', { hasText: 'Start Here' }).first().click();
    await expect(page).toHaveURL(/\/start-here\/?/);
    await expect(page.locator('#mobile-menu')).toHaveAttribute('aria-hidden', 'true');
  });

  test('desktop blog hover does not expose the retired submenu', async ({ page, isMobile }) => {
    test.skip(isMobile, 'desktop-only submenu regression');

    await page.goto('/blog/');
    await page.locator('.site-nav__link', { hasText: 'Blog' }).hover();
    await page.waitForTimeout(150);
    await expect(page.locator('.site-nav__submenu')).toHaveCount(0);
    await expectNoHorizontalOverflow(page);
  });

  test('blog search/filter UI remains usable and shareable', async ({ page }) => {
    await page.goto('/blog/');
    await expect(page.locator('.blog-discovery')).toBeVisible();
    await expect(page.locator('.category-filter')).toHaveCount(7);
    await page.locator('#blog-search-input').fill('solar');
    await page.locator('.blog-search button[type="submit"], .blog-search button').click();
    await expect(page).toHaveURL(/\/blog\/\?s=solar/);
    await page.waitForLoadState('networkidle');
    await expect(page.locator('.blog-results-count')).toContainText(/article/);
    await expectNoHorizontalOverflow(page);
  });

  test('gear page keeps affiliate CTAs and never shows placeholders', async ({ page }) => {
    await page.goto('/gear/');
    await expect(page.locator('body')).not.toContainText('Product link coming soon');
    const amazonLinks = page.locator('a[href*="amazon.com"][href*="tag=rollingreno-20"]');
    await expect(amazonLinks.first()).toBeVisible();
    expect(await amazonLinks.count()).toBeGreaterThanOrEqual(12);
    await expectNoHorizontalOverflow(page);
  });

  test('core public pages render without 404 signals or overflow', async ({ page }) => {
    for (const path of ['/', '/blog/', '/start-here/', '/gear/', '/full-time-rv-insurance/']) {
      await page.goto(path);
      await expect(page.locator('body')).not.toContainText('Page not found');
      await expect(page.locator('body')).not.toContainText('Nothing found');
      await expectNoHorizontalOverflow(page);
    }
  });
});
