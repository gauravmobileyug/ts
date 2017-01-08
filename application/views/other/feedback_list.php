<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
			Feedbacks
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Feedbacks</li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-xs-12">
  <div class="box">
	<div class="box-header">
	  <h3 class="box-title">All Feedbacks</h3>

	  <div class="box-tools">
		
	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive ">
		<table class="table table-hover table-striped">
			<tbody>
				<tr>
				  <th>Sr.No</th>
				  <th>Name</th>
				  <th>User Id</th>
				  <th>Subject</th>
				  <th>Date Added</th>
				  <th>Action</th>
				</tr>
				<?php if( !empty($feedbacks) ) { ?>
					<?php foreach($feedbacks as $key => $item){ ?>
					
					
					
					<div id="feedback-<?=$item['feedback_id']?>" class="modal fade" role="dialog">	
					
						<div class="modal-dialog">	
							<div class="modal-content">	
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Feedback Message</h4>	
								</div>			  		
								<div class="modal-body" style="height: auto;">
								
									<p>
										<?=$item['message']?>
									</p>		
							
									
								</div>	
								<div class="modal-footer">	
									
								</div>		
							</div>	
						</div>	
						
						
					</div>
				
						<tr>
							<td><?=$count++;?></td>
							<td><?php echo $item['name'];?></td>
							<td><?php echo $item['user_id'];?></td>
							<td><?php echo $item['subject'];?></td>
							<td><?php echo date('d M Y', strtotime($item['date_added'])) ;?></td>
							<td>
								<a class="btn btn-primary btn-xs" href="javascript:void(0)" style="cursor: pointer;" data-toggle="modal" data-target="#feedback-<?=$item['feedback_id']?>"> View Message </a> | 
								<a class="btn btn-danger btn-xs" onclick="delete_feedback('<?=$item['feedback_id'];?>')"> Delete Message </a>  
								
							</td>
						</tr>
					<?php }?>
				<?php }else{?>
						<tr>
							<td colspan="7" style="text-align:center"><label class="text-danger">No Feedbacks Found !</label></td>
						</tr>
						<?php } ?>
				
			</tbody>
		</table>
	</div>
	<div class="box-footer clearfix">
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
	<!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
</div>
</section>
</div>