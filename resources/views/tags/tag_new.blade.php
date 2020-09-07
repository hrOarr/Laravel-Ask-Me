@extends('layouts.app')
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							@if($questions->isEmpty())
							  <p>No question is found for this tag</p>
							@else
							  <legend class="text-left">
							  	<h1>{{$page_title}}</h1>
							  </legend>

							  <br/>

							  @foreach($questions as $question)
							    @include('questions.index')
							    @if($questions->last()!=$question)
							      <hr>
							    @endif
							  @endforeach
							  {{$questions->links()}}
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			@include('tags.tags')
		</div>
	</div>
</div>

@endsection