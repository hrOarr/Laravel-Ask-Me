@php

$answer_count = json_decode($question->answer_count, true);
if( isset($answer_count[0]) ){
	$answer_number = $answer_count[0]['total'];
}
else{
	$answer_number = 0;
}

@endphp

<div class="row">
	<div class="col-md-11">
		    <h2 style="color: #2a88bd; font-weight: bolder;margin-top: 0px;">
			<a href="/questions/{{$question->id}}/{{App\Classes\Url::get_slug($question->question)}}">
				{{ $question->question }}
			</a>
		     </h2>

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

<script type="text/javascript">
	$('.q_vote').on('click', function (e){
		e.preventDefault();
		var uid = $(this).parent().data('uid');
		var data = {vote: $(this).data('vote'), question_id: $(this).parent().data('question')};
		if($(this).parent().data('question')){
			if(uid==''){ // not signed in
				var action = $(this).attr('id');
				var cur_vote = parseInt($( "#q-" +  $(this).parent().data('question')).text());
				if(action=="q-upvote"){
					$( "#q-" +  $(this).parent().data('question')).html(cur_vote - 1);
				}

				$('a.upvote').removeClass('upvote-on');
				$('a.downvote').removeClass('downvote-on');
				history.pushState("", "Login", "/login");
				$('#login-warning').modal('show');
				console.log('ok')
				return false;
			}
		}
	});
</script>