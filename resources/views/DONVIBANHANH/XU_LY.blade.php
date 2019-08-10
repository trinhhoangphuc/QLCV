<script>

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
			"order": [[ 0, "ASC" ]],
			"lengthMenu": [[10, 15, 20, 25, 30, -1], [10, 15, 20, 25, 30, "Tất cả"]],

			"processing" : true,
			"serverSide" : true,
			"ajax": "{{route('DATA_DS_DON_VI_BAN_HANH')}}",
			"columns": [
				{ "data": "STT" },
				{ "data": "madonvi" },
				{ "data": "tendonvi", },
				{ "data": "benngoai" },
				{ "data": "email" },
				{ "data": "sodienthoai" },
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
	$(document).on('click', '#btn-add', function(){	//Open DON_VI Add Form	
		$("#InsertUpdate").validate().resetForm();	
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Thêm đơn vị ban hành");

		$('#MA_DON_VI').val("");
		$('#TEN_DON_VI').val("");
		$('#EMAIL_DON_VI').val("");
		$('#SO_DIEN_THOAI').val("");
		$('#DIA_CHI').val("");
		$("#TYPE").val("0");

		$('#errorEmail').hide();
		$('#errorID').hide();
		$('#errorNAME').hide();
		$('#errorPhone');
	});

	$(document).on('click', '#btn-delete', function(){	
		$("#MA_DON_VI_DELETE").val($(this).val());		 	
		$("#modal-delete").modal("show");
		$("#modal-delete .modal-title").text("Xóa đơn vị");
	});

	$(document).on('click', '#btn-edit', function(){
		var id = $(this).val();
		$('#errorEmail').hide();
		$('#errorID').hide();
		$('#errorNAME').hide();
		$('#errorPhone');

		$("#InsertUpdate").addClass('hidden');
		$("#show-loader").removeClass("hidden");
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Sửa Đơn Vị");
		$.ajax({
			type: "GET", 
			url: "{{asset('')}}"+"/don-vi-ban-hanh/du-lieu-don-vi/"+id, 
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){ 
				if(data.error){

				}else{
					var DON_VI_DETAIL = data.message;
					$('#MA_DON_VI').val(DON_VI_DETAIL.madonvi);
					$('#TEN_DON_VI').val(DON_VI_DETAIL.tendonvi);
					$('#EMAIL_DON_VI').val(DON_VI_DETAIL.email);
					$('#SO_DIEN_THOAI').val(DON_VI_DETAIL.sodienthoai);
					$('#DIA_CHI').val(DON_VI_DETAIL.diachi);
					(DON_VI_DETAIL.benngoai == 1) ? $("#BEN_NGOAI").prop("selected", true) : $("#BEN_TRONG").prop("selected", true);
					$("#TYPE").val(DON_VI_DETAIL.madonvi);
					$("#show-loader").addClass("hidden");
					$("#InsertUpdate").removeClass('hidden');
					$("#InsertUpdate").validate().resetForm();
				}

			}
		});
	});

	$(document).ready(function() {
		$("#InsertUpdate").validate({ 
			rules: {
				MA_DON_VI: 		{ required: true, },
				EMAIL_DON_VI: 	{ required: true, email: true },
				TEN_DON_VI: 	{  required: true },
				DIA_CHI: 		{  required: true },
				SO_DIEN_THOAI: 	{  required: true, number: true, minlength: 10, maxlength: 10 },
			}, 
			messages: {
				MA_DON_VI: 		{ required: "Vui lòng nhập mã đơn vị.", },
				EMAIL_DON_VI: 	{ required: 'Vui lòng nhập email.', email: "Email không đúng định dạng." },
				TEN_DON_VI: 	{ required: "Vui lòng nhập tên đơn vị.", },
				DIA_CHI: 		{ required: "Vui lòng nhập địa chỉ." },
				SO_DIEN_THOAI: 	{ required: "Vui lòng nhập số điện thọai", 
								  number: "Vui lòng nhập số", 
								  minlength: "Số điện thoại phải đủ 10 số", 
								  maxlength: "Số điện thoại không quá 10 số" },
			},
			submitHandler: function(form) {
				var TYPE = $('#TYPE').val();
				var _URL = ($('#TYPE').val() == 0) ? "{{asset('')}}"+"don-vi-ban-hanh/them" : "{{asset('')}}"+"don-vi-ban-hanh/sua/" + $("#TYPE").val();
				
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
							(data.message.EMAIL_DON_VI != undefined) ? $('#errorEmail').text(data.message.EMAIL_DON_VI[0]).show() : $('#errorEmail').hide();

							(data.message.MA_DON_VI != undefined) ? $('#errorID').text(data.message.MA_DON_VI[0]).show() : $('#errorID').hide();

							(data.message.TEN_DON_VI != undefined) ? $('#errorNAME').text(data.message.TEN_DON_VI[0]).show() : $('#errorNAME').hide();

							(data.message.SO_DIEN_THOAI != undefined) ? $('#errorPhone').text(data.message.SO_DIEN_THOAI[0]).show() : $('#errorPhone').hide();
						}else{
							if(data.message == true){
								$('#example2').DataTable().ajax.reload();
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.info("Thêm đơn vị mới thành công!");
								else toastr.info("cập nhật đơn vị thành công!");
							}else{
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.error("Thêm đơn vị mới không thành công!");
								else toastr.error("cập nhật đơn vị không thành công!");
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
					url: "{{asset('')}}"+"don-vi-ban-hanh/xoa", 
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

	})	
</script>