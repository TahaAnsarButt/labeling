<?php
if (!($this->session->has_userdata('user_id'))) {
	redirect('login');
} else {
?>


	<?php
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


								<?php
								$Month = date('m');
								$Year = date('Y');
								$Day = date('d');
								$CurrentDate = $Year . '-' . $Month . '-' . $Day;
								?>
								<br><br>
								<div id="panel-7" class="panel">
									<div class="panel-hdr">
										<h2>
											Kits <span class="fw-300"><i>Receiving</i></span>
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
												<div class="row">
													<div class="col-md-3">
														<label>Start Date :</label>
														<div class="form-group-inline">
															<input name="date" id="date1" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
														</div>
													</div>
													<div class="col-md-3">
														<label>End Date</label>
														<div class="form-group-inline">
															<input name="date" id="date2" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
														</div>
													</div>
												</div>
												<br><br>
												<div class="row">
													<div class="col-md-2">
														<div class="form-group">
															<lable class="form-control-label" for="duration">Label Type:</lable>

															<?php

															if ($this->session->userdata('user_id') == 2199) { ?>
																<select class="form-control" name="Type" id="Type">
																	<option value="">Select Duration :</option>
																	<?php

																	foreach ($labelinfor as $Key) {

																	?>
																		<option value="<?php echo $Key['ID'] ?>">ASST BALL</option>

																	<?php
																		break;
																	}
																	?>

																</select>

															<?php } else if ($this->session->userdata('user_id') == 2199) {
															?>
																<select class="form-control" name="Type" id="Type">
																	<option value="">Select Duration :</option>

																	<?php

																	foreach (array_reverse($labelinfor) as $Key) {
																		if($Key['KitID'] == 2){

																		}
																		else{
																	?>
																		<option value="<?php echo  $Key['ID']; ?>">ATACGEAR </option>
																	<?php
																		}
																		break;
																	}
																	?>
																</select>

															<?php
															} else {
															?>
																<select class="form-control" name="Type" id="Type">
																	<option value="">Select Duration :</option>

																	<?php

																	foreach ($labelinfor as $Key) {

																	?>


																		<option value="<?php echo $Key['ID'] ?>"><?php echo $Key['LabelType'] ?></option>

																	<?php
																	}
																	?>
																</select>


															<?php
															}

															?>
														</div>
													</div>
													<div class="col-md-2">
														<label>Kit Name:</label>
														<div class="form-group-inline">

															<input name="KITName" id="Kitname" class="form-control" type="text" readonly="true">
															<input name="ID" id="ID" class="form-control" type="text" hidden="true">
														</div>
													</div>
													<div class="col-md-2">
														<label>Start Range :</label>
														<div class="form-group-inline">

															<input name="SR" id="start_quantity" class="form-control" type="text">
														</div>
													</div>
													<div class="col-md-2">
														<label>End Range :</label>
														<div class="form-group-inline">

															<input name="ER" id="end_quantity" class="form-control" type="text">
														</div>
													</div>
													<div class="col-md-3">
														<label>Received Date :</label>
														<div class="form-group-inline">

															<input name="date" id="Rdate" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
														</div>
													</div>
													<div class="col-md-3">
														<label style="background-color: #fff; color: #fff;">Schedule End Date</label>
														<div class="form-group-inline">

															<button class="btn btn-primary" id="enter">Save</button>
														</div>
													</div>

												</div>

												<br><br>
												<div class="row">
													<div class="col-md-12" id="Data">
														<div class="table-responsive-lg">
															<table class="table table-striped table-hover table-sm" id="tableExport">
																<thead>

																	<th>Kit Name</th>
																	<th>Quantity</th>
																	<th>Received Date</th>
																	<th>Issue For Printing</th>
																	<th>Date</th>
																	<th>Action</th>

																</thead>
																<tbody>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					</main>

					<?php
					$this->load->view('after-main');
					?>


					<script>
						$(document).ready(function() {
							$("#date1").change(function(e) {
								//alert('Heloo');
								loadDate()
							});
							$("#date2").change(function(e) {
								//alert('Heloo');
								loadDate()
							});

							$("select[name=Type]").change(function() {

								loadtype()
								loadDate()
							});

							function loadtype() {
								//alert("Please select");
								var Type = $("select[name='Type']").val()
								url = "<?php echo base_url("index.php/kitsReceived/json_by_machine/") ?>" + Type
								$.get(url, function(data) {

									console.log(data);


									html = data[0].KitID
									html1 = data[0].ID
									// html += '<option value="'+element.SecID+'" >'+element.SecName+'</option>'

									console.log(html);
									$("#Kitname").val(html)
									$("#ID").val(html1)
								})
							}

							function loadDate() {

								var Type = $("select[name='Type']").val()

								var date1 = $("#date1").val()
								var date2 = $("#date2").val()
								//alert(date1
								if (!Type) {
									alert("Please select label type.");
									return;
								}
								url = "<?php echo base_url("index.php/kitsReceived/getData/") ?>" + date1 + "/" + date2 + "/" + Type
								//alert(url);
								$.get(url, function(data) {
									//alert(data);
									$("#Data").html(data)
								});
							}
						});
						$('#enter').click(function() {
							let start_quantity = document.getElementById('start_quantity').value;
							let end_quantity = document.getElementById('end_quantity').value;
							let kitid = $("#Kitname").val();
							let labelid = $('#ID').val();
							let RDate = $("#Rdate").val();
							url = "<?php echo base_url('index.php/kitsReceived/insert_data/') ?>" + start_quantity + "/" + end_quantity + "/" + kitid + "/" + labelid + "/" + RDate
							//alert(url);
							$.get(url, function(data) {
								console.log(data);
								location.reload();
							})
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
