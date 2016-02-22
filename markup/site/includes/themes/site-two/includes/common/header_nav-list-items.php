
				<li class="<?php echo page_is('index') ? 'active' : ''; ?>">
					<a href="<?php echo theme_nav_url(); ?>">Home</a>
				</li>
				<li class="">
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
				<li class="<?php echo page_is('disclosure-agreement') ? 'active' : ''; ?>">
					<a href="<?php echo theme_nav_url('disclosure-agreement'); ?>">Disclosure Agreement</a>
				</li>
				<li class="<?php echo page_is('contact') ? 'active' : ''; ?>">
					<a href="<?php echo theme_nav_url('contact'); ?>">Contact Us</a>
				</li>