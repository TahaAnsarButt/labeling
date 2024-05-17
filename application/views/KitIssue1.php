<?php
if (!($this->session->has_userdata('user_id'))) {
	redirect('login');
} else {

	$this->load->view('header');
?>

	<body class="mod-bg-1 ">
		<!-- DOC: script to save and load page settings -->
		<script>
			/**
			 *	This script should be placed right after the body tag for fast execution 
			 *	Note: the script is written in pure javascript and does not depend on thirdparty library
			 **/
			'use strict';

			var classHolder = document.getElementsByTagName("BODY")[0],
				/** 
				 * Load from localstorage
				 **/
				themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) : {},
				themeURL = themeSettings.themeURL || '',
				themeOptions = themeSettings.themeOptions || '';
			/** 
			 * Load theme options
			 **/
			if (themeSettings.themeOptions) {
				classHolder.className = themeSettings.themeOptions;
				console.log("%c✔ Theme settings loaded", "color: #148f32");
			} else {
				console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
			}
			if (themeSettings.themeURL && !document.getElementById('mytheme')) {
				var cssfile = document.createElement('link');
				cssfile.id = 'mytheme';
				cssfile.rel = 'stylesheet';
				cssfile.href = themeURL;
				document.getElementsByTagName('head')[0].appendChild(cssfile);
			}
			/** 
			 * Save to localstorage 
			 **/
			var saveSettings = function() {
				themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
					return /^(nav|header|mod|display)-/i.test(item);
				}).join(' ');
				if (document.getElementById('mytheme')) {
					themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
				};
				localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
			}
			/** 
			 * Reset settings
			 **/
			var resetSettings = function() {
				localStorage.setItem("themeSettings", "");
			}
		</script>
		<!-- BEGIN Page Wrapper -->
		<div class="page-wrapper">
			<div class="page-inner">
				<!-- BEGIN Left Aside -->
				<?php
				$this->load->view('aside');
				?>
				<!-- END Left Aside -->
				<div class="page-content-wrapper">
					<!-- BEGIN Page Header -->
					<?php
					$this->load->view('template');
					?>
					<!-- END Page Header -->
					<!-- BEGIN Page Content -->
					<!-- the #js-page-content id is needed for some plugins to initialize -->
					<main id="js-page-content" role="main" class="page-content">
						<?php
						if ($this->session->flashdata('Proinfo')) {


						?>
							<div class="alert alert-danger alert-dismissible show fade" id="msgbox">
								<div class="alert-body">
									<button class="close" data-dismiss="alert">
										<span>&times;</span>
									</button>
									<?php echo $this->session->flashdata('Proinfo'); ?>
								</div>
							</div>
						<?php
						}

						?>

						<div>
							<div>

								<!-- Popup Form Button -->

								<!-- Modal HTML Markup -->
								<div id="ModalLoginForm" class="modal fade">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title">Add/Edit Assets Type </h1>
											</div>
											<div class="modal-body">
												<form name="form" id="myForm" method="POST" action="">
													<!-- <input type="hidden" name="_token" value=""> -->
													<div class="form-group" style="display:none;">
														<label class="control-label">ID</label>
														<div>
															<input type="text" class="form-control input-lg" id="project-bid" name="tid">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label">Asset Type</label>
														<div>
															<input type="text" class="form-control input-lg" name="assetName" id="assName" placeholder="Enter Asset Name">
														</div>
													</div>
													<!-- <div class="form-group">
                        <label class="control-label">Password</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="password">
                        </div>
                    </div> -->
													<div class="form-group">
														<div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="assetStatus"> Status
																</label>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div>
															<button type="submit" class="btn btn-success" id="saveAssetType">Save</button>
															<button type="submit" class="btn btn-success" id="updateAssetType" style="display:none">Update</button>

															<button class="btn btn-success" data-dismiss="modal">Close</button>

														</div>
													</div>
												</form>

											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div><!-- /.modal -->

								<!-- Modal Delete Asset Type -->
								<div class="modal fade" id="ModelDeletetype" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalCenterTitle">Delete Asset Type</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Are you sure you want to delete detail of project? (This process is irreversible)
											</div>
											<div class="modal-footer">

												<button type="button" class="btn btn-primary btn-confirm-del-type">Yes</button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
											</div>
										</div>
									</div>
								</div>


								<!-- Modal Delete Asset Type -->
								<div class="modal fade" id="ModelDeleteChart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalCenterTitle">Delete Chart of Asset</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Are you sure you want to delete detail of project? (This process is irreversible)
											</div>
											<div class="modal-footer">

												<button type="button" class="btn btn-primary btn-confirm-del-chart">Yes</button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
											</div>
										</div>
									</div>
								</div>


								<div id="ModalAss" class="modal fade">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title">Add/Edit Charts of Asset</h1>
											</div>
											<div class="modal-body">
												<form name="formChart" id="myformChart" method="POST" action="">
													<!-- <input type="hidden" name="_token" value=""> -->
													<div class="form-group" style="display:none;">
														<label class="control-label">ID</label>
														<div>
															<input type="text" class="form-control input-lg" id="project-bid" name="cid">
														</div>
													</div>

													<div class="form-group">
														<div>
															<label for="sel1">Production Type :</label>
															<select class="form-control" id="sel1" name="assetProdType">
																<option value="0" disabled>Select one of the following</option>
																<option value="1">Production</option>
																<option value="2">Non Production</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<div>
															<label for="sel1">Asset Type :</label>
															<select class="form-control" id="sel1" name="assetChartType">
																<option value="0" disabled>Select one of the following</option>
																<?php
																if (isset($Assettype)) {
																	foreach ($Assettype as $Key) {

																?>

																		<option value="<?php echo $Key['TID'] ?>"><?php echo $Key['AssertType'] ?></option>
																<?php
																	}
																}
																?>

															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label">Name :</label>
														<div>
															<input type="text" class="form-control input-lg" name="assetNameChart" placeholder="Name">
														</div>
													</div>

													<div class="form-group">
														<label class="control-label">UOM: </label>
														<div>
															<input type="text" class="form-control input-lg" name="UOM" placeholder="UOM">
														</div>
													</div>
													<!-- <div class="form-group">
                        <label class="control-label">Password</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="password">
                        </div>
                    </div> -->
													<div class="form-group">
														<div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="assetChartStatus"> Status
																</label>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div>
															<button type="submit" class="btn btn-success" id="saveAssetChart">Save</button>
															<button type="submit" class="btn btn-success" id="updateAssetChart" style="display:none">Update</button>

															<button class="btn btn-success" data-dismiss="modal">Close</button>

														</div>
													</div>
												</form>

											</div>
										</div><!-- /.modal-content -->
									</div><!-- /.modal-dialog -->
								</div>
								<br><br>
								<?php
								$Month = date('m');
								$Year = date('Y');
								$Day = date('d');
								$CurrentDate = $Year . '-' . $Month . '-' . $Day;
								?>
								<div id="exampleModalEditMat" class="panel">
									<div class="panel-hdr">
										<h2>
											Kits <span class="fw-300"><i>Issuance</i></span>
										</h2>
										<div class="panel-toolbar">
											<button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
											<button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
											<button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
										</div>
									</div>
									<div class="panel-container show">
										<div class="panel-content">


											<div class="tab-content py-3">

												<div class="row ">
													<div class="col-sm-1">
														<!-- <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2"  >
                                                                <label class="custom-control-label" for="customSwitch2">Reprint</label>
                                                            </div> -->
													</div>
													<div class="col-md-3">
														<label>Start Date :</label>
														<div class="form-group-inline">

															<input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>">
														</div>
													</div>
													<div class="col-md-3" hidden>
														<label>End Date</label>
														<div class="form-group-inline">

															<input name="date" id="date2" class="form-control" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" type="date" value="<?php echo $CurrentDate; ?>">
														</div>
													</div>

													<div class="col-md-2">
														<div class="form-group">
															<lable class="form-control-label" for="duration">Factory Code:</lable>

															<select class="form-control" name="duration" id="fc">

																<option value="B34001">B34001</option>
																<option value="B34002">B34002</option>
																<option value="B34003">B34003</option>
																<option value="B34004">B34004</option>
																<option value="B34005">B34005</option>
																<option value="B34006">B34006</option>
																<option value="B34007">B34007</option>
																<option value="Sample_Label">Sample Label</option>
																<option value="3HV001">3HV001</option>
															</select>
														</div>
													</div> 

													<div class="col-md-2">
														<label style="background-color: #fff; color: #fff;">Search</label>
														<div class="form-group-inline">

															<button class="btn btn-primary" id="Searchbtn">Search</button>
														</div>
													</div>
												</div>

											</div>
											<br><br>
											<div class="row" id="Kitsname">



											</div>


											<div class="row">
												<div id="westageDesc" style="display:none" class="col-md-2">
													<div class="form-group">
														<lable class="form-control-label " for="duration">Westage Description:</lable>
														<br>
														<select id="westageCons" type="text" value="0" class="form-control mySelectMatProEdit" data-live-search="true" searchable="Search here..">
															<option value="Red Tape">Red Tape</option>
															<option value="Printing">Printing</option>
															<option value="Quality Issue">Quality Issue</option>
															<option value="White Wastage">White Wastage</option>
															<option value="Test PO">Test PO</option>

														</select>
													</div>
												</div>

											</div>

											<br><br>





											<div class="row">
												<div class="col-md-12">
													<div class="table-responsive-lg" id="kitsissuance">


													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>


						</div>
				</div>
			</div>
			</main>
		</div>
		<?php
		$this->load->view('after-main');
		?>



		<script>
			$("#customSwitch2").change(function(e) {

			});
			$(document).ready(function() {
				loadData()
				// $("#date1").change(function(e) {
				//     //alert('Heloo');
				//     loadPO()
				//     loadData()
				// });
				// $("#date2").change(function(e) {
				//     //alert('Heloo');
				//     loadPO()
				//     loadData()
				// });
				$("#Kits").change(function(e) {
					//alert('Heloo');
					var PoCode = $("#PoCode").val();
					// alert(PoCode);
					url = "<?php echo base_url("/json_by_machine/") ?>" + PoCode

					$.get(url, function(data) {
						html = data[0].OrderQty

						console.log(html);
						$("#pquantity").val(html)
					});
					loadbalance()
				});
				$('#Searchbtn').click(function() {
					//alert("i am here");
					loadData()
				});

				function loadData() {

					var date1 = $("#date1").val()
					var date2 = $("#date2").val()
					var fc = $("#fc").val()
					// console.log("date1=" + date1 + ", date2=" + date2 + ", fc=" + fc);
					url = "<?php echo base_url("index.php/KitIssuance1/getkitsissuance/") ?>" + date1 + "/" + date2 + "/" + fc 
					$.get(url, function(data) {
						$("#kitsissuance").html(data)
					});
				}
			});
		</script>




		<?php
		$this->load->view('Foter');
		?>
	</body>

	</html>
<?php

}

?>
