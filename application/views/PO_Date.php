 <div class="row">
                     
<div class="col-md-5"  id="exampleModalEditMat">
                        <div class="form-group">
                            <lable class="form-control-label" for="duration">PO Code:</lable>
                            <br>
                            <select class="form-control mySelectMatProEdit" data-live-search="true" searchable="Search here.."  name="PO" id="PoCode">
                             <option value="">Select PO :</option>
                               <?php
                                  foreach ($getPO as $Key) {
                         ?>
                        <option value="<?php echo $Key['PO'] ?>" ><?php echo $Key['POCode'] ?></option>
                        <?php
                        }
                  ?>
                  </select>
                        </div>
                    </div>
                       <div class="col-md-4">
                       <label >Order Qty:</label>
                        <div class="form-group-inline">
                            
                            <input name="POQty" id="POQty" class="form-control" type="text" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                       <label >PO Wise Balance:</label>
                        <div class="form-group-inline">
                            
                            <input name="Balance" id="powisebalance" class="form-control" type="text" readonly>
                        </div>
                    </div>
                 </div>



                           <script>
    
$(document).ready(function(){
      
$("#PoCode").change(function(e) {
loadQty()
     });
     function loadQty(){
          var PO =  $("#PoCode").val()
            url = "<?php echo base_url("index.php/Kitsissuance/json_by_machine/") ?>" + PO 
            //alert(url);       
 $.get(url, function(data) {
  console.log(data);
 html = data[0].OrderQty
  balance = data[0].Balance
 
                $("#POQty").val(html)
                  $("#powisebalance").val(Math.abs(balance))
                  
 });
        }
         $('.mySelectMatProEdit').select2(
        {
  dropdownParent: $('#exampleModalEditMat')
}
    );
});


</script>
