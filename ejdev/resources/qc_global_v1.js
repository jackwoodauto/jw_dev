"use strict";

$(".preloader").hide();
$(".upload-files-qc").hide();
$(".upload_area").hide();

$("#upload-files-qc").click(function(){
    $(".preloader").show();
    $(".upload-files-qc").hide();
  });


  $("#upload_button").hide();

  $("#new_job_button").click(function(){
      $("#upload_button").show();
      $("#new_job_button").hide();
      $("#edit_job_button").hide();
    });

  $("#edit_job_button").click(function(){
      $("#upload_button").show();
      $("#new_job_button").hide();
      $("#edit_job_button").hide();
    });






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

	$(".file-input-qc").change(function() {

		var fileName_1 = $("#input-invoice").val()!="";
		var fileName_2 = $("#input-quote").val()!="";


		if((fileName_1 == true) && (fileName_2 == true)){
			$("#actionrun").show();
			$(".upload-files-qc").show();
      $(".upload_area").show();
			$(".file-select-submit").show();
		} else {
		   console.log("all files are not selected");
		}
	});
});

$(".upload_area").hide();
$(".upload-files-qc").hide();
$(".file-select-submit").hide();

// quotecheck uploader
