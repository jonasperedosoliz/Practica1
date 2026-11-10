import { expect, type Locator, type Page } from '@playwright/test';
import { BasePage } from './BasePage';

export class LoginPage extends BasePage {
    readonly heading: Locator;
    readonly emailInput: Locator;
    readonly passwordInput: Locator;
    readonly rememberCheckbox: Locator;
    readonly submitButton: Locator;

    constructor(page: Page) {
        super(page, { path: '/login' });

        this.heading = page.getByRole('heading', { name: 'Iniciar sesión' });
        this.emailInput = page.getByLabel('Correo electrónico');
        this.passwordInput = page.getByLabel('Contraseña');
        this.rememberCheckbox = page.getByLabel('Recordarme');
        this.submitButton = page.getByRole('button', { name: 'Entrar' });
    }

    async expectLoaded() {
        await expect(this.heading).toBeVisible();
        await expect(this.emailInput).toBeVisible();
        await expect(this.passwordInput).toBeVisible();
        await expect(this.submitButton).toBeEnabled();
    }

    async login(email: string, password: string) {
        await this.emailInput.fill(email);
        await this.passwordInput.fill(password);
        await this.submitButton.click();
    }

    async loginAndWaitForDashboard(email: string, password: string) {
        await this.goto();
        await this.login(email, password);
        await this.page.waitForURL(/\/dashboard$/);
    }
}
