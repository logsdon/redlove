//<![CDATA[
/**
* Adjust text size to fill a container with text
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<div class="screen">

	<div id="quotes">
		<blockquote>
			<p></p>
			<cite></cite>
		</blockquote>
	</div>
	
	<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="[Background image]" class="fullscreen-background bg-top">
	<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="[Background image]" class="fullscreen-background bg-bottom">
	
	<div class="scroll-to-next"></div>

</div>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_tabs.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_tabs.js"></script>
<style type="text/css">
	#quotes * {
		color: #ffffff;
		text-shadow: 0 0 0.125em rgba(0, 0, 0, 0.6);
	}
	#quotes {
		font-family: Vollkorn;
		left: 50%;
		padding: 5.0em 4.0em 4.0em;
		position: absolute;
		text-align: center;
		top: 50%;
		
		-webkit-transform: translate(-50%, -50%);
		-moz-transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		
		width: 80%;
	}
	#quotes p {
		line-height: 1.0;
		margin: 0;
	}
	#quotes cite {
		display: block;
		font-size: 2.0em;
		font-style: italic;
		text-align: right;
	}
	#quotes cite:before {
		content: "\2014  ";
	}
	#quotes cite a {
		text-decoration: none;
	}

	.scroll-to-next {
		bottom: 0;
		font-size: 4.0em;
		left: 50%;
		line-height: 1.0;
		position: absolute;
		top: auto;
		
		//
		-webkit-transform: translateX(-50%);
		-moz-transform: translateX(-50%);
		-ms-transform: translateX(-50%);
		-o-transform: translateX(-50%);
		transform: translateX(-50%);
	}
	.scroll-to-next:after {
		content: "\f107";
		cursor: pointer;
		font-family: FontAwesome;
		opacity: 0.5;
		text-shadow: 0 0.125em 8px rgba(0, 0, 0, 0.8);
		
		-webkit-transition: all 0.4s ease-in-out 0.0s;
		-moz-transition: all 0.4s ease-in-out 0.0s;
		-ms-transition: all 0.4s ease-in-out 0.0s;
		-o-transition: all 0.4s ease-in-out 0.0s;
		transition: all 0.4s ease-in-out 0.0s;
	}
	.scroll-to-next:hover:after {
		opacity: 1.0;
		text-shadow: none;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function ( $ )
	{
		$('#quotes blockquote p').redlove_fit_text({
			container : '#quotes',
			fill : window,
			max : 90
		});
	});
</script>

* 
*/
;(function ()// Begin function closure; avoid collisions
{
	// If objects do not exist, check again shortly
	if ( typeof(jQuery) === 'undefined' )
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
			proto.num_instances++;
			this.init.apply(this, arguments);
			return this;
		};
		// Private variables
		var proto = Plugin.prototype;
		// Plugin properties
		proto.name = 'redlove_fit_text';
		proto.namespace = '.' + proto.name;
		proto.data_key = proto.name;
		proto.num_instances = 0;
		proto.default_options = {
			container : '',
			debug : false,
			fill : '',
			max : 120,
			min : 5,
			throttle_milliseconds : 250,// Milliseconds
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
			
			// Plugin properties
			inst.namespace = proto.namespace + '.' + proto.num_instances;
			
			inst.throttle_time_last = 0;
			inst.debounce_timeout;
			
			inst.$window = $(window);
			
			// Plugin implementation code
			
			inst.$window
			.one('load' + inst.namespace, function ( event )
			{
				inst.update(event);
			})
			.on('resize' + inst.namespace, function ( event )
			{
				inst.update(event);
			});
			
			inst.update();
			
			return inst;
		};
		
		/**
		* Update plugin
		* 
		* @param object event Passed event
		* @return object Plugin instance
		*/
		proto.update = function ( event )
		{
			var inst = this;
			
			// Throttle (ensures 1 action during interval) and Debounce (ensures 1 action after interval)
			var now = new Date().getTime();
			var throttle_time_elapsed = now - inst.throttle_time_last;
			
			// Throttle: If request time is too soon since last request
			if ( throttle_time_elapsed < inst.options.throttle_milliseconds )
			{
				// Debounce: Reset timeout for delayed event to run when requests stop
				clearTimeout(inst.debounce_timeout);
				inst.debounce_timeout = null;// Eliminate the chance of creating concurrent timeouts
				// Set minimum milliseconds to avoid race conditions and multiple setTimeouts
				var debounce_milliseconds = inst.options.throttle_milliseconds - throttle_time_elapsed;
				debounce_milliseconds = ( debounce_milliseconds < 100 ) ? 100 : debounce_milliseconds;
				inst.debounce_timeout = setTimeout(function ()
				{
					inst.update();
				}, debounce_milliseconds);
				
				return;
			}
			inst.throttle_time_last = now;
			
			// Actual code implementation
			
			inst.scale_text(inst.$element, inst.options.container, inst.options.fill, inst.options.max, inst.options.min);
			
			return inst;
		};
		
		/**
		* Scale text for its container to fill an element
		* 
		* @param mixed text_element The actual text element to change font size, like <p>
		* @param mixed text_container_element The container the text is in that will scale with the text, like <div>
		* @param mixed fill_element The element to try to fill, like window
		* @param mixed max_font_size Maximum font size
		* @param mixed min_font_size Minimum font size
		* @return void
		*/
		proto.scale_text = function ( text_element, text_container_element, fill_element, max_font_size, min_font_size )
		{
			var inst = this;
			
			max_font_size = ( typeof(max_font_size) !== 'undefined' ) ? max_font_size : inst.options.max;
			min_font_size = ( typeof(min_font_size) !== 'undefined' ) ? min_font_size : inst.options.min;
			
			// Make quote text fit within half the browser area
			var $text_element = $(text_element);
			var $text_container_element = ( typeof(text_container_element) !== 'undefined' ) ? $(text_container_element) : $text_element;
			var $fill_element = ( typeof(text_container_element) !== 'undefined' ) ? $(fill_element) : inst.$window;
			var fill_element_height = $fill_element.outerHeight();
			
			var font_size_start = parseFloat($text_element.css('font-size'));
			$text_element.css('font-size', min_font_size);
			var text_container_element_height = $text_element.outerHeight();
			var text_container_element_height_previous;
			
			var font_size = min_font_size;
			var font_size_previous;
			var increment = 20;
			
			while ( text_container_element_height < fill_element_height && font_size <= max_font_size )
			{
				font_size_previous = font_size;
				text_container_element_height_previous = text_container_element_height;
				
				font_size += increment;
				$text_element.css('font-size', font_size);
				text_container_element_height = $text_container_element.outerHeight();
				
				if ( inst.options.debug )
				{
					console.log('text_container_element_height: ' + text_container_element_height + ' fill_element_height: ' + fill_element_height + ' font_size: ' + font_size + ' font_size_previous: ' + font_size_previous);
				}
				
				if ( text_container_element_height > fill_element_height )
				{
					if ( inst.options.debug )
					{
						console.log('too much at ' + font_size + ' go back to ' + font_size_previous + ' increment ' + increment);
					}
					
					font_size = font_size_previous;
					text_container_element_height = text_container_element_height_previous;
					$text_element.css('font-size', font_size);
					
					if ( increment > 1 )
					{
						increment = Math.floor(increment / 2);
						continue;
					}
					
					break;
				}
			}
			
			if ( inst.options.debug )
			{
				console.log('Starting font-size: ' + font_size_start + ' Stopping font-size: ' + font_size_previous + ' text_container_element_height: ' + text_container_element_height + ' fill_element_height: ' + fill_element_height);
			}
		}
		
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