
				<li>
					<a href="<?php echo site_url('layouts/one'); ?>">Home</a>
					<ul>
						<li>
							<a href="<?php echo site_url('layouts/one/contact'); ?>">Contact</a>
						</li>
						<li>
							<a href="<?php echo site_url('layouts/one/logged-in_user_dashboard'); ?>">Logged-in User Dashboard</a>
						</li>
						<li>
							<a href="<?php echo site_url('layouts/one/logged-in_user_applications'); ?>">Logged-in User Applications</a>
						</li>
						<li>
							<a href="<?php echo site_url('layouts/one/logged-in_user_new-application'); ?>">Logged-in User New Application</a>
						</li>
					</ul>
				</li>
				<li class="<?php echo page_is('', true) || strpos(PAGE, '') === 0 ? 'active' : ''; ?>">
					<a href="">Example Menu Item</a>
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