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
                        $CurrentMonth = $Year . '-' . $Month;
                        $formattedMonth = date('F Y', strtotime($CurrentMonth));
                        echo '<script> let month = ' . json_encode($formattedMonth) . '; console.log("month:", month); </script>';

                        ?>

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
                                        <br><br>
                                        <div class="row" id="Kitsname">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-control-label">Audit Month:</label>
                                                    <select class="form-control kitsSelectbox" name="AuditID" id="Audit" required="true" onchange="loadMonth()">
                                                        <option value="">Select Audit Month</option>
                                                        <?php foreach ($getAuditID as $key => $value) {
                                                                ?>
                                                                <option value="<?php echo $value['TID'] ?>"><?php echo $value['AuditMonth'] ?></option>
                                                                <?php } ?>
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
                                            <div class="col-md-2">

                                                <label>Westage:</label>
                                                <div class="form-group-inline">

                                                    <input name="SR" value="0" id="Westage"  class="form-control" type="text" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Balance:</label>

                                                <div class="form-group-inline">

                                                    <input name="Balance" readonly="readonly" id="Balance" class="form-control" type="text">
                                                </div>
                                            </div>
                                        
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
                                                        <option value="Red Tape">Red Tape</option>
                                                        <option value="Printing">Printing</option>
                                                        <option value="Quality Issue">Quality Issue</option>
                                                        <option value="White Wastage">White Wastage</option>
                                                        <option value="Test PO">Test PO</option>

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
                                          
                                        </div>
                                        <br><br>

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
                </main>
            </div>
    
      
            <script>
               

               function loadMonth(){
                let IDs = $("#Audit").val();
                let url5 = "<?php echo base_url('Westage1/loadWastageAudit') ?>";

data = {
    "AuditID": IDs
};

$.post(url5, data, function(data) {

    console.log("Audit Month Data", data);

})
                

               }
               
               function loadbalance() {
                        //alert('I am here');
                        var Kits = $("#Kits").val()
                        url = "<?php echo base_url("index.php/Westage1/json_by_machine_balance/") ?>" + Kits
                        //alert(url);       
                        $.get(url, function(data) {
                            html = data[0].AvailableBalance

                            // console.log(html);


                            $("#Balance").val(html)
                        });
                    }

               $("#Kits").change(function(e) {
                     
                        loadbalance()
                });


                $("#kitsdata").on("click", function() {

                    let kits = $("#Kits").val();
    let Westage = $("#Westage").val();
    let issuedate = $("#issuedate").val();
    let westageCons = $("#westageCons").val();
    let IDs = $("#Audit").val();

    console.log('Westage', Westage);
    console.log('Issue', issuedate);
    console.log('Westage Cons', westageCons);


    
    url = "<?php echo base_url('Westage1/getAuditID') ?>";

$.post(url, { 'AUDIT_ID': IDs }, function(res) {

console.log("Audit IDS", res[0]['TID']);
IDs = res[0]['TID'];

})

var Bal = $("#Balance").val();



let data = {
        "kits": kits,
        "Bal": Bal,
        "Westage": Westage,
        "issuedate": issuedate,
        "westageCons": westageCons,
        "auditID": IDs
};

 



let url3 = "<?php echo base_url('Westage1/insertWastage') ?>";

$.post(url3, data, function(data) {

console.log('Added Data Successfully');

})



                })

               $(document).ready(function(){



               })



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