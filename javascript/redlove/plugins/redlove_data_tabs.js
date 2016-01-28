//<![CDATA[
/**
* Tabs functionality using the data attribute on elements that do not need to be in a traditional structure
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<h3>Data Tabs</h3>

<div>
	<ul class="data-tab-collection">
		<li class="active" data-tab="data-tabs1-1">Tab One</li>
		<li data-tab="data-tabs1-2">Tab Two</li>
		<li data-tab="data-tabs1-3">Tab Three</li>
	</ul>
	<ul class="data-tab-content-collection">
		<li id="data-tabs1-1">Tab One content</li>
		<li id="data-tabs1-2">Tab Two content</li>
		<li id="data-tabs1-3">Tab Three content</li>
	</ul>
</div>

<hr>

<a href="#" data-tab="data-tabs2-1">Tab One</a>
<span data-tab="data-tabs2-2">Tab Two</span>
<div>
	<a href="#data-tabs2-1" data-tab>Tab One</a>
	<a href="#data-tabs2-2" data-tab>Tab Two</a>
	<a href="#data-tabs2-3" data-tab>Tab Three</a>
	<div class="data-tab-content-collection">
		<div id="data-tabs2-1">Tab One content</div>
		<div id="data-tabs2-2">Tab Two content</div>
		<div id="data-tabs2-3">Tab Three content</div>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_data_tabs.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_data_tabs.js"></script>
<style type="text/css">
	.data-tab-collection {
		display: inline-block;
	}
	.data-tab-collection ul,
	.data-tab-collection li,
	.data-tab-content-collection ul,
	.data-tab-content-collection li {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.data-tab-collection > * {
		float: left;
		padding: 0.5em;
		-webkit-transition: all 0.4s ease-out 0s;
		-moz-transition: all 0.4s ease-out 0s;
		-ms-transition: all 0.4s ease-out 0s;
		-o-transition: all 0.4s ease-out 0s;
		transition: all 0.4s ease-out 0s;
	}
	[data-tab].active {
		color: red;
		font-weight: bold;
	}
</style>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_data_tabs';
	var plugin_namespace = '.' + plugin_name;
	var plugin_default_options = {
		active_class : 'active',
		data_key : 'tab',
		debug : false,
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
		options = $.extend( {}, plugin_default_options, options );
		
		// Plugin implementation code
		
		var tab_selector = '[data-' + options.data_key + ']';
		
		// Show clicked tab content
		$(document).on('click' + plugin_namespace, tab_selector, function(event)
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			
			// Find the tab to select
			var is_href = ( this.href !== undefined );
			var new_hash = is_href ? this.href.split('#')[1] || $(this).data(options.data_key) : $(this).data(options.data_key);
			if ( typeof new_hash === undefined )
			{
				return;
			}
			
			var $new_tab_content = $('#' + new_hash);
			if ( $new_tab_content.length == 0 )
			{
				return;
			}
			
			var new_index = $new_tab_content.index();
			var $tab_content_container = $new_tab_content.parent();
			var $tab_contents = $tab_content_container.children();
			var $cur_tab_content = $tab_contents.filter('.' + options.active_class);
			
			var cur_index = $cur_tab_content.index();
			var cur_hash = $tab_contents.eq(cur_index).attr('id');
			
			// Stop if showing the same tab
			if ( cur_index == new_index )
			{
				return;
			}
			// If there is a previous selection
			else if ( cur_index > - 1 )
			{
				// Hide previous tab
				link_selector = tab_selector + '[href="#' + cur_hash + '"]';
				data_selector = '[data-' + options.data_key + '="' + cur_hash + '"]';
				
				$cur_tab_content
				.add( link_selector + ',' + data_selector )
				.removeClass(options.active_class);
			}
			
			// Show the tab content
			link_selector = tab_selector + '[href="#' + new_hash + '"]';
			data_selector = '[data-' + options.data_key + '="' + new_hash + '"]';
			
			$new_tab_content
			.add( link_selector + ',' + data_selector )
			.addClass(options.active_class);
		});
		
		$('[data-' + options.data_key + '].' + options.active_class).trigger('click');
	};
	
	$.fn.redlove_data_tabs();
	
})( jQuery, window, document );// End function closure
//]]>