<?php if ($Owner || $Admin || $Manager) {
		echo form_open('purchases/till_actions', 'id="action-form", method="post", role="form"');
} ?>
<?php if ($this->session->flashdata('update_error')) { ?>
    <div class="alert alert-danger"> <?= $this->session->flashdata('update_error') ?> </div>
<?php }else if($this->session->flashdata('update_success')){ ?>
	<div class="alert alert-success"> <?= $this->session->flashdata('update_success') ?> </div>
<?php }?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('manage_till'); ?></h2>	
    </div>
	<div id="message">
	</div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>
				<?php 
					$exes = array();
					$exes[0] = "--Select User--";
					foreach($executives as $key=>$val){
						$exes[$val['id']] = $val['username'];
					}		
				?>
					<div class="table-responsive">
						<table class="table table-bordered table-condensed table-hover table-striped">
							<thead>
							<tr>				
								<th><?= lang("till_name"); ?></th>
								<th><?= lang("till_ip"); ?></th>
								<th>Store ID</th>
								<th>User ID</th>
								<th style="width:160px;"><?= lang("actions"); ?></th>	
							</tr>
							</thead>
							<?php  
                                                            if(!empty($tills)){
								foreach($tills as $key=>$val){
							?>
							<tbody>
                                                            <tr id="<?=$val->id?>">
                                                                <?php echo form_hidden('till_id[]',$val->id); ?>
                                                                    <td><?=$val->till_name?></td>
                                                                    <td><?=$val->till_ip?></td>
                                                                    <!--<td><?=$val->store_id?></td>-->
                                                                    <!-- change by vikas singh 23-08-2016 -->
                                                                    <td><?=$this->session->userdata('warehouse_id');?></td>
                                                                    <!-- end -->
                                                                    <td>
                                                                            <div class="form-group">
                                                                                    <?php 
                                                                                            echo form_dropdown('user_id[]',$exes,$val->user_id,'class="form-control select user" required="required" style="width:100%"'); 
                                                                                    ?>	
                                                                            </div>
                                                                    </td>
                                                                    <td><button id="tr_<?=$val->id?>" class="btn btn-primary add_user_till">Assign</button>
                                                                    <?php if($this->Owner) { ?>    
                                                                    <button id="tr_<?=$val->id?>" class="btn btn-primary delete_user_till">Delete</button> <!-- Added By Vikas -->
                                                                    <?php } elseif($GP['till-deleteTill'] == 1) { ?>
                                                                    <button id="tr_<?=$val->id?>" class="btn btn-primary delete_user_till">Delete</button></td>
                                                                    <?php } ?>
                                                            </tr>
                                                                <?php }
                                                                }
                                                                ?>
							</tbody>						
						</table>
					</div>
			<!---
				<div class="form-group">
                    <?php echo form_submit('add_till', $this->lang->line("till_add_batch"), 'class="btn btn-primary"'); ?>
                </div>
			--->
            </div>
        </div>
    </div>
</div>
<?php echo form_close();?>
<script type="text/javascript">
	$(document).ready(function(){	
		$('.add_user_till').on('click',function(event){
			event.preventDefault();
			var id = $(this).closest('tr').attr('id');
			var user_id = $(this).closest('tr').find(".user option:selected").val();
			$.ajax({
				method : "POST",
				url : "till/assignTillExecutive",
				data : {id : id,user_id : user_id},
				datatype: "json",
				success : function(response){				
					var sdata = $.parseJSON(response);					
					//$('tr#'+sdata['id']).find('select.user option').attr('selected',true);				
					if(sdata['msg'] == 'success'){
						var msg = '<div class="alert alert-success">till has been updated successfully</div>'
						$('#message').html(msg).show().fadeOut(8000);
					}else if(sdata['msg'] == 'failed'){
						var msg = '<div class="alert alert-danger">till has been updated</div>'
						$('#message').html(msg).show().fadeOut(8000);
					}else{
						var msg = '<div class="alert alert-danger">till has been already assigned to salesperson</div>'
						$('#message').html(msg).show().fadeOut(8000);
					}
						
				},
				error : function(jqXHR,textStatus,errorThrown){
					console.log(textstatus,errorThrown);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){	
		$('.delete_user_till').on('click',function(event){
			event.preventDefault();
			var id = $(this).closest('tr').attr('id');
                        var btn = this;
                        $.ajax({
			method : "POST",
		        url : "till/deleteTill",
			cache: false,				
			data:'id=' + id,
			success: function(response){
                        if (response == "true")
                        {
                        
                         $(btn).closest('tr').fadeOut("slow");
		         var msg = '<div class="alert alert-success">till has been deleted successfully</div>'
		         $('#message').html(msg).show().fadeOut(8000);
			 
                         }
                        else
                         {
                        alert("Something went worng!");
                         }
                       
                      }   
			
		});	
		});
	});
</script>




