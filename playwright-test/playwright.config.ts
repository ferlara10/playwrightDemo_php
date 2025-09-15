import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  use: {
    headless: true,   // browser visible
    baseURL: 'http://localhost:3000', // optional
  },
  testDir: 'test',   // only look here for tests
  testMatch: ['**/*.spec.ts'],  // pick only TS files
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    }
  ],
  // 👇 put slowMo in launch options
  workers: 1,
  reporter: [
    ['list'],                     // console output
    ['junit', { outputFile: 'results/results.xml' }],   // CI-friendly XML
    ['html', { open: 'never' }]   // HTML report (won't open automatically)
  ],
  timeout: 30000,
  // Playwright does not take slowMo here directly
  // Instead, configure it in launch options:
  // Example: pass via CLI (see below)
});
