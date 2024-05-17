<?php
if (!($this->session->has_userdata('user_id'))) {
	redirect('login');
} else {

	$this->load->view('header');
?>

	<body class="mod-bg-1 ">

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
							<?php
							$Month = date('m');
							$Year = date('Y');
							$Day = date('d');
							$CurrentDate = $Year . '-' . $Month . '-' . $Day;
							?>
							<div class="row ">
								<div class="col-md-3">
									<label>Plan Date Start :</label>
									<div class="form-group-inline">

										<input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>">
									</div>
								</div>
								<div class="col-md-3">
									<label>Plan Date End :</label>
									<div class="form-group-inline">

										<input name="date" id="date2" class="form-control" type="date" value="<?php echo $CurrentDate; ?>">
									</div>
								</div>
								<div class="col-md-2 mt-4">
									<div class="form-group-inline">

										<button class="btn btn-primary" id="Searchbtn">Search</button>
									</div>
								</div>
							</div>
							<div id="tableData" class="mt-2">

							</div>
						</div>
				</div>
			</div>
			</main>
		</div>
		<?php
		$this->load->view('after-main');
		?>
		<script src="assets/bundles/datatables/datatables.min.js"></script>
		<script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
		<script src="assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
		<script src="assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
		<script src="assets/bundles/datatables/export-tables/jszip.min.js"></script>
		<script src="assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
		<script src="assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
		<script src="assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
		<script src="assets/js/page/datatables.js"></script>
		<script>

var AuditMonthh = [];

			function loadAuditMonth(){

				var url = "<?php echo base_url('index.php/PIR/getAuditID/'); ?>";

				$.get(url, function(data) {

					AuditMonthh.push(data);
					console.log("Load Audit MNTH", data);

				})

			}

			$('#Searchbtn').click(function() {
				loadData();
				loadAuditMonth();
			});
			function updateStatus(POCode)
			{
			$('#receivedate').show();
			}

			function Cancel(POCode)
			{
				var Audit1 = $("#Audit1").val();
				var ReceivedBy = $("#ReceivedBy").val();

				// alert(ReceivedBy);

				// return 


				let confirmm = confirm("Are you sure you want to cancel?")
				if(confirmm){
					var url = "<?php echo base_url('index.php/PIR/cancel/'); ?>";
                            console.log("URL:", url);

                            var data = {
                                ReceiveDate: $('#Date').val(),
                                POCode: POCode,
								AuditMonth: Audit1,
								ReceivedBy: ReceivedBy
                            };
							console.log("data", data);

                            $.post({
                                url: url,
                                data: data,
                                success: function(data) {
                                    console.log(data);
									alert('PO canceled successfully')
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    console.error(xhr.responseText);
                                }
                            });
				}
				else{
				alert("user canceled request")
				};
				
			}


			// <td>${element.Days}</td>
			// <th>Days</th>



			async function loadData() {
				//alert('Heloo');
				var date1 = $("#date1").val()
				var date2 = $("#date2").val()
				url = "<?php echo base_url(
							'index.php/PIR/getAll/'
						); ?>"
				// alert(url);
				let data =
					await $.post(url, {
						"date1": date1,
						"date2": date2
					}, function(data) {
						if (data.PIR.length > 0) {
							// console.log("data", data);
							let html = '';
							html += `<table id="Data" class="table table-bordered table-hover table-striped w-100">
									<thead class="bg-primary-600">

										<tr>
										<th>Cancel</th>
											<th>KitName</th>
											<th>POCode</th>
											<th>Print Quantity</th>
											<th>Print Date</th>
											<th>Issue Date</th>
											<th>Key NO.</th>
											<th>Audit Month</th>
											<th>Received By</th>
											<th>Receive Date</th>
											<th>Action</th>


										</tr>
									</thead>
									<tbody>`;

									console.log(":Check daa", AuditMonthh);

									AuditMonthh[0].forEach(element1 => {
										console.log(":Check daa", element1);

									})

							data.PIR.forEach((element) => {
								let isChecked = element.Cancel === 1 ? 'checked' : '';
								html += `<tr>
								<td><div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault${element.POCode}" onclick="updateStatus(${element.POCode}, this )" ${isChecked}>
                                    </div>
                                    </td>
											<td>${element.KitName}</td>
												<td>${element.POCode}</td>
												<td>${element.KitQty}</td>
												<td>${element.IssuanceDate}</td>
												<td>${element.IssueDate}</td>
												<td>${element.KeyNum}</td>
												<td>
												 
												<div  class="col-md-12">
														<div class="form-group">
															<select class="form-control kitsSelectbox" name="Audit1" id="Audit1" required="true" >
														`
														AuditMonthh[0].forEach(element1 => {
															html += `
                                                                <option value="${element1.TID}">${element1.AuditMonth}</option>
                                                                `
															})

														html += `	

															</select>
													</div>
											</div>
												</td>
												<td>
												<div class="col-md-12">
			<select class="form-control" name="ReceivedBy" id="ReceivedBy">

				<option value="658 Ashfaq Ahmed">658 / Ashfaq Ahmed</option>
				<option value="8506 Asmat Ullah">8506 / Asmat Ullah </option>
				<option value="1611 Abid Ali">1611 / Abid Ali</option>
				<option value="211 Rizwan Akbar">211 / Rizwan Akbar</option>
				<option value="7543 Aftab Mehboob">7543 / Aftab Mehboob</option>
				<option value="1142 Qasir Naveed">1142 / Qasir Naveed</option>
			</select>
		</div>
												</td>

												<td>
												<div class="form-group" id = "receivedate" >
                                                                                    <label class="form-control-label">Received Date</label>
                                                                                    <div class="input-group">
                                                                                        <input class="form-control" type="Date" id="Date" name="date" value="<?php echo $CurrentDate; ?>">
                                                                                    </div>
                                                                                </div>
																				</td>
												<td>
                                    <button class="btn btn-primary" onclick="Cancel('${element.POCode}')">Update</button>
                                    </td>
										</tr>`
							})
							html += `</tbody></table>`;
							$("#tableData").html(html);
							$('#Data').dataTable({
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

						} else {
							alert("No data available!");
						}
					});
			}

			AuditMonthh = [];

		</script>


	</body>

	</html>

	<?php
	$this->load->view('Foter');
	?>

<?php

}

?>
