# Pruebas E2E con Playwright

Suite de pruebas end-to-end (de extremo a extremo) para el sistema **AppWeb-GestionProductos** (Laravel + Blade + Alpine.js).
Las pruebas abren un navegador Chromium real y recorren la aplicación como lo haría un usuario.

## Cobertura

| Archivo | Qué valida |
| --- | --- |
| `specs/smoke.spec.ts` | La aplicación responde, el login carga y las rutas protegidas exigen sesión. |
| `specs/categories.spec.ts` | Navegación desde el menú lateral, carga de la tabla sin errores y alta/baja de una categoría. |
| `specs/products.spec.ts` | Navegación y tabla de inventario, y flujo completo: categoría temporal, alta del producto, verificación de datos y limpieza. |

## Estructura

```
tests/e2e/
├── global-setup.ts      # Crea el usuario de prueba antes de ejecutar la suite
├── fixtures/            # Fixtures de Playwright y credenciales de prueba
├── pages/               # Page Object Models
│   ├── BasePage.ts      # Clase base: menú lateral, buscador, borrado con confirmación, alertas
│   ├── LoginPage.ts
│   ├── CategoriesPage.ts
│   └── ProductsPage.ts
└── specs/               # Casos de prueba (*.spec.ts)
```

Las pruebas usan el patrón **Page Object Model**: los selectores y acciones de cada pantalla viven en `pages/`,
y los specs solo describen el comportamiento esperado. La lógica común está centralizada en `BasePage`.

## 1. Requisitos e instalación

Requisitos previos: PHP y Composer, Node.js 18+, MySQL en ejecución (por ejemplo con Laragon) y el archivo `.env` configurado.

```powershell
composer install
npm install
php artisan migrate
npm run build
npx playwright install chromium
```

- `npm install` instala `@playwright/test`, que ya está declarado en `package.json`.
- `npx playwright install chromium` descarga el navegador que usan las pruebas (solo la primera vez).

No hace falta crear un usuario manualmente: antes de cada ejecución, `global-setup.ts` corre
`php artisan db:seed --class=E2EUserSeeder`, que crea o actualiza el usuario de prueba:

- Correo: `qa.e2e@example.com`
- Contraseña: `Password123!`

Se pueden cambiar con las variables de entorno `E2E_USER_EMAIL` y `E2E_USER_PASSWORD`.

Tampoco hace falta iniciar el servidor: Playwright ejecuta `php artisan serve` automáticamente
en `http://127.0.0.1:8000` si no está encendido (y lo reutiliza si ya lo está).

## 2. Ejecutar las pruebas

| Modo | Comando | Para qué sirve |
| --- | --- | --- |
| Normal | `npm run test:e2e` | Ejecuta toda la suite sin abrir ventanas (rápido). |
| Visual | `npm run test:e2e:headed` | Muestra el navegador mientras se ejecutan las pruebas. |
| Interactivo | `npm run test:e2e:ui` | Abre la interfaz de Playwright: elegir pruebas, verlas paso a paso y viajar en el tiempo por cada acción. |
| Demostración | `npm run test:e2e:demo` | Navegador visible, acciones ralentizadas y evidencia (video, captura y trace) de **todas** las pruebas. |

Ejecutar un solo archivo o una sola prueba:

```powershell
npx playwright test tests/e2e/specs/products.spec.ts
npx playwright test -g "registra un producto"
```

Las pruebas se ejecutan en serie (un solo worker) porque comparten la base de datos de Laravel.
Los datos que crean llevan el prefijo `E2E` y una marca de tiempo, y se eliminan al terminar.

## 3. Ver el reporte HTML

Después de cualquier ejecución:

```powershell
npm run test:e2e:report
```

Se abre el reporte interactivo en el navegador. En él se puede:

- Ver cada prueba con su resultado, duración y pasos (`test.step`).
- Reproducir el **video** de la ejecución.
- Ver las **capturas de pantalla**.
- Abrir el **trace**: línea de tiempo con el DOM, la red y la consola en cada acción.

En una ejecución normal, la evidencia se guarda solo cuando una prueba falla.
Con `npm run test:e2e:demo` se guarda para todas, lo que resulta ideal para una presentación.

Ubicación de los archivos generados (ignorados por git):

- `playwright-report/`: reporte HTML.
- `tests/e2e/.results/`: videos, capturas y traces de cada prueba.
