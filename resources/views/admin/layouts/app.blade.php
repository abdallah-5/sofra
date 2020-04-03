<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sofra</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="{{url('\admin\home')}}" class="brand-link ">

              <span class="brand-text font-weight-bold text-uppercase" style="font-size:40px">Sofra</span>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('cities.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-city"></i>
              <p>Cities</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('regions.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-map-marker-alt"></i>
              <p>Regions</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('categories.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Categories</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('offers.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Offers</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('contacts.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-phone-alt"></i>
              <p>Contacts</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('restaurants.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-hamburger"></i>
              <p>Restaurants</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('clients.index'))}}" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>Clients</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('orders.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Orders</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url(route('users.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{url(route('roles.index'))}}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Roles</p>
            </a>
          </li>

          @inject('setting','App\Models\Setting')
          <li class="nav-item">
            <a href="{{url(route('settings.edit',$setting->first()))}}" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Settings</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('page_title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('\home')}}">Home</a></li>
              <li class="breadcrumb-item active">@yield('page_title')</li>
              <li class="breadcrumb-item active">logout</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">

    <strong>Copyright &copy; 2020 AAA </strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>
@stack('scripts')

</body>
</html>
