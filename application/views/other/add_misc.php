<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		Add Miscellaneous Item
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('otheractivity/get_all_misc');?>"> List Miscellaneous</a></li>
        <li class="active">Miscellaneous Items</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	 <form method="POST" action="<?php echo site_url('otheractivity/add_misc'); ?>" enctype="multipart/form-data" id="form" name="ad_misc_form">
      <div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create Miscellaneous Items</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <input class="form-control" placeholder="Title" id="title" name="title" value="">
              </div>
              <div class="form-group">
                <input class="form-control" placeholder="Short Description" id="short_description" name="short_description" value="">
              </div>
				
			 <div class="form-group">
				<label for="exampleInputFile">Upload File</label>
                <input type="file" class="form-control"  id="file" name="file" value="">
				<span><i>Only pdf,doc & docx</i> File types are allowed </span>
              </div>	
            </div>
            <!-- /.box-body -->
            <div class="box-footer">				<div class="pull-left" style="padding-right:12px" >									</div>  			
              <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
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