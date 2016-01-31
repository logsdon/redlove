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
	
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'stylesheets/redlove/examples.css'); ?>">
	
</head>
<body class="mobile-menu-liner">
<?php
// Body Prepend
include(THEME_PATH . 'common/body.prepend.php');
?>

<div class="body-liner">

<?php
// Header
include(THEME_PATH . 'common/header.php');
?>

<div class="band-wrap">
<div class="band padding-tbm content">
<div class="band-liner">

	<section class="content">


<h1>Style References</h1>

<?php
$code = <<< CODE
<div class="border-radius" style="border: 1px solid #ccc;">border-radius</div>
<div class="box-shadow">box-shadow</div>
<span class="text-shadow">text-shadow</span>
<br>
<span class="gradient">gradient</span>
<br>
<span class="gradient-button">gradient-button</span>
<div class="animation-flicker">animation-flicker</div>

<div class="bg-size-cover" style="background-image: url('<?php echo base_url(); ?>images/test/small-0.jpg'); background-position: 50% 50%; background-repeat: no-repeat; height: 100px;">background-size: cover; Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area</div>
<div class="bg-size-contain" style="background-image: url('<?php echo base_url(); ?>images/test/small-0.jpg'); background-position: 50% 50%; background-repeat: no-repeat; height: 100px;">background-size: contain; Scale the image to the largest size such that both its width and its height can fit inside the content area</div>
CODE;
output_code($code);
?>

<h1>Style Examples</h1>

<h2>Border Arrows</h2>

<?php
$code = <<< CODE
<span class="border-arrow border-arrow-down"></span>border-arrow-down
<br>
<span class="border-arrow border-arrow-left"></span>border-arrow-left
<br>
<span class="border-arrow border-arrow-right"></span>border-arrow-right
<br>
<span class="border-arrow border-arrow-up"></span>border-arrow-up
CODE;
output_code($code);
?>

<h2>Line Counter</h2>

<?php
$code = <<< CODE
<pre class="line-counter">
	<span>def print_hi(name)</span>
	<span>	puts "Hi, #{name}"</span>
	<span>end</span>
	<span></span>
	<span>print_hi('Tom')</span>
	<span>#=> prints 'Hi, Tom' to STDOUT.</span>
</pre>
CODE;
output_code($code);
?>

<h2>Cards</h2>

<?php
$code = <<< CODE
<div class="card">
	<h5>Hover over me&hellip;</h5>
	<img data-src="<?php echo base_url(); ?>javascript/holder.js/100x100/auto" alt="" title="" class="img img-scale img-row">
	<p>&hellip; and hidden content will appear</p>
	<div class="card-hover-content">
		<div class="card-table">
			<div class="card-cell-center">
				<div class="position-absolute pin-top text-left width-full">
					<h5>Content pinned to top</h5>
				</div>
				<p>This is hovered content. This is centered using display: table so that you can further position other elements in the card.</p>
				<ul class="position-absolute pin-bottom text-left width-full">
					<li><a href="">Content</a></li>
					<li><a href="">pinned to</a></li>
					<li><a href="">bottom</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="card">
	<h5>Hover over me&hellip;</h5>
	<img data-src="<?php echo base_url(); ?>javascript/holder.js/100x100/auto" alt="" title="" class="img img-scale img-row">
	<p>&hellip; and hidden content will appear</p>
	<div class="card-hover-content">
		<div class="position-center">
				<h5>Content</h5>
				<p>This is hovered content. This is centered using position: absolute so you cannot easily position other elments in the card.</p>
				<ul>
					<li><a href="">Content</a></li>
				</ul>
		</div>
	</div>
</div>
CODE;
output_code($code);
?>

<h2>Shadows</h2>

<?php
$code = <<< CODE
<div class="shadows shadows_lifted-no-curl">
	<p style="background: white;position: relative; z-index: 1;">3d shadow effects</p>
</div>

<div class="shadows shadows_lifted-no-curl" style="width: 200px;">
	<div style="background: white; width: 100%; height: 100%; position: relative; z-index: 1;">
		<p>The effects may need tweaked around content to get desired results</p>
	</div>
</div>
CODE;
output_code($code);
?>

<h2>Data Icons</h2>

<?php
$code = <<< CODE
<span data-icon="&#x2039;"></span>
<span data-icon="This is another example of text being used"></span>
CODE;
output_code($code);
?>

<h2>Font Awesome Icons</h2>

<?php
$code = <<< CODE
<!--
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
-->

<i class="fa fa-camera-retro"></i> fa-camera-retro
<i class="fa fa-camera-retro fa-lg"></i> fa-lg
<i class="fa fa-camera-retro fa-2x"></i> fa-2x
<i class="fa fa-camera-retro fa-3x"></i> fa-3x
<i class="fa fa-camera-retro fa-4x"></i> fa-4x
<i class="fa fa-camera-retro fa-5x"></i> fa-5x

<hr>

<i class="fa fa-refresh fa-spin"></i>
<i class="fa fa-cog fa-spin"></i>

<hr>

<i class="fa fa-shield"></i> normal<br>
<i class="fa fa-shield fa-rotate-90"></i> fa-rotate-90<br>
<i class="fa fa-shield fa-rotate-180"></i> fa-rotate-180<br>
<i class="fa fa-shield fa-rotate-270"></i> fa-rotate-270<br>
<i class="fa fa-shield fa-flip-horizontal"></i> fa-flip-horizontal<br>
<i class="fa fa-shield fa-flip-vertical"></i> icon-flip-vertical

<hr>

<div class="list-group">
	<a class="list-group-item" href="#"><i class="fa fa-home fa-fw"></i>&nbsp; Home</a>
	<a class="list-group-item" href="#"><i class="fa fa-book fa-fw"></i>&nbsp; Library</a>
	<a class="list-group-item" href="#"><i class="fa fa-pencil fa-fw"></i>&nbsp; Applications</a>
	<a class="list-group-item" href="#"><i class="fa fa-cog fa-fw"></i>&nbsp; Settings</a>
</div>

<hr>

<ul class="fa-ul list-vertical">
	<li><i class="fa-li fa fa-check-square"></i>List icons</li>
	<li><i class="fa-li fa fa-check-square"></i>can be used</li>
	<li><i class="fa-li fa fa-spinner fa-spin"></i>as bullets</li>
	<li><i class="fa-li fa fa-square"></i>in lists</li>
</ul>

<hr>

<span class="fa-stack fa-lg">
	<i class="fa fa-camera fa-stack-1x"></i>
	<i class="fa fa-ban fa-stack-2x text-danger"></i>
</span>
fa-ban on fa-camera

<hr>

<div class="input-group margin-b1">
	<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
	<input class="form-control" type="text" placeholder="Email address">
</div>

<hr>

<div class="input-group margin-b1">
	<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
	<input class="form-control" type="text" placeholder="Search">
</div>

<hr>

<p>
	<span aria-hidden="true" data-icon="&#x21dd;"></span>
	Stats
</p>

<hr>

<a href="#" class="display_inline-block">
	<span data-icon="&#x25a8;"></span>
	<span class="screen-reader-text">RSS</span>
</a>
CODE;
output_code($code);
?>

<h2>Navigation</h2>

<h3>Nav List</h3>

<?php
$code = <<< CODE
<nav class="nav-dropdown-setup nav-primary-list">
	
	<ul>
		
		<li class="active">
			<a href="">Home</a>
		</li>
		<li>
			<a href="">About Us</a>
		
			<ul>
				<li>
					<a href="">Subnav 1</a>
				</li>
				<li>
					<a href="">Subnav 2</a>
				</li>
				<li>
					<a href="">Subnav 3</a>
				</li>
			</ul>
			
		</li>
		<li>
			<a href="">Contact Us</a>
		</li>

	</ul>
	
</nav>
CODE;
output_code($code, false);
?>

<h3>Footer navigation list</h3>

<?php
$code = <<< CODE
<div style="display: inline-block; width: 100%;">
	<nav class="nav-footer-list">
		<ul>
			<li><a href="">Home</a></li>
			<li><a href="">About</a></li>
			<li><a href="">Sign Up</a></li>
			<li><a href="">Sign In</a></li>
		</ul>
	</nav>
</div>
CODE;
output_code($code, false);
?>

<h3>Breadcrumbs Nav</h3>

<?php
$code = <<< CODE
<nav class="nav-breadcrumbs">
	<ul>
		<li><a href="">Home</a></li>
		<li><a href="">About Us</a></li>
		<li><a href="" class="active">Me</a></li>
	</ul>
</nav>
CODE;
output_code($code, false);
?>

<h3>Social Nav</h3>

<?php
$code = <<< CODE
<nav class="nav-social">
	<ul>
		<li class="facebook"><a href="">Facebook</a></li>
		<li class="twitter"><a href="">Twitter</a></li>
		<li class="pinterest"><a href="">Pinterest</a></li>
		<li class="instagram"><a href="">Instagram</a></li>
	</ul>
</nav>
CODE;
output_code($code, false);
?>

<h3>Pagination and Paging</h3>

<?php
$code = <<< CODE
<div class="pagination_prev-next">
	<a href="#" class="pagination_prev-next_prev">‹ Prev</a>
	<a href="#" class="pagination_prev-next_next">Next ›</a>
