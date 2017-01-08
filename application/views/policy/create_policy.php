<div class="content-wrapper">
<?php 	
	$id  = '';
	$title	= '';
	$type	= '';
	$short_description = '';	
	$long_description 	= '';
	$file 	= '';
	$save 	= '';	
	$publish = '';
	$date_added = '';	
	$date_added = '';		
	$action = 'policy/create_policy';
	$upload_action          =  "policy/upload";
	
	if(isset($policy)){	
		$id 					=  $policy['id'];	
		$title 					=  $policy['title'];	
		$type 					=  $policy['type'];	
		$short_description		=  $policy['short_description'];
		$long_description 		=  $policy['long_description'];	
		$file 					=  $policy['file'];		
		$save 					=  $policy['save'];	
		$publish 				=  $policy['publish'];	
		$date_added 			=  $policy['date_added'];
		$action					=  'policy/update_policy';
		$upload_action          =  "policy/update_upload";	
	}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Policy
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i>Home</a></li>
		
        <li><a href="<?php echo site_url('policy/list_policy');?>">Policies</a></li>
        <li class="active">Policy</li>
      </ol>
    </section>
	
	
	<?php /* ?>
	
	<div id="policy_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Upload Policy</h4>
		  </div>
		  
		  <div class="modal-body" style="height: 85px;">
			<form name="upload_policy" action="<?php echo site_url($upload_action);?>" id="upload_policy" method="POST" enctype="multipart/form-data">
				<p style="float:left">					<input type="hidden" name="id" value="<?php echo $id ;?>" />
					<input type="file"  id="policy_file" name="policy_file" class="file" required>	<span><i>Only pdf file is allowed </i></span>			
				</p>
				<p style="float:right">
					<a href="#" class="btn btn-primary" onclick="$('#upload_policy').submit();">
						<i class="fa fa-upload"></i>
						Upload
					</a>
				</p>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div>
	
	<?php */ ?>
    <!-- Main content -->
    <section class="content">
	<form method="POST" action="<?php echo site_url($action);?>" name="policy_form" id="policy_form" enctype="multipart/form-data">
	  <input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
      <div class="row">
           
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create New Policy</h3>
			  <div class="pull-right">
				<?php
					if($publish == '1') : echo "<label class='label label-success'>Published</label>";
					elseif($publish == '2') : echo "<label class='label label-warning'>Saved</label>";
					endif;
				?>
			  </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <input class="form-control" placeholder="Policy Title" id="title" name="title" value="<?php echo $title;?>" required>
              </div>
              <div class="form-group">
                <input class="form-control" required placeholder="Short Description" id="short_description" name="short_description" value="<?php echo $short_description;?>">
              </div>
			  
			  <div class="form-group">
               <label style="cursor:pointer;padding-right:10px;"><input type="radio"  required name="type" value="G" <?php echo $type == 'G' ? 'checked' : '';?>> Policy</label>
                <label style="cursor:pointer;padding-right:10px;"> <input type="radio" required name="type" value="P" <?php echo $type == 'P' ? 'checked' : '';?>> Public Holidays</label>
               
				<?php /*
			   <label style="cursor:pointer;padding-right:10px;"> <input type="radio"  required name="type" value="A" <?php echo $type == 'A' ? 'checked' : '';?>> Appraisal</label>
			   */?>
              </div>
			  
			  <div class="form-group">
               <input type="file" class="form-control"  id="policy_file" name="policy_file" class="file" <?php if(!isset($policy)){	?>required <?php }?>>	<span><i>Only pdf file is allowed </i></span>		
              </div>
			  
			  
              <!-- <div class="form-group">
                    <textarea id="long_description" class="form-control" style="height: 300px" name="long_description">
						<?php //echo $long_description;?>
                    </textarea>
              </div> -->
			  
			  
			  <input type="hidden" name="publish" id="publish" value="<?php echo $publish ;?>" />
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
			
			
              <div class="pull-right">
                
				
				<?php if( $publish == 1 ):?>
					<button type="submit" class="btn btn-default" name="publish" value="1" id="save_policy" ><i class="fa fa-pencil"></i> Save As Draft</button>
				<?php elseif ( $save == 1): ?>
					<button type="submit" class="btn btn-primary" name="save_publish" value="1"><i class="fa fa-envelope-o"></i> Save & Publish </button>
				<?php elseif( $save == '' && $publish == ''): ?>
					<button type="submit" class="btn btn-default" name="publish" value="1" id="save_policy" ><i class="fa fa-pencil"></i> Save As Draft</button>
				<?php endif;?>
              </div>
              <a href="<?php echo site_url('policy/create_policy');?>" class="btn btn-default"><i class="fa fa-refresh"></i> Reset </a>
			  
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>		
		
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
	</form>
    <!-- /.content -->
  </div>
  <script>
	$(document).ready(function(){
		$('.close2').click(function(){
			$('#policy_modal').hide();
		});
	});
  </script>