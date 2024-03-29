<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin panel</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>



      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#category" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-list"></i>
          <span>Categories</span>
        </a>
        <div id="category" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Add Category:</h6>
            <a class="collapse-item" href="category.php">Category</a>
            <div class="dropdown-divider"></div>
            <h6 class="collapse-header">Add Sub-category:</h6>
            <a class="collapse-item" href="subcategory.php">Sub-category</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-list"></i>
          <span>Products</span>
        </a>
        <div id="product" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Add Product:</h6>
            <a class="collapse-item" href="product.php?source=add_product">Add Product</a>
            <div class="dropdown-divider"></div>
            <h6 class="collapse-header">View all products:</h6>
            <a class="collapse-item" href="product.php">View all products</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a href="orders.php" class="nav-link">
        <i class="fas fa-fw fa-list"></i>
        <span>Orders</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>