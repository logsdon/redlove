<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 3) . 'includes/common.php');
}
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEME_PATH . 'common/head.php');
	?>
	
</head>
<body class="mobile-menu-liner">

<div class="body-liner">


<?php require_once(THEME_PATH . 'common/header-logged-in.php'); ?>



<div class="band-wrap">
<div class="band padding-tbl content grid-gutter">
<div class="band-liner">

	<section class="content">

		<div class="columns grid grid-flush">
			<div class="column-row">
				<div class="column w50">
					Internal Menu Dashboard Applications<br>
					
					<h3>Getting Started</h3>
					<p>Welcome, employee name, to the education manager for XYZ Company.</p>
					<p>Click the Start New Application button below to begin a new application request.</p>
					<p><a href="" class="button">Start New Application</a></p>
					
					<h3>Frequently Asked Questions</h3>
					<ul>
						<li>How do I change my password?</li>
						<li>How do I check the status of my current applications?</li>
						<li>How can I cancel an application?</li>
						<li>How can I access my company policy about educational assistance?</li>
						<li>How do I check my account balance?</li>
					</ul>
				</div>
				<div class="column w50">
					<h3>Application Notifications</h3>
					<div class="notification notification-success">
						<p>Application: 0001 has been approved. Sept. 30, 2015</p>
					</div>
					<div class="notification notification-success">
						<p>Application: 0002 has been approved. Sept. 28, 2015</p>
					</div>
					<div class="notification notification-error">
						<p>Application: 0003 has been declined. Sept. 28, 2015</p>
					</div>
					<div class="notification notification-warning">
						<p>Application: 0004 requires documentation. Sept. 28, 2015</p>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	
</div>
</div>
</div>



<?php require_once(THEME_PATH . 'common/footer.php'); ?>

</div>
<!-- /body-liner -->



<!-- JavaScript -->

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($)
{
});
//]]>
</script>



</body>
</html>