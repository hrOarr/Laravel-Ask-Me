<?php

namespace App\Http\Controllers;

use App\Question;
use App\Answer;
use App\Classes\QuestionValidation;
use App\Classes\Url;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class QuestionController extends Controller
{
    // display the question

   public function show_details(Question $question){
      $relevant_questions = Question::top_relevant(Question::get_tags($question->id)->toArray(), $question->id);
      $answers = Answer::get_sorted($question->id);

      return view('questions.show_details',[
         'question' => $question,
         'answers' => $answers,
         'relevant_questions' => $relevant_questions,
         'page_title' => $question->question
      ]);
   }

   // insert question
   // post method
   public function insert(){
      $duplicate = QuestionValidation::checkDuplicate(Request::get('question'), Request::get('tags'));

      if(is_object($duplicate)){
         Session::flash('flash_message', '<P><h4>Question Already Asked</h4></P>');

         return Redirect::to('questions/'.$duplicate->id.'/'.Url::get_slug($duplicate->question));
      }

      $question = Question::insert(Auth::user()->id, Request::get('tags'), Request::get('question'));
      Session::flash('flash_message', '<P><h3>Question Added</h3>');

      return Redirect::to('questions/'.$question->id.'/'.Url::get_slug($question->question));
   }

   // edit question
   public function edit(){
      $edited = Question::find(Request::get('id'));
      $edited->question = Request::get('question');
      $edited->save();

      return Redirect::to('questions/'.$id.'/'.Url::get_slug($question));
   }

   // top questions sorted by votes
   public function top(){
      return view('questions.top',[
         'questions' => Question::top(),
         'page_title' => 'Top Questions'
      ]);
   }
}
