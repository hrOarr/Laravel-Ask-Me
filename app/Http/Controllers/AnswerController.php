<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class AnswerController extends Controller
{
   // insert answer
   // post method
   public function insert(){
      Answer::insert(Request::get('answer'), Request::get('question_id'), Auth::user()->id);
      Session::flash('flash_message', 'Thanks for answering!');

      return Redirect::to('questions/'.Request::get('question_id').'/'.Request::get('question_url'));
   }

   // update the answer
   public function update(){
      $answer = Answer::update_answer(Request::get('pk'), Request::get('value'));

      if($answer){
         return Response::json(['status' >= 1]);
      }
      else{
         return Response::json(['status' => 0]);
      }
   }
}
