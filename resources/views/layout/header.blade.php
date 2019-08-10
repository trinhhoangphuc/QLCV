<header class="main-header">

    <a href="" class="logo">

      <span class="logo-mini"><img src="{{asset('images/layouts/logo.png')}}" alt="" width="30px;"></span>

      <span class="logo-lg" style="font-size: 16px;"><img src="{{asset('images/layouts/logo.png')}}" alt="" width="30px;"> Quản Lý Công Văn</span>
    </a>
   
    <nav class="navbar navbar-static-top">

      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <!-- <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('images/layouts/avatar.png')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">Trịnh Hoàng Phúc</span>
            </a>
            <ul class="dropdown-menu">
            
              <li class="user-header">
                <img src="{{asset('images/layouts/avatar.png')}}" class="img-circle" alt="User Image">

                <p>
                  Trịnh Hoàng Phúc
                  <small>
                  </small>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <a href="info')}}" class="btn btn-default btn-flat">Thông tin</a>
                </div>
                <div class="pull-right">
                  <a href="postLogout')}}" class="btn btn-default btn-flat">Đăng xuất</a>
                </div>
              </li>
            </ul>
          </li>
        </ul> -->
      </div>
    </nav>
  </header>

  <aside class="main-sidebar">

    <section class="sidebar">

      <div class="user-panel">
        <div class="pull-left image">
          <?php $_URLIMG = (Session::get("USER_IMG") != "avatar.png" && Session::get("USER_IMG") != "avatarnu.png") ? "avatar" : "layouts"; ?>
          <img src="{{asset('')}}images/{{$_URLIMG}}/{{Session::get('USER_IMG')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Session::get("USER_NAME")}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

    
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>

   

        <li class="treeview @yield('THONG_TIN')">
          <a href="">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <span>Trang cá nhân</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="@yield('TRANG_CA_NHAN')"><a href="{{route('TRANG_CA_NHAN')}}"><i class="fa fa-circle-o"></i> Thông tin</a></li>

            <li class="@yield('LOG_DANG_NHAP')"><a href="{{route('LOG_DANG_NHAP')}}"><i class="fa fa-circle-o"></i> Nhật ký đăng nhập</a></li>


            <li class=""><a href="{{route('postLogout')}}"><i class="fa fa-circle-o"></i> Đăng xuất</a></li>

          </ul>
        </li>



        <li class="treeview @yield('DV_NHOM')">
          <a href="">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Đơn vị - Bộ phận</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="@yield('DON_VI')"><a href="{{route('DS_DON_VI')}}"><i class="fa fa-circle-o"></i> Đơn vị</a></li>

            <li class="@yield('DON_VI_BAN_HANH')"><a href="{{route('DS_DON_VI_BAN_HANH')}}"><i class="fa fa-circle-o"></i> Đơn vị ban hành</a></li>

          </ul>
        </li>

        <li class="treeview @yield('CB_QUYEN')">
          <a href="">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Cán bộ - Quyền</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="@yield('NHOM')"><a href="{{route('DS_NHOM')}}"><i class="fa fa-circle-o"></i> Nhóm quyền</a></li>

            <li class="@yield('CAN_BO')"><a href="{{route('DS_CAN_BO')}}"><i class="fa fa-circle-o"></i> Cán bộ</a></li>

          </ul>
        </li>

        <li class="treeview @yield('CONGVAN')">
          <a href="">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Công văn</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="@yield('LOAI_CONG_VAN')"><a href="{{route('DS_LOAI_CONG_VAN')}}"><i class="fa fa-list-ol"></i> Loại công văn</a></li>

            <li class="@yield('CAN_BO')"><a href="{{route('DS_CAN_BO')}}"><i class="fa fa-circle-o"></i> Cán bộ</a></li>

          </ul>
        </li>

        <li class="treeview @yield('thongke')">
          <a href="#">
            <i class="fa fa-area-chart"></i> 
            <span>Thống kê</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@yield('tknam')"><a href="'TKnam') }}"><i class="fa fa-circle-o"></i> Doanh thu</a></li>
            <li class="@yield('tkloai')"><a href="'TKloai') }}" ><i class="fa fa-circle-o"></i> Loại bán chạy</a></li>
            <li class="@yield('tksp')"><a href="'TKsanpham') }}"><i class="fa fa-circle-o"></i> Sản phẩm bán chạy</a></li>
            <li class="@yield('tonkho')"><a href="'TKsanphamTK') }}"><i class="fa fa-circle-o"></i> Số lượng trong kho</a></li>
          </ul>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

