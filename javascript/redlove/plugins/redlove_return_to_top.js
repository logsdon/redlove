//<![CDATA[
/**
* Show "return to top" indicator when scrolling past window height
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_return_to_top.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_return_to_top.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$.fn.redlove_return_to_top();
	});
</script>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_return_to_top';
	var plugin_default_options = {
		debug : false,
		element_id : 'redlove_return-to-top',
		offset : undefined,
		return_interval : 'slow',
		return_offset : 0,
		scrolled_class : 'fixed',
		throttle_interval : 250,
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
		
		var $element = $('#' + options.element_id);
		if ( $element.length > 0 )
		{
			return this;
		}
		$element = $('<div id="' + options.element_id + '"><a href="#"></a></div>').appendTo('body');
		
		$element.on('click', function(event)
		{
			event.preventDefault();
			$('html,body').animate({'scrollTop' : options.return_offset}, options.return_interval, function(){});
		});
		
		var $window = $(window);
		var $document = $(document);
		var scroll_target_top = ( options.offset === undefined ) ? $window.height() / 2 : options.offset;//$element.offset().top
		
		var throttle_options = {
			debug : options.debug,
			interval : options.throttle_interval,
			run_at_start : true,
			run_at_end : true,
			callback : function ( self, args )
			{
				if ( $window.scrollTop() > scroll_target_top )
				{
					$element.addClass(options.scrolled_class);
				}
				else
				{
					$element.removeClass(options.scrolled_class);
				}
			}
		};
		var throttle = new redlove_throttle(throttle_options);
		throttle.handler();
		$window.scroll(throttle.handler);
	};
	
})( jQuery, window, document );// End function closure
//]]>