<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaReportePdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_generate_categories_pdf_report(): void
    {
        $user = User::factory()->create();

        Categoria::create([
            'nombre' => 'Lacteos',
            'descripcion' => 'Productos refrigerados',
            'estado' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('listacategorias.pdf'));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertSee('%PDF', false);
    }

    public function test_guest_is_redirected_when_trying_to_access_categories_pdf_report(): void
    {
        $response = $this->get(route('listacategorias.pdf'));

        $response->assertRedirect(route('login'));
    }
}
