//<![CDATA[

jQuery(document).ready(function($)
{
	// ------------------------------------------------------------
	
	jQuery(window).load(function()
	{
		console.log('// ------------------------------------------------------------');
		console.log('// Begin GLOBAL_OBJECT testing');
		GLOBAL_OBJECT.my_function2('this is the...');
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin javascript_plugin_basic testing');
		var plugin = new javascript_plugin_basic({interval : 123});
		console.log(plugin.options);
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin javascript_plugin_advanced testing');
		var plugin = new javascript_plugin_advanced({interval : 456});
		console.log(plugin.options);
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_plugin_basic testing');
		$('#basic-plugin_test-list-1').jquery_plugin_basic({arg1 : 'test-1'});
		$('#basic-plugin_test-list-2').jquery_plugin_basic({arg1 : 'test-2'});
		$('#basic-plugin_test-list-3').jquery_plugin_basic({arg1 : 'test-3'});
		
		var plugin = $('#basic-plugin_test-list-1').data('jquery_plugin_basic');
		console.log(plugin);
		
		var plugin = $('#basic-plugin_test-list-2').data('jquery_plugin_basic');
		console.log(plugin);
		
		var plugin = $('#basic-plugin_test-list-3').data('jquery_plugin_basic');
		console.log(plugin);
		
		console.log('');
		$('#basic-plugin_test-list-1').jquery_plugin_basic.options;
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_plugin_basic testing');
		$('#basic-plugin_test-list-1').jquery_plugin_basic({arg1 : 'test-1'});
		$('#basic-plugin_test-list-2').jquery_plugin_basic({arg1 : 'test-2'});
		$('#basic-plugin_test-list-3').jquery_plugin_basic({arg1 : 'test-3'});
		console.log('');
		$('#basic-plugin_test-list-1').jquery_plugin_basic.options;
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_plugin_advanced testing');
		console.log('How many instances have we created? ' + $.fn.jquery_plugin_advanced.prototype.num_instances );
		console.log('Our default options are...');
		console.log( $.fn.jquery_plugin_advanced.prototype.default_options );
		console.log('I am changing default_val to "waffles"');
		$.fn.jquery_plugin_advanced.prototype.default_options.default_val = 'waffles';
		
		console.log('Creating a plugin instance');
		$('#test-list-1').jquery_plugin_advanced({arg2 : 'test-1'});
		console.log('Updating a plugin instance');
		$('#test-list-1').jquery_plugin_advanced({arg1 : 'test-3'});
		console.log( $('#test-list-1').data('jquery_plugin_advanced').options );
		
		console.log('Creating a plugin instance');
		$('#test-list-2').jquery_plugin_advanced({arg1 : 'test-2'});
		
		console.log('Setting plugin data');
		console.log( $('#test-list-2').data('jquery_plugin_advanced').set_data('new key', 'new value') );
		console.log('Getting plugin data');
		console.log( $('#test-list-2').data('jquery_plugin_advanced').get_data() );
		
		console.log('I am changing default_val to "pancakes"');
		$('#test-list-2').data('jquery_plugin_advanced').default_options.default_val = 'pancakes';
		
		console.log('Creating a plugin instance');
		$('#test-list-3').jquery_plugin_advanced({arg1 : 'test-1'});
		
		console.log('Getting plugin reference');
		var plugin = $.fn.jquery_plugin_advanced.get_plugin('#test-list-3');
		console.log('Internal data');
		console.log( plugin._data );
		console.log('Updating a plugin instance');
		console.log( plugin.init() );
		
		$.fn.jquery_plugin_advanced.prototype.log('Using the plugin log method!');
		
		console.log('How many instances have we created? ' + $.fn.jquery_plugin_advanced.prototype.num_instances );
		console.log('How many instances have we created? ' + $('#test-list-2').data('jquery_plugin_advanced').num_instances );
		console.log( $('#test-list-2').data('jquery_plugin_advanced').num_instances );
		console.log('Our default options are...');
		console.log( $.fn.jquery_plugin_advanced.prototype.default_options );
		console.log('// ------------------------------------------------------------');
		/*
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_plugin_advanced2 testing');
		console.log( $.fn.jquery_plugin_advanced2.num_instances );
		console.log( $.fn.jquery_plugin_advanced2.default_options );
		$('#test-list-1').jquery_plugin_advanced2({arg1 : 'test-1'});
		$('#test-list-2').jquery_plugin_advanced2({arg1 : 'test-2'});
		console.log('Set data...');
		//$('#test-list-1').data('jquery_plugin_advanced2').set_data('waffles');
		//$('#test-list-2').data('jquery_plugin_advanced2').set_data('doughnuts');
		console.log( $.fn.jquery_plugin_advanced2.num_instances );
		console.log( $.fn.jquery_plugin_advanced2.default_options );
		console.log( $('#test-list-1').data('jquery_plugin_advanced2').num_instances );
		console.log( $('#test-list-1').data('jquery_plugin_advanced2').default_options );
		console.log('Get data...');
		console.log( $('#test-list-1').data('jquery_plugin_advanced2').get_data() );
		console.log( $('#test-list-2').data('jquery_plugin_advanced2').get_data('#test-list-2') );
		console.log('// ------------------------------------------------------------');
		console.log('');
		*/
	});
	
	// ------------------------------------------------------------
	
});

