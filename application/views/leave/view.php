<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
       <?php echo ucwords($policy['title']) ;?>
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
		<div class="box box-solid">
			<div class="box-header with-border">
			  <i class="fa fa-text-width"></i>
			  <h3 class="box-title">Description</h3>
			  <div class="pull-right"><?php echo date('d/M/y',strtotime($policy['date_added']));?></div>
			</div>
			<!-- /.box-header -->
			<div class="box-body box-body-scroll">
			  <h2 ><?php echo $policy['short_description'];?></h2>
			  <dl class="dl-horizontal">
				<p><?php echo $policy['long_description'];?></p>
			  </dl>
			</div>
			
			<div class="box-footer">				<div class="pull-left">				<a class="btn btn-primary btn-xs" href="javascript:history.go(-1);"><i class="fa fa-arrow-left"></i> Go Back </a> 			  </div>   
              <div class="pull-right">
				<?php if(!empty($policy['file'])){?>	
                <a class="btn btn-primary btn-xs" href="<?php echo !empty($policy['file']) ? base_url().$policy['file'] : '#';?>"><i class="fa fa-download"></i> Download </a>
				<?php }?>
              </div>
            
            </div>
			
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</div>
	</div>
</div>