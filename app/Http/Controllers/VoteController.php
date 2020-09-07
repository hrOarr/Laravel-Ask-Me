<?php

namespace App\Http\Controllers;

use App\Vote;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Response;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote_question(){
      return Response::json(Vote::vote(Auth::id(), Request::get('question_id'), Request::get('vote'), 'question_id'));
    }

    public function vote_answer(){
      return Response::json(Vote::vote(Auth::id(), Request::get('answer_id'), Request::get('vote'), 'answer_id'));
    }
}
