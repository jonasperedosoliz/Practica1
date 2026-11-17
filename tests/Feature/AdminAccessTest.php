<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_categories(): void
    {
        $this->get(route('listacategorias.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_from_products(): void
    {
        $this->get(route('listaproductos.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_from_reports(): void
    {
        $this->get(route('listacategorias.pdf'))->assertRedirect(route('login'));
        $this->get(route('listacategorias.excel'))->assertRedirect(route('login'));
        $this->get(route('listaproductos.pdf'))->assertRedirect(route('login'));
        $this->get(route('listaproductos.excel'))->assertRedirect(route('login'));
    }

    public function test_administrator_can_use_current_admin_features(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
        ]);

        $categoria = Categoria::create([
            'nombre' => 'General',
            'descripcion' => 'Categoria base',
            'estado' => true,
        ]);

        Producto::create([
            'nombre' => 'Producto demo',
            'descripcion' => 'Para acceso admin',
            'precio' => 10,
            'stock' => 5,
            'categoria_id' => $categoria->id,
        ]);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('listacategorias.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('listaproductos.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('listacategorias.pdf'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->actingAs($admin)
            ->get(route('listaproductos.pdf'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->actingAs($admin)
            ->get(route('listacategorias.excel'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('listaproductos.excel'))
            ->assertOk();
    }
}
