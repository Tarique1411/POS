<?php

$sync_type = $this->input->get('type'); 
if($sync_type =='sync_out')
{
	$attrib = array('data-toggle' => 'validator', 'role' => 'form', 'method' => 'get','class' => 'form-horizontal','id'=>'add_org');
	echo form_open('welcome/intrmExport', $attrib);
}
if($sync_type =='sync_in')
{
	$attrib = array('data-toggle' => 'validator', 'role' => 'form','method' => 'get', 'class' => 'form-horizontal','id'=>'add_org');
	echo form_open('welcome/POSImport', $attrib);
}
if($sync_type =='sync_empty')
{
	$attrib = array('data-toggle' => 'validator', 'role' => 'form', 'method' => 'get','class' => 'form-horizontal','id'=>'add_org');
	echo form_open('welcome/syncPosOrg', $attrib);
}

?>

<div class="row">
<div class="form-group">
    <label class="control-label col-sm-2" for="org_list">Choose Warehouse*</label>
    <select name="org_id" id="org_id" required="required"  style="width: 30%;">
	<!-- <option value="">select warehouse</option> -->
	<?php 
	foreach($warehouselist as $warehouselists)
	{?>
	
	<option value="<?php echo base64_encode($warehouselists->ORG_ID); ?>"><?php echo $warehouselists->ORG_DESC; ?></option>
		
	<?php } ?>
	
	</select>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">

        <button type="button" id="load" onclick ="mloading()" class="btn btn-primary">Submit</button>
    </div>
</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">


    function mloading()
    {
    	$('#load').html('<div id="loading-image"><img src="<?= $assets ?>/images/ajax-loader.gif" alt="Loading..." /></div>');

        document.getElementById("add_org").submit();
    }	

    $(document).ready(function () {

        $('#add_org').validate({

            rules:{
                org_list:{
                    required:true
                }
                
            },
            messages:{
                org_list:{
                    required:"Please choose a  warehouse location!"
                }
            }
        });
        
        
    });
</script>
