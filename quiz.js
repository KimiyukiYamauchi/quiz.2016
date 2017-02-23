$(function() {
	'use strict';

	$('.answer').on('click', function() {
		var $selected = $(this);
		if( $selected.hasClass('correct') || $selected.hasClass('wrong') ) {
			return;
		}
		$selected.addClass('selected');
		var answer = $selected.text();
		//console.log(answer);

		$.post('_answer.php', {
			answer: answer,
			token: $('#token').val()
		}, function(res) {
			//alert(res.correct_answer);
			$('.answer').each(function() {
				if($(this).text() === res.correct_answer) {
					$(this).addClass('correct');
				} else {
					$(this).addClass('wrong');
				}
			});
			if(answer === res.correct_answer){
				// correct!
				$selected.text(answer + ' ...CORRECT!');
			} else {
				// wrong!
				$selected.text(answer + ' ...WRONG!');
			}
			$('#btn').removeClass('disabled');
		});

	});

	$('#btn').on('click', function() {
		if(!$(this).hasClass('disabled')){
			location.reload();
		}
	});

});
