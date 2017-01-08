<div class="content-wrapper">

    <section class="content-header">

      <h1>
		Update Activity

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo site_url('otheractivity/activities');?>"> Activity List </a></li>
		<li><a href="<?php echo site_url('otheractivity/view_activity/'.$activity['id']);?>">View Activity </a></li>

        <li class="active">Activity</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	 <form method="POST" action="<?php echo site_url('otheractivity/edit_activity/'.$activity['id']); ?>" enctype="multipart/form-data" id="form" name="ad_misc_form">

      <div class="row">

		<div class="col-md-12">

			<div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Update Activity</h3>
			  
			  <div class="box-tools">
				<div onclick="update_activity_status('<?php echo $activity['status'];?>', '<?php echo $activity['id'];?>')">
				<?php 

				if($activity['status'] == 'A') {

				?>

				<label class="label label-success" style="cursor:pointer"> Active <label>

				<?php

				}else{

				?>

				<label class="label label-danger" style="cursor:pointer"> Inavtive <label>

				<?php

				}

				?>
				</div>
			 </div>
			    
				
			  

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <div class="form-group">

                <input class="form-control" placeholder="Activity Name" id="activity_name" name="activity_name" value="<?php echo $activity['activity_name'] ;?>" required>

              </div>

			  
			  <div class="form-group">

                <input class="form-control" placeholder="Date Of Activity" id="activity_date" name="activity_date" value="<?php echo $activity['activity_date'] ;?>" required>

              </div>

			  
			   <div class="form-group">
				<?php 
					$img = 'assets/images/no_wallpic.jpg';
					if(  !empty($activity['image']) ){
						$img = $activity['image'];
					}
				?>
				
				<img src="<?php echo base_url($img);?>" style="    height: 50px;" />
				
			   </div>
			  
			  
			  <div class="form-group">

				<label for="exampleInputFile">Upload New Image</label>

                <input type="file" class="form-control"  id="file" name="file" value=""><span class="help">Only jpeg,jpg or png files are allowed</span>

              </div>	

			
			  
              <div class="form-group">

                 <textarea id="activity_description" class="form-control" style="height: 300px" name="activity_description" placeholder="Activity full description" required><?php echo $activity['activity_description'] ;?></textarea>

              </div>

				
			</div>

            <!-- /.box-body -->

            <div class="box-footer">

			
              <div class="pull-right">

                <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Update </button>

              </div>

              <button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset </button>

            </div>

            <!-- /.box-footer -->

          </div>

		</div>

	  </div>

	 </form>

    </section>



</div>	

<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
 <script>
	$(function () {
		$("#activity_description").wysihtml5({"color": true});
		$('#activity_date').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
		});
		
	});
</script>