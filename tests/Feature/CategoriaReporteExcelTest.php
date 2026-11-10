<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriaReporteExcelTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_generate_categories_excel_report(): void
    {
        $user = User::factory()->create();

        Categoria::create([
            'nombre' => 'Tecnologia',
            'descripcion' => 'Categoria de equipos y accesorios',
            'estado' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('listacategorias.excel'));

        $response->assertOk();
        $response->assertDownload('reporte-categorias.xlsx');
        $this->assertStringContainsString(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            (string) $response->headers->get('content-type')
        );
    }

    public function test_guest_is_redirected_when_trying_to_access_categories_excel_report(): void
    {
        $response = $this->get(route('listacategorias.excel'));

        $response->assertRedirect(route('login'));
    }
}
