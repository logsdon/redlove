
	<meta name="robots" content="index,follow" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="imagetoolbar" content="false" />

	<!-- Mobile-specific Metas , maximum-scale=1-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Open Graph -->
	<!--
	<?php
	if ( ! isset($page__skip_og) )
	{
		$open_graph = ! empty($open_graph) ? $open_graph : array();
		$open_graph_defaults = array(
			// Facebook uses property attributes
			'og:title' => ! empty($page_data['meta_title']) ? $page_data['meta_title'] : 'Page Title &mdash; Example.com',
			'og:type' => 'website',
			'og:url' => site_url(),
			'og:image' => base_url() . 'images/favicon.png',
			'og:site_name' => ! empty($page_data['site_name']) ? $page_data['site_name'] : 'Example Site',
			'og:locale' => 'en_US',
			'og:description' => ! empty($page_data['meta_description']) ? $page_data['meta_description'] : 'The description of the example site.',
			'fb:app_id' => '',
			// Twitter uses name attributes
			'twitter:card' => 'summary',
			'twitter:site' => '@username',
			'twitter:title' => ! empty($page_data['meta_title']) ? $page_data['meta_title'] : 'Page Title &mdash; Example.com',
			'twitter:description' => ! empty($page_data['meta_description']) ? $page_data['meta_description'] : 'The description of the example site.',
			'twitter:image' => base_url() . 'images/favicon.png',
		);
		$open_graph = array_merge($open_graph_defaults, $open_graph);
		foreach ( $open_graph as $key => $value )
		{
			if ( strlen($value) > 0 )
			{
		?>
		<meta name="<?php echo $key; ?>" property="<?php echo $key; ?>" content="<?php echo $value; ?>" />
		<?php
			}
		}
	}
	?>
	-->

	<!-- StyleSheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('../../stylesheets/redlove/base.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('../../stylesheets/redlove/common.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('../../stylesheets/redlove/examples.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('stylesheets/site.css'); ?>">

	<!--<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('stylesheets/font-awesome/css/font-awesome.min.css'); ?>">

	<!-- JavaScript -->
	<!--[if lt IE 9]><script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo base_url(); ?>javascript/respond.min.js"></script><![endif]-->
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="<?php echo base_url(); ?>javascript/jquery-1.11.3.min.js"><\/script>')</script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>javascript/holder.js"></script>
	
	<script type="text/javascript" src="<?php echo cb_url('../../javascript/redlove/base.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo cb_url('../../javascript/redlove/common.js'); ?>"></script>
	<script type="text/javascript">
		// Save common data
		window.REDLOVE = window.REDLOVE || {fn : {}};
		$.extend(window.REDLOVE, {
			debug : false,
			form_data : {
				<?php
				if ( isset($this) && property_exists($this, 'csrf') )
				{
				?>
					'<?php echo $this->csrf->get_token_name(); ?>' : '<?php echo $this->csrf->get_hash(); ?>',
				<?php
				}
				?>
				ajax : 1
			},
			base_url : '<?php echo function_exists('base_url') ? base_url() : ''; ?>',
			page_start_time : <?php echo time(); ?>,
			server_timezone_offset : <?php echo date('Z'); ?>,
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
			'' : ''// Empty so each real property set above has a comma after it
		});
	</script>

	<!-- Favicons -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>images/favicon.ico" />
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>images/favicon.ico" />
	<link rel="image_src" href="<?php echo base_url(); ?>images/favicon.png" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>images/favicon_152x152.png">
	<meta name="msapplication-TileImage" content="<?php echo base_url(); ?>images/favicon_144x144.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">

	<!-- Feeds 
	<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php echo site_url(); ?>">
	-->

<?php
if ( ENVIRONMENT == 'production' )
{
?>

	<!-- Google Analytics -->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA--1']);
	  _gaq.push(['_setDomainName', 'example.com']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>

	<!-- Google Analytics -->
	<script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA--1', 'auto');
		ga('send', 'pageview');
	</script>
	
<?php
}
?>
