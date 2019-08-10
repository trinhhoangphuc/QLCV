<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form role="form" id="InsertUpdate"  enctype="multipart/form-data" >
					<input type="hidden" name="TYPE" id="TYPE">
					<input type="hidden" name="TYPE_IMG" id="TYPE_IMG">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<label for="MA_CAN_BO">Mã cán bộ</label>
									<input autocomplete="off" name="MA_CAN_BO" id="MA_CAN_BO" type="text" class="form-control" placeholder="Nhập mã số cán bộ" value="">
									<p id="errorID" class="help-block error "></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5">
								<div class="form-group">
									<label for="HO">Họ/Tên đệm</label>
									<input autocomplete="off" name="HO" id="HO" type="text" class="form-control" placeholder="Nhập họ" value="">
								</div>
							</div>
							<div class="col-xs-7">
								<div class="form-group">
									<label for="TEN">Tên của bạn</label>
									<input autocomplete="off" name="TEN" id="TEN" type="text" class="form-control" placeholder="Nhập tên" value="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="DIA_CHI">Địa chỉ</label>
							<input autocomplete="off" type="text" class="form-control" id="DIA_CHI" name="DIA_CHI" placeholder="Nhập địa chỉ" value="">
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="NGAY_SINH">Ngày sinh</label>
									<input name="NGAY_SINH" id="NGAY_SINH" type="date" class="form-control" value="">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="SO_DIEN_THOAI">Số điện thoại</label>
									<input autocomplete="off" name="SO_DIEN_THOAI" id="SO_DIEN_THOAI" type="text" class="form-control" placeholder="Nhập số điện thoại" value="">
									<p id="errorPhone" class="help-block error "></p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<label for="GIOI_TINH">Giới tính</label>
									<select name="GIOI_TINH" ID="GIOI_TINH" class="form-control" onchange="changPic()">
										<option value="1" checked  >Nam</option>
										<option value="0" >Nữ</option>
									</select>
								</div>
							</div>
							<div class="col-xs-8">
								<div class="form-group">
									<label for="EMAIL">Địa chỉ Email</label>
									<input autocomplete="off" name="EMAIL" id="EMAIL" type="email" class="form-control" placeholder="Nhập địa chỉ email" value="">
									<p id="errorEmail" class="help-block error "></p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="DON_VI">Đơn vị</label>
									<select name="DON_VI" ID="DON_VI" class="form-control">
										@foreach($DON_VI as $ITEM)
										<option value="{{$ITEM->madonvi}}"  >{{$ITEM->tendonvi}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="NHOM">Nhóm quyền</label>
									<select name="NHOM" ID="NHOM" class="form-control">
										@foreach($NHOM as $ITEM)
										<option value="{{$ITEM->manhom}}"  >{{$ITEM->tennhom}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-8">
								<div class="form-group"><label>Ảnh đại diện</label>
									<input name="ANH_DAI_DIEN" id="ANH_DAI_DIEN" type="file" class="form-control" accept="image/*" onchange="loadFile(event)">
								</div>
							</div>
							<div class="col-xs-4">
								<div style="width: 80px; height: 80px;">
									<img src="" id="output" alt="" width="100%" height="100%">
									<script>
										var loadFile = function(event) {
											var output = document.getElementById('output');
											output.src = URL.createObjectURL(event.target.files[0]);
											if (window.File && window.FileReader && window.FileList && window.Blob)
											{
												var fsize = $('#ANH_DAI_DIEN')[0].files[0].size;
												if(fsize>2097152){
													$('#btn-update-info-2').attr("disabled", true);
													$('#errorUpdate').text("Kích thước ảnh lớn hơn 2MB").show();
												}else{
													$('#btn-update-info-2').attr("disabled", false);
													$('#errorUpdate').text("").hide();
												}
											}
											
										};
									</script>
								</div>
							</div>
						</div>

					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-xs-8">
								<p id="errorUpdate" class="help-block error "></p>
							</div>
							<div class="col-xs-4 text-right">
								<button type="submit" id="btn-update-info-2"  class="btn btn-primary btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
							</div>
						</div>
					</div>

				</form>
				<div id="show-loader" class="spin-modal hidden"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<div id="show-loader" class="spin-modal">
					<img src="{{asset('images/layouts/primary.png')}}" class="img-responsive" style="margin: auto">
					<h3>Bạn có chắc muốn xóa dữ liệu đã chọn?</h3>
					<form id="DeleteDV" name="DeleteDV">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" id="MA_CAN_BO_DELETE" name="MA_CAN_BO_DELETE">
						<div class="text-center">
							<button type="submit" id="btn-accept-delete"  class="btn btn-primary btn-flat"> Xác nhận</button>
							<button type="button"  class="btn btn-default btn-flat" data-dismiss="modal" aria-label="Close">Hủy bỏ</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>