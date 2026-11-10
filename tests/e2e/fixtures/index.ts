import { test as base } from '@playwright/test';
import { CategoriesPage } from '../pages/CategoriesPage';
import { LoginPage } from '../pages/LoginPage';
import { ProductsPage } from '../pages/ProductsPage';

type Pages = {
    loginPage: LoginPage;
    categoriesPage: CategoriesPage;
    productsPage: ProductsPage;
    pageErrors: string[];
};

export const test = base.extend<Pages>({
    loginPage: async ({ page }, use) => {
        await use(new LoginPage(page));
    },
    categoriesPage: async ({ page }, use) => {
        await use(new CategoriesPage(page));
    },
    productsPage: async ({ page }, use) => {
        await use(new ProductsPage(page));
    },
    pageErrors: async ({ page }, use) => {
        const errors: string[] = [];
        page.on('pageerror', (error) => errors.push(error.message));
        await use(errors);
    },
});

export { expect } from '@playwright/test';
export { testUser } from './credentials';
