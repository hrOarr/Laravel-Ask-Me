<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function questions(){
      return $this->belongsToMany('App\Question', 'question_tag', 'tag_id', 'question_id');
    }

    // get all tags used questions
    public static function get_tags(){
      return self::distinct()->orderBy('name', 'asc')->get();
    }
}
