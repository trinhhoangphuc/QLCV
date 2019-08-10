@extends('layout.master')

@section('title')
	QLCV | {{$TIEU_DE}}
@endsection

@section('THONG_TIN')
	active
@endsection

@section('TRANG_CA_NHAN')
	active
@endsection

@section('noidung')

<div class="content-wrapper">

	<section class="content-header">
		<h1>
			{{$TIEU_DE}}
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
			<!-- <li><a href="#">Examples</a></li> -->
			<li class="active">{{$TIEU_DE}}</li>
		</ol>
	</section>


	<section class="content">

		<div class="row">
			<div class="col-xs-12">

				<div class="box">
					<br/>
					<div class="box-body table-responsive">
						<div class="col-sm-3 text-center">
							<div class="avatar-info">
								<?php $_URLIMG = (Session::get("USER_IMG") != "avatar.png" && Session::get("USER_IMG") != "avatarnu.png") ? "avatar" : "layouts"; ?>
								<img src="{{asset('')}}images/{{$_URLIMG}}/{{$CAN_BO->anhdaidien}}" alt=""><br/><br/>
							</div>
							<button id="btn-update-info" type="button" class="btn btn-primary btn-flat btn-sm">Cập nhật</button>
							<button id="btn-update-pass" type="button" class="btn btn-default btn-flat btn-sm">Đổi mật khẩu</button>
						</div>
						<div class="col-sm-9 table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td title="admin" colspan="2" style="text-align:left; font-weight: bold; font-size: 18px;">{{ $CAN_BO->ho." ".$CAN_BO->ten }}</td>
									</tr>
									<tr>
										<td><b>Đơn vị:</b></td>
										<td>{{$CAN_BO->tendonvi}}</td>
									</tr>
									<tr>
										<td><b>Tổ/Bộ phận:</b></td>
										<td>{{$CAN_BO->tennhom}}</td>
									</tr>
									<tr>
										<td><b>MSCB:</b></td>
										<td>{{$CAN_BO->maso}}</td>

									</tr>

									<tr>
										<td><b>Ngày sinh:</b></td>
										<td>{{date_format($CAN_BO->ngaysinh, 'd-m-Y')}}</td>

									</tr>

									<tr>
										<td><b>Giới tính:</b></td>
										<td>{{ ($CAN_BO->gioitinh == 1) ? "Nam" : "Nữ" }}</td>
									</tr>
									<tr>
										<td><b>Điện thoại:</b></td>
										<td>{{$CAN_BO->sodienthoai}}</td>
									</tr>
									<tr>
										<td><b>Địa chỉ Email:</b></td>
										<td>{{$CAN_BO->email}}</td>
									</tr>
									<tr>
										<td><b>Địa chỉ:</b></td>
										<td>{{$CAN_BO->diachi}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

				</div>

			</div>

		</div>

	</section>

	@include("THONGTIN.MODAL_THONG_TIN")

</div>

@section('script')

@if(session("status"))
	<script type="text/javascript" charset="utf-8" async defer>
		var STATUS = '{{session("status")}}';
		toastr.info(STATUS);
	</script>
@endif

@include("THONGTIN.XU_LY")

@endsection
@endsection