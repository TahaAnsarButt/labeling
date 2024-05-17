<?php
if (!$this->session->has_userdata('user_id')) {
	redirect('login');
} else {
	$this->load->view('header'); ?>

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
				console.log("%c Theme settings loaded", "color: #148f32");
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
				<?php $this->load->view('aside'); ?>
				<!-- END Left Aside -->
				<div class="page-content-wrapper">
					<!-- BEGIN Page Header -->
					<?php $this->load->view('template'); ?>
					<!-- END Page Header -->
					<!-- BEGIN Page Content -->
					<!-- the #js-page-content id is needed for some plugins to initialize -->
					<main id="js-page-content" role="main" class="page-content">
						<?php if ($this->session->flashdata('Proinfo')) { ?>
							<div class="alert alert-danger alert-dismissible show fade" id="msgbox">
								<div class="alert-body">
									<button class="close" data-dismiss="alert">
										<span>&times;</span>
									</button>
									<?php echo $this->session->flashdata(
										'Proinfo'
									); ?>
								</div>
							</div>
						<?php } ?>

						<div>
							<div>
								<br><br>

								<?php
								$Month = date('m');
								$Year = date('Y');
								$Day = date('d');
								$CurrentDate =
									$Year . '-' . $Month . '-' . $Day;
								?>
								<div id="exampleModalEditMat" class="panel">
									<div class="panel-hdr">
										<h2>
											Kits <span class="fw-300"><i>Print</i></span>
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
														<label>Plan Date :</label>
														<div class="form-group-inline">

															<input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>">
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

												<!-- <div class="col-md-2">
													<div class="form-group">
														<lable class="form-control-label" for="duration">Plan Type:</lable>
														
														<select class="form-control" name="duration" id="samLabel">
															
														<option value="Normal">Normal</option>

																<option value="Sample Label">Sample Label</option>
																
														</select>
													</div>
												</div> -->

													
													<!-- <div class="col-md-3">
                                                        <label>End Date</label>
                                                        <div class="form-group-inline">

                                                            <input name="date" id="date2" class="form-control" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" type="date" value="<?php echo $CurrentDate; ?>">
                                                        </div>
                                                    </div> -->
													<div class="col-md-2 mt-4">
														<div class="form-group-inline">

															<button class="btn btn-primary" id="Searchbtn">Search</button>
														</div>
													</div>
												</div>

											</div>
											<br><br>
											<div class="row" id="Kitsname">
												<div class="col-md-2">
													<div class="form-group">
														<lable class="form-control-label" for="duration">Kits Name:</lable>
														<?php
														//print_r($Kits);
														?>

														<select class="form-control kitsSelectbox" name="duration" id="Kits">
															<?php
															foreach ($Kits as $Key) { ?>
																<option value="<?php echo $Key['RecID']; ?>"><?php echo $Key['SerialNo']; ?></option>

															<?php }
															?>
														</select>
													</div>
												</div>


												<div class="col-md-1">
													<label>Balance:</label>
													<div class="form-group-inline">

														<input name="Balance" readonly="readonly" id="Balance" class="form-control" type="text">
													</div>
												</div>
												<!-- 
												<div class="col-md-2">
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
													<label>Print Date :</label>
													<div class="form-group-inline">

														<input name="date" id="issuedate" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
													</div>
												</div>
												<div class="col-md-2" >
													<div class="form-group-inline">
														<button class="btn btn-primary mt-4" id="searchdata">Save</button>
													</div>
												</div>


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
											<div class="col-md-7">
												<div class="col-md-3 ">
													<div style="display:none" class="btn btn-warning  submit-button mb-2">Print Selected</div>
												</div>
											</div>
											<!-- <div class="col-md-7">
												<div class="col-md-3 ">
													<div style="display:none" class="btn btn-danger  email-button mb-2">Send Email</div>
												</div>
											</div> -->
											<div id="poSelectbox">


											</div>

										</div>




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

					</main>
				</div>
			</div>
		</div>

		</div>
		<?php $this->load->view('after-main'); ?>


		<script>
			$("#customSwitch2").change(function(e) {

			});
			let a = ''
			$(document).ready(function() {

				loadData()
				//loadbalance()
				$("#date1").change(function(e) {
					//alert('Heloo');
					loadPO()
				});
				// $("#date2").change(function(e) {
				//     //alert('Heloo');
				//     loadPO()
				//     loadData()
				// });
				$("#Kits").change(function(e) {
					//alert('Heloo');
					var PoCode = $("#PoCode").val();
					// alert(PoCode);
					url = "<?php echo base_url(
								'/json_by_machine/'
							); ?>" + PoCode

					$.get(url, function(data) {
						html = data[0].OrderQty

						console.log(html);
						$("#pquantity").val(html)
					});
					loadbalance()
				});
				$('#Searchbtn').click(function() {
					// alert("heloo");
					loadPO()
					loadData()
				});


				function loadData() {
					//alert('Heloo');
					var date1 = $("#date1").val()
					var date2 = $("#date2").val()
					url = "<?php echo base_url(
								'index.php/Kitsissuance/getkitsissuance/'
							); ?>" + date1 + "/" + date2
					// alert(url);
					$.get(url, function(data) {
						console.log(data);
						$("#kitsissuance").html(data)
					});
				}
				var balance;
				var IssueQty;

				function loadbalance() {
					//alert('I am here');
					var Kits = $("#Kits").val()

					url = "<?php echo base_url(
								'index.php/Kitsissuance/json_by_machine_balance/'
							); ?>" + Kits
					//alert(url);       
					$.get(url, function(data) {
						console.log("data", data)
						html = data[0].AvailableBalance
						balance = html;
						IssueQty = data[0].IssueQty

						console.log(":Check", IssueQty);


						// html = 44980;
						//console.log(html);
						if (parseInt(html) < 0) {
							alert("Sorry You can't add this Kit because Balance is less than Zero")
							$("#Balance").val(' ')
							return false
						} else {
							$("#Balance").val(html)
						}



					});
				}


				//  $('#checkAllKits').click(function () {    
				//      $('input:checkbox').prop('checked', this.checked);    
				//  });


				kits = []
				balance = []
				manual = []

				$('#poSelectbox').on('click', '#select-all', function(e) {
					$(".submit-button").css('display', 'block')
					// $(".email-button").css('display', 'block')

					checked = $('#select-all:checked').val()
					if (checked) {
						$('.kit_id').prop('checked', true)

					} else {
						$('.kit_id').prop('checked', false)


					}

				})
				$(".submit-button").on("click", function() {
					var selectedPlanType = $('input[name="checkbox"]:checked').data('plan-type');
					kits = []
					balance = []
					manual = []
					kitsName = $(".kitsSelectbox").val()
					printDate = $("#issuedate").val()
					pdate = $("#date1").val()
					if (kitsName.length === 0) {
						alert("Please select Kit");
					} else {

						$('input[name="checkbox"]:checked').each(function() {

							var currentRow = $(this).closest("tr");
							//var col1=currentRow.find("td:eq(4)").html(); // get current row 1st TD value
							emanual = currentRow.find("td:eq(5) input[type='text']").val();
							blnce = $(`#eBalance${this.value}`).text();
							console.log("Data", emanual);


							kits_id = this.value
							kits.push(this.value);
							balance.push(blnce);
							if (emanual != '') {
								manual.push(emanual);
							}



						});
					}
					//console.log(kits)
					urlL = '<?php echo base_url('Kitsissuance/insertionAllKits') ?>'
					if (typeof manual !== 'undefined' && manual.length === 0) {

						$.post(urlL, {
							"mbalance": balance,
							"kits": kits,
							"kitsName": kitsName,
							"printDate": printDate,
							"pdate": pdate,
							"PlanType": selectedPlanType
						}, function(data) {

							loadPO()
							currentBalance()
							// alert(selectedPlanType)
							alert("Kit Issued Successfully!")
						}).fail(function() {
							alert("Print Quantity is Greater Then Kits Balance");
						})

					} else {
						$.post(urlL, {
							"mbalance": manual,
							"kits": kits,
							"kitsName": kitsName,
							"printDate": printDate,
							"pdate": pdate,
							"PlanType": selectedPlanType

						}, function(data) {

							loadPO()
							currentBalance()
							// alert(selectedPlanType)
							alert("Kit Issued Date Updated Successfully!")
						}).fail(function() {
							alert("Print Quantity is Greater Then Kits Balance");
						})
					}



				})

				function currentBalance() {

					var Kits = $("#Kits").val()

					url = "<?php echo base_url(
								'index.php/Kitsissuance/json_by_machine_balance/'
							); ?>" + Kits
					//alert(url);       
					$.get(url, function(data) {
						console.log("data", data)
						html = data[0].AvailableBalance
						// html = 44980;
						//console.log(html);
						if (parseInt(html) < 0) {
							alert("Sorry You can't add this Kit because Balance is less than Zero")
							$("#Balance").val('')
							return false
						} else {
							$("#Balance").val(html)
							a = data[0].AvailableBalance

						}



					});
				}


				function loadPO() {
					//alert('Heloo');
					$("#poSelectbox").html(' ')
					var date1 = $("#date1").val()
					var date2 = $("#date2").val()
					var fc = $("#fc").val()

				    

					// var samLabel = $("#samLabel").val()

					
					url = "<?php echo base_url('index.php/Kitsissuance/getPO/'); ?>" + date1 + "/" + date1 + "/" + fc 
					$.get(url, function(data) {
						// console.log(data)
						//  $("#poSelectbox").html(data)

						table = ''
						table += `
                        <div class="row">
							<table class="table table-striped table-hover table-sm" id="PowiseDatatabel">
								<thead>
									<tr>
										<th>  
											<div class=" custom-control custom-checkbox no-sort">
												<input class="custom-control-input" type="checkbox" id="select-all">
												<label for="select-all" class="custom-control-label"></label>
											</div>
										</th>
										<th>Plan Date</th>
										<th>PO Code</th>
										<th>Factory Code</th>
										<th>Quantity</th>
										<th>Manual Quantity</th>
										<th>PlanType</th>
										<th>Balance</th>
										<!--<th>Action</th>-->

											
									</tr>
								</thead>
								<tbody >`;

						data['getPO'].forEach(e => {
							table += ` 
							<tr>
								<td>
									<input class="kit_id"  type="checkbox" name="checkbox" id="select${e.PO}" value="${e.PO}" data-plan-type="${e.PlanType}" onchange="showDate()" />
									<label for="select${e.PO}"></label>
								</td>    
								<td>${e.PlanDate}</td>
								<td id="ePoCOde${e.PO}">${e.POCode}</td>
								<td>${e.FactoryCode}</td>
								<td>${e.OrderQty}</td>
								<td><input name="POQty" id="ManualQty${e.PO}" value="" class="form-control col-md-4" type="text"></td>

								<td><span class="badge badge-info">${e.PlanType}</span></td>

								<input name="POQty" Class="OrderQty" hidden id="OrderQty${e.PO}"  value="${e.OrderQty}" type="text">

								<input name="POQty" hidden id="PData${e.PO}"  value="${e.PlanDate}" type="text">

								<input name="POQty" hidden id="POBalance${e.PO}"  value="${e.Balance}" type="text"></input></td>

								<td id="eBalance${e.PO}">${e.Balance}</td>

								<!--<td>   <button class="btn btn-primary btn-xs printbtn" id="btn.${e.PO}" >Print</button></td>-->
								<input name="POQty" hidden id="PData${e.PO}"  value="${e.PlanDate}" type="text">
							</tr>`
						})

						table += ` </tbody>
                                    
                                    </table>`
						$("#poSelectbox").append(table);

						$(".printbtn").click(function(e) {
							var PlanType = $('input[name="checkbox"]:checked').data('plan-type');

							//alert("i am Here");
							let id = this.id;
							//alert(id);
							alert(id);
							let split_value = id.split(".");
							//console.log(split_value);
							var PO = split_value[1];


							var OrderQty = $(`#OrderQty${PO}`).val();
							var manual = $(`#ManualQty${PO}`).val();
							var Balance = $(`#POBalance${PO}`).val();
							var PData = $(`#PData${PO}`).val();


							var KitsiD = $("#Kits").val();
							if (manual.length === 0) {
								pquantity = Balance;
							} else {
								pquantity = manual;
							}
							var issuedate = $('#issuedate').val();
							//    alert(OrderQty)
							//    alert(pquantity)
							if (pquantity >>> OrderQty) {
								alert("Order Quantity is Greater then Balance")
							} else {
								if (pquantity >>> Balance) {

									alert("Kits Quantity is Greater then Balance")
								} else {

									if (PO.length === 0) {
										alert("Please select PO Code")
									} else if (KitsiD.length === 0) {
										alert("Please select Kit")
									} else if (issuedate.length === 0) {
										alert("Please select PO issue date")
									} else {
										url = "<?php echo base_url(
													'index.php/kitsissuance/insert_data/'
												); ?>"
										//alert("insertion Call");

										$.post(url, {
											"PO": PO,
											"pquantity": pquantity,
											"issuedate": issuedate,
											"PData": PData,
											"KitsiD": KitsiD,
											"PlanType": PlanType
										}, function(data) {

											//console.log(data)
											// getPowisebalance(PO);
											//loadData();
											loadbalance()
											loadPO()
										})
									}
								}
							}

							//var Order = Balance;
							//alert(PO);
							// alert(PO);
							// alert(KitsiD);
							// alert(issuedate);
							//alert(Balance);
							// $("#printbtn").change(function(e) {
							//                     alert('Heloo');
							// var PoCode = $("#PoCode").val();
							// //alert(PoCode);
							// url = "<?php echo base_url(
											'/json_by_machine/'
										); ?>" + PoCode

							// $.get(url, function(data) {
							//     html = data[0].OrderQty

							//     console.log(html);
							//     $("#pquantity").val(html)
							// });
							// loadbalance()
						});


						$('#PowiseDatatabel').dataTable({

							responsive: false,
							lengthChange: false,
							dom:

								"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
								"<'row'<'col-sm-12'tr>>" +
								"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
							buttons: [

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
					});
				}

				function getPowisebalance(PO) {

					url = "<?php echo base_url(
								'index.php/Kitsissuance/json_by_machine/'
							); ?>" + PO
					$.get(url, function(data) {
						balance = data[0].Balance
						$("#powisebalance").val(Math.abs(balance));
					});
				}

				$('.kitsSelectbox').select2({
					dropdownParent: $('#Kitsname')
				});
				$('#searchdata').click(function() {
					var PlanType = $('input[name="checkbox"]:checked').data('plan-type');

					var planDate = $("#date1").val();
					// var PO = $("#PoCode").val('');

					var KitsiD = $("#Kits").val();
					var pquantity = $("#pquantity").val();
					var issuedate = $('#issuedate').val();
					var westage = parseInt($("#Westage").val());
					var Balance = parseInt($("#powisebalance").val());
					// alert(Balance);
					// alert(pquantity);
					var receivedBy = $('#Receivedby').val();


					var Order = parseInt($("#powisebalance").val());
					// if (westage > 0) {
					// 	var WestageDesc = $("#westageCons").val();

					// } else {
					// 	var WestageDesc = "NoWestage";

					// }

					var Status
					if ($('#customSwitch2').is(":checked")) {
						Status = 1;
					} else {
						Status = 0;
					}

					if (parseInt(Order) < parseInt(pquantity)) {
						alert("Order Quantity is Greater then Balance");
					} else {
						if (parseInt(Balance) < parseInt(pquantity)) {

							alert("Kits Quantity is Greater then Balance");
						} else {

							if (KitsiD == null) {
								alert("Please select Kit");
							} else if (issuedate == null) {
								alert("Please select PO print date");
							} else {
								url = "<?php echo base_url('index.php/kitsissuance/insert_data/'); ?>"
								//alert("insertion Call");

								$.post(url, data = {
									// "PO": PO,
									"PlanDate": planDate,
									"KitsiD": KitsiD,
									"pquantity": IssueQty,
									"issuedate": issuedate

								}, function(data) {
									// alert(PlanType);
									alert("Kit Added Successfully!");
									console.log(data)
									getPowisebalance(PO);
									location.reload();
									// loadData();
									// loadbalance()
									// loadPO()
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


			function westageChange() {

				if ($("#Westage").val() > 0) {
					$("#westageDesc").css("display", "block")

				} else {
					$("#westageDesc").css("display", "none")
				}



			}
		</script>
		<script>
			function showDate() {
				$(".submit-button").css('display', 'block')
				// $(".email-button").css('display', 'block')

			}
		</script>

		<?php $this->load->view('Foter'); ?>
	</body>

	</html>
<?php
}

?>
