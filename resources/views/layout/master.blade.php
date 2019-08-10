<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token()}}"/>

	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/layouts/logo.png')}}">
	<title>@yield('title')</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/bower_components/Ionicons/css/ionicons.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/dist/css/AdminLTE.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/dist/css/skins/_all-skins.min.css')}}">

	<link href="https://fonts.googleapis.com/css?family=Noto+Serif&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

	<link href="{{asset('admin/toastr/toastr.min.css')}}" rel="stylesheet">

	<link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>

<body class="hold-transition skin-blue sidebar-mini">

  <input type="hidden" id="_URL" name="_URL" value="{{asset('')}}">

	<div class="wrapper">
    
		@include('layout.header')
		
		@yield('noidung')


		@include('layout.footer')

	</div>
	


</body>

<script src="{{asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

<script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script src="{{asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

<script src="{{asset('admin/bower_components/fastclick/lib/fastclick.js')}}"></script>

<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>

<script src="{{asset('admin/dist/js/demo.js')}}"></script>

<script src="{{asset('admin/jquery-validate/jquery.validate.min.js')}}"></script>
	
<script src="{{asset('admin/toastr/toastr.min.js')}}"></script>
<script src="{{asset('admin/toastr/toastr.init.js')}}"></script>

<script>
  $(function () {
  	$('#example1').DataTable({
  		responsive: true,
  		"language": {
  			"lengthMenu": "Hiển thị _MENU_ dòng dữ liệu",
  			"info": "Hiển thị _START_ trong tổng số _TOTAL_ dòng dữ liệu",
  			"infoEmpty": "Dữ liệu rỗng",
  			"emtyTable": "Chưa có dữ liệu nào",
  			"processing": "Đang xử lý...",
  			"search": "Tìm kiếm ",
  			"loadingRecords": "Đang load dữ liệu",
  			"zeroRecords": "Không tìm thấy dữ liệu",
  			"infoFiltered": "(Được từ tổng số _MAX_ dòng dữ liệu)",
  			"paginate": {
  				"firt": "|<",
  				"last": ">|",
  				"next": ">",
  				"previous": "<"
  			}

  		},
      "order": [[ 0, "desc" ]],
  		"lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "Tất cả"]],
  		"columnDefs": [
  			{ "targets": 'nosort', "orderable": false },
  		]
  	});
  });


  	toastr.options = {
  		"closeButton": true,
  		"debug": false,
  		"newestOnTop": false,
  		"progressBar": true,
  		"positionClass": "toast-bottom-right",
  		"preventDuplicates": false,
  		"onclick": null,
  		"showDuration": "300",
  		"hideDuration": "1000",
  		"timeOut": "5000",
  		"extendedTimeOut": "1000",
  		"showEasing": "linear",
  		"hideEasing": "linear",
  		"showMethod": "show",
  		"hideMethod": "hide"
  	}

</script>
<script srype="text/javascript">
  $(document).ready(function(){ 
    $(window).scroll(function(){ 
      if ($(this).scrollTop() > 100) { 
        $('#scroll').fadeIn(); 
      } else { 
        $('#scroll').fadeOut(); 
      } 
    }); 
    $('#scroll').click(function(){ 
      $("html, body").animate({ scrollTop: 0 }, 600); 
      return false; 
    }); 
  });
</script>
@yield("script")
</html>