<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Word extends Model
{
    use HasFactory;
    protected $table = 'words';

    protected $fillable = ['word', 'definition'];

    public function fetchFromExternalAPI()
    {
        $response = Http::get('https://random-words-api.vercel.app/word', []);
        $word = json_decode($response->body());
        return $word;
    }

    public function shuffleWord($word) {
        $word = str_shuffle($word);
        return $word;
    }
}
