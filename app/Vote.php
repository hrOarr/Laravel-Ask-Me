<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
      'user_id',
      'answer_id',
      'question_id',
      'vote',
    ];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function answer(){
      return $this->belongsTo('App\Answer');
    }

    public function question(){
      return $this->belongsTo('App\Question');
    }

    public static function vote($user_id, $id, $vote, $column)
    {
        $voted = self::where('user_id', $user_id)->where($column, $id)->first();
        if (isset($voted->vote) && $voted->vote == $vote) {
            self::destroy($voted->id);
            $ajax_response = ['status' => 'success', 'msg' => "Vote nullified on $column $id"];
        } else {
            self::updateOrCreate([$column => $id, 'user_id' => $user_id], ['vote' => $vote]);
            $ajax_response = ['status' => 'success', 'msg' => "Vote cast on $column $id"];
        }

        return $ajax_response;
    }
}
