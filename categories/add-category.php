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

</style>

<div class="content-wrapper">
 <!-- Main content -->
 <section class="content">
  <div class="row">
    <div class="col-md-12">
      <form action="#" method="POST" onsubmit="return false;" id="addCategoryForm">
       <div class="panel panel-primary" id="">
        <div class="panel-heading">
         <h3 class="panel-title">Category Details</h3>
       </div>
       <div class="panel-body">
        <div class="panel-body">
          <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" placeholder="Category name" name="category_name" id="category_name" class="form-control" required="">
          </div>
        </div>
        <div class="panel-body">
          <div class="form-group">
            <label for="category_type">Category Type</label>&nbsp;&nbsp;
            <input type="radio" name="category_type" id="category_type_expense" class="flat-red tadio-inline" value="Expense" checked> Expense&nbsp;&nbsp;
            <input type="radio" name="category_type" id="category_type_income" class="flat-red radio-inline" value="Income"> Income&nbsp;&nbsp;
          </div>
        </div>
        <div class="panel-body">
          <input type="submit" name="submit" value="Add Category" class="btn btn-primary pull-right" onclick="addCategory()">
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


  function addCategory() {
    var categoryName = document.getElementById('category_name').value;
    var categoryType;
    if(document.getElementById('category_type_expense').checked){
      categoryType = document.getElementById('category_type_expense').value;
    } else if (document.getElementById('category_type_income').checked){
      categoryType = document.getElementById('category_type_income').value;
    }
    var data = "categoryName=" + categoryName + "&categoryType=" + categoryType + "&action=" + "add_category"; 
    $.ajax({
      url: "category-services.php",
      type: "POST",
      data:  data,
      dataType: 'json',
      success: function(result){
        bootbox.alert(result.message, function(){window.location.href = "<?php echo HOMEURL; ?>categories/add-category.php";});
      },
      error: function(result){
        bootbox.alert(result.message);
      }           
    });
  }

</script>
<?php 
include('../footer.php'); 
?>
