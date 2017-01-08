<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
        Leave Application Histories
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Leave Histories</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">       
        <div class="col-md-12">
			 <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Leaves</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
             
              <div class="table-responsive mailbox-messages">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<td><label>Sr.No.</label></td>
							<td><label>Leave Date From</label></td>
							<td><label>Leave Date To</label></td>
							<td><label>Leave Request Date</label></td>
							<td><label>Reporting Manager</label></td>
							<td><label>Leave Status</label></td>
							
						</tr>
					</thead>

					<tbody>
						
						<?php if( isset($leave_history) && !empty($leave_history) ){ ?>
						<?php 
						$i = 1;
						foreach($leave_history as $key => $leave){?>
						<tr>
							<td class="mailbox-name"><?php echo $i++;?></td>
							<td class="mailbox-name"></td>
							<td class="mailbox-subject"></td>
							<td class="mailbox-date"></td>
							<td colspan="2" class="mailbox-subject">
								
							</td>
						</tr>
						<?php  } ?>
						<?php } else {?>
						<tr>
							<td colspan="6" style="text-align:center;color:red"><label>No History Found</label></td>
						</tr>
						
						<?php }?>
					</tbody>
				</table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding"><div class="pull-left">				<a class="btn btn-primary btn-xs" href="javascript:history.go(-1);"><i class="fa fa-arrow-left"></i> Go Back </a> 			  </div>   
              <div class="mailbox-controls">				
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