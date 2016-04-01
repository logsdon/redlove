
// Handle toggle clicks
$(document).on('click.toggle', '[data-toggle]', function ( event )
{
	event.preventDefault();
	event.stopImmediatePropagation();
	
	var $this = $(this);
	
	// If a red dot, toggle off other red dots in container
	if ( $this.hasClass('red-dot') )
	{
		var $container = $this.closest('.red-dots-container');
		var $active = $container.find('.red-dot.active');
		if ( $active.length > 0 && $active[0] != this )
		{
			$active.removeClass('active');
			
			var toggle = $active.data('toggle');
			var toggles = toggle.split(',');
			var toggles_array = new Array();
			for ( var index in toggles )
			{
				toggles_array.push('[data-togglee="' + toggles[index].trim() + '"]');
			}
			$( toggles_array.join(',') ).removeClass('active');
		}
	}
	
	$this.toggleClass('active');
	var toggle = $this.data('toggle');
	var toggles = toggle.split(',');
	var toggles_array = new Array();
	for ( var index in toggles )
	{
		toggles_array.push('[data-togglee="' + toggles[index].trim() + '"]');
	}
	$( toggles_array.join(',') ).toggleClass('active');
});

$('[data-togglee-coords]').each( function ( i, el )
{
	var $this = $(this);
	var options = {'center' : false};
	
	// Get the data- on the element and cast numeric
	var coords = $this.data('togglee-coords') || '0,0';
	coords = coords.split(',');
	var dimensions = $this.data('togglee-dim') || '';//$this.width() + ',' + $this.height();
	dimensions = String( dimensions ).indexOf(',') > -1 ? dimensions.split(',') : [dimensions];
	dimensions[0] = is_numeric(dimensions[0]) ? dimensions[0] * 1 : '';
	dimensions[1] = is_numeric(dimensions[1]) ? dimensions[1] * 1 : '';
	
	var dot_width = dimensions[0];
	var dot_height = dimensions[1];
	var dot_left = options.center ? (coords[0] * 1) - (dimensions[0] / 2) : coords[0];
	var dot_top = options.center ? (coords[1] * 1) - (dimensions[1] / 2) : coords[1];
	var dot_right = is_numeric(dot_width) ? dot_left + dot_width : '';
	var dot_bottom = is_numeric(dot_height) ? dot_top + dot_height : '';
	
	// Set the element style
	var obj = {
		'left' : is_numeric(dot_left) ? dot_left + 'px' : dot_left,
		'top' : is_numeric(dot_top) ? dot_top + 'px' : dot_top
	};
	if ( is_numeric(dot_width) )
	{
		obj.width = is_numeric(dot_width) ? dot_width + 'px' : dot_width;
	}
	if ( is_numeric(dot_height) )
	{
		obj.height = is_numeric(dot_height) ? dot_height + 'px' : dot_height;
	}
	
	$this.css(obj);
});

/**
* http://stackoverflow.com/questions/9716468/is-there-any-function-like-isnumeric-in-javascript-to-validate-numbers
*/
function is_numeric ( n )
{
	return ! isNaN(parseFloat(n)) && isFinite(n);
}

// Handle toggle class clicks
$('[data-toggle-class]').click(function ( event )
{
	event.preventDefault();
	event.stopImmediatePropagation();
	
	var $this = $(this);
	var toggle_class = $this.data('toggle-class') || 'active';
	$this.toggleClass(toggle_class);
});
