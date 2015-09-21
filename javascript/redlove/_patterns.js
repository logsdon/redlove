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
		console.log('// Begin javascript_basic_plugin testing');
		var plugin1 = new javascript_basic_plugin({interval : 123});
		var plugin2 = new javascript_basic_plugin({interval : 456});
		
		console.log(plugin1.options);
		console.log(plugin2.options);
		plugin1.check_something();
		plugin2.check_something();
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin javascript_advanced_plugin testing');
		var plugin1 = new javascript_advanced_plugin({interval : 123});
		var plugin2 = new javascript_advanced_plugin({interval : 456});
		
		console.log(plugin1.options);
		console.log(plugin2.options);
		plugin1.run();
		plugin2.run();
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_basic_plugin testing');
		$('#basic-plugin_test-list-1').jquery_basic_plugin({arg1 : 'test-1'});
		$('#basic-plugin_test-list-2 li').jquery_basic_plugin({arg1 : 'test-2'});
		$('#basic-plugin_test-list-3').jquery_basic_plugin({arg1 : 'test-3'});
		
		var data = $('#basic-plugin_test-list-1').data('jquery_basic_plugin');
		console.log(data);
		$.fn.jquery_basic_plugin.check_load_complete(data);
		
		var data = $('#basic-plugin_test-list-2 li').data('jquery_basic_plugin');
		console.log(data);
		$.fn.jquery_basic_plugin.check_load_complete(data);
		
		var data = $('#basic-plugin_test-list-3').data('jquery_basic_plugin');
		console.log(data);
		$.fn.jquery_basic_plugin.check_load_complete(data);
		
		console.log('');
		$('#basic-plugin_test-list-1').jquery_basic_plugin.options;
		console.log('// ------------------------------------------------------------');
		console.log('');
		
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_advanced_plugin testing');
		console.log('How many instances have we created? ' + $.fn.jquery_advanced_plugin.prototype.num_instances );
		console.log('Our default options are...');
		console.log( $.fn.jquery_advanced_plugin.prototype.default_options );
		console.log('I am changing default_val to "waffles"');
		$.fn.jquery_advanced_plugin.prototype.default_options.default_val = 'waffles';
		
		console.log('Creating a plugin instance');
		$('#test-list-1').jquery_advanced_plugin({arg2 : 'test-1'});
		console.log('Updating a plugin instance');
		$('#test-list-1').jquery_advanced_plugin({arg1 : 'test-3'});
		console.log( $('#test-list-1').data('jquery_advanced_plugin').options );
		
		console.log('Creating a plugin instance');
		$('#test-list-2').jquery_advanced_plugin({arg1 : 'test-2'});
		
		console.log('Setting plugin data');
		console.log( $('#test-list-2').data('jquery_advanced_plugin').set_data('new key', 'new value') );
		console.log('Getting plugin data');
		console.log( $('#test-list-2').data('jquery_advanced_plugin').get_data() );
		
		console.log('I am changing default_val to "pancakes"');
		$('#test-list-2').data('jquery_advanced_plugin').default_options.default_val = 'pancakes';
		
		console.log('Creating a plugin instance');
		$('#test-list-3').jquery_advanced_plugin({arg1 : 'test-1'});
		
		console.log('Getting plugin reference');
		var plugin = $.fn.jquery_advanced_plugin.get_plugin('#test-list-3');
		console.log('Internal data');
		console.log( plugin.data );
		console.log('Updating a plugin instance');
		console.log( plugin.init() );
		
		console.log('How many instances have we created? ' + $.fn.jquery_advanced_plugin.prototype.num_instances );
		console.log('How many instances have we created? ' + $('#test-list-2').data('jquery_advanced_plugin').num_instances );
		console.log( $('#test-list-2').data('jquery_advanced_plugin').num_instances );
		console.log('Our default options are...');
		console.log( $.fn.jquery_advanced_plugin.prototype.default_options );
		console.log('// ------------------------------------------------------------');
		/*
		console.log('// ------------------------------------------------------------');
		console.log('// Begin jquery_advanced_plugin2 testing');
		console.log( $.fn.jquery_advanced_plugin2.num_instances );
		console.log( $.fn.jquery_advanced_plugin2.default_options );
		$('#test-list-1').jquery_advanced_plugin2({arg1 : 'test-1'});
		$('#test-list-2').jquery_advanced_plugin2({arg1 : 'test-2'});
		console.log('Set data...');
		//$('#test-list-1').data('jquery_advanced_plugin2').set_data('waffles');
		//$('#test-list-2').data('jquery_advanced_plugin2').set_data('doughnuts');
		console.log( $.fn.jquery_advanced_plugin2.num_instances );
		console.log( $.fn.jquery_advanced_plugin2.default_options );
		console.log( $('#test-list-1').data('jquery_advanced_plugin2').num_instances );
		console.log( $('#test-list-1').data('jquery_advanced_plugin2').default_options );
		console.log('Get data...');
		console.log( $('#test-list-1').data('jquery_advanced_plugin2').get_data() );
		console.log( $('#test-list-2').data('jquery_advanced_plugin2').get_data('#test-list-2') );
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
	var plugin_name = 'javascript_basic_plugin';
	var plugin_default_options = {
		callback : function(){},// Define an empty anonymous function so something exists to call
		color : '#556b2f',
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
		
		// Extend default options
		this.options = $.extend( {}, plugin_default_options, options );
		
		// Plugin instance properties
		this.now = 0;
		this.now = new Date().getTime();
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
	* Check something in the plugin instance
	* 
	* @return void
	*/
	window[plugin_name].prototype.check_something = function ()
	{
		console.log(plugin_name + ' check_something()');
		console.log(this.now);
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
	/**
	* Plugin constructor
	* 
	* @param mixed ... Accept any incoming arguments
	* @return object Plugin instance
	*/
	var Plugin = function ( options )
	{
		console.log(proto.name + '()');
		proto.num_instances++;
		this.init.apply(this, arguments);
		return this;
	};
	// Private variables
	var proto = Plugin.prototype;
	// Plugin properties
	proto.name = 'javascript_advanced_plugin';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		callback : function(){},// Define an empty anonymous function so something exists to call
		color : '#556b2f',
		debug : false,
		interval : 100,// Milliseconds
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
		console.log(proto.name + ' init()' + proto.num_instances);
		
		// Extend default options
		this.options = $.extend( {}, this.default_options, options );
		
		// Plugin properties
		this.data = this.data || {};
		this.now = 0;
		this.now = new Date().getTime();
		this.time_last_run = 0;
		
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
		
		// Plugin implementation code
		this.run();
		
		return this;
	};
	
	/**
	* Run plugin actions
	* 
	* @param mixed args Passed arguments
	* @return void
	*/
	proto.run = function ( args )
	{
		console.log(proto.name + ' run()');
		console.log(this.now);
		
		this.time_last_run = this.now;
		this.options.callback.call(this, args);
	};
	
	// Window plugin definition
	window[proto.name] = Plugin;
	
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
	// Private variables
	var plugin_name = 'jquery_basic_plugin';
	var plugin_data_key = plugin_name;
	var plugin_default_options = {
		callback : function(){},// Define an empty anonymous function so something exists to call
		color : '#556b2f',
		debug : false,
		interval : 100,// Milliseconds
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
		console.log(plugin_name + '()');
		
		// Extend default options
		var metadata = {};//this.$element.data( 'plugin-options' );//$(element).data();
		options = $.extend( {}, plugin_default_options, options, metadata );
		
		// Private variables
		var data = {
			$element : $(this),
			options : options,
			num_preloaded_images : 0,
			'' : ''// Empty so each property above ends with a comma
		};
		
		// Private methods
		
		/**
		* Check if all images are loaded
		* 
		* @return void
		*/
		function check_load_complete ()
		{
			if ( data.$element.length == data.num_preloaded_images )
			{
				data.options.oncomplete(data.num_preloaded_images);
			}
		}
		
		// Plugin code for each element
		return this.each(function ( index )
		{
			// Set data across all elements
			$.data(this, plugin_data_key, data);
			
			$(this).css({
				color : options.color
			});
		});
	};
	
	/**
	* Check if all images are loaded
	* 
	* @return void
	*/
	$.fn[plugin_name].check_load_complete = function ( data )
	{
		console.log(plugin_name + ' check_load_complete()');
		console.log(data);
		console.log(data.$element.length + ' == ' + data.num_preloaded_images);
		if ( data.$element.length == data.num_preloaded_images )
		{
			data.options.oncomplete(data.num_preloaded_images);
		}
	};
	
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
	/**
	* Plugin constructor
	* 
	* @param mixed ... Accept any incoming arguments
	* @return object Plugin instance
	*/
	var Plugin = function ()
	{
		console.log(proto.name + '()');
		proto.num_instances++;
		this.init.apply(this, arguments);
		return this;
	};
	// Private variables
	var proto = Plugin.prototype;
	// Plugin properties
	proto.name = 'jquery_advanced_plugin';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		callback : function(){},// Define an empty anonymous function so something exists to call
		color : '#556b2f',
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
		console.log(proto.name + ' init()' + proto.num_instances);
		
		// Stop if no arguments
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
		
		// Plugin properties
		this.data = this.data || {};
		
		// Plugin implementation code
		this.update();
	};
	
	/**
	* Update the plugin
	* 
	* @return void
	*/
	proto.update = function ()
	{
		console.log(proto.name + ' update()');
		
		this.$element.css({
			color : this.options.color
		});
		
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
	};
	
	/**
	* Get plugin reference
	* 
	* @param mixed el DOM element
	* @return object Plugin instance
	*/
	proto.get_plugin = function ( el )
	{
		console.log(proto.name + ' get_plugin()');
		var $el = el !== undefined ? $(el) : this.$element;
		return $el.data(proto.data_key);
	};
	
	/**
	* Set plugin reference
	* 
	* @param mixed el DOM element
	* @param mixed data Plugin instance
	* @return object Plugin instance
	*/
	proto.set_plugin = function ( el, data )
	{
		console.log(proto.name + ' set_plugin()');
		var tmp_data = data !== undefined ? data : el;
		var tmp_el = data !== undefined ? $(el) : this.$element;
		return tmp_el.data(proto.data_key, tmp_data);
	};
	
	/**
	* Get plugin data
	* 
	* @param mixed el DOM element
	* @param string key The data key for the associated value
	* @return void|mixed Plugin data
	*/
	proto.get_data = function ( el, key )
	{
		console.log(proto.name + ' get_data()');
		
		var data = this.data || this.get_plugin(el).data;
		if ( data === undefined )
		{
			return;
		}
		return ( key !== undefined ? data[key] : data );
	};
	
	/**
	* Set plugin data
	* 
	* @param mixed el DOM element
	* @param string key The data key for the associated value
	* @param mixed data The data to store
	* @return void|mixed Plugin data
	*/
	proto.set_data = function ( el, key, data )
	{
		console.log(proto.name + ' set_data()');
		
		var tmp_data = data !== undefined ? data : key;
		var tmp_key = data !== undefined ? key : el;
		var tmp_el = data !== undefined ? $(el) : this.$element;
		
		var plugin_inst = this.get_plugin(tmp_el);
		if ( plugin_inst === undefined )
		{
			return;
		}
		
		if ( tmp_key !== undefined )
		{
			plugin_inst.data[tmp_key] = tmp_data;
		}
		else
		{
			plugin_inst.data = tmp_data;
		}
		
		return tmp_data;
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
			var plugin_inst = $.data(this, proto.data_key);//proto.get_plugin(this)
			if ( ! plugin_inst )
			{
				plugin_inst = new Plugin(this, options);
				$.data(this, proto.data_key, plugin_inst);//proto.set_plugin(plugin_inst)
			}
			else
			{
				plugin_inst.init(this, options);
			}
		});
	};
	// Reference the Plugin prototype to access properties and methods without instantiation
	$.fn[proto.name].prototype = Plugin.prototype//Object.create();
	// Create Plugin references to public prototype functions at the jQuery definition root
	for ( var key in Plugin.prototype )
	{
		if ( $.type(Plugin.prototype[key]) == 'function' && key.indexOf('_') !== 0 )
		{
			$.fn[proto.name][key] = Plugin.prototype[key];
		}
	}
	// Window plugin definition
	//window[proto.name] = Plugin;
	
})( jQuery, window, document );// End function closure

// ------------------------------------------------------------

//]]>