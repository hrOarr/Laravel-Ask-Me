<?php

namespace App;

use App\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Question extends Model
{
    // pagination

   private static $pagination_count = 10;
   private static $pagination_count_min = 5;

   // create relationship to users
   public function user(){
      return $this->belongsTo('App\User');
   }

   // create relationship to answers
   public function answers(){
      return $this->hasMany('App\Answer');
   }

   // create relationship to votes
   public function votes(){
      return $this->hasMany('App\Vote');
   }

   // relationship table or pivot table
   public function tags(){
      return $this->belongsToMany('App\Tag', 'question_tag', 'question_id', 'tag_id'); // specify the parameters
   }

   // insert the question in table
   public static function insert($user_id, $tags, $question_text){
      $question = new self;
      $question->question = $question_text;
      $question->user_id = $user_id;
      $question->save();

      if( !empty($tags) ){
         $tags = array_unique(explode(',', $tags));
         if( is_array($tags) ){
            foreach ($tags as $tag) {
               $tmp = DB::table('tags')->where('name', $tag)->first();
               if(isset($tmp)){
                  DB::table('question_tag')->insert(
                    ['tag_id' => $tmp->id, 'question_id' => $question->id]
                  );
               }
            }
         }
      }

      return $question;
   }

   // search
   public static function search($qry){
      $data = self::join('question_tag', 'question_tag.question_id', '=', 'questions.id')
      ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
      ->select('questions.*')
      ->where('questions.question', 'LIKE', '%'.$qry.'%')
      ->orWhere('tags.name', 'LIKE', '%'.$qry.'%')
      ->groupBy('questions.id')
      ->orderBy('questions.created_at', 'desc')
      ->paginate(self::$pagination_count_min);

      return $data;
   }

   // get tags for specific question
   public static function get_tags($id){
      $data = self::join('question_tag', 'question_tag.question_id', '=', 'questions.id')
      ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
      ->where('question_tag.question_id', '=', $id)
      ->select('tags.name')
      ->get();

      return $data;
   }

   // top relevant questions
   public static function top_relevant($tags, $question_id = 0){
      return self::join('question_tag', 'question_tag.question_id', '=', 'questions.id')
            ->join('tags', 'tags.id', '=', 'question_tag.tag_id')
            ->select('questions.*')
            ->where('questions.id', '!=', $question_id)
            ->whereIn('tags.name', $tags)
            ->orderBy('questions.id', 'desc')
            ->paginate(self::$pagination_count_min);
   }

   // top questions sorted by vote
   public static function top(){
      $data = self::join('votes', 'votes.question_id', '=', 'questions.id')
      ->select('questions.*', DB::raw('sum(votes.vote) as total_votes'))
      ->groupBy('questions.id')
      ->orderBy('total_votes', 'desc')
      ->orderBy('questions.created_at', 'desc')
      ->paginate(self::$pagination_count_min);

      return $data;
   }

   // answer count
   public function answer_count(){
      return $this->answers()
      ->selectRaw('count(*) as total, question_id')
      ->groupBy('question_id');
   }

}