// ------------------------------------------------------------

/**
* Wait for resources to become available
* 
*/
;(function ()// Begin function closure; avoid collisions
{
	console.log('// ------------------------------------------------------------');
	console.log('Wait for resources to become available...');
	// If objects do not exist, check again shortly
	if ( typeof jQuery === 'undefined' )
	{
		console.log('Still waiting...');
		return setTimeout(arguments.callee, 250);
	}
	
	console.log('jQuery is available!');
	
	jQuery(document).ready(function ( $ )
	{
		console.log('DOM is ready!');
		console.log('');
		
		// Toggle id from href
		$('a.resource-wait').click(function ( event )
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			$( $(this).attr('href') ).slideToggle();
		});
	});
	
})();// End function closure

// ------------------------------------------------------------

/**
* Create a global object
* 
*/
window.GLOBAL_OBJECT = window.GLOBAL_OBJECT || {};
window.GLOBAL_OBJECT = $.extend(window.GLOBAL_OBJECT, {
	/**
	* Property
	*
	* @var string
	*/
	my_property : 'property value',
	
	/**
	* Function
	* 
	* @param mixed my_arg An argument
	* @return void
	*/
	my_function : function ( my_arg )
	{
		console.log(my_arg + ' ' + this.my_property);
	},
	
	/**
	* Function
	* 
	* @param mixed my_arg An argument
	* @return void
	*/
	my_function2 : function ( my_arg )
	{
		this.my_function(my_arg);
	},
	
	'' : ''// Empty so each property above ends with a comma
});

// ------------------------------------------------------------

/**
* JavaScipt basic plugin template
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:
* 
*/
;(function ( window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'javascript_plugin_basic';
	var plugin_instances = 0;
	var plugin_default_options = {
		callback : function(){},
		debounce : false,
		debug : false,
		interval : 100,// Milliseconds
		'' : ''// Empty so each property above ends with a comma
	};
	
	// Window plugin definition
	
	/**
	* Window plugin constructor
	* 
	* @param mixed options Plugin options object
	* @return object Plugin instance
	*/
	window[plugin_name] = function ( options )
	{
		console.log(plugin_name + '()');
		plugin_instances++;
		
		// Extend default options
		this.options = $.extend( {}, plugin_default_options, options );
		
		// Plugin instance properties
		this.now = 0;
		this.time_last_run = 0;
		
		console.log(plugin_name + ' init()');
		
		// Create an anonymous function to run later using plugin data
		var self = this;
		this.handler = function ()
		{
			self.now = new Date().getTime();
			
			if ( self.options.debug )
			{
				console.log('Running at start');
			}
			self.run(arguments);
		};
		
		return this;
	};
	
})( window, document );// End function closure

// ------------------------------------------------------------

