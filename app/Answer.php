<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['answer_text','answer_type'];

    public function question()
    {
    return $this->belongsTo(Question::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
