//<![CDATA[
/**
* Toggle input value on blur and focus
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<script type="text/javascript" src="javascript/redlove/plugins/redlove_toggle_value.js"></script>
<script type="text/javascript">//<!--
jQuery(document).ready(function($){

	$('.toggle-value').redlove_toggle_value();
	$('#zip_2').redlove_toggle_value({
		default_value : 'Default Value',
		sticky : true,
		blur_class : 'blur',
		focus_class : 'focus'
	});
	
});
//--></script>
<style type="text/css">
.blur {
	color: #999999;
	font-style: italic;
}
</style>
<input type="text" class="toggle-value" name="zip_1" value="" title="Zip Code">
<input type="text" id="zip_2" name="zip_2" value="">
<input type="text" class="toggle-value" name="input_search" value="" data-toggle-default="Search">

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_toggle_value';
	var plugin_default_options = {
		blur_class : '',
		debug : false,
		default_value : undefined,
		focus_class : '',
		sticky : true,
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
		
		// Plugin implementation code
		// Plugin code for each element
		return this.each(function ( index )
		{
			var $input = $(this);
			// Default to title attribute if no default value
			var default_value = $input.data('toggle-default') || options.default_value || $input.attr('title') || $input.attr('placeholder') || '';
			
			// If the value is blank, use the default
			if ( $input.val() === '' )
			{
				$input.val( default_value ).addClass(options.blur_class);
			}
			
			// Combine classes for toggling, removing spaces in case either is blank
			//var blur_and_focus_classes = (options.blur_class +' '+ options.focus_class).replace(/^\s\s*/, '').replace(/\s\s*$/, '');
			
			// Handle the focus and blur of the input element
			$input
			.on('focus', function ()
			{
				if ( $input.val() === default_value )
				{
					$input.val('')
					.removeClass(options.blur_class)
					.addClass(options.focus_class);
				}
			})
			.on('blur', function ()
			{
				if ( options.sticky && $input.val() === '' )
				{
					$input.val(default_value)
					.removeClass(options.focus_class)
					.addClass(options.blur_class);
				}
			});
		});
	};
	
})( jQuery, window, document );// End function closure
//]]>