/**
* JavaScipt advanced plugin template
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:
* 
*/
;(function ( window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'javascript_plugin_advanced';
	var plugin_ref;
	var plugin_default_options = {
		callback : function(){},
		debounce : false,
		debug : false,
		interval : 100,// Milliseconds
		'' : ''// Empty so each property above ends with a comma
	};
	
	/**
	* Plugin constructor
	* 
	* @param mixed options Plugin options object
	* @return object Plugin instance
	*/
	var Plugin = function ( options )
	{
		return this.init(options);
	};
	
	// Plugin properties
	plugin_ref = Plugin.prototype;// Plugin prototype reference
	plugin_ref.default_options = plugin_default_options;
	
	// Plugin methods
	
	/**
	* Initialize plugin
	* 
	* @param mixed options Plugin options object
	* @return object Plugin instance
	*/
	plugin_ref.init = function ( options )
	{
		// Extend default options
		this.options = $.extend( {}, this.default_options, options );
		
		// Internal properties
		this.now = 0;
		this.time_last_run = 0;
		
		console.log(plugin_name + ' init()');
		
		// Create an anonymous function to run later using plugin data
		var self = this;
		this.handler = function ()
		{
			self.now = new Date().getTime();
			
			if ( self.options.debug )
			{
				console.log('Running at start');
			}
			self.run(arguments);
		};
		
		return this;
	};
	
	/**
	* Run plugin actions
	* 
	* @param mixed args Passed arguments
	* @return void
	*/
	plugin_ref.run = function ( args )
	{
		this.time_last_run = this.now;
		this.options.callback.call(this, args);
	};
	
	// Window plugin definition
	window[plugin_name] = Plugin;
	
})( window, document );// End function closure

// ------------------------------------------------------------

/**
* jQuery basic plugin template
* 
* Applies actions to elements
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:
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
	proto.name = 'jquery_plugin_basic';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		backgroundColor : 'white',
		callback : function(){},
		color : '#556b2f',
		debounce : false,
		debug : false,
		interval : 100,// Milliseconds
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
		console.log(proto.name + '()' + proto.num_instances);
		
		this.element = el;
		this.$element = $(el);
		this.options = options;
		
		// Extend default options
		this.metadata = {};//this.$element.data('plugin-options');//$(element).data();
		this.options = $.extend( {}, this.default_options, this.options, this.metadata );
		
		this.update();
	};
	
	/**
	* Update the plugin
	* 
	* @return void
	*/
	proto.update = function ()
	{
		this.$element.css({
			color : this.options.color,
			backgroundColor : this.options.backgroundColor
		});
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
			// If plugin data doesn't exist, initialize new plugin
			var data = $.data(this, proto.data_key);
			if ( ! data )
			{
				var plugin = new Plugin( this, options );
				$.data(this, proto.data_key, plugin);
			}
			// Else re-initialize plugin
			else
			{
				data.init(this, options);
			}
		});
	};
	// Reference the Plugin prototype to access properties and methods without instantiation
	$.fn[proto.name].prototype = Plugin.prototype//Object.create();
	// Create Plugin references to public prototype functions at the jQuery definition root
	for ( var index in Plugin.prototype )
	{
		if ( $.type(Plugin.prototype[index]) == 'function' && index.indexOf('_') !== 0 )
		{
			$.fn[proto.name][index] = Plugin.prototype[index];
		}
	}
	
})( jQuery, window, document );// End function closure

// ------------------------------------------------------------

