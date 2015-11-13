//<![CDATA[
/**
* Create a carousel slideshow
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:


<div id="testimonials">

	<div class="redlove_carousel"><!-- redlove_carousel-cover -->
		
		<div class="redlove_carousel-content-wrapper">
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
		</div>
		
	</div>

</div>

<style>
#panel-scroller .redlove_carousel-item {
	width: 300px;
}
</style>
<div id="panel-scroller">

	<div class="redlove_carousel"><!-- redlove_carousel-cover -->
		
		<div class="redlove_carousel-content-wrapper">
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>1 Food Pantry</h5>
				<p>Here can be three lines of text with no need for a "Read More" link because what you say what you need.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>2 Fellowship</h5>
				<p>Then each following item should have equal or less line length to keep things consistent.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>3 Addiction Struggles?</h5>
				<p>If you need to link to something, you can <a href="">put the link</a> in the text.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>4 Food Pantry</h5>
				<p>Here can be three lines of text with no need for a "Read More" link because what you say what you need.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>5 Fellowship</h5>
				<p>Then each following item should have equal or less line length to keep things consistent.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>6 Food Pantry</h5>
				<p>Here can be three lines of text with no need for a "Read More" link because what you say what you need.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>7 Fellowship</h5>
				<p>Then each following item should have equal or less line length to keep things consistent.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>8 Addiction Struggles?</h5>
				<p>If you need to link to something, you can <a href="">put the link</a> in the text.</p>
			</div>
			
		</div>
		
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($)
{
	$('#testimonials .redlove_carousel').redlove_carousel({debug : true});
	
	$('#panel-scroller .redlove_carousel').on('show_item', function ( event, obj )
	{
		console.log('hey! showing item!');
	});
	$('#panel-scroller .redlove_carousel').redlove_carousel({
		auto : true,
		debug : true,
		per_view : 3,
		scroll_interval : 1000
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
	proto.name = 'redlove_carousel';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		active_class : 'active',
		container : '',
		debug : false,
		content_wrapper_selector : '.redlove_carousel-content-wrapper',
		item_selector : '.redlove_carousel-item',
		nav_selector : '.redlove_carousel-nav',
		nav_prev_selector : '.redlove_carousel-nav_prev',
		nav_next_selector : '.redlove_carousel-nav_next',
		paging_selector : '.redlove_carousel-paging',
		
		auto : false,
		interval : 3000,
		transition: 'slide_horizontal',//fade,slide_horizontal
		transition_interval : 500,
		easing : 'easeOutCubic',
		
		per_view : 1,
		
		random : false,
		preload : false,
		sizer : '.redlove_carousel-sizer',
		images : [],
		
		callback : function(){},// Define an empty anonymous function so something exists to call
		
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
		inst.$document = $(document);
		
		// Plugin implementation code
		inst.timer = null;
		inst.hover = false;
		inst.slide_ratio = 0;
		inst.auto = inst.options.auto;
		
		inst.cur_index = 0;
		inst.num_items = 0;
		
		inst.$carousel = $(inst.element);
		inst.$content_wrapper = inst.$carousel.find(inst.options.content_wrapper_selector);
		inst.$items = inst.$carousel.find(inst.options.item_selector);
		inst.num_items = inst.$items.length;
		
		inst.$sizer = $(inst.options.sizer, inst.$carousel);
		inst.paging_template = '\
			<div class="redlove_carousel-paging">\
				<ol>\
					<li><a href="#"></a></li>\
				</ol>\
			</div>\
		';
		inst.$paging = $(inst.paging_template).prependTo(inst.$carousel);
		inst.$paging_ol = inst.$paging.find('ol');
		inst.$paging_li_clone = inst.$paging_ol.find('li').eq(0).clone();
		inst.$paging_ol.empty();
		
		// Setup slides
		if ( inst.options.transition == 'fade' )
		{
			inst.$items.hide();
		}
		
		// If randomizing the slides
		if ( inst.options.random )
		{
			inst.randomize(inst.$items);
		}
		
		// Handle mouse enter/leave
		inst.$carousel.on('mouseenter.' + proto.name, function(){inst.mouseenter();});
		inst.$carousel.on('mouseleave.' + proto.name, function(){inst.mouseleave();});
		
		// Gather navigation
		inst.nav_template = '\
			<div class="redlove_carousel-nav">\
				<a href="#" class="redlove_carousel-nav_prev"></a>\
				<a href="#" class="redlove_carousel-nav_next"></a>\
			</div>\
		';
		inst.$nav = $(inst.nav_template).prependTo(inst.$carousel);
		inst.$nav_prev = inst.$nav.find(inst.options.nav_prev_selector);
		inst.$nav_next = inst.$nav.find(inst.options.nav_next_selector);
		inst.$nav_prev.add(inst.$nav_next).removeClass('available unavailable');
		inst.$nav_prev.addClass('unavailable');
		inst.$nav_next.addClass(( inst.num_items <= inst.num_visible ? 'unavailable' : 'available' ));
		// Set navigation events
		inst.$nav_prev
		.add(inst.$nav_next)
		.off('click.' + proto.name)
		.on('click.' + proto.name, function ( event )
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			
			this.blur();
			inst.auto = false;
			
			// Check which link was clicked
			var is_prev = ( inst.$nav_prev.get(0) == this );
			
			// Increment index
			var index = inst.cur_index + ( is_prev ? -1 : 1 );
			inst.show_item(index);
		});
		
		// Set pagination events
		inst.$paging
		.off('click.' + proto.name, 'a')
		.on('click.' + proto.name, 'a', function ( event )
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			
			this.blur();
			inst.auto = false;
			
			// Go to the paging index
			var paging_index = $(this).parent().index();
			inst.show_item(paging_index);
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
		
		// Preload images
		if ( inst.options.preload )
		{
			inst.$images = inst.$carousel.find('img');
			
			var images_loaded = 0;
			$images
			.one('load.' + proto.name, function ( event )
			{
				images_loaded++;
				if ( images_loaded == $images.length )
				{
					inst.slide_ratio = this.width / this.height;
					
					if ( inst.auto )
					{
						inst.start_timer();
					}
					inst.show_item(inst.cur_index);
				}
			})
			.one('error.' + proto.name, function ( event )
			{
				$(this).trigger('load.' + proto.name);
			})
			.each(function ()
			{
				if ( this.complete )
				{
					$(this).trigger('load.' + proto.name);
				}
				// Cached images may not fire load, so we reset src
				else
				{
					this.src = this.src;
				}
			});
		}
		// Initialize the carousel
		else
		{
			if ( inst.auto )
			{
				inst.start_timer();
			}
			inst.show_item(inst.cur_index);
		}
	};
	
	/**
	* Update the plugin
	* 
	* @return object Plugin instance
	*/
	proto.update = function ()
	{
		var inst = this;
		
		// Reset content dimensions for base calculations
		var $items = inst.$items;
		$items.css({
			marginLeft : '',
			marginRight : '',
			width : ''
		});
		
		inst.$content_wrapper.css({
			height : 'auto',
			left : 0,
			width : 'auto'//999999
		});
		
		inst.$carousel
		.css({
			width : 'auto',
			height : 'auto'
		});
		
		inst.viewport_width = inst.$carousel.width();
		
		// Take off inline styles
		inst.$carousel
		.add(inst.$content_wrapper)
		.css({
			width : '',
			height : ''
		});
		
		// Get the max dimensions of items
		inst.max_item_width = 0;
		inst.max_item_height = 0;
		$items.each(function ( index )
		{
			var $item = $(this);
			inst.max_item_width = Math.max($item.outerWidth(), inst.max_item_width);
			inst.max_item_height = Math.max($item.outerHeight(), inst.max_item_height);
		});
		inst.max_item_width = Math.ceil(inst.max_item_width);
		inst.max_item_height = Math.ceil(inst.max_item_height);
		
		// Figure items per viewport
		inst.items_per_view = parseInt(inst.options.per_view) || 0;
		if ( inst.items_per_view == 0 )
		{
			inst.items_per_view = Math.floor(inst.viewport_width / inst.max_item_width);
		}
		
		var target_item_width = inst.viewport_width / inst.items_per_view;
		//target_item_width = +(Math.round(target_item_width + 'e+1')  + 'e-1');
		//target_item_width = target_item_width.toFixed(2);
		//target_item_width = Math.floor(target_item_width);
		var last_on_viewport_remainder = inst.viewport_width - (target_item_width * inst.items_per_view);
		
		var running_total_width = 0;
		
		// Normalize the item width with margins
		$items.each(function ( index )
		{
			var $item = $(this);
			var item_width = $item.outerWidth();
			
			var difference_x = 0;
			if ( item_width > 0 )
			{
				difference_x = target_item_width - item_width; 
			}
			
			var css = {};
			
			// If difference is negative, adjust item dimensions
			if ( difference_x < 0 )
			{
				css.width = target_item_width;
				css.marginLeft = 0;
				css.marginRight = 0;
			}
			// If difference is positive, adjust item margins
			else if ( difference_x > 0 )
			{
				var margin_x = Math.ceil(difference_x / 2);
				css.width = target_item_width - (margin_x * 2);
				css.marginLeft = margin_x;
				css.marginRight = margin_x;
			}
			
			if ( inst.options.center_vertical )
			{
				var item_height = $item.outerHeight();
				var difference_y = inst.max_item_height - item_height;
				var margin_y = Math.ceil(difference_y / 2);
				
				css.marginTop = margin_y;
				css.marginBottom = margin_y;
			}
			
			running_total_width += Math.ceil($item.width());
			running_total_width += Math.ceil(css.marginLeft);
			running_total_width += Math.ceil(css.marginRight);
			
			$item.css(css);
		});
		
		// Make items container wide enough for content
		inst.content_width = Math.ceil(target_item_width * inst.num_items);
		inst.$content_wrapper.width(inst.content_width);
		inst.num_visible = Math.floor(inst.viewport_width / target_item_width);
		if ( inst.num_visible > inst.num_items )
		{
			inst.num_visible = inst.num_items;
		}
		inst.num_views = Math.ceil(inst.content_width / inst.viewport_width);
		inst.cur_index = inst.wrap_index(inst.cur_index, inst.num_views);
		inst.move_amount = inst.num_visible * target_item_width;
		inst.max_left_prev = 0;
		inst.max_left_next = -(inst.num_views * inst.move_amount);
		
		if ( inst.options.debug )
		{
			console.log(proto.name + ' update()');
			console.log({
				$element : inst.$element.parent().attr('id') + ' ' + inst.$element.attr('class'),
				running_total_width : running_total_width,
				max_item_width : inst.max_item_width,
				max_item_height : inst.max_item_height,
				items_per_view : inst.items_per_view,
				target_item_width : target_item_width,
				content_width : inst.content_width,
				num_visible : inst.num_visible,
				num_items : inst.num_items,
				num_views : inst.num_views
			});
		}
		
		// Populate pagination
		inst.$paging_ol.empty();
		for ( var index = 0; index < inst.num_views; index++ )
		{
			var $new_li = inst.$paging_li_clone.clone();
			inst.$paging_ol.append($new_li);
		}
		
		inst.$paging
		.find('li').eq(inst.cur_index).addClass(inst.options.active_class);
		
		return inst;
	};
	
	/**
	* Show an item by index
	*/
	proto.show_item = function ( index )
	{
		var inst = this;
		
		inst.stop_timer();
		index = inst.wrap_index(index, inst.num_views);
		
		var transition_interval = ( index !== inst.cur_index ) ? inst.options.transition_interval : 0;
		
		// Make sure all item animations are completed
		inst.$items
		.add(inst.$content_wrapper)
		.stop(true, true)
		.clearQueue();
		
		// Figure new position
		var new_left = -(index * inst.move_amount);
		
		// Toggle nav
		inst.$nav_prev.add(inst.$nav_next).removeClass('available unavailable');
		var visibility_class = ( index == 0 || inst.num_views == 0 ) ? 'unavailable' : 'available';
		inst.$nav_prev.addClass(visibility_class);
		visibility_class = ( index == inst.num_views - 1 || inst.num_views == 0 ) ? 'unavailable' : 'available';
		inst.$nav_next.addClass(visibility_class);
		
		if ( inst.options.debug )
		{
			console.log(proto.name + ' show_item()');
			console.log({
				$element : inst.$element.parent().attr('id') + ' ' + inst.$element.attr('class'),
				cur_index : inst.cur_index,
				index : index,
				new_left : new_left,
				visibility_class : visibility_class,
				transition_interval : transition_interval,
				move_amount : inst.move_amount,
				num_items : inst.num_items,
				num_views : inst.num_views
			});
		}
		
		// Move the content wrapper to the index
		if ( inst.options.transition == 'slide_horizontal' )
		{
			inst.$content_wrapper
			.animate(
				{
					left : new_left
				},
				transition_interval,
				inst.options.easing,
				function ()
				{
					inst.start_timer();
				}
			);
		}
		// Fading slides
		else
		{
			// Previous
			if ( index !== inst.cur_index )
			{
				inst.$items
				.eq(inst.cur_index)
				//.animate({opacity : 0.1}, transition_interval, inst.options.easing)
				.fadeOut(inst.transition_interval);
			}
			
			// Next
			inst.$items
			.eq(index)
			//.animate({opacity : 1}, transition_interval, inst.options.easing)
			.fadeIn(
				inst.transition_interval,
				inst.options.easing,
				function ()
				{
					inst.start_timer();
				}
			);
		}
		
		// Set active class on elements
		inst.$items.removeClass(inst.options.active_class)
		.eq(index).addClass(inst.options.active_class);
		
		inst.$paging
		.find('li').removeClass(inst.options.active_class)
		.eq(index).addClass(inst.options.active_class);
		
		// Update the current index
		inst.cur_index = index;
		
		inst.$element.trigger('show_item.' + proto.name, {inst : inst});
	};
	
	/**
	* Start timer
	*/
	proto.start_timer = function ()
	{
		var inst = this;
		inst.stop_timer();
		
		if ( inst.auto && ! inst.hover && inst.$items.length > 1 )
		{
			inst.timer = setInterval(
				function ()
				{
					inst.show_item( inst.cur_index + 1 );
				},
				inst.options.interval + inst.options.transition_interval
			);
		}
	};
	
	/**
	* Stop timer
	*/
	proto.stop_timer = function ()
	{
		var inst = this;
		if ( inst.timer )
		{
			clearInterval(inst.timer);
		}
	};
	
	/**
	* Mouse enter handler
	*/
	proto.mouseenter = function ()
	{
		var inst = this;
		inst.hover = true;
		inst.stop_timer();
	};
	
	/**
	* Mouse leave handler
	*/
	proto.mouseleave = function ()
	{
		var inst = this;
		inst.hover = false;
		inst.start_timer();
	};
	
	/**
	* Wrap index
	*/
	proto.wrap_index = function ( index, total )
	{
		if ( total <= 0 )
		{
			return 0;
		}
		
		while ( index >= total )
		{
			index -= total;
		}
		
		while ( index < 0 )
		{
			index += total;
		}
		
		/*
		if ( index < 0 )
		{
			index = total - 1;
		}
		else if ( index > total - 1 )
		{
			index = 0;
		}
		*/
		
		return index;
	};
	
	/**
	* Randomize array
	* $($elements[Math.floor(Math.random() * $elements.length)]).click()
	* http://stackoverflow.com/questions/5329201/jquery-move-elements-into-a-random-order
	*/
	proto.randomize = function ( selector )
	{
		//$('<my selector>').sort( function(){ return ( Math.round( Math.random() ) - 0.5 ) } );
		
		var $element = $(selector);
		var $parent = $element.parent();
		$element
		.sort(function ()
		{
			/*
			// http://jsfiddle.net/MikeGrace/Vgavb/
			// Convert to integers from strings
			var a = parseInt($(a).attr('timestamp'), 10);
			var b = parseInt($(b).attr('timestamp'), 10);
			// Compare
			if ( a > b )
			{
				return 1;
			}
			else if ( a < b )
			{
				return -1;
			}
			else
			{
				return 0;
			}
			*/
			
			// Random
			return ( Math.round( Math.random() ) - 0.5 );
		})
		.detach()
		.appendTo($parent);
		
		/*
		// Sort random
		// https://css-tricks.com/snippets/jquery/shuffle-dom-elements/
		// http://jsfiddle.net/C6LPY/2/
		var parent = $('#shuffle');
		var divs = parent.children();
		while ( divs.length )
		{
			parent.append(divs.splice(Math.floor(Math.random() * divs.length), 1)[0]);
		}
		*/
		
		/*
		// Pick random element
		$($elements[Math.floor(Math.random() * $elements.length)]).click()
		*/
	};
	
	/**
	* Randomize array
	* http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
	*/
	proto.shuffle = function ( my_array )
	{
		var current_index = my_array.length, temporary_value, random_index;

		// While there remain elements to shuffle...
		while ( current_index !== 0 )
		{
			// Pick a remaining element...
			random_index = Math.floor(Math.random() * current_index);
			current_index -= 1;

			// And swap it with the current element.
			temporary_value = my_array[current_index];
			my_array[current_index] = my_array[random_index];
			my_array[random_index] = temporary_value;
		}

		return my_array;
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