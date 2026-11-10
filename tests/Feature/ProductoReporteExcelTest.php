<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoReporteExcelTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_generate_products_excel_report(): void
    {
        $user = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Oficina',
            'descripcion' => 'Productos de uso diario',
            'estado' => true,
        ]);

        Producto::create([
            'nombre' => 'Impresora laser',
            'descripcion' => 'Equipo de alta velocidad',
            'precio' => 1850.50,
            'stock' => 6,
            'categoria_id' => $categoria->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('listaproductos.excel'));

        $response->assertOk();
        $response->assertDownload('reporte-productos.xlsx');
        $this->assertStringContainsString(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            (string) $response->headers->get('content-type')
        );
    }

    public function test_guest_is_redirected_when_trying_to_access_products_excel_report(): void
    {
        $response = $this->get(route('listaproductos.excel'));

        $response->assertRedirect(route('login'));
    }
}
