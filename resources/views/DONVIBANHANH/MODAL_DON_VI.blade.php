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
						<input type="hidden" name="TYPE" id="TYPE">
						<div class="row">
							<div class="col-xs-4">
								<div class="form-group">
									<label for="MA_DON_VI">Mã đơn vị</label>
									<input autocomplete="off" type="text" class="form-control" name="MA_DON_VI" id="MA_DON_VI" placeholder="Mã đơn vị">
									<p id="errorID" class="help-block error "></p>
								</div>
							</div>
							<div class="col-xs-8">
								<div class="form-group">
									<label for="TEN_DON_VI">Tên đơn vị</label>
									<input autocomplete="off" type="text" class="form-control" name="TEN_DON_VI" id="TEN_DON_VI" placeholder="Tên đơn vị">
									<p id="errorNAME" class="help-block error "></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-7">
								<div class="form-group">
									<label for="SO_DIEN_THOAI">Số điện thoại</label>
									<input autocomplete="off" type="text" class="form-control" name="SO_DIEN_THOAI" id="SO_DIEN_THOAI" placeholder="Số điện thoại">
									<p id="errorPhone" class="help-block error "></p>
								</div>
							</div>
							<div class="col-xs-5">
								<div class="form-group">
									<label for="LOAI_DON_VI">Loại đơn vị</label>
									<select name="LOAI_DON_VI" ID="LOAI_DON_VI" class="form-control">
										<option value="1" id="BEN_NGOAI">Ngoài trường</option>
										<option value="0" id="BEN_TRONG">Trong trường</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5">
								<div class="form-group">
									<label for="EMAIL_DON_VI">Email đơn vị</label>
									<input autocomplete="off" type="email" class="form-control" id="EMAIL_DON_VI" name="EMAIL_DON_VI" placeholder="Email đơn vị">
									<p id="errorEmail" class="help-block error "></p>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="form-group">
									<label for="DIA_CHI">Địa chỉ</label>
									<input autocomplete="off" type="text" class="form-control" name="DIA_CHI" id="DIA_CHI" placeholder="Địa chỉ">
								</div>
							</div>
						</div>
						
					</div>
					<div class="box-footer text-right">
						<button type="submit"  class="btn btn-primary btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
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
						<input type="hidden" id="MA_DON_VI_DELETE" value="">
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