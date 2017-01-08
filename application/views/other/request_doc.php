<div class="content-wrapper">

    <!-- Content Header (Page header) -->

	<?php //fn_ems_debug($user_data); ?>

    <section class="content-header">

      <h1>
		Request Document From HR
      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Request Docs</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	 <form method="POST" action="<?php echo site_url('otheractivity/request_doc'); ?>" enctype="multipart/form-data" id="form" name="request_doc">

      <div class="row">

		<div class="col-md-12">

			<div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Fill Comments</h3>

            </div>

            <!-- /.box-header -->

            <div class="box-body">
			
			<div class="form-group">
				<input type="text" class="form-control" name="title" id="title" placeholder="Title" required />
             </div>	
			
			 <div class="form-group">
				<textarea class="form-control" name="comments" id="comments" placeholder="Add Your Comments" style="    height: 195px;" required></textarea>
             </div>	

		
			 
            </div>

            <!-- /.box-body -->

            <div class="box-footer">
			
				<div class="pull-left" style="padding-right:12px">
					<a class="btn btn-primary" href="javascript:history.go(-1);"><i class="fa fa-arrow-left"></i> Go Back </a> 
				</div>  

              <div class="pull-right">

                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Send Request </button>

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