/**
* jQuery advanced plugin template
* 
* Applies actions to elements, stores plugin instance, and extends plugin public prototype to jQuery function
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:
* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'jquery_plugin_advanced';
	var plugin_data_key = plugin_name;//'plugin_' + 
	var plugin_ref;
	var plugin_default_options = {
		callback : function(){},
		debug : false,
		default_val : undefined,
		'' : ''// Empty so each property above ends with a comma
	};
	
	/**
	* Plugin constructor
	* 
	* @param mixed el DOM element
	* @param mixed options Plugin options object
	* @return void
	*/
	var Plugin = function ( el, options )
	{
		console.log(plugin_name + '()');
		
		this.init(el, options);
		
		// If first plugin run, set up global event listeners, etc.
		if ( plugin_ref.first_run )
		{
		}
		plugin_ref.first_run = false;
	};
	
	// Plugin properties
	plugin_ref = Plugin.prototype;// Plugin prototype reference
	plugin_ref.default_options = plugin_default_options;
	plugin_ref.first_run = true;
	plugin_ref.instances = new Array();
	plugin_ref.num_instances = 0;
	
	// Plugin methods
	
	/**
	* Initialize plugin
	* 
	* @param mixed el DOM element
	* @param mixed options Plugin options object
	* @return object Plugin instance
	*/
	plugin_ref.init = function ( el, options )
	{
		console.log(plugin_name + ' init()');
		
		// Internal data property
		this._data = this._data || {};
		
		if ( arguments.length == 0 || arguments[0] == undefined )
		{
			return this;
		}
		
		// Check for passed element
		if ( el !== undefined && ! $.isPlainObject(el) )
		{
			this.element = el;
			this.$element = $(el);
		}
		
		// Check for passed options
		if ( $.isPlainObject(el) )
		{
			this.options = el;
		}
		else if ( $.isPlainObject(options) )
		{
			this.options = options;
		}
		
		// Extend default options
		this.metadata = {};//this.$element.data('plugin-options');//$(element).data();
		this.options = $.extend( {}, this.default_options, this.options, this.metadata );
		
		// Our plugin implementation code goes here.
		this.update();
		
		return this;
	};
	
	/**
	* Update the plugin
	* 
	* @return object Plugin instance
	*/
	plugin_ref.update = function ()
	{
		console.log(plugin_name + ' update()');
		
		/*
		var $window = $(window);
		var $document = $(document);
		var document_width = $document.width();// width of HTML document
		var document_height = $document.height();// height of HTML document
		var window_width = $window.width();// width of browser viewport
		var window_height = $window.height();// height of browser viewport
		var window_scroll_top = $window.scrollTop();// number of pixels scrolled vertically
		var $target_element = $('.scroll-target');
		$target_element.offset().top;// position relative to the document
		$target_element.position().top;// position relative to the offset parent
		$target_element.width();// content width
		$target_element.innerWidth();// content width, including padding but not border
		$target_element.outerWidth();// content width, including padding and border
		$target_element.outerWidth(true);// content width, including padding, border, and margin
		
		var scroll_top_last = $window.scrollTop();
		var scroll_time_last = 0;
		var scroll_debounce_timeout;
		var scroll_loading = false;
		var scroll_load_available = true;
		var scroll_throttle_milliseconds = 250;
		var scroll_function = function(event)
		{
			// Throttle and Debounce
			var now = new Date().getTime();
			var scroll_time_elapsed = now - scroll_time_last;
			// Throttle: If request time is too soon since last request
			if ( scroll_time_elapsed < scroll_throttle_milliseconds )
			{
				//console.log('throttling and setting debounce');
				
				// Debounce: Reset timeout for delayed event to run when requests stop
				clearTimeout(scroll_debounce_timeout);
				scroll_debounce_timeout = setTimeout(function(){
					//console.log('running debounce');
					scroll_function();
				}, scroll_throttle_milliseconds - scroll_time_elapsed);
				
				return;
			}
			scroll_time_last = now;
			
			//console.log('running scroll_function');
			
			// Scroll for window
			//var scroll_top = $window.scrollTop();
			//var scroll_bottom = scroll_top + window_height;
			//var scroll_delta = ( scroll_top > scroll_top_last ) ? 1 : -1;
			//scroll_delta = ( scroll_top == scroll_top_last ) ? 0 : scroll_delta;
			//scroll_top_last = scroll_top;
			//var scroll_target_offset = $('footer').offset();
			//var target_in_view = ( scroll_bottom > scroll_target_offset.top );
			
			// Scroll for target
			var scroll_top = $target_element.scrollTop();
			var window_height = $target_element[0].scrollHeight;
			var scroll_bottom = scroll_top + window_height;
			var scroll_delta = ( scroll_top > scroll_top_last ) ? 1 : -1;
			scroll_delta = ( scroll_top == scroll_top_last ) ? 0 : scroll_delta;
			scroll_top_last = scroll_top;
			var target_in_view = ( scroll_bottom > window_height - 100 );
			
			// If not loading, more can be loaded, scrolling down, and target has come into view
			if ( 
				! scroll_loading && 
				scroll_load_available && 
				scroll_delta == 1 && 
				target_in_view 
			)
			{
				//console.log('Load...');
				load_more();
			}
		};
		// Scroll for window
		//$window.on('scroll', scroll_function);
		//scroll_function();
		//var scroll_function_interval = setInterval(scroll_function, 500);
		// Scroll for target
		scroll_function();
		$target_element.on('scroll', scroll_function);
		*/
		
		return this;
	};
	
	/**
	* Log messages
	* 
	* @param string message The message to display
	* @return void
	*/
	plugin_ref.log = function ( message )
	{
		console.log(plugin_name + ' log()');
		
		if ( window.console && window.console.log )
		{
			window.console.log(message);
		}
		else
		{
			alert(message);
		}
	};
	
	/**
	* Get plugin reference
	* 
	* @param mixed el DOM element
	* @return object Plugin instance
	*/
	plugin_ref.get_plugin = function ( el )
	{
		console.log(plugin_name + ' get_plugin()');
		var $el = el !== undefined ? $(el) : this.$element;
		return $el.data(plugin_data_key);
	};
	
	/**
	* Set plugin reference
	* 
	* @param mixed el DOM element
	* @param mixed data Plugin instance
	* @return object Plugin instance
	*/
	plugin_ref.set_plugin = function ( el, data )
	{
		console.log(plugin_name + ' set_plugin()');
		var tmp_data = data !== undefined ? data : el;
		var tmp_el = data !== undefined ? $(el) : this.$element;
		return tmp_el.data(plugin_data_key, tmp_data);
	};
	
	/**
	* Get plugin data
	* 
	* @param mixed el DOM element
	* @param string index The data key for the associated value
	* @return void|mixed Plugin data
	*/
	plugin_ref.get_data = function ( el, index )
	{
		console.log(plugin_name + ' get_data()');
		var plugin = this.get_plugin(el);
		if ( plugin === undefined )
		{
			return;
		}
		
		return ( index !== undefined ? plugin._data[index] : plugin._data );
	};
	
	/**
	* Set plugin data
	* 
	* @param mixed el DOM element
	* @param string index The data key for the associated value
	* @param mixed data The data to store
	* @return void|mixed Plugin data
	*/
	plugin_ref.set_data = function ( el, index, data )
	{
		console.log(plugin_name + ' set_data()');
		var tmp_data = data !== undefined ? data : index;
		var tmp_index = data !== undefined ? index : el;
		var tmp_el = data !== undefined ? $(el) : this.$element;
		
		var plugin = this.get_plugin(tmp_el);
		if ( plugin === undefined )
		{
			return;
		}
		
		if ( tmp_index !== undefined )
		{
			plugin._data[tmp_index] = tmp_data;
		}
		else
		{
			plugin._data = tmp_data;
		}
		
		return tmp_data;
	};
	
	// Private functions
	
	/**
	* Debug plugin
	* 
	* @param mixed obj Data object to work with
	* @return void
	*/
	function debug ( obj )
	{
		console.log(plugin_name + ' debug()');
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
		// Plugin code for each element
		return this.each(function ( index )
		{
			// If plugin data doesn't exist, initialize new plugin
			var data = plugin_ref.get_plugin(this);//$.data(this, plugin_data_key);
			if ( ! data )
			{
				var plugin = new Plugin( this, options );
				plugin.set_plugin(plugin);//$.data(this, plugin_data_key, plugin);
				plugin_ref.num_instances++;
			}
			// Else re-initialize plugin
			else
			{
				data.init(this, options);
			}
		});
	};
	// Reference the Plugin prototype to access properties and methods without instantiation
	$.fn[plugin_name].prototype = Plugin.prototype//Object.create();
	// Create Plugin references to public prototype functions at the jQuery definition root
	for ( var index in Plugin.prototype )
	{
		if ( $.type(Plugin.prototype[index]) == 'function' && index.indexOf('_') !== 0 )
		{
			$.fn[plugin_name][index] = Plugin.prototype[index];
		}
	}
	// Window plugin definition
	//window[Plugin.prototype.plugin_name] = Plugin;
	
})( jQuery, window, document );// End function closure

