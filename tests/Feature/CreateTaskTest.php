<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    public function test_auth_can_create_task()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Ma nouvelle tâche',
            'detail' => 'Tous les détails de ma nouvelle tâche',
        ]);
        $this->assertDatabaseHas('tasks', [
            'title' => 'Ma nouvelle tâche'
        ]);
        $this->get('/tasks')
             ->assertSee('Ma nouvelle tâche');
    }
}
