
// Handle completed click
$(document).on('click', '.completed', function ( event )
{
	event.preventDefault();
	event.stopImmediatePropagation();
	
	var num_sections = $('.quiz-section').length;
	var section_index = $('.quiz-section').index( $(this).closest('.quiz-section') );
	if ( section_index < num_sections - 1 )
	{
		$('.section-tile').eq(section_index).addClass('complete');
		$('.section-tile').eq(section_index + 1).trigger('click');
	}
	else
	{
		// Build the quiz
		
		// Clear existing questions
		$('.quiz form > ol > li:not(.quiz-question-template)').remove();
		// Create clean templates
		var $template = $('.quiz-question-template').clone().removeClass('quiz-question-template');
		var $answer_template = $template.find('li').clone();
		$template.find('ul').empty();
		
		// Loop over module questions
		var module = $('#education-center-body')[0].className.replace('quiz_', '');
		var questions = quizzes[module]['questions'];
		for ( var key in questions )
		{
			// Skip loop if the property is from prototype
			if ( ! questions.hasOwnProperty(key) || key.length == 0 )
			{
				continue;
			}
			
			var question_id = key;
			var question = questions[key];
			var answers = question['answers'];
			
			// Create question and answer html and data
			var $question = $template.clone();
			$question.find('span').html( question.content );
			var $question_answer_list = $question.find('ul');
			
			for ( var key in answers )
			{
				// Skip loop if the property is from prototype
				if ( ! answers.hasOwnProperty(key) || key.length == 0 )
				{
					continue;
				}
				
				var answer_id = key;
				var answer = answers[key];
				
				var $answer = $answer_template.clone();
				$answer
				.find('input').attr({
					'name' : question_id,
					'value' : encodeURIComponent(answer.content),
					'data-answer_id' : answer_id
				}).end()
				.find('span').html( answer.content );
				$question_answer_list.append( $answer );
			}
			
			$('.quiz form > ol').append( $question );
		}
		
		// Scroll to content
		$('html,body').animate({
			scrollTop : $('#education-center-body').offset().top
		}, 
		fade_interval, 
		function ()
		{
			// Toggle quiz forms
			$('.modules').hide();
			$('.quiz').fadeIn();
		});
	}
});
