//<![CDATA[
/**
* Place absolute positioned elements by their center
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<div class="blue-dot-box blue-dot-box_state_0 animate-flicker" data-coords="90,30">
	<a href=""  class="blue-dot" data-modal-box="#text-1"><span></span></a>
	<div class="blue-dot-line transform_origin-0 transform_rotate-45"></div>
</div>
<div class="blue-dot-box blue-dot-box_state_0 animate-flicker" data-coords="50,210">
	<a href=""  class="blue-dot" data-modal-box="#text-2"><span></span></a>
	<div class="blue-dot-line transform_origin-0 transform_rotate-290"></div>
</div>
<div class="blue-dot-box blue-dot-box_state_0 animate-flicker" data-coords="245,95">
	<a href=""  class="blue-dot" data-modal-box="#text-3"><span></span></a>
	<div class="blue-dot-line transform_origin-0 transform_rotate-190"></div>
</div>

<style type="text/css">
	.blue-dot-box {
		position: absolute;
		z-index: 1;
	}
	.blue-dot {
		background: #00a9e0;
		-webkit-border-radius: 50%;
		-khtml-border-radius: 50%;
		-moz-border-radius: 50%;
		border-radius: 50%;
		cursor: pointer;
		display: block;
		height: 24px;
		outline: 0;
		position: absolute;
		width: 24px;
		z-index: 1;
	}
	.blue-dot span {
		border: 3px solid #FFFFFF;
		-webkit-border-radius: 50%;
		-khtml-border-radius: 50%;
		-moz-border-radius: 50%;
		border-radius: 50%;
		height: 42%;
		left: 50%;
		position: absolute;
		top: 50%;
		-webkit-transform: translate(-50%, -50%);
		-moz-transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		-o-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
		width: 42%;
	}
	.blue-dot-line {
		border-top: 2px solid #00a9e0;
		left: 12px;
		pointer-events: none;
		position: absolute;
		top: 12px;
		width: 50px;
	}
	.transform_origin-0 {
		-webkit-transform-origin: 0% 0%;
		-moz-transform-origin: 0% 0%;
		-ms-transform-origin: 0% 0%;
		-o-transform-origin: 0% 0%;
		transform-origin: 0% 0%;
	}
	.transform_rotate-45 {
		-webkit-transform: rotate(45deg);
		-moz-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		transform: rotate(45deg);
	}
</style>
<script type="text/javascript" src="javascript/redlove/plugins/redlove_placedots.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.blue-dot-box').redlove_placedots();
	});
</script>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_placedots';
	
	// jQuery plugin definition
	
	/**
	* jQuery plugin constructor
	* 
	* @return object jQuery object
	*/
	$.fn[plugin_name] = function ()
	{
		// Plugin code for each element
		return this.each(function ( index )
		{
			$this = $(this);
			
			// Set the element index for later use
			$this.data('index', index);
			
			// Get the data- on the element and cast numeric
			var coords = $this.data('coords') || '0,0';
			coords = coords.split(',');
			coords[0] *= 1;
			coords[1] *= 1;
			var dimensions = $this.data('dim') || $this.width() + ',' + $this.height();
			dimensions = dimensions.split(',');
			dimensions[0] *= 1;
			dimensions[1] *= 1;
			
			var dot_width = dimensions[0];
			var dot_height = dimensions[1];
			var dot_left = coords[0] - (dimensions[0] / 2);
			var dot_top = coords[1] - (dimensions[1] / 2);
			var dot_right = dot_left + dot_width;
			var dot_bottom = dot_top + dot_height;
			
			// Set the element style
			$this.css({
				'left' : dot_left + 'px',
				'top' : dot_top + 'px',
				'width' : dot_width,
				'height' : dot_height
			});
		});
	};
	
})( jQuery, window, document );// End function closure
//]]>