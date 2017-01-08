<div class="content-wrapper">

    <!-- Content Header (Page header) -->

	<?php //fn_ems_debug($user_data); ?>

    <section class="content-header">

      <h1>
		Gallery
      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Gallery</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	 <form method="POST" action="<?php echo site_url('otheractivity/add_gallery'); ?>" enctype="multipart/form-data" id="form" name="add_gallery">

      <div class="row">

		<div class="col-md-12">

			<div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Add New Gallery Image</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">

            
			 <div class="form-group">

				<label for="exampleInputFile">Upload File</label>

                <input type="file" class="form-control"  id="file" name="files[]" value="" multiple>

              </div>	

            </div>

            <!-- /.box-body -->

            <div class="box-footer">
			
				<div class="pull-left">
					
				</div>  
			

              <div class="pull-right">

                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Add To Gallery </button>

              </div>

          

            </div>

            <!-- /.box-footer -->

          </div>

		</div>

	  </div>

	 </form>
	 
	 
	  <div class="row">
		
		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
				<i class="fa fa-list-alt"></i>
				<h3 class="box-title" class="pull-left">Gallery Pictures</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-bordered dataTable ">		
					<thead>
						<tr>
							<th>Sr.No.</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if( isset($galleries) && !empty($galleries) ){
							
							foreach($galleries as $key => $gallery) {
						?>
							<tr>
								<td><?php echo $count++ ;?></td>
								<td style="
    width: 44%;
"><img src="<?php echo base_url($gallery['file']) ;?>"  style="width:21%"/></td>
								
								<td>
									
									<a href="<?=site_url('otheractivity/delete_gallery/'.$gallery['id']);?>" class="btn btn-danger btn-xs">
										<i class="fa fa-remove"> Delete </i>
									</a>
								</td>
							</tr>	
						<?php }
						}else{
							?>
							<tr><td colspan="3" style="text-align:center"><label class="text-danger">No Data Found!</label></td></tr>
							<?php
						}
						?>
					</tbody>
				</table>				
			</div>
			
			
			<div class="box-body">
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
	 
	 

    </section>



</div>	