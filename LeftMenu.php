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
				<li <?php if($current_page == 'index.php'  ) { echo 'class="active has-sub"'; } else { echo 'class="has-sub"';}?>>
					<a href="index.php">
					<i class="icon-home"></i> 
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					</a>
				</li>
				<?php
				$aMenuPerm = $oSession->getSession('sesMenuPermission');
				//print_r($aMenuPerm);
				//$allowedCat = $oDb->get_row("SELECT db_lcatId FROM USER WHERE login_id = '".$xx."'");
				$rCatList = $oDb->get_results("SELECT db_lcatId, db_lcatName FROM linkcattable WHERE db_lcatStatus = 1 ORDER BY db_lsOrder ASC");
				//print_r($rCatList);
				$cInfo = $oSession->getSession('sesCustomerInfo');
				$aMainMenu = $cInfo['aMainMenu'];
				$aMenuList = $oMaster->getMainMenuNames($aMainMenu);
				$ParentId = $oCustomer->getParentId($current_page);
				
				foreach ($aMenuList as $category)
    			{
				?>
				<li <?php if($ParentId == $category['db_lcatId'] ) { echo 'class="has-sub open start active "'; } else { echo 'class="has-sub "';}?>>
						<a href="javascript:;">
						<i class="icon-table"></i> 
						<span class="title"><?php echo $category['db_lcatName']; ?></span>
						<span class="selected"></span>
						<span class="arrow"></span>
						</a>
				<?php
				
				if($rMenuList = $oDb->get_results("SELECT
        								db_lscatId, db_lscatName, db_lscatLink, 
        								db_lscatmenu_param, db_target
        							FROM 
        								linksubcattable
        							WHERE
        								db_lscatStatus =1 
        								AND db_lcatId = ".$category['db_lcatId']."
        								AND ls_catMenuType = 1
        							ORDER BY
        								db_lsOrder ASC"))
										/*echo '<pre>';
										print_r($rMenuList);
										echo '</pre>';*/
										
										
				 {
				 ?>
				 <ul class="sub" <?php if(!empty($current_page))  { /*echo 'style="display:none"';*/ }?>>
				 <?php
				     foreach($rMenuList as $menu)
					 {
						 
					   $selectedMenu = $oDb->get_row("SELECT db_lscatId FROM linksubcattable WHERE db_lscatLink = '$file' AND ls_catMenuType = 1 $where");
						
						if(in_array($menu->db_lscatId, $aMenuPerm))
						{
						if(!empty($selectedMenu->db_lscatId))
						{
							if($rOtherLinks = $oDb->get_results("SELECT db_lscatId FROM linksubcattable WHERE ls_catParentId = '$selectedMenu->db_lscatId' AND ls_catMenuType = 2", ARRAY_A))
							{
								foreach($rOtherLinks as $other)
								{
									if(!in_array($other['db_lscatId'], $aMenuPerm))
									{
									$aMenuPerm[] = $other['db_lscatId'];
									//$oSession->setSession('sesMenuPermission',$aMenuPerm);
									}
								}
								$oSession->setSession('sesMenuPermission',$aMenuPerm);
								
							}
						}
						   	if($menu->db_target == 0)
							{
							?>
<li <?php if($current_page == $menu->db_lscatId)  { echo 'class="active"'; }?>><a href="<?php echo APP_HTTP."/".$menu->db_lscatLink.".php".$menu->db_lscatmenu_param; ?>"><?php echo $menu->db_lscatName; ?></a></li>
						   <?php
							}
							
						}

					 }//innerfoeach
				   ?>
				    </ul>
				   <?php
				   
				 
				 } //end if						
										
														
				} //end foreach
				
				?>
				</li>
				
				
				
				
				<!--<li class=" has-sub start active">
					<a href="javascript:;">
					<i class="icon-table"></i> 
					<span class="title">Asset</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li><a href="AssetCategory.php">Asset Category</a></li>
						<li><a href="AssetType.php">Asset Type</a></li>
				    </ul>
				</li>
				
				<li class="has-sub">
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Territory</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li ><a href="Country.php">Country</a></li>
						<li ><a href="Currency.php">Currency</a></li>
						<li ><a href="State.php">State</a></li>
						<li ><a href="City.php">City</a></li>
						<li ><a href="Port.php">Port</a></li>
						<li ><a href="Shift.php">Shift</a></li>
					</ul>
				</li>
				<li class="has-sub">
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Company</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li><a href="Company.php">Company</a></li>
						<li><a href="AssetUnit.php">Unit</a></li>
						<li><a href="AssetDepartment.php">Department</a></li>
						<li><a href="Division.php">Division</a></li>
						<li><a href="Store.php">Store</a></li>
					</ul>
				</li>
				
				<li class="has-sub">
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Participants</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li><a href="Bank.php">Bank</a></li>
						<li><a href="AssetVendor.php">Supplier</a></li>
						<li><a href="Customer.php">Customer</a></li>
						<li><a href="Employee.php">Employee</a></li>
					</ul>
				</li>
				
				<li class="has-sub">
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Maintenance</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li><a href="MaintenanceGroup.php">Maintenance Group</a></li>
						<li><a href="Maintenance.php">Maintenance</a></li>
						<li><a href="Fault.php">Fault</a></li>
					</ul>
				</li>
				
				<li class="has-sub">
					<a href="javascript:;">
					<i class="icon-briefcase"></i> 
					<span class="title">Setup</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub">
						<li><a href="TaxForm.php">Tax Form</a></li>
						<li><a href="Maintenance.php">Maintenance</a></li>
						<li><a href="Fault.php">Fault</a></li>
					</ul>
				</li>-->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>