// ------------------------------------------------------------

/**
* jQuery advanced plugin template 2
* Unfortunately, .prototype only available after instantiation, so can only reference variables and methods from plugin references and not standalone
* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'advanced_plugin_template2';
	var plugin_data_key = plugin_name;
	var plugin_default_options = {
		default_val : undefined,
		callback : function(){},
		debug : false,
		'' : ''
	};
	
	// Plugin constructor
	var Plugin = function ( element, options )
	{
		console.log(plugin_name + '()');
		
		this.element = element;
		this.$element = $(element);
		this.options = options;
		this.metadata = {};//this.$element.data('plugin-options');//$(element).data();
	};
	
	// Plugin prototype
	Plugin.prototype = {
		// Public properties
		default_options : plugin_default_options,
		// Initialize plugin
		init : function( el, options )
		{
			console.log(plugin_name + ' init()');
			
			// Extend default options
			this.config = $.extend( {}, this.default_options, this.options, this.metadata );
			return this;
		},
		// Update plugin
		update : function( el, options )
		{
			console.log(plugin_name + ' update()');
			
			var data = this.get_data(el);
			if ( ! data )
			{
				return;
			}
			
			return this;
		},
		// Set plugin data
		set_data : function( el, data )
		{
			console.log(plugin_name + ' set_data()');
			var tmp_el = data !== undefined ? $(el) : this.$element;
			var tmp_data = data !== undefined ? data : el;
			return tmp_el.data(plugin_data_key, tmp_data);
		},
		// Get plugin data
		get_data : function( el )
		{
			console.log(plugin_name + ' get_data()');
			var el = el !== undefined ? $(el) : this.$element;
			return el.data(plugin_data_key);
		}
	};
	
	// Private functions
	
	// Private function for debugging.
	function debug()
	{
		console.log(plugin_name + ' debug()');
	}
	
	Plugin.default_options = Plugin.default_options;
	Plugin.num_instances = 0;
	
	$.fn[plugin_name] = function(options)
	{
		return this.each(function( index )
		{
			if ( ! $.data(this, plugin_data_key) )
			{
				var plugin = new Plugin( this, options ).init();
				$.data(this, plugin_data_key, plugin);
				//return plugin_ref.init.apply(this, arguments);
				Plugin.num_instances++;
			}
		});
	};
	
})( jQuery, window, document );// End function closure

// ------------------------------------------------------------

// ------------------------------------------------------------
// References
// ------------------------------------------------------------

/**
* 
http://learn.jquery.com/plugins/basic-plugin-creation/
http://learn.jquery.com/plugins/advanced-plugin-concepts/
*/

