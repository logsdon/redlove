<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 3) . 'includes/common.php');
}

$page_data = array(
	'meta_title' => 'Contact | Top Home Inspections | Columbus, Ohio',
	'meta_description' => 'Let Top Home Inspections evaluate the condition of your current or soon-to-be home to make you aware of existing and potential issues. We&srquo;re qualified, high integrity, and Columbus local. Call us now at (614) 123-4567',
	'meta_keywords' => 'home, inspection, columbus, ohio, building, professional, thorough, report, issues, roof, insulation, plumbing, foundation, electrical',
	'site_name' => 'Top Home Inspections | Columbus, Ohio',
);
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="loading no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="loading no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="loading no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEME_PATH . 'includes/common/head.php');
	?>
	
</head>
<body class="mobile-menu-liner">
<?php
// Body Prepend
include(THEME_PATH . 'includes/common/body.prepend.php');
?>


<div class="body-liner">


<?php require_once(THEME_PATH . 'includes/common/header.php'); ?>



<div class="band-wrap">
<div class="band padding-tbl content grid-gutter">
<div class="band-liner">

	<section class="content">
		<div class="tab-title">
			<h2>Contact Us</h2>
			<h3>Uncompromising quality at competitive rates</h3>
		</div>
		<p>If you are in the market for a home inspection, get in touch. We're ready to help you out.</p>
		
		<form action="<?php echo theme_url('_process'); ?>" method="post" novalidate="novalidate" class="contact-form"><!--enctype="multipart/form-data"-->
			<input type="hidden" name="action" value="contact">
			
			<fieldset>
			
				<div class="columns grid grid-flush">
					<div class="column-row">
						<div class="column w50">
							<label>Name<em>*</em></label>
							<input type="text" name="name" placeholder="Your Name" class="width-full">
						</div>
						<div class="column w50">
							<label>Phone<em>*</em></label>
							<input type="phone" name="phone" placeholder="(###) ###-####" class="width-full">
						</div>
						<div class="column w50">
							<label>Email<em>*</em></label>
							<input type="email" name="email" placeholder="you@mail.com" class="width-full">
						</div>
						<div class="column w50">
							<label>Subject<em>*</em></label>
							<select name="subject" class="width-full">
								<option value="">&mdash; Please select &mdash;</option>
								<option>Questions</option>
								<option>Quote</option>
								<option>Other</option>
							</select>
						</div>
					</div>
					<div class="column-row">
						<div class="column w100">
							<label>Message<em>*</em></label>
							<textarea name="message" placeholder="Your message&hellip;" class="width-full" rows="5"></textarea>
						</div>
					</div>
					<div class="column-row margin-t3">
						<div class="column w100">
							<input type="submit" value="Submit" class="w100 padding-tb2 button button-inverse">
						</div>
					</div>
				</div>
				
			</fieldset>
			
		</form>

	</section>
	
</div>
</div>
</div>



<?php require_once(THEME_PATH . 'includes/common/footer.php'); ?>

</div>
<!-- /body-liner -->


<?php
// Body Append
include(THEME_PATH . 'includes/common/body.append.php');
?>
</body>
</html>