
	$('.q_vote').on('click', function (e){
		e.preventDefault();
		var uid = $(this).parent().data('uid');
		var data = {vote: $(this).data('vote'), question_id: $(this).parent().data('question')};
		console.log(data)
	});
