//<![CDATA[
/**
* Track page scroll, coordinating anchor links in nav with area ids matching hashes
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<ul id="stickynav">
	<li><a href="#section-1">Section 1</a></li>
	<li><a href="#section-2">Section 2</a></li>
	<li><a href="#section-3">Section 3</a></li>
</ul>
<div id="section-1">
	<h1>Test content</h1>
	<p>This is some test content!</p>
</div>
<div id="section-2">
	<h1>Test content</h1>
	<p>This is some test content!</p>
</div>
<div id="section-3">
	<h1>Test content</h1>
	<p>This is some test content!</p>
</div>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_stickynav.css" media="all">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_stickynav.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$('#stickynav').redlove_stickynav({
			trigger_offset : 0.4,
			offset : $('#sticky_nav').outerHeight()
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
		var Plugin = function ()
		{
			proto.num_instances++;
			this.init.apply(this, arguments);
			return this;
		};
		// Private variables
		var proto = Plugin.prototype;
		// Plugin properties
		proto.name = 'redlove_stickynav';
		proto.data_key = proto.name;
		proto.num_instances = 0;
		proto.default_options = {
			active_class : 'active',
			debug : false,
			in_view : function(){},// Define an empty anonymous function so something exists to call
			offset : 0,
			out_view : function(){},// Define an empty anonymous function so something exists to call
			smooth_scroll : true,
			smooth_scroll_time : 500,
			throttle : 100,
			trigger_offset : null,//0.0 - 1.0 fraction of window height; 0.0 = top, 0.5 = half
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
			inst.$window = $(window);
			inst.$document = $(document);
			inst.scroll_targets = [];
			inst.trigger_offset = 0;
			
			// Plugin implementation code
			inst.update();
			
			// Use timeout to help with responsiveness and not fire before DOM resizes
			inst.update_timeout = null;
			// Update on page load
			inst.$window.one('load.' + proto.name, function ( event )
			{
				if ( inst.update_timeout )
				{
					clearTimeout(inst.update_timeout);
					inst.update_timeout = null;// Eliminate the chance of creating concurrent timeouts
				}
				inst.update_timeout = setTimeout(function(){inst.update();}, 100);
			});
			// Update on page resize
			inst.$window.bind('resize.' + proto.name, function ( event )
			{
				if ( inst.update_timeout )
				{
					clearTimeout(inst.update_timeout);
					inst.update_timeout = null;// Eliminate the chance of creating concurrent timeouts
				}
				inst.update_timeout = setTimeout(function(){inst.update();}, 100);
			});
			
			var throttle_options = {
				interval : inst.options.throttle,
				run_at_start : true,
				run_at_end : true,
				callback : function ()
				{
					inst.check_scroll();
				}
			};
			inst.throttle = new redlove_throttle(throttle_options);
			inst.$window.bind('scroll.' + proto.name, inst.throttle.handler);
		};
		
		/**
		* Update the plugin
		* 
		* @return void
		*/
		proto.update = function ()
		{
			var inst = this;
			
			if ( inst.options.debug )
			{
				console.log(proto.name + ' update()');
			}
			
			// Update dimensions and positioning
			inst.document_height = inst.$document.height();
			inst.window_height = inst.$window.height();
			inst.scroll_top_last = inst.$window.scrollTop();
			
			inst.trigger_offset = inst.options.offset;
			if ( inst.options.trigger_offset !== null )
			{
				if ( inst.options.trigger_offset <= 1 )
				{
					inst.trigger_offset = inst.window_height * inst.options.trigger_offset;
				}
				else
				{
					inst.trigger_offset = inst.options.trigger_offset;
				}
			}
			
			// Gather scroll targets
			var scroll_targets = [];
			var $targets = inst.$element.find('a[href^="#"]');
			$targets.each(function ( index, el )
			{
				// Get anchor hash
				var hash = el.hash.replace('#', '');
				
				// Get position of each target
				var $target = $('#' + hash);
				if ( $target.length == 0 )
				{
					return;
				}
				
				// Add scroll target
				scroll_targets.push({
					el : el,
					hash : hash,
					top : $target.offset().top,
					bottom : inst.document_height
				});
				var cur_index = scroll_targets.length - 1;
				var prev_index = scroll_targets.length - 2;
				
				// Adjust top
				//scroll_targets[cur_index].top -= inst.options.offset;
				scroll_targets[cur_index].top = Math.round( scroll_targets[cur_index].top );
				
				// Adjust bottom
				if ( scroll_targets.length > 1 )
				{
					scroll_targets[prev_index].bottom = scroll_targets[cur_index].top - 0.01;
				}
				//scroll_targets[cur_index].bottom -= inst.options.offset;
				scroll_targets[cur_index].bottom = Math.round( scroll_targets[cur_index].bottom );
			});
			inst.scroll_targets = scroll_targets;
			
			// Set up smooth scrolling
			if ( inst.options.smooth_scroll )
			{
				var selector = 'click.' + proto.name + ' vclick.' + proto.name;
				inst.$element.find('a[href^="#"]')
				.unbind(selector)
				.bind(selector, function ( event )
				{
					event.preventDefault();
					event.stopImmediatePropagation();
					
					var hash = this.hash.replace('#', '');
					var $target = $('#' + hash);
					if ( $target.length > 0 )
					{
						var target_top = Math.ceil( $target.offset().top - inst.options.offset );
						$('html,body').animate(
							{
								scrollTop : target_top
							},
							inst.options.smooth_scroll_time,
							function ()
							{
								// Make sure last scroll is checked
								inst.check_scroll();
							}
						);
					}
					
					return false;
				});
			}
			
			// Run at start
			inst.check_scroll();
		};
		
		/**
		* Check scroll
		* 
		* @return void
		*/
		proto.check_scroll = function ()
		{
			// Avoid window scroll objects coming through
			if ( this == window)
			{
				return;
			}
			
			var inst = this;
			
			// Get scroll position and direction
			var scroll_top = inst.$window.scrollTop();
			var delta_v = ( scroll_top > inst.scroll_top_last ) ? 1 : -1;
			inst.scroll_top_last = scroll_top;
			
			// Check scroll position
			var trigger = scroll_top + inst.trigger_offset;
			var scroll_targets = inst.scroll_targets;
			for ( var index = 0; index < scroll_targets.length; index++ )
			{
				if ( inst.options.debug )
				{
					console.log(
						'index: ' + index + 
						'trigger: ' + trigger + 
						' scroll_top: ' + scroll_top + 
						' scroll_targets[index].top: ' + scroll_targets[index].top + 
						' scroll_targets[index].bottom: ' + scroll_targets[index].bottom
					);
				}
				
				if ( trigger >= scroll_targets[index].top && trigger <= scroll_targets[index].bottom )
				{
					// If already active, stop iterating
					if ( $(scroll_targets[index].el).parent().hasClass(inst.options.active_class) )
					{
						break;
					}
					
					$(scroll_targets[index].el).parent().addClass(inst.options.active_class);
					inst.options.in_view.call(inst);
				}
				else
				{
					$(scroll_targets[index].el).parent().removeClass(inst.options.active_class);
					inst.options.out_view.call(inst);
				}
			}
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
		
	})( jQuery, window, document );// End function closure
})();// End function closure
//]]>