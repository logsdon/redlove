
<div class="band-wrap">
<div class="band header padding-tbm grid-gutter">
<div class="band-liner">

	<header class="primary">
		
		<h1 class="logo">
			<a href="<?php echo theme_nav_url(); ?>">[Logo]<!--<img src="<?php echo theme_base_url(); ?>images/header__logo.jpg" alt="[Logo]" class="scale-with-grid" />--></a>
		</h1>
		
		<nav class="nav-dropdown-setup nav-primary">
			<ul>
				<li>
					<a href="<?php echo theme_nav_url(); ?>">Home</a>
				</li>
				<li class="<?php echo page_is('', true) || strpos(PAGE, '') === 0 ? 'active' : ''; ?>">
					<a href="">Theme</a>
					<ul>
						<li>
							<a href="<?php echo theme_nav_url('inside'); ?>">Inside variations</a>
						</li>
						<li>
							<a href="<?php echo theme_nav_url('style-guide'); ?>">Style Guide</a>
						</li>
						<li>
							<a href="<?php echo theme_nav_url('style-examples'); ?>">Style Examples</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>

	</header>
	<!-- /header -->

</div>
<!-- /band liner -->
</div>
<!-- /band header -->
</div>
<!-- /band-wrap -->
