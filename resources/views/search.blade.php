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
							  <p>No question is found.</p>
							@else
							  <legend class="text-left">
							  	<h1>Results for - {{$qry}}</h1>
							  </legend>

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
			@include('sidebar.search')
			@include('sidebar.tags')
		</div>
	</div>
</div>

@endsection