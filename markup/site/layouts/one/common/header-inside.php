<div class="band-wrap band-header bg-size-cover">
<div class="band padding-tbs grid-gutter">
<div class="band-liner">

	<header class="primary">
		
		<h1 class="logo display-table-cell">
			<a href="<?php echo site_url(''); ?>">Logo<!--<img src="<?php echo base_url(); ?>images/header__logo.jpg" alt="[Logo]" class="scale-with-grid" />--></a>
		</h1>
		
		<nav class="nav-dropdown-setup nav-primary display-table-cell table-cell--middle">
			<ul>
				<li>
					<a href="<?php echo site_url(); ?>">Home</a>
				</li>
				<li class="<?php echo page_is('', true) || strpos(PAGE, '') === 0 ? 'active' : ''; ?>">
					<a href="">Menu Item</a>
					<ul>
						<li>
							<a href="">Submenu Item</a>
						</li>
						<li>
							<a href="">Submenu Item</a>
						</li>
						<li>
							<a href="">Submenu Item</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>

	</header>
	
</div>
</div>
</div>