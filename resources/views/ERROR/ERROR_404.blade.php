@extends('layout.master')
@section('title')
QLCV | Không tìm thấy trang
@endsection
@section('noidung')

<div class="content-wrapper">

	<section class="content">

		<div class="row">
			<div class="col-xs-12">

				<div class="box">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<img src="{{asset('images/layouts/404-page.gif')}}" class="responsive" width="100%">
							<div class="error_404">
								<h2>Oops! Có lỗi xảy ra</h2>
								<p>Không tìm thấy được trang bạn cần</p>
								<p>Hãy trở lại <a href="{{route('TRANG_CA_NHAN')}}">trang chủ.</a></p>

							</div>
							<br/>
						</div>
						<div class="col-sm-3"></div>
					</div>
				</div>

			</div>

		</div>

	</section>


</div>

@endsection