<script type="text/javascript" charset="utf-8" async defer>

	var changPic = function(event) {
		if($('#ANH_DAI_DIEN').val() == "" && ($("#TYPE_IMG").val() == "avatar.png" || $("#TYPE_IMG").val() == "avatarnu.png")){
			var GENDER = $("#GIOI_TINH").val();
			var IMG = (GENDER == 1) ? "avatar.png" : "avatarnu.png"
			var output = document.getElementById('output');
			output.src = "{{asset('images/layouts/')}}/"+IMG;
		}
	};
	
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
			"ajax": "{{route('DATA_DS_CAN_BO')}}",
			"columns": [
				{ "data": "STT" },
				{ "data": "maso" },
				{ 
					"data": "anhdaidien",
					render: function (data, type, full, meta) {
						var _URLIMG = (data != "avatar.png" && data != "avatarnu.png") ? "avatar" : "layouts";
                		return '<img src="{{asset('')}}/images/'+_URLIMG+'/'+data+'" class="img-thumbnail" alt="User Image" />'
					}
				},
				{ "data": "ten" },
				{ "data": "tendonvi" },
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
	
	$(document).on('click', '#btn-edit', function(){
		var id = $(this).val();
		$('#errorEmail').hide();
		$('#errorID').hide();
		$('#errorNAME').hide();

		$("#InsertUpdate").validate().resetForm();
		$("#InsertUpdate").addClass('hidden');
		$("#show-loader").removeClass("hidden");
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Sửa cán bộ");
		$.ajax({
			type: "GET", 
			url: "{{asset('')}}"+"can-bo/du-lieu/"+id, 
			headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(data){ 
				if(data.error){

				}else{
					var CAN_BO_DETAIL = data.message;
					var now = new Date(CAN_BO_DETAIL.ngaysinh);
					var day = ("0" + now.getDate()).slice(-2);
					var month = ("0" + (now.getMonth() + 1)).slice(-2);
					var today = now.getFullYear()+"-"+(month)+"-"+(day) ;

					$("#MA_CAN_BO").val(CAN_BO_DETAIL.maso);
					$("#HO").val(CAN_BO_DETAIL.ho);
					$("#TEN").val(CAN_BO_DETAIL.ten);
					$("#DIA_CHI").val(CAN_BO_DETAIL.diachi);
					$("#NGAY_SINH").val(today);
					$("#SO_DIEN_THOAI").val(CAN_BO_DETAIL.sodienthoai);
					$("#EMAIL").val(CAN_BO_DETAIL.email);
					$('#GIOI_TINH option[value='+CAN_BO_DETAIL.gioitinh+']').attr('selected','selected');
					$('#DON_VI option[value='+CAN_BO_DETAIL.madonvi+']').attr('selected','selected');
					$('#NHOM option[value='+CAN_BO_DETAIL.manhom+']').attr('selected','selected');
					
					$("#TYPE").val(CAN_BO_DETAIL.id);
					$("#TYPE_IMG").val(CAN_BO_DETAIL.anhdaidien);
					
					var output = document.getElementById('output');
					var _URLIMG = (CAN_BO_DETAIL.anhdaidien != "avatar.png" && CAN_BO_DETAIL.anhdaidien != "avatarnu.png") ? "avatar" : "layouts";
					output.src = "{{asset('')}}/images/"+_URLIMG+"/"+CAN_BO_DETAIL.anhdaidien;

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
		$("#modal-default .modal-title").text("Thêm cán bộ Mới");

		$("#MA_CAN_BO").val("");
		$("#HO").val("");
		$("#TEN").val("");
		$("#DIA_CHI").val("");
		$("#NGAY_SINH").val("");
		$("#SO_DIEN_THOAI").val("");
		$("#EMAIL").val("");
		$('#GIOI_TINH option[value=1]').attr('selected','selected');
		$("#ANH_DAI_DIEN").val(null);
		$("#TYPE").val("0");
		$("#TYPE_IMG").val("avatar.png");
		changPic();

		$('#errorEmail').hide();
		$('#errorID').hide();
		$('#errorNAME').hide();
	});

	$(document).on('click', '#btn-delete', function(){	
		$("#MA_CAN_BO_DELETE").val($(this).val());		 	
		$("#modal-delete").modal("show");
		$("#modal-delete .modal-title").text("Xóa cán bộ");
	});

	$(document).ready(function() {
		$("#InsertUpdate").validate({ 
			rules: {
				HO: 			{ required: true, },
				EMAIL: 			{ required: true, email: true },            
                TEN:             { required: true, },       
                DIA_CHI:         { required: true, },
                SO_DIEN_THOAI:  	{ required: true, number: true, maxlength: 10, minlength: 10},
                NGAY_SINH:      	{ required: true, },
			}, 
			messages: {
				HO: 			{ required: "Vui lòng nhập họ.", },
				TEN: 			{ required: "Vui lòng nhập tên.", },
				EMAIL: 			{ required: 'Vui lòng nhập email.', email: "Email không đúng định dạng." },
				DIA_CHI: 		{ required: "Vui lòng nhập địa chỉ.", },
				SO_DIEN_THOAI: 	{ required: "Vui lòng nhập số điện thoại.", 
									number: "Điện thoại phải là số",
									maxlength: "Số điện thoại phải đủ 10 số",
									minlength: "Số điện thoại phải đủ 10 số",
								},
				NGAY_SINH: 		{ required: "Vui lòng nhập ngày sinh.", },
			},
			submitHandler: function(form) {
				var TYPE = $('#TYPE').val();
				var _URL = (TYPE == 0) ? "{{asset('')}}"+"can-bo/them" : "{{asset('')}}"+"can-bo/sua/" + TYPE;
				
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
							(data.message.EMAIL != undefined) ? $('#errorEmail').text(data.message.EMAIL[0]).show() : $('#errorEmail').hide();

							(data.message.MA_CAN_BO != undefined) ? $('#errorID').text(data.message.MA_CAN_BO[0]).show() : $('#errorID').hide();

							(data.message.SO_DIEN_THOAI != undefined) ? $('#errorPhone').text(data.message.SO_DIEN_THOAI[0]).show() : $('#errorPhone').hide();
						}else{
							if(data.message == true){
								$('#example2').DataTable().ajax.reload();
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.info("Thêm cán bộ mới thành công!");
								else toastr.info("cập nhật cán bộ thành công!");
							}else{
								$("#modal-default").modal("hide");
								if(TYPE == 0) toastr.error("Thêm cán bộ mới không thành công!");
								else toastr.error("cập nhật cán bộ không thành công!");
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
					url: "{{route('XOA_CAN_BO')}}", 
					data: {
						'MA_CAN_BO_DELETE' : $('#MA_CAN_BO_DELETE').val(),	
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
								toastr.info("Xóa cán bộ thành công!");
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