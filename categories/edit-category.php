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

if(isset($_GET['categoryId'])) {
	$categoryId = $_GET['categoryId'];
	$table_name = $_SESSION['username'] . "_categories";
	$query = "SELECT * FROM $table_name WHERE cat_id = '$categoryId'";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_array($result);
   $categoryData = $row;
 }
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
      <form action="#" method="POST" onsubmit="return false;" id="editCategoryForm">
      <input name="category_id" id="category_id" type="hidden" value="<?php echo $categoryData['cat_id'] ?>"">
       <div class="panel panel-primary" id="">
        <div class="panel-heading">
         <h3 class="panel-title">Category Details</h3>
       </div>
       <div class="panel-body">
        <div class="panel-body">
          <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" placeholder="Category name" name="category_name" id="category_name" class="form-control" value="<?php echo $categoryData['category_name'] ?>" required="">
          </div>
        </div>
        <div class="panel-body">
          <div class="form-group">
            <label for="category_type">Category Type</label>&nbsp;&nbsp;
            <input type="radio" name="category_type" id="category_type_1" class="flat-red tadio-inline" value="Expense" <?php echo (($row['category_type']=='Expense')?'checked':''); ?> > Expense&nbsp;&nbsp;
            <input type="radio" name="category_type" id="category_type_2" class="flat-red radio-inline" value="Income" <?php echo (($row['category_type']=='Income')?'checked':''); ?> > Income&nbsp;&nbsp;
          </div>
        </div>
        <input type="submit" name="submit" value="Save Category" class="btn btn-primary pull-right" onclick="updateCategory()">
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


  function updateCategory() {
    var categoryId = document.getElementById('category_id').value;
  	var categoryName = document.getElementById('category_name').value;
    var categoryType;
    if(document.getElementById('category_type_1').checked){
      categoryType = document.getElementById('category_type_1').value;
    } else if (document.getElementById('category_type_2').checked){
      categoryType = document.getElementById('category_type_2').value;
    }
    var data = "categoryId=" + categoryId + "&categoryName=" + categoryName + "&categoryType=" + categoryType + "&action=" + "update_category"; 
    $.ajax({
      url: "category-services.php",
      type: "POST",
      data:  data,
      dataType: 'json',
      success: function(result){
        bootbox.alert(result.message, function(){window.location.href = "<?php echo HOMEURL; ?>categories/view-categories.php";});
      },
      error: function(result){
        bootbox.alert(result.message);
      }           
    });
  }

  $(document).ready(function(){
    $('.shootdatepicker').datepicker({
      format: 'yyyy-mm-dd',
    });
  });

</script>
<?php 
include('../footer.php'); 
?>
