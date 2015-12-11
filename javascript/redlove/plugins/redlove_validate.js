//<![CDATA[
/**
* Form validation
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_validate.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_validate.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{

		// Handle form submission
		$('#register-section form').bind('submit', function ( event )
		{
			event.preventDefault();
			
			var $form = $(this);
			
			// If validating the form for a new user
			if ( ! $('body').hasClass('returning-user') )
			{
				var validate_options = {
					fields : {
						'input[name="last_name"]' : {
							rules : 'required',
							message : 'Please enter your Last Name.'
						},
						'input[name="first_name"]' : {
							rules : 'required',
							message : 'Please enter your First Name.'
						},
						'input[name="address"]' : {
							rules : 'required',
							message : 'Please enter your Address.'
						},
						'input[name="zip"]' : {
							rules : 'required',
							message : 'Please enter your Zip Code.'
						},
						'input[name="city"]' : {
							rules : 'required',
							message : 'Please enter your City.'
						},
						'select[name="state"]' : {
							rules : 'required',
							message : 'Please enter your State.'
						},
						'input[name="country"]' : {
							rules : 'required',
							message : 'Please enter your Country.'
						},
						'input[name="email"]' : {
							rules : 'valid_email',
							message : 'Please enter an email address.',
							messages : {
								valid_email : 'Please enter a valid email address.'
							}
						},
						'input[name="confirm_email"]' : {
							rules : 'matches[input[name="email"]]',
							message : 'Please confirm a valid email address.'
						}
					}
				};
				var validation = $form.redlove_validate(validate_options);
				
				// If invalid, stop
				if ( ! validation.valid )
				{
					$('html,body').animate({'scrollTop' : $('#register-section').offset().top}, 500, function(){});
					return false;
				}
			}
			
			// Submit valid form
			
			alert('handle form submission');
			
			$('html,body').animate({'scrollTop' : $('#content').offset().top}, 500, function(){});
			
			toggle_email_section(false);
			
			$form.find('.error, .valid').removeClass('error valid').end()
			.find('.validation-label').empty().end()
			.get(0).reset();
		});
		
	});
</script>

<style type="text/css">

#consumer_support #content form .validation-mark {
	display: none;
	position: relative;
	top: -3.4em;
}
#consumer_support #content form .validation-mark.error,
#consumer_support #content form .validation-mark.valid {
	display: block;
	vertical-align: top;
}
#consumer_support #content form .validation-mark.error:after,
#consumer_support #content form .validation-mark.valid:after {
	color: #ffffff;
	content: "";
	display: inline-block;
	font-family: FontAwesome;
	font-size: 2.0em;
	left: auto;
	line-height: 1.0;
	padding: 0.35em 0.4em;
	pointer-events: none;
	position: absolute;
	right: 0;
	top: auto;
}
#consumer_support #content form .validation-mark.error:after {
	background-color: #dd0000;
	content: "\f00d";
}
#consumer_support #content form .validation-mark.valid:after {
	background-color: #0ea4da;
	content: "\f00c";
}

#consumer_support #content form .validation-label {
	display: none;
}
#consumer_support #content form .validation-label.error,
#consumer_support #content form .validation-label.valid {
	display: block;
	font-family: 'DINWebRegular',Arial,sans-serif;
	font-size: 1.3em;
	margin: 0.25em 0 0;
	position: absolute;
	left: 0;
}
#consumer_support #content form .validation-label.error {
	color: #dd0000;
}
#consumer_support #content form .validation-label.valid {
	display: none;
}

</style>

* 
*/
;(function ()// Begin function closure; avoid collisions
{
	// If objects do not exist, check again shortly
	if ( typeof jQuery === 'undefined' )
	{
		return setTimeout(arguments.callee, 250);
	}
	
	;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
	{
		/**
		* Plugin constructor
		* 
		* @param mixed ... Accept any incoming arguments
		* @return object Plugin instance
		*/
		var Plugin = function ( options )
		{
			this.init.apply(this, arguments);
			return this;
		};
		// Private variables
		var proto = Plugin.prototype;
		// Plugin properties
		proto.name = 'redlove_validate';
		proto.data_key = proto.name;
		proto.default_options = {
			'' : ''// Empty so each property above ends with a comma
		};
		
		// Plugin methods
		
		/**
		* Initialize plugin
		* 
		* @param mixed el DOM element
		* @param mixed options Plugin options object
		* @return object Plugin instance
		*/
		proto.init = function ( el, options )
		{
			var inst = this;
			inst.element = el;
			inst.$element = $(el);
			inst.options = options;
			
			// Extend default options
			inst.metadata = {};//inst.$element.data('plugin-options');//$(element).data();
			inst.options = $.extend( {}, inst.default_options, inst.options, inst.metadata );
			
			return inst.validate_form(inst.$element, inst.options);
		};
		
		/**
		* Validate a form
		* 
		* @param object $form Form element
		* @param mixed args Passed arguments
		* @return object
		*/
		proto.validate_form = function ( $form, options )
		{
			var inst = this;
			
			/*
			var fields = {
				'input[name="email"]' : {
					rules : 'required,valid_email',
					message : 'Please enter an email address.',
					messages : {
						valid_email : 'Please enter a valid email address.'
					}
				},
				'input[name="confirm_email"]' : {
					rules : 'matches[input[name="email"]]',
					message : 'Please confirm a valid email address.'
				}
			};
			var form_valid = validate_form($form, fields);
			*/
			
			var default_options = {
				validation_mark_class : 'validation-mark',
				validation_mark_open : '<span>',
				validation_mark_close : '</span>',
				validation_label_class : 'validation-label',
				validation_label_open : '<label>',
				validation_label_close : '</label>',
				
				do_field_events : true,
				setup_field_events : function ( $form, $field, field, validate_info )
				{
					var my_obj = {
						fields : {}
					};
					my_obj.fields[field] = $.extend(true, {}, validate_info);
					
					$field
					.unbind('keyup change')
					// Use function factory to close scope
					.bind('keyup change', function ( $form, my_obj )
					{
						return function ( event )
						{
							inst.validate_form($form, my_obj);
						}
					}($form, my_obj));
				},
				field_error_class : 'error',
				field_valid_class : 'valid',
				fields : {},
				field_handler : function ( args )
				{
					if ( args.$field.parent().hasClass('select-wrapper') )
					{
						args.$field = args.$field.parent();
					}
					
					var field_class = args.field_valid ? args.options.field_valid_class : args.options.field_error_class;
					var field_validation_classes = [args.options.field_error_class, args.options.field_valid_class].join(' ');
					var validation_siblings = '.' + [args.options.validation_mark_class, args.options.validation_label_class].join(', .');
					
					args.$field
					.removeClass(field_validation_classes)
					.addClass(field_class)
					.siblings(validation_siblings)
					.removeClass(field_validation_classes)
					.addClass(field_class)
					.filter('.' + args.options.validation_label_class)
					.html(args.field_messages.join(" \n"));
				},
				'' : ''// Empty so each property above ends with a comma
			};
			options = $.extend( {}, default_options, options );
			
			var form_valid = true;
			var form_messages = [];
			var form_field_map = {};
			
			for ( var field in options.fields )
			{
				// Ensure we are not looking at inherited properties
				if ( ! options.fields.hasOwnProperty(field) )
				{
					break;
				}
				
				var field_valid = true;
				var field_messages = [];
				
				var validate_info = options.fields[field];
				// Break out multiple rules
				var rules = validate_info.rules.split(',');
				
				for ( var rule_i in rules )
				{
					// Trim whitespace
					rule_i = String(rule_i).replace(/^\s+/, '').replace(/\s+$/, '');
					
					// Ensure we are not looking at inherited properties
					if ( ! rules.hasOwnProperty(rule_i) )
					{
						break;
					}
					
					// Parse out any options in square brackets following the rule name
					var raw_rule = rules[rule_i];
					var rule_array = raw_rule.match(/([^\[]+)\[?(.*)\]$/i);
					/*
					console.log('matches[input[name="email"]]'.match(/([^\[]+)\[?(.*)\]$/i));
					console.log('matches[.this-is-a-test]'.match(/([^\[]+)\[?(.*)\]$/i));
					console.log('matches[dougnuts[animals[]]]'.match(/([^\[]+)\[?(.*)\]$/i));
					*/
					
					var rule = ( rule_array !== null && rule_array.length > 1 ) ? rule_array[1] : raw_rule;
					var rule_options = ( rule_array !== null && rule_array.length > 2 ) ? rule_array[2] : '';
					
					var $field = $form.find(field);
					
					// Check required
					if ( rule == 'required' )
					{
						if ( $field.val() === '' || $field.val() === undefined )
						{
							field_valid = false;
						}
					}
					
					// Check matching fields
					else if ( rule == 'matches' )
					{
						var $field_match = $form.find(rule_options);
						if ( $field.val() !== $field_match.val() )
						{
							field_valid = false;
						}
					}
					
					// Check validation function
					else if ( typeof proto.validation_methods[rule] !== 'undefined' )
					{
						if ( ! proto.validation_methods[rule]($field.val(), rule_options) )
						{
							field_valid = false;
						}
					}
					
					// Set common invalid field variables
					if ( ! field_valid )
					{
						form_valid = false;
						var message = proto.get_message(validate_info, field, raw_rule);
						form_field_map[field] = message;
						form_messages.push(message);
						field_messages.push(message);
					}
					
				}
				
				// Place handlers on invalid fields to validate input
				if ( options.do_field_events && ! field_valid )
				{
					options.setup_field_events($form, $field, field, validate_info);
				}
				
				// Handle field validity
				options.field_handler({
					$form : $form,
					$field : $field,
					field : field,
					validate_info : validate_info,
					field_valid : field_valid,
					field_messages : field_messages,
					options : options
				});
			}
			
			return {
				valid : form_valid,
				messages : form_messages,
				field_map : form_field_map,
			};
		};
		
		/**
		* Get message
		* 
		* @param mixed validate_info Validation information object
		* @param string field Field selector/key
		* @param string rule Full rule being used
		* @return string
		*/
		proto.get_message = function ( validate_info, field, rule )
		{
			var message = '';
			
			if ( typeof validate_info.messages !== 'undefined' && typeof validate_info.messages[rule] !== 'undefined' )
			{
				message = validate_info.messages[rule];
			}
			else if ( typeof validate_info.message !== undefined )
			{
				message = validate_info.message;
			}
			
			return message;
		};
		
		/**
		* Validation methods
		* 
		* @return void
		*/
		proto.validation_methods = {
			valid_required : function( string )
			{
				return (string != '' || string.length > 0);
			},
			valid_max_length : function( string, max )
			{
				max = max || 3;
				return (max.length > parseFloat(max));
			},
			valid_min_length : function( string, min )
			{
				min = min || 3;
				return (min.length < parseFloat(min));
			},
			//http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
			valid_email : function( string )
			{
				//var email_reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var email_reg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				return (string.length > 0 && email_reg.test(string));
			},
			//http://stackoverflow.com/questions/123559/a-comprehensive-regex-for-phone-number-validation
			valid_phone : function( string )
			{
				var phone_reg = /^[0-9\(\)\/\+ \-\.ext]*\d$/;// /^[\d\+\-\.\(\)x ]+$/ // /^[0-9\(\)\/\+ \-\.ext]*\d$/
				return (string.length > 0 && phone_reg.test(string));
			},
			valid_zip : function( string )
			{
				var zip_reg = /^[0-9]{5}(?:-[0-9]{4})?$/;
				return (string.length > 0 && zip_reg.test(string));
			},
			
			'' : ''
		};
		
		// jQuery plugin definition
		
		/**
		* jQuery plugin constructor
		* 
		* @param mixed options Plugin options object
		* @return object jQuery object
		*/
		$.fn[proto.name] = function ( options )
		{
			// Plugin code for each element
			return this.each(function ( index )
			{
				// If plugin data doesn't exist, create new plugin; else re-initialize
				var plugin_inst = $.data(this, proto.data_key);
				if ( ! plugin_inst )
				{
					plugin_inst = new Plugin(this, options);
					$.data(this, proto.data_key, plugin_inst);
				}
				else
				{
					plugin_inst.init(this, options);
				}
			});
		};
		
		// Window plugin definition
		
		window[proto.name] = Plugin;
		
	})( jQuery, window, document );// End function closure
})();// End function closure
//]]>