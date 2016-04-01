//<![CDATA[
/**
* Modal window plugin
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:


<div id="modal-1" class="redlove_modal-container">
	<h1>Test content</h1>
	<p>This is some test content!</p>
</div>
<a href="#modal-1" class="redlove_modal-link">Modal 1</a>

<a href="#modal-2-and-3" onclick="$.fn.redlove_modal.show('test');$.fn.redlove_modal.show('<h2>Testing more</h2><p>A paragaph.</p><ul><li>list item</li></ul>');return false;">Modals 2 &amp; 3</a>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_modal.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_modal.js"></script>
<script type="text/javascript">

jQuery(document).ready(function($)
{
	$('.redlove_modal-link').redlove_modal({interval : 500});
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
		
		// If first plugin run, set up global event listeners, etc.
		if ( proto.num_instances == 1 )
		{
			// Setup action buttons used in modals
			$(document).on('click.redlove_modal', '.redlove_modal_action-close', function ( event )
			{
				event.preventDefault();
				$(this).closest('.redlove_modal').find('.redlove_modal_controls_close').trigger('click');
			});
		}
		
		return this;
	};
	// Private variables
	var proto = Plugin.prototype;
	// Plugin properties
	proto.name = 'redlove_modal';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		auto : true,
		callback : function(){},// Define an empty anonymous function so something exists to call
		debug : false,
		images : [],
		interval : 1000,
		transition_interval : 500,
		type : 'fade',//fade,slide_horizontal
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
		
		/*
		// Check for incoming hash to use
		this.check_hash();
		// Bind event to window if the existing event.namespace does not exist
		var event_name = 'hashchange.redlove_modal';
		if ( ! window.REDLOVE.fn.has_event(window, event_name) )
		{
			$(window).bind(event_name, function()
			{
				proto.check_hash();
			});
		}
		*/
	};
	
	/**
	* Update the plugin
	* 
	* @return object Plugin instance
	*/
	proto.update = function ()
	{
		this.$element.on( 'click.redlove_modal', this.on_click);
	};
	
	/**
	* Handle modal click
	* 
	* @return void
	*/
	proto.on_click = function ( event )
	{
		event.preventDefault();
		
		var $this = $(this);
		var self = $.data(this, proto.data_key);
		
		/*
		// Options
		$.each(this.attributes, function(i, attrib)
		{
			var name = attrib.name;
			var value = attrib.value;
			// do your magic :-)
		});
		*/
		
		var href = $this.attr('href');
		var parsed_url = window.REDLOVE.fn.parse_url(href);
		// If there is a hash and only a hash, treat as inline
		var $target = $('#' + parsed_url.hash);
		if (
			( parsed_url.hash && $target.length > 0 ) ||
			( self.options.mode == 'inline' )
		)
		{
			proto.show( $target.html(), self.options );//$target[0].outerHTML
		}
		else
		{
			var content = href;
			
			// YouTube
			var video_id = new RegExp('[\\?&]v=([^&#]*)').exec(href);
			if ( ! video_id )
			{
				video_id = new RegExp('youtu.be/([^&#]*)').exec(href);
			}
			if ( video_id && video_id[1] )
			{
				var width = self.options.width || 640;
				var height = self.options.height || 360;
				//self.options.width = width;
				//self.options.height = height;
				var youtube_src = '//www.youtube.com/embed/' + video_id[1] + '?&hl=en&fs=1&rel=0&autoplay=1&egm=0&showinfo=0&hd=0&loop=0&wmode=transparent&enablejsapi=1';
				content = '<div class="redlove_modal_embed"><iframe width="' + width + '" height="' + height + '" src="' + youtube_src + '" frameborder="0" allowfullscreen></iframe></div>';
			}
			
			proto.show( content, self.options, self );//$target[0].outerHTML
		}
		
		//proto.log(self);
		//proto.log('index: ' + $el.index() + ' auto: ' + self.options.auto);
		
		// Trigger custom event
		$this
		.trigger('modal_show', {modal : self});
	};
	
	/**
	* Show the modal
	* 
	* @return void
	*/
	proto.show = function ( content, options, self )
	{
		if ( typeof(self) !== 'object' || ! (self instanceof Plugin) )
		{
			options = $.extend( {}, proto.default_options, options );
		}
		
		// Remove existing modal
		var $modal = $('.redlove_modal');
		var $modal_visible = $modal.filter(':visible');
		/*
		if ( $modal_visible.length > 0 )
		{
			$modal_visible
			.stop(true, true)
			.remove();
		}
		*/
		
		if ( content == false )
		{
			//return;
		}
		
		// Prevent body scrolling
		$('body').addClass('redlove_no-scroll');
		
		var is_image = window.REDLOVE.fn.check_image_url(content);
		
		// Create content
		if ( is_image )
		{
			var $image = $('<img src="' + content + '">');
			content = $image[0].outerHTML;
		}
		
		// Create modal
		var content_class_addon = is_image ? ' redlove_modal_content-image' : '';
		
		var $modal = $('\
			<div class="redlove_modal">\
				<div class="redlove_modal_liner">\
					<div class="redlove_modal_controls_close"></div>\
					<div class="redlove_modal_controls_prev"></div>\
					<div class="redlove_modal_controls_next"></div>\
					<div class="redlove_modal_content' + content_class_addon + '">\
						<div class="redlove_modal_content_liner">\
							' + content + '\
						</div>\
					</div>\
				</div>\
			</div>\
		')
		.appendTo('body')
		.css({'opacity' : 0.0})
		.animate({'opacity' : 1.0}, 500);
		//.find('.redlove_modal_content')
		//.scrollTop(0);
		
		// Remove nav if no groups
		if ( ! options.group )
		{
			$modal.find('.redlove_modal_controls_prev, .redlove_modal_controls_next').remove();
		}
		
		var $modal_liner = $modal.find('.redlove_modal_liner');
		var $modal_content_liner = $modal.find('.redlove_modal_content_liner');
		resize_overlay();
		
		if ( options.addon_class )
		{
			$modal.addClass(options.addon_class);
		}
		if ( options.width )
		{
			$modal_liner.css({width : options.width});
		}
		if ( options.height )
		{
			$modal_liner.css({height : options.height});
		}
		
		if ( is_image )
		{
			$image
			.one('load.redlove_modal', function()
			{
				//$modal_liner.css({height: '', width: ''});
				resize_overlay();
				//console.log('loaded ' + this.width + ' ' + this.height + ' ' + this.naturalWidth + ' ' + this.naturalHeight);
				//console.log($('.redlove_modal_liner').width());
				//console.log(window.getComputedStyle(this, null).getPropertyValue('width'));
				//console.log(window.getComputedStyle(this, null).getPropertyValue('height'));
			}).each(function()
			{
				if ( this.complete )
				{
					$(this).load();
				}
			});
		}
		// Close modal
		$modal.on('click.redlove_modal', function( event )
		{
			//event.preventDefault();
			//event.stopImmediatePropagation();
			
			// Stop if not background or close click
			if ( 
				event.target != $modal[0] &&
				event.target != $modal.find('.redlove_modal_controls_close')[0]
			)
			{
				return;
			}
			
			// Remove modal
			$modal
			.stop()
			.animate({'opacity' : 0.0}, 500, function()
			{
				// Clean up and remove iframe from memory so it stops playing
				$(this)
				.find('iframe').hide()
				.end().remove();
				
				// Allow body scrolling
				if ( $modal_visible.length == 0 )
				{
					$('body').removeClass('redlove_no-scroll');
				}
			});
		});
		
		// Group navigation
		$modal.find('.redlove_modal_controls_prev, .redlove_modal_controls_next').on('click', function( event )
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			
			var is_prev = $(this).hasClass('redlove_modal_controls_prev');
			
			// Remove modal
			$modal
			.stop()
			.animate({'opacity' : 0.0}, 500, function()
			{
				// Clean up and remove iframe from memory so it stops playing
				$(this)
				.find('iframe').hide()
				.end().remove();
				
				// Allow body scrolling
				$('body').removeClass('redlove_no-scroll');
			
				if ( options.group )
				{
					var index = options.$group.index( el );
					index += is_prev ? -1 : 1;
					index = window.REDLOVE.fn.wrap_index( index, options.$group.length );
					options.$group.eq( index ).trigger('click');
				}
			});
		});
		
		// Resize on browser resize
		var overlay_resize_timeout;
		$(window).on('resize.redlove_modal', function()
		{
			if ( overlay_resize_timeout )
			{
				clearTimeout(overlay_resize_timeout);
				overlay_resize_timeout = null;
			}
			
			overlay_resize_timeout = setTimeout(resize_overlay, 100);
		});
		function resize_overlay()
		{
			// Automatically set dimensions to content dimensions
			$modal_content_liner.css({
				display: 'inline-block',
				width : 'auto'
			});
			$modal_liner.css({
				width: '',
				height: ''
			});
			
			var embed_class = 'redlove_modal_embed';
			var $embed = $modal_content_liner.find('.' + embed_class);
			if ( $embed.length > 0 )
			{
				$embed.removeClass(embed_class);
			}
			
			var liner_outside_width = $modal_liner.outerWidth();
			var liner_outside_height = $modal_liner.outerHeight();
			var liner_width = $modal_liner.width();
			var liner_height = $modal_liner.height();
			var liner_padding_width = liner_outside_width - liner_width;
			var liner_padding_height = liner_outside_height - liner_height;
			
			var content_width = $modal_content_liner.outerWidth(true);
			var content_height = $modal_content_liner.outerHeight(true);
			
			// If an image, use its dimensions
			if ( is_image )
			{
				var $image = $('.redlove_modal_content_liner > img');
				if ( $image.length > 0 )
				{
					var image = $image[0];
					content_width = image.naturalWidth;//image.width;
					content_height = image.naturalHeight;//image.height;
				}
			}
			else
			{
				// Add a little more width for inline text content adjustments
				if ( $embed.length == 0 )
				{
					content_width += 1;
				}
			}
			// Set dimension ratio of content
			var content_ratio = content_width / content_height;
			
			// Set max dimensions from which is smaller
			var max_width = Math.min(liner_width, content_width);
			var max_height = Math.min(liner_height, content_height);
			
			// Figure proportional dimensions
			var new_liner_width = max_height * content_ratio;
			new_liner_width = ( new_liner_width > max_width ) ? max_width : new_liner_width;
			var new_liner_height = new_liner_width / content_ratio;
			new_liner_height = ( new_liner_height > max_height ) ? max_height : new_liner_height;
			// Add padding
			new_liner_width += liner_padding_width;
			new_liner_height += liner_padding_height;
			
			// Set new liner dimensions
			$modal_liner.css({
				width: new_liner_width,
				height: new_liner_height
			});
			// Reset content liner
			$modal_content_liner.css({
				display: '',
				width : '',
				overflow : ( (content_height <= new_liner_height && content_width <= new_liner_width) ? 'hidden' : 'auto' )
			});
			
			if ( $embed.length > 0 )
			{
				$embed.addClass(embed_class);
			}
			
			/*
			console.log( 
				' liner:' + liner_width + ' x ' + liner_height + 
				' content_width:' + content_width + ' x ' + content_height + 
				' new liner:' + new_liner_width + ' x ' + new_liner_height + 
				''
			);
			*/
		};
	};
	
	/**
	* Check the browser hash
	* 
	* @return void
	*/
	proto.check_hash = function ()
	{
		if ( window.location.hash )
		{
			var hash = window.location.hash;//.replace('#', '');
			// If a matching element exists
			if ( $(hash).hasClass('redlove_modal-container') )
			{
				proto.show(hash);
			}
		}
	};
	
	/**
	* Get browser viewport
	* 
	* @return object Viewport dimensions
	*/
	proto.get_viewport = function ()
	{
		var e = window;
		var a = 'inner';
		if ( ! ('innerWidth' in window) )
		{
			a = 'client';
			e = document.documentElement || document.body;
		}
		return {
			width : e[ a + 'Width' ],
			height : e[ a + 'Height' ]
		};
	};
	
	/**
	* Set center
	* 
	* @return object jQuery object
	*/
	proto.center = function ( el )
	{
		var $this = $(el);
		$this.css({'position': 'absolute', 'top': '0px', 'left': '0px'});//absolute if going off of relative parent
		var top = Math.max(0, (($(window).height() - $this.outerHeight()) / 2));// + $(window).scrollTop()
		var left = Math.max(0, (($(window).width() - $this.outerWidth()) / 2));// + $(window).scrollLeft()
		$this.css({'top': top + 'px', 'left': left + 'px'});
		return $this;
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
	
})( jQuery, window, document );// End function closure
//]]>