<div class="content-wrapper">

    <!-- Content Header (Page header) -->

	<?php //fn_ems_debug($user_data); ?>

    <section class="content-header">

      <h1>

		Add Activity

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo site_url('otheractivity/activities');?>"> Activity List </a></li>

        <li class="active">Activity</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	 <form method="POST" action="<?php echo site_url('otheractivity/add_activity'); ?>" enctype="multipart/form-data" id="form" name="ad_misc_form">

      <div class="row">

		<div class="col-md-12">

			<div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Add A New Activity</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

              <div class="form-group">

                <input class="form-control" placeholder="Activity Name" id="activity_name" name="activity_name" value="" required>

              </div>

				<div class="form-group">

                <input class="form-control" placeholder="Date Of Activity" id="activity_date" name="activity_date" value="" required>

              </div>

			  
			  <div class="form-group">

				<label for="exampleInputFile">Upload Image</label>

                <input type="file" class="form-control"  id="file" name="file" value="" required><span class="help">Only jpeg,jpg or png files are allowed</span>

              </div>	

			
			  
              <div class="form-group">

                 <textarea id="activity_description" class="form-control" style="height: 300px" name="activity_description" placeholder="Activity full description" required></textarea>

              </div>

				
			</div>

            <!-- /.box-body -->

            <div class="box-footer">
 
			
              <div class="pull-right">
				
                <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save </button>

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