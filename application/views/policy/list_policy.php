<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
        All Policies
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Policy</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">       
        <div class="col-md-12">
			<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Policy</h3>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
             
              <div class="table-responsive mailbox-messages no-padding">
				<table class="table dataTable table-hover table-striped" id="policy_list">
					<thead>
						<tr>
							<th><label>Sr.No.</label></th>
							<th><label>Title</label></th>
							<th><label>Policy Description</label></th>
							<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S' ) :?>
							<th><label>Save/Publish</label></th>
							<?php endif;?>
							<th><label>Date Added</label></th>
							<th><label>Date Modified</label></th>
							<th style="text-align: center;"><label>Action</label></th>
							
						</tr>
					</thead>

					<tbody>
						
						<?php if( isset($policies) && !empty($policies) ){ ?>
						<?php 
						
						foreach($policies as $key => $policy){?>
						<tr>
							<td class="mailbox-name"><?php echo $count++;?></td>
							<td class="mailbox-name" style="width: 12%;word-break: break-all;"><?php echo $policy['title'];?></td>
							<td class="mailbox-subject" style="width: 18%;word-break: break-all;"><?php echo substr($policy['short_description'], 0,30);?>...</td>
							
							
							<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S' ) :?>
							<td class="mailbox-subject">
								<?php echo $policy['publish'] == '1' ? "<label class='label label-success'>Published</label>" : "<label class='label label-warning'>Saved</label>";?>
							</td>
							<?php endif;?>
							
							<td class="mailbox-date"><?php echo date('d-m-Y' ,strtotime($policy['date_added']));?></td>
							<td class="mailbox-date"><?php echo date('d-m-Y' ,strtotime($policy['date_modified']));?></td>
							<td  class="mailbox-subject">
								<a  data-toggle="tooltip" title="View"  class="btn btn-info  btn-xs" href="<?php echo site_url('policy/view?id='.$policy['id']);?>">
									<i class="fa  fa-eye"></i>
								</a>
								<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S') { ?>	
								<a  data-toggle="tooltip" title="Edit"  class="btn btn-warning  btn-xs" href="<?php echo site_url('policy/create_policy?id='.$policy['id']);?>">
									<i class="fa  fa-edit"></i> 
								</a>
								
								<a data-toggle="tooltip" title="Delete"  class="btn btn-danger  btn-xs" href="javascript:void(0)" onclick="delete_policy('<?=$policy['id'];?>')">
									<i class="fa  fa-remove"></i> 
								</a>
								
								<?php } ?>								
								<?php if(!empty($policy['file'])) { ?>
								
								<a data-toggle="tooltip" title="Download" target="_blank" class="btn btn-primary btn-xs" href="<?php echo isset($policy['file']) ? base_url($policy['file']) : '#';?>">
									<i class="fa fa-download"></i> 
								</a>
								
								<?php }?>																
							</td>
						</tr>
						<?php  } ?>
						<?php } else {?>
						<!-- <tr>
							<td colspan="5" style="text-align:center;color:red"><label>No Policy Found</label></td>
						</tr> -->
						
						<?php }?>
						
					</tbody>
					
				</table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer padding">
              <div class="mailbox-controls">
				<div class="pull-left">
				
				</div>
			  
				<ul class="pagination pagination-sm no-margin pull-right">
				<?php 
					foreach ($links as $link) { 
						echo "<li>". $link."</li>";
					}
				?>
				</ul>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
  </div>
  
  <script>
  <?php if($user_data['role'] != 'H' || $user_data['role'] != 'S') { ?>	
	$(document).ready(function(){
		$('#policy_list').DataTable({	
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"columnDefs": [ {	
				"targets": [5],	
				"orderable": true 
			} ]
		});
	});
  <?php }else{ ?>

	$(document).ready(function(){
		$('#policy_list').DataTable({	
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true
		});
	});

  <?php } ?>
  </script>