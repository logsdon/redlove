//<![CDATA[
/**
* Tabs functionality using tab/tab content container classes or predictable markup structure
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<h3>Tabs</h3>

<div class="tabs1">
	<ul class="tab-container">
		<li class="active">Tab One</li>
		<li>Tab Two</li>
		<li>Tab Three</li>
	</ul>
	<ul class="tab-content-container">
		<li>Tab One content</li>
		<li>Tab Two content</li>
		<li>Tab Three content</li>
	</ul>
</div>

<hr>

<div class="tabs2">
	<ul class="tab-container">
		<li class="active">Tab One</li>
		<li>Tab Two</li>
		<li>Tab Three</li>
	</ul>
	<ul class="tab-content-container">
		<li>Tab One content</li>
		<li>Tab Two content</li>
		<li>Tab Three content</li>
	</ul>
</div>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_tabs.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_tabs.js"></script>
<style type="text/css">
	.tab-container {
		display: inline-block;
	}
	.tab-container ul,
	.tab-container li,
	.tab-content-container ul,
	.tab-content-container li {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.tab-container > * {
		float: left;
		padding: 0.5em;
		-webkit-transition: all 0.4s ease-out 0s;
		-moz-transition: all 0.4s ease-out 0s;
		-ms-transition: all 0.4s ease-out 0s;
		-o-transition: all 0.4s ease-out 0s;
		transition: all 0.4s ease-out 0s;
	}
	.tab-container > *.active {
		color: red;
		font-weight: bold;
	}
</style>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.tabs1, .tabs2').redlove_tabs();
	});
</script>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_tabs';
	var plugin_namespace = '.' + plugin_name;
	var plugin_default_options = {
		active_class : 'active',
		debug : false,
		mode : 'selector',
		tab_container : '.tab-container',
		tab_content_container : '.tab-content-container',
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
		// Plugin code for each element
		return this.each(function ( index )
		{
			var element = this;
			var $element = $(element);
			var metadata = {};//$element.data('tab-options');
			options = $.extend( {}, plugin_default_options, options, metadata );
			
			// Plugin implementation code
			
			if ( options.mode == 'selector' )
			{
				var $tab_container = $element.find(options.tab_container);
				var $tab_content_container = $element.find(options.tab_content_container);
			}
			else
			{
				var $children = $element.children();
				var $tab_container = $children.eq(0);
				var $tab_content_container = $children.eq(1);
			}
			
			var $tabs = $tab_container.children();
			var $tab_contents = $tab_content_container.children();
			
			// Show clicked tab content
			$tabs.on('click' + plugin_namespace, function ( event )
			{
				event.preventDefault();
				event.stopImmediatePropagation();
				
				var cur_index = $tabs.index( $tabs.filter('.' + options.active_class) );
				var new_index = $tabs.index(this);
				
				// If there is a previous selection
				if ( cur_index > -1 )
				{
					// Hide previous tab
					$tabs.eq(cur_index)
					.add( $tab_contents.eq(cur_index) )
					.removeClass(options.active_class);
				}
				
				// Show the tab content
				$tabs.eq(new_index)
				.add( $tab_contents.eq(new_index) )
				.addClass(options.active_class);
			});
			
			$tabs.filter('.' + options.active_class).trigger('click' + plugin_namespace);
		});
	};
	
})( jQuery, window, document );// End function closure
//]]>