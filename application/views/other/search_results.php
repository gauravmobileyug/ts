<div class="box">
   <div class="box-header">
      <h3 class="box-title"><i class="fa  fa-search"></i> Search Results</h3>
      <div class="box-tools pull-right">
         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
         </button>
         <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
   </div>
   <div class="box-body table-responsive ">
      <table class="table table-hover table-striped" id="t_search_results">
         <thead>
            <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Date</th>
               <!-- <th>Email</th> -->
               <th>Phone</th>
               <th>Department</th>
               <th>Status</th>
               <th>Action</th>
            </tr>
		</thead>
		<tbody>
            <?php 
               if(isset($employees) && !empty($employees)){
               
               	foreach($employees as $key => $employee):
               
               ?>
            <tr>
               <td><?php echo $employee['id'];?></td>
               <td>
                  <a href="<?php echo site_url('user/view/'.$employee['id']);?>">
                  <?php echo strtoupper($employee['firstname']. ' '.$employee['lastname']);?>
                  </a>
               </td>
               <td><?php echo date('d-M-Y', strtotime($employee['date_added']));?></td>
               <!-- <td><?php echo $employee['email'];?></td> -->
               <td><?php echo $employee['phone'];?></td>
               <td><?php echo !empty($employee['department']) ? strtoupper($employee['department_name']) : 'NA';?></td>
               <td>
                  <?php if( $employee['status'] == 0 ) {?>
                  <span class="label label-warning">Disabled</span>
                  <?php }elseif($employee['status'] == 1) { ?>
                  <span class="label label-success">Enabled</span>
                  <?php }?>
               </td>
               <td colspan="3">
			   <a class="btn btn-xs btn-primary" href="<?php echo site_url('user/view/'.$employee['id']);?>"><i class="fa fa-eye"></i> View </a> 
				<?php if($user_data['role'] == 'S' || $user_data['role'] == 'H'){?>
				| 
				<a class="btn btn-xs btn-warning"href="<?php echo site_url('user/edit/'.$employee['id']);?>"><i class="fa  fa-edit"></i> Edit</a> 
			   <!-- <a href="#" onclick="fn_del_Emp('<?php echo $employee['id'];  ?>');"><i class="fa fa-remove"></i></a> -->
			  <?php } ?>
			   </td>
            </tr>
            <?php
               endforeach;
               
               }else{
               
               ?>
            <tr>
               <td colspan="10" class="no-data"><b>No Results Found</b></td>
            </tr>
            <?php
               }
            ?>
      </table>
   </div>
   <div class="box-footer clearfix">
	<div class="pull-left">
					
				</div>  
   </div>
</div>
<script>

<?php 	if(isset($employees) && !empty($employees)){ ?>
		$(document).ready(function(){
			
			$('html, body').animate({scrollTop:$('#t_search_results').position().top}, 2000); 
	
			$(".ems-box-body").css("display","none");
			$("#ems-collapse").children().removeClass("fa-minus");
			$("#ems-collapse").children().addClass("fa-plus");
			
			$('#t_search_results').DataTable({
			  "paging": true,
			  "lengthChange": true,
			  "searching": true,
			  "ordering": true,
			  "info": true,
			  "autoWidth": true, 
			  "columnDefs": [ {
				"targets": [6],
				"orderable": false
				} ]
			});
			
			
		});
		
<?php 	} ?>
</script>