<?php 
session_start();

include('../dbconfig.php');
include('../header.php');
include('../sidebar.php');
$table_name_prefix = $_SESSION['username'];

if(!$_SESSION['login']){
  echo "<script>window.location.href=\"".HOMEURL."index.php\"</script>";
}

?>
<link rel="stylesheet" href="<?php echo HOMEURL; ?>plugins/iCheck/all.css">
<style type="text/css">
  .pb10{
    padding-bottom: 10px;
  }


  .fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
  }
  .fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
  }

  /*for removing spin box arrows in input */
  input[type='number'] {
    -moz-appearance:textfield;
  }
  /*for removing spin box arrows in input */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      -webkit-appearance: none;
  }

  textarea {
    resize: none;
  }

</style>

<div class="content-wrapper">
 <!-- Main content -->
 <section class="content">
  <div class="row">
    <div class="col-md-12">
      <form action="#" method="POST" onsubmit="return false;" id="addTransactionForm">
       <div class="panel panel-primary" id="">
        <div class="panel-heading">
         <h3 class="panel-title">Transaction Details</h3>
       </div>
       <div class="panel-body">
        <div class="panel-body">
          <div class="form-group">
            <label for="category_name">Payee</label>
            <input type="text" placeholder="Payee" name="payee" id="payee" class="form-control" required="">
          </div>
        </div>
        <div class="panel-body">
          <div class="form-group" >
            <label for="category_type">Transaction Type</label>&nbsp;&nbsp;
            <!-- <input type="radio" name="transaction_type" id="transaction_type_expense" class="flat-red tadio-inline" value="Expense" checked> Expense&nbsp;&nbsp;
            <input type="radio" name="transaction_type" id="transaction_type_income" class="flat-red radio-inline" value="Income"> Income&nbsp;&nbsp;
            <input type="radio" name="transaction_type" id="transaction_type_transfer" class="flat-red radio-inline" value="Income"> Transfer&nbsp;&nbsp; -->
            <select class="form-control" onchange="getCategories(this.value)" name="select_transaction_type" id="select_transaction_type">
              <option value="Expense"> Expense</option>
              <option value="Income"> Income</option>
              <option value="Transfer"> Transfer</option>
            </select>
          </div>
        </div>
        <div class="panel-body">
          <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" placeholder="Amount" name="amount" id="amount" class="form-control" required="">
          </div>
        </div>
        <div class="panel-body" id="non_transer_category">
          <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" name="select_category" id="select_category">
              
            </select>
          </div>
        </div>
        <div class="panel-body" id="non_transfer_account">
          <div class="form-group">
            <label for="account">Account</label>
            <select class="form-control" name="select_account" id="select_account">
              
            </select>
          </div>
        </div>
         <div class="panel-body" id="from_account">
          <div class="form-group">
            <label for="from_account">From Account</label>
            <select class="form-control" name="select_from_account" id="select_from_account">
              
            </select>
          </div>
        </div>
         <div class="panel-body" id="to_account">
          <div class="form-group">
            <label for="to_account">To Account</label>
            <select class="form-control" name="select_to_account" id="select_to_account">
              
            </select>
          </div>
        </div>
        <div class="panel-body">
          <label for="transaction_date">Transaction Date</label>
          <input type="date"  placeholder="" name="transaction_date" id="transaction_date" class="transactiondatepicker form-control" required="">
        </div>
        <div class="panel-body">
          <label for="descripton">Description (optional)</label>
          <textarea class="form-control" id="description"></textarea>
        </div>
        <div class="panel-body">
          <input type="submit" name="submit" value="Add Transaction" class="btn btn-primary pull-right" onclick="addTransaction()">
        </div>
      </div>
    </div>
  </div>
</div>
</div>

</form>
</div>
</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('../footer_jsimports.php'); ?>
<script src="<?php echo HOMEURL; ?>plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript">

  $(function(){
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
  });

  function selectAccount(){
    //dummy function
  }

  function addTransaction() {
    var payee = document.getElementById('payee').value;
    var transactionType = document.getElementById('select_transaction_type').value;
    var amount = document.getElementById('amount').value;
    var categoryId = document.getElementById('select_category').value;
    var accountId = document.getElementById('select_account').value;
    var transactionDate = document.getElementById('transaction_date').value;
    var description = document.getElementById('description').value;
    var fromAccountId = document.getElementById('select_from_account').value;
    var toAccountId = document.getElementById('select_to_account').value;
    if(description === ""){
      description = "NA";
    } 
    var data;
    if(transactionType !== 'Transfer'){
      data = "payee=" + payee + "&transactionType=" + transactionType + "&amount=" + amount + "&categoryId=" + categoryId + "&accountId=" + accountId + "&transactionDate=" + transactionDate + "&description=" + description + "&action=" + "add_transaction";
      
    } else {
      data = "payee=" + payee + "&transactionType=" + transactionType + "&amount=" + amount + "&fromAccountId=" + fromAccountId + "&toAccountId=" + toAccountId + "&transactionDate=" + transactionDate + "&description=" + description + "&action=" + "add_transaction";
    } 

    if(transactionType !== 'Transfer' || fromAccountId !== toAccountId){
      $.ajax({
        url: "transaction-services.php",
        type: "POST",
        data:  data,
        dataType: 'json',
        success: function(result){
          bootbox.alert(result.message, function(){window.location.href = "<?php echo HOMEURL; ?>transactions/add-transaction.php";});
        },
        error: function(result){
          bootbox.alert(result.message);
        }           
      }); 
    } else {
      bootbox.alert("Both the account cannot be same!");
    }
  }

  $(document).ready(function(){
    var eDate = new Date();
    eDate.setDate(eDate.getDate());
    $('.transactiondatepicker').datepicker({
      endDate: eDate,
      autoclose: true,
      format: 'yyyy-mm-dd',
    });
  });


  $(document).ready(getAccounts());
  $(document).ready(getCategories('Expense'));
  $(document).ready(function(){
    $('#from_account').hide();
    $('#to_account').hide();
  });

  function getCategories(transactionType){
    if(transactionType !== 'Transfer'){
      $('#non_transer_category').show();
      $('#non_transfer_account').show();
      $('#from_account').hide();
      $('#to_account').hide();
      var data = "transactionType=" + transactionType + "&action=get_categories";
      $.ajax({
        url: "transaction-services.php",
        type: "POST",
        data:  data,
        dataType: 'html',
        success: function(result){
          $('#select_category').html(result);
        },
        error: function(result){
          bootbox.alert(result);}           
      });
    } else {
        $('#non_transer_category').hide();
        $('#non_transfer_account').hide();
        $('#from_account').show();
        $('#to_account').show();
    }
  }

  function getAccounts(){
    var data = "action=get_accounts";
    $.ajax({
        url: "transaction-services.php",
        type: "POST",
        data:  data,
        dataType: 'html',
        success: function(result){
          $('#select_account').html(result);
          $('#select_from_account').html(result);
          $('#select_to_account').html(result);
        },
        error: function(result){
          bootbox.alert(result);}           
      });
  }
</script>
<?php 
include('../footer.php'); 
?>
