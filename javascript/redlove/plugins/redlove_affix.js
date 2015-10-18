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
			trigger_offset : 0,
			'' : ''
		};
		
		// Plugin implementation code
		this.update();
		var self = this;
		this.data.$window.one('load.' + proto.name, function(){self.update();});
		
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
	* @return object Plugin instance
	*/
	proto.update = function ()
	{
		// Update dimensions and positioning
		this.data.window_height = this.data.$window.height();
		this.data.scroll_top_last = this.data.$window.scrollTop();
		this.data.document_height = this.data.$document.height();
		
		this.data.start_left = this.$element.css('left');
		this.data.start_position = this.$element.css('position');
		this.data.start_right = this.$element.css('right');
		this.data.start_top = this.$element.css('top');
		this.data.start_bottom = this.$element.css('bottom');
		this.data.start_offset = this.$element.offset();
		this.data.element_height = this.$element.outerHeight();
		
		this.options.until = this.options.until !== null ? this.options.until : this.data.document_height;
		
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
		
		// Check scroll position
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
		var trigger = scroll_top + this.options.trigger_offset;
		var target_top = this.data.start_offset.top + this.options.offset;
		if ( trigger >= target_top && trigger <= this.options.until )
		{
			// If already affixed, stop
			if ( this.$element.hasClass(this.options.affixed_class) )
			{
				return;
			}
			
			this.$element.addClass(this.options.affixed_class)
			.css({
				left : this.data.start_offset.left,
				right : 'auto',
				top : this.options.offset,
				bottom : 'auto'
			});
			
			$('<div class="' + this.options.placeholder_class + '"></div>')
			.css('height', this.data.element_height)
			.insertAfter(this.$element);
		}
		else if ( this.$element.hasClass(this.options.affixed_class) )
		{
			this.$element.removeClass(this.options.affixed_class)
			.css({
				left : this.data.start_left,
				right : this.data.start_right,
				top : this.data.start_top,
				bottom : this.data.start_bottom
			});
			
			this.$element.next('.' + this.options.placeholder_class).remove();
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