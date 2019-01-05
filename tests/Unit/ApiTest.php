<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class ApiTest extends TestCase
{

	// use DatabaseMigrations;

    public function testUserCreation() {

    	$response = $this->json('POST', '/api/register', [
    		'name' => 'test1',
    		'email' => str_random(10) . '@test.com',
    		'password' => 'secret'
    	]);

    	$response->assertStatus(200)->assertJsonStructure([
    		'success' => ['token', 'name']
    	]);

    }

    public function testUserLogin() {

    	$response = $this->json('POST', '/api/login', [
    		'email' => 'varun@test.com',
    		'password' => 'secret'
    	]);

    	$response->assertStatus(200)->assertJsonStructure([
    		'success' => ['token']
    	]);

    }

    public function testCategoryFetch() {

    	$user = User::find(1);

    	$this->actingAs($user, 'api')
    		->json('GET', '/api/category')
    		->assertStatus(200)
    		->assertJsonStructure([
	    		'*' => [
	    			'id',
	                'name',
	                'created_at',
	                'updated_at',
	                'deleted_at'
	    		]
	    	]);

    }

    public function testCategoryCreation() {

    	$user = User::find(1);

    	$this->actingAs($user, 'api')
    		->json('POST', '/api/category', [
    			'name' => 'In Progress'
    		])
    		->assertStatus(200)
    		->assertJsonStructure([
    			'status', 'message'
    		]);
    }

    public function testCategoryDeletion() {

    	$category = \App\Category::find(1);

    	$this->withoutMiddleware()
    		->json('DELETE', '/api/category/{$category->id}')
    		->assertStatus(200)
    		->assertJson([
    			'status' => true,
    			'message' => 'Category deleted'
    		]);

    }
}
