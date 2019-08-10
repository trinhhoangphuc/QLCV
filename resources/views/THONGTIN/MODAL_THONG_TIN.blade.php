<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form role="form" id="InsertUpdate" >
					<div class="box-body">
						<div class="row">
							<div class="col-xs-5">
								<div class="form-group">
									<label for="HO">Họ/Tên đệm</label>
									<input autocomplete="off" name="HO" id="HO" type="text" class="form-control" placeholder="Nhập họ" value="{{$CAN_BO->ho}}">
								</div>
							</div>
							<div class="col-xs-7">
								<div class="form-group">
									<label for="TEN">Tên của bạn</label>
									<input autocomplete="off" name="TEN" id="TEN" type="text" class="form-control" placeholder="Nhập tên" value="{{$CAN_BO->ten}}">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="DIA_CHI">Địa chỉ</label>
							<input autocomplete="off" type="text" class="form-control" id="DIA_CHI" name="DIA_CHI" placeholder="Nhập địa chỉ" value="{{$CAN_BO->diachi}}">
						</div>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
									<label for="NGAY_SINH">Ngày sinh</label>
									<input name="NGAY_SINH" id="NGAY_SINH" type="date" class="form-control" value="{{date_format($CAN_BO->ngaysinh, 'Y-m-d')}}">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="SO_DIEN_THOAI">Số điện thoại</label>
									<input autocomplete="off" name="SO_DIEN_THOAI" id="SO_DIEN_THOAI" type="text" class="form-control" placeholder="Nhập số điện thoại" value="{{$CAN_BO->sodienthoai}}">
									<p id="errorPhone" class="help-block error "></p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<label for="GIOI_TINH">Giới tính</label>
									<select name="GIOI_TINH" ID="GIOI_TINH" class="form-control">
										<option value="1" <?php echo  ($CAN_BO->gioitinh == 1) ? "checked" : "" ?> >Nam</option>
										<option value="0" <?php echo  ($CAN_BO->gioitinh == 1) ? "checked" : "" ?> >Nữ</option>
									</select>
								</div>
							</div>
							<div class="col-xs-8">
								<div class="form-group">
									<label for="EMAIL">Địa chỉ Email</label>
									<input autocomplete="off" name="EMAIL" id="EMAIL" type="email" class="form-control" placeholder="Nhập địa chỉ email" value="{{$CAN_BO->email}}">
									<p id="errorEmail" class="help-block error "></p>
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
									<img src="{{asset('')}}images/{{$_URLIMG}}/{{$CAN_BO->anhdaidien}}" id="output" alt="" width="100%" height="100%">
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

<div class="modal fade" id="modal-repass">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form role="form" id="InsertUpdate_PASS" >
					<div class="box-body">
						
						<div class="form-group">
							<label for="MAT_KHAU_CU">Mật khẩu cũ</label>
							<input autocomplete="off" type="password" class="form-control" id="MAT_KHAU_CU" name="MAT_KHAU_CU" placeholder="Nhập mật khẩu cũ">
							<p id="errorOldPass" class="help-block error "></p>
						</div>
						<div class="form-group">
							<label for="MAT_KHAU_MOI">Mật khẩu mới</label>
							<input autocomplete="off" type="password" class="form-control" id="MAT_KHAU_MOI" name="MAT_KHAU_MOI" placeholder="Nhập mật khẩu mới">
						</div>
						<div class="form-group">
							<label for="NHAP_LAI">Nhập lại mật khẩu mới</label>
							<input autocomplete="off" type="password" class="form-control" id="NHAP_LAI" name="NHAP_LAI" placeholder="Nhập lại mật khẩu mới">
						</div>
						<div>
							<i style="color: #f39c12; font-size: 18px;" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
							Lưu ý, nên thay đổi mật khẩu thường xuyên để tăng tính bảo mật, mật khẩu nên chứa chữ, ký tự đặc biệt và số.
						</div>

					</div>
					<div class="box-footer">
						<div class="row">
							<div class="col-xs-8">
								<p id="errorUpdatePas" class="help-block error "></p>
							</div>
							<div class="col-xs-4 text-right">
								<button type="submit"  class="btn btn-primary btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
							</div>
						</div>
					</div>
				</form>
				<div id="show-loader" class="spin-modal hidden"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
			</div>
		</div>
	</div>
</div>