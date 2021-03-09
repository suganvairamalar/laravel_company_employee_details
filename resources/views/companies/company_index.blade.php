@extends('layouts.company_app')
@section('content')
<div>
   <div class="row">
      <div class="pull-left">
         <button type="button" name="company_create_record" id="company_create_record" class="btn btn-success btn-sm">COMPANY ADD</button>
      </div>
      <div class="pull-right">
         <div class="form-group form-inline">
            <form id="company_search_form" action="/companies">
               <table class="table table-bordered">
               <tr>
                      <td class="col-md-3 col-lg-3 col-xs-3 col-sm-3" ><select class="form-control" name="search_dropdown" id="search_dropdown">
                          <option value="">Select Search</option>
                          <option value="name">NAME</option>
                          <option value="email">EMAIL</option>
                          <option value="website">WEBSITE</option>                         
                        </select></td>
                           <td class="col-md-6 col-lg-6 col-xs-6 col-sm-6" >
                           {{ csrf_field() }}
                           {{ method_field('GET') }}
                           <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                           <input type="text" class="form-control" name="search" id="search">
                     </td>
                     <td class="col-lg-3 col-xs-3 col-sm-3 col-md-3">
                     <button type="submit" class="btn btn-warning" id="company_search_submit" name="company_search_submit">
                     <span class="glyphicon glyphicon-search"></span></button> 
                     <a href="{{route('company.index')}}" class="btn btn-primary"><span class="reloadbtn glyphicon glyphicon-refresh"></span></a>                     
                     </td>                     
                  </tr> 
                  </table>              
            </form>
         </div>
      </div>
   </div>
   <div class="row">
      @include('companies.company_list')   
   </div>
</div>
<div class="row">
   <div id="company_form_Modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-danger">
               <label class="modal-title">COMPANY ADD FORM</label>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="start_cloes"><span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="post" id="company_form" class="form-horizontal" enctype="multipart/form-data">
               <div class="modal-body bg-primary">
                  <span id="company_form_result"></span>
                  {{ csrf_field() }}
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                  <div class="form-group">
                     <label class="control-label1 col-md-4 col-lg-4 col-xs-4 col-sm-4">NAME</label>
                     <div class="col-md-8 col-lg-8 col-xs-8 col-sm-8">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter a Company Name">
                     </div>
                  </div>                  
                  <div class="form-group">
                     <label class="control-label1 col-md-4 col-lg-4 col-xs-4 col-sm-4">EMAIL</label>
                     <div class="col-md-8 col-lg-8 col-xs-8 col-sm-8">
                        <input type="text" class="form-control" name="email" id="email" placeholder="test@test.com">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label1 col-md-4 col-lg-4 col-xs-4 col-sm-4">COMPANY LOGO</label>
                     <div class="col-md-8 col-lg-8 col-xs-8 col-sm-8">
                        <input type="file" name="logo" id="logo" class="form-control" multiple> 
                        <span id="store_logo"></span>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label1 col-md-4 col-lg-4 col-xs-4 col-sm-4">WEBSITE</label>
                     <div class="col-md-8 col-lg-8 col-xs-8 col-sm-8">
                        <input type="text" class="form-control" name="website" id="website" placeholder="www.test.com">
                     </div>
                  </div>
               </div>
               <div class="modal-footer bg-danger">
                  <input type="hidden" name="hidden_id" id="hidden_id" class="form-control">  
                  
                  <input type="hidden" name="company_action" id="company_action" /> 
                  <div class="spinner_loader">
                  <img src="{{URL::asset('images/spinner1.gif')}}" style="width: 50px;height:50px" >  
                   </div>
                                 
                  <button type="button" class="btn btn-secondary" id="cloes" data-dismiss="modal">CLOSE</button>
                  <input type="submit" name="company_action_button" id="company_action_button" class="btn btn-primary" value="ADD">
               </div>
               
            </form>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div id="company_confirm_Modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-danger">
               <label class="modal-title">CONFIRMATION</label>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <p style="color:red;font-size:16px;font-weight: bold;font-style: italic;">Are you sure !! want to delete this record?</p>
            </div>
            <div class="modal-footer bg-danger">
               <button type="button" name="company_ok_button" id="company_ok_button" class="btn btn-danger">OK</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection