import { test, expect } from '@playwright/test';

test('user can register then login and reach dashboard', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/register');
    const email = `e2e_login_${Date.now()}@example.com`;
    await page.fill('input[name="name"]', 'Login Tester');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'secret123');
    await page.selectOption('select[name="role"]', 'donor');
    await Promise.all([
        page.waitForNavigation({ url: /\/login/ }),
        page.click('button[type="submit"]'),
    ]);

    // now login
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'secret123');
    await page.click('form button');
    await page.waitForSelector('text=Donor Dashboard', { timeout: 60000 });
    expect(await page.url()).toContain('/donor/dashboard');
});
