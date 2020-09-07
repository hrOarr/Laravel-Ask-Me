<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    public function user(){
      return $this->belongsTo('App\User');
    }

    public function question(){
      return $this->belongsTo('App\Question');
    }

    public function votes(){
      return $this->hasMany('App\Vote');
    }

    // insert an answer
    public static function insert($answer_text, $question_id, $user_id){
      $answer = new self;
      $answer->answer = $answer_text;
      $answer->user_id = $user_id;
      $answer->question_id = $question_id;
      $answer->save();

      return $answer;
    }

    // update an answer
    public static function update_answer($answer_id, $answer){
      $answer_data = self::whereId($answer_id)->first();
      $answer_data->answer = $answer;

      if($answer_data->save()){
         return true;
      }
    }

    // answers sorted by vote
    public static function get_sorted($question_id){
      $answer = self::join('questions', 'questions.id', '=', 'answers.question_id')
      ->select('answers.*')
      ->where('questions.id', '=', $question_id)
      ->groupBy('answers.id')
      ->orderBy('answers.created_at', 'desc')
      ->get();

      return $answer;
    }

}
