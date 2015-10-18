//<![CDATA[
/**
* Show code examples
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_code_example.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_code_example.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$.fn.redlove_code_example();
	});
</script>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_code_example';
	var plugin_default_options = {
		debug : false,
		toggle_class : 'redlove_code-example_toggle',
		liner_class : 'redlove_code-example_liner',
		hover_class : 'redlove_code-example-hover',
		shown_class : 'redlove_code-example-shown',
		'' : ''// Empty so each property above ends with a comma
	};
	
	// jQuery plugin definition
	
	/**
	* jQuery plugin constructor
	* 
	* @param mixed options Plugin options object
	* @return object jQuery object
	*/
	$.fn[plugin_name] = function ( options )
	{
		options = $.extend( {}, plugin_default_options, options );
		
		$('.' + options.toggle_class)
		.on('click', function(event)
		{
			event.preventDefault();
			
			var $toggle = $(this);
			if ( $toggle.data('is_hover') )
			{
				$toggle.data('is_hover', false);
				return;
			}
			
			toggle_example($toggle);
		})
		.on('mouseenter', function(event)
		{
			var $toggle = $(this);
			var $example = $toggle.parent();
			$example.addClass(options.hover_class);
			
			var is_shown = $example.hasClass(options.shown_class);
			if ( ! is_shown )
			{
				$toggle.data('is_hover', true);
				toggle_example(this);
			}
			
		})
		.on('mouseleave', function(event)
		{
			var $toggle = $(this);
			if ( $toggle.data('is_hover') )
			{
				toggle_example(this);
			}
			
			var $example = $toggle.parent();
			$example.removeClass(options.hover_class);
		});
		
		function toggle_example ( toggle )
		{
			var $toggle = $(toggle);
			var $example = $toggle.parent();
			var example = $example[0];
			var $example_liner = $example.find('.' + options.liner_class);
			var example_liner = $example_liner[0];
			var is_shown = $example.hasClass(options.shown_class);
			
			var text = example_liner.innerHTML;
			var stored_text = $example.data('text');
			if ( stored_text === undefined )
			{
				stored_text = '<pre>' + REDLOVE.fn.encode_html_entities(REDLOVE.fn.trim(text)) + '</pre>';
			}
			
			var height = is_shown ? '' : $example_liner.outerHeight();
			$example_liner.css('height', height);
			
			$example_liner.html(stored_text);
			$example.data('text', text).toggleClass(options.shown_class);
		}
	};
	
})( jQuery, window, document );// End function closure
//]]>