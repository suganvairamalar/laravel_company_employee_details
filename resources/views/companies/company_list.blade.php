@if(!empty($companies))   
<div class="table-responsive tableFixHead">
   <table class="table table-striped table-bordered table-hover">
      <thead>
        
         <tr class="bg-primary">
            <th class="col-xs-1 col-lg-1 col-sm-1 col-md-1">S.NO</th>           
            <th class="col-xs-2 col-lg-2 col-sm-2 col-md-2">LOGO</th>           
            <th class="col-xs-2 col-lg-2 col-sm-2 col-md-2">NAME</th>           
            <th class="col-xs-2 col-lg-2 col-sm-2 col-md-2">EMAIL</th>           
            <th class="col-xs-2 col-lg-2 col-sm-2 col-md-2">WEBSITE</th>           
            <th class="col-xs-2 col-lg-2 col-sm-2 col-md-2">ACTION</th>
         </tr>
      </thead>
      <tbody >
         <?php $i=0; ?>
         @foreach($companies as $company)
         <?php $i++; ?>
         <tr>
            <td class="col-xs-1 col-lg-1 col-sm-1 col-md-1">{{ $i }}</td>
            <td class="col-xs-2 col-lg-2 col-sm-2 col-md-2"><div><img src="{{ asset('storage/'.$company->logo)}}" style="width:100px;height:100px;" class='img-thumbnail'></div></td>
            <td class="col-xs-2 col-lg-2 col-sm-2 col-md-2">{{ $company->name }}</td>
            <td class="col-xs-2 col-lg-2 col-sm-2 col-md-2">{{ $company->email }}</td>
            <td class="col-xs-2 col-lg-2 col-sm-2 col-md-2">{{ $company->website }}</td>
            <td>
                <!-- class="btn btn-info glyphicon glyphicon-th detailbtn" -->
               <button type="button" name="edit" id="{{ $company->id }}" class="edit btn btn-warning btn-sm">Edit</button> <!-- class="btn btn-warning glyphicon glyphicon-edit editbtn" -->
               <button type="button" name="delete" id="{{ $company->id }}" class="delete btn btn-danger btn-sm">Delete</button> <!-- class="btn btn-danger glyphicon glyphicon-trash deletebtn" -->
            </td>
         </tr>
         @endforeach       
      </tbody>
   </table>
</div>
@endif     
<!-- </div> -->
<!-- {!!$companies->render()!!} -->

{!! $companies->appends(Request::capture()->except('page'))->render() !!}