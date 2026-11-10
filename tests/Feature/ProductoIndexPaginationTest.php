<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoIndexPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_productos_se_dividen_en_paginas_de_siete_registros(): void
    {
        $user = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Categoria base',
            'descripcion' => 'Categoria de prueba',
            'estado' => true,
        ]);

        $nombres = ['Alpha', 'Bravo', 'Charlie', 'Delta', 'Echo', 'Foxtrot', 'Golf', 'Hotel', 'India', 'Juliet'];

        foreach ($nombres as $indice => $nombre) {
            Producto::create([
                'nombre' => "Producto {$nombre}",
                'descripcion' => "Descripcion {$nombre}",
                'precio' => 10 + $indice,
                'stock' => $indice + 1,
                'categoria_id' => $categoria->id,
            ]);
        }

        $primeraPagina = $this->actingAs($user)->get(route('listaproductos.index'));
        $primeraPagina->assertOk();
        $primeraPagina->assertSee('Producto Alpha');
        $primeraPagina->assertSee('Producto Golf');
        $primeraPagina->assertDontSee('Producto Hotel');

        $segundaPagina = $this->actingAs($user)->get(route('listaproductos.index', ['page' => 2]));
        $segundaPagina->assertOk();
        $segundaPagina->assertSee('Producto Hotel');
        $segundaPagina->assertSee('Producto Juliet');
        $segundaPagina->assertDontSee('Producto Alpha');
    }
}
