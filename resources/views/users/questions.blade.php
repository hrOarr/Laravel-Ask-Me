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
							  <p>{{$user->name}} has not asked any questions yet.</p>
							@else
							  <legend class="text-left">Questions asked by - {{$user->name}}</legend>

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
		</div>
	</div>
</div>

@endsection