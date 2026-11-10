<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaIndexPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_list_is_paginated_in_groups_of_seven(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 9) as $numero) {
            Categoria::create([
                'nombre' => 'Categoria '.$numero,
                'descripcion' => 'Descripcion '.$numero,
                'estado' => true,
            ]);
        }

        $primeraPagina = $this->actingAs($user)->get(route('listacategorias.index'));
        $primeraPagina->assertOk();
        $primeraPagina->assertSee('Categoria 1');
        $primeraPagina->assertSee('Categoria 7');
        $primeraPagina->assertDontSee('Categoria 8');

        $segundaPagina = $this->actingAs($user)->get(route('listacategorias.index', ['page' => 2]));
        $segundaPagina->assertOk();
        $segundaPagina->assertSee('Categoria 8');
        $segundaPagina->assertSee('Categoria 9');
        $segundaPagina->assertDontSee('Categoria 1');
    }
}
