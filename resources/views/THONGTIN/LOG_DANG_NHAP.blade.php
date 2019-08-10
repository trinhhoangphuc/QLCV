@extends('layout.master')

@section('title')
	QLCV | {{$TIEU_DE}}
@endsection

@section('THONG_TIN')
	active
@endsection

@section('LOG_DANG_NHAP')
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
					<div class="box-header">
						<!-- <h3 class="box-title" style="color: #3c8dbc; font-weight: bold">{{$TIEU_DE}}</h3> -->
					</div>

					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="10%" class="test">Mã Log</th>
									<th width="56%">Trình duyệt</th>
									<th>Địa chỉ IP</th>
									<th>Thời gian</th>
								</tr>
							</thead>
							<tbody>
								@foreach($LOG_DN as $ITEM)
								<tr>
									<td>{{ $ITEM->id }}</td>
									<td>{{ $ITEM->browser }}</td>
									<td>{{ $ITEM->diachiip }}</td>
									<td>{{ date_format($ITEM->ngaydangnhap, "d-m-Y H:i:s") }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>

			</div>

		</div>

	</section>



</div>

@endsection