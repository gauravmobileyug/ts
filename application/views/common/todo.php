<style>

#cke_15,#cke_22,#cke_30,#cke_35,#cke_67,#cke_84,#cke_87,#cke_72,#cke_73,#cke_75,#cke_77,#cke_78,#cke_79,#cke_66 ,#cke_58{ display:none;}
#cke_1_contents { height: 255px !important; }

</style>




<script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/samples/js/sf.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/config.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/plugins/smiley/dialogs/smiley.js');?>"></script> 



<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/fulltoolbareditor.js');?>"></script>
<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/abstracttoolbarmodifier.js');?>"></script>
<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/toolbarmodifier.js');?>"></script>
<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/toolbartextmodifier.js');?>"></script>

<script type="text/javascript" src="<?=base_url('assets/ckeditor/samples/js/sample.js');?>"></script>

<div class="col-md-8">
	<form method="POST" action="<?php echo site_url('user/todo');?>" enctype="multipart/form-data">
		<div class="box box-default">
			<div class="box-header" style="padding-bottom:0px">
			  <i class="ion ion-clipboard"></i>
			  <h3 class="box-title">To Do List</h3>
			</div>

			<div class="box-body" style="    padding: 4px;">
					<div style="padding-bottom:2px;">
			  
					<?php 


					$todo_list = '';
					if( isset($common_data['todo_list']) && !empty($common_data['todo_list']) ) :
						$todo_list = $common_data['todo_list']['todo_list'];						
					?>
					<input type="hidden" name="todo_id" value="<?= $common_data['todo_list']['todo_id'];?>" />
					<?php endif;?>
			  

					<textarea id="editor" class="form-control" style="height: 400px" name="todo_list" placeholder="Create Your To-Do" required><?=$todo_list;?></textarea>

				  </div>
				  
				<div>
					<div class="pull-left">
						<button type="reset" class="btn btn-default btn-xs" onclick="clear_editor()"><i class="fa  fa-eraser"></i> Clear ALL </button>
					</div>
					
					<div class="pull-right">
						<button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-save"></i> Save </button>
						<a id="cke_28" class="btn btn-warning btn-xs" href="javascript:void('Undo')" title="Undo" tabindex="-1" hidefocus="true" role="button" aria-labelledby="cke_28_label" aria-haspopup="false" onkeydown="return CKEDITOR.tools.callFunction(35,event);" onfocus="return CKEDITOR.tools.callFunction(36,event);" onclick="CKEDITOR.tools.callFunction(37,this);return false;"><span id="cke_28_label"  aria-hidden="false">Undo</span></a>
					</div>
				</div>
				  
			</div>
		
			
		</div>
	</form>
</div>
<script>
	initSample();
</script>
