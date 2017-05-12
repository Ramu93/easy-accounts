<?php 

?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo HOMEURL; ?>dist/img/avatar5.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['fullname']; ?></p>
        <!-- Status -->
        <!--a href="#"><i class="fa fa-circle text-success"></i> Online</a-->
      </div>
    </div>

    <!-- search form (Optional) -->
      <!--form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form-->
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!--li class="header">HEADER</li-->
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Accounts</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>accounts/add-account.php"><i class="glyphicon glyphicon-plus"></i> <span>Add Account</span></a></li>
            <li ><a href="<?php echo HOMEURL; ?>accounts/view-accounts.php"><i class="glyphicon glyphicon-file"></i> <span>View/Edit Accounts</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-tasks"></i> <span>Transactions</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>transactions/add-transaction.php"><i class="glyphicon glyphicon-plus"></i> Add Transaction</a></li>
            <li><a href="<?php echo HOMEURL; ?>transactions/view-transactions.php"><i class="glyphicon glyphicon-file"></i> View/Edit Transactions</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="glyphicon glyphicon-list"></i> <span>Categories</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo HOMEURL; ?>categories/add-category.php"><i class="glyphicon glyphicon-plus"></i> Add Category</a></li>
            <li><a href="<?php echo HOMEURL; ?>categories/view-categories.php"><i class="glyphicon glyphicon-file"></i> View/Edit Categories</a></li>
          </ul>
        </li>
        <li class="treeview"> 
          <li><a href="<?php echo HOMEURL; ?>expenses/expense-chart.php"><i class="glyphicon glyphicon-picture"></i> <span>Expense Chart</span> </a></li>
        </li>
        <li class="treeview">
          <li><a href="<?php echo HOMEURL; ?>income/income-chart.php"><i class="glyphicon glyphicon-picture"></i> <span>Income Chart</span> </a></li>
        </li>
        <li><a href="<?php echo HOMEURL; ?>settings/settings.php"><i class="glyphicon glyphicon-cog"></i> <span>Settings</span> </a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
