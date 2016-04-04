//<![CDATA[

// --------------------------------------------------------------------

// On window load
jQuery(window).load(function ()
{
	// Page has loaded, toggle loading/loaded
	$('html').removeClass('loading').addClass('loaded');
});

// --------------------------------------------------------------------

// On DOM ready
jQuery(document).ready(function ( $ )
{
	
	// --------------------------------------------------------------------
	
	// Remove "no JavaScript" class from DOM
	$('.no-js').removeClass('no-js');
	
	// --------------------------------------------------------------------
	
	// If iPhone, iPod, or iPad
	if ( navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i) )
	{
		// Fix label clicking
		// http://www.thewatchmakerproject.com/blog/how-to-fix-the-broken-ipad-form-label-click-issue
		jQuery(document).ready(function ()
		{
			//$($(this).attr('for')).focus();
			$('label[for]').click(function ()
			{
				var el = $(this).attr('for');
				if ($('#' + el + '[type=radio], #' + el + '[type=checkbox]').attr('selected', !$('#' + el).attr('selected'))) {
					return;
				} else {
					$('#' + el)[0].focus();
				}
			});
		});
		
		// ----------------------------------------
		
		// On page load
		jQuery(window).load(function ()
		{
			// Scroll to hide address bar
			setTimeout(function(){window.scrollTo(0, 1);}, 100);
		});
	}
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Links
	// --------------------------------------------------------------------
	
	// Smooth scroll anchor links
	// http://css-tricks.com/snippets/jquery/smooth-scrolling/
	var $root = $('html, body');
	$('a[href*=#]:not([href=#]):not(.l-modal-link)').click(function ()
	{
		if (
			location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && 
			location.hostname == this.hostname
		)
		{
			var offset = -20;
			var hash = this.hash;
			var target = $(hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			var target_scroll_top = ( target.length > 0 ) ? target.offset().top : 0;
			target_scroll_top += offset;
			
			$root.animate({
				scrollTop: target_scroll_top
			}, 
			1000, 
			function() {
				// Swap out targets long enough to change the hash without moving to them
				var id = target.attr('id');
				var name = target.attr('name');
				target.attr('id', '');
				target.attr('name', '');
				window.location.hash = hash;
				target.attr('id', id);
				target.attr('name', name);
				//$root.scrollTop(target_scroll_top);
			});
			return false;
		}
	});
	
	// External links
	$(document).on('click', 'a[rel="external"], a[rel="document"]', function ( event )
	{
		event.preventDefault();
		window.open($(this).attr('href'));
		return false;
	});

	// Print links
	$(document).on('click', 'a[rel="print"]', function ( event )
	{
		event.preventDefault();
		window.print();
	});

	// Back links
	$(document).on('click', 'a[rel="back"]', function ( event )
	{
		event.preventDefault();
		window.history.back();
	});

	// Disabled Tab
	$(document).on('click', '.disabled', function ( event )
	{
		event.preventDefault();
	});

	// Create popup window
	$(document).on('click', '.popup-window', function ( event )
	{
		event.preventDefault();
		var width = 626,
			height = 436,
			left = ($(window).width() - width) / 2,
			top = ($(window).height() - height) / 2,
			url = this.href,
			opts = 'status=1' +
			',width=' + width +
			',height=' + height +
			',top=' + top +
			',left=' + left;
		window.open(url, 'popupwindow', opts);
		this.blur();
		return false;
	});

	// Form submit
	$(document).on('click', '.form-submit', function ( event )
	{
		event.preventDefault();
		$(this).closest('form').trigger('submit');
	});
	
	// Clickthrough elements functionality
	// http://stackoverflow.com/questions/3680429/click-through-a-div-to-underlying-elements
	// pointer-events:none
	$(document).on('click', '.click-through', function ( event )
	{
		event = event || window.event;
		$this = $(this);
		// make finger disappear
		$this.hide(0);
		// get element at point of click
		starter = document.elementFromPoint(event.clientX, event.clientY);
		// send click to element at finger point
		$(starter).click();
		// bring back the finger
		$this.show(0);
	});
	
	// --------------------------------------------------------------------
	// Forms
	// --------------------------------------------------------------------
	
	// Trigger file input
	// http://stackoverflow.com/questions/793014/jquery-trigger-file-input
	$(document).on('click', '[data-input-file]', function ( event )
	{
		event.preventDefault();
		
		var $this = $(this);
		var $input_file = $this.siblings().andSelf().filter( $this.data('input-file') ) || $( $this.data('input-file') );
		
		if ( $input_file.length )
		{
			var $input_file_value_target = $this.siblings().andSelf().filter( $this.data('input-file-value-target') );
			$input_file_value_target = $input_file_value_target.length ? $input_file_value_target : $this;
			
			$input_file.trigger('click')//.get(0).focus();
			// Put text in text field under file input
			.one('change', function ( event )
			{
				event.preventDefault();
				var file_value = this.value.substring(this.value.lastIndexOf('\\') + 1);
				$input_file_value_target.val(file_value);
				this.blur();
			});
		}
		
		$this[0].blur();
	});
	
	// --------------------------------------------------------------------
	// Media
	// --------------------------------------------------------------------
	
	// Fluid width video
	/*
	//http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
	//http://css-tricks.com/NetMag/FluidWidthVideo/demo.php
	//http://www.bymichaellancaster.com/blog/fluid-iframe-and-images-without-javascript-plugins/
	var $videos = $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src^="//www.youtube.com"], object, embed');
	// The element that is fluid width
	var $fluid_el = $('body');
	// Figure out and save aspect ratio for each video
	$videos.each(function()
	{
		$(this)
		// jQuery .data does not work on object/embed elements
		.attr('data-aspect_ratio', this.height / this.width)
		// and remove the hard coded width/height
		.removeAttr('height')
		.removeAttr('width');
	});
	// When the window is resized
	$(window).resize(function()
	{
		var new_width = $fluid_el.width();
		// Resize all videos according to their own aspect ratio
		$videos.each(function()
		{
			var $el = $(this);
			$el
			.width(new_width)
			.height(new_width * $el.attr('data-aspect_ratio'));
		});
	})
	// Kick off one resize to fix all videos on page load
	.resize();
	*/
	
	var $embed_videos = $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src^="//www.youtube.com"], object, embed');
	// Figure out and save aspect ratio for each video
	$embed_videos.each(function()
	{
		var aspect_ratio = this.height / this.width;
		
		var $video_el = $(this);
		// Create embed, set padding to aspect ratio fill, insert after the video temporarily
		var $embed_el = $('<div class="embed"></div>')
		.css('padding-bottom', (aspect_ratio * 100) + '%')
		.insertAfter($video_el);
		
		// Set the aspect ratio data, move video inside embed
		$video_el
		// jQuery .data does not work on object/embed elements
		.attr('data-aspect_ratio', aspect_ratio)
		.appendTo($embed_el);
	});
	
	// --------------------------------------------------------------------
	// AJAX
	// --------------------------------------------------------------------
	
	$('.image_some-img').on('click', function ( event )
	{
		event.preventDefault();
		
		// Populate input with data and trigger click
		var $this = $(this);
		var action = $this.data('editable-action');
		var params = $this.data('editable-params');
		$('#input_file_some-img').data({
			'editable-action' : action,
			'editable-params' : params,
			'triggered_by' : $this
		}).trigger('click');
	});
	
	// On file change, create from, clone input, submit form
	$('#input_file_some-img').on('change', function ( event )
	{
		var $element = $(this);
		var $triggered_by = $element.data('triggered_by');
		
		// Create new form to submit
		var $new_form = $('<form action="' + COMMON.store_api + '" method="post" enctype="multipart/form-data" novalidate="novalidate"></form>');
		
		// Add form data
		$new_form
		.append('<input type="hidden" name="action" value="' + $element.data('editable-action') + '">')
		.append('<input type="hidden" name="params" value="' + encodeURIComponent(JSON.stringify($element.data('editable-params'))) + '">');
		append_fields_to_form($new_form, REDLOVE.form_data);
		append_fields_to_form($new_form, REDLOVE.security);
		
		// Clone file input, add it after, reset value; used to swap out real input
		var $input = $(this);
		var $new_input = $input.clone(true);
		$new_input.insertAfter($input).wrap('<form>').parent('form').trigger('reset').end().unwrap();
		// Move the original file input data to the form; security restrictions prevent cloning in all browsers
		$input.appendTo($new_form);
		
		// Create an iframe for the form target
		var $iframe = create_iframe_form_target(function ( content )
		{
			show_site_loading(false);
			
			// Remove form and process response
			$new_form.remove();
			response = try_parse_json(content);
			
			// Check if no or invalid response received
			if ( ! response || typeof(response) !== 'object' )
			{
				show_message('Invalid response format.', 'error');
				return false;
			}
			
			// Normalize response code to numeric
			var success = response['code'] * 1;
			// If successful
			if ( success > 0 )
			{
				var data = response['value'];
				
				//window.location.reload();
				
				// Refresh image source
				var new_src = REDLOVE.base_url + 'images/store-product/' + data.file + '?cb=' + new Date().getTime();
				$('img[data-product-image-id="' + data.image_id + '"]')
				.attr('src', new_src);
				
				show_message(response['message'], 'success');
			}//end if successful
			else
			{
				show_message(response['message'], 'error');
				return false;
			}//end if not successful
		});
		$new_form.attr('target', $iframe[0].id);
		
		// Add form to DOM
		$('body').append($new_form);
		
		// Submit form
		show_site_loading();
		$new_form.trigger('submit');
	});
	
	// --------------------------------------------------------------------
	
	var $first_field = $('.form_some-form').find('input[type!="hidden"], textarea, select').eq(0);
	if ( $first_field.length && $first_field.val().length == 0 )
	{
		$first_field[0].focus();
	}
	
	// Submit a form
	$('.form_some-form').on('submit', function ( event )
	{
		// If event is an object, prevent default action
		/*
		event.preventDefault();
		
		// or
		
		var event_passed = ( event && typeof(event) === 'object' );
		if ( event_passed )
		{
			event.preventDefault();
		}
		*/
		var event_passed = ( event && typeof(event) === 'object' );
		if ( event_passed )
		{
			event.preventDefault();
		}
		
		// If an event passed, use "this" or else assume form selector passed
		/*
		var $this = $(this);
		
		// or
		
		var $this = event_passed ? $(this) : $(event).eq(0);
		*/
		var $this = event_passed ? $(this) : $(event).eq(0);
		
		/*
		// Init messages and loading indicators
		REDLOVE.fn.show_form_loading($this);
		*/
		
		// ----------------------------------------
		// Gather data
		/*
		var data = jQuery.parseJSON( $(this).attr('rel') );//$this.data('data')// Parse JSON data on element
		
		// or
		
		var data = {};
		data.action = $this.data('action') || '';
		data.name = $('input[name="name"]', $this).val() || '';
		data.email = $('input[name="gobbledy-gook"]', $this).val() || '';
		
		var params = $this.data('params') || {};
		*/
		var data = {};
		data.action = $this.data('action') || '';
		data.name = $('input[name="name"]', $this).val() || '';
		data.email = $('input[name="gobbledy-gook"]', $this).val() || '';
		data.question = $('textarea[name="question"]', $form).val() || '';
		
		// If clicking on an item with data instead of a form
		var params = $this.data('params') || {};
		params.action_modifier = 'edit-in-place';
		params.field = $this.attr('property');
		params.value = $this.html();
		if ( params.field == 'price' )
		{
			params.value = 0;
		}
		// ----------------------------------------
		
		// ----------------------------------------
		// Validate data
		var valid = true;
		var messages = new Array();
		
		/*
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
		messages = messages.concat(validation.messages);
		*/
		
		if ( data.name.length == 0 )
		{
			valid = false;
			messages.push('Please enter your name.');
		}
		
		if ( data.email.length == 0 || ! REDLOVE.fn.validation.valid_email(data.email) )
		{
			valid = false;
			messages.push('Please enter a valid email address.');
		}
		
		// If not valid, stop processing
		if ( ! valid )
		{
			/*
			// Add message
			messages.push('Please enter valid information for all required fields.');
			
			// or
			
			// Show generic messages
			REDLOVE.fn.show_message(messages.join("\n"), 'error');
			
			// or
			
			// Show form messages
			REDLOVE.fn.show_form_messages( $this, messages, 'error' );
			
			// or
			
			// Hide form loading
			REDLOVE.fn.show_form_loading($this, false);
			
			// or
			
			// Create messages modal
			var newline = '<br>';//"\n";
			var message = messages.join(newline);
			$.fn.redlove_modal.show('<h3 style="font-weight: 700;">Whoops!</h3><div style="font-size: 1.2em;"><p style="font-weight: 700;">It looks like you forgot to complete all form information.</p><p>' + message + '</p></div>');
			
			// or
			
			// Move to first error
			var $error_fields = $this.find('.error');
			if ( $error_fields.length > 0 )
			{
				$('html, body').animate({scrollTop: $error_fields.eq(0).offset().top - 100}, 1000, function () {});
			}
			
			return false;
			*/
			
			messages.push('Please enter valid information for all required fields.');
			REDLOVE.fn.show_form_messages( $this, messages, 'error' );
			REDLOVE.fn.show_form_loading($this, false);
			
			return false;
		}
		// ----------------------------------------
		
		// ----------------------------------------
		// Gather request data
		/*
		var request_data = {};
		request_data.action = data.action;
		request_data.params = JSON.stringify(params);
		request_data = REDLOVE.fn.serialize_multiple(request_data, REDLOVE.form_data, $this.serialize());
		
		// or
		
		var request_data = {};
		// Manual data
		request_data.key = value;
		request_data.params = JSON.stringify({});
		// Extend with common and security data
		$.extend(true, request_data, REDLOVE.form_data, REDLOVE.security);
		// Serialize the data as a string
		request_data = REDLOVE.fn.serialize_data(request_data);
		// Add serialized form data
		request_data += '&' + $this.serialize();
		// Serialize common and security data
		//request_data += serialize_data(REDLOVE.form_data);
		//request_data += serialize_data(REDLOVE.security);
		
		// or
		
		// If clicking on an item with data instead of a form
		var request_data = {
			action : $this.data('action'),
			params : JSON.stringify(params)
		};
		request_data = REDLOVE.fn.serialize_multiple(request_data, REDLOVE.form_data);
		*/
		var request_data = {};
		request_data.action = data.action;
		request_data.params = JSON.stringify(params);
		request_data = REDLOVE.fn.serialize_multiple(request_data, REDLOVE.form_data, $this.serialize());
		
		// ----------------------------------------
		
		// Send request
		/*
		$.ajax($.extend({}, REDLOVE.common_ajax_options, {
			context : $this,
			data : request_data,
			url : $this.attr('action'),
			success : function ( response, text_status, jq_xhr )
			{
				// Check if no or invalid response received
				if ( ! response || typeof(response) !== 'object' )
				{
					REDLOVE.fn.show_message('Invalid response format.', 'error');
					return false;
				}
				
				// Normalize response code to numeric
				var success = response['code'] * 1;
				// If NOT successful
				if ( success <= 0 )
				{
					REDLOVE.fn.show_message(response['message'], 'error');
					return false;
				}//end if not successful
				else
				{
					var data = response['value'];
					messages = messages = messages.concat(response['message']);
					
					// Show form messages
					REDLOVE.fn.show_message(response['message'], 'success');
					
					// Reset form
					$this[0].reset();
				}//end if successful
			}
		}));//end $.ajax
		*/
		$.ajax({
			cache : false,
			context : $this,
			data : request_data,
			dataType : 'json',// Response type
			timeout : 300000,
			type : 'POST',
			url : $this.attr('action'),//REDLOVE.base_url + ''//this.href//this.action//$this.attr('action'),// For IE, make sure form action attribute is not empty if used
			
			success : function ( response, text_status, jq_xhr )
			{
				// Check if debugging
				if ( REDLOVE.debug )
				{
					REDLOVE.fn.log(REDLOVE.fn.object_to_string(response));
				}
				
				// Check if no or invalid response received
				if ( ! response || typeof(response) !== 'object' )
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
					/*
					REDLOVE.fn.show_message(response['message'], 'error');
					// or
					REDLOVE.fn.show_form_messages( $this, response['message'], 'error' );
					*/
					REDLOVE.fn.show_message(response['message'], 'error');
					
					return false;
				}//end if not successful
				else
				{
					var data = response['value'];
					
					/*
					// Show form messages
					REDLOVE.fn.show_message( response['message'], 'success' );
					// or
					REDLOVE.fn.show_form_messages( $this, response['message'], 'success' );
					// or
					create_growl(response['message'], 'success');
					// or
					alert(response['message']);
					
					// or
					
					// Reset form
					$this[0].reset();
					
					// or
					
					// Reload page
					window.location.reload();
					// or
					window.location.href = 'http://example.com/thank-you?';
					
					// or
					
					// Create messages modal
					var newline = '<br>';//"\n";
					var message = messages.join(newline);
					$.fn.redlove_modal.show('<h3 style="font-weight: 700;">Thank you!</h3><div style="font-size: 1.2em;"><p>' + message + '</p></div>');
					
					// or
					
					// Scroll to top
					$('html, body').animate({scrollTop: 0}, 1000, function () {});
					*/
					
					// Send analytics event
					REDLOVE.fn.send_analytics_hit($this.attr('action'), 'form', 'submit', 'contact');
					
					// or
					
					// Close modal window
					$this.closest('.redlove_modal').find('.redlove_modal_controls_close').trigger('click');
					
					// or
					
					// Clone elements
					var $template = $(event.currentTarget);
					var $clone = $template.clone().removeAttr('id');
					$clone.add( $clone.find('[data-editable-params=""]') ).attr('data-editable-params', data.encoded_json_params);
					$clone.insertBefore($template);
					delete($template);
					delete($clone);
					
					// or
					
					$('.answer:not(.hidden)').remove();
					for ( var i in data )
					{
						// Clone elements
						var $template = $('#text-answer-template');
						var $clone = $template.clone().removeAttr('id').removeClass('hidden');
						$clone.find('h4').html( data[i].title + data[i].asked_byline).after(data[i].answer_content);
						$clone.find('.nav_social-share a:eq(0)').attr('href', data[i].facebook_url);
						$clone.find('.nav_social-share a:eq(1)').attr('href', data[i].twitter_url);
						$clone.insertBefore($template);
						delete($template);
						delete($clone);
					}
					
					// or
					
					var $answers = $('.answer');
					var $answers_container = $('.answers-container');
					var $template = $answers.eq(0);//$('#text-answer-template');
					$answers.remove();
					for ( var i in data )
					{
						// Clone elements
						var $clone = $template.clone().removeAttr('id').removeClass('hidden');
						$clone.find('h4').html(data[i].title + data[i].asked_byline);
						$clone.find('.answer_content').html(data[i].answer_content);
						$clone.find('.nav_social-share a:eq(0)').attr('href', data[i].facebook_url);
						$clone.find('.nav_social-share a:eq(1)').attr('href', data[i].twitter_url);
						$clone.appendTo($answers_container);
						delete($clone);
					}
					delete($template);
					
					// or
					
					// Iterate over response data
					$('.results').empty();
					for ( var prop in data )
					{
						var row = data[prop];
						
						//http://stackoverflow.com/questions/11591174/escaping-of-attribute-values-using-jquery-attr
						var title = $('<div/>').html(row.title + ' --- ' + row.description).text();
						var $new_element = $('<div/>').html(title);
						$('.results').append($new_element);
						delete(row);
					}
					
				}//end if successful
			},
			
			error : function ( jq_xhr, text_status, error_thrown )
			{
				var newline = "\n";
				var message = [
					'There was an error with the request.',
					'Javascript: ' + error_thrown,
					'Application: ' + jq_xhr.responseText
				].join(newline);
				
				REDLOVE.fn.show_message(message, 'error');
			},
			
			statusCode :
			{
				404 : function()
				{
					REDLOVE.fn.show_message('The page was not found.', 'error');
				}
			},
			
			beforeSend : function( jq_xhr, settings )
			{
				REDLOVE.fn.show_site_loading();
			},
			
			complete : function( jq_xhr, text_status )
			{
				REDLOVE.fn.show_form_loading($this, false);
				REDLOVE.fn.show_site_loading(false);
			}
			
		});//end $.ajax
		
	});
	
	// --------------------------------------------------------------------
	
	function show_form_messages ( $form, messages, type )
	{
		// Find or create messages element within form
		var $notifications = $('.notifications', $form);
		if ( ! $notifications.length )
		{
			$notifications = $('<div class="notifications"></div>').prependTo($form);
		}
		
		$notifications.empty();//.html(messages.join("\n"));
		
		// If a message string, convert to array
		if ( typeof(messages) === 'string' && messages.length > 0 )
		{
			messages = new Array(messages);
		}
		
		// Display messages
		if ( messages && messages.length > 0 )
		{
			// Show each message individually
			for ( var messages_index in messages )
			{
				var message = messages[messages_index];
				if ( message.length > 0 )
				{
					$notifications.append( $('<div class="notification ' + type + '">' + message + '</div>') );
				}
			}
			
			// Scroll to notifications
			$('html,body').animate({
				scrollTop : $notifications.offset().top - 100//0//$form.offset().top
			}, 500, function(){});
		}
		
		return $notifications;
	}

	// --------------------------------------------------------------------
	
	function show_form_loading ( $form, show )
	{
		var show = ( show !== false );
		
		var $submit_button = $('[type="submit"]', $form);
		var is_input = ( $submit_button.length > 0 );
		$submit_button = is_input ? $submit_button : $('.form-submit', $form);
		
		var initial_submit_value = $submit_button.data('initial-value');
		if ( initial_submit_value === undefined )
		{
			initial_submit_value = is_input ? $submit_button.val() : $submit_button.html();
			$submit_button.data('initial-value', initial_submit_value);
		}
		
		if ( show )
		{
			if ( is_input )
			{
				$submit_button.prop('disabled', true).val('Sending...');
			}
			else
			{
				$submit_button.attr('disabled', 'disabled').html('Sending...');
			}
			
			var messages = new Array('Please wait...');
			show_form_messages($form, messages, 'warning');
		}
		else
		{
			if ( is_input )
			{
				$submit_button.prop('disabled', false).val(initial_submit_value);
			}
			else
			{
				$submit_button.attr('disabled', '').html(initial_submit_value);
			}
			
			//show_form_messages($form);
		}
	}

	// --------------------------------------------------------------------
	
	function show_site_loading ( show )
	{
		var hide = ( show === false );
		
		// Create element if it doesn't exist
		var site_loading_class = 'site_loading';
		var $site_loading = $('.' + site_loading_class);
		if ( $site_loading.length == 0 )
		{
			$site_loading = $('<div class="'+ site_loading_class + '"></div>').appendTo('body');
			// Prevent mouse interactions
			$site_loading.on('click', function ( event )
			{
				event.preventDefault();
				event.stopImmediatePropagation();
				return false;
			});
		}
		
		if ( hide )
		{
			$site_loading
			.stop(true, true)
			.fadeOut(300, function ()
			{
				$('body').removeClass('no-scroll no-select');
			});
		}
		else
		{
			// Prevent body scrolling and text selection
			$('body').addClass('no-scroll no-select');
			$site_loading
			.stop(true, true)
			.fadeIn(300);
		}
	}

	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	<script type="text/javascript">
	jQuery(document).ready(function ( $ )
	{
		var pagination_config = {
			base_url : '<?php echo site_url('answers/load/text'); ?>',
			num_links : 2,
			offset_key : 'page',
			page : <?php echo $pagination_answers_text_page; ?>,
			pagination_container : '.nav_answer-pagination',
			per_page : <?php echo $pagination_answers_text_limit; ?>,
			total_rows : <?php echo $pagination_answers_text_total_rows; ?>,
			
			first_link : '&laquo;',
			prev_link : '&lsaquo;',
			next_link : '&rsaquo;',
			last_link : '&raquo;',
			'' : ''
		};
		REDLOVE.fn.create_pagination(pagination_config);
	});
	</script>
	<nav class="nav_answer-pagination"></nav>
	*/
	$(document).on('click', '.nav_answer-pagination_text a', function ( event )
	{
		event.preventDefault();
		
		// Gather request data
		var request_data = REDLOVE.fn.serialize_multiple(REDLOVE.form_data);
		var url = this.href;
		
		// Send request
		$.ajax($.extend({}, REDLOVE.common_ajax_options, {
			data : request_data,
			url : url,
			success : function ( response, text_status, jq_xhr )
			{
				// Check if no or invalid response received
				if ( ! response || typeof(response) !== 'object' )
				{
					REDLOVE.fn.show_message('Invalid response format.', 'error');
					return false;
				}
				
				// Normalize response code to numeric
				var success = response['code'] * 1;
				// If successful
				if ( success > 0 )
				{
					var data = response['value'];
					data = data['data'];
					
					var $answers = $('.answer');
					var $answers_container = $('.answers-container');
					var $template = $answers.eq(0);//$('#text-answer-template');
					$answers.remove();
					for ( var i in data )
					{
						// Clone elements
						var $clone = $template.clone().removeAttr('id').removeClass('hidden');
						$clone.find('h4').html(data[i].title + data[i].asked_byline);
						$clone.find('.answer_content').html(data[i].answer_content);
						$clone.find('.nav_social-share a:eq(0)').attr('href', data[i].facebook_url);
						$clone.find('.nav_social-share a:eq(1)').attr('href', data[i].twitter_url);
						$clone.appendTo($answers_container);
						delete($clone);
					}
					delete($template);
					
					REDLOVE.answers_text_pagination_config.page = REDLOVE.fn.parse_querystring(url)[REDLOVE.answers_text_pagination_config.offset_key];
					REDLOVE.fn.create_pagination(REDLOVE.answers_text_pagination_config);
				}//end if successful
				else
				{
					REDLOVE.fn.show_message(response['message'], 'error');
					return false;
				}//end if not successful
			}
		}));//end $.ajax
	});
	
	
	
});

