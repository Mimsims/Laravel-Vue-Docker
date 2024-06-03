<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    const RESOURCE = 'https://rickandmortyapi.com/api/character';

    protected $fillable = ['id', 'name', 'status', 'species', 'type', 'gender', 'origin', 'location', 'image', 'episode', 'url', 'created'];

    protected $casts = [
        'episode' => 'array',
        'origin' => 'array',
        'location' => 'array'
    ];
}