/**
* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'logsdon__toggle_val';
	var plugin_data_key = 'plugin_' + plugin_name;
	var plugin_ref;
	var plugin_defaults = {
		default_val : undefined,
		callback : function(){},
		debug : false,
		'' : ''
	};
	
	// Plugin definition
	$.fn[plugin_name] = function ( options )
	{
		/*
		if ( plugin_ref[options] )
		{
			return plugin_ref[options].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if ( typeof options === 'object' || ! options )
		{
			return plugin_ref.init.apply(this, arguments);
		}
		else
		{
			$.error('Method ' + options + ' does not exist on jQuery.' + plugin_name);
		}
		*/
		
		// Extend default options
		var metadata = {};//this.$element.data( 'plugin-options' );//$(element).data();
		options = $.extend( {}, $.fn[plugin_name].defaults, options, metadata );
		
		//this.init();
		//plugin_ref.init(this.element, this.options);
		
		return this.each(function( index )
		{
			$this = $(this);
			if ( ! $.data(this, plugin_data_key) )
			{
				//var plugin = new Plugin( this, options );
				//$.data(this, plugin_data_key, plugin);
				//return plugin_ref.init.apply(this, arguments);
				plugin_ref.num_instances++;
			}
		});
	};
	
	// Private variables
	plugin_ref = $.fn[plugin_name];
	
	// Public variables
	plugin_ref.defaults = plugin_defaults;
	plugin_ref.num_instances = 0;
	
	// Public functions
	
	// Initialize plugin
	plugin_ref.init = function( el, options )
	{
		// Our plugin implementation code goes here.
		var $el = $(el);
		//plugin_ref.update(el, options);
	};
	
	// Update plugin
	plugin_ref.update = function( el, options )
	{
		var data = plugin_ref.get_data(el);
		if ( ! data )
		{
			return;
		}
		
		return this;
	};
	
	// Get plugin data
	plugin_ref.get_data = function( el )
	{
		//return $(el).data(plugin_data_key);
		
		var data;
		
		if ( el )
		{
			data = $(el).data(plugin_data_key);
		}
		else if ( plugin_ref.options )
		{
			data = {options : plugin_ref.options};
		}
		else
		{
			data = $(this).data(plugin_data_key);
		}
		
		return data;
	};
	
	// Set plugin data
	plugin_ref.set_data = function( el, data )
	{
		return $(el).data(plugin_data_key, data);
	};
	
	// Log messages
	plugin_ref.log = function( message )
	{
		if ( window.console && window.console.log )
		{
			window.console.log(message);
		}
		else
		{
			alert(message);
		}
	};
	
	// Private functions
	
	// Private function for debugging.
	function debug( $obj )
	{
	};
	
})( jQuery, window, document );// End function closure

