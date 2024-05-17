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
								$CurrentMonth = $Year . '-' . $Month;
								$formattedMonth = date('F Y', strtotime($CurrentMonth));
								echo '<script> let month = ' . json_encode($formattedMonth) . '; console.log("month:", month); </script>';


								// '<script> let month ='  ; json_encode($CurrentMonth); '</script>'
								// ;'<script>console.log("month:",month)</script>';


								?>
								<!-- <script>let AuditMonth = <?php echo json_encode($CurrentMonth) ?>; 
                            $('#one').html(AuditMonth)
                            </script> -->
								<div id="exampleModalEditMat" class="panel">
									<div class="panel-hdr">
										<h2>
											Westage <span class="fw-300"><i>Form</i></span>
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

                                            <div id="htmlData">


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
			
<script>

function getLabelReceive(){
    
}


$(document).ready(function(){
   
    $("#htmlData").html("");

    var html = "";

    html += `
    <table class="table table-striped table-hover table-sm" id="tableExport">
                                <thead style="background-color:black; color:white;">
                                    <tr>
                                        <th>Kit Name</th>
                                        <th>Wastage</th>
                                        <th>Wastage Description</th>
                                        <th>Entry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                        <td> </td>
                                        <td></td>
                                        <td> </td>
                                        <td></td>
                                    </tr>
                            </tbody>

    `

    $("#htmlData").html(html);

    $('#tableExport').dataTable({
							responsive: false,
							lengthChange: false,
							dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
								"<'row'<'col-sm-12'tr>>" +
								"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							buttons: [{
									extend: 'pdfHtml5',
									text: 'PDF',
									titleAttr: 'Generate PDF',
									className: 'btn-outline-danger btn-sm mr-1'
								},
								{
									extend: 'excelHtml5',
									text: 'Excel',
									titleAttr: 'Generate Excel',
									className: 'btn-outline-success btn-sm mr-1'
								},
								{
									extend: 'csvHtml5',
									text: 'CSV',
									titleAttr: 'Generate CSV',
									className: 'btn-outline-primary btn-sm mr-1'
								},
								{
									extend: 'copyHtml5',
									text: 'Copy',
									titleAttr: 'Copy to clipboard',
									className: 'btn-outline-primary btn-sm mr-1'
								},
								{
									extend: 'print',
									text: 'Print',
									titleAttr: 'Print Table',
									className: 'btn-outline-primary btn-sm'
								}
							]
						});

})

</script>



			<?php
			$this->load->view('Foter');
			?>
			<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
		</div>
	</body>

	</html>
<?php

}

?>