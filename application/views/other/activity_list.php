<div class="content-wrapper">

    <!-- Content Header (Page header) -->

	<?php //fn_ems_debug($user_data); ?>

    <section class="content-header">

      <h1>

		All Activities

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Activities</li>

      </ol>

    </section>



<!-- Main content -->

<section class="content">

<div class="row">

<div class="col-xs-12">

  <div class="box">

	<div class="box-header">

	  <h3 class="box-title">All Items</h3>
	  <?php if($user_data['role'] == 'H' || $user_data['role'] == 'S'){ ?>
	  <div class="box-tools">
		<a href="<?php echo site_url('otheractivity/add_activity'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp;Add Activity</a>
	  </div>
	 <?php } ?>
	</div>

	<!-- /.box-header -->

	<div class="box-body table-responsive ">

		<table class="table table-hover table-striped" id="activity_list">
		
			<thead>
				<tr>

				  <th>ID</th>

				  <th>Activity</th>

				  <th>Activity Description</th>
				  
				  <th>Activity Date</th>

				  <th>Status</th>

				  <th>Date Added</th>

				  <th>Action</th>

				</tr>
			
			</thead>
	
			<tbody>

				

				<?php if( !empty($activities) ) { $count = 1;?>

					<?php foreach($activities as $key => $item){?>

						<tr>

							<td><?php echo $count++;?></td>

							<td><?php echo $item['activity_name'];?></td>

							<td><?php echo substr(strip_tags($item['activity_description']) , 0,30).'...';?></td>
							
							<td><?php echo date('d M Y' , strtotime($item['activity_date']));?></td>

							<td style="cursor:pointer;" 
							<?php if($user_data['role'] == 'S' || $user_data['role'] == 'H'){ ?>
								onclick="update_activity_status('<?php echo $item['status'];?>', '<?php echo $item['id'];?>')"
							<?php } ?>
							>

							

								<?php 

								if($item['status'] == 'A') {

								?>

								<label class="label label-success" style="cursor:pointer"> Active <label>

								<?php

								}else{

								?>

								<label class="label label-danger" style="cursor:pointer"> Inavtive <label>

								<?php

								}

								?>

								

							</td>

							<td><?php echo date('d M Y',strtotime($item['date_added']));;?></td>
							<td>
								<a class="btn btn-xs btn-primary" href="<?php echo site_url('otheractivity/view_activity/'.$item['id']);?>"><i class="fa fa-eye"></i> View</a>
								
								<?php if($user_data['role'] == 'S' || $user_data['role'] == 'H'){ ?>
								<a class="btn btn-xs btn-info" href="<?php echo site_url('otheractivity/edit_activity/'.$item['id']);?>"><i class="fa  fa-edit"></i> Edit</a>
								<a class="btn btn-xs btn-danger" href="<?php echo site_url('otheractivity/delete_activity/'.$item['id']);?>"><i class="fa  fa-remove"></i> Delete</a>
								<?php }?>
								
								
								
							</td>
							

						</tr>

					<?php }?>

				<?php }?>

			</tbody>

		</table>

	</div>

	<div class="box-footer clearfix">

		<div class="pull-left">
					<a class="btn btn-primary btn-xs" href="javascript:history.go(-1);"><i class="fa fa-arrow-left"></i> Go Back </a> 
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

<script>

$(document).ready(function(){
	
	$('#activity_list').DataTable({	 
		"paging": false,	
		"lengthChange": true,
		"searching": true,	
		"ordering": true,
		"info": true,	
		"autoWidth": true, 
		"columnDefs": [ {
			"targets": [6],
			"orderable": false	
		} ]	
	});
});
</script>