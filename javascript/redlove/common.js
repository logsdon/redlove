//<![CDATA[
/**
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
*/

// --------------------------------------------------------------------

// On window load
jQuery(window).load(function ()
{
	// Page has loaded, toggle loading/loaded
	$('html').removeClass('loading').addClass('loaded');
});

// --------------------------------------------------------------------

// On DOM ready
jQuery(document).ready(function ( $ )
{
	
	// --------------------------------------------------------------------
	
	// Remove "no JavaScript" class from DOM
	$('.no-js').removeClass('no-js');
	
	// --------------------------------------------------------------------
	
	// If iPhone, iPod, or iPad
	if ( navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i) )
	{
		// Fix label clicking
		// http://www.thewatchmakerproject.com/blog/how-to-fix-the-broken-ipad-form-label-click-issue
		jQuery(document).ready(function ()
		{
			//$($(this).attr('for')).focus();
			$('label[for]').click(function ()
			{
				var el = $(this).attr('for');
				if ($('#' + el + '[type=radio], #' + el + '[type=checkbox]').attr('selected', !$('#' + el).attr('selected'))) {
					return;
				} else {
					$('#' + el)[0].focus();
				}
			});
		});
		
		// ----------------------------------------
		
		// Scroll to hide address bar on page load
		jQuery(window).load(function ()
		{
			setTimeout(function(){window.scrollTo(0, 1);}, 100);
		});
	}
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Links
	// --------------------------------------------------------------------
	
	// Smooth scroll anchor links
	// http://css-tricks.com/snippets/jquery/smooth-scrolling/
	$('.redlove_smooth-scroll a[href*=#]:not([href=#])').click(function ()
	{
		if (
			location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && 
			location.hostname == this.hostname
		)
		{
			var $root = $('html, body');
			var offset = -20;
			var hash = this.hash;
			var target = $(hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			var target_scroll_top = ( target.length > 0 ) ? target.offset().top : 0;
			target_scroll_top += offset;
			
			$root.animate({
				scrollTop: target_scroll_top
			}, 
			1000, 
			function() {
				// Swap out targets long enough to change the hash without moving to them
				var id = target.attr('id');
				var name = target.attr('name');
				target.attr('id', '');
				target.attr('name', '');
				window.location.hash = hash;
				target.attr('id', id);
				target.attr('name', name);
				//$root.scrollTop(target_scroll_top);
			});
			return false;
		}
	});
	
	// External links
	$(document).on('click', 'a[rel="external"], a[rel="document"]', function ( event )
	{
		event.preventDefault();
		window.open($(this).attr('href'));
		return false;
	});

	// Print links
	$(document).on('click', 'a[rel="print"]', function ( event )
	{
		event.preventDefault();
		window.print();
	});

	// Back links
	$(document).on('click', 'a[rel="back"]', function ( event )
	{
		event.preventDefault();
		window.history.back();
	});

	// Disabled Tab
	$(document).on('click', '.disabled', function ( event )
	{
		event.preventDefault();
	});

	// Create popup window
	$(document).on('click', '.popup-window', function ( event )
	{
		event.preventDefault();
		var width = 626,
			height = 436,
			left = ($(window).width() - width) / 2,
			top = ($(window).height() - height) / 2,
			url = this.href,
			opts = 'status=1' +
			',width=' + width +
			',height=' + height +
			',top=' + top +
			',left=' + left;
		window.open(url, 'popupwindow', opts);
		this.blur();
		return false;
	});

	// Form submit
	$(document).on('click', '.form-submit', function ( event )
	{
		event.preventDefault();
		$(this).closest('form').trigger('submit');
	});
	
	// Clickthrough elements functionality
	// http://stackoverflow.com/questions/3680429/click-through-a-div-to-underlying-elements
	// pointer-events:none
	$(document).on('click', '.click-through', function ( event )
	{
		event = event || window.event;
		$this = $(this);
		// make finger disappear
		$this.hide(0);
		// get element at point of click
		starter = document.elementFromPoint(event.clientX, event.clientY);
		// send click to element at finger point
		$(starter).click();
		// bring back the finger
		$this.show(0);
	});
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Media
	// --------------------------------------------------------------------
	
	// Fluid width video
	/*
	//http://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
	//http://css-tricks.com/NetMag/FluidWidthVideo/demo.php
	//http://www.bymichaellancaster.com/blog/fluid-iframe-and-images-without-javascript-plugins/
	var $videos = $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src^="//www.youtube.com"], object, embed');
	// The element that is fluid width
	var $fluid_el = $('body');
	// Figure out and save aspect ratio for each video
	$videos.each(function()
	{
		$(this)
		// jQuery .data does not work on object/embed elements
		.attr('data-aspect_ratio', this.height / this.width)
		// and remove the hard coded width/height
		.removeAttr('height')
		.removeAttr('width');
	});
	// When the window is resized
	$(window).resize(function()
	{
		var new_width = $fluid_el.width();
		// Resize all videos according to their own aspect ratio
		$videos.each(function()
		{
			var $el = $(this);
			$el
			.width(new_width)
			.height(new_width * $el.attr('data-aspect_ratio'));
		});
	})
	// Kick off one resize to fix all videos on page load
	.resize();
	*/
	/*
	var $embed_videos = $('iframe[src^="http://player.vimeo.com"], iframe[src^="http://www.youtube.com"], iframe[src^="//www.youtube.com"], object, embed');
	// Figure out and save aspect ratio for each video
	$embed_videos.each(function()
	{
		var aspect_ratio = this.height / this.width;
		
		var $video_el = $(this);
		// Create embed, set padding to aspect ratio fill, insert after the video temporarily
		var $embed_el = $('<div class="embed"></div>')
		.css('padding-bottom', (aspect_ratio * 100) + '%')
		.insertAfter($video_el);
		
		// Set the aspect ratio data, move video inside embed
		$video_el
		// jQuery .data does not work on object/embed elements
		.attr('data-aspect_ratio', aspect_ratio)
		.appendTo($embed_el);
	});
	*/
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Analytics
	// --------------------------------------------------------------------
	
	// Register analytics event
	$(document).on('click', '.analytics_event', function ( event )
	{
		var $this = $(this);
		var data = $this.data();
		var category = ( data.category !== undefined ) ? data.category : 'link';
		var action = ( data.action !== undefined ) ? data.action : 'click';
		var label = ( data.label !== undefined ) ? data.label : ( $this.attr('title') || $this.text() );
		var href = $this.attr('href');
		
		REDLOVE.fn.send_analytics_event( href, category, action, label );
	});
	
	// Register analytics page hit
	$(document).on('click', '.analytics_page', function ( event )
	{
		var $this = $(this);
		var data = $this.data();
		var href = ( data.href !== undefined ) ? data.href : $this.attr('href');
		var title = ( data.title !== undefined ) ? data.title : ( $this.attr('title') || $this.text() );
		
		REDLOVE.fn.send_analytics_page( href, title );
	});
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Responsive
	// --------------------------------------------------------------------
	
	// Create dropdown select from nav
	var $responsive_nav_desktop = $('.responsive-nav_desktop');
	if ( $responsive_nav_desktop.length > 0 )
	{
		var $select_container = $('<div class="responsive-nav_mobile" />').insertAfter($responsive_nav_desktop);
		var $select = $('<select />').appendTo($select_container);
		
		// Create default option
		$('<option />', {
			'value': '',
			'text': 'Go to...'
		})
		.prop('selected', true)
		.appendTo($select);
		
		// Populate with menu items
		$responsive_nav_desktop.find('a:not(.not-responsive)').each(function(i)
		{
			var el = $(this);
			$('<option />', {
				//'selected': 'selected',
				'value': el.attr('href'),
				'text': el.text().length > 0 ? el.text() : el.find('img').attr('title')// Use text or img title text
			}).appendTo($select);
		});
		
		// Go to selected address
		$select.change(function()
		{
			window.location.href = $select.find('option:selected').val();
		});
	}
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Alerts and Notifications
	// --------------------------------------------------------------------
	
	// Close and remove element
	$(document).on('click', '.alert, .notification', function(event)
	{
		var $element = $(this);
		var offset = $element.offset();
		var click_from_right = $element.outerWidth() - (event.pageX - offset.left);
		var click_from_top = (event.pageY - offset.top);
		//console.log(click_from_right + ', ' + click_from_top);
		
		// If clicked in the top right corner
		if ( click_from_right > 30 || click_from_top > 30 )
		{
			return true;
		}
		
		event.preventDefault();
		
		// Hide overflow, FadeOut and SlideUp at the same time, then remove
		$element
		.css({overflow: 'hidden'})
		.animate({opacity: 0, height: 0, marginBottom: 0, paddingTop: 0, paddingBottom: 0}, 300, function()
		{
			$element.remove();
		});
		
		return false;
	});
	
	// --------------------------------------------------------------------
	
});

// --------------------------------------------------------------------

// --------------------------------------------------------------------
//	# Media
// --------------------------------------------------------------------

// If image placeholders are used, have them retry to generate if there are errors, like used inside a display:none element
if ( window.Holder )
{
	Holder.invisible_error_fn = function(fn){
		return function(el){
			setTimeout(function(){
				fn.call(this, el)
			}, 10)
		}
	}
}

// --------------------------------------------------------------------

//]]>