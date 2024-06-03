<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Character;
use App\Collections\CharacterCollection;

class RaMController extends Controller
{    

    private function getCharactersAPI($url) {
        $response = Http::get($url);
        $charactersData = $response['results'];

        if(!Cache::has('Characters')) {
            $infoData = $response['info'];

            $characters = CharacterCollection::make($charactersData, $infoData);       
        }
        else {
            $characters = Cache::get('Characters');
            $characters->mergeResults($charactersData);
            $characters->setInfo('next', $response['info']['next']);
        }
        Cache::put('Characters', $characters, 43200); // 30 days   
    }

    public function getCharacters(Request $request)
    {
        try {
            if(!Cache::has('Characters')) {
                $this->getCharactersAPI(Character::RESOURCE);
            }

            $characters = Cache::get('Characters');

            $page = intval($request->input('page'));

            if (!$page || $page <= 0) $page = 1;
            else {
                if ($page > $characters['info']['api_pages']) $page = $characters['info']['api_pages'];
            }

            while (count($characters['results']) < CharacterCollection::API_PER_PAGE * $page &&
                    count($characters['results']) < $characters['info']['count']) {
                $getAPIResult = $this->getCharactersAPI($characters['info']['next']);
                $characters = Cache::get('Characters');
            }

            $results_slice = $characters->sliceResults(($page - 1) * CharacterCollection::API_PER_PAGE, CharacterCollection::API_PER_PAGE);

            return  response()->json($results_slice);
        } catch (\Exception $e) {
            return response()->json(['Failed to fetch characters error:'.$e->getMessage()], 500);
        }
    }

    public function getCharacterDetails($characterId)
    {
        try {
            $response = Http::get(Character::RESOURCE . '/' . $characterId);            
            $characterData = (array)$response->json();

            $character = new Character();
            $character->fill($characterData);

            return $character;
        } catch (\Exception $e) {       
            return response()->json(['error' => 'Failed to retrieve episode details'], 500);
        }
    }

}
