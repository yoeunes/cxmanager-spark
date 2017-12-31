<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = ['user_id','project_id','issue_title','issue_created_date','issue_response_date','issue_response_person','issue_type','issue_status', 'issue_priority','issue_description','issue_recommendation','issue_resolution'];

    public function issuecomments()
    {
    	return $this->hasMany(Issuecomment::class);
    }

    public function addIssuecomments(Issuecomment $issuecomments, User $userinfo)
    {
    	$issuecomments->user_id = $userinfo->user_id;
    	return $this->issuecomments()->save($issuecomments);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function team()
    {
    return $this->belongsTo(Team::class);
    }

    public function asset()
    {
    return $this->belongsTo(Asset::class);
    }

    public function space()
    {
    return $this->belongsTo(Space::class);
    }

    public function by(User $user)
    {
        $this->user_id = $user->id;
    }

}
