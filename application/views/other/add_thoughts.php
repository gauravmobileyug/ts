
<style>

#cke_15,#cke_22,#cke_30,#cke_35,#cke_67,#cke_84,#cke_87,#cke_72,#cke_73,#cke_75,#cke_77,#cke_78,#cke_79,#cke_66 ,#cke_58{ display:none;}
#cke_1_contents { height: 255px !important; }

</style>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

	<?php //fn_ems_debug($user_data); ?>

    <section class="content-header">

      <h1>
		Add Thought Of The Day
      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Thought Of The Day</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	 <form method="POST" action="<?php echo site_url('otheractivity/add_thoughts'); ?>" enctype="multipart/form-data" id="form" name="add_thoughts">

      <div class="row">

		<div class="col-md-12">

			<div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Add Thought</h3>

            </div>
<?php //fn_ems_debug($thought);?>
            <!-- /.box-header -->

            <div class="box-body">
			<?php $sample = "We need to give each other the space to grow, to be ourselves, to exercise our diversity. We need to give each other space so that we may both give and receive such beautiful things as ideas, openness, dignity, joy, healing, and inclusion.";?>
            
			 <div class="form-group">
				<textarea class="form-control" name="thought" id="editor"  placeholder="<?=$sample;?>" style="height: 195px;" required><?=$thought['thought'];?></textarea>
             </div>	

			 <div class="form-group">
				<input type="file" name="image" class="form-control" required />
             </div>	
			 
            </div>

            <!-- /.box-body -->

            <div class="box-footer">
			
				<div class="pull-left padding " style="padding-right:12px;">
					
				</div>  

              <div class="pull-right">

                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>

              </div>

          

            </div>

            <!-- /.box-footer -->

          </div>

		</div>

	  </div>

	 </form>

    </section>



</div>	

<script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/samples/js/sf.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/config.js');?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/plugins/smiley/dialogs/smiley.js');?>"></script> 



<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/fulltoolbareditor.js');?>"></script>
<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/abstracttoolbarmodifier.js');?>"></script>
<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/toolbarmodifier.js');?>"></script>
<script src="<?=base_url('assets/ckeditor/samples/toolbarconfigurator/js/toolbartextmodifier.js');?>"></script>

<script type="text/javascript" src="<?=base_url('assets/ckeditor/samples/js/sample.js');?>"></script>
<script>
	initSample();
</script>
