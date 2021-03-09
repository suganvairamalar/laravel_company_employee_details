$(document).ready(function(){

  $( "#start_cloes").click(function() { //it will use to clear the form data while clicking close button
    location.reload(true);
   });

  $( "#cloes").click(function() { //it will use to clear the form data while clicking close button
    location.reload(true);
   });

   $('#company_search_submit').on('click',function(){
            var _token = $('#token').val();
            $value = $('#search').val();
            $.ajax({
               type:'GET',
               url:'/companies',
               data:{'search':$value,_token:_token},
               success: function(data){
                console.log(data);
               }
            });
   });

   $('#company_create_record').click(function(){
  	//alert('hi');
  	$('.modal-title').text('ADD NEW RECORD');
  	$('#company_action_button').val('ADD');
  	$('#company_action').val('ADD');
  	$('#company_form_Modal').modal('show');

  });

   $('#company_form').on('click','#company_action_button',function(e){
   	   e.preventDefault();
   	   
   	   if($('#company_action').val()=='ADD'){
 //alert("HIIII");
   	   		$.ajax({
   	   			url:'/company_add',
   	   			method:'POST',
   	   			//data:$('#company_form').serialize(),

             data:new FormData($('#company_form')[0]),
             contentType: false,
             cache: false,
             processData: false,
   	   			 dataType:"json",
             beforeSend:function(){
             $('.spinner_loader').show();
             $('#company_action_button').attr('disabled',true);
             },
   	   			success:function(data)
              {
               var html = '';
                  if(data.errors){
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++){
                      html += '<p>' + data.errors[count] + '</p>';
                      }
                      html += '</div>';

                      $('#company_action_button').attr('disabled',false);
                    }
                    if(data.success){
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#company_form')[0].reset();

                    location.reload();
                    /*setTimeout(function(){
               $('.spinner_loader').hide();
                location.reload();
              }, 2000);*/
                  }
                   $('.spinner_loader').hide();
                  $('#company_form_result').html(html);
              }
   	   		});
   	   }

   	   if($('#company_action').val()=='EDIT'){
          //alert("edit");
          //return;
          $.ajax({
          	url:'/company_update',
   	   			method:'POST',
   	   			//data:$('#company_form').serialize(),
            data:new FormData($('#company_form')[0]),
             contentType: false,
             cache: false,
             processData: false,
            
   	   			dataType:"json",
             beforeSend:function(){
            $('.spinner_loader').show();
            $('#company_action_button').attr('disabled',true);
            },
           success:function(data)
              {
               var html = '';
                  if(data.errors){
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++){
                      html += '<p>' + data.errors[count] + '</p>';
                      }
                      html += '</div>';
                      $('#company_action_button').attr('disabled',false);
                    }
                    if(data.success){
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#company_form')[0].reset();
                    $('#store_logo').html('');
                    location.reload();
                  }
                   $('.spinner_loader').hide();

                  $('#company_form_result').html(html);
              }

      });

        }

   });
   
   $(document).on('click', '.edit', function(){ 
    	/*alert('edit');
   		return;*/
   		var id = $(this).attr('id');
   		$('#company_form_result').html('');
   		$.ajax({
   			url:'/company_edit/'+id,
   			dataType:"json",
   			success:function(html){
   				$('#name').val(html.data.name);
          $('#email').val(html.data.email);
          $('#website').val(html.data.website);
          var image_path  = "http://localhost:8000/storage";
         /* alert(image_path);
          return;*/
          $('#store_logo').html("<img src="+image_path+'/'+html.data.logo+" width='60' height='40' class='img-thumbnail' />");
          //return;
          $('#store_logo').append("<input type='hidden' name='hidden_image' value='"+html.data.logo+"' />");

   				$('#hidden_id').val(html.data.id);
   				$('.modal-title').text("EDIT THE RECORD");
			    $(".modal-body").removeClass('bg-primary').addClass('bg-success');
			    $(".modal-header").removeClass('bg-danger').addClass('bg-primary');
			    $(".modal-footer").removeClass('bg-danger').addClass('bg-primary');
			    $('#company_action_button').val("EDIT");
			    $('#company_action').val("EDIT");
			    $('#company_action_button').removeClass('btn btn-primary').addClass('btn btn-warning');
			    $('#cloes').removeClass('btn btn-secondary').addClass('btn btn-success');
			    $('#company_form_Modal').modal('show');
   			}
   		});
   });


  var company_id;
  $(document).on('click', '.delete', function(){
      company_id = $(this).attr('id');
      $('#company_confirm_Modal').modal('show');      
  });

  $('#company_ok_button').click(function(){
        $.ajax({
          url:'/company_delete/'+company_id,
          beforeSend:function(){
            $('#company_ok_button').text('Deleting.....');
            },
            success:function(data){
              setTimeout(function(){
                $('company_confirm_Modal').modal('hide');
                location.reload();
              }, 2000);
            }
        });
  });


   //SEARCH DROPDOWN
  $(document).on("change",'#search_dropdown',function(){
    var select_value = $('#search_dropdown option:selected').val();
      //alert(select_value);
      if(select_value=='name'){
        $('#search').attr('placeholder','Search By Name');
      }
      else if(select_value=='email'){
        $('#search').attr('placeholder','Search By Email');
      }
      else if(select_value=='website'){
        $('#search').attr('placeholder','Search By Website');
      }
      else{
        $('#search').attr('placeholder','');
      }
  });

  

   $('#company_search_submit').on('click',function(){

            var _token = $('#token').val();
            $value = $('#search').val();
            $search_dropdown = $('#search_dropdown option:selected').val();
            /*alert($search_dropdown);
            return;*/
            if($search_dropdown == "")
            {
            $('#search_dropdown').focus();
            alert("Please select");
            return false;
            }

            if(($search_dropdown!='') && ($value=='')){
              $('#search').focus();
              alert("Please enter to search");
              return false;
            }
           
            
            $.ajax({
               type:'GET',
               url:'/companies',
               data:{'search_dropdown':$search_dropdown,'search':$value,_token:_token},
               success: function(data){
                console.log(data);
               }
            });
   });



	
});