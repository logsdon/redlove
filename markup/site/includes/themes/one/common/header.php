
	<header class="primary">
		
		<h1 class="logo display-table-cell">
			<a href="<?php echo site_url(THEME_NAV_ROOT); ?>">Logo</a>
		</h1>
		
		<nav class="nav-dropdown-setup nav-primary display-table-cell table-cell--middle show-l-up">
			<ul>
				<?php require(THEME_PATH . 'common/header_nav-list-items.php'); ?>
			</ul>
		</nav>

		<input id="mobile-menu_cb" type="checkbox" class="mobile-menu-checkbox" data-type="fixed-right">
		<label for="mobile-menu_cb" class="mobile-menu-button show-m-down position-absolute pin-top pin-right"></label>
		<nav class="mobile-menu" data-type="fixed-right">
			<ul>
				<li><label for="mobile-menu_cb" class="mobile-menu-button"></label></li>
				<?php require(THEME_PATH . 'common/header_nav-list-items.php'); ?>
			</ul>
		</nav>

	</header>