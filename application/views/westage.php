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

												<div class="row ">
													<!-- <div class="col-sm-1">
                                                        <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2"  >
                                                                <label class="custom-control-label" for="customSwitch2">Reprint</label>
                                                            </div>
                                                    </div> -->

												</div>

												<br><br>
												<div class="row" id="Kitsname">
													<div class="col-md-3">
														<div class="form-group">
															<label class="form-control-label">Audit Month:</label>
															<select class="form-control kitsSelectbox" name="AuditID" id="Audit" required="true" onchange="loadMonth()">
																<option value="">Select Audit Month</option>
																<!-- <?php foreach ($getAuditID as $key => $value) {
																		?>
                                                                <option value="<?php echo $value['AuditMonth'] ?>"><?php echo $value['AuditMonth'] ?></option>
                                                                <?php } ?> -->
															</select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<lable class="form-control-label" for="duration">Kits Name:</lable>
															<?php
															//print_r($Kits);


															?>
															<select class="form-control kitsSelectbox" name="kitsName" id="Kits">
																<option value="">Select Kits Name :</option>



																<?php

																foreach ($Kits as $Key) {
																?>

																	<option value="<?php echo $Key['RecID'] ?>"><?php echo $Key['SerialNo'] ?></option>

																<?php

																}
																?>
															</select>
														</div>
													</div>
													<div class="col-md-2">

														<label>Westage:</label>
														<div class="form-group-inline">

															<input name="SR" value="0" id="Westage" onchange="westageChange()" class="form-control" type="text" value="">
														</div>
													</div>
													<div class="col-md-2">
														<label>Balance:</label>

														<div class="form-group-inline">

															<input name="Balance" readonly="readonly" id="Balance" class="form-control" type="text">
														</div>
													</div>
													<!-- <div class="col-md-2">
                                                    <div class="form-group">
                                                            <lable class="form-control-label" for="duration">Received by:</lable>
                                                            <?php
															//print_r($Kits);
															?>
                                                            <select class="form-control kitsSelectbox" name="duration" id="Receivedby">
                                                                <option value="">Select Received by :</option>
                                                            <option value="658 Ashfa Ahmed">658 / Ashfa Ahmed</option>
                                                            <option value="4636 Asad Ali">4636 / Asad Ali</option>
                                                            <option value="1611 Abid Ali">1611 / Abid Ali</option>
                                                                <option value="211 Rizwan Akbar">211 / Rizwan Akbar</option>
                                                            </select>
                                                        </div>
                                                        </div> -->
													<div class="col-md-2">
														<label>Entry Date :</label>
														<div class="form-group-inline">
															<input name="date" id="issuedate" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
														</div>
													</div>



													<div id="westageDesc" style="display:block" class="col-md-2">
														<div class="form-group">
															<lable class="form-control-label " for="duration">Westage Description:</lable>
															<br>
															<select id="westageCons" type="text" value="0" class="form-control mySelectMatProEdit" data-live-search="true" searchable="Search here..">
																<option value="Printed Strips">Printed Strips</option>
																<!-- <option value="Printing">Printing</option> -->
																<option value="Quality Issue">Quality Issue</option>
																<option value="White Wastage">White Wastage</option>
																<!-- <option value="Test PO">Test PO</option> -->
																<option value="Red Tape">Red Tape</option>

															</select>
														</div>
													</div>

													<div class="col-md-2">
														<label style="background-color: #fff; color: #fff;">Schedule End Date</label>
														<div class="form-group-inline">
															<button class="btn btn-primary" id="kitsdata">Save</button>
														</div>
													</div>



												</div>






												<br><br>
												<div class="row">
													<div class="col-md-3">
														<label>Start Date :</label>
														<div class="form-group-inline">

															<input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>" onchange="loadWastageData()">
														</div>
													</div>
													<div class="col-md-3">
														<label>End Date</label>
														<div class="form-group-inline">

															<input name="date" id="date2" class="form-control" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" type="date" value="<?php echo $CurrentDate; ?>" onchange="loadWastageData()">
														</div>
													</div>

													<div class="form-group">
														<!-- <lable class="form-control-label" for="duration">Label Type:</lable> -->

														
													</div>

													<!-- <div class="col-md-3">
                                                        <label>Filter by Month</label>
                                                        <div class="form-group-inline">

                                                            <input name="date" id="date3" class="form-control" placeholder="YYYY-MM" required pattern="[0-9]{4}-[0-9]{2}" type="month" value="<?php echo $CurrentMonth; ?>" onchange="loadWastageDataagainstmonth()">
                                                        </div>
                                                    </div> -->
													<!-- <div class="col-md-3">
                                                            <label class="form-control-label">Audit Month:</label>
                                                            <select class="form-control kitsSelectbox" name="AuditID" id="Auditsecond" onchange="loadMonth()">
                                                                <option value="">Select Audit Month</option>
                                                            </select>
                                                    </div> -->
												</div>
												<br><br>



												<div class="row">
													<div style="display: none;" class="col-md-2">
														<div class="form-group-inline">
															<button class="btn btn-primary" onclick="loadWestageByGroup()">Check Westage</button>

														</div>
													</div>





												</div>


												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive-lg" id="kitsWastage">


														</div>
													</div>
												</div>



												<!-- <div class="row mb-3">
													<div id="getPrint" style="display:none" class="col-md-2">
														<div class="form-group-inline">
															<button class="btn btn-warning" onclick="printContent()">Take a Print</button>

														</div>
													</div>





												</div>

												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive-lg" id="labelingWestage">


														</div>
													</div>
												</div> -->


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
			// $this->load->view('after-main');
			?>


			<script>
				let IDs;
				let AuditID;
				let AuditMonth;

				function getAudData() {
					// alert('here');

					url = "<?php echo base_url('Westage/getAuditID') ?>";

					$.get(url, function(res) {
						data = res; // Use the response directly since it's an array
						// alert(JSON.stringify(data)); // Use JSON.stringify to inspect the array

						options = "<option value=''>Select Audit Month </option>";
						for (i = 0; i < data.length; i++) {
							options += '<option value="' + data[i]['AuditMonth'] + '|' + data[i]['TID'] + '">' + data[i]['AuditMonth'] + '</option>';
						}
						$("#Audit").html(options);
						$("#Auditsecond").html(options);
						$("#Audit").change(function() {
							let Value = $(this).val();
							let newval = Value.split('|');
							let nameMonth = newval[0]
							IDs = newval[1];
							// console.log(IDs)

						})
						$("#Auditsecond").change(function() {
							let newValue = $(this).val();
							let newvalone = newValue.split('|');
							AuditMonth = newvalone[0]
							AuditID = newvalone[1];
							// console.log(AuditID)
							// console.log(AuditMonth)

						})
					});
				}



				$("#customSwitch2").change(function(e) {

				});
				$(document).ready(function() {

					// loadData();
					getAudData();
					$("#date1").change(function(e) {
						//alert('Heloo');
						// loadPO()
						loadData()
					});
					$("#date2").change(function(e) {
						//alert('Heloo');
						// loadPO()
						loadData()
					});
					$("#Kits").change(function(e) {
						//alert('Heloo');
						var PoCode = $("#PoCode").val();
						//alert(PoCode);
						url = "<?php echo base_url("/json_by_machine/") ?>" + PoCode

						$.get(url, function(data) {
							html = data[0].OrderQty

							// console.log(html);
							$("#pquantity").val(html)
						});
						loadbalance()
					});


					function loadData() {
						//alert('Heloo');
						var date1 = $("#date1").val()
						var date2 = $("#date2").val()
						url = "<?php echo base_url("index.php/Westage/getkitsissuance/") ?>" + date1 + "/" + date2
						// alert(url);
						$.get(url, function(data) {
							console.log(data);
							$("#kitsissuance").html(data)
						});
					}

					function loadbalance() {
						//alert('I am here');
						var Kits = $("#Kits").val()
						url = "<?php echo base_url("index.php/Westage/json_by_machine_balance/") ?>" + Kits
						//alert(url);       
						$.get(url, function(data) {
							html = data[0].AvailableBalance

							// console.log(html);


							$("#Balance").val(html)
						});
					}

					$('.kitsSelectbox').select2({
						dropdownParent: $('#Kitsname')
					});
					$('#searchdata').click(function() {

						//var PO = $("#PoCode").val();

						var KitsiD = $("#Kits").val();
						var pquantity = parseInt($("#pquantity").val());
						var issuedate = $('#issuedate').val();
						var westage = parseInt($("#Westage").val());
						var Balance = parseInt($("#powisebalance").val());

						var Order = parseInt($("#POQty").val());

						var WestageDesc = $("#westageCons").val();



						console.log(typeof pquantity, typeof Balance);
						var Status
						if ($('#customSwitch2').is(":checked")) {
							Status = 1;
						} else {
							Status = 0;
						}

						// console.log("balance", Balance);
						// console.log("quantity", pquantity)



						console.log(Balance < pquantity);
						if (Order < pquantity) {
							alert("Order Quantity is Greater then Balance")
						} else {
							if (Balance < pquantity) {

								alert("Kits Quantity is Greater then Balance")
							} else {

								if (PO == null) {
									alert("Please select PO Code")
								} else if (KitsiD == null) {
									alert("Please select Kit")
								} else if (issuedate == null) {
									alert("Please select PO issue date")
								} else {
									url = "<?php echo base_url('index.php/Westage/insert_data/') ?>" + "/" + KitsiD + "/" + pquantity + "/" + issuedate + "/" + westage + "/" + Status + "/" + WestageDesc
									//alert("insertion Call");

									$.post(url, function(data) {
										alert("Kit Added Successfully!");
										// console.log(data)
										//getPowisebalance(PO);
										loadData();
										loadbalance()
										//loadPO()
									})
								}
							}
						}


						//  alert(PO);
						//  alert(KitsiD);
						//  alert(pquantity);
						//  alert(issuedate);
						//  alert(westage);
						// setInterval('location.reload(true);', 3000);


					});


				});





				$("#kitsdata").on("click", function() {
					let kits = $("#Kits").val();
					let Westage = $("#Westage").val();
					let issuedate = $("#issuedate").val();
					let westageCons = $("#westageCons").val();
					let auditID = IDs;

					if (!auditID) {
						alert("Please select audit month.");
						return true;
					}
					if (!kits) {
						alert("Please select a kit.");
						return true;
					}

					if (parseFloat(Westage) === 0) {
						alert("Westage value cannot be zero.");
						return;
					}



					let data = {
						"kits": kits,
						"Westage": Westage,
						"issuedate": issuedate,
						"westageCons": westageCons,
						"auditID": auditID
					};

					// console.log("data", data);return true;
					let url3 = "<?php echo base_url('Westage/insertWastage') ?>";

					$.post(url3, data, function(data) {
							if (data) {
								// Success callback function
								alert("Data added successfully");

								// Reset form fields if needed
								$("#Westage").val('');
								// $("#Audit").val('');
								// $("#Audit").val(auditID);
								loadcurrentID(auditID);
								location.reload();
							}

							// let table = '';
							// table += `
							//     <table class="table table-striped table-hover table-sm" id="tableExport">
							//         <thead style="background-color:black; color:white;">
							//             <tr>
							//                 <th>Kit Name</th>
							//                 <th>Wastage</th>
							//                 <th>Wastage Description</th>
							//                 <th>Entry Date</th>
							//             </tr>
							//         </thead>
							//         <tbody>
							// `;

							// let totalWastage = 0; // Initialize total variable

							// response.forEach((item, index) => {
							//     table += `
							//         <tr>
							//             <td>${item.SerialNo}</td>
							//             <td>${item.Wastage}</td>
							//             <td>${item.westage_description}</td>
							//             <td>${item.IssuanceDate}</td>
							//         </tr>
							//     `;

							//     totalWastage += parseFloat(item.Wastage); // Accumulate total wastage
							// });

							// // Append total row outside the loop
							// table += `
							//     <tr>
							//         <td>Total:</td>
							//         <td>${totalWastage}</td>
							//         <td></td>
							//         <td></td>
							//     </tr>
							// `;

							// table += `</tbody></table>`;
							// $("#kitsWastage").append(table); // Use html() instead of append()

							// // Initialize DataTables
							// $('#tableExport').dataTable({
							//     responsive: false,
							//     lengthChange: false,
							//     dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
							//         "<'row'<'col-sm-12'tr>>" +
							//         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							//     buttons: [
							//         {
							//             extend: 'pdfHtml5',
							//             text: 'PDF',
							//             titleAttr: 'Generate PDF',
							//             className: 'btn-outline-danger btn-sm mr-1'
							//         },
							//         {
							//             extend: 'excelHtml5',
							//             text: 'Excel',
							//             titleAttr: 'Generate Excel',
							//             className: 'btn-outline-success btn-sm mr-1'
							//         },
							//         {
							//             extend: 'csvHtml5',
							//             text: 'CSV',
							//             titleAttr: 'Generate CSV',
							//             className: 'btn-outline-primary btn-sm mr-1'
							//         },
							//         {
							//             extend: 'copyHtml5',
							//             text: 'Copy',
							//             titleAttr: 'Copy to clipboard',
							//             className: 'btn-outline-primary btn-sm mr-1'
							//         },
							//         {
							//             extend: 'print',
							//             text: 'Print',
							//             titleAttr: 'Print Table',
							//             className: 'btn-outline-primary btn-sm'
							//         }
							//     ]
							// });

							// Success callback function
							alert("Data added successfully");

							// Reset form fields if needed
							$("#Westage").val('');
							// $("#Audit").val('');
							// $("#Audit").val(auditID);
							loadcurrentID(auditID);
							location.reload();

							// Additional code if needed
							// For example, you may reload the page or update other UI elements.
							// location.reload();
						})
						.fail(function() {
							// Error callback function
							alert("Error Westage cannot be added. Try again later.");
						});
				});




				function loadcurrentID(auditID) {


					let data = {
						"auditID": auditID
					};
					// alert(auditID)

					let url9 = "<?php echo base_url('Westage/loadwastagemonth') ?>";
					
					$.post(url9, data, function(data) {
						let table = '';
						table += `
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
                        `;

						let totalWastage = 0; // Initialize total variable

						data.forEach((item, index) => {
							table += `
                                <tr>
                                    <td>${item.SerialNo}</td>
                                    <td>${item.Wastage}</td>
                                    <td>${item.westage_description}</td>
                                    <td>${item.IssuanceDate}</td>
                                </tr>
                            `;

							totalWastage += parseFloat(item.Wastage); // Accumulate total wastage
						});

						// Append total row outside the loop
						table += `
                            <tr>
                                <td>Total:</td>
                                <td>${totalWastage}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        `;

						table += `</tbody></table>`;
						// $('#tableExport').DataTable().destroy();
						$("#kitsWastage").html(table); // Use html() instead of append()

						// Initialize DataTables
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

						// Success callback function
						// alert("Data added successfully");

						// Reset form fields if needed
						$("#Westage").val('');
						// $("#Audit").val('');
						// $("#Audit").val(auditID);

						// Additional code if needed
						// For example, you may reload the page or update other UI elements.
						// location.reload();
					})
				}



				function printContent() {
					// Get the content to print by its ID
					var content = document.getElementById('contentToPrint').innerHTML;

					// Create a new window to print the content
					var printWindow = window.open('', '_blank');

					// Write the content to the new window
					printWindow.document.open();
					printWindow.document.write('<html><head><title>Printed Content</title></head><body>' + content + '</body></html>');
					printWindow.document.close();

					// Print the content
					printWindow.print();
				}




				async function loadWestageByGroup () {

					let audi = $("#Audit").val();

					$("#labelingWestage").html('');

					let html1 = '';

					var totalWestKitsCount = 0;

					let kitNameCount = 0;

					let kitNameCount1 = 0;

					let kitName1 = '';

					let kitName2 = '';

					let lastKitName1 = '';

					let lastKitName2 = '';
					let GrandTotal = 0;

					var TotalRollQty = 0;
					var TotalInkRibbonQty = 0;

					let totalWastage = 0; // Initialize total variable
					let totalWastageRedtape = 0; // Initialize total variable
					let totalWastageMissPrintIssue = 0;
					let totalWastagePrinting = 0; // Initialize total variable
					let totalWastageQualityIssue = 0; // Initialize total variable
					let totalWastageWhiteWastage = 0; // Initialize total variable
					let totalWastageTestPO = 0; // Initialize total variable

					let totalWestKitsURLD = "<?php echo base_url('Westage/loadWastageAuditD') ?>";

					data = {
						"AuditID": IDs
					};



					let urlR = "<?php echo base_url('Westage/loadWastageAuditRollAndRibbon') ?>";



					await $.post(urlR, data, function(data1) {

						data1.forEach(element1 => {
							totalWestKitsCount = totalWestKitsCount + 1

							TotalRollQty = parseInt(TotalRollQty) + parseInt(element1.RollQty);
							TotalInkRibbonQty = parseInt(TotalInkRibbonQty) + parseInt(element1.InkRibbonQty);
							
						});

						console.log('Inner Roll Qty', TotalRollQty);
						console.log('inner Ink Ribbon ', TotalInkRibbonQty);
						
					});



					// 					$.post(totalWestKitsURLD, data, function(data1) {

					// 						console.log("Total Westage Data d", data1);

					// if(data1[0].KitName === 'PAK-BST25'){
					// 	kitName2 = data1[0].SerialNo;
					// 	console.log("Kit Name D 2", kitName2);
					// }



					// 					})



					let totalWestKitsURL = "<?php echo base_url('Westage/loadWastageAudit1') ?>";

					data = {
						"AuditID": IDs
					};


					await $.post(totalWestKitsURL, data, function(data) {

						

						// console.log("Total Westage Data", data);

						// if (data[0].KitName === 'PAK-PS325S') {
						// 	kitName1 = data[0].SerialNo;
						// }


						// if (data[0].KitName == 'PAK-BST25') {
						// 	kitName2 = data[0].SerialNo;

						// 	console.log("Inner KitName 2", data);
						// }


						data.forEach(element => {
						

							if (element.KitName === 'PAK-PS325S') {
								kitNameCount = kitNameCount + 1;
								lastKitName1 = element.SerialNo
							};

							if (element.KitName == 'PAK-BST25') {
								kitNameCount1 = kitNameCount1 + 1;
								lastKitName2 = element.SerialNo
							};



							if (element.westage_description == 'Red Tape') {
								totalWastageRedtape += parseFloat(element.Wastage)
							}
							// if (element.westage_description == 'Printing') {
							// 	totalWastagePrinting += parseFloat(element.Wastage)
							// }
							// alert(element.westage_description == 'Misprint');


							if (element.westage_description == 'Misprint') {
								totalWastageMissPrintIssue += parseFloat(element.Wastage)
							}
							if (element.westage_description == 'Quality Issue') {
								totalWastageQualityIssue += parseFloat(element.Wastage)
							}
							if (element.westage_description == 'White Wastage') {
								totalWastageWhiteWastage += parseFloat(element.Wastage)
							}
							if (element.westage_description == 'Printed Strips') {
								totalWastageTestPO += parseFloat(element.Wastage)
							}
							totalWastage += parseFloat(element.Wastage); // Accumulate total wastage


						});


						console.log('Outer Roll Qty', TotalRollQty);
						console.log('Outer Ink Ribbon ', TotalInkRibbonQty);

						// alert(totalWastageMissPrintIssue);


						GrandTotal = GrandTotal + totalWastage + totalWastageRedtape + totalWastageQualityIssue + totalWastageWhiteWastage + totalWastageTestPO + totalWastageMissPrintIssue

						html1 += `
									<head>
									<meta charset="UTF-8">
									<meta name="viewport" content="width=device-width, initial-scale=1.0">
									<title>Document</title>
									<style>
										table {
										border-collapse: collapse;
										border-spacing: 0;
										width: 100%;
										border: 1px solid #ddd;
										}
										th, td {
										text-align: left;
										padding: 8px;
										}
										</style>
								</head>
									<body style="height: 800px">
								<div id="contentToPrint"  style="overflow-x:auto; width:100%; height: 100vh">
									<table>
									<tr>
									<td style="font-size:18px;"><span><img width='%' heig60ht='100vh' src='http://10.10.100.4:2000/labeling/assets/img/ForwardLogo.png' /></span></td>
										<td colspan="2" style="font-size:25px;"><span><b>Forward Sport Pvt.Ltd</b></span></td>
										<td colspan="2" style="font-size:25px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;
										<span><b>Date:</b> ${audi.slice(0,13)}</span></td>
									</tr>

									<tr>
									<td colspan='2' style="font-size:22px;"><br><br><br><br><br></td>
									<td colspan='2' style="font-size:22px;"><br><br><br><br></td>
									<td></td>
									</tr>
									
									<tr>
										<td style="border: 1px solid #000; padding:5px" colspan="1"><span style="font-size:24px;"><b>Total Kits used in this Audit:</b>${totalWestKitsCount ? totalWestKitsCount : 0}</span></td>
										<td style="border: 1px solid #000;font-size:22px;text-align:center"  colspan="1"><b>Pieces</b></td>
									<td style="border: 1px solid #000;font-size:22px; padding:5px; text-align:center" ><b>Grams</b></td>
									<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"></td>
									<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center" ><b>Pieces</b></td>
									<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center" ><b>Grams</b></td>

										</tr>
								
									<tr>
									<td style="border: 1px solid #000;font-size:22px; padding:5px"><span class="badge badge-info"><b> Red Tape + Printed Strips:</b></span></td>

									<td style="border: 1px solid #000; font-size: 22px; padding: 5px;text-align:center">
    <span>${parseFloat(totalWastageRedtape) + parseFloat(totalWastageTestPO) + '.00'}</span>
</td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;"><span class="badge badge-info"><b>Quality Issue:</b></span></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"><span>${totalWastageQualityIssue.toFixed(2)}</span></td>

										<td style="border: 1px solid #000;font-size:22px;"></td>
										<td></td>
										<td></td>

									</tr>
									<tr>
									<td style="border: 1px solid #000;font-size:22px; padding:5px"><span class="badge badge-info"><b>White Wastage:</b></span></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"><span>${totalWastageWhiteWastage.toFixed(2)}</span></td>
										
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;"><span class="badge badge-info"><b>Ink Ribbon Core:</b></span></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"><span>${TotalInkRibbonQty.toFixed(2)}</span></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"></td>
										<td></td>
										<td></td>

									</tr>

									<tr>
									<td style="border: 1px solid #000;font-size:22px; padding:5px"><span class="badge badge-info"><b>Base Roll Qty:</b></span></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"><span>${TotalRollQty.toFixed(2)}</span></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px"></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px"></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px"></td>
										<td style="border: 1px solid #000;font-size:22px; padding:5px"></td>
										<td></td>
										<td></td>

									</tr>

									
									<tr>
									
									<td style="font-size:22px; padding:5px"><span><b><u>Wastage Grand Total:</u></b></span></td>
										<td style="font-size:22px; "><span><u>${totalWastage.toFixed(2)}</u></span></td>
										<td ></td>
										<td></td>
										<td></td>

									</tr>
									<tr>
									<td colspan='2' style="font-size:22px;"></td>
									<td colspan='2' style="font-size:22px;"></td>
									<td></td>
									</tr>
									
								
									<tr>
									<td colspan='2' style="font-size:22px;"><br><br><br><br><br></td>
									<td colspan='2' style="font-size:22px;"><br><br><br><br></td>
									<td></td>
									</tr>
									

									<tr>
									<td colspan='2' style="font-size:22px;"><span><b>_______________________________</b></span></td>
									<td colspan='2' style="font-size:22px;"><span><b>________________________________</b></span></td>
									<td></td>
									</tr>

							

									<tr>
									<td colspan='2' style="font-size:22px;"><span><b>ENGINEER SIGNATURE</b></span></td>
									<td colspan='2' style="font-size:22px;"><span><b>HOD SIGNATURE </b></span></td>
									<td></td>
									</tr>
									
									</table>
								</div>
									</body>

									`



						// $("#labelingWestage").html(html1);

					})

				}

				// <tr>
				// 		<td><span class="badge badge-info"><b>Total Miss Print Wastage:</b> ${totalWastageMissPrintIssue.toFixed(2)}</span>
				// 		<span class="badge badge-info"><b>Total Redtape Wastage:</b>${totalWastageRedtape.toFixed(2)}</span>
				// 		</td>
				// 		<td>
				// 		<span class="badge badge-info"><b>Total Printing Wastage:</b> ${totalWastagePrinting.toFixed(2)}</span>
				// 		<span class="badge badge-info"><b>Total Quality Issue Wastage:</b> ${totalWastageQualityIssue.toFixed(2)}</span>
				// 		</td>
				// 		<td>
				// 		<span class="badge badge-info"><b>Total White Wastage: </b>${totalWastageWhiteWastage.toFixed(2)}</span>
						
				// 		</td>
				// 		<td><span class="badge badge-info"><b>Total Printed Strips Wastage:</b> ${totalWastageTestPO.toFixed(2)}</span></td>

				// 		</tr>


				function loadMonth() {
					$("#kitsWastage").html(' ');
					let url5 = "<?php echo base_url('Westage/loadWastageAudit1') ?>";

					data = {
						"AuditID": IDs
					};




					$.post(url5, data, function(data) {

						$("#getPrint").css("display", "block");


						let table = '';
						table += `
                     <table class="table table-striped table-hover table-sm" id="tableExport">
                     <thead style="background-color:black; color:white;">
                          <tr>
                        <th>Kit Name</th>
                        <th>Wastage</th>
                        <th>Wastage Description</th>
                        <th>Entry Date</th>
                          </tr>
						  <tr>
						 <td>
						 
						 </td> 
						 <td></td> 
						 <td></td> 
						 <td></td> 

						  </tr>
                      </thead>
                       <tbody>
                       `;

						let totalWastage = 0; // Initialize total variable
						let totalWastageRedtape = 0; // Initialize total variable
						let totalWastagePrinting = 0; // Initialize total variable
						let totalWastageQualityIssue = 0; // Initialize total variable
						let totalWastageWhiteWastage = 0; // Initialize total variable
						let totalWastageTestPO = 0; // Initialize total variable
						let totalWastageMissPrintIssue = 0;

						data.forEach((item, index) => {

							console.log("Check Total Data", item);

							table += `
                        <tr>
                        <td>${item.SerialNo ? item.SerialNo : '' }</td>
                        <td>${item.Wastage}</td>
                        <td>${item.westage_description}</td>
                        <td>${item.IssuanceDate}</td>

                        </tr>
                     `;
							if (item.westage_description == 'Red Tape') {
								totalWastageRedtape += parseFloat(item.Wastage)
							}
							if (item.westage_description == 'Printing') {
								totalWastagePrinting += parseFloat(item.Wastage)
							}
							if (item.westage_description == 'Quality Issue') {
								totalWastageQualityIssue += parseFloat(item.Wastage)
							}
							if (item.westage_description == 'White Wastage') {
								totalWastageWhiteWastage += parseFloat(item.Wastage)
							}
							if (item.westage_description == 'Printed Strips') {
								totalWastageTestPO += parseFloat(item.Wastage)
							}

							
							if (item.westage_description == 'Misprint') {
								totalWastageMissPrintIssue += parseFloat(item.Wastage)
							}
							totalWastage += parseFloat(item.Wastage); // Accumulate total wastage
						});

						// Append total row outside the loop


			
						// 					table += `
						//              <div style="max-width:50%"> <span class="badge badge-info"><b>Total Wastage:</b> ${totalWastage.toFixed(2)}</span> </div>     
						//    <div style="max-width:50%"> <span class="badge badge-info"><b>Total Redtape Wastage:</b>${totalWastageRedtape.toFixed(2)}</span>  </div>
						//    <div style="max-width:50%"> <span class="badge badge-info"><b>Total Printing Wastage: </b>${totalWastagePrinting.toFixed(2)}</span>  </div>
						//    <div style="max-width:50%"> <span class="badge badge-info"><b>Total Quality Issue Wastage:</b> ${totalWastageQualityIssue.toFixed(2)}</span> </div>
						//      <div style="max-width:50%"> <span class="badge badge-info"><b>Total White Wastage:</b> ${totalWastageWhiteWastage.toFixed(2)}</span>  </div>

						// <div style="max-width:50%">  <span class="badge badge-info"><b>Total Test PO Wastage:</b> ${totalWastageTestPO.toFixed(2)}</span>  </div>
						//                     `;

											table += `
					
					</tbody></table>`;
						$("#kitsWastage").html(table);

						// Initialize DataTables
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
					});

					loadWestageByGroup();


				}




				function loadWastageData() {
					$("#kitsWastage").html(' ')
					let url4 = "<?php echo base_url('Westage/loadWastage') ?>"

					let sdate = $("#date1").val()
					let edate = $("#date2").val()


					data = {
						"sdate": sdate,
						"edate": edate

					}
					$.post(url4, data, function(data) {
						console.log(data)

						let table = '';
						table += ` <table class="table table-striped table-hover table-sm" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                               <th>Kit Name</th>
                                                                <th>Wastage</th>
                                                                <th>Wastage Description</th>
                                                                <th>Print Date</th>
                                                              
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
						data.forEach((item, index) => {



							table += `<tr>
                        
                        <td>${item.SerialNo}</td>
                        <td>${item.Wastage}</td>
                        <td>${item.westage_description}</td>
                        <td>${item.IssuanceDate}</td>
                     
                        
                        </tr>`

						})

						table += `</tbody>
                        </table>`

						$("#kitsWastage").append(table)
						$('#tableExport').dataTable({
							responsive: false,
							lengthChange: false,
							dom:
								/*	--- Layout Structure 
									--- Options
									l	-	length changing input control
									f	-	filtering input
									t	-	The table!
									i	-	Table information summary
									p	-	pagination control
									r	-	processing display element
									B	-	buttons
									R	-	ColReorder
									S	-	Select

									--- Markup
									< and >				- div element
									<"class" and >		- div with a class
									<"#id" and >		- div with an ID
									<"#id.class" and >	- div with an ID and a class

									--- Further reading
									https://datatables.net/reference/option/dom
									--------------------------------------
								 */
								"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
								"<'row'<'col-sm-12'tr>>" +
								"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							buttons: [
								/*{
									extend:    'colvis',
									text:      'Column Visibility',
									titleAttr: 'Col visibility',
									className: 'mr-sm-3'
								},*/
								{
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
				}
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