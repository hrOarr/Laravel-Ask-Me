<?php

namespace App\Http\Controllers;

use App\Question;
use App\Tag;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    // homepage view
    public function index()
    {
        $questions = Question::orderBy('created_at', 'desc')->paginate(10);
        $top = Question::top();

        return view('home')
        ->with('questions', $questions)
        ->with('top', $top)
        ->with('tags', Tag::get_tags())
        ->with('page_title', 'Questions & Answers');
    }

    // search result
    public function search(){
      $qry = Request::get('qry');
      $questions = Question::search($qry);

      return view('search')
      ->with('questions', $questions)
      ->with('tags', Tag::get_tags())
      ->with('page_title', 'search result')
      ->with('qry', $qry);
    }
}
