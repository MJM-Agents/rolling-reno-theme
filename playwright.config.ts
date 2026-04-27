import { defineConfig, devices } from '@playwright/test';

const baseURL = process.env.ROLLING_RENO_BASE_URL || 'https://rollingreno.flywheelstaging.com';
const httpCredentials = process.env.STAGING_PRIVACY_USER && process.env.STAGING_PRIVACY_PASS
  ? { username: process.env.STAGING_PRIVACY_USER, password: process.env.STAGING_PRIVACY_PASS }
  : { username: 'rollingreno', password: 'Privy123' };

export default defineConfig({
  testDir: './tests/e2e',
  timeout: 45_000,
  expect: { timeout: 8_000 },
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 1 : 0,
  reporter: process.env.CI ? [['github'], ['html', { open: 'never' }], ['list']] : [['list']],
  use: {
    baseURL,
    httpCredentials,
    trace: 'retain-on-failure',
    screenshot: 'only-on-failure',
  },
  projects: [
    {
      name: 'desktop-chromium',
      use: { ...devices['Desktop Chrome'], viewport: { width: 1280, height: 900 } },
    },
    {
      name: 'mobile-chromium',
      use: { ...devices['Pixel 5'], viewport: { width: 390, height: 844 } },
    },
  ],
});