</div>
<div class="pagination">
	<ul>
		<li><a href="#" class="first">First</a></li>
		<li><a href="#" class="prev">‹ Prev</a></li>
		<li class="active"><a href="#">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li>
		<li><a href="#" class="next">Next ›</a></li>
		<li><a href="#" class="last">Last</a></li>
	</ul>
</div>
CODE;
output_code($code, false);
?>

<h3>Meters</h3>

<?php
$code = <<< CODE
<div class="meter">
	<ul class="meter-indicators">
		<li class="w20"><a href="#"></a></li>
		<li class="w20"><a href="#"></a></li>
		<li class="w20"><a href="#"></a></li>
		<li class="w20"><a href="#"></a></li>
		<li class="w20"><a href="#"></a></li>
	</ul>
	<div class="meter-bar">
		75%
	</div>
</div>
CODE;
output_code($code);
?>

<h3>Dots</h3>

<?php
$code = <<< CODE
<div class="dot-box" data-coords="90,30">
	<a href="#" class="dot"><span></span></a>
	<div class="dot-line transform-origin-0 transform-rotate-45"></div>
</div>
CODE;
output_code($code);
?>

<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">

<h3>Advertising/Comparison/Pricing tables</h3>


<style>
#plans,#plans ul,#plans ul li {
	margin: 0;
	padding: 0;
	list-style: none;
}

#pricePlans:after {
	content: '';
	display: table;
	clear: both;
}

#pricePlans {
	zoom: 1;
}

#pricePlans {
	max-width: 69em;
	margin: 0 auto;
}

#pricePlans #plans .plan {
	background: #fff;
	float: left;
	width: 100%;
	text-align: center;
	border-radius: 5px;
	margin: 0 0 20px 0;

	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.1);
	box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.planContainer .title h2 {
	font-size: 2.125em;
	font-weight: 300;
	color: #3e4f6a;
	margin: 0;
	padding: .6em 0;
}

.planContainer .title h2.bestPlanTitle {
	background: #3e4f6a;

	background: -webkit-linear-gradient(top, #475975, #364761);
	background: -moz-linear-gradient(top, #475975, #364761);
	background: -o-linear-gradient(top, #475975, #364761);
	background: -ms-linear-gradient(top, #475975, #364761);
	background: linear-gradient(top, #475975, #364761);
	color: #fff;
	border-radius: 5px 5px 0 0;
}


.planContainer .price p {
	background: #3e4f6a;

	background: -webkit-linear-gradient(top, #475975, #364761);
	background: -moz-linear-gradient(top, #475975, #364761);
	background: -o-linear-gradient(top, #475975, #364761);
	background: -ms-linear-gradient(top, #475975, #364761);
	background: linear-gradient(top, #475975, #364761);
	color: #fff;
	font-size: 1.2em;
	font-weight: 700;
	height: 2.6em;
	line-height: 2.6em;
	margin: 0 0 1em;
}

.planContainer .price p.bestPlanPrice {
	background: #f7814d;
}

.planContainer .price p span {
	color: #8394ae;
}

.planContainer .options {
	margin-top: 10em;
}

.planContainer .options li {
	font-weight: 700;
	color: #364762;
	line-height: 2.5;
}

.planContainer .options li span {
	font-weight: 400;
	color: #979797;
}

.planContainer .button a {
	text-transform: uppercase;
	text-decoration: none;
	color: #3e4f6a;
	font-weight: 700;
	letter-spacing: 3px;
	line-height: 2.8em;
	border: 2px solid #3e4f6a;
	display: inline-block;
	width: 80%;
	height: 2.8em;
	border-radius: 4px;
	margin: 1.5em 0 1.8em;
}

.planContainer .button a.bestPlanButton {
	color: #fff;
	background: #f7814d;
	border: 2px solid #f7814d;
}

#credits {
	text-align: center;
	font-size: .8em;
	font-style: italic;
	color: #777;
}

#credits a {
	color: #333;
}

#credits a:hover {
	text-decoration: none;
}

@media screen and (min-width: 481px) and (max-width: 768px) {

#pricePlans #plans .plan {
	width: 49%;
	margin: 0 2% 20px 0;
}

#pricePlans #plans > li:nth-child(2n) {
	margin-right: 0;
}

}

@media screen and (min-width: 769px) and (max-width: 1024px) {

#pricePlans #plans .plan {
	width: 49%;
	margin: 0 2% 20px 0;
}

#pricePlans #plans > li:nth-child(2n) {
	margin-right: 0;
}

}

@media screen and (min-width: 1025px) {

#pricePlans {
	margin: 2em auto;
}

#pricePlans #plans .plan {
	width: 24%;
	margin: 0 1.33% 20px 0;

	-webkit-transition: all .25s;
	   -moz-transition: all .25s;
	    -ms-transition: all .25s;
	     -o-transition: all .25s;
	        transition: all .25s;
}

#pricePlans #plans > li:last-child {
	margin-right: 0;
}

#pricePlans #plans .plan:hover {
	-webkit-transform: scale(1.04);
	   -moz-transform: scale(1.04);
	    -ms-transform: scale(1.04);
	     -o-transform: scale(1.04);
	        transform: scale(1.04);
}

.planContainer .button a {
	-webkit-transition: all .25s;
	   -moz-transition: all .25s;
	    -ms-transition: all .25s;
	     -o-transition: all .25s;
	        transition: all .25s;
}

.planContainer .button a:hover {
	background: #3e4f6a;
	color: #fff;
}

.planContainer .button a.bestPlanButton:hover {
	background: #ff9c70;
	border: 2px solid #ff9c70;
}

}
</style>
	<section id="pricePlans">
		<ul id="plans">
			<li class="plan">
				<ul class="planContainer">
					<li class="title"><h2>Plan 1</h2></li>
					<li class="price"><p>$10/<span>month</span></p></li>
					<li>
						<ul class="options">
							<li>2x <span>option 1</span></li>
							<li>Free <span>option 2</span></li>
							<li>Unlimited <span>option 3</span></li>
							<li>Unlimited <span>option 4</span></li>
							<li>1x <span>option 5</span></li>
						</ul>
					</li>
					<li class="button"><a href="#">Purchase</a></li>
				</ul>
			</li>

			<li class="plan">
				<ul class="planContainer">
					<li class="title"><h2 class="bestPlanTitle">Plan 2</h2></li>
					<li class="price"><p class="bestPlanPrice">$20/month</p></li>
					<li>
						<ul class="options">
							<li>2x <span>option 1</span></li>
							<li>Free <span>option 2</span></li>
							<li>Unlimited <span>option 3</span></li>
							<li>Unlimited <span>option 4</span></li>
							<li>1x <span>option 5</span></li>
						</ul>
					</li>
					<li class="button"><a class="bestPlanButton" href="#">Purchase</a></li>
				</ul>
			</li>

			<li class="plan">
				<ul class="planContainer">
					<li class="title"><h2>Plan 3</h2></li>
					<li class="price"><p>$30/<span>month</span></p></li>
					<li>
						<ul class="options">
							<li>2x <span>option 1</span></li>
							<li>Free <span>option 2</span></li>
							<li>Unlimited <span>option 3</span></li>
							<li>Unlimited <span>option 4</span></li>
							<li>1x <span>option 5</span></li>
						</ul>
					</li>
					<li class="button"><a href="#">Purchase</a></li>
				</ul>
			</li>

			<li class="plan">
				<ul class="planContainer">
					<li class="title"><h2>Plan 4</h2></li>
					<li class="price"><p>$40/<span>month</span></p></li>
					<li>
						<ul class="options">
							<li>2x <span>option 1</span></li>
							<li>Free <span>option 2</span></li>
							<li>Unlimited <span>option 3</span></li>
							<li>Unlimited <span>option 4</span></li>
							<li>1x <span>option 5</span></li>
						</ul>
					</li>
					<li class="button"><a href="#">Purchase</a></li>
				</ul>
			</li>
		</ul> <!-- End ul#plans -->
		<div id="credits">by <a href="http://wegraphics.net/">WeGraphics - http://wegraphics.net/demo/responsive-price-plans/index.html</a></div>
	</section>

	
