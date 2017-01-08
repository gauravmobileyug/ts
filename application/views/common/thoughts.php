
<style>
.thought em,.thought h3{line-height: 1.4;}
</style>
<div class="col-md-6">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border" style="padding-bottom: 0px;padding-top: 4px;">
              <div class="user-block">
                <img class="img-circle" src="<?php echo base_url($common_data['thought']['image']);?>"/> 
                <span class="username"><a href="#"><?php echo ucwords($common_data['thought']['firstname'].' '.$common_data['thought']['lastname']);?></a></span>
                <span class="description">Shared publicly - <?php echo date('d M Y',strtotime($common_data['thought']['date_added']));?></span>
              </div>
             
            </div>
            <!-- /.box-header -->
			
				<div class="box-body" >
					<div class="box-body thought" style="background: #e0e0e0;color: #222d32;" >
						
						 <!-- post text -->
						
							<i class="fa fa-quote-left" style="    padding: 7px;"></i>
							<?php echo $common_data['thought']['thought'];?>
							<i class="fa fa-quote-right" style="    padding: 7px;"></i>
						

						
						
						  <!-- Attachment -->
						  <div class="attachment-block clearfix hidden">
							<img class="attachment-img" src="<?php echo base_url('assets/dist/img/photo1.png');?>" alt="Attachment Image">

							<div class="attachment-pushed">
							  <h4 class="attachment-heading"><a href="http://www.lipsum.com/">Lorem ipsum text generator</a></h4>

							  <div class="attachment-text">
								Description about the attachment can be placed here.
								Lorem Ipsum is simply dummy text of the printing and typesetting industry... <a href="#">more</a>
							  </div>
							  <!-- /.attachment-text -->
							</div>
							<!-- /.attachment-pushed -->
						  </div>
						  <!-- /.attachment-block -->

						  <!-- Social sharing buttons 
						  <button type="button" class="btn btn-default btn-xs"><i class="fa fa-share"></i> Share</button>
						  <button type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-o-up"></i> Like</button>
						  <span class="pull-right text-muted">45 likes - 2 comments</span>-->
					</div>
				</div>
            
            <!-- 
            <div class="box-footer">
              
            </div>
            <!-- /.box-footer -->
            <div class="box-footer hidden">
              <form action="#" method="post">
                <img class="img-responsive img-circle img-sm" src="<?php echo base_url('assets/dist/img/user4-128x128.jpg');?>" alt="Alt Text">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <input type="text" class="form-control input-sm" placeholder="Press enter to post comment">
                </div>
              </form>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
<script>		
	$(function(){
		$('.thought').slimScroll({
			height: '233px'
		});
	});

</script>