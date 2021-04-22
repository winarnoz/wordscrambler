<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

use App\Models\User;
use App\Models\UserScore;
use App\Models\UserAnswerHistory;

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
            // create score
            $newScore = new UserScore;
            $newScore->user_id = $this->user->id;
            $newScore->score = 0;
            $newScore->save();
        } else {
            $score = $score->score;
        }

        // save history too
        $history = new UserAnswerHistory;
        $history->userId = $this->user->id;
        $history->word = strtolower($wordData->word);
        $history->shuffled_word = $shuffledWord;
        $history->isCorrect = 0;
        $history->lastScore = $score;
        $history->is_answered = 0;
        $history->save();
        
        return response()->json([
            "message" => "success",
            "data" => ["shuffled_word" => $shuffledWord, "id" => $history->id, "score" => $score],
        ], 201);
    }

    public function submitWord(Request $request) {
        if($this->user === 0) {
            return response()->json(["message" => "Unauthorized"], 401); 
        }

        if(empty($request->answer) || empty($request->id)) {
            return response()->json(["message" => "Bad Request"], 400); 
        }
        
        // fetch history
        $history = UserAnswerHistory::where('userId', $this->user->id)->where('is_answered', 0)->where('id', $request->id)
        ->first();

        if(empty($history)) {
            return response()->json(["message" => "Bad Request"], 400); 
        }

        // fetch user score
        $userScore = UserScore::where('user_id', $this->user->id)->first();

        // check if answered correctly
        if (strtolower($request->answer) === strtolower($history->word)) {
            $userScore->score += 10;
            $history->isCorrect = 1;
            $message = "correct answer";
        } else {
            $userScore->score -= 10;
            $history->isCorrect = 0;
            $message = "wrong answer";
        }
        $history->lastScore = $userScore->score;
        $history->is_answered = 1;
        $userScore->save();
        $history->save();

        //fetch word
        $word = Word::where('word', strtolower($history->word))->first();

        return response()->json([
            "message" => $message,
            "data" => ["original_word" => $word->word, "definition" => $word->definition, "score" => $userScore->score],
        ], 201);
        
    }
}
