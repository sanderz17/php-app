			<!-- partial:partials/_navbar.html -->
			<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row background-color">
				<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center background-color">
					<a class="navbar-brand brand-logo" href="<?php echo ADMINURL; ?>"><img src="<?php echo ADMINURL.'assets/images/logo-3.png'; ?>" alt="logo" title="<?php echo SITETITLE; ?>" style="width: 180px; height: 70px;" /></a>
					<!-- <a class="navbar-brand brand-logo-mini" href="<?php echo ADMINURL; ?>"><img src="<?php echo ADMINURL.'assets/images/logo-mini.png'; ?>" alt="logo" title="<?php echo SITETITLE; ?>" /></a> -->
				</div>
				<div class="navbar-menu-wrapper d-flex align-items-stretch">
					<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" title="Toggle Menu">
						<span class="mdi mdi-menu"></span>
					</button>
					<ul class="navbar-nav navbar-nav-right">
						<li class="nav-item nav-profile dropdown">
							<a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
								<div class="nav-profile-text">
									<p class="mb-1 text-black"><?php echo $_SESSION[SESS_PRE.'_ADMIN_SESS_NAME']; ?></p>
								</div>
							</a>
							<div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
								<a class="dropdown-item" href="<?php echo ADMINURL; ?>my-account/" title="My Account">
									<i class="mdi mdi-account-edit mr-2 text-success"></i> My Account </a>
								<a class="dropdown-item" href="<?php echo ADMINURL; ?>change-password/" title="Change Password">
									<i class="mdi mdi-textbox-password mr-2 text-primary"></i> Change Password </a>
								<a class="dropdown-item" href="<?php echo ADMINURL; ?>setting/" title="Site Setting">
									<i class="mdi mdi-settings mr-2 text-info"></i> Site Setting </a>
							</div>
						</li>

						<li class="nav-item nav-logout d-none d-lg-block">
							<a class="nav-link" href="<?php echo ADMINURL; ?>logout/" title="Logout">
								<i class="mdi mdi-power"></i>
							</a>
						</li>
					</ul>
					<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
						<span class="mdi mdi-menu"></span>
					</button>
				</div>
			</nav>
			
			<!-- partial -->