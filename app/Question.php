<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //Names the table
    protected $table = 'question';

    //Shows the fields in the table that can be filled from the system
    protected $fillable = [
        'id',
        'title',
        'creator_id',
        'pre_question_id',
        'survey_id',
        'option_id',
        'question_type',
        'require',
    ];

    //A question belongs to a survey
    public function survey()
    {
        return $this->belongsTo('App\Survey', 'survey_id');
    }

    //A question belongs to a user
    public function user()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    //A question has zero or many subquestions
    public function sub_questions()
    {
        return $this->hasMany('App\Question', 'pre_question_id');
    }

    //A question belongs to one previous question
    public function pre_question()
    {
        return $this->belongsTo('App\Question', 'id');
    }

    //A question has zero or many options
    public function options()
    {
        return $this->hasMany('App\Option');
    }

    //A question has one question type
    public function type()
    {
        return $this->hasOne('App\Type', 'question_type');
    }

    //A question has zero or many answers
    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

}

