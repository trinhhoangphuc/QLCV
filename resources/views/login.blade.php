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
	<title>Đăng nhập hệ thống</title>


	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">

	<link rel="stylesheet" href="{{asset('admin/dist/css/skins/_all-skins.min.css')}}">

	<link href="https://fonts.googleapis.com/css?family=Noto+Serif&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{asset('admin/animate/animate2.min.css')}}">

	<link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>

<body style="background: #2f6d93">

 <div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="login-form animated fadeInRight" >
        <div class="title">
          <img src="{{asset('images/layouts/logo.png')}}" style="width: 100px;" alt="">
        </div>
        <p class="title-2">
          Vui lòng sử dụng tài khoản mà chúng tôi đã cung cấp cho bạn để đăng nhập vào hệ thống.
        </p>
        <hr class="custom-hr" />
        <form name="login-admin" id="login-admin" method="POST">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label for="MA_CAN_BO"><b>Mã số cán bộ:</b></label>
            <input autocomplete="off" type="text" class="form-control none-border-radius" id="MA_CAN_BO" name="MA_CAN_BO" placeholder="Mã số cán bộ...">
          </div>
          <div class="form-group">
            <label for="MAT_KHAU"><b>Mật khẩu:</b></label>
            <input type="password" class="form-control none-border-radius" id="MAT_KHAU" name="MAT_KHAU" placeholder="Mật khẩu">
          </div>
          <div class="form-group">
            <span id="errorLogin" class="error"></span>
          </div>
          <hr class="custom-hr" />
          <button type="submit" class="btn none-border-radius btn-block btn-login">Đăng nhập</button>
        </form>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>
</div>


</body>

<script src="{{asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>

<script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>

<script src="{{asset('admin/jquery-validate/jquery.validate.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){

    $("#login-admin").validate({ 
      rules: {
        MA_CAN_BO: {  required: true, },
        MAT_KHAU:{ required: true, }
      }, 
      messages: {
        MA_CAN_BO: {
          required: "Xin vui lòng nhập mã cán bộ!",
        },
        MAT_KHAU: {
          required: "Xin vui lòng nhập mật khẩu!",
        }
      },
      submitHandler: function(form) {
        $.ajax({
          type: "POST", 
          url: "{{ route('postlogin') }}", 
          data: {
            'MA_CAN_BO' : $('#MA_CAN_BO').val(),
            'MAT_KHAU'   : $('#MAT_KHAU').val(),
          },
          headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function(data){ 
            if(data.message == true)
              location.reload();
            else 
              $("#errorLogin").text("Mã cán bộ hoặc mật khẩu không chính xác").show().fadeOut( 7000 );
          },error: function(data){
            console.log(data);
          }
        });
      }
    });
  })
</script>
</html>