//<![CDATA[
/**
* Preload images, performing actions after
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<script type="text/javascript" src="javascript/redlove/plugins/redlove_preload_images.js"></script>

$('#cards_pool img').redlove_preload_images({
	oncomplete : function ( num_preloaded_images )
	{
		preload_complete = true;
		show_loading(false);
		$start_panel.show();
	}
});

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_preload_images';
	var plugin_default_options = {
		oncomplete : function(){},// Define an empty anonymous function so something exists to call
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
		
		// Private variables
		var $this = $(this);
		var num_preloaded_images = 0;
		
		// Private methods
		
		/**
		* Check if all images are loaded
		* 
		* @return void
		*/
		function check_load_complete ()
		{
			if ( $this.length == num_preloaded_images )
			{
				options.oncomplete(num_preloaded_images);
			}
		}
		
		// Plugin code for each element
		return this.each(function ( index )
		{
			// Plugin implementation
			var $img = $(this).filter('img');
			if ( $img.length == 0 )
			{
				check_load_complete();
			}
			// Attach onload before setting src
			$img
			.on({
				load: function ( event )
				{
					num_preloaded_images++;
					$img.off(event.type);
					check_load_complete();
				},
				error: function ( event )
				{
					num_preloaded_images++;
					$img.off(event.type);
					check_load_complete();
				}
			});
			
			// Wait for images to load
			// Cached images do not fire load sometimes, so we reset src
			// $image.load(function(){ something(); }).attr('src', $image.attr('src'));
			// if (this.complete || this.complete === undefined) this.src = this.src;
			if ( this.complete )
			{
				$img.trigger('load');
			}
			else
			{
				this.src = this.src;
			}
		});
	};
	
})( jQuery, window, document );// End function closure
//]]>