import { defineConfig, devices } from '@playwright/test';

const BASE_URL = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

// Modo evidencia: graba video, screenshot y trace de TODAS las pruebas (también las exitosas).
const EVIDENCE_MODE =
    process.env.E2E_EVIDENCE === '1' || process.env.npm_lifecycle_event === 'test:e2e:demo';

export default defineConfig({
    testDir: './tests/e2e',
    testMatch: '**/*.spec.ts',
    outputDir: './tests/e2e/.results',
    globalSetup: './tests/e2e/global-setup.ts',

    // Las pruebas comparten la base de datos de Laravel: se ejecutan en serie.
    fullyParallel: false,
    workers: 1,

    forbidOnly: !!process.env.CI,
    retries: process.env.CI ? 2 : EVIDENCE_MODE ? 0 : 1,
    timeout: EVIDENCE_MODE ? 120_000 : 60_000,
    expect: {
        timeout: 7_000,
    },

    reporter: [
        ['list'],
        ['html', { outputFolder: 'playwright-report', open: 'never' }],
    ],

    use: {
        baseURL: BASE_URL,
        trace: EVIDENCE_MODE ? 'on' : 'on-first-retry',
        screenshot: EVIDENCE_MODE ? { mode: 'on', fullPage: true } : 'only-on-failure',
        video: {
            mode: EVIDENCE_MODE ? 'on' : 'retain-on-failure',
            size: { width: 1280, height: 720 },
        },
        viewport: { width: 1280, height: 720 },
        actionTimeout: 10_000,
        navigationTimeout: 15_000,
        locale: 'es-ES',
        launchOptions: {
            slowMo: EVIDENCE_MODE ? 250 : 0,
        },
    },

    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'], viewport: { width: 1280, height: 720 } },
        },
    ],

    webServer: {
        command: 'php artisan serve --host=127.0.0.1 --port=8000',
        url: BASE_URL,
        reuseExistingServer: !process.env.CI,
        timeout: 120_000,
        stdout: 'ignore',
        stderr: 'pipe',
    },
});