// --------------------------------------------------------------------
// Edit-in-place text
// --------------------------------------------------------------------

jQuery(document).ready(function ( $ )
{
	//console.log( 'Num editable: ' + $('[data-editable]').length );
	
	var event_click_namespace = 'click.editable';
	var event_blur_namespace = 'blur.editable keyup.editable paste.editable input.editable';
	event_blur_namespace = 'blur.editable';
	var event_focus_namespace = 'focus.editable';
	var event_keydown_namespace = 'keydown.editable';
	var event_paste_namespace = 'paste.editable';
	var event_change_namespace = 'change.editable';
	
	$(document)
	//.one( event_click_namespace, '[data-editable]', click_handler )
	.on( event_blur_namespace, '[data-editable]', blur_handler )
	.on( event_focus_namespace, '[data-editable]', focus_handler )
	.on( event_paste_namespace, '[data-editable]', paste_handler )
	.on( event_change_namespace, '[data-editable]', change_handler );
	
	// Start editability of attributed content
	$('[data-editable]').each(function(i, el)
	{
		start_editable(el);
	});

	function start_editable( element )
	{
		var $element = $(element);
		var element = $element[0];
		//console.log( 'start_editable(): ' + element.tagName );

		$element
		.attr('contenteditable', 'true');
		
		// If text is empty, show placeholder
		var text = $element.html();
		// Clean browser line break
		text = text.replace(/<br>$/gi, '').replace(/^\s+|\s+$/gm,'');
		if ( text == '' )
		{
			var placeholder = $element.data('editable-placeholder');
			$element.html(placeholder);
		}

		return $element;
	}

	function stop_editable( element )
	{
		var $element = $(element);
		var element = $element[0];
		//console.log( 'stop_editable(): ' + element.tagName );
		
		$element
		.attr('contenteditable', 'false');
		
		return $element;
	}
	
	// 
	function click_handler( event )
	{
		event.preventDefault();
		event.stopImmediatePropagation();
		
		var $this = $(event.currentTarget);
		//console.log( 'click_handler(): ' + $this.data('editable') );
		
		start_editable( $this );
		$this.focus();
		
		return $this;
	}
	
	function focus_handler( event )
	{
		var $this = $(event.currentTarget);
		//console.log( 'focus_handler(): ' + $this.data('editable') );
		
		// If text is placeholder, set blank text
		var text = $this.html();
		// Clean browser line break
		text = text.replace(/<br>$/gi, '').replace(/^\s+|\s+$/gm,'');
		// Set blank text if placeholder used
		var placeholder = $this.data('editable-placeholder');
		if ( text == placeholder )
		{
			text = '';
			$this.html(text);
		}
		
		$this
		.data('enter', text)
		.data('before', text)
		.addClass('editing')
		.on( event_keydown_namespace, key_listener );
		
		return $this;
	}
	
	function blur_handler( event )
	{
		var $this = $(event.currentTarget);
		//console.log( 'blur_handler(): ' + $this.data('editable') );
		
		$this
		.removeClass('editing')
		.off( event_keydown_namespace, key_listener );
		
		var text = $this.html();
		// Clean browser line break
		text = text.replace(/<br>$/gi, '').replace(/^\s+|\s+$/gm,'');
		
		if ( $this.data('before') !== text )
		{
			$this.data('before', text);
			$this.trigger('change');
		}
		
		// If text is empty, show placeholder
		if ( text == '' )
		{
			var placeholder = $this.data('editable-placeholder');
			$this.html(placeholder);
		}
		
		return $this;
	}
	
	// http://stackoverflow.com/questions/1391278/contenteditable-change-events
	// https://github.com/makesites/jquery-contenteditable/blob/master/jquery.contenteditable.js
	function change_handler( event )
	{
		var $this = $(event.currentTarget);
		//console.log( 'change_handler(): ' + $this.data('editable') );
		
		var text = $this.html();
		// Clean browser line break
		text = text.replace(/<br>$/gi, '').replace(/^\s+|\s+$/gm,'');
		// Stop if placeholder text
		var placeholder = $this.data('editable-placeholder');
		if ( text == placeholder )
		{
			return;
		}
		
		var params = $this.data('editable-params') || {};
		params.action_modifier = 'edit-in-place';
		params.field = $this.attr('property');
		params.value = $this.html();
		
		if ( params.field == 'price' )
		{
			params.value = params.value.replace(/[^\d\.]/gi, '');
			if ( ! params.value )
			{
				params.value = 0;
			}
			var price = parseFloat(params.value);
			var num_decimal_places = ( price == parseInt(price, 10) ) ? 0 : 2;
			var formatted_price = '$' + price.toFixed(num_decimal_places).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
			if ( price == 0 )
			{
				formatted_price = '&mdash;';
			}
			$this.html(formatted_price);
		}
		
		/*
		if ( params.field == 'name' )
		{
			params.value = params.value.replace(/<br>/gi, '');
		}
		
		if ( params.field == 'status' )
		{
			params.value = params.value.replace(/<br>/gi, '\n');
		}
		
		if ( params.field == 'description' )
		{
			params.value = params.value.replace(/<br>/gi, '\n');
		}
		*/
		
		// Gather request data
		var request_data = {
			action : $this.data('editable-action'),
			params : JSON.stringify(params)
		};
		// Extend with common and security data
		$.extend(true, request_data, REDLOVE.form_data, REDLOVE.security);
		//console.log(JSON.stringify(request_data));
		
		// Send request to update the field
		$.ajax({
			cache : false,
			data : request_data,
			dataType : 'json',
			timeout : 300000,
			type : 'POST',
			url : COMMON.store_api,
			
			success : function( response, text_status, jq_xhr )
			{
				// Check if no or invalid response received
				if ( ! response || typeof(response) !== 'object' )
				{
					show_message('Invalid response format.', 'error');
					return false;
				}
				
				// Normalize response code to numeric
				var success = response['code'] * 1;
				if ( success > 0 )
				{
					var data = response['value'];
					show_message(response['message'], 'success');
				}
				else
				{
					show_message(response['message'], 'error');
					return false;
				}
			},
			
			error : ajax_error_handler,
			
			beforeSend : function( jq_xhr, settings )
			{
				show_site_loading();
			},
			
			complete : function( jq_xhr, text_status )
			{
				show_site_loading(false);
			}
			
		});
		
		return $this;
	}
	
	// http://jsbin.com/owavu3/1/edit?html,js,output
	function paste_handler( event )
	{
		event.preventDefault();
		
		var $element = $(event.currentTarget);
		var element = $element[0];
		
		var html = '';//$element.html();
		
		// http://stackoverflow.com/questions/2176861/javascript-get-clipboard-data-on-paste-event-cross-browser
		// clipboardData with prompt fallback when browser doesn't support
		//var html = (event.originalEvent || event).clipboardData || prompt('Paste something..');
		
		// http://codebits.glennjones.net/editing/getclipboarddata.htm
		// http://stackoverflow.com/questions/24540765/intercept-paste-data-in-javascript
		// http://stackoverflow.com/questions/21257688/paste-rich-text-into-content-editable-div-and-only-keep-bold-and-italics-formatt
		// IE
		if ( window.clipboardData && window.clipboardData.getData )
		{
			html = window.clipboardData.getData('Text');
		}
		else if ( (event.originalEvent || event).clipboardData && (event.originalEvent || event).clipboardData.getData )
		{
			html = (event.originalEvent || event).clipboardData.getData('text/html');
		}
		else
		{
			html = prompt('Paste something..');
		}
		
		// Strip tags, multiple newlines with single, trim, and newline to <br>newline
		var cleaned_html = html.replace(/(<([^>]+)>)/ig, '\n').replace(/\n\s*\n/g, '\n').replace(/^\s+|\s+$/gm,'').replace(/\n/g, '<br>\n');
		
		$element.html(cleaned_html);
		
		/*
		// Give time for the paste to happen
		setTimeout(function()
		{
		}, 100);
		*/
		
		return $element;
	}
	
	// http://jsbin.com/owavu3/1/edit?html,js,output
	function key_listener( event )
	{
		var $element = $(event.currentTarget);
		var element = $element[0];
		
		var key_esc = ( event.which == 27 );
		var key_newline = ( event.which == 13 );
		var data = {};

		if ( key_esc )
		{
			// Restore state
			document.execCommand('undo');
			element.blur();
		}
		else if ( key_newline )
		{
			var attr = $element.data('editable-allow-newline');
			// If attribute does not exist
			if ( typeof(attr) === 'undefined' || attr === false )
			{
				// Save state
				event.preventDefault();
				element.blur();
			}
		}
		
		return $element;
	}
	
	// --------------------------------------------------------------------
	
});

