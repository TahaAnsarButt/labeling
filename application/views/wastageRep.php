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

						$Month = date('m');
						$Year = date('Y');
						$Day = date('d');
						$CurrentDate = $Year . '-' . $Month . '-' . $Day;
						?>

						<div id="exampleModalEditMat" class="panel">



							<div class="panel-hdr">
								<h2>
									Wastage <span class="fw-300"><i>Reports</i></span>
								</h2>
								<div class="panel-toolbar">
									<button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
									<button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
									<button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
								</div>
							</div>

							<div class="panel-container show">
								<div class="panel-content">

									<ul class="nav nav-pills" role="tablist">


										<li class="nav-item"><a class="nav-link  active" data-toggle="tab" href="#tab_direction-1">Wastage Detail</a></li>
										<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_direction-2">Wastage Summary</a></li>


									</ul>


									<div class="tab-content py-3">


										<div class="tab-pane fade show active" id="tab_direction-1" role="tabpanel">

											<div class="row">
												<div class="col-md-3">
													<div class="form-group">

														<label class="form-control-label">Select Audit Period:</label><br>


														<div class="row">
															<div class="col-md-6">
																<input type="radio" id="radioMonth" name="auditPeriod" value="month" onchange="monthrad()" checked>
																<label for="radioMonth">Audit Month</label>
															</div>
															<div class="col-md-6">

																<input type="radio" id="radioYear" name="auditPeriod" onchange="yearrad()" value="year">
																<label for="radioYear">Month And Year</label>
															</div>
														</div>







													</div>
												</div>
											</div>

											<div class="row mt-3">


												<div class="col-md-3">
													<div class="form-group">
														<label class="form-control-label">Audit Month:</label>
														<select class="form-control kitsSelectbox" name="Audit1" id="Audit1" required="true">
															<?php foreach ($getAuditID as $key => $value) {
															?>
																<option value="<?php echo $value['AuditMonth'] ?>"><?php echo $value['AuditMonth'] ?></option>
															<?php } ?>
														</select>
													</div>
												</div>



												<div style="display: none;" id="yearstatus" class="col-md-3">
													<div class="form-group">
														<label class="form-control-label">Select Month:</label>
														<input type="month" id="monthId" class="form-control" />
													</div>
												</div>




												<div class="col-md-3">


													<div class="col-md-2">
														<div class="form-group-inline">
															<button class="btn btn-primary mt-4" id="searchDataDetail">Search</button>
														</div>
													</div>

												</div>

											</div>


											<div class="row">

												<div class="col-md-12">



													<div id="wastageDetailHtml"></div>


												</div>
											</div>

											<div class="row mt-3">
												<div class="col-md-12">
													<div id="wastageTotalHtml"></div>

												</div>
											</div>




											<div class="row">
												<div class="col-md-12">

													<div id="monthwiseHTML"></div>

												</div>
											</div>


											<div class="row mb-3">
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
											</div>









										</div>

										<div class="tab-pane fade" id="tab_direction-2" role="tabpanel">

											<div class="form-group">

												<label class="form-control-label">Select Audit Period:</label><br>


												<div class="row">
													<div class="col-md-2">
														<input type="radio" id="radioMonth1" name="auditPeriod1" value="month" onchange="monthrad1()" checked>
														<label for="radioMonth1">Audit Month</label>
													</div>
													<div class="col-md-6">

														<input type="radio" id="radioYear1" name="auditPeriod1" onchange="yearrad1()" value="year">
														<label for="radioYear1">Month And Year</label>
													</div>
												</div>







											</div>


											<div class="row">
												<div id="monstatus1" class="col-md-3">
													<div class="form-group">
														<label class="form-control-label">Audit Month:</label>
														<select class="form-control kitsSelectbox" name="Audit2" id="Audit2" required>
															<?php foreach ($getAuditID as $key => $value) : ?>
																<option value="<?php echo $value['AuditMonth']; ?>"><?php echo $value['AuditMonth']; ?></option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>

												<div style="display: none;" id="yearstatus1" class="col-md-3">
													<div class="form-group">
														<label class="form-control-label">Select Month:</label>
														<input type="month" id="monthh" class="form-control" />
													</div>
												</div>

												<div class="col-md-3">
													<div class="form-group-inline">
														<button class="btn btn-primary mt-4" id="searchDataBySummary">Search</button>
													</div>
												</div>
											</div>



											<div class="row mt-5">

												<div class="col-md-12">

													<div id="wastageSumHtml"></div>

												</div>
											</div>


											<div class="row">
												<div class="col-md-12">

													<div id="auditwiseHTML"></div>

												</div>
											</div>


											<div class="row mb-3">
												<div id="getPrint1" style="display:none" class="col-md-2">
													<div class="form-group-inline">
														<button class="btn btn-warning" onclick="printContent()">Take a Print</button>

													</div>
												</div>





											</div>


											<div class="row">
												<div class="col-md-12">
													<div class="table-responsive-lg" id="labelingWestage1">


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
			</div>
		</div>


	<?php
}
	?>

	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


	<script src="<?php echo base_url(); ?>/assets/js/datagrid/datatables/datatables.bundle.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/vendors.bundle.js"></script>
	<script src="<?php echo base_url(); ?>/assets/js/app.bundle.js"></script>

	<script src="<?php echo base_url(); ?>/assets/js/datagrid/datatables/datatables.bundle.js"></script>

	<script src="<?php echo base_url(); ?>/assets/js/datagrid/datatables/datatables.export.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/printThis.js"></script>

	<script>
		window.onload = function() {
			var today = new Date();
			var month = today.getMonth() + 1; // getMonth() is zero-based
			var year = today.getFullYear();
			var monthFormatted = month < 10 ? '0' + month : month; // Add leading zero if needed
			var currentMonthAndYear = year + '-' + monthFormatted;
			document.getElementById('monthId').value = currentMonthAndYear;
		};

		window.onload = function() {
			var today = new Date();
			var month = today.getMonth() + 1; // getMonth() is zero-based
			var year = today.getFullYear();
			var monthFormatted = month < 10 ? '0' + month : month; // Add leading zero if needed
			var currentMonthAndYear = year + '-' + monthFormatted;
			document.getElementById('monthh').value = currentMonthAndYear;
		};





		function printContent() {
			// $(`#${contentToPrint}`).printThis();


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



		function monthrad1() {

			$("#monstatus1").css("display", "block");
			$("#yearstatus1").css("display", "none");

		}


		function yearrad1() {

			$("#monstatus1").css("display", "block");
			$("#yearstatus1").css("display", "block");


		}



		function monthrad() {

			$("#monstatus").css("display", "block");
			$("#yearstatus").css("display", "none");

		}



		function yearrad() {

			$("#monstatus").css("display", "none");
			$("#yearstatus").css("display", "block");


		}




		$("#searchDataBySummary").click(async function() {
			var audit2 = $("#Audit2").val();
			var monthId = $("#monthh").val();

			var year = parseInt(monthId.slice(0, 4));


			var month = parseInt(monthId.slice(5, 7));



			var totalLength = 0;


			if ($("#yearstatus1").css("display") === "none") {

				let totalWestAuditS = "<?php echo base_url('WastageRep/getWastageS') ?>";

				let totalWestAuditSByAudit = "<?php echo base_url('WastageRep/getWastageSByAudit') ?>";



				$("#wastageSumHtml").html('');
				var westageSumHtml = ``;

				var totalWaste = 0;

				// ${getMonthName(month)}-${data1[0].Year}

				await $.post(totalWestAuditSByAudit, {
					'audit2': audit2,
					'month': month,
					'year': year
				}, function(data2) {

					data2.forEach(element => {
						totalLength = totalLength + parseInt(element.KitCount);
					})



				})



				console.log('Check Wastage', totalLength);




				await $.post(totalWestAuditS, {
					'audit2': audit2,
					'year': year,
					'month': month
				}, function(data1) {

					if (data1.length > 0) {

						westageSumHtml += `
        <style>
        .page-break {
        border-bottom: 2px solid #000; /* Visual indication of intended page break */
        page-break-after: always; /* Suggest a page break after the element */
    }
    @media print {
        .page-break {
            border: none; /* Remove the visual border when printing */
            page-break-after: always;
        }
    }
        </style>
        <div id="printSection" style="width:100%;">
            <button class="btn btn-warning" onclick="printContent('contentToPrint')">Take a Print</button>
            <div id="contentToPrint" style="overflow-x:auto; width:100%;">
                <img style="width:25%;  height:auto;" src='http://10.10.100.4:2000/labeling/assets/img/ForwardLogo.png' />
                <div style="text-align:center; margin-top:5px;">
                    <span style="font-size:25px;"><b></b></span><br/>
                    <span style="font-size:30px;"><b> Audit Month ${audit2}</b></span>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:30px;"> <b>${data1[0].Narration} </b>
                 </span>
                </div>
           

                
                <table class="table table-striped table-hover" style="width:100%; margin-top:5px;">
                    <thead style="background-color:black; color:white; border:1px solid #000">
                        <tr style="border:1px solid #000">
                            <th colspan=2" style=" text-align:center; border:1px solid #000"><span style="font-size:28px;"> <b>Type</b></span></th>
                            <th colspan="2" style=" text-align:center; border:1px solid #000"><span style="font-size:28px;"><b>Wastage (In Pieces)</b></span></th>
                            <th colspan="2" style=" text-align:center;border:1px solid #000"><span style="font-size:28px;"><b>Wastage (In Grams)</b></span></th>
                            <th colspan="2" style=" text-align:center;border:1px solid #000"><span style="font-size:28px;"><b>Base Roll Qty</b></span></th>
                            <th colspan="2" style=" text-align:center;border:1px solid #000"><span style="font-size:28px;"><b>Ink Ribbon Core</b></span></th>
                        </tr>
                    </thead>
                    <tbody style="border:1px solid #000">`;


						data1.forEach((element, index) => {
							totalWaste = totalWaste + parseInt(element.Wastage);
							let pageBreakClass = ((index + 1) % 10 === 0) ? 'page-break' : '';



							westageSumHtml += `
								<tr class="${pageBreakClass}" style="border:1px solid #000">
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${element.westage_description}</td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${element.Wastage}</td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000"></td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000"></td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000"></td>
								</tr>`;
						});
						westageSumHtml += `
							<tr style="border:1px solid #000">
								<td colspan="6" style="font-size:25px; text-align:center; border:1px solid #000"></td>
								<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${totalLength * 4}</td>
								<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${totalLength * 2}</td>
							</tr>`;



						westageSumHtml += `

								<tr style="border:1px solid #000">
									<td colspan="12" style="font-size:20px; text-align:center; border:1px solid #000"><span style="font-size:30px"><b>Total Wastage: &nbsp;&nbsp;&nbsp;&nbsp;</b>${totalWaste}</span> </td>
								</tr>

              
        						<tr>
									<td colspan="12" style="font-size:22px;"><span><br><br><br></span></td>
								
								</tr>
                                    

        
        						<tr>
									<td colspan="6" style="font-size:22px; text-align:center"><span><b>_______________________________</b></span></td>
                                    <td colspan="6" style="font-size:22px; text-align:center"><span><b>_______________________________</b></span></td>

									</tr>
                                    

                                    <tr>
                                    <td colspan="6" style="font-size:22px; text-align:center"><span><b>ENGINEER SIGNATURE </b></span></td>

									<td colspan="6" style="font-size:22px; text-align:center"><span><b>HOD SIGNATURE </b></span></td>
								</tr>


                    </tbody>
                </table>
            </div>
        </div>`;

						$("#wastageSumHtml").html(westageSumHtml);

					} else {

						westageSumHtml += `
						<div class="alert alert-warning" role="alert" style="margin-top: 20px;"><strong>No Data Available</strong><br>Please adjust your selection criteria or check back later.</div>
            `

						$("#wastageSumHtml").html(westageSumHtml);
					}


					console.log("Check data sync", data1);
				});


			} else {

				var totalWastageByMonthlen = 0;

				let totalWestAuditS = "<?php echo base_url('WastageRep/getWastageS1') ?>";

				let totalWestAuditSByAuditM = "<?php echo base_url('WastageRep/getWastageSByAuditM') ?>";

				await $.post(totalWestAuditSByAuditM, {
					'audit2': audit2,
					'month': month,
					'year': year
				}, function(data2) {

					data2.forEach(element => {
						totalWastageByMonthlen = totalWastageByMonthlen + parseInt(element.KitCount);
						console.log('Check Wastage', element.KitCount);
					})



				})


				$("#wastageSumHtml").html('');
				var westageSumHtml = ``;

				var totalWaste = 0;

				// ${getMonthName(month)}-${data1[0].Year}

				await $.post(totalWestAuditS, {
					'audit2': audit2,
					'year': year,
					'month': month
				}, function(data1) {

console.log("Total LENGTH", totalWastageByMonthlen);


					if (data1.length > 0) {

						westageSumHtml += `
        <style>
        .page-break {
        border-bottom: 2px solid #000; /* Visual indication of intended page break */
        page-break-after: always; /* Suggest a page break after the element */
    }
    @media print {
        .page-break {
            border: none; /* Remove the visual border when printing */
            page-break-after: always;
        }
    }
        </style>
        <div id="printSection" style="width:100%;">
            <button class="btn btn-warning" onclick="printContent('contentToPrint')">Take a Print</button>
            <div id="contentToPrint" style="overflow-x:auto; width:100%;">
                <img style="width:25%;  height:auto;" src='http://10.10.100.4:2000/labeling/assets/img/ForwardLogo.png' />
                <div style="text-align:center; margin-top:5px;">
                    <span style="font-size:25px;"><b></b></span><br/>
                    <span style="font-size:30px;"><b> Monthly Audit Report ${audit2}</b></span>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <span style="font-size:30px;"> <b></b>  ${getMonthName(month)}-${data1[0].Year}
                 </span>
                </div>
           

                
                <table class="table table-striped table-hover" style="width:100%; margin-top:5px;">
                    <thead style="background-color:black; color:white; border:1px solid #000">
                        <tr style="border:1px solid #000">
                            <th colspan="2" style="text-align:center;border:1px solid #000"><span style="font-size:28px;"> <b>Type</b></span></th>
                            <th colspan="2" style="text-align:center;border:1px solid #000"><span style="font-size:28px;"><b>Wastage</b></span></th>
                            <th colspan="2" style="text-align:center;border:1px solid #000"><span style="font-size:28px;"><b>Base Roll Qty</b></span></th>
                            <th colspan="2" style="text-align:center;border:1px solid #000"><span style="font-size:28px;"><b>Ink Ribbon Core</b></span></th>

                        </tr>
                    </thead>
                    <tbody style="border:1px solid #000">`;

						data1.forEach((element, index) => {




							totalWaste = totalWaste + parseInt(element.Wastage);
							// Assuming you want a page break after every 10th row, for example
							let pageBreakClass = ((index + 1) % 10 === 0) ? 'page-break' : '';

							westageSumHtml += `
								<tr class="${pageBreakClass}" style="border:1px solid #000">
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${element.westage_description} </td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000"> ${element.Wastage}</td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000"> </td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000"> </td>

								</tr>`;

						});
						westageSumHtml += `
								<tr style="border:1px solid #000">
									<td colspan="4" style="font-size:25px; text-align:center; border:1px solid #000"></td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${parseInt(totalWastageByMonthlen) === 0 ? '' : totalWastageByMonthlen * 4}</td>
									<td colspan="2" style="font-size:25px; text-align:center; border:1px solid #000">${parseInt(totalWastageByMonthlen) === 0 ? '' : totalWastageByMonthlen * 2}</td>
								</tr>`;


						westageSumHtml += `

        						<tr style="border:1px solid #000">
        							<td colspan="12" style="font-size:20px; text-align:center; border:1px solid #000"><span style="font-size:30px"><b>Total Wastage: &nbsp;&nbsp;&nbsp;&nbsp;</b>${totalWaste}</span> </td>

           
        
        						</tr>

              
        						<tr>
									<td colspan="12" style="font-size:22px;"><span><br><br><br></span></td>
								
								</tr>
                                    

        
        						<tr>

									<td colspan="12" style="font-size:22px; text-align:center"><span><b>_______________________________</b></span></td>
								
								</tr>
                                    

                                <tr>
									<td colspan="12" style="font-size:22px; text-align:center"><span><b>HOD SIGNATURE </b></span></td>
								</tr>


                    </tbody>
                </table>
            </div>
        </div>`;

						$("#wastageSumHtml").html(westageSumHtml);

					} else {

						westageSumHtml += `
						<div class="alert alert-warning" role="alert" style="margin-top: 20px;"><strong>No Data Available</strong><br>Please adjust your selection criteria or check back later.</div>
            `

						$("#wastageSumHtml").html(westageSumHtml);
					}


					console.log("Check data sync", data1);
				});

			}


		});


		function getMonthName(monthNumber) {
			const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
			return months[monthNumber - 1];
		}


		$("#searchDataDetail").click(async function() {

			var audit1 = $("#Audit1").val();
			var MontVal = $("#monthId").val();
			var YearVal = $("#yearId").val();


			var year = parseInt(MontVal.slice(0, 4));



			var month = parseInt(MontVal.slice(5, 7));


			if ($("#yearstatus").css("display") === "none") {

				$("#wastageDetailHtml").html('');
				$("#wastageTotalHtml").html('');


				var wastageDetailHtml = ``;
				var wastageTotalHtml = ``;

				let totalWestAuditD = "<?php echo base_url('WastageRep/getWastageD') ?>";

				var totatWast = 0;

				await $.post(totalWestAuditD, {
					'audit1': audit1,
					'MontVal': month,
					'YearVal': year
				}, function(data1) {

					if (data1.length > 1) {



						wastageDetailHtml += `
<table class="table table-striped table-hover table-sm" id="tableD">
            <thead style="background-color:black; color:white;">
            <tr>
            <th  style="text-align:center" colspan="4"><span style="font-size:25px"> Audit Month  ${audit1}</span></th>'
            </tr>
            <tr>
            <th style="text-align:center" colspan="4"><span style="font-size:25px"></span></th>
            </tr>
                <tr>
                    <th><span style="font-size:20px">Kit Name</span></th>
                    <th><span style="font-size:20px">Type</span></th>
                    <th><span style="font-size:20px">Wastage</span></th>
                    <th><span style="font-size:20px">Entry Date</span></th>

                </tr>
            </thead>
            <tbody>
`

						data1.forEach(element => {

							totatWast = totatWast + parseInt(element.Wastage);

							wastageDetailHtml += `
<tr>
                    <td> ${element.SerialNo ? element.SerialNo : '' } </td>
                    <td>${element.westage_description} </td>
                    <td>${element.Wastage}</td>
                    <td>${element.EntryDate}</td>

                </tr>
`

						})


						wastageTotalHtml += `<span style="font-size:27px"><b>Total Wastage:</b>${totatWast}</span>`


						wastageDetailHtml += `</tbody> </table>`


						console.log("Get Detail Data", data1);

						$("#wastageTotalHtml").html(wastageTotalHtml);


						$("#wastageDetailHtml").html(wastageDetailHtml);
					} else {
						wastageDetailHtml += `<div class="alert alert-warning" role="alert" style="margin-top: 20px;"><strong>No Data Available</strong><br>Please adjust your selection criteria or check back later.</div>`
						$("#wastageDetailHtml").html(wastageDetailHtml);
					}



				})


				$('#tableD').dataTable({
					responsive: false,
					lengthChange: false,
	
					dom:
						/* --- Layout Structure ---
						 * Options
						 * l - length changing input control
						 * f - filtering input
						 * t - The table!
						 * i - Table information summary
						 * p - pagination control
						 * r - processing display element
						 * B - buttons
						 * R - ColReorder
						 * S - Select
						 * --- Markup ---
						 * < and > - div element
						 * <"class" and > - div with a class
						 * <"#id" and > - div with an ID
						 * <"#id.class" and > - div with an ID and a class
						 * --- Further reading ---
						 * https://datatables.net/reference/option/dom
						 * --------------------------------------
						 */
						"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
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


			} else {
				$("#wastageDetailHtml").html('');

				$("#wastageTotalHtml").html('');

				var totatWast = 0;


				var wastageDetailHtml = ``;
				var wastageTotalHtml = ``;
				let totalWestAuditD = "<?php echo base_url('WastageRep/getWastageD1') ?>";


				await $.post(totalWestAuditD, {
					'audit1': audit1,
					'MontVal': month,
					'YearVal': year
				}, function(data1) {

					if (data1.length > 1) {



						wastageDetailHtml += `
    <table class="table table-striped table-hover table-sm" id="tableD">
                                <thead style="background-color:black; color:white;">
                                <tr>
                                <th style="text-align:center" colspan="4"><span style="font-size:25px"> Audit Month ${audit1}</span></th>'
                                </tr>
                               
                                    <tr>
                                        <th><span style="font-size:20px">Kit Name</span></th>
                                        <th><span style="font-size:20px">Type</span></th>
                                        <th><span style="font-size:20px">Wastage</span></th>
                                        <th><span style="font-size:20px">Entry Date</span></th>

                                    </tr>
                                </thead>
                                <tbody>
    `

						data1.forEach(element => {
							totatWast = totatWast + parseInt(element.Wastage);
							wastageDetailHtml += `
    <tr>
                                        <td> ${element.SerialNo ? element.SerialNo : '' } </td>
                                        <td>${element.westage_description} </td>
                                        <td>${element.Wastage}</td>
                                        <td>${element.EntryDate}</td>

                                    </tr>
    `

						})

						wastageTotalHtml += `<span style="font-size:27px"><b>Total Wastage:</b>${totatWast}</span>`


						wastageDetailHtml += `</tbody> </table>`


						console.log("Get Detail Data", data1);

						$("#wastageTotalHtml").html(wastageTotalHtml);

						$("#wastageDetailHtml").html(wastageDetailHtml);
					} else {
						wastageDetailHtml += `<div class="alert alert-warning" role="alert" style="margin-top: 20px;"><strong>No Data Available</strong><br>Please adjust your selection criteria or check back later.</div>`
						$("#wastageDetailHtml").html(wastageDetailHtml);
					}



				})


				$('#tableD').dataTable({
					responsive: false,
					lengthChange: false,
					order: [
						[3, 'desc']
					],
					dom:
						/* --- Layout Structure ---
						 * Options
						 * l - length changing input control
						 * f - filtering input
						 * t - The table!
						 * i - Table information summary
						 * p - pagination control
						 * r - processing display element
						 * B - buttons
						 * R - ColReorder
						 * S - Select
						 * --- Markup ---
						 * < and > - div element
						 * <"class" and > - div with a class
						 * <"#id" and > - div with an ID
						 * <"#id.class" and > - div with an ID and a class
						 * --- Further reading ---
						 * https://datatables.net/reference/option/dom
						 * --------------------------------------
						 */
						"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
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
			}








		})





		async function getWastageRep(date1, date2) {
			let totalWestKitsURL = "<?php echo base_url('WastageRep/getWastageMonthWise') ?>";

			var date1 = $("#date1").val();
			var date2 = $("#date2").val();

			$("#date2").val();

			var html1 = ``;


			let kitNameCount1 = 0;
			var totalWestKitsCount = 0;
			let kitNameCount = 0;

			let kitName1 = '';

			let kitName2 = '';

			let lastKitName1 = '';

			let lastKitName2 = '';
			let GrandTotal = 0;

			var TotalRollQty = 0;
			var TotalInkRibbonQty = 0;

			let totalWastage = 0; // Initialize total variable
			let totalWastageRedtape = 0; // Initialize total variable
			let totalWastagePrinting = 0; // Initialize total variable
			let totalWastageQualityIssue = 0; // Initialize total variable
			let totalWastageWhiteWastage = 0; // Initialize total variable
			let totalWastageTestPO = 0; // Initialize total variable



			let urlR = "<?php echo base_url('WastageRep/loadMonthWiseRollAndRibbon') ?>";



			await $.post(urlR, {
				'sdate': date1,
				'edate': date2
			}, function(data1) {



				data1.forEach(element1 => {
					totalWestKitsCount = totalWestKitsCount + 1

					TotalRollQty = parseInt(TotalRollQty) + parseInt(element1.RollQty);
					TotalInkRibbonQty = parseInt(TotalInkRibbonQty) + parseInt(element1.InkRibbonQty);

				});

				console.log('Inner Roll Qty', TotalRollQty);
				console.log('inner Ink Ribbon ', TotalInkRibbonQty);

			});

			console.log("Roll Qty,", TotalRollQty);
			console.log("Roll Ribbon Qty,", TotalInkRibbonQty);

			await $.post(totalWestKitsURL, {
				'sdate': date1,
				'edate': date2
			}, function(data) {

				$("#getPrint").css("display", "block");

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


				GrandTotal = GrandTotal + totalWastage + totalWastageRedtape + totalWastageQualityIssue + totalWastageWhiteWastage + totalWastageTestPO

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
            <div   style="overflow-x:auto; width:100%; height: 100vh">
                <table>
                <tr>
                <td style="font-size:18px;"><span><img width='85%' heig60ht='100vh' src='http://10.10.100.4:2000/labeling/assets/img/ForwardLogo.png' /></span></td>
                    <td colspan="2" style="font-size:22px;"><span><b>Forward Sport Pvt.Ltd</b></span></td>
                    <td colspan="2" style="font-size:20px;">
                    
                    <span><b>Date:</b>${date1} To ${date2} </span></td>
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
                <td style="border: 1px solid #000;font-size:22px; padding:5px"><span class="badge badge-info"><b>Red Tape + Printed Strips:</b></span></td>

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



				$("#labelingWestage").html(html1);

			})
		}

		$("#searchData").click(function() {








			var date1 = $("#date1").val();
			var date2 = $("#date2").val();

			url = "<?php echo base_url('index.php/WastageRep/getWastageMonthWise/') ?>" + "/" + date1 + "/" + date2

			$("#monthwiseHTML").html('');

			var monHTML = ``;

			$.post(url, {
				'sdate': date1,
				'edate': date2
			}, function(data) {

				console.log('Check data', data);

				monHTML += `
            <table class="table table-striped table-hover table-sm" id="table1">
                                <thead style="background-color:black; color:white;">
                                    <tr>
                                        <th>Kit Name</th>
                                        <th>Wastage</th>
                                        <th>Wastage Description</th>
                                        <th>Entry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
            `

				data.forEach(element => {
					monHTML += `
                <tr>
                 <td>${element.SerialNo ? element.SerialNo : '' }</td>
                 <td>${element.Wastage ? element.Wastage : 0 }</td>
                 <td>${element.westage_description ? element.westage_description : '' }</td>
                 <td>${element.EntryDate ? element.EntryDate : '' }</td>
                </tr>
                `

					$("#monthwiseHTML").html(monHTML);
				})


				monHTML += `
            </tbody>
            </table>
            `


				$('#table1').dataTable({
					responsive: false,
					lengthChange: false,
					order: [
						[3, 'desc']
					],
					dom:
						/* --- Layout Structure ---
						 * Options
						 * l - length changing input control
						 * f - filtering input
						 * t - The table!
						 * i - Table information summary
						 * p - pagination control
						 * r - processing display element
						 * B - buttons
						 * R - ColReorder
						 * S - Select
						 * --- Markup ---
						 * < and > - div element
						 * <"class" and > - div with a class
						 * <"#id" and > - div with an ID
						 * <"#id.class" and > - div with an ID and a class
						 * --- Further reading ---
						 * https://datatables.net/reference/option/dom
						 * --------------------------------------
						 */
						"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
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


			getWastageRep(date1, date2);

		})




		async function getWastageAuditRep(auditID) {
			let totalWestKitsURLL = "<?php echo base_url('WastageRep/getWastageByAudit') ?>";

			var auditID1 = $("#Audit").val();


			var html1 = ``;


			let kitNameCount1 = 0;
			var totalWestKitsCount = 0;
			let kitNameCount = 0;

			let kitName1 = '';

			let kitName2 = '';

			let lastKitName1 = '';

			let lastKitName2 = '';
			let GrandTotal = 0;

			var TotalRollQty = 0;
			var TotalInkRibbonQty = 0;

			let totalWastage = 0; // Initialize total variable
			let totalWastageRedtape = 0; // Initialize total variable
			let totalWastagePrinting = 0; // Initialize total variable
			let totalWastageQualityIssue = 0; // Initialize total variable
			let totalWastageWhiteWastage = 0; // Initialize total variable
			let totalWastageTestPO = 0; // Initialize total variable

			var AuditMonth;


			let urlRR = "<?php echo base_url('WastageRep/loadAuditWiseRollAndRibbon') ?>";



			await $.post(urlRR, {
				'auditID': auditID1
			}, function(data1) {

				data1.forEach(element1 => {
					totalWestKitsCount = totalWestKitsCount + 1

					TotalRollQty = parseInt(TotalRollQty) + parseInt(element1.RollQty);
					TotalInkRibbonQty = parseInt(TotalInkRibbonQty) + parseInt(element1.InkRibbonQty);

					console.log("Toa;l Count", element1);
				});

				console.log('Inner Roll Qty', TotalRollQty);
				console.log('inner Ink Ribbon ', TotalInkRibbonQty);

			});



			await $.post(totalWestKitsURLL, {
				'auditID': auditID1
			}, function(data) {

				$("#getPrint1").css("display", "block");

				// console.log("Total Westage Data", data);

				// if (data[0].KitName === 'PAK-PS325S') {
				// 	kitName1 = data[0].SerialNo;
				// }


				// if (data[0].KitName == 'PAK-BST25') {
				// 	kitName2 = data[0].SerialNo;

				// 	console.log("Inner KitName 2", data);
				// }


				data.forEach(element => {


					AuditMonth = element.AuditMonth;

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


				GrandTotal = GrandTotal + totalWastage + totalWastageRedtape + totalWastageQualityIssue + totalWastageWhiteWastage + totalWastageTestPO

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
                <td style="font-size:18px;"><span><img width='85%' heig60ht='100vh' src='http://10.10.100.4:2000/labeling/assets/img/ForwardLogo.png' /></span></td>
                    <td colspan="2" style="font-size:22px;"><span><b>Forward Sport Pvt.Ltd</b></span></td>
                    <td colspan="2" style="font-size:20px;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;
                    <span><b>Date: </b>${AuditMonth}</span></td>
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
                <td style="border: 1px solid #000;font-size:22px; padding:5px"><span class="badge badge-info"><b>Red Tape + Printed Strips:</b></span></td>

                <td style="border: 1px solid #000; font-size: 22px; padding: 5px;text-align:center">
<span>${parseFloat(totalWastageRedtape) + parseFloat(totalWastageTestPO) + '.00'}</span>
</td>
                    <td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center">147g</td>
                    <td style="border: 1px solid #000;font-size:22px; padding:5px;"><span class="badge badge-info"><b>Quality Issue:</b></span></td>
                    <td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"><span>${totalWastageQualityIssue.toFixed(2)}</span></td>

                    <td style="border: 1px solid #000;font-size:22px;"></td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                <td style="border: 1px solid #000;font-size:22px; padding:5px"><span class="badge badge-info"><b>White Wastage:</b></span></td>
                    <td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center"><span>${totalWastageWhiteWastage.toFixed(2)}</span></td>
                    
                    <td style="border: 1px solid #000;font-size:22px; padding:5px;text-align:center">269g</td>
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



				$("#labelingWestage1").html(html1);

			})
		}




		$("#searchDatabyAudit").click(function() {


			var audit1 = $("#Audit").val();



			var date1 = $("#date1").val();
			var date2 = $("#date2").val();

			urlAudit = "<?php echo base_url('index.php/WastageRep/getWastageByAudit/') ?>" + "/" + audit1

			$("#auditwiseHTML").html('');

			var monHTML = ``;

			$.post(urlAudit, {
				'auditID': audit1
			}, function(data) {

				console.log('Check Audit data', data);

				monHTML += `
            <table class="table table-striped table-hover table-sm" id="table2">
                                <thead style="background-color:black; color:white;">
                                    <tr>
                                        <th>Kit Name</th>
                                        <th>Wastage</th>
                                        <th>Wastage Description</th>
                                        <th>Entry Date</th>
                                    </tr>
                                </thead>
                                <tbody>
            `

				data.forEach(element => {
					monHTML += `
                <tr>
                 <td>${element.SerialNo ? element.SerialNo : '' }</td>
                 <td>${element.Wastage ? element.Wastage : 0 }</td>
                 <td>${element.westage_description ? element.westage_description : '' }</td>
                 <td>${element.EntryDate ? element.EntryDate : '' }</td>
                </tr>
                `

					$("#auditwiseHTML").html(monHTML);
				})


				monHTML += `
            </tbody>
            </table>
            `


				$('#table2').dataTable({
					responsive: false,
					lengthChange: false,
					dom:
						/* --- Layout Structure ---
						 * Options
						 * l - length changing input control
						 * f - filtering input
						 * t - The table!
						 * i - Table information summary
						 * p - pagination control
						 * r - processing display element
						 * B - buttons
						 * R - ColReorder
						 * S - Select
						 * --- Markup ---
						 * < and > - div element
						 * <"class" and > - div with a class
						 * <"#id" and > - div with an ID
						 * <"#id.class" and > - div with an ID and a class
						 * --- Further reading ---
						 * https://datatables.net/reference/option/dom
						 * --------------------------------------
						 */
						"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
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


			getWastageAuditRep(audit1);

		})
	</script>
