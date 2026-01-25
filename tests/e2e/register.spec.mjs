import { test, expect } from '@playwright/test';

test('user can register and is redirected to login', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/register');

    const email = `e2e_${Date.now()}@example.com`;

    await page.fill('input[name="name"]', 'E2E User');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'secret123');
    await page.selectOption('select[name="role"]', 'donor');

    await Promise.all([
        page.waitForNavigation({ url: /\/login/ }),
        page.click('form button'),
    ]);

    expect(page.url()).toContain('/login');
});
