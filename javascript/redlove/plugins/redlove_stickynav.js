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
		this.element = el;
		this.$element = $(el);
		this.options = options;
		
		// Extend default options
		this.metadata = {};//this.$element.data('plugin-options');//$(element).data();
		this.options = $.extend( {}, this.default_options, this.options, this.metadata );
		
		// Plugin properties
		this.data = this.data || {
			$window : $(window),
			$document : $(document),
			scroll_targets : [],
			trigger_offset : 0,
			'' : ''
		};
		
		// Plugin implementation code
		this.update();
		var self = this;
		this.data.$window.one('load.' + proto.name, function(){self.update();});
		this.data.$window.on('resize.' + proto.name, function(){self.update();});
		
		var throttle_options = {
			interval : this.options.throttle,
			run_at_start : true,
			run_at_end : true,
			callback : function ()
			{
				self.check_scroll();
			}
		};
		this.data.throttle = new redlove_throttle(throttle_options);
		this.data.$window.on('scroll.' + proto.name, this.data.throttle.handler);
	};
	
	/**
	* Update the plugin
	* 
	* @return void
	*/
	proto.update = function ()
	{
		// Update dimensions and positioning
		this.data.document_height = this.data.$document.height();
		this.data.window_height = this.data.$window.height();
		this.data.scroll_top_last = this.data.$window.scrollTop();
		
		this.data.trigger_offset = this.options.offset;
		if ( this.options.trigger_offset !== null )
		{
			if ( this.options.trigger_offset <= 1 )
			{
				this.data.trigger_offset = this.data.window_height * this.options.trigger_offset;
			}
			else
			{
				this.data.trigger_offset = this.options.trigger_offset;
			}
		}
		
		// Gather scroll targets
		var self = this;
		var scroll_targets = [];
		var $targets = this.$element.find('a[href^="#"]');
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
				bottom : self.data.document_height
			});
			var cur_index = scroll_targets.length - 1;
			var prev_index = scroll_targets.length - 2;
			
			// Adjust top
			//scroll_targets[cur_index].top -= self.options.offset;
			scroll_targets[cur_index].top = Math.round( scroll_targets[cur_index].top );
			
			// Adjust bottom
			if ( scroll_targets.length > 1 )
			{
				scroll_targets[prev_index].bottom = scroll_targets[cur_index].top - 0.01;
			}
			//scroll_targets[cur_index].bottom -= self.options.offset;
			scroll_targets[cur_index].bottom = Math.round( scroll_targets[cur_index].bottom );
		});
		this.data.scroll_targets = scroll_targets;
		
		// Set up smooth scrolling
		if ( this.options.smooth_scroll )
		{
			var selector = 'click.' + proto.name + ' vclick.' + proto.name;
			this.$element.find('a[href^="#"]')
			.off(selector).on(selector, function ( event )
			{
				event.preventDefault();
				event.stopImmediatePropagation();
				
				var hash = this.hash.replace('#', '');
				var $target = $('#' + hash);
				if ( $target.length > 0 )
				{
					var target_top = Math.ceil( $target.offset().top - self.options.offset );
					$('html,body').animate(
						{
							scrollTop : target_top
						},
						self.options.smooth_scroll_time,
						function ()
						{
							// Make sure last scroll is checked
							self.check_scroll();
						}
					);
				}
				
				return false;
			});
		}
		
		// Run at start
		this.check_scroll();
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
		
		// Get scroll position and direction
		var scroll_top = this.data.$window.scrollTop();
		var delta_v = ( scroll_top > this.data.scroll_top_last ) ? 1 : -1;
		this.data.scroll_top_last = scroll_top;
		
		// Check scroll position
		var trigger = scroll_top + this.data.trigger_offset;
		var scroll_targets = this.data.scroll_targets;
		for ( var index = 0; index < scroll_targets.length; index++ )
		{
			if ( this.options.debug )
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
				if ( $(scroll_targets[index].el).parent().hasClass(this.options.active_class) )
				{
					break;
				}
				
				$(scroll_targets[index].el).parent().addClass(this.options.active_class);
				this.options.in_view.call(this);
			}
			else
			{
				$(scroll_targets[index].el).parent().removeClass(this.options.active_class);
				this.options.out_view.call(this);
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
//]]>