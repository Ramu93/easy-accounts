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
$table_name = $_SESSION['username'] . "_accounts"; 
$query = "SELECT * FROM $table_name";
$result = mysqli_query($dbc,$query);
if(mysqli_num_rows($result) > 0) {
  $output = array();
  while ($row = mysqli_fetch_array($result)) {
   $output[] = array (
     'acc_name'=>$row['acc_name'],
     'acc_type' => $row['acc_type'],
     'current_balance'=> $row['current_balance'],
     'acc_id' => $row['acc_id']
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
          <h3 class="box-title pull-left">Account Details</h3>
          <div class="pull-right">
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="viewaccounts_table">
            <thead>
              <tr>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Current Balance</th>
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
                  echo "<td>".$value['acc_name']."</td>";
                  echo "<td>".$value['acc_type']."</td>";
                  echo "<td>".$value['current_balance']."</td>";
                  echo '<td><button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="View details"  onclick="viewDetails(\''.$value['acc_id'].'\');" ><i class="glyphicon glyphicon-new-window"></i></button> <a href="'.HOMEURL.'accounts/edit-account.php?accId='.$value['acc_id'].'"><button class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit account"  type="button"><i class="glyphicon glyphicon-pencil"></i></button></a> <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete account"  onclick="deleteAccount(\''.$value['acc_id'].'\')" type="button"><i class="glyphicon glyphicon-remove"></i></button></td>';
                  echo "</tr>";
                }
              }
              else {
                echo "<tr><td colspan=\"5\">No accounts added. <a href=\"add-account.php\">Add One</a> now</td></tr>";
              }
              ?>

            </tbody></table>
          </div>
          <!-- /.box-body -->
            <!--div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div>
          </div-->
          <!-- /.box -->
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
        $('#viewaccounts_table').DataTable();
        <?php } ?>
      });

    function deleteAccount(accountId){

      bootbox.confirm('Deleting this account will also delete all the transactions made through this account. Are you sure you want to delete this account?',function(result){
        if(result){
          bootbox.confirm('Are you sure?',function(resultTwo){
            if(resultTwo){
              var data = "accountId="+accountId+"&action=delete_account";
              $.ajax({
               url: "account-services.php",
               type: "POST",
               data:  data,
               dataType: 'json',
               success: function(result){ 
                 bootbox.alert(result.message, function(){
                   location.reload();
                 });
               },
               error: function(result){
                 bootbox.alert(result.message);
               }           
              });
            }
          });
        }
      });
    }

    function viewDetails(accId){
     var data = "accId="+accId+"&action=get_account_details";
     $.ajax({
       url: "account-services.php",
       type: "POST",
       data:  data,
       dataType: 'html',
       success: function(result){
         $('#div_accdetails').html(result);
         $('#accdetails_modal').modal('show');
       },
       error: function(result){
         bootbox.alert("error");
       }           
     });
   }

 </script>
 <?php
 include('../footer.php'); 
 ?>