

    <?php
if(!($this->session->has_userdata('user_id'))){
  redirect('login');
}else{

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
                    <?php
      if($this->session->flashdata('Proinfo')){ 
    
    
      ?>
    <div class="alert alert-danger alert-dismissible show fade" id="msgbox">
                    <div class="alert-body">
                      <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                      </button>
                      <?php echo $this->session->flashdata('Proinfo');?>
                    </div>
                  </div>
                  <?php
      }

                  ?>
                      
                          <div>
                            <div>
                
                            <table id="Data" class="table table-bordered table-hover table-striped w-100">
                                                <thead class="bg-primary-600">
													
                                                    <tr>
                                                        <th>Serial No</th>
                                                        <th>Received Quantity</th>
                                                        <th>Issue Quantity</th>
                                                        <th>Available Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                            
												<?php foreach($Ledger as $key){?>
                                                    <tr>
                                                        <td><?php echo  $key['SerialNo'] ?></td>
                                                        <td><?php echo $key['RecQty'] ?></td>
                                                        <td><?php echo   $key['IssueQty']?></td>
                                                        <td><?php echo   $key['AvailableBalance']?></td>
                                                      
                                                        
                                                    </tr>
                                            
                                                   <?php 
												}  
												   ?>
                                                </tbody>
                                                
                                            </table>

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
    $(document).ready(function() {


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



});
</script>


</body>
</html>

<?php
        $this->load->view('Foter');
       ?>  

<?php

}

?>
