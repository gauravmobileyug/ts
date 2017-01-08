<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
       <?php echo !empty($policy['title']) ? ucwords($policy['title']) : 'Policy Description' ;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('policy/list_policy');?>"> Policies</a></li>
        <li class="active">Policy</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
			 <!--  <i class="fa fa-text-width"></i>
			  <h3 class="box-title">Description</h3> -->
			<!--  <div class="pull-right"><?php echo date('d/M/y',strtotime($policy['date_added']));?></div> -->
			</div>
			<!-- /.box-header -->
			<div class="box-body ">				<h4 style=""><?php echo $policy['short_description'];?></h4>
			  <!-- <dl class="dl-horizontal">
				<p><?php //echo $policy['long_description'];?></p>
			  </dl> 	 -->				  <iframe src="<?php echo base_url($policy['file']);?>" width="100%" height="600px"></iframe>
			</div>
			
			<div class="box-footer">
              <div class="pull-right">
				
			  </div>
              <div class="pull-right">
				<?php /*if(!empty($policy['file'])){?>	
                <a target="_blank" class="btn btn-primary btn-xs" href="<?php echo !empty($policy['file']) ? base_url().$policy['file'] : '#';?>">Open in other tab </a>
				<?php }*/?>
              </div>
            
            </div>
			
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</div>
	</div>
</div>