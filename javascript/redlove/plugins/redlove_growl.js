//<![CDATA[
/**
* Create throttle and debounce processes
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_growl.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_growl.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		window['growl'] = new redlove_growl();
		growl.create('Growl message created.', 'success');
	});
</script>

* 
*/
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
		return this.init(options);
	};
	// Private variables
	var proto = Plugin.prototype;
	// Plugin properties
	proto.name = 'redlove_growl';
	proto.num_instances = 0;
	proto.default_options = {
		container_id : 'redlove_growl_container',
		fade_interval : 500,// Milliseconds
		growl_class : 'redlove_growl',
		ttl_interval : 4000,// Milliseconds
		'' : ''// Empty so each property above ends with a comma
	};
	
	// Plugin methods
	
	/**
	* Initialize plugin
	* 
	* @param mixed options Plugin options object
	* @return object Plugin instance
	*/
	proto.init = function ( options )
	{
		// Extend default options
		this.options = $.extend( {}, this.default_options, options );
		
		var self = this;
		
		$(document).ready(function($)
		{
			$(document).on('click.' + proto.name, '.' + self.options.growl_class, function ( event )
			{
				self.remove( $(this) );
			});
		});
		
		return this;
	};
	
	/**
	* Run the callback, clearing debounce and updating time last run
	* 
	* @param mixed args Passed arguments
	* @return void
	*/
	proto.create = function ( content, addon_class, ttl_interval )
	{
		var $growl_container = $('#' + this.options.container_id);
		if ( $growl_container.length == 0 )
		{
			$('body').append('<div id="'+ this.options.container_id + '"></div>');
		}
		
		var $growl = $('<div class="' + this.options.growl_class + ' ' + addon_class + '">' + content + '</div>');
		$('#' + this.options.container_id).prepend($growl);
		$growl.hide().fadeIn();
		proto.num_instances++;
		
		var self = this;
		setTimeout(
			function ()
			{
				self.remove($growl);
			},
			(ttl_interval || self.options.ttl_interval)
		);
		
		return $growl;
	};
	
	/**
	* Run the callback, clearing debounce and updating time last run
	* 
	* @param mixed args Passed arguments
	* @return void
	*/
	proto.remove = function ( $growl )
	{
		if ( $growl && $growl.length > 0 )
		{
			$growl.stop().fadeOut(this.options.fade_interval, function ()
			{
				$growl.remove();
				proto.num_instances--;
			});
		}
	};
	
	// Window plugin definition
	window[proto.name] = Plugin;
	
})( jQuery, window, document );// End function closure
//]]>