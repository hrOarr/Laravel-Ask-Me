<?php

namespace App\Http\Controllers;

use App\User;
use App\Question;
use App\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
   // show profile
   public function index($id){
      $user = User::findOrFail($id);

      if(!$user){
         abort(404, 'Page Not Found');
      }

      $questions = Question::where('user_id', '=', $id)->take(10)->orderBy('id', 'DESC')->get();
      $answers = Answer::where('user_id', '=', $id)->take(10)->orderBy('id', 'DESC')->get();

      return view('users.index')->with('questions', $questions)->with('user', $user)->with('answers', $answers)->with('page_title', $user->name.'');
   }

   public function questions($id){
      $user = User::findOrFail($id);
      $questions = Question::where('user_id', '=', $id)->orderBy('id', 'DESC')->paginate(10);

      return view('users.questions')->with('questions', $questions)->with('user', $user)->with('page_title', $user->name.' Questions');
   }

   public function answers($id){
      $user = User::findOrFail($id);
      $answers = Answer::where('user_id', '=', $id)->orderBy('id', 'DESC')->paginate(10);

      return view('users.answers')->with('user', $user)->with('answers', $answers)->with('page_title', $user->name.'Answers');
    }
}
