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
							<div class="col-xs-5">
								<div class="form-group">
									<label for="MA_LOAI_CONG_VAN">Mã loại</label>
									<input autocomplete="off" type="text" class="form-control" name="MA_LOAI_CONG_VAN" id="MA_LOAI_CONG_VAN" placeholder="Mã loại">
									<p id="errorID" class="help-block error "></p>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="form-group">
									<label for="TEN_LOAI_CONG_VAN">Tên loại</label>
									<input autocomplete="off" type="text" class="form-control" name="TEN_LOAI_CONG_VAN" id="TEN_LOAI_CONG_VAN" placeholder="Tên loại">
									<p id="errorNAME" class="help-block error "></p>
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
						<input type="hidden" id="MA_LOAI_CONG_VAN_DELETE" value="">
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