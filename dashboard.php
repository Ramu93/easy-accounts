<?php 
session_start();
include('dbconfig.php');
include('header.php');
include('sidebar.php');

  
  
  // $pending_orders = 0;
  // $completed_orders = 0;
  // $jobs = 0;
  // $warehouse = 0;
  // $enquiries = 0;

  //getCounts();
  
  function getCounts(){
    global $dbc, $pending_orders, $completed_orders, $jobs, $warehouse, $enquiries;
    $query = "SELECT (SELECT COUNT(*) FROM orders WHERE order_status='completed') as completed_orders, (SELECT COUNT(*) FROM orders WHERE order_status='created') as pending_orders, (SELECT COUNT(*) FROM marketing_enquiry) as enquiries, (SELECT COUNT(*) FROM jobs) as jobs, (SELECT COUNT(*) FROM warehouse) as warehouse";

    $result = mysqli_query($dbc,$query);
    if(mysqli_num_rows($result)>0){
      $row = mysqli_fetch_assoc($result);

      $pending_orders = $row['pending_orders'];
      $completed_orders = $row['completed_orders'];
      $enquiries = $row['enquiries'];
      $jobs = $row['jobs'];
      $warehouse = $row['warehouse'];
    }
  }



?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?php echo $enquiries; ?></h3>

            <p>Enquiries</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php echo $jobs; ?></h3>

            <p>Jobs</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php echo $completed_orders; ?></h3>

            <p>Orders Completed</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo $pending_orders; ?></h3>

            <p>Orders Pending</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?php echo $warehouse; ?></h3>

            <p>Warehouse</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php 
include('footer_jsimports.php');
include('footer.php'); 
?>
