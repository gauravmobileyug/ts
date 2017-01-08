<div class="content-wrapper" style="    background-color: #ffffff;background-image: url('<?php //echo base_url('assets/images/celebration.jpg');?>');background-size: 260px 186px;">
	<?php // fn_ems_debug($other_activity); ?>
    <section class="content-header">

      <h1>

       <?php echo ucwords($activity['activity_name']) ;?> 

      </h1>
	   -  <i><?php echo date('d M Y',strtotime($activity['activity_date']));?></i>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('otheractivity/activities');?>"> Activity List </a></li>
        <li class="active">Activity</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">



      <div class="row">



		<div class="col-md-12">

		<div class="box box-solid" style=" border: 2px solid #7cb732; box-shadow: 12px 13px 26px rgb(148, 160, 133);">

			<div class="box-header with-border">

			  <i class="fa fa-text-width"></i>

			  <h3 class="box-title">Description</h3>

			  <div class="pull-right">Date Created - <?php echo date('d M Y',strtotime($activity['date_added']));?></div>

			</div>

			<!-- /.box-header -->

			<div class="box-body box-body-scroll" style="background:url('<?php echo base_url($activity['image']) ;?>');background-size:100% 100%; background-repeat: no-repeat;">

			  <h2 ><?php echo $activity['activity_name'];?></h2>

			  <dl class="dl-horizontal">

				<p><?php echo $activity['activity_description'];?></p>

			  </dl>

			</div>

			

			<div class="box-footer">
				
				<?php if($user_data['role'] == 'S' || $user_data['role'] == 'H'){ ?>
				<div class="pull-right">
					<a href="<?php echo site_url('otheractivity/edit_activity/'.$activity['id']);?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
				</div>
				<?php }?>
            </div>

			

		<!-- /.box-body -->

		</div>

		<!-- /.box -->

		</div>

	</div>
	
	<?php if( !empty($other_activity) ) {
	$color_box = array('aqua','red','green','yellow' , 'purple','blue','black');
	?>
	<div class="row">
		
		<?php //fn_ems_debug( $other_activity );?>
		
		<?php  foreach($other_activity as $_k => $_v) { $color = array_rand($color_box,1);?>
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-<?php echo $color_box[$color];?>"><i class="ion ion-ios-lightbulb-outline"></i></span> 

            <div class="info-box-content">
				<a href="<?php echo site_url('otheractivity/view_activity/'.$_v['id']);?>"><?php echo $_v['activity_name'];?>
				
				
				<?php if(isset($_v['activity_date']) ) { ?>
				<p>
					- <i><?php echo date('d M Y' ,strtotime($_v['activity_date']));?></i>
				</p>
				<?php }?>
				
				<?php if(isset($_v['activity_description']) ) { ?>
				<p>
					- <small> <a href="<?php echo site_url('otheractivity/view_activity/'.$_v['id']);?>"> Read More... </a></small>
				</p>
				<?php }?>
				
				
            </div>
			
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		<?php  }?>
		
	</div> 
	
	<?php } ?>
	</section>
</div>
