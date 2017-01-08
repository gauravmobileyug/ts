<div class="content-wrapper">

    <section class="content-header">

      <h1>
		Employee's General Forms
      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Forms</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S' ){ ?>

      <div class="row">

		<div class="col-md-12"> 
		
			<div class="pull-right">
				<a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal" data-target="#upload_form"><i class="fa fa-upload"></i> &nbsp;Upload Form</a>
			</div>
	
		</div>

	  </div>

	  
	<?php } ?>
		
		<div class="row">

			<div class="col-md-12"> 
				<div class="box">
					<div class="box-body">
						<table class="table table-condensed">
						
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Title</th>
									<th>Date Added</th>
									<th>Action</th>
								</tr>
							</thead>
							
						
							<tbody>
								<?php if(!empty($forms)):?>
								<?php foreach($forms as $key=>$form): $ext = pathinfo($form['form'], PATHINFO_EXTENSION); ?>
									<tr>
										<td><?php echo $count++;?></td>
										<td><?php echo $form['title'];?></td>
										<td><?php echo $form['date_added'];?></td>
										<td>
										
										<?php if(strtolower($ext) == 'pdf'):?>
										<a target="_blank" href="<?=base_url($form['form']);?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i>&nbsp; View</a>
										<?php else :?>
										<a target="_blank" href="<?=site_url('otheractivity/view_form/'.$form['form_id']);?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i>&nbsp; View</a>
										<?php endif;?>
										|
										<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S' ){ ?>
										<a href="javascript:delete_form(<?=$form['form_id'];?>);" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i>&nbsp; Delete</a>
										|
										<?php } ?>
										<a href="<?=base_url($form['form']);?>" class="btn btn-primary btn-xs"><i class="fa fa-download"></i>&nbsp; Download</a>
										
										</td>
									</tr>
								<?php endforeach;?>
								<?php else:?>
									<tr>
										<td colspan="4" style="text-align:center;"><label>No Forms Found !</label></td>
									</tr>
								<?php endif;?>
							</tbody>
							
						</table>
					</div>
					<div class="box-footer">
						<div class="pull-right">
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

		</div>
	 
	 

    </section>


	<div>
	
	
		<div id="upload_form" class="modal fade" role="dialog">	
		<form name="emp-of-month" action="<?php echo site_url('otheractivity/add_forms');?>" id="add_forms" method="POST" enctype="multipart/form-data">	
			<div class="modal-dialog">	
				<div class="modal-content">	
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h4 class="modal-title">Upload Form</h4>	
					</div>			  		
					<div class="modal-body" style="height: 230px;">
					
						<div class="form-group">
							<label>Form Title</label>
							<input type="text" name="title" id="title" class="form-control" placeholder="Form Title">
						</div>
					
						<div class="form-group">
							<input type="file" name="form" id="form" >
							<p class="help-block">Only doc,docx,xl,xlsx and pdf files are allowed</p>
						</div>
							
					</div>	
					<div class="modal-footer">	
						<button type="submit" class="btn btn-primary">Submit</button>	
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
					</div>		
				</div>	
			</div>
		</form>	
		
		
	</div>
	</div>
	

</div>	