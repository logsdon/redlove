
				<li>
					<a href="<?php echo theme_nav_url(); ?>">Home</a>
					<ul>
						<li>
							<a href="<?php echo theme_nav_url('contact'); ?>">Contact</a>
						</li>
					</ul>
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
				<?php
				if ( ! empty($user) )
				{
				?>
				<li>
					<img src="<?php echo theme_base_url(); ?>images/bookkeeping-615384_800.jpg" alt=" " class="img-scale img-circle" style="height: 30px; width: 30px; vertical-align: top; border: 2px solid #ffffff; top: 3px; position: relative;">
					<a href="">My Account</a>
					<ul>
						<li>
							<a href="">My account</a>
						</li>
						<li>
							<a href="">Help</a>
						</li>
					</ul>
				</li>
				<?php
				}
				?>