@extends('layouts.employee_app')
@section('content')
<div class="">
   <div class="row">
      <div class="pull-left">
         <button type="button" name="employee_create_record" id="employee_create_record" class="btn btn-success btn-sm">EMPLOYEE ADD</button>
      </div>
      <div class="pull-right">
         <div class="form-group form-inline">
            <form id="employee_search_form" action="/employees">
               {{ csrf_field() }}
               {{ method_field('GET') }}
               <label >SEARCH</label>
               <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
               <select class="form-control" name="search_dropdown" id="search_dropdown">
                          <option value="">Select Search</option>
                          <option value="first_name">FIRST NAME</option>
                          <option value="last_name">LAST NAME</option>
                          <option value="company">COMPANY</option>
                          <option value="email">EMAIL</option>
                          <option value="phone">PHONE</option>
                        </select>
               <input type="text" class="form-control" name="search" id="search">
               <button type="submit" class="btn btn-warning" id="employee_search_submit" name="employee_search_submit">
               <span class="glyphicon glyphicon-search"></span></button> 
               <a href="{{route('employee.index')}}" class="btn btn-primary"><span class="reloadbtn glyphicon glyphicon-refresh"></span></a>                      
            </form>
         </div>
      </div>
   </div>
   <div class="row">
      @include('employees.employee_list')
   </div>
</div>
<div class="row">
   <div id="employee_form_Modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-danger">
               <label class="modal-title">EMPLOYEE ADD FORM</label>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="start_cloes"><span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="post" id="employee_form" class="form-horizontal">
               <div class="modal-body bg-primary">
                  <span id="employee_form_result"></span>
                  {{ csrf_field() }}
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                  <div class="form-group">
                     <label class="control-label1 col-md-5 col-lg-5 col-xs-5 col-sm-5">FIRST NAME</label>
                     <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7">
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter a First Name">
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label1 col-md-5 col-lg-5 col-xs-5 col-sm-5">LAST NAME</label>
                     <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter a Last Name">
                     </div>
                  </div>               

                  <div class="form-group">
                     <label class="control-label1 col-md-5 col-lg-5 col-xs-5 col-sm-5">COMPANY</label>
                     <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7">
                        <select class="form-control company_id" name="company_id" id="company_id" style="width:100%;line-height: 65px;">
                          <option disabled="disabled" selected="true">Select Company</option>
                           @foreach($companies as $company)
                           <option value="{{$company->id}}">{{$company->name}}</option>
                           @endforeach
                        </select>    
                     </div>
                  </div>


                  <div class="form-group">
                     <label class="control-label1 col-md-5 col-lg-5 col-xs-5 col-sm-5">EMAIL</label>
                     <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter a Email">
                     </div>
                  </div> 

                     <div class="form-group">
                     <label class="control-label1 col-md-5 col-lg-5 col-xs-5 col-sm-5">PHONE</label>
                     <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter a Phone">
                     </div>
                  </div> 
               </div>
               <div class="modal-footer bg-danger">
                  
                  <input type="hidden" name="hidden_id" id="hidden_id" class="form-control"> 
                 
                  <input type="hidden" name="hidden_company_id" id="hidden_company_id" class="form-control">
                 
                  <input type="hidden" name="employee_action" id="employee_action" />
                   <div class="spinner_loader">
                  <img src="{{URL::asset('images/spinner1.gif')}}" style="width: 50px;height:50px" >  
                   </div>
                  <button type="button" class="btn btn-secondary" id="cloes" data-dismiss="modal">CLOSE</button>
                  <input type="submit" name="employee_action_button" id="employee_action_button" class="btn btn-primary" value="ADD">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div id="employee_confirm_Modal" class="modal fade" role="dialog">
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
               <button type="button" name="employee_ok_button" id="employee_ok_button" class="btn btn-danger">OK</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection