


	function register(){

			var email = encodeURIComponent($('#email').val());
			var story_id = $('#story_id').val();
			var url = '/?aj=register&email=' + email + '&story_id=' + story_id;

			$.getJSON(url, function(result){

				if(result.status==1){

					// Good

					if(result.landing_page!=""){

						location.href = result.landing_page;

					}else{

						$('#ss_login_message').html(result.message);
						$('#login-form').find('.btn, .input_hold').slideUp();

					}


				}else if(result.status==0){

					$('#email').addClass('ss_bad_input');
					$('#ss_login_message').html(result.message);

				}else if(result.status==-1){

					//$('#email').addClass('ss_bad_input');
					$('#ss_login_message').html(result.message);
				}

			});

		}

	function complete_reg(){

			var username = $('#username').val();
			var com1 = $('#com1').val();
			var com2 = $('#com2').val();
			var pwd = $('#pwd').val();
			var pwd_verify = $('#pwd_verify').val();
			var story_id = $('#story_id').val();

			if(pwd == pwd_verify){

				var pwd_enc = encodeURIComponent(pwd);
				var username_enc = encodeURIComponent(username);

				var url = '/?aj=complete&username=' + username_enc + '&com0=' + pwd_enc + '&com1=' + com1 + '&com2=' + com2 + '&story_id=' + story_id;

				$.getJSON(url, function(result){

					if(result.status==1){

						// Good
						location.href = result.landing_page;

					}else if(result.status==0){

						$('#ss_login_message').html(result.message);

					}else if(result.status==-1){

						$('#username').addClass('ss_bad_input');
						$('#ss_login_message').html(result.message);

					}

				});


			}else{

				$('#pwd_verify').addClass('ss_bad_input');

				$('#ss_login_message').html("<div class='notification-box notification-box-error'><p><i class='icon-remove-sign'></i>Passwords do not match</p></div>");

			}

		}

	function pwd_reset_verify(){

			//var username = $('#username').val();
			var com1 = $('#com1').val();
			var com2 = $('#com2').val();
			var pwd = $('#pwd').val();
			var pwd_verify = $('#pwd_verify').val();
			var story_id = $('#story_id').val();

			if(pwd == pwd_verify){

				var pwd_enc = encodeURIComponent(pwd);
				//var username_enc = encodeURIComponent(username);

				var url = '/?aj=pwd_reset_verify&com0=' + pwd_enc + '&com1=' + com1 + '&com2=' + com2 + '&story_id=' + story_id;

				$.getJSON(url, function(result){

					if(result.status==1){

						// Good
						location.href = result.landing_page;

					}else if(result.status==0){

						$('#ss_login_message').html(result.message);

					}else if(result.status==-1){

						//$('#username').addClass('ss_bad_input');
						$('#ss_login_message').html(result.message);

					}

				});


			}else{

				$('#pwd_verify').addClass('ss_bad_input');
				$('#ss_login_message').html("<div class='notification-box notification-box-error'><p><i class='icon-remove-sign'></i>Passwords do not match</p></div>");

			}

		}

	function pwd_request(){

			var username = encodeURIComponent($('#email').val());

			var url = '/?aj=pwd_reset_req&username=' + username; // + '&story_id=' + story_id;


			$.getJSON(url, function(result){



				$('#ss_login_message').html(result.message);
				if(result.status==1){
					$('#email').parents('.input_hold').hide();
					$('#pwd').parents('.input_hold').hide();
					$('.btn').parents('.input_hold').hide();
				}

			});


		}

	function login(){

console.log("aasds");

			if($('#pwd').parents('.input_hold:visible').length==0){

				$('#pwd').parents('.input_hold').slideDown(400);

			}else{

				var username = $('#email').val();
				var pwd = $('#pwd').val();
				var pwd_enc = encodeURIComponent(pwd);
				var story_id = $('#story_id').val();

				var url = '?aj=login&username=' + username + '&com0=' + pwd_enc + '&story_id=' + story_id;

				$.getJSON(url, function(result){

					if(result.status==1){

						// Good
						location.href = result.landing_page;

					}else if(result.status==0){

						$('#email').addClass('ss_bad_input');
						$('#pwd').addClass('ss_bad_input');
						$('#ss_login_message').html(result.message);

					}

				})


$.getJSON(url, function(result) {
 console.log(JSON.stringify(result));
})

.done(function() { console.log('getJSON request succeeded!'); })
.fail(function(jqXHR, textStatus, errorThrown) { console.log('getJSON request failed! ' + jqXHR + textStatus + errorThrown); })
.always(function() { console.log('getJSON request ended!'); });








			}

		}