<style>
/* http://codepen.io/andytran/pen/LJFeg */
.pricing {
  background: #3498db;
  width: 280px;
  top: 50%;
  left: 50%;
  margin: -117px 0 0 -140px;
  padding: 40px 0 20px;
  color: #fff;
  -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
  box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
}
.pricing .thumbnail {
  background: #fff;
  /* IE Fall */
  background: rgba(255, 255, 255, 0.2);
  display: block;
  width: 90px;
  height: 90px;
  margin: 0 auto;
  -webkit-border-radius: 100%;
  -moz-border-radius: 100%;
  border-radius: 100%;
  font-size: 36px;
  line-height: 90px;
  text-align: center;
}
.pricing .title {
  cursor: pointer;
  background: #2980b9;
  margin: 40px 0 0;
  padding: 10px;
  font-size: 18px;
  text-align: center;
  text-transform: uppercase;
  font-weight: 700;
}
.pricing .content .sub-title {
  background: #eee;
  padding: 10px;
  color: #666;
  font-size: 14px;
  font-weight: 700;
  text-align: center;
}
.pricing .content ul {
  list-style: none;
  background: #fff;
  margin: 0;
  padding: 0;
  color: #666;
  font-size: 14px;
}
.pricing .content ul li {
  padding: 10px 20px;
}
.pricing .content ul li:nth-child(2n) {
  background: #f3f3f3;
}
.pricing .content ul li .fa {
  width: 16px;
  margin-right: 10px;
  text-align: center;
}
.pricing .content ul li .fa-check {
  color: #2ecc71;
}
.pricing .content ul li .fa-close {
  color: #e74c3c;
}
.pricing .content a {
  display: block;
  background: #2980b9;
  max-width: 80px;
  margin: 0 auto;
  margin-top: 20px;
  padding: 10px 15px;
  color: #fff;
  font-size: 18px;
  font-weight: 700;
  text-align: center;
  text-decoration: none;
  -webkit-transition: 0.2s linear;
  -moz-transition: 0.2s linear;
  -ms-transition: 0.2s linear;
  -o-transition: 0.2s linear;
  transition: 0.2s linear;
}
.pricing .content a:hover {
  background: #34495e;
  /* IE Fallback */
  background: rgba(52, 73, 94, 0.7);
}
.clickMe {
  background: #fff;
  /* IE Fallback */
  background: rgba(255, 255, 255, 0.8);
  position: absolute;
  top: 180px;
  left: -60px;
  padding: 5px 7px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  color: #3498db;
  font-size: 10px;
  text-transform: uppercase;
  font-weight: 800;
}
.clickMe:before {
  content: '';
  position: absolute;
  top: 6px;
  right: -5px;
  width: 0px;
  height: 0px;
  border-top: 5px solid transparent;
  border-bottom: 5px solid transparent;
  border-left: 5 solid #fff;
  /* IE Fallback */
  border-left: 5px solid rgba(255, 255, 255, 0.8);
}
</style>
	<div class='pricing animated swing'>
  <div class='thumbnail animated pulse infinite'>
    <div class='fa fa-paper-plane'></div>
  </div>
  <div class='title'>
    Paper Package
  </div>
  <div class='content'>
    <div class='sub-title'>
      $69
      <i>per year</i>
    </div>
    <ul>
      <li>
        <div class='fa fa-check'></div>
        Complete Access To All Themes
      </li>
      <li>
        <div class='fa fa-check'></div>
        Perpetual Theme Updates
      </li>
      <li>
        <div class='fa fa-check'></div>
        Premium Technical Support
      </li>
      <li>
        <div class='fa fa-close'></div>
        Complete Access To All Plugins
      </li>
      <li>
        <div class='fa fa-close'></div>
        Layered Photoshop Files
      </li>
      <li>
        <div class='fa fa-close'></div>
        No Yearly Fees
      </li>
    </ul>
    <a href='https://www.elegantthemes.com/cgi-bin/members/register.cgi?sub=16'>
      Sign Up
    </a>
  </div>
  <div class='clickMe'>
    Click
  </div>
</div>
<hr class="default w60 center">

<h3>Events</h3>

<div class="columns">
	
	<div class="column-row">
		
		<div class="column w2-3">
		
			<style>
				/* http://checkdemoz.in/trustsite/#!blog.html@load-blog-area */
				.list-blog-wrap ul,
				.list-blog-wrap li {
					list-style: none;
					margin: 0;
					padding: 0;
				}
				
				.list-blog-wrap .list-inline,
				.list-blog-wrap .list-inline li {
					vertical-align: top;
				}
				
				.badge-circle {
					background: #ccc;
					border-radius: 50%;
					display: inline-block;
					line-height: 1;
					padding: 0.5em;
					vertical-align: middle;
				}
				
				.time-heading,
				.time-heading span {
					display: inline-block;
					margin: 0;
					vertical-align: middle;
				}
				
				.dl-inline dt,
				.dl-inline dd,
				.dl-inline label {
					display: inline-block;
				}
				
				.widget ul,
				.widget li {
					margin: 0;
					padding: 0;
				}
				.widget li {
					list-style: none;
					-webkit-transition: all 0.4s ease-out 0s;
					-moz-transition: all 0.4s ease-out 0s;
					-ms-transition: all 0.4s ease-out 0s;
					-o-transition: all 0.4s ease-out 0s;
					transition: all 0.4s ease-out 0s;
				}
				.widget li:hover {
					padding-left: 0.5em;
				}
				.widget li:before {
					content: "\f054";
					display: inline-block;
					font-family: FontAwesome;
					font-size: 0.6em;
					vertical-align: middle;
				}
			</style>
			
			<!-- .list-blog-wrap -->
			<div class="list-blog-wrap">
				<ul class="list-blog">
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130107">
										<span class="h2">01</span><span>Sept 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Suas commune omittant his</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>01:30 PM</dd>
										<dt>Place:</dt>
										<dd><a href="#">Salt Lake City, Utah - Central Temple</a></dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>8</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130120">
										<span class="h2">11</span><span>Sept 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Nam debet eirmod atomorum</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>02:20 AM</dd>
										<dt>Place:</dt>
										<dd>
											<a href="#">New Orleans, LA - O</a>
										</dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>10</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130128">
										<span class="h2">11</span><span>Sept 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Modo possit ius eu</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>11:20 PM</dd>
										<dd class="address">
											<label>Place:</label> <a href="#">Pittsburgh, PA</a>
										</dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>6</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130129">
										<span class="h2">21</span><span>Sept 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Vis no fugit nostrum iracun</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>11:20 AM</dd>
										<dd class="address">
											<label>Place:</label> <a href="#">Bel Air, MD - Old Tree</a>
										</dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>10</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130704">
										<span class="h2">25</span><span>Sept 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Errem mandamus eu sea</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>02:45 PM</dd>
										<dd class="address">
											<label>Place:</label> <a href="#">Atlanta, GA - The City</a>
										</dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>10</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130708">
										<span class="h2">16</span><span>July 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Per latine ponderum senserit</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>11:20 AM</dd>
										<dd class="address">
											<label>Place:</label> <a href="#">Atlanta, GA - The City</a>
										</dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>2</a>
								</li>
							</ul>
						</div>
					</li>
					<li>
						<div class="caption item-inner">
							<ul class="list-horizontal ">
								<li>
									<div class="badge-circle">
										<i class="fa fa-calendar"></i>
									</div>
									<time class="time-heading" datetime="20130813">
										<span class="h2">13</span><span>Aug 13</span>
									</time>
								</li>
								<li>
									<a class="h4" href="#!event-1.html@load-event-area">Suas commune omittantur his</a>
									<dl class="dl-inline">
										<dt>Time:</dt>
										<dd>11:20 AM</dd>
										<dd class="address">
											<label>Place:</label> <a href="#">Washington, DC, - St John's Cathedral</a>
										</dd>
									</dl>
								</li>
								<li>
									<a class="comments-count" href="#"><i class="fa fa-comment"></i>3</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
				<div class="show-more">
					<div class="show-more-inner text-center">
						<a class="btn-showmore btn btn-primary btn-sm disabled" href="#">
							No More Events
						</a>
					</div>
				</div>
			</div>
			<!-- /.list-blog-wrap -->
			
		</div>
		<!-- /column -->
		
		<div class="column w1-3">
			
			<!-- .sidebar -->
				<!-- .search-sidebar -->
				<div class="widget search-widget">
					<form action="index.html" class="searchform" method="get">
						<div class="input-group">
							<input type="text" placeholder="Search..." class="form-control" name="s" value="">
							<button type="submit" class="btn btn-primary input-addon">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
				</div>
				<!-- /.search-sidebar -->
				
				<!-- .widget -->
				<div class="widget">
					<span class="widget-title">Archives</span>
					<ul class="list-default">
						<li>
							<a href="#">December 2012</a>
						</li>
						<li>
							<a href="#">November 2012</a>
						</li>
						<li>
							<a href="#">October 2012</a>
						</li>
						<li>
							<a href="#">September 2012</a>
						</li>
					</ul>
					<hr>
				</div>
				<!-- /.widget -->
		
				<!-- .widget -->
				<div class="widget">
					<span class="widget-title">Calendar</span>
					<div class="calendar_wrap" id="calendar_wrap">
						<div class="control-nav control-slider pull-right">
							<a data-control="#calendar-slides" class="btn-prev"></a>
							<a data-control="#calendar-slides" class="btn-next"></a>
						</div>
						<!-- #calendar-slides -->
						<div class="flex-simple" id="calendar-slides">
							
						<div class="flex-viewport" style="overflow: hidden; position: relative; height: 347px;"><ul class="slides" style="width: 800%; transition-duration: 0s; transform: translate3d(-300px, 0px, 0px);"><li class="clone" aria-hidden="true" style="width: 300px; float: left; display: block;">
									<div class="calendar-content">
										<time class="calendar-month text-time" datetime="201307"><span class="h2">July</span><span>2013</span></time>
									
										<table>
											<thead>
												<tr>
													<th title="Monday" scope="col">Mon</th>
													<th title="Tuesday" scope="col">Tue</th>
													<th title="Wednesday" scope="col">Wed</th>
													<th title="Thursday" scope="col">Thu</th>
													<th title="Friday" scope="col">Fri</th>
													<th title="Saturday" scope="col">Sat</th>
													<th title="Sunday" scope="col">Sun</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>01</td><td>02</td><td>03</td><td>04</td><td>05</td><td>06</td><td>07</td>
												</tr>
												<tr>
													<td>08</td><td>09</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td>
												</tr>
												<tr>
													<td>15</td><td><a title="Lorem Ipsum is simply dummy text" href="#"><span class="event-date">16</span></a></td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td>
												</tr>
												<tr>
													<td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td>
												</tr>
												<tr>
													<td>29</td><td>30</td><td>31</td>
													<td colspan="4" class="pad">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</div>
								</li>
								<li class="flex-active-slide" style="width: 300px; float: left; display: block;">
									<div class="calendar-content">
										<time class="calendar-month text-time" datetime="201309"><span class="h2">Sept</span><span>2013</span></time>
										<table>
											<thead>
												<tr>
													<th title="Monday" scope="col">Mon</th>
													<th title="Tuesday" scope="col">Tue</th>
													<th title="Wednesday" scope="col">Wed</th>
													<th title="Thursday" scope="col">Thu</th>
													<th title="Friday" scope="col">Fri</th>
													<th title="Saturday" scope="col">Sat</th>
													<th title="Sunday" scope="col">Sun</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="pad" colspan="6"></td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">01</span></a></td>
												</tr>
												<tr>
													<td>02</td><td>03</td><td>04</td><td>05</td><td>06</td><td>07</td><td>08</td>
												</tr>
												<tr>
													<td>09</td><td>10</td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">11</span></a></td><td>12</td><td>13</td><td>14</td><td>15</td>
												</tr>
												<tr>
													<td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">21</span></a></td><td>22</td>
												</tr>
												<tr>
													<td>23</td><td>24</td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">25</span></a></td><td>26</td><td>27</td><td>28</td><td>29</td>
												</tr>
												<tr>
													<td>30</td>
													<td colspan="6" class="pad">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</div>
								</li>
								<li style="width: 300px; float: left; display: block;">
									<div class="calendar-content">
										<time class="calendar-month text-time" datetime="201307"><span class="h2">July</span><span>2013</span></time>
									
										<table>
											<thead>
												<tr>
													<th title="Monday" scope="col">Mon</th>
													<th title="Tuesday" scope="col">Tue</th>
													<th title="Wednesday" scope="col">Wed</th>
													<th title="Thursday" scope="col">Thu</th>
													<th title="Friday" scope="col">Fri</th>
													<th title="Saturday" scope="col">Sat</th>
													<th title="Sunday" scope="col">Sun</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>01</td><td>02</td><td>03</td><td>04</td><td>05</td><td>06</td><td>07</td>
												</tr>
												<tr>
													<td>08</td><td>09</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td>
												</tr>
												<tr>
													<td>15</td><td><a title="Lorem Ipsum is simply dummy text" href="#"><span class="event-date">16</span></a></td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td>
												</tr>
												<tr>
													<td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td>
												</tr>
												<tr>
													<td>29</td><td>30</td><td>31</td>
													<td colspan="4" class="pad">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</div>
								</li>
							<li class="clone" aria-hidden="true" style="width: 300px; float: left; display: block;">
									<div class="calendar-content">
										<time class="calendar-month text-time" datetime="201309"><span class="h2">Sept</span><span>2013</span></time>
										<table>
											<thead>
												<tr>
													<th title="Monday" scope="col">Mon</th>
													<th title="Tuesday" scope="col">Tue</th>
													<th title="Wednesday" scope="col">Wed</th>
													<th title="Thursday" scope="col">Thu</th>
													<th title="Friday" scope="col">Fri</th>
													<th title="Saturday" scope="col">Sat</th>
													<th title="Sunday" scope="col">Sun</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class="pad" colspan="6"></td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">01</span></a></td>
												</tr>
												<tr>
													<td>02</td><td>03</td><td>04</td><td>05</td><td>06</td><td>07</td><td>08</td>
												</tr>
												<tr>
													<td>09</td><td>10</td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">11</span></a></td><td>12</td><td>13</td><td>14</td><td>15</td>
												</tr>
												<tr>
													<td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">21</span></a></td><td>22</td>
												</tr>
												<tr>
													<td>23</td><td>24</td><td><a data-container="body" data-toggle="tooltip" title="" href="#" data-original-title="Lorem ipsum dolor sit."><span class="event-date">25</span></a></td><td>26</td><td>27</td><td>28</td><td>29</td>
												</tr>
												<tr>
													<td>30</td>
													<td colspan="6" class="pad">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</div>
								</li></ul></div></div>
						<!-- /#calendar-slides -->
					</div>
				</div>
				<!-- /.widget -->
			<!-- /.sidebar -->
			
		</div>
		<!-- /column -->
		
	</div>
	<!-- /column-row -->
	
