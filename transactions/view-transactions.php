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
?>
<div class="content-wrapper">
 <!-- Main content -->
 <section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary" id="">
        <div class="panel-heading">
          <h3 class="panel-title">Transaction Dates</h3>
        </div>
        <div class="panel-body">
          <form action="#" method="POST" onsubmit="return false;" id="addTransactionForm">
            <div class="panel-body">
              <label for="from_date">From Date</label>
              <input type="date"  placeholder="" name="from_date" id="from_date" class="transactiondatepicker form-control" required="">
            </div>
            <div class="panel-body">
              <label for="to_date">To Date</label>
              <input type="date"  placeholder="" name="to_date" id="to_date" class="transactiondatepicker form-control" required="">
            </div>
            <div class="panel-body">
              <input type="submit" name="submit" value="View Transactions" class="btn btn-primary pull-left" onclick="getTransactions()">
              <input type="submit" name="submit" value="Export" class="btn btn-primary pull-right" onclick="exportTransactions()">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box">
        <ul class="nav nav-tabs" data-toggle="tab">
          <li role="presentation" class="active" id="expenses_tab"><a href="#">Expenses</a></li>
          <li role="presentation" id="income_tab"><a href="#">Income</a></li>
          <li role="presentation" id="transfers_tab"><a href="#">Transfers</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="expenses_content">
            <div class="panel-body" id="expenses_div">
              
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="income_content">
            <div class="panel-body" id="income_div">
              
            </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="transfers_content">
            <div class="panel-body" id="transfers_div">
              
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="transaction_details_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width:700px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h2 class="modal-title" id="myModalLabel"> Description</h2>
        </div>
        <div class="modal-body" id="div_transaction_details" >

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
      $('#expenses_content').show();
      $('#income_content').hide();
      $('#transfers_content').hide();
      var eDate = new Date();
      eDate.setDate(eDate.getDate());
      $('.transactiondatepicker').datepicker({
        endDate: eDate,
        autoclose: true,
        format: 'yyyy-mm-dd',
      });
    });

    $('#expenses_tab').click(function (e) {
      e.preventDefault()
      $('#expenses_content').show();
      $('#income_content').hide();
      $('#transfers_content').hide();
    })

    $('#income_tab').click(function (e) {
      e.preventDefault()
      $('#expenses_content').hide();
      $('#income_content').show();
      $('#transfers_content').hide();
    })

    $('#transfers_tab').click(function (e) {
      e.preventDefault()
      $('#expenses_content').hide();
      $('#income_content').hide();
      $('#transfers_content').show();
    })

    function getTransactions(){
      var fromDate = $('#from_date').val();
      var toDate = $('#to_date').val();
      getExpenses(fromDate,toDate);
      getIncome(fromDate, toDate);
      getTransfers(fromDate, toDate)
    }

    function exportTransactions(){

    }

    function getExpenses(fromDate, toDate){
      var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&transactionType=Expense" + "&action=get_transactions";
      $.ajax({
         url: "transaction-services.php",
         type: "GET",
         data:  data,
         dataType: 'html',
         success: function(result){ 
           $('#expenses_div').html(result);
         },
         error: function(result){
           bootbox.alert(result);
         }           
      });
    }

    function getIncome(fromDate, toDate){
      var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&transactionType=Income" + "&action=get_transactions";
      $.ajax({
         url: "transaction-services.php",
         type: "GET",
         data:  data,
         dataType: 'html',
         success: function(result){ 
           $('#income_div').html(result);
         },
         error: function(result){
           bootbox.alert(result);
         }           
      });
    }

    function getTransfers(fromDate, toDate){
      var data = "fromDate=" + fromDate + "&toDate=" + toDate + "&transactionType=Transfer" + "&action=get_transactions";
      $.ajax({
         url: "transaction-services.php",
         type: "GET",
         data:  data,
         dataType: 'html',
         success: function(result){ 
           $('#transfers_div').html(result);
         },
         error: function(result){
           bootbox.alert(result);
         }           
      });
    }

    function viewDetails(transactionId){
      var data = "transactionId=" + transactionId + "&action=get_transaction_details";
      $.ajax({
        url: "transaction-services.php",
        type: "POST",
        data:  data,
        dataType: 'html',
        success: function(result){
          $('#div_transaction_details').html(result);
          $('#transaction_details_modal').modal('show');
        },
        error: function(result){
          bootbox.alert("error");
        }           
      });
    }

    function deleteTransaction(transactionId){

      bootbox.confirm('Are you sure you want to delete this transaction?',function(result){
        if(result){
          var data = "transactionId=" + transactionId + "&action=delete_transaction";
          $.ajax({
           url: "transaction-services.php",
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