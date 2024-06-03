<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharactersTest extends TestCase
{
    use RefreshDatabase;

    public function test_getCharacters()
    {
        $response = $this->get('/api/characters');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'results' => [
                '*' => [
                    'id',
                    'name',
                    'status',
                    'species',
                    'gender',
                    'origin',
                    'location',
                    'image'
                ]
            ]
        ]);
    }

    public function test_getCharacterDetails()
    {
        $characterId = 1;
        $response = $this->get('/api/characters/' . $characterId);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'status',
            'species',
            'gender',
            'origin',
            'location',
            'image'
        ]);
    }

    public function test_it_can_list_all_characters_with_pagination()
	{
        $response = $this->get('/api/characters?page=10');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'results' => [
                '*' => [
                    'id',
                    'name',
                    'status',
                    'species',
                    'gender',
                    'origin',
                    'location',
                    'image'
                ]
            ]
        ]);

        $expectedData = [
          'results' => [ [ "id" => 91,
                           "name" => "David Letterman",
                           "status" => "Alive",
                           "species" => "Human"
                        ] ],
          'info' => [ "count" => 826,
                      "pages" => 42,
                      "api_pages" => 83
                     ]             

        ];

        $response->assertJson($expectedData); 
	}

}
