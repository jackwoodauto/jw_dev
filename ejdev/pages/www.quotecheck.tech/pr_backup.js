



$(document).ready(function(){
alert("abc");
    $(function() {
        $( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
        $( ".tab-linker" ).click(function() {
            $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
            return false;
        });
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#submitNewJob").click(function(){
        var jq_newjobname = $('#new_job_name');
        var new_job_name = jq_newjobname.val();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'new_job_name1=' + new_job_name;
        if (new_job_name == '') {
            alert("Please provide a job name");
        } else {
            // AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "new_job_name",
                data: dataString,
                cache: false,
                success: function(html) {
                    //add the new job to the dropdown list:
                    var incoming_data = JSON.parse(html);
                    var ob = $("#job_selected");
                    ob.prepend("<option value='" + incoming_data.NewJobID + "'>" + incoming_data.ReturnJob + "</option>");

                    //select the newly created new_job_name
                    ob.val(incoming_data.NewJobID);
                    jq_newjobname.val(''); //blank out the new job name box
                }
            });
            $("#job_selected").trigger("change");
        }
        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //update the job info  shown in the page
    function JobSelected() {

        var dropdown = $('#job_selected');
        var selected_job_id = dropdown.val();

        $.ajax({
            type:"POST",
            url: "select_job",
            data: { 'jobid': selected_job_id },
            success: function(newdata) {
                var resulttext = JSON.stringify(newdata);
                var posErr = resulttext.indexOf("ErrorStatus");
                if (posErr == -1){
                    alert ("error reading data" + newdata);
                    returnedHTML = "<p>Error reading database.</p>";
                }
                var return_data = JSON.parse(newdata);
                var job_status_area = $('#job_status_area');
                var returnedHTML = return_data['html'];

                job_status_area.html(returnedHTML).fadeIn(1500);

                //ensure preview buttons are hooked up
                $(".previewbutton").on('click', function() {
                    $('#imgSrc').attr('src', $(this).data('src'));
                    $('#modalFileTitle').html($(this).data('src'));
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {

                alert(xhr.status);
                alert(thrownError);

                var returnedHTML = "<div><p>No Files Uploaded</p></div>";
                job_status_area.html(returnedHTML).fadeIn(1500);
            }
        });

    }; //job_selected function

    $("#job_selected").change(function(){
        JobSelected();
    });




    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $("#submitNewWholesaler").click(function(){
        var jq_newwholesalername = $('#new_wholesaler_name');
        var new_wholesaler_name = jq_newwholesalername.val();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'new_wholesaler_name1=' + new_wholesaler_name;
        if (new_wholesaler_name == '') {
            alert("Please provide a wholesaler name");
        } else {
            // AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "new_wholesaler_name",
                data: dataString,
                cache: false,
                success: function(html) {
                    //add the new wholesaler to the dropdown list:
                    var incoming_data = JSON.parse(html);
                    var ob = $("#wholesaler_selected");
                    ob.prepend("<option value='" + incoming_data.NewWholesalerID + "'>" + incoming_data.ReturnWholesaler + "</option>");
                    var ob_uq = $("#wholesaler_selected_uq");
                    ob_uq.prepend("<option value='" + incoming_data.NewWholesalerID + "'>" + incoming_data.ReturnWholesaler + "</option>");
                    //select the newly created new_wholesaler_name
                    ob.val(incoming_data.NewWholesalerID);

                    jq_newwholesalername.val(''); //blank out the new wholesaler name box
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
                async: false
            });

            WholesalerSelected();
        }
        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function WholesalerSelected(object_id) {
        //update the wholesaler info shown in the page
        var selected_wholesaler_id = object_id;
        $.ajax({
            type: "POST",
            url: "select_wholesaler",
            data: { 'wholesalerid': object_id },
            success: function(newdata) {
                var return_data = JSON.parse(newdata);
                var wholesaler_status_area = $('#wholesaler_status_area');
                var doc_select = $('#doc_select');
                var returnedHTML = return_data['html'];
                //var returnedHTML2 = return_data['html2'];

                wholesaler_status_area.html(returnedHTML).fadeIn(1500);
                //doc_select.html(returnedHTML2).fadeIn(1500);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            async: false
        });
        DocSelected();

    }; //wholesaler_selected function

    $("#wholesaler_selected").change(function(){
        WholesalerSelected("#wholesaler_selected");
    });
    $("#wholesaler_selected_uq").change(function(){
        WholesalerSelected("#wholesaler_selected_uq");
    });

    function WholesalerSelected_uq() {
        //update the wholesaler info shown in the page
        var dropdown = $('#wholesaler_selected_uq');
        var selected_wholesaler_id_uq = dropdown.val();

        $.ajax({
            type: "POST",
            url: "select_wholesaler",
            data: { 'wholesalerid': selected_wholesaler_id_uq },
            success: function(newdata) {
                var return_data = JSON.parse(newdata);
                var wholesaler_status_area = $('#wholesaler_status_area');
                var doc_select_uq = $('#doc_select_uq');
                var returnedHTML = return_data['html'];
                //var returnedHTML2 = return_data['html2'];

                wholesaler_status_area.html(returnedHTML).fadeIn(1500);
              //  doc_select_uq.html(returnedHTML2).fadeIn(1500);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
            async: false
        });
        DocSelected_uq();

    }; //wholesaler_selected function

    $("#wholesaler_selected_uq").change(function(){
        WholesalerSelected_uq();

    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $("#submitNewDocument").click(function(){
        var jq_newdocumentname = $('#new_document_name');
        var new_document_name = jq_newdocumentname.val();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = new_document_name;
        var selected_wholesaler_id = $('#wholesaler_selected').val();
        var info = [selected_wholesaler_id,dataString] ;


        if (new_document_name == '') {
            alert("Please provide a document name");
        } else {
            // AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "new_document_name",
                data: {info,info},
                cache: false,
                success: function(html) {
                    //add the new wholesaler to the dropdown list:
                    var incoming_data = JSON.parse(html);
                    var ob = $("#doc_select");
                    ob.prepend("<option value='" + incoming_data.NewDocumentID + "'>" + incoming_data.ReturnDocument + "</option>");
                    var wholesaler_selected_doc_update_check_uq = $("#wholesaler_selected_uq").val();
                    if (selected_wholesaler_id == wholesaler_selected_doc_update_check_uq) {
                      var ob_uq = $("#doc_select_uq");
                      ob_uq.prepend("<option value='" + incoming_data.NewDocumentID + "'>" + incoming_data.ReturnDocument + "</option>");
                    }
                  //  var ob_uq = $("#doc_select_uq");
                  //  ob_uq.prepend("<option value='" + incoming_data.NewDocumentID + "'>" + incoming_data.ReturnDocument + "</option>");

                    //select the newly created new_wholesaler_name
                    ob.val(incoming_data.NewDocumentID);

                    jq_newdocumentname.val(''); //blank out the new wholesaler name box
                }

            });
            $( "#doc_select" ).trigger("change");
            $( "#doc_select_uq" ).trigger("change");
        }
        return false;
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function DocSelected() {
        //show the layout of the selected document
        var dropdown = $('#doc_select');
        var selected_doc_id = dropdown.val();

        $.ajax({
            type:"POST",
            url: "select_document",
            data: { 'docid': selected_doc_id },
            success: function(newdata) {
                var return_data = JSON.parse(newdata);
                var document_visual_layout_section = $('#document_visual_layout_section');
                var returnedHTML = return_data['html3'];
                document_visual_layout_section.html(returnedHTML).fadeIn(1500);

                // JACK - do we need these variables:
                // var return_data = JSON.parse(newdata);
                // var wholesaler_status_area = $('#wholesaler_status_area');
                // var doc_select = $('#doc_select');
                // var returnedHTML = return_data['html'];
                // var returnedHTML2 = return_data['html2'];
            },
            //JACK - add an error function in here... what if there is an error? what should the user see?
        });
    };
    $("#doc_select").change(function(){
        DocSelected();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#submitNewColumn").click(function(){

        var jq_newcolumnname = $('#new_column_name');
        var new_column_name = jq_newcolumnname.val();
        // Returns successful data submission message when the entered information is stored in database.
        var dataString = new_column_name;
        var dropdown = $('#doc_select');
        var selected_wholesaler_id = dropdown.val();
        var info = [selected_wholesaler_id,dataString ];
        //var info[0] = dropdown;
        //  var info[1] = selected_wholesaler_id;

        if (new_column_name == '') {
            alert("Please provide a Column name");
        } else {
            // AJAX code to submit form.
            $.ajax({
                type: "POST",
                url: "new_column_name",
                data: {info,info},
                cache: false,
                success: function(html) {
                    //add the new job to the dropdown list:
                    //  jq_newcolumnname.val(''); //blank out the new job name box

                }
            });
        }
        DocSelected()
        return false;
    });

    JobSelected(); //when a job is in the selected box use ajax to run a php file that uses sql to get the infomation out of the database

    WholesalerSelected(); //when a Wholesaler is in the selected box use ajax to run a php file that uses sql to get the infomation out of the database

});
