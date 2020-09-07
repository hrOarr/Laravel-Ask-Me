@extends('layouts.app')

@section('content')
  <div class="container">
  	<div class="row">
  		<div class="col-md-9">
  			<div class="row">
  				<div class="col-md-12">
  					<div class="panel panel-default">
  						<div class="panel-body">
  							<legend>
  								<h1>Ask Question</h1>
  							</legend>

  							@if(!Auth::check())
  							  <p>
  							  	You must be logged in to ask question
  							  	<a href="/register">Register </a>
  							  	here.
  							  </p>
  							@elseif($tags->isEmpty())
  							  <p>Add tag before asking</p>
  							@else
  							  {{ Form::open( array('url'=>'questions/create','class' =>'form-horizontal') ) }}
  							  {{ Form::token() }}

  							  <div class="form-group">
  							  	<div class="col-md-11">
  							  		{!! Form::text('question', null, ['class' => 'form-control','maxlength' => 140, 'placeholder' => 'it should be as question form','required']) !!}
                                            <small>140 character limit</small>
  							  	</div>
  							  </div>

  							  <div class="form-group">
  							  	<div class="col-md-11">
  							  		<label for="txtTags">Tags</label>

  							  		@if(!$tags->isEmpty())
  							  		  @foreach($tags as $tag)
  							  		    <small><a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>,</small>
  							  		  @endforeach
  							  		@endif

  							  		{!! Form::text('tags', null, [ 'class' => 'form-control', 'id' => 'txtTags', 'placeholder' => 'Add Tag', 'required']) !!}
  							  	</div>
  							  </div>

  							  <div class="form-group">
  							  	<div class="col-md-12">
  							  		{{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
  							  	</div>
  							  </div>
  							  {{ Form::close() }}
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