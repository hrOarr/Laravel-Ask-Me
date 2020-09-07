<?php

use Illuminate\Support\Facades\Route;
use App\Tag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// home
Route::get('/', 'HomeController@index')->name('Home');

// search
Route::get('/search/', ['uses' => 'HomeController@search', 'as' => 'search']);

// question
Route::get('questions/edit/{question}', 'QuestionController@edit')->middleware('can:update, post');
Route::get('questions/{question}/{slug}', 'QuestionController@show_details');
Route::post('questions/create', ['before' => 'csrf', 'uses' => 'QuestionController@insert']);
Route::post('questions/edit', ['before' => 'csrf', 'uses' => 'QuestionController@edit_save']);


Route::get('questions/ask', function(){
   return view('questions.ask', ['tags' => Tag::get()]);
});

// answer
Route::post('answer/create', ['before' => 'csrf', 'uses' => 'AnswerController@insert']);
Route::post('answer/update', ['before' => 'csrf', 'uses' => 'AnswerController@update']);

// tag
Route::get('tag/{tag:name}', 'TagController@new');

// votes
Route::post('vote/answer', ['before' => 'csrf', 'uses' => 'VoteController@vote_answer']);
Route::post('vote/question', ['before' => 'csrf', 'uses' => 'VoteController@vote_question']);

// users
Route::get('user/{id}', 'UserController@index');
Route::get('user/{id}/questions', 'UserController@questions');
Route::get('user/{id}/answers', 'UserController@answers');
