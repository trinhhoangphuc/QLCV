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
			"ajax": "{{route('DATA_DS_LOAI_CONG_VAN')}}",
			"columns": [
				{ "data": "STT" },
				{ "data": "maloai" },
				{ "data": "tenloai" },
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
	
	$(document).on('click', '#btn-add', function(){		
		$("#InsertUpdate").validate().resetForm();		 	
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Thêm Loại Cong Văn Mới");
		$('#MA_LOAI_CONG_VAN').val("");
		$('#TEN_LOAI_CONG_VAN').val("");
		$("#TYPE").val("0");
		$('#errorID').hide();
		$('#errorNAME').hide();
	});

	$(document).on('click', '#btn-edit', function(){
		var id = $(this).val();
		$('#errorID').hide();
		$('#errorNAME').hide();

		$("#InsertUpdate").validate().resetForm();
		$("#InsertUpdate").addClass('hidden');
		$("#show-loader").removeClass("hidden");
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Cập Nhật Loại Công Văn");
		$.ajax({
			type: "GET", 
			url: "{{asset('')}}"+"/loai-cong-van/du-lieu/"+id, 
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){ 
				if(data.error){

				}else{
					var LOAI_CONG_VAN_DETAIL = data.message;
					$('#MA_LOAI_CONG_VAN').val(LOAI_CONG_VAN_DETAIL.maloai);
					$('#TEN_LOAI_CONG_VAN').val(LOAI_CONG_VAN_DETAIL.tenloai);
					$("#TYPE").val(LOAI_CONG_VAN_DETAIL.maloai);
					$("#show-loader").addClass("hidden");
					$("#InsertUpdate").removeClass('hidden');	
					$("#InsertUpdate").validate().resetForm();
				}

			}
		});
	});

	$(document).on('click', '#btn-delete', function(){	
		$("#MA_LOAI_CONG_VAN_DELETE").val($(this).val());		 	
		$("#modal-delete").modal("show");
		$("#modal-delete .modal-title").text("Xóa Loại Công Văn");
	});

	$(document).ready(function() {
		$("#InsertUpdate").validate({ 
			rules: {
				MA_LOAI_CONG_VAN: 		{ required: true, },
				TEN_LOAI_CONG_VAN: 		{  required: true },
			}, 
			messages: {
				MA_LOAI_CONG_VAN: 		{ required: "Xin vui lòng nhập mã loại công văn.", },
				TEN_LOAI_CONG_VAN: 		{ required: "Xin vui lòng nhập tên loại công văn.", },
			},
			submitHandler: function(form) {
				var TYPE = $('#TYPE').val();
				var _URL = (TYPE == 0) ? "{{asset('')}}"+"loai-cong-van/them" : "{{asset('')}}"+"loai-cong-van/sua/" + TYPE;
				
				$.ajax({
					type: "POST", 
					url: _URL, 
					data: {
						'MA_LOAI_CONG_VAN' 	 : $('#MA_LOAI_CONG_VAN').val(),
						'TEN_LOAI_CONG_VAN' 	 : $('#TEN_LOAI_CONG_VAN').val(),	
					},
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(data){ 
						if(data.error){
							(data.message.MA_LOAI_CONG_VAN != undefined) ? $('#errorID').text(data.message.MA_LOAI_CONG_VAN[0]).show() : $('#errorID').hide();

							(data.message.TEN_LOAI_CONG_VAN != undefined) ? $('#errorNAME').text(data.message.TEN_LOAI_CONG_VAN[0]).show() : $('#errorNAME').hide();
						}else{
							if(data.message == true){
								$('#example2').DataTable().ajax.reload();
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.info("Thêm loại công văn mới thành công!");
								else toastr.info("cập nhật loại công văn thành công!");
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
					url: "{{route('XOA_LOAI_CONG_VAN')}}", 
					data: {
						'MA_LOAI_CONG_VAN' : $('#MA_LOAI_CONG_VAN_DELETE').val(),	
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
								toastr.info("Xóa loại công văn thành công!");
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