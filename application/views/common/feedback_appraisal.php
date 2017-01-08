<style>
/*.widget-user-header {     text-align: center; }*/
/*.widget-user-username { margin-top: 8px !important; }*/
</style>


<div class="col-md-4">
	
	
	
	<?php 
	
		$appraisal = '';
		$holidays = '';
		
		if(!empty($common_data['other_policies'])){
			
			foreach( $common_data['other_policies'] as $k => $value ){
				if($value['type'] == 'P'){
					//$holidays = base_url($value['file']) ;
					$holidays =$value['id'];
				}
				if($value['type'] == 'A'){
					$appraisal = base_url($value['file']) ;
				}
			}
		}
	
	?>
	
	<?php /*
	
	<div class="box box-widget widget-user" style="cursor: pointer;">
		<a href="<?php echo $appraisal != '' ? $appraisal:  'javascript:void(0)';?>">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="widget-user-header  bg-orange-active " style="height: 85px;">
		  <h3 class="widget-user-username"><i class="fa  fa-thumbs-o-up"></i> Appraisals</h3>
		</div>
		</a>
	</div>
	
	*/ ?>
<?php /* ?>
	<div class="box box-widget widget-user-2">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="widget-user-header bg-yellow">
			<h3 class="widget-user-username">General Forms</h3>
		</div>
		<div class="box-footer no-padding">
			<ul class="nav nav-stacked">
			
			<?php foreach($common_data['forms'] as $key=>$form):?>
			
			
			<li><a href="<?=base_url($form['form']);?>"><?php echo ucwords($form['title']);?><span class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></span></a></li>
			
			<?php endforeach;?>
			</ul>
		</div>
	</div>
	
	<?php */?>
	<a href="<?php echo site_url('otheractivity/add_forms');?>">
		<div class="box box-widget widget-user" style="cursor: pointer;" >
			<!-- Add the bg color to the header using any of the bg-* classes -->
			<div class="widget-user-header bg-orange"  style="height: 85px;">
			  <h3 class="widget-user-username"> <i class="fa  fa-paperclip"></i> General Forms</h3>
			</div>
			
		</div>
	</a>
	
	<div class="box box-widget widget-user" style="cursor: pointer;" data-toggle="modal" data-target="#feedback">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<div class="widget-user-header bg-red"  style="height: 85px;">
		  <h3 class="widget-user-username"> <i class="fa  fa-comment-o"></i> Feedbacks</h3>
		</div>
		
	</div>
	
	<div class="box box-widget widget-user" style="cursor: pointer;">
		<!-- Add the bg color to the header using any of the bg-* classes -->
		<a href="<?php echo $holidays != '' ? site_url('policy/view?id='.$holidays):  'javascript:void(0)';?>">
		<div class="widget-user-header bg-green"  style="height: 85px;">
		  <h3 class="widget-user-username"> <i class="fa  fa-calendar-check-o"></i> Public Holidays</h3>
		</div>
		</a>
	</div>
</div>
	
	
	<div id="feedback" class="modal fade" role="dialog" style="padding-right: 63px !important;">	
		<form name="emp-of-month" action="<?php echo site_url("otheractivity/feedback");?>" id="feedback_form" method="POST" enctype="multipart/form-data">	
		<div class="modal-dialog">	
			<div class="modal-content" style="width: 718px;">	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Submit Feedback Form</h4>	
				</div>			  		
				<div class="modal-body" style="height: auto; width: 715px;">
				
					<p>
						<input type="text" name="name" id="name" class="form-control" placeholder="Name"/>
					</p>
				
					<p>
						<input  data-toggle="tooltip" title="Feedback subject is compulsory" type="text" name="subject" id="subject" required class="form-control" placeholder="Feedback Subject"/>
					</p>
					<p >				
						<textarea style="height: 130px;" data-toggle="tooltip" title="Feedback message is compulsory"  id="remarks" name="message" class="form-control" placeholder="Feedback Message"></textarea>	
						<input type="hidden" name="user_id" value="<?=$user_data['id'];?>" id="user_id"/>
					</p>		
			
					</form>	
				</div>	
				<div class="modal-footer">	
					<button type="submit" class="btn btn-primary" >Submit</button>	
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
				</div>		
			</div>	
		</div>	
		
		</form>
	</div>

<script>


  $(function () {
    $("#remarks").wysihtml5();
	
	$('a[data-wysihtml5-command="insertImage"]').remove();
	$('a[data-wysihtml5-command="createLink"]').remove();
  });

<?php if($this->session->userdata('success')):?>




e += '<div class="alert alert-success alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
				e += <?=$this->session->userdata('success');?>;
				e += '</div>';
$('.sidebar-mini').after( e );

<?php elseif($this->session->userdata('failure')):?>

alert('<?=$this->session->userdata('failure');?>');

e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
				e += <?=$this->session->userdata('failure')?>;
				e += '</div>';

$('.sidebar-mini').after( e );

<?php endif; $this->session->unset_userdata('success');$this->session->unset_userdata('failure')?>


</script>
