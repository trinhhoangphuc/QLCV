<script type="text/javascript" charset="utf-8" async defer>
	
	

	$(document).on('click', '#btn-update-info', function(){		
		$("#modal-default").modal("show");
		$("#modal-default .modal-title").text("Cập nhật thông tin");
		$("#ANH_DAI_DIEN").val(null);
		var output = document.getElementById('output');
        output.src ="{{asset('images/avatar/'.$CAN_BO->anhdaidien)}}";
        $('#errorEmail').hide();
		$('#errorPhone').hide();
	});

	$(document).on('click', '#btn-update-pass', function(){		
		$("#modal-repass").modal("show");
		$("#modal-repass .modal-title").text("Đổi mật khẩu");
	});

	$(document).ready(function() {
		$("#InsertUpdate").validate({  // update info
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
				var _URL = "{{asset('')}}"+"thong-tin/cap-nhat";
				
				$.ajax({
					url: _URL,
					method: "POST",
					data:new FormData(form),
					dataType: 'JSON',
					contentType: false,
					cache: false,
					processData: false,
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(data)
					{
						if(data.error){
							$('#errorUpdate').hide();
							(data.message.EMAIL != undefined) ? $('#errorEmail').text(data.message.EMAIL[0]).show() : $('#errorEmail').hide();
							(data.message.SO_DIEN_THOAI != undefined) ? $('#errorPhone').text(data.message.SO_DIEN_THOAI[0]).show() : $('#errorPhone').hide();
						}else{
							$('#errorEmail').hide();
							$('#errorPhone').hide();
							if(data.check){
								$('#errorUpdate').text("Bạn chưa thay đổi thông tin").show();
							}else{
								$('#errorUpdate').hide();
								if(data.message)
									location.reload();
								else
									$('#errorUpdate').text("Không thể cập nhật").show();
							}
						}	
					},
					error: function(data){
						console.log(data);
					}

				});
			}
		});


		$("#InsertUpdate_PASS").validate({  // update info
			rules: {
				MAT_KHAU_CU: 	{ required: true, },
				MAT_KHAU_MOI: 	{ required: true, },            
                NHAP_LAI:       { equalTo: '#MAT_KHAU_MOI', },       
			}, 
			messages: {
				MAT_KHAU_CU:  { required: "Vui lòng nhập mật khẩu củ.", },
				MAT_KHAU_MOI: { required: "Vui lòng nhập mật khẩu mới.", },
				NHAP_LAI: 	  { equalTo: "Không trùng khớp với mật khẩu mới" },
			},
			submitHandler: function(form) {
				var _URL = "{{asset('')}}"+"thong-tin/cap-nhat-mat-khau";
				
				$.ajax({
					url: _URL,
					method: "POST",
					data:new FormData(form),
					dataType: 'JSON',
					contentType: false,
					cache: false,
					processData: false,
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function(data)
					{
						if(data.error){
							$('#errorOldPass').text("Mật khẩu không chính xác!").show();
						}else{
							if(data.message)
								location.reload();
							else
								$('#errorUpdatePas').text("Không thể cập nhật").show();
						}	
					},
					error: function(data){
						console.log(data);
					}

				});
			}
		});

	})	


	
</script>