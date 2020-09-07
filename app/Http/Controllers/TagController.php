<?php

namespace App\Http\Controllers;

use App\Question;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // show new tag questions
   public function new(Tag $tag){
      return view('tags.tag_new',[
         'tag_info' => $tag,
         'questions' => Question::top_relevant($tag->toArray()),
         'page_title' => 'New ' . $tag->name . ' Questions',
         'tags' => Tag::get_tags(),
         'tmp' => $tag
      ]);
   }
}
