<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issuecomment extends Model
{
    protected $fillable = ['issuecomment_title', 'issuecomment_date', 'issuecomment_comment', 'user_id'];

    public function issue()
    {
    	return $this->belongsTo(Issue::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function by(User $user)
    {
    	$this->user_id = $user->id;
    }
}
