//<![CDATA[
/**
* @version 0.0.0
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
*/

/* ============================================================
	Table of Contents
============================================================
	REDLOVE
		# Strings
		# Arrays
		# Objects
		# Date and Time
		# Math
		# Numerical
		# URL
		# Files
		# Forms
		# Browser Abilities
		# Logging
		# AJAX
		# Analytics
	GLOBAL
		# Logging
	
	REDLOVE common setup:

<script style="text/javascript" src="javascript/redlove/base.js"></script>
<script style="text/javascript" src="javascript/redlove/common.js"></script>
<script style="text/javascript">//<![CDATA[
// Global common data object
window.REDLOVE = window.REDLOVE || {fn : {}};
$.extend(window.REDLOVE, {
	form_data : {
		<?php
		if ( isset($this) && property_exists($this, 'csrf') )
		{
		?>
			'<?php echo $this->csrf->get_token_name(); ?>' : '<?php echo $this->csrf->get_hash(); ?>',
		<?php
		}
		elseif ( class_exists('Csrf') )
		{
			$CSRF = new Csrf();
		?>
			'<?php echo $CSRF->get_token_name(); ?>' : '<?php echo $CSRF->get_hash(); ?>',
		<?php
		}
		?>
		ajax : 1
	},
	base_url : '<?php echo function_exists('base_url') ? base_url() : ''; ?>',
	// or
	base_url : '<?php echo function_exists('theme_nav_url') ? theme_nav_url() : ''; ?>',
	site_theme : '<?php echo isset($this->site_theme) ? $this->site_theme : ''; ?>',
	site_theme_path : '<?php echo isset($this->site_theme_path) ? $this->site_theme_path : ''; ?>',
	site_theme_url : '<?php echo isset($this->site_theme_url) ? $this->site_theme_url : ''; ?>',
	page_start_time : <?php echo time(); ?>,
	server_timezone_offset : <?php echo date('Z'); ?>,
	'' : ''// Empty so each real property set above has a comma after it
});
//]]></script>
<script style="text/javascript" src="javascript/site.js"></script>
*/

window.REDLOVE = window.REDLOVE || {fn : {}};

$.extend(window.REDLOVE, {
	base_url : '',
	client_timezone_offset : - new Date().getTimezoneOffset() * 60,
	common_ajax_options : {
		cache : false,
		dataType : 'json',
		timeout : 300000,
		type : 'POST',
		error : REDLOVE.fn.ajax_error_handler,
		beforeSend : REDLOVE.fn.ajax_beforesend_handler,
		complete : REDLOVE.fn.ajax_complete_handler
	},
	debug : false,
	form_data : {},
	html_newline : '<br>',
	newline : "\n",
	'' : ''// Empty so each real property set above has a comma after it
});

