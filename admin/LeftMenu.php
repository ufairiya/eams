<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="Search..." />				
							<input type="button" class="submit" value=" " />
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li <?php if($current_page == 'index.php'  ) { echo 'class="active has-sub start"'; } else { echo 'class="has-sub start"';}?>>
					<a href="index.php">
					<i class="icon-home"></i> 
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					</a>
				</li>
				<li <?php if($current_page == 'User.php' || $current_page == 'UserRole.php' || $current_page == 'MenuEdit.php' ||  $current_page == 'UserRoleMenuEdit.php' ) { echo 'class="active has-sub start"'; } else { echo 'class="has-sub start"';}?>>
					<a href="javascript:;">
					<i class="icon-table"></i> 
					<span class="title">User</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li <?php if($current_page == 'User.php' ) { echo 'class="active"'; }?>><a href="User.php" >User</a></li>
						<li <?php if($current_page == 'UserRole.php' ) { echo 'class="active"'; }?>><a href="UserRole.php">User Role</a></li>
				    </ul>
				</li>
				
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>