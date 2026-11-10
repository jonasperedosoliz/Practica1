import { expect, type Locator, type Page } from '@playwright/test';
import { BasePage } from './BasePage';

export type ProductData = {
    nombre: string;
    descripcion?: string;
    precio: number;
    stock: number;
    categoria: string;
    imagen?: string;
};

export class ProductsPage extends BasePage {
    readonly heading: Locator;
    readonly catalogTitle: Locator;
    readonly newProductLink: Locator;
    readonly pdfReportLink: Locator;
    readonly excelReportLink: Locator;

    readonly createHeading: Locator;
    readonly nameInput: Locator;
    readonly descriptionInput: Locator;
    readonly priceInput: Locator;
    readonly stockInput: Locator;
    readonly categorySelect: Locator;
    readonly imageInput: Locator;
    readonly submitButton: Locator;
    readonly cancelLink: Locator;

    static readonly columns = ['#', 'Producto', 'Descripcion', 'Precio', 'Stock', 'Categoria', 'Acciones'];

    constructor(page: Page) {
        super(page, {
            path: '/listaproductos',
            sidebarLabel: /Productos/,
            searchPlaceholder: 'Buscar producto o categoria',
        });

        this.heading = page.getByRole('heading', { level: 2, name: 'Productos', exact: true });
        this.catalogTitle = page.getByText('Catalogo de productos');
        this.newProductLink = page.getByRole('link', { name: 'Nuevo producto' });
        this.pdfReportLink = page.getByRole('link', { name: 'Reporte PDF' });
        this.excelReportLink = page.getByRole('link', { name: 'Reporte Excel' });

        this.createHeading = page.getByRole('heading', { level: 2, name: 'Nuevo producto' });
        this.nameInput = page.getByLabel('Nombre');
        this.descriptionInput = page.getByLabel('Descripción');
        this.priceInput = page.getByLabel('Precio');
        this.stockInput = page.getByLabel('Stock');
        this.categorySelect = page.getByLabel('Categoría');
        this.imageInput = page.getByLabel('Imagen del producto');
        this.submitButton = page.getByRole('button', { name: 'Registrar' });
        this.cancelLink = page.getByRole('link', { name: 'Cancelar' });
    }

    static formatPrice(precio: number): string {
        const formatted = precio.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
        return `${formatted} Bs`;
    }

    async verifyPageLoaded() {
        await expect(this.page).toHaveURL(this.urlPattern);
        await expect(this.page).toHaveTitle('Lista de productos');
        await expect(this.heading).toBeVisible();
        await expect(this.catalogTitle).toBeVisible();
        await expect(this.table).toBeVisible();
        await expect(this.table.getByRole('columnheader')).toHaveText(ProductsPage.columns);
        await expect(this.newProductLink).toBeVisible();
        await expect(this.sidebarLink).toHaveClass(/\bactive\b/);
    }

    async openCreateForm() {
        await this.newProductLink.click();
        await this.page.waitForURL(/\/listaproductos\/create$/);
        await expect(this.createHeading).toBeVisible();
    }

    async fillProductForm({ nombre, descripcion, precio, stock, categoria, imagen }: ProductData) {
        await this.nameInput.fill(nombre);
        if (descripcion !== undefined) {
            await this.descriptionInput.fill(descripcion);
        }
        await this.priceInput.fill(precio.toString());
        await this.stockInput.fill(stock.toString());
        await this.categorySelect.selectOption({ label: categoria });
        if (imagen) {
            await this.imageInput.setInputFiles(imagen);
        }
    }

    async submitProductForm(): Promise<string> {
        await this.waitForNavigation(() => this.submitButton.click());
        await expect(this.page).toHaveURL(this.urlPattern);
        await expect(this.alert).toBeVisible();
        return (await this.alert.innerText()).trim();
    }

    async createProduct(data: ProductData): Promise<string> {
        await this.openCreateForm();
        await this.fillProductForm(data);
        return this.submitProductForm();
    }

    async searchProduct(nombre: string): Promise<Locator> {
        return this.search(nombre);
    }

    async expectProductInTable({ nombre, descripcion, precio, stock, categoria }: ProductData) {
        const row = await this.searchProduct(nombre);
        await expect(row).toHaveCount(1);

        const cells = row.getByRole('cell');
        await expect(cells.nth(1)).toContainText(nombre);
        await expect(cells.nth(2)).toHaveText(descripcion ?? '-');
        await expect(cells.nth(3)).toHaveText(ProductsPage.formatPrice(precio));
        await expect(cells.nth(4)).toHaveText(stock.toString());
        await expect(cells.nth(5)).toHaveText(categoria);
    }

    async deleteProduct(nombre: string) {
        await this.deleteItem(nombre, 'Producto eliminado exitosamente.');
    }
}
