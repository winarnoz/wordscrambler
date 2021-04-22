<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    use HasFactory;
    protected $table = 'user_scores';

    protected $fillable = ['user_id', 'score'];
}
