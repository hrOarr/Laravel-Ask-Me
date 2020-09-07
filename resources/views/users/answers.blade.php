@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							@if($answers->isEmpty())
							  <p>{{$user->name}} has not any answer yet.</p>
							@else
							  <legend class="text-left">Answers given by - {{$user->name}}</legend>

							  <ul style="list-style-type: none;">
							  @foreach($answers as $answer)
							    <li>
							    	<div class="row panel">
							    		<div class="col-md-12">
							    			<h4 style="margin: 0;display: inline;"><a href="/questions/{{$answer->question->id}}/{{ App\Classes\Url::get_slug($answer->question->question) }}">{{ ucfirst($answer->question->question) }}</a></h4> <small>{{ $answer->created_at->diffForHumans() }}</small>
                                                  <p>{{ $answer->answer }}</p>
							    		</div>
							    	</div>
							    </li>
							  @endforeach
							  </ul>
							  {{$answers->links()}}
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