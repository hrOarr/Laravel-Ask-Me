@extends('layouts.app')
@section('content')
@php
// todo clean this up
$answer_count = json_decode($question->answer_count,true);
if (isset($answer_count[0])) {
    $answer_number = $answer_count[0]['total'];
} else  {
    $answer_number = 0;
}
$shown = false;
@endphp

<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">

				@if (Session::has('flash_message'))
                        <div class="alert alert-success">{!!Session::get('flash_message')!!}</div>
                    @endif

                    <div class="panel-body">
                     <div class="row">
	                  <div class="col-md-12">
		               <h1 style="color: #000;font-weight: bolder;margin-top: 0;">{{ $question->question }}</h1>

		          <span>
                       <small><strong>
                        Asked {{$question->created_at->diffForHumans()}}, by <a href="/user/{{$question->user->id}}"  title="{{ $question->user->name }}">{{ucfirst($question->user->name)}}</a>,
                        {{ $answer_number >= 1 ? $answer_number . ' ' . Str::plural('answer', $answer_number) : ''  }}
                        @if ($question->user_id == Auth::id())
                            | <a href="/questions/edit/{{$question->id}}">edit question</a>
                        @endif
                     </strong></small>
                     </span>


                       @if( !$question->tags->isEmpty() )
		             @foreach($question->tags as $tag)
		             <a href="#" title="{{ $tag->name }}"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-hashtag" style="color: white;font-weight: normal;"></i> {{ $tag->name }}</button></a>
		            @endforeach
		            @endif
	                 </div>
                     </div>

                     <br>

                     @if( !isset(Auth::user()->id) && !Auth::check())
                         <p>Please <a href="/login">login</a> to post an answer for this question</p>
                     @else
                         {{ Form::open( array('url' => 'answer/create', 'class' =>'form-horizontal') ) }}
                         {{ Form::token() }}
                         {{ Form::hidden('question_id', $question->id) }}
                         {{ Form::hidden('question_url', App\Classes\Url::get_slug($question->question)) }}

                         <div class="form-group">
                         	<div class="col-md-10">
                         		{!! Form::text('answer', null, [
                         			'class' => 'form-control',
                         			'placeholder' => 'Write an answer...',
                         			'required'
                         		]) !!}
                         	</div>
                         	<div class="col-md-2">
                         		{{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                         	</div>
                         </div>

                         {{ Form::close() }}
                         @endif

                         <legend class="text-left">Answers</legend>
                         @if(!$answers->isEmpty())
                           
                           @foreach($answers as $answer)
                             <div class="row">
                             	<div class="col-md-12">
                             		<h4 style="margin: 0;display: inline;word-wrap:break-word;">{{ $answer->answer }}</h4>

                             		@if ($answer->created_at != $answer->updated_at)
                                      <P class="text-right" style="margin-top: 10px"><strong><small>by <a href="/user/{{$answer->user->id}}" title="{{ $answer->user->name }}">{{ ucfirst($answer->user->name) }}</a> | edited {{ $answer->updated_at->diffForHumans() }}</small></strong></P>
                                   @else
                                      <P class="text-right" style="margin-top: 10px"><strong><small>by <a href="/user/{{$answer->user->id}}" title="{{ $answer->user->name }}">{{ ucfirst($answer->user->name) }}</a> | {{ $answer->created_at->diffForHumans() }}</small></strong></P>
                                   @endif
                             	</div>
                             </div>
                           @endforeach
                           @else
                            <h4 style="margin: 0;display: inline;word-wrap:break-word;">No answer yet.</h4>
                         @endif

                         <br>

                         @if ( $relevant_questions->isEmpty() )
                            <p>No Relevant Questions</p>
                         @else
                            <legend class="text-left" style="font-size: 24px;">Relevant Questions</legend>
                            @foreach($relevant_questions as $question)

                              @php
                                $answer_count = json_decode($question->answer_count,true);
                                if(isset($answer_count[0])){
                                   $answer_number = $answer_count[0]['total'];
                                }
                                else{
                                   $answer_number = 0;
                                }
                              @endphp

                              <div class="row">
                                  <div class="col-md-11">
                                      <h4 style="color: #2a88bd;font-weight: bolder;margin-top: 0;margin-bottom: 0px;"><a href="/question/{{$question->id}}/{{ App\Classes\Url::get_slug($question->question) }}" title="{{ $question->question }}">{{ $question->question }}</a></h4>
                                   <span>
                                      <small>
                                      <strong>
                                       Asked {{$question->created_at->diffForHumans()}}
                                        {{ $answer_number >= 1 ? ' with ' . $answer_number . ' ' . Str::plural('answer', $answer_number) : ''  }}
                                      </strong>
                                      </small>
                                   </span>
                                  </div>
                                </div>

                              @if($relevant_questions->last() != $question)
                                 <hr>
                              @endif
                            @endforeach
                         @endif

                    </div>
			</div>
		</div>
	</div>
</div>

@endsection