<div id="page-body">
        
<?php
      include("module/main/sidebar.php");
?>
        <div id="wp-content">
        <?php
       if(isset($_GET['action']))
       {
        $tam=$_GET['action'];
       } 
       else
       {
        $tam ='';
       }
       if($tam=='reports')
       {
        include("main/baocaothongke.php");
       }
       elseif($tam=='manage-orders')
       {
        include("main/quanlydonhang.php");
       }
       elseif($tam=='manage-products')
       {
        include("main/quanlysanpham.php");
       }
       elseif($tam=='manage-accounts')
       {
        include("main/quanlytaikhoan.php");
       }
       
       ?>
        </div>
      </div>