<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 2) . 'includes/common.php');
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
	include(THEMEPATH . 'common/head.php');
	?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('site.css'); ?>">

</head>
<body class="mobile-menu-liner">

<div class="body-liner">



<?php require_once('common/header-logged-in.php'); ?>



<div class="band-wrap">
<div class="band padding-tbl content grid-gutter">
<div class="band-liner">

	<section class="content">

		<h3>My Applications</h3>
		<a href="" class="button">Start New Application</a>
		
		<div class="responsive-wrap">
			<table border="0" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>ID Number</th>
						<th>Description</th>
						<th>Status</th>
						<th>Amount</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody class="zebra">
					<tr>
						<td>0001</td>
						<td><a href="">Ohio University - Underwater Basket Weaving 101</a></td>
						<td>Approved - Payment Pending</td>
						<td>$532.68</td>
						<td>Cancel (X)</td>
					</tr>
					<tr>
						<td>0002</td>
						<td><a href="">Ohio University - Underwater Basket Weaving 201</a></td>
						<td>Approved - Payment Pending</td>
						<td>$732.84</td>
						<td>Cancel (X)</td>
					</tr>
					<tr>
						<td>0003</td>
						<td><a href="">Ohio University - Underwater Welding 101</a></td>
						<td>Denied - Payment Revoked</td>
						<td>$438.55</td>
						<td>Cancel (X)</td>
					</tr>
					<tr>
						<td>0004</td>
						<td><a href="">Ohio University - Underwater Welding 201</a></td>
						<td>Documentation Requested</td>
						<td>$345.98</td>
						<td>Cancel (X)</td>
					</tr>
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
		
	</section>
	
</div>
</div>
</div>



<?php require_once('common/footer.php'); ?>

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