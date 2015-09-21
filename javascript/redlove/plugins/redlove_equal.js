/**
* Equal dimensions plugin
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<div class="redlove_demo_equal-column" style="background: red; display: inline-block; height: 50px; width: 50px;"></div>
<div class="redlove_demo_equal-column" style="background: green; display: inline-block; height: 100px; width: 100px;"></div>
<div class="redlove_demo_equal-column" style="background: blue; display: inline-block; height: 75px; width: 75px;"></div>
<br>
<a href="#" onclick="$('.redlove_demo_equal-column').redlove_equal();return false;">Equal heights</a>
<a href="#" onclick="$('.redlove_demo_equal-column').redlove_equal({dimension : 'width'});return false;">Equal widths</a>

<script type="text/javascript" src="scripts/redlove/plugins/redlove_equal.js"></script>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_max';
	var plugin_default_options = {
		dimension : 'height',
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
		// Extend default options
		options = $.extend( {}, plugin_default_options, options );
		
		// Get max dimension
		var max = 0;
		
		// Plugin code for each element
		this.each(function ( index )
		{
			var dimension = options.dimension == 'width' ? $(this).outerWidth(true) : $(this).outerHeight(true);
			max = Math.max(max, dimension);
		});
		
		return max;
	};
	
	// ------------------------------------------------------------
	
	// Private variables
	var plugin_name = 'redlove_equal';
	var plugin_default_options = {
		dimension : 'height',
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
		// Extend default options
		options = $.extend( {}, plugin_default_options, options );
		
		// Get max dimension
		var max = $(this).redlove_max(options);
		
		// Plugin code for each element
		return this.each(function ( index )
		{
			var css = {};
			css['min-' + options.dimension] = max + 'px';
			$(this).css(css);
		});
	};
	
})( jQuery, window, document );// End function closure
