

    <?php
if(!($this->session->has_userdata('user_id'))){
  redirect('login');
}else{
?>


<?php
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
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            /** 
             * Load theme options
             **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            }
            else
            {
                console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);
            }
            /** 
             * Save to localstorage 
             **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /** 
             * Reset settings
             **/
            var resetSettings = function()
            {
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
                       
                    
                        <div>
                            <div>
                            
                            <!-- Popup Form Button --> 


<div id="ModalLoginForm" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
<!-- Modal HTML Markup -->
<!-- <div  class="modal fade"> -->
   <!--  <div class="modal-dialog" role="document">
        <div class="modal-content">-->
            <div class="modal-header">
                <h1 class="modal-title">Add Asset</h1>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="">
                    <!-- <input type="hidden" name="_token" value=""> -->
                   <div class="row">
                        <div class="form-group col-md-3">
                      <label for="sel1">Type</label>
                      <div>
                        <select class="form-control" id="sel1" name="assetType" >
                        <option value="" disabled selected>Select one of the following</option>
                        <option>Type 1</option>
                            <option>Type 2</option>
                            <option>Type 3</option>
                            <option>Type 4</option>
                            </select>
                     </div>
                 </div> 
                    <div class="form-group col-md-3">
                        <label class="control-label">Asset Name</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="assetName" placeholder="Enter Asset Name">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Cost</label>
                        <div>
                            <input type="number" class="form-control input-lg" name="assetCost" placeholder="Enter Asset Cost">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Purchase Date</label>
                        <div>
                            <input type="date" class="form-control input-lg" name="assetPurchaseDate" placeholder="Enter Asset Purchase Date">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Overall Cost</label>
                        <div>
                            <input type="number" class="form-control input-lg" name="assetOverallCost" placeholder="Enter Asset Overall Cost">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                    <label class="control-label">Original Life Id</label>
                        <div>
                            <input type="number" class="form-control input-lg" name="assetOriginalLifeId" placeholder="Enter Asset Original Life ID">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Depreciation</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="assetDepreciation" placeholder="Enter Asset Depreciation">
                        </div>
                    </div>
                 <div class="form-group col-md-3">
                     <div>
                     <label for="sel1">Depreciation Method</label>
                        <select class="form-control" id="sel1" name="assetDepMethod" >
                        <option value="" disabled selected>Select one of the following</option>
                        <option>Method 1</option>
                            <option>Method 2</option>
                            <option>Method 3</option>
                            <option>Method 4</option>
                            </select>
                        </div> 
                   </div>
                        <div class="form-group col-md-3">
                        <label class="control-label">Percentage</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="assetPercentage" placeholder="Enter Percentage">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                    <label class="control-label">Expiry</label>
                        <div>
                            <input type="date" class="form-control input-lg" name="assetExpiry" placeholder="Enter Asset Expiry">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                    <label class="control-label">Depreciation Start</label>
                        <div>
                            <input type="date" class="form-control input-lg" name="assetDepStart" placeholder="Enter Depreciation Starting Date">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                    <div>
                    <label class="control-label">Depreciation End</label>
                            <input type="date" class="form-control input-lg" name="assetDepEnd" placeholder="Enter Depreciation Ending Date">
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                    <div>
                    <label class="control-label">Location</label>
                        
                            <input type="text" class="form-control input-lg" name="assetLocation" placeholder="Enter Asset Location">
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label">Password</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="password">
                        </div>
                    </div> -->
                    <!-- <div class="form-group col-md-3">
                        <div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="status"> Status
                                </label>
                            </div>
                        </div>
                    </div> --> 
                    </div>
                    <br><br>
                    <div class="row">
                    <div class="form-group col-md-3">
                        <div>
                            <button type="submit" class="btn btn-success">Save</button>
                            
                            <button type="submit" class="btn btn-success">Clear</button>

                            <button type="submit" class="btn btn-success">Close</button>
                           <!--  <a class="btn btn-link" href="">Forgot Your Password?</a> -->
                        </div>
                    </div>
        </div>
        
                </form>
        
          <!--       <h1>Or Signup!</h1>
                <form role="form" method="POST" action="">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">E-Mail Address</label>
                        <div>
                            <input type="email" class="form-control input-lg" name="email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Confirm Password</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-success">
                                Register
                            </button>
                        </div>
                    </div>
                </form> -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<br><br>
                                <!--Table responsive-->
                                <div id="panel-8" class="panel">
                                    <div class="panel-hdr">
                                        <h2>
                                        <i class='fal fa fa-table text-primary'></i>&nbsp;&nbsp;Assets Overall Records 
</span>
                                        </h2>
                                        <button type="button" class="btn btn-primary" style="float:right;" data-toggle="modal" class="d-grid gap-2 d-md-block float-right" data-target=".bd-example-modal-xl">+ Create</button>
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                    <!--         <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> -->
                                        </div>
                                    </div>
                                    <div class="panel-container show">
                                        <div class="panel-content">
               <!--                              <div class="panel-tag">
                                                Make table responsive with <code>.table-responsive</code>. Maximum breakpoint can be applied by adding <code>.table-responsive-sm</code>, <code>.table-responsive-ms</code>, <code>.table-responsive-lg</code>, <code>.table-responsive-xl</code>
                                            </div>
 -->                                            <div class="table-responsive-lg">
                                                <table class="table table-bordered m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Table</td>
                                                            <td>True</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                  
                    <?php
        $this->load->view('after-main');
       ?>
        <!-- END Page Settings -->
        <!-- base vendor bundle: 
			 DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations 
						+ pace.js (recommended)
						+ jquery.js (core)
						+ jquery-ui-cust.js (core)
						+ popper.js (core)
						+ bootstrap.js (core)
						+ slimscroll.js (extension)
						+ app.navigation.js (core)
						+ ba-throttle-debounce.js (core)
						+ waves.js (extension)
						+ smartpanels.js (extension)
						+ src/../jquery-snippets.js (core) -->
       <?php
        $this->load->view('Foter');
       ?>

    </body>
</html>
<?php

}

?>