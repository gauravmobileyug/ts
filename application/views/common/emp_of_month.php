<!-- <style>
.widget-user .widget-user-image{top:35px;}
.rem-pad{padding-top:5px!important;}
.rem-head{height:130px;}
.widget-user .rem-pad .widget-user-username{font-size:20px;}
</style> -->
<div class="col-md-4">
<!-- <div class="widget-user-header" style="color:#fff;height: 32px;position: absolute;z-index: 9;width: 91%;line-height: 30px;text-align: center;text-transform: capitalize;font-size: 22px;font-family: 'Source Sans Pro',sans-serif;border-top-right-radius: 3px;border-top-left-radius: 3px;font-weight:100;	">employee of the month</div> -->
	<?php //fn_ems_debug($employee_of_month);?>

<div class="box box-widget widget-user ">
	<!-- Add the bg color to the header using any of the bg-* classes -->
	
	<div class="widget-user-header bg-aqua rem-head">
	  <h3 class="widget-user-username">
		<?php echo ucwords($common_data['employee_of_month']['firstname'].' '.$common_data['employee_of_month']['lastname']);?>
	  </h3>
      <h5 class="widget-user-desc"><?=ucwords($common_data['employee_of_month']['user_designation_description']);?></h5>
	</div>
	<div class="widget-user-image" style="top: 85px;">
	
		<?php $img = !empty($common_data['employee_of_month']['profile_pic']) ? base_url($common_data['employee_of_month']['profile_pic']) : base_url('assets/images/blank_user.png') ;?>
	
	
	  <img class="img-circle" style="height: 90px;" src=<?php echo $img;?> alt="User Avatar">
	</div>
	<div class="box-footer rem-pad">
	  <div class="row">
	  <div class="col-sm-12">
		<p style="padding-left: 19px;
    padding-right: 30px;" class=" emp-of-month">
			<i><?=$common_data['employee_of_month']['remarks'];?></i>
		</p>		
	  </div>
	  
		
	  </div>
	 
	</div>
	
	<div class="box-footer bg-aqua-active" style="    padding-top: 5px !important; background-color: #00add8; color: white;   padding-bottom: 4px;">				
				<?php if(!$common_data['if_appreciated']):?>
					<a type="button"  onclick="appreciate('<?php echo $common_data['employee_of_month']['id'];?>');" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</a>
				<?php endif;?>
				
				<?php if($common_data['total_appreciation']):?>
				<a href="javascript:void(0);" class="btn btn-success btn-xs"> &nbsp;<?=$common_data['total_appreciation'];?> Likes</a>
				<?php endif;?>
				
			
			
			
				<?php /* ?>
				
				<h3 class="widget-user-username" style="text-align:right;font-size:20px"><?php echo ucwords($common_data['employee_of_month']['firstname'].' '.$common_data['employee_of_month']['lastname']);?></h3>
				<h5 class="widget-user-desc" style="text-align:right;"><?=ucwords($common_data['employee_of_month']['user_designation_description']);?></h5>
					<?php */ ?>
				<span class="widget-user-username" style="text-align:right;font-size:14px;float: right;">
					Employee Of The Month
				</span>
			</div>
  </div>
  
</div>
<script>		
	$(function(){
		$('.emp-of-month').slimScroll({
			height: '73px'
		});
	});

</script>
<script src="http://letteringjs.com/js/jquery.lettering-0.6.1.min.js"></script>
	<script>
	$(function() {
        $("h1").lettering();
    });
	</script>