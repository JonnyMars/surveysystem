<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //names the table
    protected $table = 'answer';

    //Shows the fields in the table that can be filled from the system
    protected $fillable = [
        'title',
        'atext',
        'question_id',
        'survey_id',
        'answered_by',
    ];


    //An answer has one question
    public function question()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }
}
