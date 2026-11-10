<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_busqueda_filtra_por_nombre_descripcion_y_categoria(): void
    {
        $user = User::factory()->create();

        $categoriaMonitores = Categoria::create([
            'nombre' => 'Monitores',
            'descripcion' => 'Pantallas',
            'estado' => true,
        ]);

        $categoriaPerifericos = Categoria::create([
            'nombre' => 'Perifericos',
            'descripcion' => 'Accesorios',
            'estado' => true,
        ]);

        Producto::create([
            'nombre' => 'Monitor Gamer',
            'descripcion' => 'Pantalla de alta frecuencia',
            'precio' => 1500,
            'stock' => 3,
            'categoria_id' => $categoriaMonitores->id,
        ]);

        Producto::create([
            'nombre' => 'Teclado Mecanico',
            'descripcion' => 'Switch azul para oficina',
            'precio' => 320,
            'stock' => 8,
            'categoria_id' => $categoriaPerifericos->id,
        ]);

        $respuestaNombre = $this->actingAs($user)->get(route('listaproductos.index', ['buscar' => 'Monitor']));
        $respuestaNombre->assertOk();
        $respuestaNombre->assertSee('Monitor Gamer');
        $respuestaNombre->assertDontSee('Teclado Mecanico');
        $respuestaNombre->assertSee('Filtro: Monitor');

        $respuestaCategoria = $this->actingAs($user)->get(route('listaproductos.index', ['buscar' => 'Perifericos']));
        $respuestaCategoria->assertOk();
        $respuestaCategoria->assertSee('Teclado Mecanico');
        $respuestaCategoria->assertDontSee('Monitor Gamer');
        $respuestaCategoria->assertSee('Filtro: Perifericos');
    }
}