</div>
<!-- /columns -->

<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">








<h2>Plugins</h2>

<h3>Toggle Value</h3>

<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_toggle_value.js'); ?>"></script>
<script type="text/javascript">//<!--
jQuery(document).ready(function($){

	$('.toggle-value').redlove_toggle_value();
	$('#zip_2').redlove_toggle_value({
		default_value : 'Default Value',
		sticky : true,
		blur_class : 'blur',
		focus_class : 'focus'
	});
	
});
//--></script>
<style type="text/css">

/* ------------------------------------------------------------
	Form validation
------------------------------------------------------------ */

/* 
	Form validation - <label>
---------------------------------------- */
label.error,
label.success {
	color: #E25F53;
}

label.success {
	background-color: transparent;
	color: #0060BF;
}

/* 
	Form validation - <label> <input> <textarea> <select>
---------------------------------------- */
input.error,
textarea.error,
select.error,
input.error:focus,
textarea.error:focus,
select.error:focus {
	border: 1px solid #E25F53;
}

/* 
	Form validation - jQuery validate plugin
---------------------------------------- */
.invalid label {
	color: #B94A48;
}
.invalid input,
.invalid textarea,
.invalid select {
	border-color: #B94A48;
}

</style>
<?php
$code = <<< CODE
<input type="text" class="toggle-value" name="zip_1" value="" title="Zip Code">
<input type="text" id="zip_2" name="zip_2" value="">
<input type="text" class="toggle-value" name="input_search" value="" data-toggle-default="Search">
CODE;
output_code($code, false);
?>

<h3>Validation</h3>

<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_validate.js'); ?>"></script>
<script type="text/javascript">//<!--
jQuery(document).ready(function($){

	$('#validate_form_1').redlove_validate({
		default_value : 'Default Value',
		sticky : true,
		blur_class : 'blur',
		focus_class : 'focus'
	});
	
});
//--></script>
<style type="text/css">
.blur {
	color: #999999;
	font-style: italic;
}
</style>

<form class="">

</form>

<h3>Modal</h3>

<?php
$code = <<< CODE
<div id="modal-1" class="redlove_modal-container">
	<h1>Test content</h1>
	<p>This is some test content!</p>
	<a href="#" class="redlove_modal_action-close">Ok (close modal)</a>
</div>
<a href="#modal-1" class="redlove_modal-link">Modal 1</a>
<a href="#modal-2-and-3" onclick="$.fn.redlove_modal.show('test');$.fn.redlove_modal.show('<h2>Testing more</h2><p>A paragaph.</p><ul><li>list item</li></ul>');return false;">Modals 2 &amp; 3</a>
CODE;
output_code($code, false);
?>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_modal.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_modal.js'); ?>"></script>
<script type="text/javascript">

jQuery(document).ready(function($)
{
	$('.redlove_modal-link').redlove_modal({interval : 500});
});

</script>

<h3>Equal</h3>

<?php
$code = <<< CODE
<div class="redlove_demo_equal-column" style="background: red; display: inline-block; height: 50px; width: 50px;"></div>
<div class="redlove_demo_equal-column" style="background: green; display: inline-block; height: 100px; width: 100px;"></div>
<div class="redlove_demo_equal-column" style="background: blue; display: inline-block; height: 75px; width: 75px;"></div>
<br>
<a href="#" onclick="$('.redlove_demo_equal-column').redlove_equal();return false;">Equal heights</a>
<a href="#" onclick="$('.redlove_demo_equal-column').redlove_equal({dimension : 'width'});return false;">Equal widths</a>

CODE;
output_code($code, false);
?>
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_equal.js'); ?>"></script>

<h3>RedLove Preload Images</h3>

<div class="redlove_demo_preload_images-1">
	<img src="<?php echo base_url(); ?>images/test/medium-0.jpg" style="width: 50px; height: auto;">
</div>
<div class="redlove_demo_preload_images-2">
	<img src="<?php echo base_url(); ?>images/test/large-0.jpg" style="width: 50px; height: auto;">
	<img src="<?php echo base_url(); ?>images/test/large-1.jpg" style="width: 50px; height: auto;">
	<img src="<?php echo base_url(); ?>images/test/large-2.jpg" style="width: 50px; height: auto;">
