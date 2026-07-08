<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FabricsPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the fabrics page loads correctly.
     */
    public function test_fabrics_page_loads()
    {
        $this->seed(\Database\Seeders\EducationalPageSeeder::class);

        // First check if the page loads and contains the static content.
        $response = $this->get('/fabrics');
        $response->assertStatus(200);
        $response->assertSee('الاقمشة الصديقة للبيئة');
    }
}
