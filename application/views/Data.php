<?php
$this->load->view('header');
?>
<script>
	function loadDate(TID, RDate) {
		//alert("Called")
		split_date = RDate.split("/");
		//2020-09-28
		let date_make = split_date[2] + "-" + split_date[1] + "-" + split_date[0];
		//alert(date_make);
		var Type = TID
		var date1 = date_make
		var date2 = date_make
		//alert(date1);
		url = "<?php echo base_url("index.php/kitsReceived/getData/") ?>" + date1 + "/" + date2 + "/" + Type
		//alert(url);
		$.get(url, function(data) {
			alert("Selected Kits is Isseud Successfully")
			$("#Data").html(data)
		});
	}

	$(".updatebtn").click(function(e) {
		let id = this.id;
		let split_value = id.split(".");

		var RIDValue = $(`#RID${split_value[1]}`).val()
		var RStatus = $(`#customSwitch${split_value[1]}`).val()
		var IssueDte = $(`#iDate${split_value[1]}`).val()
		var RDate = $(`#RDate${split_value[1]}`).val()
		var TID = $(`#TID${split_value[1]}`).val()
		//alert(RDate)

		console.log("RIDValue", RIDValue)
		console.log("RStatus", RStatus)
		console.log("IssueDte", IssueDte)
		url = "<?php echo base_url('index.php/kitsReceived/updateRecord/') ?>" + RIDValue + "/" + RStatus + "/" + IssueDte

		// alert(url);
		$.get(url, function(data) {

			loadDate(TID, RDate)
		})

	});
</script>
<div class="table-responsive-lg" id="Data">
	<table class="table table-striped table-hover table-sm" id="tableExport">
		<thead style="background-color:black; color:white;">

			<th>Kit Name</th>
			<th>Quantity</th>
			<th>Received Date</th>
			<th>Issue For Printing</th>
			<th>Date</th>

			<th>Action</th>

		</thead>
		<tbody>
			<?php
			foreach ($received as $keys) {
				$Status = $keys['IssueStatus'];
				$RecID = $keys['RecID'];
			?>

				<tr>

					<td><?php echo $keys['SerialNo']; ?>


					</td>
					<td><?php echo $keys['Qty']; ?></td>
					<td><?php echo $keys['TranDate']; ?></td>
					<input type="text" name="RID" id="RID<?php echo $RecID; ?>" value="<?php echo $RecID; ?>" hidden>
					<input type="text" name="RDate" id="RDate<?php echo $RecID; ?>" value="<?php echo $keys['TranDate']; ?>" hidden>
					<input type="text" name="TID" id="TID<?php echo $RecID; ?>" value="<?php echo $keys['ID']; ?>" hidden>
					<td><?php if ($Status == 1) { ?>
							<div class="custom-control custom-switch">
								<input type="checkbox" name="onoffswitch" class="custom-control-input" id="customSwitch<?php echo $RecID ?>" checked>
								<label class="custom-control-label" for="customSwitch<?php echo $RecID ?>"></label>
							</div>
						<?php
							} else {
						?>
							<div class="custom-control custom-switch">
								<input type="checkbox" name="onoffswitch" class="custom-control-input" id="customSwitch<?php echo $RecID ?>">
								<label class="custom-control-label" for="customSwitch<?php echo $RecID ?>"></label>
							</div>
						<?php
							} ?>
					</td>
					<td>
						<?php
						$issueDate = $keys['IssueDate'];
						if ($issueDate) {
						?>
							<?php echo $keys['IssueDate']; ?>
						<?php
						} else {
						?>
							<input type="Date" class="form-control" name="IDate" id="iDate<?php echo $RecID; ?>">
						<?php
						}
						?>

					</td>

					<td>
						<?php if ($Status == 1) { ?>
							<button type="button" class="btn btn-primary btn-sm updatebtn" id="btn.<?php echo $RecID; ?>" disabled="disabled">Done</button>
						<?php
						} else {
						?>
							<button type="button" class="btn btn-info btn-sm updatebtn" id="btn.<?php echo $RecID; ?>">issued</button>
						<?php
						}
						?>
					</td>


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