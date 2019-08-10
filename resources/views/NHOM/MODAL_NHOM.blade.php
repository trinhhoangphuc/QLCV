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
									<label for="MA_NHOM">Mã nhóm quyền</label>
									<input autocomplete="off" type="text" class="form-control" name="MA_NHOM" id="MA_NHOM" placeholder="Mã nhóm quyền">
									<p id="errorID" class="help-block error "></p>
								</div>
							</div>
							<div class="col-xs-7">
								<div class="form-group">
									<label for="TEN_NHOM">Tên nhóm quyền</label>
									<input autocomplete="off" type="text" class="form-control" name="TEN_NHOM" id="TEN_NHOM" placeholder="Tên nhóm quyền">
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
						<input type="hidden" id="MA_NHOM_DELETE" value="">
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

<div class="modal fade" id="modal-role">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				<form role="form" id="InsertUpdateRole">
					<input type="hidden" id="MA_QUYEN" name="MA_QUYEN" value="">
					<div class="box-body">
						<div class="row">

							<div class="col-sm-6">
								<div class="checkbox">
									<label>
										<input id="role_1" type="checkbox" value="1" name="role[]">
										Thêm đơn vị
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_2" type="checkbox" value="2" name="role[]">
										Cập nhật đơn vị
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_3" type="checkbox" value="3" name="role[]">
										Xóa đơn vị
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_4" type="checkbox" value="4" name="role[]">
										Thêm nhóm quyền
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_5" type="checkbox" value="5" name="role[]">
										Cập nhật nhóm quyền
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_6" type="checkbox" value="6" name="role[]">
										Xóa nhóm quyền
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_7" type="checkbox" value="7" name="role[]">
										Cấp quyền cho nhóm
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_8" type="checkbox" value="8" name="role[]">
										Thêm cán bộ
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_9" type="checkbox" value="9" name="role[]">
										Cập nhật cán bộ
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_10" type="checkbox" value="10" name="role[]">
										Xóa cán bộ
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_11" type="checkbox" value="11" name="role[]">
										Cấp mật khẩu
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_12" type="checkbox" value="12" name="role[]">
										Thêm công văn
									</label>
								</div>
								
							</div>

							<div class="col-sm-6">
								<div class="checkbox">
									<label>
										<input id="role_13" type="checkbox" value="13" name="role[]">
										Cập nhật công văn
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_14" type="checkbox" value="14" name="role[]">
										Xóa công văn
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_15" type="checkbox" value="15" name="role[]">
										Chuyển công văn
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_16" type="checkbox" value="16" name="role[]">
										Thêm nơi ban hành
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_17" type="checkbox" value="17" name="role[]">
										Xoá nơi ban hành
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_18" type="checkbox" value="18" name="role[]">
										Cập nhật nơi ban hành
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_19" type="checkbox" value="19" name="role[]">
										Phê duyệt công văn
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_20" type="checkbox" value="20" name="role[]">
										Kiểm duyệt công văn
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_21" type="checkbox" value="21" name="role[]">
										Thêm loại văn bản
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_22" type="checkbox" value="22" name="role[]">
										Cập nhật loại văn bản
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_23" type="checkbox" value="23" name="role[]">
										Xóa loại văn bản
									</label>
								</div>
								<div class="checkbox">
									<label>
										<input id="role_24" type="checkbox" value="24" name="role[]">
										Quản lý nhật ký đăng nhập
									</label>
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
								<button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
							</div>
						</div>
					</div>
				</form>
				<div id="show-loader" class="spin-modal hidden"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
				<div id="show-error-loader" class="spin-modal error-loader hidden">
					Không thể tải dữ liệu, vui lòng thử lại sau.
				</div>
			</div>
		</div>
	</div>
</div>