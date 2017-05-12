<?php 
session_start();

include('../dbconfig.php');
include('../header.php');
include('../sidebar.php');
//include('../common-methods.php');
$table_name_prefix = $_SESSION['username'];

if(!$_SESSION['login']){
  echo "<script>window.location.href=\"".HOMEURL."index.php\"</script>";
  //header('Location: ../index.php');
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

  input[type='number'] {
    -moz-appearance:textfield;
  }
  /*for removing spin box arrows in input */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      -webkit-appearance: none;
  }

</style>

<div class="content-wrapper">
 <!-- Main content -->
 <section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step col-xs-3"> 
            <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
            <p><small>Account</small></p>
          </div>
          <div class="stepwizard-step col-xs-3"> 
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p><small>Type</small></p>
          </div>
          <div class="stepwizard-step col-xs-3"> 
            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
            <p><small>Bank Details</small></p>
          </div>
        </div>
      </div>

      <form action="#" method="POST" onsubmit="return false;" id="addAccountForm">
        <div class="panel panel-primary setup-content" id="step-1">
          <div class="panel-heading">
           <h3 class="panel-title">Account</h3>
         </div>
         <div class="panel-body">
          <div class="form-group">
            <label for="account_name">Account Name</label>
            <input type="text" placeholder="Account name" name="account_name" id="account_name" class="form-control" required="">
          </div>
          <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
        </div>
      </div>

      <div class="panel panel-primary setup-content" id="step-2">
        <div class="panel-heading">
         <h3 class="panel-title">Type</h3>
       </div>
       <div class="panel-body">
        <hr><div class="row">
        <h3 class="panel-title">&nbsp;&nbsp;&nbsp;Account Type</h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label for="account_type">Type</label>
          <select class="form-control" id="select_account_type" name="select_account_type" required="">
            <option value="Asset">Asset</option>
            <option value="Cash">Cash</option>
            <option value="Checking">Checking</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="Loan">Loan</option>
            <option value="Others">Others</option>
            <option value="Savings">Savings</option>
          </select>
        </div>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label for="starting_balance">Satrting Balance</label>
          <input type="number" step="0.01" placeholder="Starting balance" name="starting_balance" id="starting_balance" class="form-control" required="">
        </div>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label for="open_date">Open Date</label>
          <input type="date"  placeholder="Open date" name="open_date" id="open_date" class="opendatepicker form-control" required="">
        </div>
        <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>            	
      </div>

    </div>
  </div>

  <div class="panel panel-primary setup-content" id="step-3">
    <div class="panel-heading">
     <h3 class="panel-title">Bank Details</h3>
   </div>
   <div class="panel-body">
    <div class="panel-body">
      <div class="form-group">
        <label for="account_holder_name">Account Holder Name (optional)</label>
        <input type="text" placeholder="Account holder name" name="account_holder_name" id="account_holder_name" class="form-control">
      </div>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="account_number">Account Number (optional)</label>
        <input type="number" placeholder="Account number" name="account_number" id="account_number" class="form-control">
      </div>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="bank_name">Bank Name (optional)</label>
        <input type="text" placeholder="Bank name" name="bank_name" id="bank_name" class="form-control">
      </div>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="branch">Branch (optional)</label>
        <input type="text" placeholder="Branch" name="branch" id="branch" class="form-control">
      </div>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="city">City (optional)</label>
        <input type="text" placeholder="City" name="city" id="city" class="form-control">
      </div>
      <input type="submit" name="submit" value="Add Account" class="btn btn-primary pull-right" onclick="addAccount()">
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


  function addAccount() {
    var accName = document.getElementById('account_name').value;
    var accType = document.getElementById('select_account_type').value;
    var startingBalance = document.getElementById('starting_balance').value;
    var openDate = document.getElementById('open_date').value;
    var accHolderName = document.getElementById('account_holder_name').value;
    var accNumber = document.getElementById('account_number').value;
    var bankName = document.getElementById('bank_name').value;
    var branch = document.getElementById('branch').value;
    var city = document.getElementById('city').value;
    if(accHolderName === ""){
      accHolderName = "NA";
    } 
    if(accNumber === ""){
      accNumber = "NA";
    }
    if(bankName === ""){
      bankName = "NA";
    }
    if(branch === ""){
      branch = "NA";
    }
    if(city === ""){
      city = "NA";
    }
    var data = "accName=" + accName + "&accType=" + accType + "&startingBalance=" + startingBalance + "&openDate=" + openDate + "&accHolderName=" + accHolderName + "&accNumber=" + accNumber + "&bankName=" + bankName + "&branch=" + branch + "&city=" + city + "&action=" + "add_account"; 
    $.ajax({
      url: "account-services.php",
      type: "POST",
      data:  data,
      dataType: 'json',
      success: function(result){
        bootbox.alert(result.message, function(){window.location.href = "<?php echo HOMEURL; ?>accounts/add-account.php";});
      },
      error: function(result){
        bootbox.alert(result.message);
      }           
    });
  }

  $(document).ready(function(){
    var eDate = new Date();
    eDate.setDate(eDate.getDate());
    $('.opendatepicker').datepicker({
      endDate: eDate,
      autoclose: true,
      format: 'yyyy-mm-dd',
    });
  });

</script>
<?php 
include('../footer.php'); 
?>
