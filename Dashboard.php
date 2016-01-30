<?php
  $aDashboardCount = $oMaster->getDashboardCounts();
  //print_r($aDashboardCount);
  $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
   
?>
<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-comments"></i>
								</div>
								<div class="details">
									<div class="number">
										<span id="total-asset"><?php echo $aDashboardCount['Total_Asset_Count']; ?></span>

									</div>
									<div class="desc">									
										Total Assets
									</div>
								</div>
								<a class="more" href="AssetList.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-shopping-cart"></i>
								</div>
								<div class="details">
									<div class="number">
									<span id="po-count"><?php echo $aDashboardCount['New_PO_Count']; ?></span>
                                    </div>
									<div class="desc">New P O</div>
								</div>
								<a class="more" href="PurchaseOrder.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-globe"></i>
								</div>
								<div class="details">
									<div class="number">
									<span id="PurchaseRequest-count"><?php echo $aDashboardCount['New_PR_Count']; ?></span>
                                    </div>
									<div class="desc">Purchase Request</div>
								</div>
								<a class="more" href="PurchaseRequest.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
									<div class="number">
									<span id="Addasset-count">
									<?php echo $aDashboardCount['Add_Asset_Count']; ?>
									</span>
									</div>
									<div class="desc">Add to Asset</div>
								</div>
								<a class="more" href="Inspection.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div>
					<!-- END DASHBOARD STATS -->
					<div class="clearfix"></div>
				
                    <div class="row-fluid">
					<div class="span6">
							<!-- BEGIN PORTLET-->
							<div class="portlet paddingless">
								<div class="portlet-title line">
									<h4><i class="icon-bell"></i>Feeds</h4>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
										
									</div>
								</div>
								<div class="portlet-body">
									<!--BEGIN TABS-->
									<div class="tabbable tabbable-custom">
										<ul class="nav nav-tabs">
											<li class="active"><a href="#tab_1_1" data-toggle="tab">Warranty</a></li>
											<li><a href="#tab_1_2" data-toggle="tab">Contract</a></li>
											<li><a href="#tab_1_3" data-toggle="tab">Insurance</a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="tab_1_1">
                                              <div class="scroller" id="warrants" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													
                                                    
                                                    <ul class="feeds">
														<li >
															<div class="col1">
																<div class="cont">
																	<div class="cont-col1">
																		<div class="label label-success">								
																			<i class="icon-bell"></i>
																		</div>
																	</div>
																	<div class="cont-col2">
																		<div class="desc">
																			No Warrant expires this week.
																		</div>
																	</div>
																</div>
															</div>
														</li>
                                                        </ul>
                                                        </div>
															
												
												
											</div>
											<div class="tab-pane" id="tab_1_2">
												<div class="scroller" id="contractList" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													<ul class="feeds">
														<li>
															<a href="#">
																<div class="col1">
																	<div class="cont">
																		<div class="cont-col1">
																			<div class="label label-success">								
																				<i class="icon-bell"></i>
																			</div>
																		</div>
																		<div class="cont-col2">
																			<div class="desc">
																					No Contract expires this week.
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col2">
																	<div class="date">
																		Just now
																	</div>
																</div>
															</a>
														</li>
														
													</ul>
												</div>
											</div>
											<div class="tab-pane" id="tab_1_3">
												<div class="scroller" id="insuranceList" data-height="290px" data-always-visible="1" data-rail-visible1="1">
													<ul class="feeds">
														<li>
															<a href="#">
																<div class="col1">
																	<div class="cont">
																		<div class="cont-col1">
																			<div class="label label-success">								
																				<i class="icon-bell"></i>
																			</div>
																		</div>
																		<div class="cont-col2">
																			<div class="desc">
																					No Insurance expires this week.
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col2">
																	<div class="date">
																		Just now
																	</div>
																</div>
															</a>
														</li>
														
													</ul>
												
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--END TABS-->
								</div>
							</div>
							<!-- END PORTLET-->
					<div class="span6">
							<!-- BEGIN PORTLET-->
							<div class="portlet paddingless">
                           		
								  <div class="portlet box blue">
                     <div class="portlet-title">
                     
                          <h4><i class="icon-reorder"></i>Search Report</h4>
                                              
                     </div>
                     <div class="portlet-body form">
								
								  
								<div class="portlet-body" style="min-height:310px;">
								 <form action="DetailReportList.php" class="form-horizontal" id="form_sample_3" method="post">
							      <div class="row-fluid">    
                                    <div class="span6">
                                    <select class="m-wrap " tabindex="1" name="fCriteria">
                                      <option value="">Choose the Criteria</option>
                                    <option value="count">Count</option>
                                     <option value="list">List</option>
                                    </select>
                                    </div>  
                                    
                                     <div class="span6">
                                    <select class="m-wrap " tabindex="1" name="fSearchType" id="fSearchType">
                                      <option value="">Choose the Type</option>
                                    <option value="asset">Asset</option>
                                     <option value="unit">Unit</option>
                                     <option value="store">Store</option>
                                      <option value="itemgroup">ItemGroup</option>
                                    </select>
                                    </div>  
                                    
                                      </div>  
                                      
                                     <div class="clearfix"></div> 
                                    <div class="row-fluid" style="margin-top: 20px;" id="searchtype"></div>
								
								 <div class="control-group" style="margin-top: 20px;">
								         <div id="form-date-range" class="btn">
                                    <i class="icon-calendar"></i>
                                    &nbsp;<span></span> 
                                    <input type="hidden" name="fDateRange" value="" id="date-range"/>
                                    <b class="caret"></b>
                                 </div>
								 </div>
							
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Search</button>                          
								
							 </form>
									</div>
								</div>
								</div>		
								
								</div>
							</div>		
						</div>
						
					</div>
					
				</div>
             
                