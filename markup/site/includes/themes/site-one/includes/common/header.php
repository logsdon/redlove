
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


<input id="mobile-menu_cb" type="checkbox" class="mobile-menu-checkbox" data-type="fixed-right">
<label for="mobile-menu_cb" class="mobile-menu-button show-m-down position-absolute pin-top pin-right padding-1"></label>
<nav class="mobile-menu" data-type="fixed-right">
	<ul>
		<li><label for="mobile-menu_cb" class="mobile-menu-button"></label></li>
		<?php require(THEME_PATH . 'includes/common/header_nav-list-items.php'); ?>
	</ul>
</nav>
