<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

use App\Models\User;
use App\Models\UserScore;

class ApiController extends Controller
{   

    public function __construct(Request $request)
    {
        $this->user = $this->authRequest($request);
    }

    public function fetchWord() {
        if($this->user === 0) {
            return response()->json(["message" => "Unauthorized"], 401); 
        }

        $word = new Word;
        $wordData = $word->fetchFromExternalAPI();
        
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
        
        $score = UserScore::where('user_id', $this->user->id)->first();
        if (empty($score)) {
            $score = 0;
        } else {
            $score = $score->score;
        }
        
        return response()->json([
            "message" => "success",
            "data" => ["shuffled_word" => $shuffledWord, "word_id" => $savedWord->id, "score" => $score],
        ], 201);
    }
}
