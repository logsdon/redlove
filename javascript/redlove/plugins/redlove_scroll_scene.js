//<![CDATA[
/**
* Create an overall scroll controller to handle scroll events, 
* then add scroll scenes with trigger/target details and handling events
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_scroll_scene.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_scroll_scene.js"></script>
<style type="text/css">
#affix-test {
	background: blue;
	width: 100%;
	z-index: 1;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo redlove_cb_url('javascript/redlove/plugins/redlove_scroll_scene.css'); ?>">
<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/redlove/plugins/redlove_scroll_scene.js'); ?>"></script>
<script type="text/javascript">
jQuery(document).ready(function ( $ )
{
	window['scroll_controller'] = window['scroll_controller'] || new redlove_scroll_scene({debug : true});
	
	window.scroll_controller.add_scene({
		debug : false,
		name : 'Specific pixel area test',
		
		trigger_window_scale_y : 0,
		
		start : 100,
		stop : 500,
		
		scroll_handler : function ( event, params )
		{
			if ( params.scene.controller.options.debug )
			{
				console.log('scene: ' + this.name + ' event.type: ' + event.type);
			}
		},
		
		'' : ''
	});
	
	window.scroll_controller.add_scene({
		debug : false,
		name : 'Scroll over specific element',
		
		trigger_window_scale_y : 0.75,
		
		selector : '.screen[id="test-screen"]',
		
		scroll_handler : function ( event, params )
		{
			if ( this.debug )
			{
				console.log('scene: ' + this.name + ' event.type: ' + event.type);
			}
		},
		
		'' : ''
	});
	
	window.scroll_controller.add_scene({
		name : 'Return to top',
		
		trigger_window_scale_y : 0,
		
		start : function () {
			return window.scroll_controller.$window.height() / 2;
		},
		
		$affix_element : $('#return-to-top'),
		affixed_class : 'fixed',
		affixed_placeholder_class : '',
		create_placeholder : false,
		
		scroll_handler : function ( event, params )
		{
			if ( event.type == 'enter' )
			{
				this.$affix_element.addClass(params.scene.affixed_class);
			}
			else if ( event.type == 'leave' )
			{
				this.$affix_element.removeClass(params.scene.affixed_class);
			}
			
			// Parallax
			// Treat document_height - window_height as 100% goal window_scroll_top is reaching
			var goal = $document.height() - window_height;
			var percent = (window_scroll_top > 0 ) ? window_scroll_top / goal : 0;
			console.log('parallax: ' + window_scroll_top + ' ' + goal + ' ' + percent);
		},
		
		'' : ''
	});
	
	window.scroll_controller.add_scene({
		debug : false,
		name : 'Affix test',
		
		trigger_window_scale_y : 0,
		trigger_offset_y : 20,
		
		start : 300,
		
		$affix_element : $('#affix-test'),
		affixed_class : 'redlove_affixed',
		affixed_placeholder_class : 'redlove_affixed_placeholder',
		create_placeholder : true,
		
		resize_handler : function ( event, params )
		{
			this.$affix_element
			.css({
				left : '',
				top : '',
				width : ''
			})
			.removeClass(params.scene.affixed_class);
		},
		
		scroll_handler : function ( event, params )
		{
			if ( this.debug )
			{
				console.log('scene: ' + this.name + ' event.type: ' + event.type);
			}
			
			if ( event.type == 'enter' )
			{
				// If already affixed, stop
				if ( this.$affix_element.hasClass(params.scene.affixed_class) )
				{
					return;
				}
				
				this.$affix_element
				.addClass(params.scene.affixed_class);
				var tmp_css ={
					left : params.item.css.left,
					right : 'auto',
					top : params.item.css.top,
					bottom : 'auto'
				};
				
				if ( this.create_placeholder )
				{
					$('<div class="' + params.scene.affixed_placeholder_class + '"></div>')
					.css('height', this.$affix_element.height())
					.insertAfter(this.$affix_element);
				}
			}
			else if ( event.type == 'leave' )
			{
				this.$affix_element.removeClass(params.scene.affixed_class);
				var tmp_css = {
					left : params.item.css.left,
					right : params.item.css.right,
					top : params.item.css.top,
					bottom : params.item.css.bottom
				};
				
				if ( this.create_placeholder )
				{
					this.$affix_element.next('.' + params.scene.affixed_placeholder_class).remove();
				}
			}
		},
		
		'' : ''
	});
	
	var stickynav_scene = window.scroll_controller.add_scene({
		debug : false,
		name : 'Sticky nav test',
		
		trigger_window_scale_y : 0.5,
		
		selector : '.screen[id]',
		
		scroll_handler : function ( event, params )
		{
			if ( this.debug )
			{
				console.log('scene: ' + this.name + ' event.type: ' + event.type);
			}
			
			if ( event.type == 'enter' )
			{
				// Add active
				var $item = params.item.element;
				
				$('#stickynav')
				.parentsUntil('ul')
				.find('a[href="#' + $item.attr('id') + '"]')
				.parent()
				.addClass('active');
			}
			else if ( event.type == 'leave' )
			{
				// Remove active
				var $item = params.item.element;
				
				$('#stickynav')
				.parentsUntil('ul')
				.find('a[href="#' + $item.attr('id') + '"]')
				.parent()
				.removeClass('active');
			}
		},
		
		'' : ''
	});
	
	$('.next-button').on('click', function ( event )
	{
		event.preventDefault();
		
		$('html, body').animate({
			scrollTop : stickynav_scene.items[stickynav_scene.scroll_item_index_next].top
		}, 1000, function(){});
	});
	
	$('#sidebar a').bind('click', function ( event )
	{
		event.preventDefault();
		
		$('html, body').animate({
			scrollTop : $( $(this).attr('href') ).offset().top - 40
		}, 500);
	});
	
});
</script>

<div id="affix-test">
	A test
	<a href="#" class="next-button button button-message">Next</a>
	<ul id="stickynav">
		<li><a href="#rsvp">Section 1</a></li>
		<li><a href="#invite">Section 2</a></li>
		<li><a href="#section-3">Section 3</a></li>
	</ul>
</div>
<div class="screen" id="test-screen">
	Screen
</div>

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
		proto.name = 'redlove_scroll_scene';
		proto.namespace = '.' + proto.name;
		proto.num_instances = 0;
		proto.default_options = {
			debug : false,
			debug_trigger_class : 'redlove_scroll_scene_trigger_debug',
			throttle_milliseconds : 250,// Milliseconds
			'' : ''// Empty so each property above ends with a comma
		};
		
		proto.default_scene = {
			index : undefined,
			controller : undefined,
			
			trigger_window_scale_y : 0.5,
			trigger_offset_y : 0,
			
			selector : undefined,
			item : undefined,
			items : undefined,
			scroll_item_index : undefined,
			scroll_item_index_next : undefined,
			percent_scrolled : undefined,
			full_document : false,
			
			start : undefined,
			stop : undefined,
			duration : undefined,
			height : undefined,
			
			//load_handler : function ( event, params ){},
			//resize_handler : function ( event, params ){},
			scroll_handler : function ( event, params ){},
			
			'' : ''
		};
		
		// Plugin methods
		
		/**
		* Initialize plugin
		* 
		* @param mixed options Plugin options object
		* @return object Plugin instance
		*/
		proto.init = function ( options, scenes )
		{
			var inst = this;
			
			// Extend default options
			inst.options = $.extend( {}, inst.default_options, options );
			
			// Plugin properties
			inst.namespace = proto.namespace + '.' + proto.num_instances;
			
			inst.throttle_time_last = 0;
			inst.debounce_timeout;
			inst.scroll_x_last = undefined;
			inst.scroll_y_last = undefined;
			inst.delta_v = 0;
			inst.delta_h = 0;
			inst.scenes = [];
			
			inst.$window = $(window);
			inst.$document = $(document);
			
			// Plugin implementation code
			
			inst.add_scene(scenes);
			
			inst.$window
			.one('load' + inst.namespace, function ( event )
			{
				inst.scenes_load_handler();
				inst.update(event);
			})
			.on('resize' + inst.namespace, function ( event )
			{
				inst.scenes_resize_handler();
				inst.update(event);
			})
			.on('scroll' + inst.namespace, function ( event )
			{
				inst.update(event);
			});
			
			inst.update();
			
			/* Use redlove_throttle
			var $element = $('#return-to-top');
			$element.on('click', function ( event )
			{
				event.preventDefault();
				$('html,body').animate({'scrollTop' : 0}, 'slow', function(){});
			});
			
			var $window = $(window);
			var $document = $(document);
			var window_height = $window.height();
			var scroll_target_top = window_height / 2;//$element.offset().top;
			var throttle_options = {
				interval : 250,
				run_at_start : true,
				run_at_end : true,
				callback : function ( self, args )
				{
					var window_scroll_top = $window.scrollTop();
					
					// Return to top
					if ( window_scroll_top > scroll_target_top )
					{
						$element.addClass('fixed');
					}
					else
					{
						$element.removeClass('fixed');
					}
					
					// Parallax
					// Treat document_height - window_height as 100% goal window_scroll_top is reaching
					var goal = $document.height() - window_height;
					var percent = (window_scroll_top > 0 ) ? window_scroll_top / goal : 0;
					console.log('parallax: ' + window_scroll_top + ' ' + goal + ' ' + percent);
				}
			};
			var my_throttle = new redlove_throttle(throttle_options);
			my_throttle.handler();
			$(window).scroll(my_throttle.handler);
			*/
			
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
			
			if ( inst.options.debug )
			{
				console.log('update: event.type ' + event.type + ' ' + event.namespace);
			}
			
			// Throttle (ensures 1 action during interval) and Debounce (ensures 1 action after interval)
			var now = new Date().getTime();
			var throttle_time_elapsed = now - inst.throttle_time_last;
			
			if ( inst.options.debug )
			{
				console.log(
					'update: elapsed: ' + throttle_time_elapsed + 
					' and last: ' + inst.throttle_time_last + 
					' and now: ' + now + 
					' and throttle: ' + inst.options.throttle_milliseconds
				);
			}
			
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
					if ( inst.options.debug )
					{
						console.log('debounce_timeout: ' + debounce_milliseconds);
					}
					inst.update(event);
				}, debounce_milliseconds);
				
				return;
			}
			inst.throttle_time_last = now;
			
			if ( inst.options.debug )
			{
				console.log('run normal: ' + throttle_time_elapsed);
			}
			
			// Actual code implementation
			
			inst.process_scroll();
			
			if ( event === undefined || event.type !== 'scroll' )
			{
				inst.update_scenes();
			}
			
			inst.process_scenes();
			
			return inst;
		};
		
		/**
		* Process scroll event
		* 
		* @return void
		*/
		proto.process_scroll = function ()
		{
			var inst = this;
			
			// Update scroll last
			inst.scroll_y_last = inst.scroll_y;
			
			// Get current scroll
			inst.scroll_y = inst.$window.scrollTop();
			
			// Set scroll delta/direction
			inst.delta_h = 0;
			if ( inst.scroll_y > inst.scroll_y_last )
			{
				inst.delta_h = 1;
			}
			else if ( inst.scroll_y < inst.scroll_y_last )
			{
				inst.delta_h = -1;
			}
		};
		
		/**
		* Update scenes data
		* 
		* @param object events Passed scenes
		* @return void
		*/
		proto.update_scenes = function ( scenes )
		{
			var inst = this;
			
			scenes = ( scenes === undefined ) ? inst.scenes : scenes;
			
			// Makes scenes an array
			if ( typeof(scenes) !== 'object' )
			{
				scenes = [];
			}
			else
			{
				if ( Object.prototype.toString.call( scenes ) !== '[object Array]' )
				{
					scenes = [scenes];
				}
			}
			
			// Set common data
			inst.document_height = inst.$document.height();
			inst.window_height = inst.$window.height();
			
			// Update scene item data
			for ( var index in scenes )
			{
				var scene = scenes[index];
				
				// If a collection of items
				if ( typeof(scene.selector) !== 'undefined' )
				{
					scene.items = inst.gather_scroll_items(scene);
				}
				// If a single item
				else if ( typeof(scene.start) !== 'undefined' )
				{
					var top = 0;
					if ( typeof(scene.start) === 'function' )
					{
						top = scene.start.apply(this, []);
					}
					else if ( typeof(scene.start) === 'string' || typeof(scene.start) === 'object' )
					{
						top = $(scene.start).offset().top;
					}
					else
					{
						top = scene.start;
					}
					
					var bottom = top;
					if ( typeof(scene.stop) !== 'undefined' )
					{
						if ( typeof(scene.stop) === 'function' )
						{
							bottom = scene.stop.apply(this, []);
						}
						else if ( typeof(scene.stop) === 'string' || typeof(scene.stop) === 'object' )
						{
							bottom = $(scene.stop).offset().top + $(scene.stop).outerHeight(true);
						}
						else
						{
							bottom = scene.stop;
						}
					}
					else if ( typeof(scene.height) !== 'undefined' )
					{
						if ( typeof(scene.height) === 'function' )
						{
							bottom = top + scene.height.apply(this, []);
						}
						else if ( typeof(scene.height) === 'string' || typeof(scene.height) === 'object' )
						{
							bottom = top + $(scene.height).offset().top + $(scene.height).outerHeight(true);
						}
						else
						{
							bottom = top + scene.height;
						}
					}
					else if ( typeof(scene.duration) !== 'undefined' )
					{
						bottom = top + scene.duration;
					}
					else
					{
						bottom = inst.document_height;
					}
					
					// Set single item data
					scene.items = [{
						offset : {},
						css : {},
						top : top,
						right : undefined,
						bottom : bottom,
						left : undefined,
						element : undefined
					}];
					
					if ( inst.options.debug )
					{
						console.log('scene item...');
						console.log(scene.items[0]);
					}
				}
			}
		};
		
		/**
		* Scenes load handler
		* 
		* @param array scenes Passed scenes
		* @return void
		*/
		proto.scenes_load_handler = function ( scenes )
		{
			var inst = this;
			
			scenes = ( scenes === undefined ) ? inst.scenes : scenes;
			
			// Iterate over scroll sceness
			for ( var index in scenes )
			{
				var scene = scenes[index];
				if ( typeof(scene.load_handler) === 'function' )
				{
					scene.load_handler({type : 'load', namespace : inst.namespace.substr(1)}, {scene : scene});
				}
			}
		};
		
		/**
		* Scenes resize handler
		* 
		* @param array scenes Passed scenes
		* @return void
		*/
		proto.scenes_resize_handler = function ( scenes )
		{
			var inst = this;
			
			scenes = ( scenes === undefined ) ? inst.scenes : scenes;
			
			// Iterate over scroll sceness
			for ( var index in scenes )
			{
				var scene = scenes[index];
				if ( typeof(scene.resize_handler) === 'function' )
				{
					scene.resize_handler({type : 'resize', namespace : inst.namespace.substr(1)}, {scene : scene});
				}
			}
		};
		
		/**
		* Process scenes
		* 
		* @param array scenes Passed scenes
		* @return void
		*/
		proto.process_scenes = function ( scenes )
		{
			var inst = this;
			
			scenes = ( scenes === undefined ) ? inst.scenes : scenes;
			
			// Iterate over scroll sceness
			for ( var index in scenes )
			{
				var scene = scenes[index];
				
				// Figure trigger position
				var trigger_window_scale_y = ( typeof(scene.trigger_window_scale_y) !== 'undefined' ) ? scene.trigger_window_scale_y : 0.5;
				var trigger_window_y =  trigger_window_scale_y * inst.window_height;
				var trigger_offset_y = ( typeof(scene.trigger_offset_y) !== 'undefined' ) ? scene.trigger_offset_y : 0;
				var trigger_y = inst.scroll_y + trigger_window_y + trigger_offset_y;
				
				// Show indicators
				if ( inst.options.debug )
				{
					var selector = '.' + inst.options.debug_trigger_class + '[data-trigger-for="' + index + '"]';
					$(selector).remove();
					var $trigger = $('<div class="' + inst.options.debug_trigger_class + '" data-trigger-for="' + index + '">Trigger for Scene ' + index + '</div>')
					.css({top: trigger_y});
					$('body').append($trigger);
				}
				
				// Loop over items
				if ( scene.items !== undefined )
				{
					for ( var index = 0; index < scene.items.length; index++ )
					{
						var item = scene.items[index];
						
						// If scrolling in the scene
						if ( trigger_y >= item.top && trigger_y < item.bottom )
						{
							scene.scroll_item_index = index;
							scene.scroll_item_index_next = ( index == scene.items.length - 1 ) ? 0 : index + 1;
							scene.scroll_item_index_prev = ( index == 0 ) ? scene.items.length - 1 : index - 1;
							
							var length_to_scroll = (item.bottom - item.top);
							var length_scrolled = trigger_y - item.top;
							var percent_scrolled = length_scrolled / length_to_scroll;
							item.percent_scrolled = percent_scrolled;
							if ( inst.options.debug )
							{
								console.log('percent_scrolled: ' + percent_scrolled);
							}
							
							// If the scene hasn't been entered in yet, trigger enter
							if ( item.entered === undefined )
							{
								item.entered = true;
								scene.scroll_handler({type : 'enter'}, {scene : scene, item : item});
							}
							
							// Trigger scrolling in scene
							scene.scroll_handler({type : 'in'}, {scene : scene, item : item});
							continue;
						}
						// If not scrolling in the scene and has been entered, trigger leave
						else if ( item.entered !== undefined )
						{
							item.entered = undefined;
							scene.scroll_handler({type : 'leave'}, {scene : scene, item : item});
							continue;
						}
					}
				}
			}
		};
		
		/**
		* Gather item offset data
		* 
		* @param object scene A scroll scene
		* @return mixed Processed items
		*/
		proto.gather_scroll_items = function ( scene )
		{
			var items = [];
			var $elements = $(scene.selector);
			for ( var index = 0; index < $elements.length; index++ )
			{
				var $element = $elements.eq(index);
				var offset = $element.offset();
				var height = $element.outerHeight(true);
				var width = $element.outerWidth(true);
				var bottom = ( scene.full_document && index == $elements.length - 1 ) ? this.$document.height() : offset.top + height;
				var right = ( scene.full_document && index == $elements.length - 1 ) ? this.$document.width() : offset.left + width;
				
				var data = {
					index : index,
					
					offset : offset,
					left : offset.left,
					right : right,
					top : offset.top,
					bottom : bottom,
					
					height : height,
					width : width,
					
					css : {
						left : $element.css('left'),
						right : $element.css('right'),
						top : $element.css('top'),
						bottom : $element.css('bottom'),
						position : $element.css('position')
					},
					
					element : $element
				};
				items.push(data);
			}
			
			return items;
		};
		
		/**
		* Add scroll scene
		* 
		* @param object|array scene A scroll scene or array of scenes
		* @return object The full scroll scene
		*/
		proto.add_scene = function ( scenes )
		{
			var inst = this;
			
			var object_scenes = false;
			
			// Makes scenes an array
			if ( typeof(scenes) !== 'object' )
			{
				scenes = [];
			}
			else
			{
				if ( Object.prototype.toString.call( scenes ) !== '[object Array]' )
				{
					object_scenes = true;
					scenes = [scenes];
				}
			}
			
			for ( var index = 0; index < scenes.length; index++ )
			{
				var scene = scenes[index];
				scene = jQuery.extend(true, {}, this.default_scene, scene);
				scene.index = this.scenes.length;
				scene.controller = this;
				inst.update_scenes(scene);
				this.scenes.push(scene);
			}
			
			return object_scenes ? inst.scenes[inst.scenes.length - 1] : inst.scenes;
		};
		
		/**
		* Remove scroll scene
		* 
		* @param object scene A scroll scene
		* @return void
		*/
		proto.remove_scene = function ( scene )
		{
			var index = ( typeof(scene) !== 'object' ) ? parseInt(scene) : scene.index;
			
			// Find the index of the scene for removal
			//array.indexOf(scene);
			// Remove the scene and adjust keys
			//array.splice(index, 1);
			
			// Delete array value but keep index position
			delete this.scenes[index];
		};
		
		/**
		* Destroy scroll controller
		* 
		* @param void
		* @return void
		*/
		proto.destroy = function ()
		{
			var inst = this;
			
			inst.$window
			.off('resize' + inst.namespace)
			.off('scroll' + inst.namespace);
			
			inst = null;
			delete inst;
			console.log(inst);
			
			proto.num_instances--;
		};
		
		// Window plugin definition
		window[proto.name] = Plugin;
		
	})( jQuery, window, document );// End function closure
	
})();// End function closure
//]]>
