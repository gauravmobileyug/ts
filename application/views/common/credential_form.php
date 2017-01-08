 <div id="credentials_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Change Login Credentials</h4>
		  </div>
		  
		  <div class="modal-body" style="height: auto;">
			<form class="form-horizontal" method="POST" action="<?php  echo site_url('user/change_credentials');?>">
              <div class="box-body">
               <!--  <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password"  name="password" placeholder="Password" required>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="password2" class="col-sm-2 control-label">Confirm Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" required>
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Change</button>
              </div>
              <!-- /.box-footer -->
            </form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	</div>
</div>