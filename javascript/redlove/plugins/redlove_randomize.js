//<![CDATA[
/**
* Randomize DOM elements
* 
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* 
* Usage:

<script type="text/javascript" src="javascript/redlove/plugins/redlove_randomize.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function ( $ )
	{
		$('.game').redlove_randomize('.game-piece');
	});
</script>

* 
*/
;(function ( $ )
{
	$.fn.redlove_randomize = function ( selector )// Begin function closure; avoid collisions
	{
		// If the selector not a jQuery object, treat as an array
		if ( typeof(selector) === 'object' && ! (selector instanceof jQuery || 'jquery' in Object(selector)) )
		{
			return shuffle(selector);
		}
		
		// Else shuffle elements
		
		/*
		$(this)
		.children(selector)
		.sort(function ()
		{
			return Math.random() - 0.5;
		})
		.detach()
		.appendTo(this);
		*/
		
		return ( selector ? this.find(selector) : this )
		.parent()
		.each(function ()
		{
			var $parent = $(this);
			var $children = $parent.children(selector);
			shuffle($children);
			$children.detach();  

			for ( var index = 0; index < $children.length; index++ )
			{
				$parent.append($children[index]);      
			}
		});    
	};
	
	/**
	* http://stackoverflow.com/questions/1533910/randomize-a-sequence-of-div-elements-with-jquery
	* http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
	*/
	function shuffle ( array )
	{
		var currentIndex = array.length, temporaryValue, randomIndex;

		// While there remain elements to shuffle...
		while ( 0 !== currentIndex )
		{
			// Pick a remaining element...
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;

			// And swap it with the current element.
			temporaryValue = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = temporaryValue;
		}

		return array;
	}
	/*
	function shuffle ( o )
	{
		for ( var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x );
		return o;
	}
	*/
	/**
	* Randomize array element order in-place.
	* Using Durstenfeld shuffle algorithm.
	*/
	/*
	function shuffle ( array )
	{
		for ( var i = array.length - 1; i > 0; i-- )
		{
			var j = Math.floor(Math.random() * (i + 1));
			var temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	}
	*/
	
})( jQuery );// End function closure
//]]>