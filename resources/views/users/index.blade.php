@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<h1>{{$user->name}}</h1>
							@if($questions->isEmpty())
							  <p>User has not asked any questions yet.</p>
							@else
							  <legend class="text-left">Recent Questions</legend>
							  <ul style="list-style-type: none; padding-left:0px;">
							  	@foreach($questions as $question)
							  	  <li>
							  	  	<div class="row panel">
							  	  		<div class="col-md-12">
							  	  			<h4 style="margin: 0;display: inline;"><a href="/questions/{{$question->id}}/{{ App\Classes\Url::get_slug($question->question) }}" title="{{ $question->question }}">{{ $question->question }}</a></h4> <small>{{count($question->answers)}} Answers | {{ $question->created_at->diffForHumans() }}</small>
							  	  		</div>
							  	  	</div>
							  	  </li>
							  	@endforeach
							  </ul>
							@endif

							@if($answers->isEmpty())
							  <p>User has no answers yet.</p>
							@else
							  <legend class="text-left">Recent Answers</legend>

							  <ul style="list-style-type: none;">
							  	@foreach($answers as $answer)
							  	<li>
							  	  <div class="row panel">
							  	  	<div class="col-md-12">
							  	  		<h4 style="margin: 0;display: inline;"><a href="/questions/{{$answer->question->id}}/{{ App\Classes\Url::get_slug($answer->question->question) }}">{{ ucfirst($answer->question->question) }}</a></h4> <small>{{ $answer->created_at->diffForHumans() }}</small>
                                                  <p>{{$answer->answer}}</p>
                                                  <small style="display: inline;">{{$answer->created_at->diffForHumans()}}</small>
							  	  	</div>
							  	  </div>
							  	</li>
							  	@endforeach
							  </ul>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			@include('sidebar.search')
		</div>
	</div>
</div>

@endsection