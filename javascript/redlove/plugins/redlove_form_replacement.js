//<![CDATA[
/**
* Set element positioning on scroll position
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<div class="form-replacement">
	<input type="radio" name="rating" value="1">
	<input type="radio" name="rating" value="2">
	<input type="radio" name="rating" value="3">
	<input type="radio" name="rating" value="4">
	<input type="radio" name="rating" value="5">
	<input type="radio" name="rating" value="6" checked="checked">
	<input type="radio" name="rating" value="7" disabled="disabled">
</div>

<div class="form-replacement">
	<input type="checkbox" name="replaced_checkbox[]" value="1">
	<input type="checkbox" name="replaced_checkbox[]" value="2">
	<input type="checkbox" name="replaced_checkbox[]" value="3">
	<input type="checkbox" name="replaced_checkbox[]" value="4">
	<input type="checkbox" name="replaced_checkbox[]" value="5" checked="checked">
	<input type="checkbox" name="replaced_checkbox[]" value="6" disabled="disabled">
</div>

<select class="form-replacement">
	<option value="">&mdash; Please select &mdash;</option>
	<option value="option-1">Option 1</option>
	<option value="option-2" selected="selected">Option 2</option>
	<option value="option-3">Option 3</option>
</select>

<link rel="stylesheet" type="text/css" href="javascript/redlove/plugins/redlove_form_replacement.css">
<script type="text/javascript" src="javascript/redlove/plugins/redlove_form_replacement.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$('.form-replacement').redlove_form_replacement();
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
	proto.name = 'redlove_form_replacement';
	proto.data_key = proto.name;
	proto.num_instances = 0;
	proto.default_options = {
		input_box_class : 'redlove_form-replacement_input_box',
		input_checkbox_class : 'redlove_form-replacement_input_checkbox',
		input_radio_class : 'redlove_form-replacement_input_radio',
		select_class : 'redlove_form-replacement_select',
		select_options_class : 'redlove_form-replacement_select_options',
		select_option_class : 'redlove_form-replacement_select_option',
		select_option_active_class : 'active',
		selected_option_class : 'redlove_form-replacement_selected_option',
		debug : false,
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
		this.element = el;
		this.$element = $(el);
		this.options = options;
		
		// Extend default options
		this.metadata = {};//this.$element.data('plugin-options');//$(element).data();
		this.options = $.extend( {}, this.default_options, this.options, this.metadata );
		
		// Plugin properties
		this.$document = $(document);
		
		// Plugin implementation code
		var self = this;
		
		this.$element.each(function(i, el)
		{
			$inputs = $(this);
			
			var $input_boxes = $inputs.filter('input[type="checkbox"], input[type="radio"]')
			.add( $inputs.find('input[type="checkbox"], input[type="radio"]') );
			self.setup_input_boxes($input_boxes);
			
			var $selects = $inputs.filter('select').add( $inputs.find('select') );
			self.setup_selects($selects);
		});
	};
	
	/**
	* Setup input boxes
	* 
	* @return object Plugin instance
	*/
	proto.setup_input_boxes = function ( $input_boxes )
	{
		var self = this;
		
		if ( $input_boxes.length > 0 )
		{
			$input_boxes.each(function(i, el)
			{
				var $input_box = $(this);
				var input_name = $input_box.attr('name');
				var class_name = ( $input_box.attr('type') == 'radio' ) ? self.options.input_radio_class : self.options.input_checkbox_class;
				var $replacement = $('<span class="' + self.options.input_box_class + ' ' + class_name + '" data-for="' + input_name + '" data-for-index="' + i + '"></span>');
				$input_box.after($replacement).hide();
				
				$input_box.on('change.' + proto.name, function(event)
				{
					self.update_inputs($input_boxes);
				});
			});
			
			self.update_inputs($input_boxes);
		}
		
		if ( proto.num_instances == 1 )
		{
			self.$document.on('click.' + proto.name, '.' + this.options.input_box_class, function(event)
			{
				event.preventDefault();
				
				var $replacement = $(this);
				// Get the real HTML element
				var $input = $replacement.prev('input[type="checkbox"], input[type="radio"]').eq(0);
				
				// If disabled, stop
				if ( $replacement.hasClass('disabled') )
				{
					return;
				}
				
				// Trigger click
				$input.trigger('click');//IE8 has trouble recognizing change on first click own
			});
		}
	};
	
	/**
	* Update group of input boxes
	* 
	* @return object Plugin instance
	*/
	proto.update_inputs = function ( $input_boxes )
	{
		var self = this;
		
		$input_boxes.each(function(i, el)
		{
			var $input_box = $(this);
			var $replacement = $(this).next('.' + self.options.input_box_class);
			
			// Prep real HTML element; Check if it should be checked, and hide it
			if ( $input_box.prop('checked') )
			{
				$replacement.addClass('checked');
			}
			else
			{
				$replacement.removeClass('checked');
			}
			
			if ( $input_box.prop('disabled') )
			{
				$replacement.addClass('disabled');
			}
			else
			{
				$replacement.removeClass('disabled');
			}
		});
	};
	
	/**
	* Setup selects
	* 
	* @return object Plugin instance
	*/
	proto.setup_selects = function ( $selects )
	{
		var self = this;
		
		if ( $selects.length > 0 )
		{
			$selects.each(function(i, el )
			{
				var $select = $(this);
				var $replacement = $('\
				<div class="' + self.options.select_class + '">\
					<div class="' + self.options.selected_option_class + '" data-value=""></div>\
					<div class="' + self.options.select_options_class + '"></div>\
				</div>\
				');
				if ( $select.prop('disabled') )
				{
					$replacement.addClass('disabled');
				}
				var $replacement_option_selected = $replacement.find('.' + self.options.selected_option_class);
				var $replacement_options_container = $replacement.find('.' + self.options.select_options_class).hide();
				
				$replacement_option_selected.on('click.' + proto.name + ' touchstart.' + proto.name, function(event)
				{
					event.stopPropagation();
					$replacement_options_container.toggle();
					self.$document.one('click.' + proto.name + '.close_options touchstart.' + proto.name + '.close_options', function(event)
					{
						event.stopPropagation();
						$replacement_options_container.hide();
					});
				});
				
				var $select_options = $select.find('option');
				$select_options.each(function(i, el)
				{
					var $option = $(this);
					var $replacement_option = $('<div class="' + self.options.select_option_class + '"></div>')
					.data('value', $option.attr('value'))
					.html($option.html());
					$replacement_options_container.append($replacement_option);
				});
				
				var $replacement_options = $replacement_options_container.find('.' + self.options.select_option_class);
				$replacement_options.on('click.' + proto.name + ' touchstart.' + proto.name, function(event)
				{
					event.stopPropagation();
					self.$document.off('click.' + proto.name + '.close_options touchstart.' + proto.name + '.close_options');
					
					var $replacement_option = $(this);
					
					$replacement_options.removeClass(self.options.select_option_active_class);
					$replacement_option.addClass(self.options.select_option_active_class);
					
					var selected_index = $select[0].selectedIndex;
					var replacement_selected_index = $replacement_option.index();
					var replacement_selected_value = $replacement_option.data('value');
					var replacement_selected_html = $replacement_option.html();
					
					$replacement_option_selected
					.data('value', replacement_selected_value)
					.html(replacement_selected_html);
					$select.val(replacement_selected_value);
					// If clicked by a human and the selected index has changed, trigger the change event
					if ( event.originalEvent !== undefined && selected_index != replacement_selected_index )
					{
						$select.trigger('change');
					}
					$replacement_options_container.hide();
				});
				
				// Select the selected option by default
				$replacement_options.eq($select[0].selectedIndex).trigger('click');
				
				$select.after($replacement).hide();
				
				$replacement.css('min-width', $replacement_options_container.outerWidth());
			});
		}
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