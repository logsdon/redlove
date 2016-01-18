//<![CDATA[
/**
* Set element positioning on scroll position
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<div id="affix-me">
	<h1>Test content</h1>
	<p>This is some test content!</p>
</div>

<style type="text/css">
	.redlove_affixed {
		left: 0;
		position: fixed;
		top: 0;
		z-index: 2;
	}
</style>
<script type="text/javascript" src="javascript/redlove/plugins/redlove_affix.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$('#affix-me').redlove_affix({offset : 20});
	});
</script>

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
		var Plugin = function ()
		{
			proto.num_instances++;
			this.init.apply(this, arguments);
			return this;
		};
		// Private variables
		var proto = Plugin.prototype;
		// Plugin properties
		proto.name = 'redlove_affix';
		proto.data_key = proto.name;
		proto.num_instances = 0;
		proto.default_options = {
			affixed_class : 'redlove_affixed',
			debug : false,
			offset : 0,
			placeholder_class : 'redlove_affix_placeholder',
			throttle : 100,
			trigger_offset : null,//0.0 - 1.0 fraction of window height; 0.0 = top, 0.5 = half
			trigger_window_fraction : 0.0,//0.0 - 1.0 fraction of window height; 0.0 = top, 0.5 = half
			until : null,
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
		* @return object Plugin instance
		*/
		proto.update = function ()
		{
			var inst = this;
			
			if ( inst.options.debug )
			{
				console.log(proto.name + ' update()');
			}
			
			// Update dimensions and positioning
			inst.window_height = inst.$window.height();
			inst.scroll_top_last = inst.$window.scrollTop();
			inst.document_height = inst.$document.height();
			
			inst.start_left = inst.$element.css('left');
			inst.start_position = inst.$element.css('position');
			inst.start_right = inst.$element.css('right');
			inst.start_top = inst.$element.css('top');
			inst.start_bottom = inst.$element.css('bottom');
			inst.element_height = inst.$element.outerHeight();
			
			var has_class = inst.$element.hasClass(inst.options.affixed_class);
			inst.$element.removeClass(inst.options.affixed_class);
			inst.start_offset = inst.$element.offset();
			if ( has_class )
			{
				inst.$element.addClass(inst.options.affixed_class);
			}
			
			inst.until = inst.options.until !== null ? inst.options.until : inst.document_height;
			
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
			
			// Check scroll position
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
			var target_top = inst.start_offset.top + inst.options.offset;
			
			if ( inst.options.debug )
			{
				console.log(
					proto.name + ' check_scroll: ' +
					'trigger: ' + trigger + 
					'target_top: ' + target_top + 
					'until: ' + inst.until + 
					'inst.document_height: ' + inst.$document.height() + 
					'$(document).height(): ' + $(document).height()
				);
			}
			
			if ( trigger >= target_top && trigger <= inst.until )
			{
				// If already affixed, stop
				if ( inst.$element.hasClass(inst.options.affixed_class) )
				{
					return;
				}
				
				inst.$element.addClass(inst.options.affixed_class)
				.css({
					left : inst.start_offset.left,
					right : 'auto',
					top : inst.options.offset,
					bottom : 'auto'
				});
				
				$('<div class="' + inst.options.placeholder_class + '"></div>')
				.css('height', inst.element_height)
				.insertAfter(inst.$element);
			}
			else if ( inst.$element.hasClass(inst.options.affixed_class) )
			{
				inst.$element.removeClass(inst.options.affixed_class)
				.css({
					left : inst.start_left,
					right : inst.start_right,
					top : inst.start_top,
					bottom : inst.start_bottom
				});
				
				inst.$element.next('.' + inst.options.placeholder_class).remove();
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