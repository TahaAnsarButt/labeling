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
                    <?php
                    $this->load->view('template');
                    ?>
       
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
                            
                            <br><br>
                        <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Plan Date Start :</label>
                                        <div class="form-group-inline">

                                            <input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Plan Date End :</label>
                                        <div class="form-group-inline">

                                            <input name="date1" id="date2" class="form-control" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" type="date" value="<?php echo $CurrentDate; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="margin-top:24px;">
                                        <button type="button" class="btn btn-primary" id="searchReport">Search</button>
                                    </div>
                                </div>
                                                <br><br>

                                <div id="appendTableLocal">
                           
                                     <!-- <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                        <thead class="bg-primary-600">
                                            <tr>
                                                <th>PO Code</th>
                                                <th>Date</th>
                                                <th>FactoryCode</th>

                                                <th>Article</th>
                                                <th>Quantity</th>
                                                <th>Description</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reprinted as $key) { ?>
                                                <tr>
                                                    <td><?php echo $key['POCode'] ?></td>
                                                    <td><?php echo $key['Date'] ?></td>
                                                    <td><?php echo $key['FactoryCode'] ?></td>
                                                    <td><?php echo $key['Article'] ?></td>
                                                    <td><?php echo $key['Quantity'] ?></td>
                                                    <td><?php echo $key['Description'] ?></td>
                                                   

                                                </tr>

                                            <?php } ?>




                                        </tbody> 


                                     <tr>
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




$(document).ready(function(){
    $("#appendTableLocal").html(' ');

    var date1 = $("#date1").val();
    var date2 = $("#date2").val();

                let urlReport = '<?php echo base_url('Kitsissuance/getresult') ?>'
                $.post(urlReport, { 'date1':date1, 'date2': date2 },  (data) => {


                    console.log("heck", data);
                        let table = '';

                        table += ` <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                                            <thead class="bg-primary-600">
                                                <tr>
                                                    <th>PO</th>
                                                    <th>Quantity</th>
                                                    <th>Factory Code</th>
                                                    <th>Type</th>
                                                    <th>Reason</th>
                                                    <th>Plan Date</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>`;

                        data.forEach(element => {

                            const planDate = new Date(element.PlanDate);
            // Format the date as DD/MM/YYYY
            const formattedPlanDate = `${planDate.getDate()}/${planDate.getMonth() + 1}/${planDate.getFullYear()}`;


                            table += ` <tr>
                                                        <td>${element.POCode}</td>
                                                        <td>${element.quantity }</td>\
                                                        <td>${element.FactoryCode }</td>

                                                        <td>${element.type }</td>
                                                        <td>${element.reason }</td>
                                                        <td>${formattedPlanDate }</td>
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







$("#searchReport").on("click", function() {
    $(document).on({
        ajaxStart: function() {
            $("#overlay").fadeIn(300);
        }
    });
    $("#appendTableLocal").html('');
    sdate = $("#date1").val();
    edate = $("#date2").val();
    let urlReport = '<?php echo base_url('Kitsissuance/LabelFilter') ?>';
    $.post(urlReport, {
        "sdate": sdate,
        "edate": edate
    }, (data) => {
        let table = '';
        if (data.length > 0) {
            table += `<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>PO</th>
                                <th>Quantity</th>
                                <th>Type</th>
                                <th>Factory Code</th>
                                <th>Reason</th>
                                <th>Plan Date</th>
                            </tr>
                        </thead>
                        <tbody>`;
            data.forEach(element => {
                const planDate = new Date(element.PlanDate);
                const formattedPlanDate = `${planDate.getDate()}/${planDate.getMonth() + 1}/${planDate.getFullYear()}`;
                table += `<tr>
                            <td>${element.POCode}</td>
                            <td>${element.quantity}</td>
                            <td>${element.type}</td>
                            <td>${element.FactoryCode}</td>
                            <td>${element.reason}</td>
                            <td>${formattedPlanDate}</td>
                        </tr>`;
            });
            table += `</tbody></table>`;
        } else {
            table = `<div class="alert alert-warning" role="alert" style="margin-top: 20px;">
                        <strong>No Data Available</strong><br>Please adjust your selection criteria or check back later.
                    </div>`;
        }
        $("#appendTableLocal").html(table);
        if (data.length > 0) {
            $('#dt-basic-example').dataTable({
                responsive: true,
                lengthChange: false,
                dom: "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
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
        }
    }).done(function() {
        $("#overlay").fadeOut(300);
    })
    .fail(function() {
        $("#overlay").fadeOut(300);
    });
});

        </script>
    </body>

    </html>
<?php

}

?>