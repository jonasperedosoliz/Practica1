<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoReportePdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_generate_products_pdf_report(): void
    {
        $user = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Lacteos',
            'descripcion' => 'Productos refrigerados',
            'estado' => true,
        ]);

        Producto::create([
            'nombre' => 'Yogurt',
            'descripcion' => 'Envase de 1 litro',
            'precio' => 12.50,
            'stock' => 8,
            'categoria_id' => $categoria->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('listaproductos.pdf'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertSee('%PDF', false);
    }

    public function test_guest_is_redirected_when_trying_to_access_products_pdf_report(): void
    {
        $response = $this->get(route('listaproductos.pdf'));

        $response->assertRedirect(route('login'));
    }
}