</div>
<div class="redlove_demo_preload_images-3">
	<img src="<?php echo base_url(); ?>images/test/medium-0.jpg" style="width: 50px; height: auto;">
</div>

<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_preload_images.js'); ?>"></script>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	$('.redlove_demo_preload_images-1 img').redlove_preload_images({
		oncomplete : function( num_preloaded_images )
		{
			console.log('redlove_preload_images 1: ' + num_preloaded_images);
		}
	});
	
	$('.redlove_demo_preload_images-2 img').redlove_preload_images({
		oncomplete : function( num_preloaded_images )
		{
			console.log('redlove_preload_images 2: ' + num_preloaded_images);
		}
	});
	
	$('.redlove_demo_preload_images-3 img').redlove_preload_images({
		oncomplete : function( num_preloaded_images )
		{
			console.log('redlove_preload_images 3: ' + num_preloaded_images);
		}
	});
});
</script>

<h3>Growl messages</h3>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_growl.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_growl.js'); ?>"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		window['growl'] = new redlove_growl();
	});
</script>
<a href="#" onclick="window.growl.create('Growl message created.', 'success');return false;">Show growl message.</a>

<h3>Return to Top</h3>
<p>Check the bottom right of the viewport when scrolling down.</p>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_return_to_top.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_return_to_top.js'); ?>"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$.fn.redlove_return_to_top();
	});
</script>

<h3>Throttle</h3>
<p>Check the bottom right of the viewport when scrolling down and check the console.log for messages.</p>
<div id="return-to-top">
	<a href="#">^ Throttle example</a>
</div>

<style type="text/css">
	#return-to-top.fixed {
		bottom: 0;
		left: auto;
		position: fixed;
		right: 0;
		top: auto;
	}
</style>
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_throttle.js'); ?>"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		var $element = $('#return-to-top');
		$element.on('click', function(event)
		{
			event.preventDefault();
			$('html,body').animate({'scrollTop' : 0}, 'slow', function(){});
		});
		
		var $window = $(window);
		var scroll_target_top = $window.height() / 2;//$element.offset().top;
		var throttle_options = {
			interval : 250,
			run_at_start : true,
			run_at_end : true,
			callback : function ( self, args )
			{
				if ( $window.scrollTop() > scroll_target_top )
				{
					$element.addClass('fixed');
				}
				else
				{
					$element.removeClass('fixed');
				}
			}
		};
		var my_throttle = new redlove_throttle(throttle_options);
		my_throttle.handler();
		$(window).scroll(my_throttle.handler);
		
		// --------------------------------------------------------------------
		
		// Create a debounce example
		$(window).scroll(new redlove_throttle({
			interval : 500,
			debounce : true,
			callback : function ( self, args )
			{
				if ( $window.scrollTop() > 200 )
				{
					console.log('Throttle debounce example, shows after activity has stopped for interval');
				}
			}
		}).handler);
		
	});
</script>

<h3>Form Replacement</h3>

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

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_form_replacement.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_form_replacement.js'); ?>"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$('.form-replacement').redlove_form_replacement();
	});
</script>

<h3>Data Tabs</h3>

<div>
	<ul class="data-tab-collection">
		<li class="active" data-tab="data-tabs1-1">Tab One</li>
		<li data-tab="data-tabs1-2">Tab Two</li>
		<li data-tab="data-tabs1-3">Tab Three</li>
	</ul>
	<ul class="data-tab-content-collection">
		<li id="data-tabs1-1">Tab One content</li>
		<li id="data-tabs1-2">Tab Two content</li>
		<li id="data-tabs1-3">Tab Three content</li>
	</ul>
</div>

<hr>

<a href="#" data-tab="data-tabs2-1">Tab One</a>
<span data-tab="data-tabs2-2">Tab Two</span>
<div>
	<a href="#data-tabs2-1" data-tab>Tab One</a>
	<a href="#data-tabs2-2" data-tab>Tab Two</a>
	<a href="#data-tabs2-3" data-tab>Tab Three</a>
	<div class="data-tab-content-collection">
		<div id="data-tabs2-1">Tab One content</div>
		<div id="data-tabs2-2">Tab Two content</div>
		<div id="data-tabs2-3">Tab Three content</div>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_data_tabs.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_data_tabs.js'); ?>"></script>
<style type="text/css">
	.data-tab-collection {
		display: inline-block;
	}
	.data-tab-collection ul,
	.data-tab-collection li,
	.data-tab-content-collection ul,
	.data-tab-content-collection li {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.data-tab-collection > * {
		float: left;
		padding: 0.5em;
		-webkit-transition: all 0.4s ease-out 0s;
		-moz-transition: all 0.4s ease-out 0s;
		-ms-transition: all 0.4s ease-out 0s;
		-o-transition: all 0.4s ease-out 0s;
		transition: all 0.4s ease-out 0s;
	}
	[data-tab].active {
		color: red;
		font-weight: bold;
	}
</style>

<h3>Tabs</h3>

<div class="tabs1">
	<ul class="tab-collection">
		<li class="active">Tab One</li>
		<li>Tab Two</li>
		<li>Tab Three</li>
	</ul>
	<ul class="tab-content-collection">
		<li>Tab One content</li>
		<li>Tab Two content</li>
		<li>Tab Three content</li>
	</ul>
</div>

<hr>

<div class="tabs2">
	<ul class="tab-collection">
		<li class="active">Tab One</li>
		<li>Tab Two</li>
		<li>Tab Three</li>
	</ul>
	<ul class="tab-content-collection">
		<li>Tab One content</li>
		<li>Tab Two content</li>
		<li>Tab Three content</li>
	</ul>
</div>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_tabs.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_tabs.js'); ?>"></script>
<style type="text/css">
	.tab-collection {
		display: inline-block;
	}
	.tab-collection ul,
	.tab-collection li,
	.tab-content-collection ul,
	.tab-content-collection li {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.tab-collection > * {
		float: left;
		padding: 0.5em;
		-webkit-transition: all 0.4s ease-out 0s;
		-moz-transition: all 0.4s ease-out 0s;
		-ms-transition: all 0.4s ease-out 0s;
		-o-transition: all 0.4s ease-out 0s;
		transition: all 0.4s ease-out 0s;
	}
	.tab-collection > *.active {
		color: red;
		font-weight: bold;
	}
</style>
<script type="text/javascript">
	$(document).ready(function()
	{
		$('.tabs1, .tabs2').redlove_tabs();
	});
</script>


<h3>FAQ/Info Toggle</h3>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_expand_group.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_expand_group.js'); ?>"></script>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	$('.redlove_expand-group').redlove_expand_group();
});
</script>

<div class="redlove_expand-group">
	<a href="">Section One</a>
	<div>Section one content here.</div>
	<a href="">Section Two</a>
	<div>Section three content here.</div>
	<a href="">Section Three</a>
	<div>Section three content here.</div>
</div>

<div class="redlove_expand-group">
	<a href="">Expander 1</a>
	<div>
		<p>
			Nihil essent est ne, suas labores vel ut. Pri molestae, vis sint antiopam inciderint ide. Mals copiosae, consti tuam accomod ar. Omnes inimicus. Discere evertitur inciderin torquatos pro an aciti.
		</p>
		<ul>
			<li>
				Lorem ipsum et, duo lorem cuo aeter ut, veri
			</li>
			<li>
				Prodesset ein audiam et eam vi intellege otace
			</li>
			<li>
				Decore iuvaret ut proper trio dedicat, etusto
			</li>
		</ul>
	</div>
	<a href="">Expander 2</a>
	<div>
		<p>
			Nihil essent est ne, suas labores vel ut. Pri molestae, vis sint antiopam inciderint ide. Mals copiosae, consti tuam accomod ar. Omnes inimicus. Discere evertitur inciderin torquatos pro an aciti.
		</p>
		<ul>
			<li>
				Lorem ipsum et, duo lorem cuo aeter ut, veri
			</li>
			<li>
				Prodesset ein audiam et eam vi intellege otace
			</li>
			<li>
				Decore iuvaret ut proper trio dedicat, etusto
			</li>
		</ul>
	</div>
</div>

<ul class="redlove_expand-group list-fqa">
	<li>
		<a href="#" class="redlove_expander">Cum ea albucius insolens definitionem?</a>
		<div class="redlove_expandee">
			<p>
				Nihil essent est ne, suas labores vel ut. Pri molestae, vis sint antiopam inciderint ide. Mals copiosae, consti tuam accomod ar. Omnes inimicus. Discere evertitur inciderin torquatos pro an aciti.
			</p>
			<ul>
				<li>
					Lorem ipsum et, duo lorem cuo aeter ut, veri
				</li>
				<li>
					Prodesset ein audiam et eam vi intellege otace
				</li>
				<li>
					Decore iuvaret ut proper trio dedicat, etusto
				</li>
			</ul>
		</div>
	</li>
	<li>
		<a href="#" class="redlove_expander">Mucius aeterno utroque pro ne?</a>
		<div class="redlove_expandee">
			<p>Magna solum principes nam id. Est ea eirmod melioret scriptorem. Ut fastidi eligendi molestie cibo epicure ea cum, ad est adhuc semper pertinacia. Mel viris platone medioc ritate mea etiam.</p>
		</div>
	</li>
	<li>
		<a href="#" class="redlove_expander">Fugit adversarium pri ea, ut sit nisl?</a>
		<div class="redlove_expandee">
			<p>
				Pri eu graece omnesque, nam id quis probo viderer. Atu doctus adolescens vix, est eu alii dolor assueverit. Sed ei quas commune, adhuc dicat scripserit ne sea. Eos antie rebum vocent docendi.
			</p>
			<ul>
				<li>
					Nam ex illum dicta, duo liber deleniti defin
				</li>
				<li>
					Duo nullam nonumes an, consul ancillae euri
				</li>
			</ul>
			<br>
			<p>
				<em>Suavitate elaboraret id qui, vix regione diceret in,</em> enne mucius petentium vel. Error dolorem ex sea. Et tibique quaerendum reformidans his, nam ancillae mediocrem instructior eat levonta dec.
			</p>
			<p>
				<em>Quis solet molestie qui ea, his an hinc apeirian praesent. Verear forensibus at vim.</em>
			</p>
		</div>
	</li>
