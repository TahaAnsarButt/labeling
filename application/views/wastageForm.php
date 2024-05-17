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
                                ?>
                                <div id="exampleModalEditMat" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                            Audit <span class="fw-300"><i>Form</i></span>
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
                                                    <div class="col-md-2">
                                                        <label>Create an entry</label>
                                                        <div class="form-group-inline">

                                                            <!-- <button class="btn btn-primary" id="kitsdata1">Submit</button> -->
                                                            <button class="btn btn-primary" id="openForm">Create</button>

                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- <div class="row ">
                                                    <div class="col-sm-1">
                                                         <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2"  >
                                                                <label class="custom-control-label" for="customSwitch2">Reprint</label>
                                                            </div> 
                                                    </div> -->
                                                <!-- <div class="col-md-3">
                                                        <label>Start Date :</label>
                                                        <div class="form-group-inline">

                                                            <input name="date" id="date1" class="form-control" type="date" value="<?php echo $CurrentDate; ?>" onchange="loadWastageData()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>End Date</label>
                                                        <div class="form-group-inline">

                                                            <input name="date" id="date2" class="form-control" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" type="date" value="<?php echo $CurrentDate; ?>">
                                                        </div>
                                                    </div> -->
                                                <!-- <div class="col-md-3">
                                                        <label>Audit Month</label>
                                                        <div class="form-group-inline">

                                                            <input name="date" id="date3" class="form-control" type="month">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">

                                                        <label>Wastage Quantity:</label>
                                                        <div class="form-group-inline">

                                                            <input name="SR" value="0" id="Westage" onchange="westageChange()" class="form-control" type="text" value="">
                                                        </div>
                                                    </div> -->
                                                <!-- </div>  -->

                                                <!-- <br><br> -->
                                                <!-- <div class="row" id="Kitsname">
                                                    <div id="westageDesc" style="display:block" class="col-md-3">
                                                        <div class="form-group">
                                                            <lable class="form-control-label " for="duration">Wastage Description:</lable>
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
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <lable class="form-control-label" for="duration">Kits Name:</lable>
                                                            <?php
                                                            //print_r($Kits);


                                                            ?>
                                                            <select class="form-control kitsSelectbox" name="kitsName" id="Kits">
                                                                <option value="">Select Kits Name :</option>

                                                                <?php
                                                                if ($this->session->userdata('user_id') == 2197) {
                                                                    foreach ($atif_array as $Key) {
                                                                ?>
                                                                        <option value="<?php echo $Key['RecID'] ?>"><?php echo $Key['SerialNo'] ?></option>
                                                                    <?php
                                                                    }
                                                                } else if ($this->session->userdata('user_id') == 2199) {
                                                                    foreach ($haroon_array as $Key) {
                                                                    ?>
                                                                        <option value="<?php echo $Key['RecID'] ?>"><?php echo $Key['SerialNo'] ?></option>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    foreach ($Kits as $Key) {
                                                                    ?>

                                                                        <option value="<?php echo $Key['RecID'] ?>"><?php echo $Key['SerialNo'] ?></option>

                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-md-1">
                                                        <label>Balance:</label>

                                                        <div class="form-group-inline">

                                                            <input name="Balance" readonly="readonly" id="Balance" class="form-control" type="text">
                                                        </div>
                                                    </div> -->
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
                                                <!-- <div class="col-md-2">
                                                        <label>Print Date :</label>
                                                        <div class="form-group-inline">

                                                            <input name="date" id="issuedate" class="form-control" value="<?php echo $CurrentDate; ?>" type="date">
                                                        </div>
                                                    </div> -->




                                                <!-- </div>  -->




                                                <br><br>
                                                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Wastage</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="formsubmit">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="fname">Audit Month</label>
                                                                            <input type="text" id="AuditMonth" class="form-control">
                                                                            <input type="hidden" id="TID" class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="fname">Description</label>
                                                                            <input type="text" id="Description" class="form-control">
                                                                            <input type="hidden" id="TID" class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="fname">Duration</label>
                                                                            <input type="text" id="Duration" class="form-control">
                                                                            <input type="hidden" id="TID" class="form-control">
                                                                        </div>
                                                                        <!-- 

                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" id="checkId" checked="">
                                                                            <label class="custom-control-label" for="checkId">Status</label>
                                                                        </div> -->



                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" id="submitBtnUpdate">Update Data</button>
                                                                    <button type="button" class="btn btn-primary" id="submitBtn">Add Data</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                               




                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive-lg" id="kitsWastage">
                                                            
                                                        </div>
                                                    </div>
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
            <?php
            // $this->load->view('after-main');
            ?>


            <script>
                
                $('#openForm').click(function() {
                        $('#Description').val("");
                        $('#AuditMonth').val("");
                        $('#Duration').val("");
                        $("#submitBtn").css('display','block');
                        $("#submitBtnUpdate").css('display','none');
                        $('#modal').modal('toggle');

                        // alert('hello');
                    });
                function editEntry(TID) {
                    console.log(TID);
                        $.post(
                            "<?php echo base_url('Westage/getID'); ?>",
                            {"TID":TID},
                            function(data) {
                                $('#AuditMonth').val(`${data.AuditMonth}`);
                                $('#Duration').val(`${data.Duration}`);
                                $('#Description').val(`${data.Description}`);
                                $('#TID').val(`${data.TID}`);
                                $("#submitBtn").css('display','none');
                                $("#submitBtnUpdate").css('display','block');
                                $('#modal').modal('toggle');
                            
                        })
                    }
                    function deleteEntry(TID) {
                    console.log(TID);
                    let result  = confirm("are you sure you want to delete this entry");
                    if(result){
                        $.post(
                            "<?php echo base_url('Westage/deleteByID'); ?>",
                            {"TID":TID},
                            function(data) {
                                loadWastageData();
                        })}
                    }
                $(document).ready(function() {
                    loadWastageData();

                    ($('#submitBtn').click(function() {
                        // alert('clicked')
                        // console.log("clicked");
                        var url = "<?php echo base_url('Westage/AddWastageForm'); ?>";
                        console.log("URL:", url);
                        var AuditMonth = $('#AuditMonth').val()
                        var Description = $('#Description').val()
                        var Duration = $('#Duration').val()

                        // var data = {
                        //     var AuditMonth: $('#AuditMonth').val(),
                        //     var Description: $('#Description').val(),
                        //     var Duration: $('#Duration').val(),
                        // };

                        $.ajax({
                            url: "<?php echo base_url('Westage/AddWastageForm'); ?>",
                            type: 'post',
                            data: {
                                "AuditMonth": AuditMonth,
                                "Description": Description,
                                "Duration": Duration
                            },
                            success: function(data) {
                                loadWastageData();
                                // console.log(data);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.error("error:", xhr.responseText);
                            }
                        });
                        $('#modal').modal('hide');
                    }));

                    


                    ($('#submitBtnUpdate').click(function() {
                        // alert('clicked')
                        var url = "<?php echo base_url('Westage/UpdateWastageForm'); ?>";
                        console.log("URL:", url);
                        var data = {
                            AuditMonth: $('#AuditMonth').val(),
                            Description: $('#Description').val(),
                            Duration: $('#Duration').val(),
                            TID: $('#TID').val()
                        };

                        $.post({
                            url: url,
                            data: data,
                            success: function(data) {
                                loadWastageData();
                                // console.log(data);
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.error(xhr.responseText);
                            }
                        });
                        $('#modal').modal('hide');
                    }));





                    // $('#DeleteEntry').click(function(T_ID) {

                    // })

                });


                function loadWastageData() {
                    $("#kitsWastage").html(' ')
                    let url4 = "<?php echo base_url('Westage/loadWastageMasterForm') ?>"
                    $.post(url4, function(data) {
                        console.log(data)

                        let table = '';
                        table += ` <table class="table table-striped table-hover table-sm" id="tableExport">
                                                        <thead style="background-color:black; color:white;">
                                                           <tr>
                                                               <th>Audit Month</th>
                                                                <th>Description</th>
                                                                <th>Duration</th>
                                                                <th>Entry Date</th>
                                                                <th>Action</th>

                                                              
                                                            
                                                           </tr>
                                                        </thead>
                                                       <tbody >`
                        data.forEach((item, index) => {

                            table += `<tr>
                        
                        <td>${item.AuditMonth}</td>
                        <td>${item.Description}</td>
                        <td>${item.Duration}</td>
                        <td>${item.Narration}</td>
                        <td><button class="btn btn-info btn-sm" onclick ="editEntry(${item.TID})">Edit</button>
                        <button class="btn btn-danger btn-sm ml-4" onclick ="deleteEntry(${item.TID})">Delete</button></td>
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
    </body>

    </html>
<?php

}

?>