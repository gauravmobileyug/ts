<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('common/header');
$this->load->view('common/notifications');

?>
<body class="sidebar-mini layout-boxed skin-black">
<div class="wrapper">
  <?php $this->load->view('manager/common/manager_header');?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('manager/common/left_side_bar');?>
  <!-- Content Wrapper. Contains page content -->
  <?php $this->load->view('manager/main_content');?>
  <!-- /.content-wrapper -->
   <footer class="main-footer">
   <?php echo $this->lang->line('versetal_copyright_content') ;?>
  </footer>
  
   <?php //$this->load->view('manager/common/right_side_bar');?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
</body>
<?php $this->load->view('common/footer');?>
