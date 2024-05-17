<?php
if (!($this->session->has_userdata('user_id'))) {
    redirect('login');
} else {

    $this->load->view('header');
?>

    <html>

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
                        <?php ?>

                        <!-- <div class="container">

                            <div id="panel-3" class="panel" style="padding:12px;">
                                <div class="panel-container show">

                                    <div class="panel-content nav nav-pills justify-content-center">

                                    

                                    </div>
                                </div>

                            </div>
                        </div> -->
                        <div id="panel-3" class="panel" style="padding:12px;">
                            <div class="panel-hdr">
                                <h2>
                                    Kits <span class="fw-300"><i>Dashboard</i></span>
                                </h2>
                                <div class="panel-toolbar">
                                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                                </div>
                            </div>
                            <div class="panel-container show">

                                <div class="panel-content nav nav-pills justify-content-center">

                                    <div class="container">
                                        <div class="row" style="margin-left:30px">
                                            <!-- <div class="col-md-4" id="totalKits">
                                                <a href="javascript:void(0)">
                                                    <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php echo $printedkits; ?>
                                                                <small class="m-0 l-h-n">Total Kits</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-futbol position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </a>
                                            </div> -->
                                            <div class="col-md-4" id="issuedKits">
                                                <a href="javascript:void(0)">
                                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">

                                                                <?php echo $issuedkits; ?>
                                                                <small class="m-0 l-h-n">Total Kits Printed</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-futbol position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-md-4" id="instockKits">
                                                <a href="javascript:void(0)">
                                                    <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php echo $Available; ?>
                                                                <small class="m-0 l-h-n">In-Stock Kits Balance</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-futbol position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </a>
                                            </div>

                            

                                            <!-- <div class="col-md-4" id="dailyPrintedKits">
                                                <a href="javascript:void(0)">
                                                    <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                <?php echo $getkitsissuanceCount; ?>
                                                                <small class="m-0 l-h-n">Daily Printed</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-futbol position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div> 
                                                </a>
                                            </div> -->

                                             <!-- <div class="col-md-4" id="dailyIssued">
                                                <a href="javascript:void(0)">
                                                    <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">

                                                                <?php echo $dailyIssued; ?>
                                                                <small class="m-0 l-h-n">Daily Issued</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-futbol position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </a>
                                            </div>  -->



                                            <div class="col-md-4" id="balanceIssued">
                                                <a href="javascript:void(0)">
                                                    <div class="p-3  rounded overflow-hidden position-relative text-white mb-g" style="background-color: #38B261;">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">

                                                              <?php echo $getkitsPrinted; ?>
                                                                <small class="m-0 l-h-n">Printed Stock</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-futbol position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                                    </div>
                                                </a>
                                            </div>


                                        </div>
                                        <?php
								$Month = date('m');
								$Year = date('Y');
								$Day = date('d');
								$CurrentDate = $Year . '-' . $Month . '-' . $Day;
								?>
                                           
                                           <div style="display: none;" id="issuedDate" class="row">
                                            <div class="col-md-12">

                                            <div class="row">
													<div class="col-md-4">
														<label>Start Issuance Date :</label>
														<div class="form-group-inline">
															<input name="date" id="date1" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
														</div>
													</div>
													<div class="col-md-4">
														<label>End Issuance Date</label>
														<div class="form-group-inline">
															<input name="date" id="date2" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
														</div>
													</div>

                                                    <div class="col-md-4 mt-4">
														<div class="form-group-inline">
															<button class="btn btn-primary" id="Searchbtn">Search</button>
														</div>
													</div>


											</div>

                                            </div>
                                           </div>


                                        <div class="mt-3" id="tableAll">

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
        $this->load->view('after-main');
        ?>





        <?php
        $this->load->view('Foter');
        ?>
        <script src="<?php echo base_url(); ?>assets/js/datagrid/datatables/datatables.export.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/datagrid/datatables/datatables.bundle.js"></script>
        <script>
            $(document).ready(function() {

                // initialize datatable
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

            });
        </script>

        <script>

            $("#Searchbtn").click(function(){

                $("#tableAll").html("")


                var startDate = $("#date1").val();
                var endDate = $("#date2").val();

                // alert(startDate);
                // alert(endDate);

                url = '<?php echo base_url('Dashboard/issuedKitsByDate') ?>';
                $.post(url, {'startDate':startDate, 'endDate':endDate }, function(data) {
                
                    console.log("cHECK DATA BY Date Range", data);
                
                    let table = '';
                    table += ` <table class="table table-striped table-hover table-sm" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                                <th>Kit Name</th>
                                                                <th>Received Date</th>
                                                                <th>Issuance Date</th>
                                                                <th>Quantity</th>
                                                               
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                    data.forEach((item, index) => {



                        table += `<tr>
                        <td>${item.KitName}</td>
                        <td>${item.TranDate}</td>
                        
                        <td>${item.IssueDate}</td>
                        <td>${item.Qty}</td>
                       
                        
                        </tr>`

                    })

                    table += `</tbody>
</table>`

                    $("#tableAll").html(table)

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


            })

            $("#totalKits").on("click", function() {
                $("#tableAll").html(' ')
                url = '<?php echo base_url('Dashboard/totalKits') ?>';
                $.post(url, function(data) {

                    let table = '';
                    table += ` <table class="table table-striped table-hover table-sm" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                                <th>Kit Name</th>
                                                                <th>Received Date</th>
                                                                <th>Quantity</th>
                                                              
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                    data.forEach((item, index) => {



                        table += `<tr>
                        <td>${item.KitName}</td>
                        <td>${item.TranDate}</td>
                        <td>${item.Qty}</td>
                     
                        
                        </tr>`

                    })

                    table += `</tbody>
</table>`

                    $("#tableAll").html(table)

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
            })

            $("#issuedKits").on("click", function() {
                $("#tableAll").html(' ')
                url = '<?php echo base_url('Dashboard/issuedKits') ?>';
                $.post(url, function(data) {

                    $("#issuedDate").css("display", "block");

                    let table = '';
                    table += ` <table class="table table-bordered table-hover table-striped w-100" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                                <th>Kit Name</th>
                                                                <th>Received Date</th>
                                                                <th>Issuance Date</th>
                                                                <th>Quantity</th>
                                                               
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                    data.forEach((item, index) => {



                        table += `<tr>
                        <td>${item.KitName}</td>
                        <td>${item.TranDate}</td>
                        
                        <td>${item.IssueDate}</td>
                        <td>${item.Qty}</td>
                       
                        
                        </tr>`

                    })

                    table += `</tbody>
</table>`

                    $("#tableAll").append(table)

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
            })

            $("#instockKits").on("click", function() {
                $("#tableAll").html(' ')
                url = '<?php echo base_url('Dashboard/instockKits') ?>';
                
                $.post(url, function(data) {

                

                    $("#issuedDate").css("display","none");

                    let table = '';
                    table += ` <table class="table table-bordered table-hover table-striped w-100" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                                <th>Kit Name</th>
                                                                <th>Received Date</th>
                                                                <th>Quantity</th>
                                                                
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                    data.forEach((item, index) => {



                        table += `<tr>
                        <td>${item.SerialNo}</td>
                        <td>${item.TranDate}</td>
                        <td>${item.Qty}</td>
                      
                        
                        </tr>`

                    })

                    table += `</tbody>
                    </table>`

                    $("#tableAll").append(table)

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
            })

            $("#dailyPrintedKits").on("click", function() {
                $("#tableAll").html(' ')
                url = '<?php echo base_url('Dashboard/dailyPrintedKits') ?>';
                $.post(url, function(data) {

                    let table = '';
                    table += ` <table class="table table-striped table-hover table-sm" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                                <th>PO Code</th>
                                                                <th>Kit Name</th>
                                                                <th>Quantity</th>
                                                                <th>Print Date</th> 
                                                                <th>Wastage</th> 
                                                                <th>Wastage Description</th> 
                                                                <th>Printed By</th> 
                                                               
                                                                <th>Issue Date</th>
                                                                <th>Issued To</th>
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                    data.forEach((item, index) => {


                        table += `<tr>
                        <td>${item.POCode}</td>
                        <td>${item.SerialNo}</td>
                        <td>${item.KitQty}</td>
                        <td>${item.IssuanceDate}</td>
                        <td>${item.Wastage}</td>
                        <td>${item.westage_description}</td>
                        <td>${item.Issuedby}</td>
                        <td>${item.IssueDate}</td>
                       
                        <td>${item.Receivedby}</td>
                        
                        </tr>`

                    })

                    table += `</tbody>
                </table>`

                    $("#tableAll").append(table)

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
            })


            // <th>Days</th>
            //                         <th>Key NO.</th>
            //                         <th>Issue Qty</th>


            // <td>${element['Days'] }</td>
            //                             <td>${element['KeyNum'] }</td>   
            //                             <td>${element['IssueQty']}</td>

            $("#balanceIssued").on("click", function() {
                let table = "";

                let urlissuanceStock = '<?php echo base_url('Kitsissuance/issuanceStock') ?>';
                $.post(urlissuanceStock, (data) => {
                    $("#tableAll").html("")



                    // console.log(data);
                    // if(data.issuanceStock.length > 0){
                    // totalstock = data.issuanceStock;
                    // data.issuanceStock.filter(item => {if(KitQty != IssueQty)
                    // stock.push(item);
                    // })
                    // }

 $("#issuedDate").css("display","none");

                    table += ` <table id="tableExport" class="table table-bordered table-hover table-striped w-100">
                            <thead style="background-color:black; color:white;">
                                <tr>
                                    <th>PO Code</th>
                                    <th>Plan Date</th>
                                    <th>Order Qty</th>
                                    <th>Kits No</th>

                                    <th>Print Date</th>
                                    <th>Printed Qty</th>
                                    <th>Type</th>
                                    <th>Printed By</th>
                                    <th>Received By</th>
                                    <th>Issue Date</th>
                                    
                               
                                
                                </tr>
                            </thead>
                            <tbody>`;

                    data['IssueBalance'].forEach(element => {
                        table += ` <tr>
                                        <td>${element['POCode']}</td>
                                        <td>${element['PlanDate'] }</td>
                                        <td>${element['OrderQty'] }</td>
                                        <td>${element['SerialNo'] }</td>

                                        <td>${element['PrintDate'] }</td>
                                        <td>${element['KitQty'] }</td>

                                        <td>${element['Type'] }</td>
                                        <td>${element['Issuedby'] }</td>
                                        <td>${element['Receivedby'] ? element['Receivedby'] : 'Pending' }</td>
                                        <td>${element['IssueDate'] ? element['IssueDate'] : 'Pending' }</td>                                        
                                       
                                      

                                    </tr>`
                    })

                    table += `</tbody>
                            </table>`
                    $("#tableAll").append(table);
                    $('#tableExport').dataTable({
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
                })
                // .done(function() {
                //     $("#overlay").fadeOut(300);
                // })
                // .fail(function() {
                //     $("#overlay").fadeOut(300);

                // })
            })



            $("#dailyIssued").on("click", function() {
                $("#tableAll").html(' ')
                url = '<?php echo base_url('Dashboard/dailyIssued') ?>';
                $.post(url, function(data) {

                    let table = '';
                    table += ` <table class="table table-striped table-hover table-sm" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                                <th>PO Code</th>
                                                                <th>Kit Name</th>
                                                                <th>Quantity</th>
                                                                <th>Print Date</th> 
                                                                <th>Wastage</th> 
                                                                <th>Wastage Description</th> 
                                                                <th>Printed By</th> 
                                                               
                                                                <th>Issue Date</th>
                                                                <th>Issued To</th>
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                    data.forEach((item, index) => {


                        table += `<tr>
                        <td>${item.POCode}</td>
                        <td>${item.SerialNo}</td>
                        <td>${item.KitQty}</td>
                        <td>${item.IssuanceDate}</td>
                        <td>${item.Wastage}</td>
                        <td>${item.westage_description}</td>
                        <td>${item.Issuedby}</td>
                        <td>${item.IssueDate}</td>
                       
                        <td>${item.Receivedby}</td>
                        
                        </tr>`

                    })

                    table += `</tbody>
                    </table>`

                    $("#tableAll").append(table)

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
            })
        </script>
    </body>

    </html>
<?php

}

?>