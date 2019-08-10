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
			"ajax": "{{route('DATA_DS_DON_VI')}}",
			"columns": [
				{ "data": "STT" },
				{ "data": "madonvi" },
				{ "data": "tendonvi" },
				{ "data": "email" },
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
	
	$(document).on('click', '#btn-edit', function(){
		var id = $(this).val();
		$('#errorEmail').hide();
		$('#errorID').hide();
		$('#errorNAME').hide();

		$("#InsertUpdate").validate().resetForm();
		$("#InsertUpdate").addClass('hidden');
		$("#show-loader").removeClass("hidden");
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Sửa Đơn Vị");
		$.ajax({
			type: "GET", 
			url: "{{asset('')}}"+"/don-vi/du-lieu-don-vi/"+id, 
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){ 
				if(data.error){

				}else{
					var DON_VI_DETAIL = data.message;
					$('#MA_DON_VI').val(DON_VI_DETAIL.madonvi);
					$('#TEN_DON_VI').val(DON_VI_DETAIL.tendonvi);
					$('#EMAIL_DON_VI').val(DON_VI_DETAIL.email);
					$("#TYPE").val(DON_VI_DETAIL.madonvi);
					$("#show-loader").addClass("hidden");
					$("#InsertUpdate").removeClass('hidden');	
					$("#InsertUpdate").validate().resetForm();
				}

			}
		});
	});

	$(document).on('click', '#btn-add', function(){		
		$("#InsertUpdate").validate().resetForm();		 	
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Thêm Đơn Vị Mới");
		$('#MA_DON_VI').attr('readonly', false);
		$('#MA_DON_VI').val("");
		$('#TEN_DON_VI').val("");
		$('#EMAIL_DON_VI').val("");
		$("#TYPE").val("0");
		$('#errorEmail').hide();
		$('#errorID').hide();
		$('#errorNAME').hide();
	});

	$(document).on('click', '#btn-delete', function(){	
		$("#MA_DON_VI_DELETE").val($(this).val());		 	
		$("#modal-delete").modal("show");
		$("#modal-delete .modal-title").text("Xóa đơn vị");
	});

	$(document).ready(function() {
		$("#InsertUpdate").validate({ 
			rules: {
				MA_DON_VI: 		{ required: true, },
				EMAIL_DON_VI: 	{ required: true, email: true },
				TEN_DON_VI: 	{  required: true },
			}, 
			messages: {
				MA_DON_VI: 		{ required: "Xin vui lòng nhập mã đơn vị.", },
				EMAIL_DON_VI: 	{ required: 'Xin vui lòng nhập email.', email: "Email không đúng định dạng." },
				TEN_DON_VI: 	{ required: "Xin vui lòng nhập tên đơn vị.", },
			},
			submitHandler: function(form) {
				var TYPE = $('#TYPE').val();
				var _URL = (TYPE == 0) ? "{{asset('')}}"+"don-vi/them" : "{{asset('')}}"+"don-vi/sua/" + TYPE;
				
				$.ajax({
					type: "POST", 
					url: _URL, 
					data: {
						'MA_DON_VI' 	 : $('#MA_DON_VI').val(),
						'TEN_DON_VI' 	 : $('#TEN_DON_VI').val(),
						'EMAIL_DON_VI'   : $('#EMAIL_DON_VI').val(),	
					},
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(data){ 
						if(data.error){
							(data.message.EMAIL_DON_VI != undefined) ? $('#errorEmail').text(data.message.EMAIL_DON_VI[0]).show() : $('#errorEmail').hide();

							(data.message.MA_DON_VI != undefined) ? $('#errorID').text(data.message.MA_DON_VI[0]).show() : $('#errorID').hide();

							(data.message.TEN_DON_VI != undefined) ? $('#errorNAME').text(data.message.TEN_DON_VI[0]).show() : $('#errorNAME').hide();
						}else{
							if(data.message == true){
								$('#example2').DataTable().ajax.reload();
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.info("Thêm đơn vị mới thành công!");
								else toastr.info("cập nhật đơn vị thành công!");
							}
						}
						
					},
					error:function(err){}
				});
			}
		});

		$("#DeleteDV").validate({ 

			submitHandler: function(form) {
				$.ajax({
					type: "POST", 
					url: "{{asset('')}}"+"don-vi/xoa", 
					data: {
						'MA_DON_VI' : $('#MA_DON_VI_DELETE').val(),	
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
								toastr.info("Xóa đơn vị thành công!");
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

	});	
</script>