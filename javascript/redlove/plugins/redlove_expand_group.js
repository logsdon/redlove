//<![CDATA[
/**
* Create an accordion type of info expander
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_expand_group.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_expand_group.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	$('.redlove_expand-group').redlove_expand_group();
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
	proto.name = 'redlove_expand_group';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		active_class : 'active',
		debug : false,
		expander : 'a',
		expander_selector : '.redlove_expander',
		expandee : 'div',
		expandee_selector : '.redlove_expandee',
		close_others : false,
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
		inst.metadata = {};//this.$element.data('plugin-options');//$(element).data();
		inst.options = $.extend( {}, inst.default_options, inst.options, inst.metadata );
		
		// Plugin properties
		
		// Plugin implementation code
		inst.$expanders = inst.$element.find(inst.options.expander_selector + ', > ' + inst.options.expander);
		
		// Handle show/hide
		inst.$expanders.on('click.' + proto.name, function ( event )
		{
			event.preventDefault();
			
			var $this = $(this);
			var $next = $this.next();
			var is_active = $this.hasClass(inst.options.active_class);
			
			// Close others
			if ( inst.options.close_others )
			{
				$this.siblings().not($next)
				.removeClass(inst.options.active_class)
				.css({
					maxHeight : ''
				});
			}
			
			// Close self
			if ( is_active )
			{
				$this.add($next)
				.removeClass(inst.options.active_class)
				.css({
					maxHeight : ''
				});
			}
			// Open self
			else
			{
				$this.addClass(inst.options.active_class);
				$next.css({
					maxHeight : $next.data('maxHeight')
				});
			}
		});
		
		inst.update();
		
		// Use timeout to help with responsiveness and not fire before DOM resizes
		inst.update_timeout = null;
		// Update on page load
		$(window).one('load.' + proto.name, function ( event )
		{
			if ( inst.update_timeout )
			{
				clearTimeout(inst.update_timeout);
				inst.update_timeout = null;// Eliminate the chance of creating concurrent timeouts
			}
			inst.update_timeout = setTimeout(function(){inst.update();}, 100);
		});
		// Update on page resize
		$(window).on('resize.' + proto.name, function ( event )
		{
			if ( inst.update_timeout )
			{
				clearTimeout(inst.update_timeout);
				inst.update_timeout = null;// Eliminate the chance of creating concurrent timeouts
			}
			inst.update_timeout = setTimeout(function(){inst.update();}, 100);
		});
		
		return inst;
	};
	
	/**
	* Update the plugin
	* 
	* @return object Plugin instance
	*/
	proto.update = function ()
	{
		var inst = this;
		
		// Set the max-height data
		inst.$expanders.next().each( function ( i, el )
		{
			var $this = $(this);
			$this.data('maxHeight', $this.css('maxHeight', 'none').outerHeight());
			$this.css('maxHeight', '');
		});
		
		return inst;
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