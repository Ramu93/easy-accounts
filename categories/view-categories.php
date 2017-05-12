<?php 
session_start();

include('../dbconfig.php');
include('../header.php');
include('../sidebar.php');
//include('../common-methods.php');

if(!$_SESSION['login']){
  echo "<script>window.location.href=\"".HOMEURL."index.php\"</script>";
  //header('Location: ../index.php');
}


  //Query
$table_name = $_SESSION['username'] . "_categories"; 
$query = "SELECT * FROM $table_name ORDER BY category_type";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $output = array();
  while ($row = mysqli_fetch_array($result)) {
   $output[] = array (
    'category_name'=>$row['category_name'],
     'category_type' => $row['category_type'],
     'cat_id' => $row['cat_id']
     );
 }
}
?>
<div class="content-wrapper">
 <!-- Main content -->
 <section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title pull-left">Categories</h3>
          <div class="pull-right">
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="viewcategories_table">
            <thead>
              <tr>
                <th>Category Name</th>
                <th>Category Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $datatableflag = false; 
              if(!empty($output)) {
                $datatableflag = true;
                foreach ($output as $value) {
                  echo "<tr>";
                  echo "<td>".$value['category_name']."</td>";
                  echo "<td>".$value['category_type']."</td>";
                  echo '<td><a href="'.HOMEURL.'categories/edit-category.php?categoryId='.$value['cat_id'].'"><button class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit category"  type="button"><i class="glyphicon glyphicon-pencil"></i></button></a> <button class="btn btn-danger"  data-toggle="tooltip" data-placement="bottom" title="Delete category"  onclick="deleteCategory(\''.$value['cat_id'].'\')" type="button"><i class="glyphicon glyphicon-remove"></i></button></td>';
                  echo "</tr>";
                }
              }
              else {
                echo "<tr><td colspan=\"5\">No categories added. <a href=\"add-category.php\">Add One</a> now</td></tr>";
              }
              ?>

            </tbody></table>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="accdetails_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width:700px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel"> Account Details</h2>
        </div>
        <div class="modal-body" id="div_accdetails" >

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- /.content-wrapper -->
  <?php include('../footer_jsimports.php');?>
  <script type="text/javascript">
    $(document).ready(function(){
      <?php if($datatableflag){ ?>
        $('#viewcategories_table').DataTable();
        <?php } ?>
    });

    function deleteCategory(categoryId){

      bootbox.confirm('Are you sure you want to delete this category?',function(result){
        if(result){
          var data = "categoryId=" + categoryId + "&action=delete_category";
          $.ajax({
           url: "category-services.php",
           type: "POST",
           data:  data,
           dataType: 'json',
           success: function(result){ 
             bootbox.alert(result.message, function(){
               location.reload();
             });;
           },
           error: function(result){
             bootbox.alert(result.message);}           
           });
        }
      });
    }

 </script>
 <?php
 include('../footer.php'); 
 ?>