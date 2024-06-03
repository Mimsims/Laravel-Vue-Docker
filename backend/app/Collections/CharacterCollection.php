<?php

namespace App\Collections;

use Illuminate\Support\Collection;
use App\Models\Character;

class CharacterCollection extends Collection
{
    const API_PER_PAGE = 10;

    public static function make($characters = [], $info = [])
    {
      $results['results'] = array_map(function ($character) {
        return new Character($character);
        }, $characters);

      // Calculate how many pages will contain API response       
      $info['api_per_page'] = self::API_PER_PAGE;
      $info['api_pages'] = ceil($info['count'] / self::API_PER_PAGE);

      $results['info'] = $info;      
      return new static($results);
    }

    public function push(...$values)
    {
      $this->items['results'] = array_merge($this->items['results'], $values);
    }

    public function setInfo($key, $value)
    {
        $this->items['info'][$key] = $value;
    }

    public function mergeResults($data) {
        $this->items['results'] = array_merge($this->items['results'], $data);
    }

    public function sliceResults($index, $count) {
        $result['results'] = array_slice($this->items['results'], $index, $count);
        $result['info'] = $this->items['info'];
        return $result;
    }
}
