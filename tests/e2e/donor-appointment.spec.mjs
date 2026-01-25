import { test, expect } from '@playwright/test';
import fs from 'fs';

test('donor can book an appointment', async ({ page }) => {
    // start tracing to capture network/DOM/screenshots for debugging
    await page.context().tracing.start({ screenshots: true, snapshots: true });
    const tracePath = `test-results/trace-donor-appointment-${Date.now()}.zip`;
    await page.goto('http://127.0.0.1:8000/register');
    const email = `e2e_app_${Date.now()}@example.com`;
    await page.fill('input[name="name"]', 'Appointment Tester');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'secret123');
    await page.selectOption('select[name="role"]', 'donor');
    await Promise.all([
        page.waitForNavigation({ url: /\/login/ }),
        page.click('button[type="submit"]'),
    ]);

    // login
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', 'secret123');
    await page.click('form[action="/login"] button');
    await page.waitForSelector('text=Donor Dashboard', { timeout: 60000 });

    // navigate to appointment from dashboard link
    await page.click('text=Book Appointment');
    await page.waitForURL('**/donor/appointment', { timeout: 60000 });
    await page.fill('input[name="donor_name"]', 'Appointment Tester');
    await page.fill('input[name="blood_group"]', 'O-');
    await page.fill('input[name="date"]', new Date(Date.now() + 3 * 24 * 3600 * 1000).toISOString().slice(0, 10));
    await page.fill('input[name="time"]', '10:00');
    try {
        await Promise.all([
            page.waitForNavigation({ url: /\/donor\/appointment/ }),
            page.click('form[action="/donor/appointment"] button'),
        ]);
        // debug: save HTML snapshot immediately after submit
        const html = await page.content();
        const out = `test-results/e2e-debug-appointment-${Date.now()}.html`;
        fs.writeFileSync(out, html);
        // check for success flash
        await page.waitForSelector('[data-test="flash-success"]', { timeout: 60000 });
        const flash = await page.locator('[data-test="flash-success"]').textContent();
        expect(flash).toContain('Appointment booked');
    } finally {
        await page.context().tracing.stop({ path: tracePath });
    }
});
