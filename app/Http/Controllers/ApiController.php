<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Http\Controllers\Validator;

class ApiController extends Controller
{   
    public function requestToken() {
        
    }

    public function fetchWord() {
        $word = new Word;
        $wordData = $word->fetchFromExternalAPI();

        $validation = Validator::make(Request::all(),[ 
            'username' => 'required|unique:users, username',
            'password' => 'required',
        ]);
        
        if(empty($wordData)) {
            return response()->json([
                "message" => "We cannot generate a word at this moment"
            ], 503); 
        }
        $wordData = $wordData[0];
        $savedWord = Word::firstOrCreate([
            'word' => strtolower($wordData->word),
            'definition' => $wordData->definition,
        ]);

        $shuffledWord = $word->shuffleWord($savedWord->word);
        
        return response()->json([
            "message" => "success",
            "data" => ["shuffled_word" => $shuffledWord, "id" => $savedWord->id],
        ], 201);
    }
}
