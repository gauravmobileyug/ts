<!-- Hello User -->
<?php if( $this->session->flashdata('success') ) :?>

<div class="alert alert-success alert-dismissible custom-alerts">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
	<span><i class="icon fa fa-check"></i> Success :  </span>
	<?php echo $this->session->flashdata('success');?>
</div>

<?php endif;?>

<?php  if( $this->session->flashdata('info') ) :?>
<div class="alert alert-info alert-dismissible custom-alerts">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
	<span><i class="icon fa fa-info"></i> Notice : </span>
	<?php echo $this->session->flashdata('info');?>
 </div>
<?php endif;?>

<?php  if( $this->session->flashdata('warning') ) :?>
<div class="alert alert-warning alert-dismissible custom-alerts">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
	<span><i class="icon fa fa-warning"></i> Warning :</span>
	<?php echo $this->session->flashdata('warning');?>
</div>
<?php endif;?>


<?php  if( $this->session->flashdata('failure') ) :?>
	
<div class="alert alert-danger alert-dismissible custom-alerts">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
	<span><i class="icon fa fa-ban"></i> Alert:</span>
	<?php echo $this->session->flashdata('failure'); ?>
</div>


<?php endif;?>