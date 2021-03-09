$(document).ready(function(){
   $( "#start_cloes").click(function() { //it will use to clear the form data while clicking close button
    location.reload(true);
   });

  $( "#cloes").click(function() { //it will use to clear the form data while clicking close button
    location.reload(true);
   });

  $('#employee_search_submit').on('click',function(){

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
               url:'/employees',
               data:{'search_dropdown':$search_dropdown,'search':$value,_token:_token},
               success: function(data){
                console.log(data);
               }
            });
   });


  $(document).on("change",'#search_dropdown',function(){
    var select_value = $('#search_dropdown option:selected').val();
      //alert(select_value);
      if(select_value=='first_name'){
        $('#search').attr('placeholder','Search By First Name');
      }
      else if(select_value=='last_name'){
        $('#search').attr('placeholder','Search By Last Name');
      }     
      else if(select_value=='company'){
        $('#search').attr('placeholder','Search By Company');
      }
      else if(select_value=='email'){
        $('#search').attr('placeholder','Search By Email');
      }
      else if(select_value=='phone'){
        $('#search').attr('placeholder','Search By Phone');
      }
      else{
        $('#search').attr('placeholder','');
      }
  });  

    $('#company_id').select2();    

    $('#employee_create_record').click(function(){
  	//alert('hi');
  	$('.modal-title').text('ADD NEW RECORD');
  	$('#employee_action_button').val('ADD');
  	$('#employee_action').val('ADD');
  	$('#employee_form_Modal').modal('show');

  });



  $('#employee_form').on('click','#employee_action_button',function(e){
  		e.preventDefault();
  		if($('#employee_action').val()=='ADD'){
  				/*alert('hi');
  				return;*/
  				$.ajax({
  					url:'/employee_add',
  					type:'POST',
  					data:$('#employee_form').serialize(),
  					dataType:"json",
             beforeSend:function(){
             $('.spinner_loader').show();
             $('#employee_action_button').attr('disabled',true);
             },
  					success:function(data){
  						var html = '';
  						  if(data.errors){
  						  	html = '<div class="alert alert-danger">';
  						  	for(var count = 0; count < data.errors.length; count++){
  						  		html += '<p>' + data.errors[count] + '</p>';
  						  	}
  						  		html += '</div>';
  						  }
  						  if(data.success){
  						  	html = '<div class="alert alert-success">' + data.success + '</div>';
  						  	$('#employee_form')[0].reset();
  						  	location.reload();
  						  }
                  $('.spinner_loader').hide();
  						  	$('#employee_form_result').html(html);
  					}
  				});
  		}
  		if($('#employee_action').val()=='EDIT'){
  				/*alert('hi');
  				return;*/
  				$.ajax({
  					url:'/employee_update',
  					type:'POST',
  					data:$('#employee_form').serialize(),
  					dataType:"json",
             beforeSend:function(){
            $('.spinner_loader').show();
            $('#employee_action_button').attr('disabled',true);
            },
  					success:function(data){
  						var html = '';
  						  if(data.errors){
  						  	html = '<div class="alert alert-danger">';
  						  	for(var count = 0; count < data.errors.length; count++){
  						  		html += '<p>' + data.errors[count] + '</p>';
  						  	}
  						  		html += '</div>';
  						  }
  						  if(data.success){
  						  	html = '<div class="alert alert-warning">' + data.success + '</div>';
  						  	$('#employee_form')[0].reset();
  						  	location.reload();
  						  }
                  $('.spinner_loader').hide();
  						  	$('#employee_form_result').html(html);
  					}
  				});
  		}
  		
  });    

      
  	$(document).on('click', '.edit', function(){
  		var id = $(this).attr('id');
  			//alert('edit');
  			//return;
  			$('#employee_form_result').html('');
  			$.ajax({
  				url:'/employee_edit/'+id,
  				dataType:"json",
  				success:function(html){
  				$('#first_name').val(html.data.first_name);
  				$('#last_name').val(html.data.last_name);
  				$('#email').val(html.data.email);
          $('#phone').val(html.data.phone);        
       
          $("#company_id").select2().select2('val',html.data.company_id);
                   
          $('#company_id').append("<input type='hidden' name='hidden_company_id' value='"+html.data.company_id+"' />");
          

   				$('#hidden_id').val(html.data.id);
   				
          $('#hidden_company_id').val(html.data.company_id);
          	
   				$('.modal-title').text("EDIT THE RECORD");
			    $(".modal-body").removeClass('bg-primary').addClass('bg-success');
			    $(".modal-header").removeClass('bg-danger').addClass('bg-primary');
			    $(".modal-footer").removeClass('bg-danger').addClass('bg-primary');
			    $('#employee_action_button').val("EDIT");
			    $('#employee_action').val("EDIT");
			    $('#employee_action_button').removeClass('btn btn-primary').addClass('btn btn-warning');
			    $('#cloes').removeClass('btn btn-secondary').addClass('btn btn-success');
			    $('#employee_form_Modal').modal('show');
  				}
  			});

  	});

   var employee_id;
   $(document).on('click','.delete',function(){
   		employee_id = $(this).attr('id');
   		$('#employee_confirm_Modal').modal('show');
   });
   $('#employee_ok_button').click(function(){
   		$.ajax({
   			url:'/employee_delete/'+employee_id,
   			beforeSend:function(){
   				$('#employee_ok_button').text('Deleting...');
   			},
   			success:function(data){
   				setTimeout(function(){
   					$('employee_confirm_Modal').modal('hide');
   					location.reload();
   				}, 2000);
   			}
   		});
   });

   


});