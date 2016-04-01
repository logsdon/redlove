//<![CDATA[
/**
* Tabs functionality using tab/tab content collection classes or predictable markup structure
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<h3>Tabs</h3>

<div class="tabs1">
	<ul class="tab-collection">
		<li class="active">Tab One</li>
		<li>Tab Two</li>
		<li>Tab Three</li>
	</ul>
	<ul class="tab-content-collection">
		<li>Tab One content</li>
		<li>Tab Two content</li>
		<li>Tab Three content</li>
	</ul>
</div>

<hr>

<div class="tabs2">
	<ul class="tab-collection">
		<li class="active">Tab One</li>
		<li>Tab Two</li>
		<li>Tab Three</li>
	</ul>
	<ul class="tab-content-collection">
		<li>Tab One content</li>
		<li>Tab Two content</li>
		<li>Tab Three content</li>
	</ul>
</div>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_tabs.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_tabs.js"></script>
<style type="text/css">
	.tab-collection {
		display: inline-block;
	}
	.tab-collection ul,
	.tab-collection li,
	.tab-content-collection ul,
	.tab-content-collection li {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.tab-collection > * {
		float: left;
		padding: 0.5em;
		-webkit-transition: all 0.4s ease-out 0s;
		-moz-transition: all 0.4s ease-out 0s;
		-ms-transition: all 0.4s ease-out 0s;
		-o-transition: all 0.4s ease-out 0s;
		transition: all 0.4s ease-out 0s;
	}
	.tab-collection > *.active {
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
		tab_collection : '',
		tab_content_collection : '',
		default_tab_collection : '.tab-collection',
		default_tab_content_collection : '.tab-content-collection',
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
			
			// If a collection selector exists, use selectors
			if ( options.tab_collection.length > 0 )
			{
				var $tab_collection = $element.find(options.tab_collection);
				var $tab_content_collection = $element.find(options.tab_content_collection);
			}
			// Else from the element passed, 
			// use the first element as the tab collection 
			// and the second as the tab content collection
			else
			{
				var $children = $element.children();
				var $tab_collection = $children.eq(0);
				var $tab_content_collection = $children.eq(1);
			}
			
			var $tabs = $tab_collection.children();
			var $tab_contents = $tab_content_collection.children();
			
			// Show clicked tab content
			$tabs
			.on('click' + plugin_namespace, function ( event )
			{
				event.preventDefault();
				
				var active_index = $tabs.index( $tabs.filter('.' + options.active_class) );
				var index = $tabs.index(this);
				
				// If there is a previous selection
				if ( active_index > -1 )
				{
					// Hide previous tab
					$tabs.eq(active_index)
					.add( $tab_contents.eq(active_index) )
					.removeClass(options.active_class);
				}
				
				// Show the tab content
				var $tab = $tabs.eq(index);
				var $tab_content = $tab_contents.eq(index);
				$tab
				.add( $tab_content )
				.addClass(options.active_class);
				
				// Trigger custom event
				$(this)
				.trigger('tab_show', {
					tab: $tab,
					tab_content: $tab_content
				});
			})
			.filter('.' + options.active_class)
			.trigger('click' + plugin_namespace);
		});
	};
	
})( jQuery, window, document );// End function closure
//]]>