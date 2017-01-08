<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		All Miscellaneous Items
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Miscellaneous Items</li>
      </ol>
    </section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-xs-12">
  <div class="box">
	<div class="box-header">
	  <h3 class="box-title">All Items</h3>

	  <div class="box-tools">
		
	  </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive ">
		<table class="table table-hover table-striped">
			<tbody>
				<tr>
				  <th>Sr.No.</th>
				  <th>Title</th>
				  <th>Short Description</th>
				  <th>Status</th>
				  <th>Date Added</th>
				  <th>Action</th>
				</tr>
				<?php if( !empty($items) ) {?>
					<?php foreach($items as $key => $item){?>
						<tr>
							<td><?php echo $count++;?></td>
							<td><?php echo $item['title'];?></td>
							<td style="word-break: break-word; width: 50%;"><?php echo $item['short_description'];?></td>
							<td>
							
							<?php 
							if($item['status']) {
							?>
							<label class="label label-success"> Active <label>
							<?php
							}else{
							?>
							<label class="label label-danger"> Inavtive <label>
							<?php
							}
							?>
							
							</td>
							<td><?php echo date('d,M Y',strtotime($item['date_added']));;?></td>
							<td>
							<a class="label label-info" href="<?php echo site_url('otheractivity/download/'.$item['id']) ;?>"><i class="fa fa-download"></i> Download</a>
							
							<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S'):?>
							<a class="label label-danger" href="javascript:void(0);" onclick="delete_activity(<?php echo $item['id']; ?>)">
								<i class="fa fa-remove"></i> Delete
							</a>	
							<?php endif;?>
							</td>
						</tr>
					<?php }?>
				<?php }else{?>
						<tr>
							<td colspan="7" style="text-align:center"><label class="text-danger">No Items Found !</label></td>
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