$.extend(window.REDLOVE.fn, {
	
	// --------------------------------------------------------------------
	//	# Strings
	// --------------------------------------------------------------------
	
	/**
	* Convert text to character codes
	*/
	obfuscate : function ()
	{
		var bytes = [];
		for ( var i = 0; i < this.length; i++ )
		{
			bytes.push('&#' + this.charCodeAt(i) + ';');
			//function(c){return String.fromCharCode((c<=”Z”?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}
		}
		return bytes.join('');
	},

	/**
	* Trim text
	*/
	trim : function ( string )
	{
		return String(string).replace(/^\s+/, '').replace(/\s+$/, '');
	},

	/**
	* Trim whitespace from text
	*/
	trim_all_whitespace : function ( string )
	{
		return String(string).replace(/^\s+|\s+$/gm, '');
	},

	// --------------------------------------------------------------------
	//	# Arrays
	// --------------------------------------------------------------------
	
	/**
	* Remove array elements with matching values
	* 
	* http://stackoverflow.com/questions/281264/remove-empty-elements-from-an-array-in-javascript
	*/
	clean_array : function ( arr, delete_value )
	{
		for ( var i = 0; i < arr.length; i++ )
		{
			if ( arr[i] == delete_value )
			{         
				arr.splice(i, 1);
				i--;
			}
		}
		return arr;
	},

	/**
	* Randomize array elements
	* 
	* http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
	*/
	shuffle : function ( arr )
	{
		var currentIndex = arr.length, temporaryValue, randomIndex ;

		// While there remain elements to shuffle...
		while ( 0 !== currentIndex )
		{
			// Pick a remaining element...
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;

			// And swap it with the current element.
			temporaryValue = arr[currentIndex];
			arr[currentIndex] = arr[randomIndex];
			arr[randomIndex] = temporaryValue;
		}

		return arr;
	},

	// --------------------------------------------------------------------
	//	# Objects
	// --------------------------------------------------------------------
	
	/**
	* Function : dump()
	* Arguments: The data - array,hash(associative array),object
	*    The level - OPTIONAL
	* Returns  : The textual representation of the array.
	* This function was inspired by the print_r function of PHP.
	* This will accept some data as the argument and return a
	* text that will be a more readable version of the
	* array/hash/object that is given.
	* Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
	* 
	* http://www.openjs.com/scripts/others/dump_function_php_print_r.php
	*/
	dump : function ( arr, level )
	{
		var dumped_text = "";
		if(!level) level = 0;
		
		//The padding given at the beginning of the line.
		var level_padding = "";
		for(var j=0;j<level+1;j++) level_padding += "    ";
		
		if(typeof(arr) == 'object') { //Array/Hashes/Objects 
			for(var item in arr) {
				var value = arr[item];
				
				if(typeof(value) == 'object') { //If it is an array,
					dumped_text += level_padding + "'" + item + "' ...\n";
					dumped_text += dump(value,level+1);
				} else {
					dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
				}
			}
		} else { //Stings/Chars/Numbers etc.
			dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
		}
		return dumped_text;
	},

	/**
	* Test for jQuery object
	*/
	has_event : function ( object, event_name )
	{
		var event_bound = false;
		
		// Parse event name
		var namespace_index = event_name.indexOf('.');
		var type = ( namespace_index === -1 ) ? event_name : event_name.substring(0, namespace_index);
		var namespace = ( namespace_index === -1 ) ? '' : event_name.substring(namespace_index + 1);
		
		// For each event on the object
		$.each( $._data(object, 'events'), function ( event_index, event_object )
		{
			for ( var object_index in event_object )
			{
				if ( typeof event_object[object_index] === 'object' )
				{
					// If the event type matches
					if ( event_object[object_index].type == type )
					{
						// If there is an event namespace and it doesn't match, move on
						if ( event_object[object_index].namespace && namespace && event_object[object_index].namespace !== namespace )
						{
							continue;
						}
						
						// If a matching event found, stop
						event_bound = true;
						break;
					}
				}
			}
		});
		
		return event_bound;
	},

	/**
	* Test for jQuery object
	*/
	is_jquery_obj : function ( test_var )
	{
		return ( test_var instanceof jQuery || 'jquery' in Object(test_var) );
	},

	/**
	* Convert object to string
	*/
	object_to_string : function ( o )
	{
		var parse = function(_o){
			var a = [], t;
			for(var p in _o){
				if(_o.hasOwnProperty(p)){
					t = _o[p];
					if(t && typeof t == "object"){
						a[a.length]= p + ":{ " + arguments.callee(t).join(", ") + "}";
					}
					else {
						if(typeof t == "string"){
							a[a.length] = [ p+ ": \"" + t.toString() + "\"" ];
						}
						else{
							a[a.length] = [ p+ ": " + t.toString()];
						}
					}
				}
			}
			return a;
		}
		return "{" + parse(o).join(", ") + "}";
	},

	/**
	* Get number of elements in object
	* 
	* http://stackoverflow.com/questions/5223/length-of-javascript-object-ie-associative-array
	*/
	size : function ( obj )
	{
		var size = 0, key;
		for ( key in obj )
		{
			if (obj.hasOwnProperty(key)) size++;
		}
		return size;
	},

	// --------------------------------------------------------------------
	//	# Date and Time
	// --------------------------------------------------------------------

	/**
	* Get current time as seconds
	*/
	get_seconds : function ()
	{
		return (new Date).getTime() / 1000;
	},

	/**
	* Convert time to hours, minutes, seconds, and H:i:s
	*/
	get_time_parts : function ( milliseconds )
	{
		milliseconds = parseInt( milliseconds );
		sec_numb = milliseconds / 1000;
		var hours = Math.floor(sec_numb / 3600);
		var minutes = Math.floor((sec_numb - (hours * 3600)) / 60);
		var seconds = sec_numb - (hours * 3600) - (minutes * 60);
		
		var data = {
			'hours' : hours,
			'minutes' : minutes,
			'seconds' : seconds
		}
		
		if ( hours   < 10 ) {hours = '0' + hours;}
		if ( minutes < 10 ) {minutes = '0' + minutes;}
		if ( seconds < 10 ) {seconds = '0' + seconds;}
		var time = hours + ':' + minutes + ':' + seconds;
		
		data.f_hours = hours;
		data.f_minutes = minutes;
		data.f_seconds = seconds;
		data.time = time;
		
		return data;
	},

	// --------------------------------------------------------------------
	//	# Math
	// --------------------------------------------------------------------
	
	/**
	* http://weblog.bocoup.com/find-the-closest-power-of-2-with-javascript/
	*/
	get_nearest_power_of_2 : function ( aSize )
	{
		return Math.pow( 2, Math.round( Math.log( aSize ) / Math.log( 2 ) ) ); 
	},

	/**
	* 
	*/
	get_square_info : function ( num )
	{
		var nrst_pow = this.get_nearest_power_of_2(num);
		var sqrt = Math.sqrt(num);
		var row_w = Math.ceil(sqrt) + Math.round(sqrt - Math.floor(sqrt));// Add on for awkward fit
		var row_h = Math.floor(sqrt);
		var data = {
			'num' : num,
			'row_w' : row_w,
			'row_h' : row_h,
			'nrst_pow' : nrst_pow,
			'sqrt' : sqrt
		};
		//alert(data.row_w + 'x' + data.row_h);
		return data;
	},

	/**
	* Check if variable is a number
	*/
	is_number : function ( n )
	{
		return ( ! isNaN(parseFloat(n)) && isFinite(n) );
	},

	/**
	* Check if number is an integer
	* 
	* http://stackoverflow.com/questions/3885817/how-to-check-that-a-number-is-float-or-integer
	*/
	is_integer : function ( n )
	{
		return ( this.is_number(n) && n % 2 === 0 );//Number(n) === n
	},

	/**
	* Check if number is a float
	* 
	* http://stackoverflow.com/questions/3885817/how-to-check-that-a-number-is-float-or-integer
	*/
	is_float : function ( n )
	{
		return ( this.is_number(n) && n % 2 !== 0 );
	},

	/**
	* Get a random number in the range
	*/
	random_from_to : function ( from, to )
	{
		//return Math.floor(Math.random() * (Max - Min + 1)) + Min;
		return Math.floor(Math.random() * (to - from + 1) + from);
	},

	/**
	* Get a random number up to max
	*/
	random_num : function ( max )
	{
		return Math.floor(Math.random() * max);
	},

	/**
	* Keep the passed index within the total
	*/
	wrap_index : function ( index, total )
	{
		if ( total == 0 )
		{
			return 0;
		}
		
		while ( index >= total )
		{
			index -= total;
		}
		
		while ( index < 0 )
		{
			index += total;
		}
		
		/*
		if ( index < 0 )
		{
			index = total - 1;
		}
		else if ( index > total - 1 )
		{
			index = 0;
		}
		*/
		
		return index;
	},
	
	// --------------------------------------------------------------------
	//	# Numerical
	// --------------------------------------------------------------------

	/**
	* Format number with commas
	*/
	add_commas : function ( nStr )
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = ( x.length > 1 ? '.' + x[1] : '' );
		var rgx = /(\d+)(\d{3})/;
		while ( rgx.test(x1) )
		{
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	},

	/**
	* Get the percentage given the number and max
	*/
	get_percent : function ( num, max )
	{
		max = ( max !== undefined ) ? max : 100;
		var percent = num / max;
		return ( isNaN(percent) ? 0 : percent );
	},

	/**
	* Format number as US dollars
	*/
	format_dollars : function ( num, places )
	{
		num = parseFloat(num);
		places = ( places !== undefined ) ? places : 2;
		return '$' + this.add_commas(num.toFixed(places));
	},

	/**
	* Format number as percent
	*/
	format_percent : function ( num )
	{
		return Math.round(parseFloat(num)) + '%';
	},

	/**
	* Better float rounding precision
	*/
	round_number : function ( number, digits )
	{
		var multiple = Math.pow(10, digits);
		var rndedNum = Math.round(number * multiple) / multiple;
		return rndedNum;
	},

	// --------------------------------------------------------------------
	//	# URL
	// --------------------------------------------------------------------

	/**
	* Check if url matches an image format
	*/
	check_image_url : function ( url )
	{
		if ( url === undefined || $.type(url) !== 'string' )
		{
			return false;
		}
		
		return url && ( url.match(/\.(jpeg|jpg|gif|png)$/i) != null );
	},

	/**
	* Create an <a> tag element
	*/
	create_link : function ( text, url, attributes )
	{
		attributes = attributes || '';
		attributes = ( attributes.length > 0 ) ? ' ' + attributes : '';
		return '<a href="' + url + '"' + attributes + '>' + text + '</a>';
	},
	
	/**
	* Create pagination links for record navigation
	* 
	<div class="pagination-container">
		<nav class="nav_text-answer-pagination">
			<ul>
				<li class="first">&laquo; First</li>
				<li class="prev">&lsaquo; Prev</li>
				<li class="">1</li>
				<li class="">2</li>
				<li class="active">3</li>
				<li class="">4</li>
				<li class="">5</li>
				<li class="next">Next &rsaquo;</li>
				<li class="last">Last &raquo;</li>
			</ul>
		</nav>
	</div>
	*/
	create_pagination : function ( config )
	{
		var default_config = {
			base_url : '',
			num_links : 2,// Number of "digit" links to show before/after the currently viewed page
			offset : undefined,
			offset_key : 'page',
			page : undefined,
			pagination_container : undefined,
			per_page : 3,
			total_rows : 0,
			use_page : true,
			use_querystring : true,
			
			// Pagination config
			display_pages : true,
			
			full_tag_open : '<ul>',
			full_tag_close : '</ul>',
			
			first_tag_open : '<li class="first">',
			first_link : '&laquo; First',
			first_tag_close : '</li>',
			
			prev_tag_open : '<li class="prev">',
			prev_link : '&lsaquo; Prev',
			prev_tag_close : '</li>',
			
			cur_tag_open : '<li class="active">',
			cur_tag_close : '</li>',
			
			num_tag_open : '<li class="">',
			num_tag_close : '</li>',
			
			next_tag_open : '<li class="next">',
			next_link : 'Next &rsaquo;',
			next_tag_close : '</li>',
			
			last_tag_open : '<li class="last">',
			last_link : 'Last &raquo;',
			last_tag_close : '</li>',
		};
		config = $.extend({}, default_config, config);
		
		if ( config.total_rows == 0 )
		{
			return;
		}
		
		var has_querystring = this.has_querystring(config.base_url);
		var base_url = config.base_url + ( has_querystring ? '&' : '?' ) + config.offset_key + '=';
		
		var limit = config.per_page;
		var total_pages = Math.ceil(config.total_rows / config.per_page);
		
		// Get current page from config or url
		var page = config.page;
		if ( page === undefined )
		{
			var qs_vars = this.parse_querystring();
			page = qs_vars[config.offset_key] || 1;
		}
		// Normalize page to number
		page *= 1;
		
		// Check page range
		if ( page > total_pages )
		{
			page = total_pages;
		}
		
		if ( page < 1 )
		{
			page = 1;
		}
		
		var offset = (page - 1) * limit;
		
		// Set the starting and ending pages based on the current page
		var starting_page = page - config.num_links;
		var ending_page = page + config.num_links;
		// If starting page out of range, put in range and shift overflow to ending page
		if ( starting_page < 1 )
		{
			ending_page += Math.abs(starting_page) + 1;
			starting_page = 1;
		}
		// If ending page out of range, put in range and shift overflow to starting page
		if ( ending_page > total_pages )
		{
			starting_page -= ending_page - total_pages;
			ending_page = total_pages;
		}
		// Check starting page range
		if ( starting_page < 1 )
		{
			starting_page = 1;
		}
		// Check ending page range
		if ( ending_page > total_pages )
		{
			ending_page = total_pages;
		}
		
		var pieces = new Array();
		
		// Begin pagination html
		pieces.push(config.full_tag_open);
		
		// If not showing the first page, show first_link
		if ( starting_page > 1 )
		{
			pieces.push(
				config.first_tag_open + 
				this.create_link(config.first_link, base_url + 1) + 
				config.first_tag_close
			);
		}
		
		// If not on the first page, show prev_link
		if ( page != 1 )
		{
			pieces.push(
				config.prev_tag_open + 
				this.create_link(config.prev_link, base_url + (page - 1)) + 
				config.prev_tag_close
			);
		}
		
		// Create links for page range
		if ( config.display_pages )
		{
			for ( var page_i = starting_page; page_i <= ending_page; page_i++ )
			{
				if ( page_i == page )
				{
					pieces.push(
						config.cur_tag_open + 
						this.create_link(page_i, base_url + page_i) + 
						config.cur_tag_close
					);
				}
				else
				{
					pieces.push(
						config.num_tag_open + 
						this.create_link(page_i, base_url + page_i) + 
						config.num_tag_close
					);
				}
			}
		}
		
		// If not on the last page, show next_link
		if ( page != total_pages )
		{
			pieces.push(
				config.next_tag_open + 
				this.create_link(config.next_link, base_url + (page + 1)) + 
				config.next_tag_close
			);
		}
		
		// If not showing the last page, show last_link
		if ( ending_page < total_pages )
		{
			pieces.push(
				config.last_tag_open + 
				this.create_link(config.last_link, base_url + total_pages) + 
				config.last_tag_close
			);
		}
		
		// End pagination html
		pieces.push(config.full_tag_close);
		
		var links = ( total_pages > 1 ) ? pieces.join("\n") : null;
		
		var data = {
			page : page,
			total_pages : total_pages,
			per_page : limit,
			limit : limit,
			offset : offset,
			limit_data : {
				limit : limit,
				offset : offset,
			},
			from : ( config.total_rows > 0 ) ? offset + 1 : 0,
			to : ( offset + config.per_page > config.total_rows ) ? config.total_rows : offset + config.per_page,
			links : links,
		};
		
		if ( config.pagination_container !== undefined )
		{
			var $pagination_container = $(config.pagination_container);
			//$pagination_container.empty();
			$pagination_container.html(links);
		}
		
		return data;
	},
	
	/**
	* Get hash from url
	* 
	* http://stackoverflow.com/questions/298503/how-can-you-check-for-a-hash-in-a-url-using-javascript
	* http://stackoverflow.com/questions/1822598/getting-url-hash-location-and-using-it-in-jquery
	*/
	get_hash : function ( url )
	{
		var hash = undefined;
		
		if ( url !== undefined )
		{
			hash = url.split('#')[1];//If the URI is not the document's location
		}
		// if hash found
		else if ( window.location.hash )
		{
			hash = window.location.hash.replace('#', '');
			//hash = window.location.hash.substring(1);//Puts hash in variable, and removes the # character
			//hash = window.location.hash.slice(1);//hash to string (= "myanchor")
		}
		
		return hash;
	},

	/**
	* Get querystring from url
	*/
	get_querystring : function ( url )
	{
		var querystring = '';
		
		if ( url !== undefined )
		{
			querystring = url.split('?')[1];//If the URI is not the document's location
		}
		// if search found
		else if ( window.location.search )
		{
			querystring = window.location.search.replace('?', '');
			//querystring = window.location.search.substring(1);//Puts querystring in variable, and removes the ? character
			//querystring = window.location.search.slice(1);
		}
		
		return querystring;
	},

	/**
	* Get variable from querystring
	*/
	get_querystring_var : function ( field, url )
	{
		var qs_vars = this.parse_querystring(url);
		return qs_vars[field];
	},

	/**
	* Check if url has a querystring
	*/
	has_querystring : function ( url )
	{
		if ( url === undefined )
		{
			url = window.location.search || '';
		}
		
		return ( url.indexOf('?') >= 0 );
	},

	/**
	* Check if querystring has field
	*/
	has_querystring_field : function ( field, url )
	{
		if ( url === undefined )
		{
			url = window.location.search || '';
		}
		
		return (
			url.indexOf('?' + field + '=') >= 0 ||
			url.indexOf('&' + field + '=') >= 0 ||
			url.indexOf('&amp;' + field + '=') >= 0
		);
	},

	/**
	* Parse querystring
	* 
	* http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values
	* http://www.svlada.com/blog/2012/06/15/how-to-get-url-parameters-javascript/
	* https://github.com/rapportive-oss/jquery-parsequery/blob/master/jquery.parsequery.js
	* http://www.joezimjs.com/javascript/3-ways-to-parse-a-query-string-in-a-url/
	*/
	parse_querystring : function ( url )
	{
		var data = {};
		
		var querystring = this.get_querystring(url);
		if ( querystring.length > 0 )
		{
			var qs_pairs = querystring.split('&');
			for ( var i = 0; i < qs_pairs.length; ++i )
			{
				var qs_kv = qs_pairs[i].split('=');
				//if (qs_kv.length != 2) continue;
				data[qs_kv[0]] = (qs_kv.length >= 2) ? decodeURIComponent(qs_kv[1].replace(/\+/g, ' ')) : '';
			}
		}
		
		return data;
	},

	/**
	* This function creates a new anchor element and uses location
	* properties (inherent) to get the desired URL data. Some String
	* operations are used (to normalize results across browsers).
	* 
	* http://james.padolsey.com/javascript/parsing-urls-with-the-dom/
	*/
	parse_url : function (url)
	{
		var a =  document.createElement('a');
		a.href = url;
		return {
			source: url,
			protocol: a.protocol.replace(':',''),
			host: a.hostname,
			port: a.port,
			query: a.search,
			params: (function(){
				var ret = {},
				seg = a.search.replace(/^\?/,'').split('&'),
				len = seg.length, i = 0, s;
				for (;i<len;i++) {
					if (!seg[i]) { continue; }
					s = seg[i].split('=');
					ret[s[0]] = s[1];
				}
				return ret;
			})(),
			file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
			hash: a.hash.replace('#',''),
			path: a.pathname.replace(/^([^\/])/,'/$1'),
			relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
			segments: a.pathname.replace(/^\//,'').split('/')
		};
	},
	
	/**
	* Create a url-safe string
	* 
	* http://stackoverflow.com/questions/1053902/how-to-convert-a-title-to-a-url-slug-in-jquery
	*/
	url_title : function ( string )
	{
		return string
			.toLowerCase()
			.replace(/[^\w ]+/g, '')
			.replace(/\s+/g, '-')
			;
	},
	
	/**
	* Encode common html entities with replacements
	*/
	encode_html_entities : function ( string )
	{
		return String(string).replace(/&amp;/g, '&').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	},
	
	/**
	* Encode html entities using DOM
	*/
	encode_entities : function ( string )
	{
		return $('<div/>').text(string).html();
	},
	
	/**
	* Decode html entities using DOM
	*/
	decode_entities : function ( string )
	{
		return $('<div/>').html(string).text();
	},
	
	// --------------------------------------------------------------------
	//	# Files
	// --------------------------------------------------------------------

	/**
	* Parse file into parts
	*/
	get_file_parts  : function ( file )
	{
		var data = {'path' : '', 'filename' : '', 'name' : '', 'ext' : ''};
		
		// Check if path to parse
		if ( file.indexOf('/') == -1 )
		{
			data.filename = file;
		}
		else
		{
			// Run through these in case file is a url
			//this removes the anchor at the end, if there is one
			file = file.substring(0, (file.indexOf('#') == -1) ? file.length : file.indexOf('#'));
			//this removes the query after the file name, if there is one
			file = file.substring(0, (file.indexOf('?') == -1) ? file.length : file.indexOf('?'));
			
			data.path = file.substring(0, file.lastIndexOf('/') + 1);
			//this removes everything before the last slash in the path
			data.filename = file.substring(file.lastIndexOf('/') + 1, file.length);
		}
		
		var pieces = data.filename.split('.');
		//http://stackoverflow.com/questions/190852/how-can-i-get-file-extensions-with-javascript
		//data.ext = filename.split('.').pop();
		if ( pieces.length > 1 )
		{
			data.ext = pieces[pieces.length - 1];
			pieces.splice(pieces.length - 1, 1);
		}
		data.name = pieces.join('.');
		
		return data;
	},

	// --------------------------------------------------------------------
	//	# Forms
	// --------------------------------------------------------------------

	/**
	* Append an object of fields to a form
	*/
	append_fields_to_form : function ( form, fields )
	{
		$form = $(form);
		
		for ( key in fields )
		{
			$form.append('<input type="hidden" name="' + key + '" value="' + fields[key] + '" autocomplete="off">');
		}
		
		key = $form = undefined;
		delete key;
		delete $form;
	},

	/**
	* Create a temporary iframe form target, scrape data to onload callback, remove self
	* 
	* @param mixed Callback function
	* @return object Created jQuery iframe element
	*/
	create_iframe_form_target : function ( onload_callback )
	{
		// Create a random id
		var randomized_number = new Date().getTime() + '-' + new Date().getMilliseconds() + '-' + Math.floor(Math.random() * 101);
		var new_id = 'iframe_form-target_' + randomized_number;
		
		// Create iframe
		var $iframe = $('<iframe id="' + new_id + '" name="' + new_id + '" frameborder="0" scrolling="no" marginwidth="0" marginheight="0" hspace="0" vspace="0" height="0" width="0" style="border: 0 none; height: 0px; left: 0; overflow: hidden; position: absolute: top: 0; width: 0px;"></iframe>');
		var iframe = $iframe[0];
		// Add to DOM now to prevent onload firing after attachment
		$('body').append($iframe);
		
		// Create onload event
		var onload_iframe = function( event )
		{
			// Get iframe text content
			var content = false;
			var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
			if ( iframeDocument )
			{
				content = iframeDocument.getElementsByTagName('body')[0].innerHTML;
			}
			// Remove iframe and run callback
			$iframe.remove();
			onload_callback(content);
		};
		
		// Attach onload event handler
		if ( iframe.attachEvent )
		{
			iframe.attachEvent('onload', onload_iframe);
		}
		else
		{
			iframe.onload = onload_iframe;
		}
		
		return $iframe;
	},

	/**
	* Format a phone number dynamically based on length
	* 
	
	$('input[name="phone"]').on('keyup change', function(event)
	{
		var $this = $(this);
		var phone_digits = $this.data('phone-digits');
		var new_phone_digits = this.value.replace(/[^0-9x]/g, '');
		if ( phone_digits != new_phone_digits )
		{
			$this.val( format_phone(this.value) );
			$this.data('phone-digits', new_phone_digits);
		}
	});
	
	*/
	format_phone : function ( text )
	{
		var text = text.replace(/[^0-9x]/g, '');
		//var text = text.replace(/\s+/g, '');

		if ( text.length <= 6 )
		{
			return text.replace(/(\d{3})(\d{3})?/, '($1) $2');
		}
		else if ( text.length <= 10 )
		{
			return text.replace(/(\d{3})(\d{3})?(\d{4})?/, '($1) $2-$3');
		}
		else
		{
			return text.replace(/(\d)?\D*?(\d{3})\D*?(\d{3})\D*?(\d{4})(.*)?/, '$1($2) $3-$4$5');
		}
		
		if ( text.length > 10 )
		{
			return text.replace(/\D*?(\d{0,1})\D*?(\d{1,3})\D*?(\d{1,3})?\D*?(\d{1,4})?(.*)?/, '$1($2) $3-$4$5');
		}
		else
		{
			return text.replace(/\D*?(\d{1,3})\D*?(\d{1,3})?\D*?(\d{1,4})?(.*)?/, '($1) $2-$3');
		}
		
		return text.replace(/(\d)?\D*?(\d{3})\D*?(\d{3})\D*?(\d{4})(.*)?/, '$1($2) $3-$4$5');
		return text.replace(/(\d)?\D*?(\d{1,3})\D*?(\d{0,3})\D*?(\d{0,4})(.*)?/, '$1($2) $3-$4$5');
		return text.replace(/(\d)?\D*?(\d{3})\D*?(\d{3})\D*?(\d{4})(.*)?/, '$1($2) $3-$4$5');
		
		if ( phone.length > 10 )
		{
			return phone.replace(/(\d)(\d{3})(\d{3})(\d{4})(\d*)/, '$1 ($2) $3-$4 $5');
		}
		
		return phone.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
	},
	
	/**
	* Validation methods
	*/
	validation : {
		valid_required : function( string )
		{
			return (string != '' || string.length > 0);
		},
		valid_max_length : function( string, max )
		{
			max = max || 3;
			return (max.length > parseFloat(max));
		},
		valid_min_length : function( string, min )
		{
			min = min || 3;
			return (min.length < parseFloat(min));
		},
		//http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
		valid_email : function( string )
		{
			//var email_reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var email_reg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return (string.length > 0 && email_reg.test(string));
		},
		//http://stackoverflow.com/questions/123559/a-comprehensive-regex-for-phone-number-validation
		valid_phone : function( string )
		{
			var phone_reg = /^[0-9\(\)\/\+ \-\.ext]*\d$/;// /^[\d\+\-\.\(\)x ]+$/ // /^[0-9\(\)\/\+ \-\.ext]*\d$/
			return (string.length > 0 && phone_reg.test(string));
		},
		valid_zip : function( string )
		{
			var zip_reg = /^[0-9]{5}(?:-[0-9]{4})?$/;
			return (string.length > 0 && zip_reg.test(string));
		},
		'' : ''
	},

	// --------------------------------------------------------------------
	//	# Browser Abilities
	// --------------------------------------------------------------------

	/**
	* http://stackoverflow.com/questions/11381673/javascript-solution-to-detect-mobile-browser/11381730#11381730
	*/
	is_mobile : function()
	{
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	},

	// --------------------------------------------------------------------
	//	# Logging
	// --------------------------------------------------------------------
	
	/**
	* Console or browser logging
	*/
	log : function ( message, debug )
	{
		if ( debug )
		{
			var $debug = $('#debug');
			if ( $debug.length == 0 )
			{
				$debug = $('<div id="debug"></div>').appendTo('body');
			}
			$debug.append('<p>' + message + '</p>');
		}
		
		if ( window.console && window.console.log )
		{
			console.log(message);
		}
	},

	// --------------------------------------------------------------------
	//	# AJAX
	// --------------------------------------------------------------------

	/**
	* Common functionality before sending AJAX
	*/
	ajax_beforesend_handler : function ( jq_xhr, settings )
	{
		window.REDLOVE.fn.show_site_loading();
	},

	/**
	* Common functionality after AJAX complete
	*/
	ajax_complete_handler : function ( jq_xhr, text_status )
	{
		window.REDLOVE.fn.show_site_loading(false);
	},

	/**
	* Common functionality for AJAX error
	*/
	ajax_error_handler : function ( jq_xhr, text_status, error_thrown )
	{
		var newline = "\n";
		var message = [
			'There was an error with the request.',
			'Javascript: ' + error_thrown,
			'Application: ' + jq_xhr.responseText
		].join(newline);
		
		window.REDLOVE.fn.show_message(message, 'error');
	},

	/**
	* Common handler for AJAX status codes
	*/
	ajax_statuscode_handler : {
		404 : function ()
		{
			show_message('The page was not found.', 'error');
		}
	},

	/**
	* Create a throttle to actions
	*/
	create_throttle : function ( milliseconds, message )
	{
		//callback = callback || function(){};// Define an empty anonymous function so something exists to call
		
		// Throttle requests
		var throttle_time_last = 0;
		var throttle_milliseconds = milliseconds || 250;
		var throttle_message = message || 'Action frequency throttled.';
		var debounce_timeout;

		return function check_throttle()
		{
			// Throttle (ensures 1 action during interval) and Debounce (ensures 1 action after interval)
			var now = new Date().getTime();
			var throttle_time_elapsed = now - throttle_time_last;
			// Throttle: If request time is too soon since last request
			if ( throttle_time_elapsed < throttle_milliseconds )
			{
				//javascript_abort(throttle_message);
				
				/*
				//console.log('Throttled and setting debounce');
				// Debounce: Reset timeout for delayed event to run when requests stop
				clearTimeout(debounce_timeout);
				debounce_timeout = null;// Eliminate the chance of creating concurrent timeouts
				var debounce_milliseconds = throttle_milliseconds - throttle_time_elapsed;
				// Set minimum milliseconds to avoid race conditions and multiple setTimeouts
				if ( debounce_milliseconds >= 50 )
				{
					debounce_timeout = setTimeout(function(){
						//console.log('Debounce passed, running callback()');//callback();
					}, debounce_milliseconds);
				}
				*/
				
				return;
			}
			throttle_time_last = now;
			
			//console.log('Throttle passed, running callback()');//callback();
		};
	},

	/**
	* Stop JavaScript execution
	*/
	javascript_abort : function ( message )
	{
		if ( typeof(message) == 'undefined' )
		{
			message = 'This is not an error. This is just to abort javascript.';
		}
		
		throw new Error(message);
		
		// To try in code and silently capture errors
		// Entry point...
		try
		{
			// Run code that can error
		}
		// Handle error message if appropriate
		catch( e )
		{
			console.log(e.message);
		}
	},

	/**
	* Convert object to url encoded querystring
	*/
	serialize_data : function ( obj, field_name )
	{
		var str = '';
		for ( var key in obj )
		{
			// If using a static field name[] with an array of values, like for multiple checkbox values
			var url_key = ( field_name !== undefined && field_name.length > 0 ) ? field_name : key;
			str += '&' + encodeURIComponent(url_key) + '=' + encodeURIComponent(obj[key]);
		}
		return str;
	},

	/**
	* Serialize all passed arguments
	*/
	serialize_multiple : function ()
	{
		var data = '';
		for ( var arg_i in arguments )
		{
			var arg = arguments[arg_i];
			if ( typeof arg === 'object' )
			{
				data += this.serialize_data(arg);
			}
			else
			{
				// Check if string is already encoded
				//arg = ( typeof arg == 'string' && decodeURIComponent(arg) !== arg ) ? arg : encodeURIComponent(arg);
				data += '&' + arg;
			}
		}
		return data;
	},

	/**
	* Safely attempt parsing JSON string
	* 
	* http://stackoverflow.com/questions/3710204/how-to-check-if-a-string-is-a-valid-json-string-in-javascript-without-using-try
	*/
	try_parse_json : function ( string )
	{
		try
		{
			var o = jQuery.parseJSON(string);

			// Handle non-exception-throwing cases:
			// Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
			// but... JSON.parse(null) returns 'null', and typeof null === "object", 
			// so we must check for that, too.
			if ( o && typeof o === 'object' && o !== null )
			{
				return o;
			}
		}
		catch (e) { }

		return false;
	},

	/**
	* Show common form loading indicator
	*/
	show_form_loading : function ( $form, show )
	{
		var show = ( show !== false );
		
		var $submit_button = $('[type="submit"]', $form);
		var is_input = ( $submit_button.length > 0 );
		$submit_button = is_input ? $submit_button : $('.form-submit', $form);
		
		var initial_submit_value = $submit_button.data('initial-value');
		if ( initial_submit_value === undefined )
		{
			initial_submit_value = is_input ? $submit_button.val() : $submit_button.html();
			$submit_button.data('initial-value', initial_submit_value);
		}
		
		if ( show )
		{
			if ( is_input )
			{
				$submit_button.prop('disabled', true).val('Sending...');
			}
			else
			{
				$submit_button.attr('disabled', 'disabled').html('Sending...');
			}
			
			//var messages = new Array('Please wait...');
			//this.show_form_messages($form, messages, 'warning');
		}
		else
		{
			if ( is_input )
			{
				$submit_button.prop('disabled', false).val(initial_submit_value);
			}
			else
			{
				$submit_button.attr('disabled', '').html(initial_submit_value);
			}
			
			//this.show_form_messages($form);
		}
	},

	/**
	* Show common form messages
	*/
	show_form_messages : function ( $form, messages, type )
	{
		// Find or create messages element within form
		var $notifications = $('.notifications', $form);
		if ( ! $notifications.length )
		{
			$notifications = $('<div class="notifications"></div>').prependTo($form);
		}
		
		$notifications.empty();//.html(messages.join("\n"));
		
		// If a message string, convert to array
		if ( typeof messages == 'string' && messages.length > 0 )
		{
			messages = new Array(messages);
		}
		
		// Display messages
		if ( messages && messages.length > 0 )
		{
			// Show each message individually
			for ( var messages_index in messages )
			{
				var message = messages[messages_index];
				if ( message.length > 0 )
				{
					$notifications.append( $('<div class="notification ' + type + '">' + message + '</div>') );
				}
			}
			
			// Scroll to notifications
			$('html,body').animate({
				scrollTop : $notifications.offset().top - 100//0//$form.offset().top
			}, 500, function(){});
		}
		
		return $notifications;
	},

	/**
	* Show common message
	*/
	show_message : function ( messages, type )
	{
		if ( typeof messages === 'string' )
		{
			messages = new Array(messages);
		}
		
		for ( var i in messages )
		{
			message = String(messages[i]);
			if ( type == 'error' )
			{
				alert(message);
			}
			else
			{
				alert(message);
			}
		}
		/*
		for ( var i in messages )
		{
			message = String(messages[i]).replace("\n", '<br>');
			growl.create(message, type, 5000);
		}
		*/
	},

	/**
	* Show common site loading indicator
	*/
	show_site_loading : function ( show )
	{
		show = ( show !== false );
		
		// Create element if it doesn't exist
		var site_loading_class = 'site-loading';
		var $site_loading = $('.' + site_loading_class);
		if ( $site_loading.length == 0 )
		{
			$site_loading = $('<div class="'+ site_loading_class + '"></div>').appendTo('body');
			// Prevent mouse interactions
			$site_loading.on('click', function ( event )
			{
				event.preventDefault();
				event.stopImmediatePropagation();
				return false;
			});
		}
		
		if ( show )
		{
			// Prevent body scrolling and text selection
			$('body').addClass('no-scroll no-select');
			$site_loading.stop().fadeIn(300);
		}
		else
		{
			$site_loading.stop().fadeOut(300, function ()
			{
				$('body').removeClass('no-scroll no-select');
			});
		}
	},

	// --------------------------------------------------------------------
	//	# Analytics
	// --------------------------------------------------------------------
	
	/**
	* Register analytics event; work with jQuery helper on .analytics_event
	*/
	send_analytics_event : function ( href, category, action, label, value )
	{
		//console.log('send_analytics_hit: ' + href + ', ' + category + ', ' + action + ', ' + label + ', ' + value);
		
		// Google Analytics
		if ( window.ga )
		{
			// https://developers.google.com/analytics/devguides/collection/analyticsjs/events
			// send, event, [category], [action], [label], [value](number)
			window.ga('send', 'event', category, action, label);
		}
		else if ( window._gaq )
		{
			//var _gaq = window._gaq || [];
			window._gaq.push(['_trackEvent', category, action, label]);
		}
		
		/*
		// Lyris
		$lyris_iframe = $('#lyris_iframe');
		// Create if it doesn't exist
		if ( $lyris_iframe.length == 0 )
		{
			$lyris_iframe = $('<iframe id="lyris_iframe" src="about:blank" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" style="position:absolute;width:0;height:0;border:none;" tabindex="-1"  />').appendTo('body');
		}
		$lyris_iframe[0].src = REDLOVE.base_url + 'analytics/event/link/click?page=' + encodeURIComponent(href) + '&title=' + encodeURIComponent(label);
		*/
	},
	
	/**
	* Register analytics page hit; work with jQuery helper on .analytics_page
	*/
	send_analytics_page : function ( href, title )
	{
		// Google Analytics
		if ( window.ga )
		{
			window.ga('send', 'pageview', {
				'page' : href,
				'title' : title
			});
		}
		else if ( window._gaq )
		{
			//var _gaq = window._gaq || [];
			window._gaq.push(['_trackPageview', href]);
		}
	},
	
	// --------------------------------------------------------------------
	
	'' : ''// Empty so each property above ends with a comma
	
});

// --------------------------------------------------------------------

// --------------------------------------------------------------------
//	# Logging
// --------------------------------------------------------------------

/**
* Avoid `console` errors in browsers that lack a console.
* 
* http://stackoverflow.com/questions/7585351/testing-for-console-log-statements-in-ie
*/
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = ( window.console = window.console || {} );

    while ( length-- )
	{
        method = methods[length];

        // Only stub undefined methods.
        if ( ! console[method] )
		{
            console[method] = noop;
        }
    }
}());

// --------------------------------------------------------------------

//]]>