// ------------------------------------------------------------

(function($)
{
	$.fn.greenify = function( options )
	{
		// These are the defaults.
		var default_options = {
			color : '#556b2f',
			backgroundColor : 'white'
		};
		// This is the easiest way to have default options.
		var options = $.extend(default_options, options);
		
		// Do something to each element here.
		return this.each(function( index )
		{
			$(this).css({
				color: options.color,
				backgroundColor: options.backgroundColor
			});
		});
	};
})(jQuery);

// ------------------------------------------------------------

// http://www.smashingmagazine.com/2011/10/essential-jquery-plugin-patterns/
$.fn.pluginTest4 = function()
{
	// your plugin logic
	var max = 0;
	this.each(function(i)
	{
		max = Math.max(max, $(this).outerHeight(true));
	});
	return max;
};

(function( $ ){
	$.fn.pluginTest5 = function()
	{
		// your plugin logic
	};
})( jQuery );

(function( $ ){
	$.extend($.fn, {
		pluginTest6: function()
		{
			// your plugin logic
		}
	});
})( jQuery );

// ------------------------------------------------------------

// http://stackoverflow.com/questions/14985623/multiple-instances-of-jquery-plugin-on-same-page
$.fn.extend({
	pluginTest1 : function(params)
	{
		// Merge default and user parameters
		var otherGeneralVars = 'example';

		return this.each(function()
		{
			var $t = $(this), opts = $.extend({},$.pluginTest1.defaults, params);
			$t.text(opts.foo + uniqueId);
		});
	}
});

// ------------------------------------------------------------

// https://css-tricks.com/forums/topic/multiple-instances-of-jquery-plugin-on-one-page/
$.fn.pluginTest2 = function(options)
{
	return this.each(function()
	{
		settings = $.extend({
			option1 : 'etc',
			option2 : 'etc',
			//more options
			'' : ''
		}, options);

		// code to do stuff
		var $this = $(this);

		// target elements inside using $this as the base
		var element = $this.find('.inside');
	});
};

// ------------------------------------------------------------

