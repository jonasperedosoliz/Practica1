<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductoImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_image_is_stored_when_creating_a_product(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Tecnologia',
            'descripcion' => 'Dispositivos',
            'estado' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('listaproductos.store'), [
                'nombre' => 'Tablet Pro',
                'descripcion' => 'Pantalla de alta resolucion',
                'precio' => 2500,
                'stock' => 5,
                'categoria_id' => $categoria->id,
                'imagen' => UploadedFile::fake()->image('tablet.jpg'),
            ]);

        $response->assertRedirect(route('listaproductos.index'));

        $producto = Producto::first();

        $this->assertNotNull($producto);
        $this->assertNotNull($producto->imagen);
        Storage::disk('public')->assertExists($producto->imagen);
    }

    public function test_product_image_is_replaced_when_updating_a_product(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Tecnologia',
            'descripcion' => 'Dispositivos',
            'estado' => true,
        ]);

        $imagenInicial = UploadedFile::fake()->image('inicial.jpg')->store('productos', 'public');

        $producto = Producto::create([
            'nombre' => 'Tablet Pro',
            'descripcion' => 'Pantalla de alta resolucion',
            'precio' => 2500,
            'stock' => 5,
            'categoria_id' => $categoria->id,
            'imagen' => $imagenInicial,
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('listaproductos.update', $producto), [
                'nombre' => 'Tablet Pro 2',
                'descripcion' => 'Pantalla mejorada',
                'precio' => 2600,
                'stock' => 8,
                'categoria_id' => $categoria->id,
                'imagen' => UploadedFile::fake()->image('nueva.png'),
            ]);

        $response->assertRedirect(route('listaproductos.index'));

        $producto->refresh();

        Storage::disk('public')->assertMissing($imagenInicial);
        Storage::disk('public')->assertExists($producto->imagen);
    }
}
