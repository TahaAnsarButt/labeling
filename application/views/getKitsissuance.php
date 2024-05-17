<?php

$this->load->view('header');
?>
<script>
	$(".deletebtn").click(function(e) {
		let id = this.id;
		let split_value = id.split(".");
		var RID = split_value[1];
		var Datee = $(`#Datee${split_value[1]}`).val();
		let text;
		let person = prompt("Are Your Want to Delete Printed", "");
		if (person == null) {
			text = "User cancelled the prompt.";
		} else {
			text = "Deleted Successfully";
			url = "<?php echo base_url('index.php/Kitsissuance/Delete/') ?>" + RID

			$.get(url, function(data) {
				alert(" Printed Delete Successfully");
				location.reload();

			});
		}
		document.getElementById("demo").innerHTML = text;
	});
	$(".updatebtn").click(function(e) {
		//alert("heloo");
		let id = this.id;
		//alert(id);
		let split_value = id.split(".");
		//console.log(split_value);
		var RID = split_value[1];
		//alert(`#issueDate.${split_value[1]}`);
		//alert(split_value[1]);
		//   let RID =split_value[1]);
		var iDate = $(`#issueDate${split_value[1]}`).val();
		var Receivedby = $(`#Receivedby${split_value[1]}`).val();
		var Datee = $(`#Datee${split_value[1]}`).val();
		//let split_Datee = Datee.split("/");

		//text = Receivedby.replace("%20", "");
		//   $(`select#Receivedby.${split_value[1]} option`).filter(":selected").val();
		//console.log(Receivedby);
		//   alert(id);
		//alert(iDate);
		// alert(Receivedby);

		// console.log("RIDValue",RIDValue)
		// console.log("RStatus",RStatus)
		// console.log("IssueDte",IssueDte)
		url = "<?php echo base_url('index.php/Kitsissuance/updateRecord/') ?>" + Receivedby + "/" + iDate + "/" + RID

		//alert(url);
		$.get(url, function(data) {
			alert("PO Issed Done Successfully");
			loadData(Datee);
		});

		function loadData(Datee) {
			//alert('Heloo');
			split_date = Datee.split("/");
			//2020-09-28
			let date_make = split_date[2] + "-" + split_date[1] + "-" + split_date[0];
			var date1 = date_make
			var date2 = date_make
			url = "<?php echo base_url("index.php/Kitsissuance/getkitsissuance/") ?>" + date1 + "/" + date1
			//alert(url);
			$.get(url, function(data) {
				$("#Data").html(data)
			});
		}
	});
	$('#dt-basic-example').dataTable({
                            responsive: true,
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
</script>
<?php $Month = date('m');
$Year = date('Y');
$Day = date('d');
$CurrentDate = $Year . '-' . $Month . '-' . $Day; ?>

<div id="demo" style="display:none">
	<div class="row">
		<div class="col-sm-3">
			<label for="country">Select Issue Date</label>
			<input class="form-control" type="date" name="date" value="<?php echo $CurrentDate ?>" id="dateofCheck" />
		</div>
		<div class="col-sm-3">
			<label for="country">Select Received By</label>
			<select class="form-control" name="Received" id="Received">

				<option value="658 Ashfaq Ahmed">658 / Ashfaq Ahmed</option>
				<option value="8506 Asmat Ullah">8506 / Asmat Ullah </option>
				<option value="1611 Abid Ali">1611 / Abid Ali</option>
				<option value="211 Rizwan Akbar">211 / Rizwan Akbar</option>
				<option value="7543 Aftab Mehboob">7543 / Aftab Mehboob</option>
				<option value="1142 Qasir Naveed">1142 / Qasir Naveed</option>
			</select>
		</div>
		<div class="col-sm-2" style="margin-top:20px;">
			<button class="btn btn-primary" id="issuedKit">Issue Selected</button>
		</div>
	</div>
</div>
<div class="table-responsive-lg" id="Data">
	<p>


	</p>

	<table class="table table-bordered table-striped table-hover table-sm" id="PowiseDatatabel">
		<thead>
			<tr>
				<th>
					<div class=" custom-control custom-checkbox no-sort">
						<input class="custom-control-input" type="checkbox" id="select-all">
						<label for="select-all" class="custom-control-label"></label>
					</div>
				</th>
				<th>PO Code</th>
				<th>Plan Date</th>
				<th>Kit Name</th>
				<th>Factory Code</th>
				<th>Quantity</th>
				<th>Print Date</th>
				<th>Printed By</th>
				<th>Print Status</th>
				<th>Issue Date</th>
				<th>Issued To</th>
				<!-- <th>Action</th>
        <th>Action</th> -->
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($getkitsissuance as $keys) {
				$POCode = $keys['POCode'];
				$SerialNo = $keys['SerialNo'];
				$FactoryCode = $keys['FactoryCode'];
				$KitQty = $keys['KitQty'];
				$IssuanceDate = $keys['IssuanceDate'];
				$Issuedby = $keys['Issuedby'];
				$PlanDate = $keys['PlanDate'];
				$Receivedby = $keys['Receivedby'];
				$IssueDate = $keys['IssueDate'];
				$TID = $keys['TID'];

				?>

				<tr>
					<td>
						<?php
							if (!empty($IssueDate)) { } else {
								?>
							<input class="kit_id" type="checkbox" name="checkbox" id="select<?php echo $TID ?>" value="<?php echo $TID ?>" onchange="showDate()" />
							<label for="select<?php echo $TID ?>"></label>
						<?php


							}

							?>




					</td>
					<td><?php echo $POCode; ?></td>
					<td><?php echo date('d/m/Y', strtotime($PlanDate))  ?></td>
					<td><?php echo $SerialNo; ?></td>
					<td><?php echo $FactoryCode; ?></td>
					<td><?php echo $KitQty; ?></td>
					<td><?php echo $IssuanceDate; ?></td>


					<td><?php echo $Issuedby; ?></td>
					<td>



						<button type="button" class="btn btn-xs btn-outline-success">Normal</button>



					</td>

					<td>

						<?php
							if (!empty($IssueDate)) {
								?><?php echo $IssueDate; ?>
					<?php

						} else {
							$Month = date('m');
							$Year = date('Y');
							$Day = date('d');
							$CurrentDate = $Year . '-' . $Month . '-' . $Day;
							?>
					<?php

						}
						?>

					<input type="text" class="form-control" value="<?php echo $IssuanceDate; ?>" id="Datee<?php echo $TID; ?>" hidden>
					</td>
					<td>
						<?php
							if (!empty($Receivedby)) {
								?><?php echo $Receivedby; ?>
					<?php

						} else {
							?>

					<?php
						}
						?>
					</td>
					<!-- <td>
            <?php
				if (!empty($IssueDate)) {
					?>
              <button class="btn btn-success btn-xs updatebtn" id="btn.<?php echo $TID; ?>" disabled>issued</button>
            <?php
				} else {
					?>
              <button class="btn btn-warning btn-xs updatebtn" id="btn.<?php echo $TID; ?>">issued</button>
            <?php
				}
				?>
          </td> -->
					<!-- <td>
            <?php
				if (!empty($IssueDate)) {
					?>
              <button class="btn btn-primary btn-xs">Saved</button>

            <?php
				} else {
					?>
              <button class="btn btn-danger btn-xs deletebtn" id="btn.<?php echo $TID; ?>">Delete</button>
            <?php
				}
				?>
          </td> -->


				</tr>

			<?php
			}
			?>
		</tbody>

	</table>
</div>

<?php
$this->load->view('Foter');

?>
<script>
	function showDate() {
		$("#demo").css('display', 'block')


	}

	kits = []
	$("#select-all").on("click", function() {

		$("#demo").css('display', 'block')
		checked = $('#select-all:checked').val()
		if (checked) {
			$('.kit_id').prop('checked', true)

		} else {
			$('.kit_id').prop('checked', false)


		}
	})
	$("#issuedKit").on("click", function() {
		datee = $("#dateofCheck").val()
		Received = $("#Received").val()
		// console.log($('input[name="checkbox"]:checked').serialize());
		$('input[name="checkbox"]:checked').each(function() {
			kits_id = this.value
			kits.push(this.value);
		});
		console.log(kits);
		urlL = '<?php echo base_url('Kitsissuance/issuedAll') ?>'

		$.post(urlL, {
			"datee": datee,
			"Received": Received,
			"kits": kits
		}, function(data) {
			alert("Kit Issued Successfully!")
			loadAgain()
			location.reload()
		})

	})


	function loadAgain() {


		var date1 = '<?php echo $dates; ?>'
		var date2 = '<?php echo $datee; ?>'
		url = "<?php echo base_url("index.php/Kitsissuance/getkitsissuance/") ?>" + date1 + "/" + date2
		$.get(url, function(data) {
			$("#kitsissuance").html(data)
		});

	}
</script>
