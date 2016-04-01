/*

/* -------------------------------------------------------
	Responsive navigation - Dropdown replacement for nav
------------------------------------------------------- /
.responsive-nav_mobile {
	display: none;
}
.responsive-nav_mobile select {
	background: #e8ecf3;
	font: normal 400 1.8em/100% inherit;
	margin: 0;
	min-height: 28px;
	width: 100%;
}

/*  Media Query - Mobile
------------------------------------------------------- /
/* All Mobile Sizes (devices and browser) /
@media only screen and (max-width: 767px) {

	.responsive-nav_desktop {
		display: none !important;
	}
	.responsive-nav_mobile {
		display: block;
	}
	
}
*/
jQuery(document).ready(function($)
{
	
	//------------------------------------------------------------
	
	// Create dropdown select from nav
	var $select_container = $('<div class="responsive-nav_mobile" />').insertAfter('.responsive-nav_desktop');
	var $select = $('<select />').appendTo($select_container);
	
	// Create default option
	$('<option />', {
		'value': '',
		'text': 'Go to...'
	})
	.prop('selected', true)
	.appendTo($select);
	
	// Populate with menu items
	$('.responsive-nav_desktop a:not(.not-responsive)').each(function(i)
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
	
	//------------------------------------------------------------
	
});