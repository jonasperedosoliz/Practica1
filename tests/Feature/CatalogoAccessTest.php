<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_catalog(): void
    {
        $this->get(route('catalogo'))->assertRedirect(route('login'));
    }

    public function test_registered_user_can_view_catalog(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $categoria = Categoria::create([
            'nombre' => 'General',
            'descripcion' => 'Base',
            'estado' => true,
        ]);

        Producto::create([
            'nombre' => 'Producto visible',
            'descripcion' => 'Para catálogo',
            'precio' => 25,
            'stock' => 4,
            'categoria_id' => $categoria->id,
        ]);

        $this->actingAs($user)
            ->get(route('catalogo'))
            ->assertOk()
            ->assertSee('Producto visible');
    }

    public function test_welcome_shows_catalog_preview(): void
    {
        $categoria = Categoria::create([
            'nombre' => 'General',
            'descripcion' => 'Base',
            'estado' => true,
        ]);

        Producto::create([
            'nombre' => 'Producto welcome',
            'descripcion' => 'Preview',
            'precio' => 10,
            'stock' => 2,
            'categoria_id' => $categoria->id,
        ]);

        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('Producto welcome')
            ->assertSee('Registrarse para ver');
    }
}
