<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
	public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response
			->assertStatus(200)
			->assertViewIs('welcome');
    }
	
	/**
	* read post link test
	*
	* @return void
	*/
	public function test_read_request()
    {
        $response = $this->postJson('/read', ['file'=>'D:\xampp\htdocs\reader\storage\test.txt', 'type'=>'first']);
 
        $response
            ->assertStatus(201)
            ->assertJson([
                '1' => 'line 1',
            ]);
    }
}
