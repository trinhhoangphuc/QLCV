<script type="text/javascript" charset="utf-8" async defer>

	$(document).ready(function () {
		var t = $('#example2').DataTable({
			"responsive": true,
			"language": {
				"lengthMenu": "Hiển thị _MENU_ dòng dữ liệu",
				"info": "Hiển thị _START_ trong tổng số _TOTAL_ dòng dữ liệu",
				"infoEmpty": "Dữ liệu rỗng",
				"emtyTable": "Chưa có dữ liệu nào",
				"processing": "Đang xử lý...",
				"search": "Tìm kiếm ",
				"loadingRecords": "Đang load dữ liệu",
				"zeroRecords": "Không tìm thấy dữ liệu",
				"infoFiltered": "(Được từ tổng số _MAX_ dòng dữ liệu)",
				"paginate": {
					"firt": "|<",
					"last": ">|",
					"next": ">",
					"previous": "<"
				}

			},
			"order": [[ 0, "asc" ]],
			"lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "Tất cả"]],

			"processing" : true,
			"serverSide" : true,
			"ajax": "{{route('DATA_DS_NHOM')}}",
			"columns": [
				{ "data": "STT" },
				{ "data": "manhom" },
				{ "data": "tennhom" },
				{ "data": "thoigianthem", },
				{"data": "action", "className": "text-right", "orderable": false}
			]
		});

		t.on( 'order.dt search.dt', function () {
			t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			} );
		} ).draw();
	});

	$(document).on('click', '#btn-edit', function(){ // Open Nhom update form
		var id = $(this).val();
		$("#InsertUpdate").addClass('hidden');
		$("#show-loader").removeClass("hidden");
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Cập nhật nhóm");
		$('#errorID').hide();
		$('#errorNAME').hide();
		$.ajax({
			type: "GET", 
			url: "{{asset('')}}"+"nhom-quyen/du-lieu-nhom/"+id, 
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){ 
				if(data.error){

				}else{
					var NHOM_DETAIL = data.message;
					$('#MA_NHOM').val(NHOM_DETAIL.manhom);
					$('#TEN_NHOM').val(NHOM_DETAIL.tennhom);
					$("#TYPE").val(NHOM_DETAIL.manhom);
					$("#show-loader").addClass("hidden");
					$("#InsertUpdate").removeClass('hidden');
					$("#InsertUpdate").validate().resetForm();	
				}

			}
		});
	});

	$(document).on('click', '#btn-add', function(){	//Open Nhom Add Form	
		$("#InsertUpdate").validate().resetForm();	
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Thêm Nhóm Mới");
		$('#MA_NHOM').attr('readonly', false);
		$('#MA_NHOM').val("");
		$('#TEN_NHOM').val("");
		$("#TYPE").val("0");
		$('#errorID').hide();
		$('#errorNAME').hide();
	});

	$(document).on('click', '#btn-delete', function(){ //Open Nhom Delete Form	
		$("#MA_NHOM_DELETE").val($(this).val());		 	
		$("#modal-delete").modal("show");
		$("#modal-delete .modal-title").text("Xóa nhóm");
	});

	$(document).on('click', '#btn-role', function(){ //Open Nhom Role Form	
		var id = $(this).val();	
		$("#MA_QUYEN").val(id);	 	
		$("#modal-role").modal("show");
		$("#modal-role .modal-title").text("Cấp quyền cho nhóm quyền");
		$("#InsertUpdateRole").addClass('hidden');
		$("#show-loader").removeClass("hidden");
		$.ajax({
			type: "GET", 
			url: "{{asset('')}}"+"nhom-quyen/quyen-nhom/"+id, 
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){ 
				$("input:checkbox").prop("checked", false);
				$("#show-loader").addClass("hidden");
				if(data.error){
					$("#show-error-loader").removeClass("hidden");
				}else{
					$("#InsertUpdateRole").removeClass('hidden');
					var QUYEN_NHOM_DETAIL = data.message;
					if(QUYEN_NHOM_DETAIL.length > 0){
						for(i=1; i<=24; i++){
							for(j=0; j<	QUYEN_NHOM_DETAIL.length; j++){
								if( $("#role_"+i).val() == QUYEN_NHOM_DETAIL[j].quyen){
									$("#role_"+i).prop("checked", true);
									break;
								}
							}	
						}
					}else{
						for(i=1; i<=24; i++){ $("#role_"+i).prop("checked", false); }
					}

				}

			}, error: function (data) {
				console.log(data)
			}
		});
	});

	$(document).ready(function() {
		$("#InsertUpdate").validate({ // Nhom Insert && Update 	
			rules: {
				MA_NHOM: 		{ required: true, },
				EMAIL_NHOM: 	{ required: true, email: true },
				TEN_NHOM: 	{  required: true },
			}, 
			messages: {
				MA_NHOM: 		{ required: "Xin vui lòng nhập mã nhóm.", },
				EMAIL_NHOM: 	{ required: 'Xin vui lòng nhập email.', email: "Email không đúng định dạng." },
				TEN_NHOM: 	{ required: "Xin vui lòng nhập tên nhóm.", },
			},
			submitHandler: function(form) {
				var _URL = ($('#TYPE').val() == 0) ? "{{asset('')}}"+"nhom-quyen/them" : "{{asset('')}}"+"nhom-quyen/sua/" + $("#TYPE").val();
				
				$.ajax({
					url: _URL,
					method: "POST",
					data:new FormData(form),
					dataType: 'JSON',
					contentType: false,
					cache: false,
					processData: false,
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(data){ 
						if(data.error){
							(data.message.MA_NHOM != undefined) ? $('#errorID').text(data.message.MA_NHOM[0]).show() : $('#errorID').hide();

							(data.message.TEN_NHOM != undefined) ? $('#errorNAME').text(data.message.TEN_NHOM[0]).show() : $('#errorNAME').hide();
						}else{
							if(data.message == true){
								$('#example2').DataTable().ajax.reload();
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.info("Thêm nhóm mới thành công!");
								else toastr.info("cập nhật nhóm thành công!");
							}else{
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.error("Thêm nhóm mới không thành công!");
								else toastr.error("cập nhật nhóm không thành công!");
							}
						}
						
					},
					error:function(err){ }
				});
			}
		});

		$("#DeleteDV").validate({ //Nhom Delete 

			submitHandler: function(form) {
				$.ajax({
					type: "POST", 
					url: "{{asset('')}}"+"nhom-quyen/xoa", 
					data: {
						'MA_NHOM' : $('#MA_NHOM_DELETE').val(),	
					},
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(data){ 
						if(data.error){
							$("#modal-delete").modal("hide");
							toastr.error("Dữ liệu đã được sử dụng");
						}else{
							if(data.message == true){
								$('#example2').DataTable().ajax.reload();
								$("#modal-delete").modal("hide");
								toastr.info("Xóa nhóm thành công!");
							}
						}
					},
					error:function(err){ 
						$("#modal-delete").modal("hide");
						toastr.error("Không thể xóa dữ liệu");
					}
				});
			}
		});

		$("#InsertUpdateRole").validate({ //Nhom Role Update 

			submitHandler: function(form) {
				var dsCheckBox = [];
				for(i=1; i<=24; i++){
					if( $("#role_"+i).prop("checked")){
						dsCheckBox.push($("#role_"+i).val());
					}
				}
				if(dsCheckBox.length > 0){
					$.ajax({
						type: "POST", 
						url: "{{asset('')}}"+"nhom-quyen/cap-quyen/"+$("#MA_QUYEN").val(), 
						data:new FormData(form),
						dataType: 'JSON',
						contentType: false,
						cache: false,
						processData: false,
						headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						success: function(data){ 
							if(data.error){
								$("#modal-role").modal("hide");
								toastr.error("Không thể cấp quyền");
							}else{
								if(data.message == true){
									$('#example2').DataTable().ajax.reload();
									$("#modal-role").modal("hide");
									toastr.info("cấp quyền thành công!");
								}
							}
						},
						error:function(err){ 
							console.log(err);
						}
					});
				}else{
					$("#errorUpdate").text("Bạn chưa chọn dữ liệu").show();
				}
				
			}
		});

	})	
</script>