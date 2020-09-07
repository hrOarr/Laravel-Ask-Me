<?php

namespace App\Classes;

use App\Question;

class QuestionValidation
{
   // check for duplicate questions

   public static function checkDuplicate($question, $tag){
      $tags = explode(',', $tag);

      $data = Question::select('*')->where('question', '=', $question)->get();

      if(isset($data[0])){
         return $data[0];
      }
      else{
         return false;
      }
   }
}