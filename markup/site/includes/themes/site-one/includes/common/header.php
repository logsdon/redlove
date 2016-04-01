
	<header class="primary">
		
		<h1 class="logo display-table-cell no-wrap">
			<a href="<?php echo theme_nav_url(); ?>">Logo</a>
		</h1>
		
		<nav class="nav-dropdown-setup nav-primary display-table-cell table-cell--middle show-l-up">
			<ul>
				<?php require(THEME_PATH . 'includes/common/header_nav-list-items.php'); ?>
			</ul>
		</nav>

	</header>


<input id="responsive-menu_cb" type="checkbox" class="responsive-menu-checkbox" data-responsive-menu-type="fixed-right">
<label for="responsive-menu_cb" class="responsive-menu-button show-m-down position-absolute pin-top pin-right padding-1"></label>
<nav class="responsive-menu" data-responsive-menu-type="fixed-right">
	<ul>
		<li><label for="responsive-menu_cb" class="responsive-menu-button"></label></li>
		<?php require(THEME_PATH . 'includes/common/header_nav-list-items.php'); ?>
	</ul>
</nav>
