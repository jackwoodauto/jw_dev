"use strict";
		

$(document).ready(function(e) {
    

	
	// Input placeholders for windows browsers and firefox	
	if(navigator.appVersion.match(/MSIE [\d.]+/) || navigator.appVersion.toLowerCase().indexOf('edge') > -1){
		
		$(document).find("input[placeholder]").each(function(){
			if($.trim($(this).val()) == ""){
				$(this).val($(this).attr("placeholder")).addClass('placeholder');
			}
			$(this).on("focus",function(){
				$(this).hasClass('placeholder') ? $(this).val('').removeClass('placeholder') : false;
			}).on("blur",function(){
				$(this).val() == '' ? $(this).val($(this).attr("placeholder")).addClass('placeholder') :false;          
			});
		});     
	}
	
	
	$(".dynamic_textarea" ).each( function( index, element ){

		$(this).height(0).height(this.scrollHeight);

	});
	
	
	
	
});

	$(window).resize(function(e) {
		df_grid_image_dynamic();
	});
		
	function df_grid_image_dynamic(){

		var w = $(".df_grid_image_dynamic").width();
		var h = 0.7264 * w;
		$(".df_grid_image_dynamic").height(h);

	}
	
	function reveal_edit(){
		
		
		$('.df-hide-on-edit').fadeOut(100);
		$('.df-editable').slideDown(500,function(){
			
			$(this).find('.dynamic_textarea').each( function( index, element ){
				var scroll_to_height = this.scrollHeight + 20;
				$(this).animate({height: scroll_to_height},500);
				
			});
			
		});
		
		
		
		
	}


	function df_reaction_v2(page_url, obj, c, r){
				
		var type = $(obj).attr("data-react-type");
		var parent = $(obj).parent();
		var url = page_url + '?aj=react&t=' + type + '&c=' + c + '&r=' + r;

		$.getJSON(url, function(result){

			if(result.status==1){

				$(parent).children('.growl').html(result.dislikes);
				$(parent).children('.wag').html(result.likes);

			}else{

				if(result.redirect!=""){

					location.href = result.redirect;

				}
			}
		});
	}


	
	
	function register(){
			
			var email = encodeURIComponent($('#email').val());
			var story_id = $('#story_id').val();
			var url = '/login/?aj=register&email=' + email + '&story_id=' + story_id;
			
			$.getJSON(url, function(result){

				if(result.status==1){
					
					// Good
					
					if(result.landing_page!=""){
						
						location.href = result.landing_page;
						
					}else{
						
						$('#ss_login_message').html(result.message);
						$('.ss_login_form').find('.btn, .input_hold').hide();
						
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
				
				var url = '/login/?aj=complete&username=' + username_enc + '&com0=' + pwd_enc + '&com1=' + com1 + '&com2=' + com2 + '&story_id=' + story_id;
				
				
				
				
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
				$('#ss_login_message').html("<div class='alert alert-danger'><i class='icon-remove-sign'></i>Passwords do not match</div>");
				
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
				
				var url = '/login/?aj=pwd_reset_verify&com0=' + pwd_enc + '&com1=' + com1 + '&com2=' + com2 + '&story_id=' + story_id;
				
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
				$('#ss_login_message').html("<div class='alert alert-danger'><i class='icon-remove-sign'></i>Passwords do not match</div>");
				
			}

		}
	
	function pwd_request(){
			
		
			var username = encodeURIComponent($('#email').val());

			var story_id = $('#story_id').val();


			var url = '/login/?aj=pwd_reset_req&username=' + username + '&story_id=' + story_id;
			

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
			
			
		
			if($('#pwd').parents('.input_hold:visible').length==0){
				
				$('#pwd').parents('.input_hold').slideDown(400);
				
			}else{
		
				var username = $('#email').val();
				var pwd = $('#pwd').val();
				var pwd_enc = encodeURIComponent(pwd);
				var story_id = $('#story_id').val();

				var url = '/login/?aj=login&username=' + username + '&com0=' + pwd_enc + '&story_id=' + story_id;
				
				$.getJSON(url, function(result){

					if(result.status==1){

						// Good
						location.href = result.landing_page;

					}else if(result.status==0){
						
						$('#email').addClass('ss_bad_input');
						$('#pwd').addClass('ss_bad_input');
						$('#ss_login_message').html(result.message);	 

					}

				});
				
				
			}
				
			

		}

	
	
	
