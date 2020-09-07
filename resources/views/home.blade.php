@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
        <div class="row">
        <div class="col-md-12">
            <legend class="text-left">
                <h1>Questions</h1>
            </legend>

            @foreach($questions as $question)
              @include('questions.index')
              @if($questions->last() != $question)
                <hr>
              @endif
            @endforeach
            {{ $questions->links() }}
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
