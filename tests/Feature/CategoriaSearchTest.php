<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_search_filters_by_name_description_and_status(): void
    {
        $user = User::factory()->create();

        Categoria::create([
            'nombre' => 'Monitores',
            'descripcion' => 'Pantallas de alta frecuencia',
            'estado' => true,
        ]);

        Categoria::create([
            'nombre' => 'Archivados',
            'descripcion' => 'Lineas deshabilitadas temporalmente',
            'estado' => false,
        ]);

        $respuestaNombre = $this->actingAs($user)->get(route('listacategorias.index', ['buscar' => 'Monitor']));
        $respuestaNombre->assertOk();
        $respuestaNombre->assertSee('Monitores');
        $respuestaNombre->assertDontSee('Archivados');
        $respuestaNombre->assertSee('Filtro: Monitor');

        $respuestaEstado = $this->actingAs($user)->get(route('listacategorias.index', ['buscar' => 'Inactivo']));
        $respuestaEstado->assertOk();
        $respuestaEstado->assertSee('Archivados');
        $respuestaEstado->assertDontSee('Monitores');
        $respuestaEstado->assertSee('Filtro: Inactivo');
    }
}
