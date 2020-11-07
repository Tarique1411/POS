    $(document).on('click', '#updateOrderDiscount', function (event) {
		event.preventDefault();
		localStorage.removeItem('posdiscount');
		
		var logged_in_discount = $('#logged_in_discount').val();
		alert(logged_in_discount);
        var ds = $('#order_discount_input').val() ? $('#order_discount_input').val() : '0';
		var ds_reason = $('#discout_reason_input').val() ? $('#discout_reason_input').val() : '';
		if (is_valid_discount(ds)) {
			if(!logged_in_discount){
				$.ajax({
					url:site.base_url+'pos/getMaxOrderDiscount',
					type:"POST",
					data:{'discount':ds},
					datatype:"json",
					success:function(data){
						data = jQuery.parseJSON(data);
						//console.log(data.status);
					if(data.status == true){
							bootbox.dialog({
								title: "Authenticate for Order Discount(Entered discount is greater than max allowed discount)",
								message: '<div class="row">  ' +
									'<div class="col-md-12"> ' +
									'<form class="form-horizontal" role="form" data-toggle="validator">' +
									'<div class="form-group"> ' +
									'<label class="col-md-4 control-label" for="name">UserName</label> ' +
									'<div class="col-md-8"> ' +
									'<input id="username" name="username" type="text" placeholder="Your user name" class="form-control input-md" required="required"> ' +
									'<span class="help-block">Here goes your name</span> </div> ' +
									'</div> ' +
									'<div class="form-group"> ' +
									'<label class="col-md-4 control-label" for="psw">Password</label> ' +
									'<div class="col-md-8">' +
									'<input id="password" name="password" type="password" data-minlength="8" placeholder="Your password" class="form-control input-md" required="required">  ' +
									' <div class="help-block">Minimum of 8 characters</div>' +
									'</div> </div>' +
									'</form> </div>  </div>',
								buttons: {
								success: {
									label: "Authenticate",
									className: "btn-success",
									callback: function () {
										var user = $('#username').val();
										var pwd = $('#password').val();
										if((user == null) || (user == undefined) || (user == '')){
											bootbox.alert("username required");
											return false;
										}
										if((pwd == null) || (pwd == undefined) || (pwd == '')){
												bootbox.alert("password required");
											return false;
										}
                                
										$.ajax({
												type: "POST",
												url: site.base_url + 'pos/authenticate_discount',
												data: {"username": user, "password": pwd},
												datatype: "json",
												success: function (cdata) {											
													var data = jQuery.parseJSON(cdata);																									
													$('#status').val(data.status);
													if (data.status == 'failed') {
														bootbox.alert('You are not authorised to allow discount');
														return;
													} else {
														$('#posdiscount').val(ds);
														$('#posdiscountreason').val(ds_reason);			
														localStorage.removeItem('posdiscountreason');
														localStorage.setItem('posdiscountreason', ds_reason);			
														localStorage.removeItem('posdiscount');
														localStorage.setItem('posdiscount', ds);
														loadItems();
													}
												}
										});
                               
									}
								}
							}
						});
						
					}else{
						return;
					}
				}			
				});
			}
		}else{
			bootbox.alert(lang.unexpected_value);
		}
		
        $('#dsModal').modal('hide');
    });	
	
			