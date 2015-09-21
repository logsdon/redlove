//<![CDATA[
/**
* Place absolute positioned elements by their center
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<a href="#" data-redlove_modalbox="#text-1">Modal 1</a>
<div class="redlove_modalbox" id="text-1">
	<div class="redlove_modalbox-liner">
		<div class="redlove_modalbox-close">Close <span>&times;</span></div>
		<div class="redlove_modalbox-content">
			<div class="text_feature">
				<h2 class="type-regular">Easy Release, Easy Return</h2>
				<p>An integrated magnet means removing the handshower is simple &ndash; and putting it back is a snap.</p>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.redlove_modalbox {
		background: rgb(0, 0, 0);
		background: rgba(255, 255, 255, 0.6);
		bottom: 0;
		display: none;
		left: 0;
		position: fixed;
		right: 0;
		top: 0;
		z-index: 9999999;
	}
	.redlove_modalbox-liner {
		-webkit-box-shadow: 0px 0px 20px 0px rgba(100, 0, 0, 0.4) !important;
		-moz-box-shadow: 0px 0px 20px 0px rgba(100, 0, 0, 0.4) !important;
		box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.4) !important;
		left: 50%;
		min-width: 290px;
		position: absolute;
		top: 50%;
		-webkit-transform: translate(-50%, -50%);
		-moz-transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		-o-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
	}
	.redlove_modalbox-close {
		color: #0099cc;
		cursor: pointer;
		left: auto;
		padding: 0.5em;
		position: absolute;
		right: 0;
		top: 0;
		z-index: 2;
	}
	.redlove_modalbox-close span {
		background: #F1F1F1;
		border: 1px solid #CCCCCC;
		-webkit-border-radius: 50%;
		-khtml-border-radius: 50%;
		-moz-border-radius: 50%;
		border-radius: 50%;
		color: #A6A6A6;
		display: inline-block;
		height: 1.0em;
		line-height: 1.0;
		text-align: center;
		width: 1.0em;
	}

	.redlove_no-scroll {
		overflow: hidden;
	}
</style>
<script type="text/javascript" src="javascript/redlove/plugins/redlove_modalbox.js"></script>
<script type="text/javascript">
	$(document).ready(function($)
	{
		$.fn.redlove_modalbox();
	});
</script>

* 
*/
;(function ( $, window, document, undefined )// Begin function closure; avoid collisions
{
	// Private variables
	var plugin_name = 'redlove_modalbox';
	
	// jQuery plugin definition
	
	/**
	* jQuery plugin constructor
	* 
	* @return object Plugin instance
	*/
	$.fn[plugin_name] = function ()
	{
		// Reset global listeners
		
		// Open modalbox
		var event_type = 'click.' + plugin_name + '.open';
		$(document)
		.off(event_type)
		.on(event_type, '[data-redlove_modalbox]', function ( event )
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			
			$( $(this).data('redlove_modalbox') ).show();
			$('body').addClass('redlove_no-scroll');
		});
		
		// Close modalbox
		event_type = 'click.' + plugin_name + '.close';
		$(document)
		.off(event_type)
		.on(event_type, '.redlove_modalbox-close', function ( event )
		{
			event.preventDefault();
			event.stopImmediatePropagation();
			
			$(this).closest('.redlove_modalbox').hide();
			$('body').removeClass('redlove_no-scroll');
		});
		
		// Plugin code for each element
		return this;
	};
	
})( jQuery, window, document );// End function closure
//]]>