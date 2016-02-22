//<![CDATA[

jQuery(document).ready(function($)
{
	
	// --------------------------------------------------------------------
	
	$('.agreement-form').on('submit', function ( event )
	{
		// If event is an object, prevent default action
		event.preventDefault();
		
		// If an event passed, use "this" or else assume form selector passed
		var $this = $(this);
		
		// ----------------------------------------
		// Gather data
		var data = {};
		data.action = $this.data('action') || '';
		// ----------------------------------------
		
		// ----------------------------------------
		// Validate data
		var valid = true;
		var messages = new Array();
		
		var validate_options = {
			fields : {
				'input[name="client1_name"]' : {
					rules : 'required',
					message : 'Please enter your Name.'
				},
				'input[name="client1_email"]' : {
					rules : 'valid_email',
					message : 'Please enter your Email.',
					messages : {
						valid_email : 'Please enter a valid Email.'
					}
				},
				'input[name="client1_date"]' : {
					rules : 'required',
					message : 'Please enter the Date.'
				},
				'textarea[name="property_address"]' : {
					rules : 'required',
					message : 'Please enter your Property Address.'
				},
				'input[name="inspection_fee"]' : {
					rules : 'required',
					message : 'Please enter your Inspection Fee.'
				},
				'input[name="inspection_deposit"]' : {
					rules : 'required',
					message : 'Please enter your Inspection Deposit.'
				}
			}
		};
		$this.redlove_validate(validate_options);
		var validation = $this.data('redlove_validate').validation;
		// Set validation
		valid = validation.valid;
		messages = validation.messages;
		
		// If not valid, stop processing
		if ( ! valid )
		{
			messages.push('Please enter valid information for all required fields.');
			
			// Create messages modal
			var newline = '<br>';//"\n";
			var message = messages.join(newline);
			$.fn.redlove_modal.show('<h3>Whoops!</h3><div><p><b>It looks like you forgot to complete all form information.</b></p><p>' + message + '</p></div>');
			
			// Move to first error
			var $error_fields = $this.find('.error');
			if ( $error_fields.length > 0 )
			{
				$('html, body').animate({scrollTop: $error_fields.eq(0).offset().top - 100}, 1000, function () {});
			}
			
			return false;
		}
		// ----------------------------------------
		
		// ----------------------------------------
		// Gather request data
		var request_data = {};
		request_data.action = data.action;
		request_data = REDLOVE.fn.serialize_multiple(request_data, REDLOVE.form_data, $this.serialize());
		// ----------------------------------------
		
		// Send request
		$.ajax($.extend({}, REDLOVE.common_ajax_options, {
			context : $this,
			data : request_data,
			url : $this.attr('action'),
			success : function ( response, text_status, jq_xhr )
			{
				// Check if no or invalid response received
				if ( ! response || typeof response !== 'object' )
				{
					REDLOVE.fn.show_message('Invalid response format.', 'error');
					return false;
				}
				
				// Normalize response code to numeric
				var success = response['code'] * 1;
				// If NOT successful
				if ( success <= 0 )
				{
					// Show form messages
					REDLOVE.fn.show_message(response['message'], 'error');
					return false;
				}//end if not successful
				else
				{
					// Reset form
					$this[0].reset();
					
					// Create messages modal
					var newline = '<br>';//"\n";
					var message = response['message'].join(newline);
					$.fn.redlove_modal.show('<h3>Thank you!</h3><div><p>' + message + '</p></div>');
					
					// Scroll to top
					$('html, body').animate({scrollTop: 0}, 1000, function () {});
					
				}//end if successful
			}
			
		}));//end $.ajax
		
		return valid;
	});
	
	// --------------------------------------------------------------------
	
	$('.contact-form').on('submit', function ( event )
	{
		// If event is an object, prevent default action
		event.preventDefault();
		
		// If an event passed, use "this" or else assume form selector passed
		var $this = $(this);
		
		// ----------------------------------------
		// Gather data
		var data = {};
		data.action = $this.data('action') || '';
		// ----------------------------------------
		
		// ----------------------------------------
		// Validate data
		var valid = true;
		var messages = new Array();
		
		var validate_options = {
			fields : {
				'input[name="name"]' : {
					rules : 'required',
					message : 'Please enter your Name.'
				},
				'input[name="phone"]' : {
					rules : 'required',
					message : 'Please enter your Phone.'
				},
				'input[name="email"]' : {
					rules : 'valid_email',
					message : 'Please enter your Email.',
					messages : {
						valid_email : 'Please enter a valid Email.'
					}
				},
				'select[name="subject"]' : {
					rules : 'required',
					message : 'Please enter your Subject.'
				},
				'textarea[name="message"]' : {
					rules : 'required',
					message : 'Please enter your Message.'
				}
			}
		};
		$this.redlove_validate(validate_options);
		var validation = $this.data('redlove_validate').validation;
		// Set validation
		valid = validation.valid;
		messages = validation.messages;
		
		// If not valid, stop processing
		if ( ! valid )
		{
			messages.push('Please enter valid information for all required fields.');
			
			// Create messages modal
			var newline = '<br>';//"\n";
			var message = messages.join(newline);
			$.fn.redlove_modal.show('<h3>Whoops!</h3><div><p><b>It looks like you forgot to complete all form information.</b></p><p>' + message + '</p></div>');
			
			// Move to first error
			var $error_fields = $this.find('.error');
			if ( $error_fields.length > 0 )
			{
				$('html, body').animate({scrollTop: $error_fields.eq(0).offset().top - 100}, 1000, function () {});
			}
			
			return false;
		}
		// ----------------------------------------
		
		// ----------------------------------------
		// Gather request data
		var request_data = {};
		request_data.action = data.action;
		request_data = REDLOVE.fn.serialize_multiple(request_data, REDLOVE.form_data, $this.serialize());
		// ----------------------------------------
		
		// Send request
		$.ajax($.extend({}, REDLOVE.common_ajax_options, {
			context : $this,
			data : request_data,
			url : $this.attr('action'),
			success : function ( response, text_status, jq_xhr )
			{
				// Check if no or invalid response received
				if ( ! response || typeof response !== 'object' )
				{
					REDLOVE.fn.show_message('Invalid response format.', 'error');
					return false;
				}
				
				// Normalize response code to numeric
				var success = response['code'] * 1;
				// If NOT successful
				if ( success <= 0 )
				{
					// Show form messages
					REDLOVE.fn.show_message(response['message'], 'error');
					return false;
				}//end if not successful
				else
				{
					// Reset form
					$this[0].reset();
					
					// Create messages modal
					var newline = '<br>';//"\n";
					var message = response['message'].join(newline);
					$.fn.redlove_modal.show('<h3>Thank you!</h3><div><p>' + message + '</p></div>');
					
					// Scroll to top
					$('html, body').animate({scrollTop: 0}, 1000, function () {});
					
				}//end if successful
			}
			
		}));//end $.ajax
		
		return valid;
	});
	
	// --------------------------------------------------------------------
	
});

//]]>