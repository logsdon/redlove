
	<meta charset="utf-8">
	<title><?php echo ! empty($page_data['meta_title']) ? $page_data['meta_title'] : ''; ?></title>
	<meta name="description" content="<?php echo ! empty($page_data['meta_description']) ? $page_data['meta_description'] : ''; ?>">
	<meta name="keywords" content="<?php echo ! empty($page_data['meta_keywords']) ? $page_data['meta_keywords'] : ''; ?>">

	<meta name="robots" content="index,follow">
	<meta name="MSSmartTagsPreventParsing" content="true">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="imagetoolbar" content="false">

	<!-- Mobile-specific Metas , maximum-scale=1-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Open Graph -->
	<?php
	if ( ! isset($page__skip_og) )
	{
		$open_graph_default_title = ! empty($page_data['meta_title']) ? $page_data['meta_title'] : '';//Page Title &mdash; Example.com
		$open_graph_default_site_name = ! empty($page_data['site_name']) ? $page_data['site_name'] : $open_graph_default_title;//Example Site
		$open_graph_default_description = ! empty($page_data['meta_description']) ? $page_data['meta_description'] : '';//The description of the example site
		$open_graph_default_url = theme_nav_url(PAGE);
		$open_graph_default_image = theme_base_url() . 'images/favicon/favicon.png';
		$open_graph = ! empty($open_graph) ? $open_graph : array();
		$open_graph_defaults = array(
			// Facebook uses property attributes
			'og:title' => $open_graph_default_title,
			'og:type' => 'website',
			'og:url' => $open_graph_default_url,
			'og:image' => $open_graph_default_image,
			'og:site_name' => $open_graph_default_site_name,
			'og:locale' => 'en_US',
			'og:description' => $open_graph_default_description,
			'fb:app_id' => '',
			// Twitter uses name attributes
			'twitter:card' => 'summary',
			'twitter:site' => '',//@username
			'twitter:title' => $open_graph_default_title,
			'twitter:description' => $open_graph_default_description,
			'twitter:image' => $open_graph_default_image,
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

	<!-- StyleSheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo redlove_cb_url('stylesheets/redlove/base.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo redlove_cb_url('stylesheets/redlove/common.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo theme_cb_url('stylesheets/site.css'); ?>">

	<!--<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo redlove_cb_url('stylesheets/font-awesome/css/font-awesome.min.css'); ?>">
	
	<link rel="stylesheet" type="text/css" href="<?php echo redlove_cb_url('stylesheets/daneden/animate.min.css'); ?>">

	<!-- JavaScript -->
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo redlove_cb_url('javascript/etc/html5.js'); ?>"></script><![endif]-->
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo redlove_cb_url('javascript/etc/respond.min.js'); ?>"></script><![endif]-->
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/jquery/jquery.min.js'); ?>"><\/script>')</script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript">window.jQuery.ui || document.write('<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/jquery/jquery-ui.min.js'); ?>"><\/script>')</script>
	
	<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/etc/holder.js'); ?>"></script>
	
	<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/redlove/base.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/redlove/common.js'); ?>"></script>
	<script type="text/javascript">
	//<![CDATA[
		// Set common data
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
			base_url : '<?php echo function_exists('theme_nav_url') ? theme_nav_url() : ''; ?>',
			page_start_time : <?php echo time(); ?>,
			server_timezone_offset : <?php echo date('Z'); ?>,
			'' : ''// Empty so each real property set above has a comma after it
		});
	//]]>
	</script>
	
	<!-- Favicons - http://realfavicongenerator.net/, https://css-tricks.com/favicon-quiz/ -->
	<link rel="image_src" href="<?php echo theme_base_url(); ?>images/favicon/favicon.png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-precomposed.png">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo theme_base_url(); ?>images/favicon/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="<?php echo theme_base_url(); ?>images/favicon/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="<?php echo theme_base_url(); ?>images/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo theme_base_url(); ?>images/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo theme_base_url(); ?>images/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?php echo theme_base_url(); ?>images/favicon/manifest.json">
	<link rel="mask-icon" href="<?php echo theme_base_url(); ?>images/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="<?php echo theme_base_url(); ?>images/favicon/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="<?php echo theme_base_url(); ?>images/favicon/mstile-144x144.png">
	<meta name="msapplication-config" content="<?php echo theme_base_url(); ?>images/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

	<!-- Feeds -->
	<!--<link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php echo theme_nav_url(); ?>">-->

	<!-- Canonical -->
	<!--<link rel="canonical" href="<?php //echo theme_nav_url(PAGE); ?>">-->
	<!--<link rel="canonical" href="https://www.example.com/<?php //echo preg_replace('/\\.[^.\\s]{3,4}$/', '', strtok(REQUEST_URI, '?')); ?>">-->

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