</ul>

<ul class="redlove_expand-group toggle">
	<li>
		<a href="#" class="redlove_expander"><i class="open-close"></i>1. Per summo sonet cu, epicuri neserchu</a>
		<div class="redlove_expandee">
			<p>
				<strong>Alia dissentias sea in</strong>, dico veri numquam est ei, duo ne quot nulla legendos. Noqui liber repudi interpretar, no graeco noluisse philosophia sit.
			</p>
			<p>
				Mel delectus pertinacia referrentur cu, id odio maloru voluptaria usu, mea ad iusto iisque.
			</p>
			<a class="btn-link text-uppercase" href="#">I'm interested »</a>
		</div>
	</li>
	<li>
		<a href="#" class="redlove_expander"><i class="open-close"></i>2. Tantas nonumy ut has posse vantur</a>
		<div class="redlove_expandee">
			<p>Mals copiosae, consti tuam accomod ar. Ones inimicus. Discere evertitur inciderint an aciti.</p>
		</div>
	</li>
	<li>
		<a href="#" class="redlove_expander"><i class="open-close"></i>3. Mei verterem volutpat consequat te</a>
		<div class="redlove_expandee">
			<p>Nihil essent est ne, suas labores vel ut. Pri molestae, vis sint antiopam inciderint ide.</p>
		</div>
	</li>
	<li>
		<a href="#" class="redlove_expander"><i class="open-close"></i>4. Sed debitis vituper atrori busid, ea est</a>
		<div class="redlove_expandee">
			<p>Tale agam epicurei mei, est ullum iudicabit consequun te, pro sumo doctus ex. Te eam alienum ancill petentiu brute putent commune ius id, sed dolor habemus veru senserit in renoe.</p>
		</div>
	</li>
</ul>

<style type="text/css" media="all">
.info-widget {
	border: 1px #dddddd solid;
	
	-khtml-border-radius: 3px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	
	-moz-box-shadow: 0px 0px 3px 0px rgb(200, 200, 200);
	-webkit-box-shadow: 0px 0px 3px 0px rgb(200, 200, 200);
	box-shadow: 0px 0px 3px 0px rgb(200, 200, 200);
	
	background: #f1f1f1;
	margin-top: 25px;
	padding: 12px;
}
.info-widget_wrap-inside {
	border: 1px #dddddd solid;
	
	-moz-box-shadow: 0px 0px 3px 0px rgb(200, 200, 200);
	-webkit-box-shadow: 0px 0px 3px 0px rgb(200, 200, 200);
	box-shadow: 0px 0px 3px 0px rgb(200, 200, 200);
	
	background: #FFFFFF;
	padding: 12px 26px; 
}

/* Heading bar */
.info-widget .heading-bar h3 {
	display: inline-block;
	border-right: 1px solid #dddddd;
	margin: 0;
	margin-right: 30px;
	padding: 0;
	width: 215px;
	height: 62px;
	vertical-align: middle;
	
	line-height: 62px;
}
.info-widget .heading-bar .bar-icon {
	display: inline-block;
	margin-right: 18px;
	vertical-align: middle;
}
.info-widget .redlove_expander {
	cursor: pointer;
}
.info-widget .redlove_expander-link {
	cursor: pointer;
	color: inherit;
	display: block;
	text-decoration: none;
}
.info-widget .redlove_expander-link h3 {
	color: inherit;
}
.info-widget .disabled {
	pointer-events: none;
}
.info-widget .redlove_expander-icon {
	background: transparent url('ecommerce__icon_redlove_expander-sprite.png') scroll no-repeat 0 0;
	display: block;
	float: right;
	margin-top: 16px;
	width: 28px;
	height: 28px;
	/* hide text */
	color: transparent;
	font: 0/0 a;
	text-shadow: none;
}
.info-widget .active .redlove_expander-icon {
	background-position: 0 -28px;
}
.info-widget .redlove_expander-icon.download {
	background-position: 0 -56px;
}

/* Content bar */
.info-widget .content-bar {
	border-top: 1px solid #DDDDDD;
	margin-top: 18px;
	padding-top: 18px;
}
.info-widget .denotes-box {
	border-top: 1px solid #DDDDDD;
	margin-top: 10px;
	padding-top: 16px;
	padding-bottom: 6px;
}

/* E-Tailer list */
.etailer-list {
	list-style: none;
	margin: 0;
	padding: 0;
	
	display: inline-block;
	*display: inline; zoom: 1;/*ie6/7*/
	vertical-align: bottom;
	width: 100%;
}
.etailer-list li {
	float: left;
	margin: 0;
	padding: 0;
	background: transparent url('ecommerce__bullet_arrow.png') scroll no-repeat 0px 4px;
	margin-bottom: 10px;
	padding-left: 20px;
	width: 30%;
}

.info-widget .preferred {
	background: transparent url('ecommerce__icon_check.png') scroll no-repeat 0 0;
	display: inline-block;
	margin: 0 6px;
	width: 12px;
	height: 12px;
	vertical-align: middle;
	/* hide text */
	color: transparent;
	font: 0/0 a;
	text-shadow: none;
}

/* Slider lists */
.slider-list > li {
	background: transparent url('ecommerce__bullet_arrow.png') scroll no-repeat 0px 4px;
	margin-bottom: 10px;
	padding-left: 20px;
}
.slider-list h4 {
	color: #00A9E0;
	font-size: 12px;
	font-weight: normal;
}
/* Slider content */
.slider-list div {
	margin-left: 16px;
	margin-bottom: 15px;
}
.slider-list div ul.circle {
	display: block;
	list-style: disc;
	list-style-position: outside;
	margin: 0 0 4px 0;
	overflow: hidden;
}
.slider-list div ul.circle li {
	list-style: circle outside;
	margin-left: 20px;
	margin-bottom: 6px;
}

</style>

<div class="redlove_expand-group info-widget">

	<div class="info-widget_wrap-inside">
	
		<div class="redlove_expander heading-bar">
			<h3>Authorized</h3>
			<img src="ecommerce__icon_etailer.png" border="0" alt="Moen(R) Authorized E-Tailer" title="Moen(R) Authorized E-Tailer" class="bar-icon" />
			<span class="redlove_expander-icon">+</span>
		</div>
		<div class="redlove_expandee content-bar">
			
			<ul class="etailer-list">
				<li>E-Tailer One<span class="preferred">*</span></li>
				<li>E-Tailer Two</li>
				<li>E-Tailer Three</li>
				
				<li>E-Tailer Four<span class="preferred">*</span></li>
				<li>E-Tailer Five</li>
				<li>E-Tailer Six</li>
				
				<li>E-Tailer Seven<span class="preferred">*</span></li>
				<li>E-Tailer Eight</li>
			</ul>
			
			<div class="denotes-box">
				<span class="preferred">*</span> = Denotes Preferred Moen E-Tailers
			</div>
			
		</div>
		
	</div>
	
</div>


<h3>Carousel</h3>

<link rel="stylesheet" type="text/css" href="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_carousel.css'); ?>">
<script type="text/javascript" src="<?php echo cb_url(REDLOVE_ROOT . 'javascript/redlove/plugins/redlove_carousel.js'); ?>"></script>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$('#testimonials .redlove_carousel').redlove_carousel({debug : false});
		
		$('#panel-scroller .redlove_carousel').on('show_item', function ( event, obj )
		{
			console.log('hey! showing item!');
		});
		$('#panel-scroller .redlove_carousel').redlove_carousel({
			auto : true,
			per_view : 3,
			scroll_interval : 1000
		});
		
		$('.columns-slideshows .redlove_carousel:nth-child(1)').redlove_carousel();
		$('#quotes .redlove_carousel').redlove_carousel();
		$('#slideshow-carousel .redlove_carousel').redlove_carousel({debug : true});
	});
</script>
<style type="text/css" media="all">
#panel-scroller .redlove_carousel-item {
	width: 300px;
}
.columns-slideshows .redlove_carousel-item,
#slideshow-carousel .redlove_carousel-item {
	width: 100%;
}

/* Quotes */
#quotes {
	background-color: #00a0e9;
	margin-bottom: 2.0em;
	margin-top: 2.0em;
	text-align: center;
}

