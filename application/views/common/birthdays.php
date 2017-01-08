<div class="col-md-4">
				
		<div class="box box-warning">
			<div class="box-header with-border bg-yellow" style="
    background: #7b7b7b;
    color: white;
">
			  <h3 class="box-title">Upcoming Birthdays</h3>
			</div>
			
			
			<div class="box-body">
			<div class="box-body birthday" style="border: 2px solid #ecf0f5;height:315px">
			
			
			
				<ul class="products-list product-list-in-box">
					<?php if(isset($common_data['birthdays']) && !empty($common_data['birthdays'])) {?>
						<?php foreach($common_data['birthdays'] as $_k => $_bv) { ?>
							<li class="item" style="border-bottom:1-x solid #d9dad9;background:f2f2f2;padding:10px 5px;">
							  <div class="product-img">
								<?php $no_image_path = base_url('assets/images/blank_user.png');?>
								<img src="<?php echo !empty($_bv['profile_pic']) ? base_url($_bv['profile_pic']) :  $no_image_path;?>" alt="Product Image">
							  </div>
							  <div class="product-info">
								<a href="javascript:void(0);" class="product-title" style="color: rgb(68, 68, 68);    width: 40%;  word-break: break-all;"> 
									<?php echo ucwords($_bv['firstname'].' '.$_bv['lastname']);?>
								  <span class="label label-success pull-right"> <i class="fa fa-calendar" style="font-size: 14px;"></i> <?php echo $_bv['dob'];?> </span></a>
									<span class="product-description">
									  <i>- <?php echo $_bv['user_designation_description'];?></i>
									</span>
							  </div>
							</li>
						<?php } ?>
					<?php } 
					else { ?>
				 <li class="item"> <strong>No Birthday This Month</strong> </li>
				<?php } ?>
				</ul>
				
			</div>
			</div>
			
	  </div>

</div>
<script>		
	$(function(){
		/* $('.birthday').slimScroll({
			height: '365px'
		}); */
	});

</script>