// --------------------------------------------------------------------

// --------------------------------------------------------------------
// Analytics
// --------------------------------------------------------------------

jQuery(document).ready(function ( $ )
{
	// Register analytics event
	$('.analytics_event').on('click', function ()
	{
		var $this = $(this);
		var data = $this.data();
		var category = ( data.category !== undefined ) ? data.category : 'link';
		var action = ( data.action !== undefined ) ? data.action : 'click';
		var label = ( data.label !== undefined ) ? data.label : ( $this.attr('title') || $this.text() );
		var href = $this.attr('href');
		
		send_analytics_hit( href, category, action, label );
	});
});

// --------------------------------------------------------------------

// Register analytics event; work with jQuery helper on .analytics_event
function send_analytics_hit ( href, category, action, label, value )
{
	//console.log('send_analytics_hit: ' + href + ', ' + category + ', ' + action + ', ' + label + ', ' + value);
	
	// Google Analytics
	if ( window.ga )
	{
		// https://developers.google.com/analytics/devguides/collection/analyticsjs/events
		// send, event, [category], [action], [label], [value](number)
		window.ga('send', 'event', category, action, label);
		window.ga('send', 'pageview', {
			'page': href,
			'title': label
		});
	}
	
	/*
	// Lyris
	$lyris_iframe = $('#lyris_iframe');
	// Create if it doesn't exist
	if ( $lyris_iframe.length == 0 )
	{
		$lyris_iframe = $('<iframe id="lyris_iframe" src="about:blank" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" style="position:absolute;width:0;height:0;border:none;" tabindex="-1"  />').appendTo('body');
	}
	// If it exists
	if ( $lyris_iframe.length > 0 )
	{
		$lyris_iframe[0].src = REDLOVE.base_url + 'analytics/event/link/click?page=' + encodeURIComponent(href) + '&title=' + encodeURIComponent(label);
	}
	*/
}

//]]>
// --------------------------------------------------------------------