#quotes blockquote {
	display: table-cell;
	vertical-align: middle;
	width: 100%;
	
	color: #FFFFFF;
	line-height: 1.2;
	padding: 1em 3em 2.5em;
	quotes: "\201C""\201D""\2018""\2019";
}
	#quotes blockquote p {
		display: block;
		font-size: 2.0em;
		font-style: normal;
		margin: 0 0 0.4em;
		padding: 1.0em 2.0em 0;
		position: relative;
	}
		#quotes blockquote p:before,
		#quotes blockquote p:after {
			content: open-quote;
			font-family: 'Bookman Old Style', 'Georgia', 'Times', 'Times New Roman', serif;
			font-size: 2.5em;
			font-weight: bold;
			left: 0;
			line-height: 1;
			position: absolute;
			top: 0;
		}
		#quotes blockquote p:after {
			bottom: 0;
			content: close-quote;
			left: auto;
			line-height: 0;
			top: auto;
			right: 0;
		}
	#quotes blockquote cite {
		display: block;
		font-size: 1.2em;
		font-style: italic;
		font-weight: bold;
		margin: 0 0 1.5em;
	}
	#quotes blockquote .newline {
		display: block;
		line-height: 1;
	}
	
#quotes .more {
	color: #FFFFFF;
	display: inline-block;
}
#quotes .more:hover {
	text-decoration: underline;
}
</style>

<div id="testimonials">

	<div class="redlove_carousel"><!-- redlove_carousel-cover -->
		
		<div class="redlove_carousel-content-wrapper">
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
					</blockquote>
				</div>
			</div>
			
		</div>
		
	</div>

</div>

<hr class="w80 center">

<div id="panel-scroller">

	<div class="redlove_carousel"><!-- redlove_carousel-cover -->
		
		<div class="redlove_carousel-content-wrapper">
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>1 Food Pantry</h5>
				<p>Here can be three lines of text with no need for a "Read More" link because what you say what you need.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>2 Fellowship</h5>
				<p>Then each following item should have equal or less line length to keep things consistent.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>3 Addiction Struggles?</h5>
				<p>If you need to link to something, you can <a href="">put the link</a> in the text.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>4 Food Pantry</h5>
				<p>Here can be three lines of text with no need for a "Read More" link because what you say what you need.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>5 Fellowship</h5>
				<p>Then each following item should have equal or less line length to keep things consistent.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>6 Food Pantry</h5>
				<p>Here can be three lines of text with no need for a "Read More" link because what you say what you need.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>7 Fellowship</h5>
				<p>Then each following item should have equal or less line length to keep things consistent.</p>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x120" alt="" title="">
				<h5>8 Addiction Struggles?</h5>
				<p>If you need to link to something, you can <a href="">put the link</a> in the text.</p>
			</div>
			
		</div>
		
	</div>
</div>

<hr class="w80 center">

<div class="columns columns-slideshows">
	
	<div class="column-row">
		<div class="column w1">
			
			<div class="redlove_carousel">
				<div class="redlove_carousel-content-wrapper">
					<div class="redlove_carousel-item">
						<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/auto" alt="" title="">
					</div>
					<div class="redlove_carousel-item">
						<a href=""><img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/auto" alt="" title=""></a>
					</div>
					<div class="redlove_carousel-item">
						<a href=""><img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/auto" alt="" title=""></a>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
	<div class="column-row">
		<div class="column w2-3">
			
			<div class="redlove_carousel">
				<div class="redlove_carousel-content-wrapper">
					<div class="redlove_carousel-item">
						<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/auto" alt="" title="">
					</div>
					<div class="redlove_carousel-item">
						<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/text:Slide 2" alt="" title="">
					</div>
					<div class="redlove_carousel-item">
						<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/text:Slide 3" alt="" title="">
					</div>
				</div>
			</div>
			
		</div>
		
		<div class="column w1-3">
			
			<div class="redlove_carousel">
				<div class="redlove_carousel-content-wrapper">
					<div class="redlove_carousel-item">
						<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/auto" alt="" title="">
					</div>
					<div class="redlove_carousel-item">
						<a href=""><img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/text:Slide 2" alt="" title=""></a>
					</div>
					<div class="redlove_carousel-item">
						<a href=""><img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x360/text:Slide 3" alt="" title=""></a>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	
</div>

<hr class="w80 center">

<div id="quotes">

	<div class="redlove_carousel"><!-- redlove_carousel-cover -->
		
		<div class="redlove_carousel-content-wrapper">
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
						<a href="" class="more">Read More Moen Quotes &raquo;</a>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
						<a href="" class="more">Read More Moen Quotes &raquo;</a>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>
						<cite>John Doe - Company Name</cite>
						<a href="" class="more">Read More Moen Quotes &raquo;</a>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
						<a href="" class="more">Read More Moen Quotes &raquo;</a>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
						<a href="" class="more">Read More Moen Quotes &raquo;</a>
					</blockquote>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<div class="redlove_carousel-item-liner">
					<blockquote>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<cite>John Doe - Company Name</cite>
						<a href="" class="more">Read More Moen Quotes &raquo;</a>
					</blockquote>
				</div>
			</div>
			
		</div>
		
	</div>

</div>

<hr class="w80 center">

<div id="slideshow-carousel">

	<div class="redlove_carousel"><!-- redlove_carousel-cover -->
		
		<div class="redlove_carousel-content-wrapper">
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x480" alt="" title="" class="img fluid">
				<div class="redlove_carousel-item-caption">
					<div class="caption">
						<h2>Slide Heading</h4>
						<p>Caption text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<a href="" class="button button-primary">More Information</a>
						<a href="" class="button button-warning">Buy Tickets</a>
					</div>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x480" alt="" title="" class="img fluid">
				<div class="redlove_carousel-item-caption">
					<div class="caption">
						<h2>Slide Heading</h4>
						<p>Caption text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<a href="" class="button button-primary">More Information</a>
						<a href="" class="button button-warning">Buy Tickets</a>
					</div>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x480" alt="" title="" class="img fluid">
				<div class="redlove_carousel-item-caption">
					<div class="caption">
						<h2>Slide Heading</h4>
						<p>Caption text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<a href="" class="button button-primary">More Information</a>
						<a href="" class="button button-warning">Buy Tickets</a>
					</div>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x480" alt="" title="" class="img fluid">
				<div class="redlove_carousel-item-caption">
					<div class="caption">
						<h2>Slide Heading</h4>
						<p>Caption text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<a href="" class="button button-primary">More Information</a>
						<a href="" class="button button-warning">Buy Tickets</a>
					</div>
				</div>
			</div>
			
			<div class="redlove_carousel-item">
				<img data-src="<?php echo base_url(); ?>javascript/holder.js/100%x480" alt="" title="" class="img fluid">
				<div class="redlove_carousel-item-caption">
					<div class="caption">
						<h2>Slide Heading</h4>
						<p>Caption text. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
						<a href="" class="button button-primary">More Information</a>
						<a href="" class="button button-warning">Buy Tickets</a>
					</div>
				</div>
			</div>
			
		</div>
		
	</div>

</div>


<h3>Mobile Menus</h3>

<script type="text/javascript">
var responsive_menu_active_class = 'mobile-menu-active';
var responsive_menu_namespace = 'mobile_menu';
var body_classes = responsive_menu_active_class + ' no-scroll no-select';
var click_events = 'click.' + responsive_menu_namespace + ' touchstart.' + responsive_menu_namespace;

// Responsive menu helper
jQuery(document).ready( function ( $ )
{
	$('.mobile-menu-checkbox')
	.each( function ( i, el )
	{
		var data_type = this.checked ? $(this).data('type') : '';
		
		if ( this.checked )
		{
			$('body').addClass(body_classes)
			.attr('data-type', data_type);
			
			if ( data_type == 'height-top' )
			{
				$('html, body').animate({scrollTop: $('.mobile-menu[data-type="height-top"]').offset().top}, 500, function(){});
			}
		}
	})
	.on(click_events, function ( event )
	{
		var data_type = this.checked ? $(this).data('type') : '';
		
		$('body').toggleClass(body_classes)
		.attr('data-type', data_type);
		
		if ( this.checked )
		{
			if ( data_type == 'height-top' )
			{
				$('html, body').animate({scrollTop: $('.mobile-menu[data-type="height-top"]').offset().top}, 500, function(){});
			}
		}
	});
});
</script>

