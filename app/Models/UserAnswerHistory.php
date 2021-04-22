<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswerHistory extends Model
{
    use HasFactory;
    protected $table = 'user_answer_histories';

    protected $fillable = ['userId', 'word', 'isCorrect', 'lastScore', 'is_answered'];
}
