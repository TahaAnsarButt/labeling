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
                    <div id="overlay">
                        <div class="cv-spinner">
                            <span class="spinner"></span>
                        </div>
                    </div>
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
                                <?php
                                $Month = date('m');
                                $Year = date('Y');
                                $Day = date('d');
                                $CurrentDate = $Year . '-' . $Month . '-' . $Day;
                                ?>

                                <!-- <form method="POST" , action="<?php echo base_url('Kitsissuance/reportFilter') ?>"> -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Issue Date Start :</label>
                                        <div class="form-group-inline">

                                            <input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Issue Date End :</label>
                                        <div class="form-group-inline">

                                            <input name="date1" id="date2" class="form-control" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" type="date" value="<?php echo $CurrentDate; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="margin-top:24px;">
                                        <button type="button" class="btn btn-primary" id="searchReport">Search</button>
                                    </div>
                                </div>
                                <!-- <form> -->

                                <div id="appendTableLocal">

                                    <!-- <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                        <thead class="bg-primary-600">
                                            <tr>
                                                <th>PO Code</th>
                                                <th>Order Qty</th>
                                                <th>Kits No</th>

                                                <th>Print Date</th>
                                                <th>Printed Qty</th>
                                                <th>Type</th>
                                                <th>Printed By</th>
                                                <th>Received By</th>
                                                <th>Issue Date</th>
                                                <th>Issue Qty</th>
                                                <th>Wastage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($report as $key) { ?>
                                                <tr>
                                                    <td><?php echo $key['POCode'] ?></td>
                                                    <td><?php echo $key['OrderQty'] ?></td>
                                                    <td><?php echo $key['SerialNo'] ?></td>

                                                    <td><?php echo $key['PDate'] ?></td>
                                                    <td><?php echo $key['KitQty'] ?></td>

                                                    <td><?php echo $key['Type'] ?></td>
                                                    <td><?php echo $key['Issuedby'] ?></td>
                                                    <td><?php echo $key['Receivedby'] ?></td>
                                                    <td><?php echo $key['IDate'] ?></td>
                                                    <td><?php echo $key['IssueQty'] ?></td>
                                                    <td><?php echo $key['Wastage'] ?></td>

                                                </tr>

                                            <?php } ?>




                                        </tbody> -->


                                    <!-- <tr>
														<th></th>
														<th></th>
														<th></th>
														<th></th>
														<th></th>
														<th></th>
														<th></th>	
														<th></th>	
														<th></th>	
														<th></th>														<th></th>

														<th class="bg-primary"><h1 class="text-white font-weight-bold">Total</h1><span class="text-white font-weight-bold" style="font-size:22px"><?php echo number_format($total) ?><span>
                                                        
                                                        </th>
                                                       
                                                   

												</tr> -->

                                    </table>
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
            $("#searchReport").on("click", function() {
                $(document).on({
                    ajaxStart: function() {
                        $("#overlay").fadeIn(300);
                    },
                    // ajaxStop: function(){ 
                    //     alert("loadding stop")
                    // }    
                });
                $("#appendTableLocal").html(' ')
                sdate = $("#date1").val();
                edate = $("#date2").val();
                let urlReport = '<?php echo base_url('Kitsissuance/reportFilter') ?>'
                $.post(urlReport, {
                        "sdate": sdate,
                        "edate": edate
                    }, (data) => {


                        let table = '';

                        table += ` <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                            <thead class="bg-primary-600">
                                                <tr>
                                                    <th>PO Code</th>
                                                    <th>Order Qty</th>
                                                    <th>Kits No</th>
                                                    <th>Print Date</th>
                                                    <th>Printed Qty</th>
                                                    <th>Type</th>
                                                    <th>Printed By</th>
                                                    <th>Received By</th>
                                                    <th>Issue Date</th>
                                                    <th>Issue Qty</th>
                                                
                                                </tr>
                                            </thead>
                                            <tbody>`;

                        data['report'].forEach(element => {
                            table += ` <tr>
                                                        <td>${element['POCode']}</td>
                                                        <td>${element['OrderQty'] }</td>
                                                        <td>${element['SerialNo'] }</td>
                                                        <td>${element['PDate'] }</td>
                                                        <td>${element['KitQty'] }</td>
                                                        <td>${element['Type'] }</td>
                                                        <td>${element['Issuedby'] }</td>
                                                        <td>${element['Receivedby'] }</td>
                                                        <td>${element['IDate'] }</td>
                                                        <td>${element['IssueQty']}</td>
                                                      

                                                    </tr>`
                        })

                        table += `</tbody>
                                            </table>`
                        $("#appendTableLocal").append(table);
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
                    }).done(function() {
                        $("#overlay").fadeOut(300);
                    })
                    .fail(function() {
                        $("#overlay").fadeOut(300);

                    })
            })
        </script>
    </body>

    </html>
<?php

}

?>