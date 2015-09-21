//<![CDATA[
/**
* Create throttle and debounce processes
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* References:
* http://benalman.com/projects/jquery-throttle-debounce-plugin/
* http://unscriptable.com/2009/03/20/debouncing-javascript-methods/
* 
* Usage:

<div id="back-to-top">
	<a href="#">^</a>
</div>

<style type="text/css">
	#back-to-top.fixed {
		bottom: 0;
		left: auto;
		position: fixed;
		right: 0;
		top: auto;
	}
</style>
<script type="text/javascript" src="javascript/redlove/plugins/redlove_throttle.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$('#return-to-top').on('click', function(event)
		{
			event.preventDefault();
			$('html,body').animate(
				{'scrollTop' : 0},
				'slow',
				function () {}
			);
		});
		
		var $window = $(window);
		var $element = $('#return-to-top');
		var scroll_target_top = 500;//$element.offset().top;
		var throttle_options = {
			debug : true,
			interval : 250,
			run_at_start : true,
			run_at_end : true,
			callback : function ( self, args )
			{
				if ( $window.scrollTop() > scroll_target_top )
				{
					$element.addClass('fixed');
				}
				else
				{
					$element.removeClass('fixed');
				}
			}
		};
		var my_throttle = new redlove_throttle(throttle_options);
		$(window).scroll(my_throttle.handler);
		
		// Create a debounce example
		$(window).scroll(new redlove_throttle({
			interval : 500,
			debounce : true,
			callback : function ( self, args )
			{
				if ( $window.scrollTop() > 200 )
				{
					console.log('monkeys');
				}
			}
		}).handler);
	});
</script>

* 
*/
;(function ( window, document, undefined )// Begin function closure; avoid collisions
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
	proto.name = 'redlove_throttle';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		callback : function(){},// Define an empty anonymous function so something exists to call
		debounce : false,
		debug : false,
		interval : 100,// Milliseconds
		run_at_start : false,
		run_at_end : true,
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
		
		// Internal properties
		this.now = 0;
		this.time_last_run = 0;
		this.debounce_timeout = null;
		
		var self = this;
		this.handler = function ()
		{
			self.now = new Date().getTime();
			
			// If running at the start and are starting
			if ( self.options.run_at_start && self.time_last_run === 0 )
			{
				if ( self.options.debug )
				{
					console.log('Throttle/Debounce: Running at start');
				}
				self.run(arguments);
			}
			
			// If debouncing, set up debounce
			if ( self.options.debounce )
			{
				self.setup_debounce(arguments);
			}
			// Else run through throttle checks
			else
			{
				// Throttle: Limit an event to run once in a period, preventing additional requests within the period
				var throttle_time_elapsed = self.now - self.time_last_run;
				if ( throttle_time_elapsed < self.options.interval )
				{
					if ( self.options.debug )
					{
						console.log('Throttle/Debounce: Throttled');
					}
					
					// If throttled, ensure event will run once at the end with the throttled difference as the interval
					if ( self.options.run_at_end )
					{
						var debounce_milliseconds = self.options.interval - throttle_time_elapsed;
						self.setup_debounce(arguments, debounce_milliseconds);
					}
					
					return;
				}
				
				// If throttling passed, run normally
				if ( self.options.debug )
				{
					console.log('Throttle/Debounce: Running normal');
				}
				self.run(arguments);
			}
		};
		
		return this;
	};
	
	/**
	* Run the callback, clearing debounce and updating time last run
	* 
	* @param mixed args Passed arguments
	* @return void
	*/
	proto.run = function ( args )
	{
		clearTimeout(this.debounce_timeout);
		this.debounce_timeout = null;// Eliminate the chance of creating concurrent timeouts
		this.time_last_run = this.now;
		this.options.callback.call(this, args);
	};
	
	/**
	* Set up the debounce to run
	* 
	* @param mixed args Passed arguments
	* @param int milliseconds The timeout milliseconds
	* @return void
	*/
	proto.setup_debounce = function ( args, milliseconds )
	{
		// Debounce: Limit an event to run once after a period, restarting the timeout if a request before the period
		clearTimeout(this.debounce_timeout);
		this.debounce_timeout = null;// Eliminate the chance of creating concurrent timeouts
		var debounce_milliseconds = ( milliseconds !== undefined ) ? milliseconds : this.options.interval;
		// Set minimum milliseconds to avoid race conditions and multiple setTimeouts
		debounce_milliseconds = ( debounce_milliseconds < 50 ) ? 50 : debounce_milliseconds;
		var self = this;
		this.debounce_timeout = setTimeout(function ()
		{
			if ( self.options.debug )
			{
				console.log('Throttle/Debounce: Running debounce');
			}
			self.run(args);
		}, debounce_milliseconds);
	};
	
	// Window plugin definition
	window[proto.name] = Plugin;
	
})( window, document );// End function closure
//]]>