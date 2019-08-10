@extends('layout.master')
@section('title')
	QLCV | {{$TIEU_DE}}
@endsection

@section('DV_NHOM')
	active
@endsection

@section('DON_VI_BAN_HANH')
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

					<div class="box-body table-responsive">
						<table id="example2" class="table table-bordered table-striped" width="100%">
							<thead>
								<tr>
									<th></th>
									<th>Mã đơn vị</th>
									<th width="30%">Tên đơn vị</th>
									<th>Loại</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Thời gian</th>
									<th class="nosort" style="text-align: right;">
										<button id="btn-add" type="button" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
									</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>

				</div>

			</div>

		</div>

	</section>

	@include("DONVIBANHANH.MODAL_DON_VI")

</div>

@section('script')

@if(session("status"))
	<script type="text/javascript" charset="utf-8" async defer>
		var STATUS = '{{session("status")}}';
		toastr.info(STATUS);
	</script>
@endif

	@include("DONVIBANHANH.XU_LY")

@endsection
@endsection