<div class="flex-row">
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_fade" type="checkbox" class="mobile-menu-checkbox" data-type="fade">
		<label for="mobile-menu_cb_fade" class="mobile-menu-button">Menu Button - Fade</label>
		<nav class="mobile-menu" data-type="fade">
			<ul>
				<li><label for="mobile-menu_cb_fade" class="mobile-menu-button">Menu Button - Fade</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_height-top" type="checkbox" class="mobile-menu-checkbox" data-type="height-top">
		<label for="mobile-menu_cb_height-top" class="mobile-menu-button">Menu Button - Height Top</label>
		<nav class="mobile-menu" data-type="height-top">
			<ul>
				<li><label for="mobile-menu_cb_height-top" class="mobile-menu-button">Menu Button - Height Top</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_fixed-top" type="checkbox" class="mobile-menu-checkbox" data-type="fixed-top">
		<label for="mobile-menu_cb_fixed-top" class="mobile-menu-button">Menu Button - Fixed Top</label>
		<nav class="mobile-menu" data-type="fixed-top">
			<ul>
				<li><label for="mobile-menu_cb_fixed-top" class="mobile-menu-button">Menu Button - Fixed Top</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_fixed-bottom" type="checkbox" class="mobile-menu-checkbox" data-type="fixed-bottom">
		<label for="mobile-menu_cb_fixed-bottom" class="mobile-menu-button">Menu Button - Fixed Bottom</label>
		<nav class="mobile-menu" data-type="fixed-bottom">
			<ul>
				<li><label for="mobile-menu_cb_fixed-bottom" class="mobile-menu-button">Menu Button - Fixed Bottom</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_fixed-left" type="checkbox" class="mobile-menu-checkbox" data-type="fixed-left">
		<label for="mobile-menu_cb_fixed-left" class="mobile-menu-button">Menu Button - Fixed Left</label>
		<nav class="mobile-menu" data-type="fixed-left">
			<ul>
				<li><label for="mobile-menu_cb_fixed-left" class="mobile-menu-button">Menu Button - Fixed Left</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_fixed-right" type="checkbox" class="mobile-menu-checkbox" data-type="fixed-right">
		<label for="mobile-menu_cb_fixed-right" class="mobile-menu-button">Menu Button - Fixed Right</label>
		<nav class="mobile-menu" data-type="fixed-right">
			<ul>
				<li><label for="mobile-menu_cb_fixed-right" class="mobile-menu-button">Menu Button - Fixed Right</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_push-top" type="checkbox" class="mobile-menu-checkbox" data-type="push-top">
		<label for="mobile-menu_cb_push-top" class="mobile-menu-button">Menu Button - Push Top</label>
		<nav class="mobile-menu" data-type="push-top">
			<ul>
				<li><label for="mobile-menu_cb_push-top" class="mobile-menu-button">Menu Button - Push Top</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_push-bottom" type="checkbox" class="mobile-menu-checkbox" data-type="push-bottom">
		<label for="mobile-menu_cb_push-bottom" class="mobile-menu-button">Menu Button - Push Bottom</label>
		<nav class="mobile-menu" data-type="push-bottom">
			<ul>
				<li><label for="mobile-menu_cb_push-bottom" class="mobile-menu-button">Menu Button - Push Bottom</label></li>
			<li><a href="">Home</a></li>
			<li><a href="">Option</a></li>
			<li><a href="">Option</a>
				<ul>
					<li><a href="">Sub-Option</a></li>
					<li><a href="">Sub-Option</a></li>
					<li><a href="">Sub-Option</a></li>
				</ul>
			</li>
			<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_push-left" type="checkbox" class="mobile-menu-checkbox" data-type="push-left">
		<label for="mobile-menu_cb_push-left" class="mobile-menu-button">Menu Button - Push Left</label>
		<nav class="mobile-menu" data-type="push-left">
			<ul>
				<li><label for="mobile-menu_cb_push-left" class="mobile-menu-button">Menu Button - Push Left</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
	<div class="flex-cell w25">
		
		<input id="mobile-menu_cb_push-right" type="checkbox" class="mobile-menu-checkbox" data-type="push-right">
		<label for="mobile-menu_cb_push-right" class="mobile-menu-button">Menu Button - Push Right</label>
		<nav class="mobile-menu" data-type="push-right">
			<ul>
				<li><label for="mobile-menu_cb_push-right" class="mobile-menu-button">Menu Button - Push Right</label></li>
				<li><a href="">Home</a></li>
				<li><a href="">Option</a></li>
				<li><a href="">Option</a>
					<ul>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
						<li><a href="">Sub-Option</a></li>
					</ul>
				</li>
				<li><a href="">Option</a></li>
			</ul>
		</nav>
		
	</div>
</div>

<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">
<hr class="default w60 center">















<h2>3rd Party Functionality</h2>

<h3>Scroll Targets / Affix (Scroll Magic, Custom, TweenMax)</h3>

<div id="trigger1" class="spacer s0"></div>
<div id="pin1" class="box2 blue">
	<p>Stay where you are (at least for a while).</p>
	<a href="#" class="viewsource">view source</a>
</div>
<div id="pin2" class="box2 blue">
	<p>Stay where you are (at least for a while).</p>
	<a href="#" class="viewsource">view source</a>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>javascript/greensock/TweenMax.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>javascript/jquery.scrollmagic.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>javascript/jquery.scrollmagic.debug.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	// init controller
	var controller = new ScrollMagic();
	
	// Pinning
	
	// build scene
	var selectors = [
		'#pin1',
		'#pin2'
	];
	for ( selector_index in selectors )
	{
		var selector = selectors[selector_index];
		var $selector = $(selector);
		
		// build scene
		var scene = new ScrollScene({
			triggerElement : selector,
			duration : $selector.height(),//0
			triggerHook : 0.0,
			offset : '0'
		})
		.setPin($selector)
		/*
		.on('enter leave', function(event)
		{
			if ( event.type == 'enter' )
			{
				$vertical_sub_nav.css({width: $vertical_sub_nav.width()});
			}
		})
		*/
		.addTo(controller);
		
		// show indicators (requires debug extension)
		scene.addIndicators({zindex: 99999});
		/*
		scene.on('update', function(event)
		{
			console.log("Scene Property change \"" + event.type + "\" changed to " + event.target.parent().info('scrollDirection'));
		});
		scene.on('progress', function(event)
		{
			console.log("Scene Property progress \"" + event.type + "\" changed to " + event.progress.toFixed(3));
		});
		*/
	}
	
	/*
	// Scroll highlighting anchor menu
	var $anchors = $vertical_sub_nav.closest('div.columns').find('a[name], div.column[id]');
	$anchors.each(function(i, el)
	{
		var $el = $(el);
		var el_target_anchor = $el.attr('name') ? $el.attr('name') : $el.attr('id');
		var el_height = $el.attr('name') ? $el.parent().height() : $el.height();
		
		var new_scene = new ScrollScene({
			triggerElement: $el,
			duration: el_height,//0,
			triggerHook: 0.0,
			offset: '-25px'
		})
		.addTo(controller)
		.on('enter leave', function(event)
		{
			if ( event.type == 'enter' )
			{
				//console.log('I just scrolled into ' + $el.attr('name'));
				$('a[href="#' + el_target_anchor + '"]').parent().addClass('active');
			}
			else if ( event.type == 'leave' )
			{
				//console.log('I just scrolled past ' + $el.attr('name'));
				$('a[href="#' + el_target_anchor + '"]').parent().removeClass('active');
			}
		});
	});
	*/
	
	/*
	var selectors = [
		'#y_1987',
		'#y_1988'
	];
	for ( selector_index in selectors )
	{
		var selector = selectors[selector_index];
		
		// build tween
		var tween = TweenMax.from(selector, 0.5, {opacity: 0, ease: Linear.easeNone});
		// build scene
		var scene = new ScrollScene({
			duration: 500,
			triggerElement: selector,
			triggerHook: 0.5
		})
		.setTween(tween)
		.addTo(controller);
		
		// show indicators (requires debug extension)
		scene.addIndicators({zindex: 999});
	}
	*/
	
	
	
	/*
				// Back to Top
				var window_height = $(window).height();
				var scroll_last_time = 0;
				var scroll_last_top = $(window).scrollTop();
				var scroll_delay = 100;
				var check_scroll = function()
				{
					// Throttle
					var now = new Date();
					var elapsed = now - scroll_last_time;
					if ( elapsed < scroll_delay )
					{
						return;
					}
					scroll_last_time = now;
					
					var scroll_top = $(this).scrollTop();
					var delta_v = (scroll_top > scroll_last_top) ? 1 : -1;
					scroll_last_top = scroll_top;
					
					// Nav bar, slide into view when going past it
					var pin_element_height = $('#search').outerHeight(true);
					if ( scroll_top > ($('#search-trigger').offset().top + pin_element_height) )
					{
						$('#search').css({top : 0 + 'px'}).addClass('sticky');
						$('#search-trigger').height(pin_element_height);
					}
					else if ( scroll_top < $('#search-trigger').offset().top )
					{
						$('#search').css({top : - pin_element_height + 'px'}).removeClass('sticky');
						$('#search-trigger').height('');
					}
					
					// Back to top
					if ( scroll_top > window_height )
					{
						$('.back-to-top').addClass('sticky');
					}
					else
					{
						$('.back-to-top').removeClass('sticky');
					}
				};
				$(window).scroll(check_scroll);
				check_scroll();
	*/
});
</script>

<hr class="w80 center">


	</section>
	<!-- /content -->
	
</div>
<!-- /band-liner -->
</div>
<!-- /band content -->
</div>
<!-- /band-wrap -->


<?php
// Footer
include(THEME_PATH . 'common/footer.php');
?>

</div>
<!-- /body-liner -->

<?php
// Body Append
include(THEME_PATH . 'common/body.append.php');
?>
</body>
</html>