// @ts-check
import { test, expect } from '@playwright/test';

test('menu', async ({ page }) => {
  await page.goto(process.env.BASE_URL);
  await expect(page.locator('#menu')).toContainText('Blog');
  await expect(page.locator('#menu')).toContainText('About');
  await expect(page.locator('#menu')).toContainText('Privacy');
});

test('index view', async ({ page }) => {
  await page.goto(process.env.BASE_URL);
  await expect(page).toHaveTitle(/Tomas Norre's Blog/);
  await expect(page.locator('#menu')).toContainText('Privacy');
  await expect(page.getByRole('main')).toContainText('Disable touchscreen on Wayland');
});

test('single view', async ({ page }) => {
  await page.goto(process.env.BASE_URL);
  await page.getByRole('main').getByText('Disable touchscreen on Wayland').click();
  await expect(page.getByRole('main')).toContainText('Disable touchscreen on Wayland');
  await expect(page.getByRole('main')).toContainText('April 25, 2025');
  await expect(page.getByRole('main')).toContainText('linux');
  await expect(page.getByRole('main')).toContainText('If you find any typos or incorrect information, please reach out on GitHub so that we can have the mistake corrected.');

});

test('social media icons', async ({ page }) => {
  await page.goto(process.env.BASE_URL);

  await expect(page.locator('#footer-links > a:nth-child(1)')).toBeVisible();
  await expect(page.locator('#footer-links > a:nth-child(2)')).toBeVisible();
  await expect(page.locator('#footer-links > a:nth-child(3)')).toBeVisible();
});

test('about', async ({ page }) => {
  await page.goto(process.env.BASE_URL + '/about');
  await expect(page).toHaveTitle(/About | /);
});

test('privacy', async ({ page }) => {
  await page.goto(process.env.BASE_URL + '/privacy');
  await expect(page).toHaveTitle(/Privacy | /);
});

test('search', async ({ page }) => {
  await page.goto(process.env.BASE_URL + '/about');
  await expect(page.getByRole('textbox', { name: 'Search' })).toBeVisible();
  await page.getByRole('textbox', { name: 'Search' }).click();
  await page.getByRole('textbox', { name: 'Search' }).fill('wayland ');
  const resultContainer = page.locator('#search-result');
  await expect(resultContainer).toBeVisible();
  // Wait briefly in case of debounce or animation
  await page.waitForTimeout(300); // adjust this based on actual app behavior
  await expect(page.getByRole('link', { name: 'Disable touchscreen on Wayland' })).toBeVisible();

});
