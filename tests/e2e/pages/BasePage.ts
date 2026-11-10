import { expect, type Locator, type Page, type Response } from '@playwright/test';

export type BasePageConfig = {
    path: string;
    sidebarLabel?: RegExp;
    searchPlaceholder?: string;
};

const escapeRegExp = (value: string) => value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

export abstract class BasePage {
    readonly page: Page;
    readonly alert: Locator;
    readonly table: Locator;

    protected readonly path: string;
    protected readonly urlPattern: RegExp;
    private readonly sidebarLabel?: RegExp;
    private readonly searchPlaceholder?: string;

    protected constructor(page: Page, config: BasePageConfig) {
        this.page = page;
        this.path = config.path;
        this.urlPattern = new RegExp(`${escapeRegExp(config.path)}(\\?.*)?$`);
        this.sidebarLabel = config.sidebarLabel;
        this.searchPlaceholder = config.searchPlaceholder;

        this.alert = page.getByRole('alert');
        this.table = page.getByRole('table');
    }

    get sidebarLink(): Locator {
        if (!this.sidebarLabel) {
            throw new Error(`${this.constructor.name} no tiene enlace en el menú lateral.`);
        }
        return this.page
            .getByRole('complementary')
            .getByRole('navigation')
            .getByRole('link', { name: this.sidebarLabel });
    }

    get searchInput(): Locator {
        if (!this.searchPlaceholder) {
            throw new Error(`${this.constructor.name} no tiene buscador.`);
        }
        return this.page.getByPlaceholder(this.searchPlaceholder);
    }

    get searchButton(): Locator {
        return this.page.getByRole('button', { name: 'Buscar' });
    }

    async goto(): Promise<Response | null> {
        const response = await this.page.goto(this.path);
        await this.page.waitForLoadState('domcontentloaded');
        return response;
    }

    async gotoFromSidebar(): Promise<Response> {
        const response = await this.waitForNavigation(() => this.sidebarLink.click());
        await expect(this.page).toHaveURL(this.urlPattern);
        return response;
    }

    async search(term: string): Promise<Locator> {
        await this.searchInput.fill(term);
        await this.waitForNavigation(() => this.searchButton.click());
        await expect(this.page).toHaveURL(/[?&]buscar=/);
        return this.rowByName(term);
    }

    dataRows(): Locator {
        return this.table.locator('tbody').getByRole('row');
    }

    rowByName(text: string): Locator {
        return this.dataRows().filter({
            has: this.page.getByText(text, { exact: true }),
        });
    }

    async deleteItem(name: string, successMessage: string | RegExp) {
        const row = await this.search(name);
        await expect(row).toHaveCount(1);

        this.page.once('dialog', (dialog) => dialog.accept());
        await this.waitForNavigation(() => row.getByRole('button', { name: 'Eliminar' }).click());
        await this.expectSuccessAlert(successMessage);
    }

    async expectSuccessAlert(message: string | RegExp) {
        await expect(this.alert).toBeVisible();
        await expect(this.alert).toContainText(message);
    }

    protected async waitForNavigation(action: () => Promise<void>): Promise<Response> {
        const [response] = await Promise.all([
            this.page.waitForResponse(
                (res) =>
                    res.request().isNavigationRequest() &&
                    res.request().frame() === this.page.mainFrame() &&
                    (res.status() < 300 || res.status() >= 400),
            ),
            action(),
        ]);
        await this.page.waitForLoadState('domcontentloaded');
        return response;
    }
}
