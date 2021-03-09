@if(!empty($employees))   
<div class="row">
</div>
<div class="table-responsive tableFixHead">
   <table class="table table-striped table-bordered table-hover">
      <thead>        
        
         <tr class="bg-primary">
            <th class="col-xs-1 col-sm-1 col-md-1">S.NO</th>
            <th class="col-xs-1 col-sm-1 col-md-1">FIRST NAME</th>   
            <th class="col-xs-2 col-sm-2 col-md-2">LAST NAME</th>        
            <th class="col-xs-2 col-sm-2 col-md-2">COMPANY</th>        
            <th class="col-xs-2 col-sm-2 col-md-2">EMAIL</th>        
            <th class="col-xs-2 col-sm-2 col-md-2">PHONE</th>        
            <th class="col-xs-2 col-sm-2 col-md-2">ACTION</th>
         </tr>
      </thead>
      <tbody >
         <?php $i=0; ?>
         @foreach($employees as $employee)
         <?php $i++; ?>
         <tr id="{{ $employee->id }}">
            <td class="col-xs-1 col-sm-1 col-md-1">{{ $i }}</td>
            <td class="col-xs-2 col-sm-2 col-md-2">{{ $employee->first_name }}</td>
            <td class="col-xs-2 col-sm-2 col-md-2">{{ $employee->last_name }}</td>
            <td class="col-xs-2 col-sm-2 col-md-2">{{ $employee->company_name }}</td>
            <td class="col-xs-2 col-sm-2 col-md-2">{{ $employee->email }}</td>
            <td class="col-xs-2 col-sm-2 col-md-2">{{ $employee->phone }}</td>
            
            <td class="col-xs-2 col-sm-2 col-md-2">
                <!-- class="btn btn-info glyphicon glyphicon-th detailbtn" -->
               <button type="button" name="edit" id="{{ $employee->id }}" class="edit btn btn-warning btn-sm">Edit</button> <!-- class="btn btn-warning glyphicon glyphicon-edit editbtn" -->
               <button type="button" name="delete" id="{{ $employee->id }}" class="delete btn btn-danger btn-sm">Delete</button> <!-- class="btn btn-danger glyphicon glyphicon-trash deletebtn" -->
            </td>
         </tr> 
         @endforeach       
      </tbody>
   </table>
</div>
@endif     
</div>
<!-- {!!$employees->render()!!} -->
<!-- {!! $employees->appends(Input::except('page'))->render() !!}
 -->
{!! $employees->appends(Request::capture()->except('page'))->render() !!}

   <!-- above code is used to dropdown search filter 
        {!!$employees->render()!!} this code is not working for dropdown field search
 -->
 