// https://github.com/jquery-boilerplate/jquery-patterns/blob/master/patterns/jquery.basic.plugin-boilerplate.js
// https://github.com/jquery-boilerplate/jquery-boilerplate/blob/master/src/jquery.boilerplate.js
// http://www.smashingmagazine.com/2011/10/essential-jquery-plugin-patterns/
/*!
* jQuery lightweight plugin boilerplate
* Original author: @ajpiano
* Further changes, comments: @addyosmani
* Licensed under the MIT license
*/
// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
;(function ( $, window, document, undefined )
{
	// undefined is used here as the undefined global
	// variable in ECMAScript 3 and is mutable (i.e. it can
	// be changed by someone else). undefined isn't really
	// being passed in so we can ensure that its value is
	// truly undefined. In ES5, undefined can no longer be
	// modified.

	// window and document are passed through as local
	// variables rather than as globals, because this (slightly)
	// quickens the resolution process and can be more
	// efficiently minified (especially when both are
	// regularly referenced in your plugin).

	// Create the defaults once
	var pluginName = 'pluginTest3',
		defaults = {
			propertyName : 'value'
		};

	// The actual plugin constructor
	function Plugin( element, options )
	{
		this.element = element;

		// jQuery has an extend method that merges the
		// contents of two or more objects, storing the
		// result in the first object. The first object
		// is generally empty because we don't want to alter
		// the default options for future instances of the plugin
		this.options = $.extend({}, defaults, options);

		this._defaults = defaults;
		this._name = pluginName;

		this.init();
	}

	Plugin.prototype = {

		init : function()
		{
			// Place initialization logic here
			// You already have access to the DOM element and
			// the options via the instance, e.g. this.element
			// and this.options
			// you can add more functions like the one below and
			// call them like so: this.yourOtherFunction(this.element, this.options).
		},

		yourOtherFunction : function(el, options)
		{
			// some logic
		}
	};

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[pluginName] = function( options )
	{
		return this.each(function()
		{
			if ( ! $.data(this, 'plugin_' + pluginName) )
			{
				$.data(this, 'plugin_' + pluginName, new Plugin(this, options));
			}
		});
	};

})( jQuery, window, document );

// ------------------------------------------------------------

// http://www.smashingmagazine.com/2011/10/essential-jquery-plugin-patterns/
/*
* 'Highly configurable' mutable plugin boilerplate
* Author: @markdalgleish
* Further changes, comments: @addyosmani
* Licensed under the MIT license
*/
// Note that with this pattern, as per Alex Sexton's, the plugin logic
// hasn't been nested in a jQuery plugin. Instead, we just use
// jQuery for its instantiation.
;(function( $, window, document, undefined )
{
	// our plugin constructor
	var Plugin = function( elem, options )
	{
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;

		// This next line takes advantage of HTML5 data attributes
		// to support customization of the plugin on a per-element
		// basis. For example,
		// <div class=item' data-plugin-options='{"message":"Goodbye World!"}'></div>
		this.metadata = this.$elem.data('plugin-options');
	};

	// the plugin prototype
	Plugin.prototype = {
		defaults : {
			message: 'Hello world!'
		},

		init : function()
		{
			// Introduce defaults that can be extended either 
			// globally or using an object literal. 
			this.config = $.extend({}, this.defaults, this.options, this.metadata);

			// Sample usage:
			// Set the message per instance:
			// $('#elem').plugin({ message: 'Goodbye World!'});
			// or
			// var p = new Plugin(document.getElementById('elem'), 
			// { message: 'Goodbye World!'}).init()
			// or, set the global default message:
			// Plugin.defaults.message = 'Goodbye World!'

			this.sampleMethod();
			return this;
		},

		sampleMethod : function()
		{
			// eg. show the currently configured message
			// console.log(this.config.message);
		}
	};

	Plugin.defaults = Plugin.prototype.defaults;

	$.fn.pluginTest7 = function(options)
	{
		return this.each(function()
		{
			new Plugin(this, options).init();
		});
	};

	//optional: window.Plugin = Plugin;
})( jQuery, window , document );

// ------------------------------------------------------------

//]]>