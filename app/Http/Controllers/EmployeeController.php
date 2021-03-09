<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Company;
use Session;
use Input;
use DB;
use Validator;

class EmployeeController extends Controller
{
     public function index(Request $request)
    {  
        $companies = Company::all(['id', 'name']);        

        if($request->search==""){
             $employees = Employee::select('employees.*','companies.name as company_name')
                  ->leftJoin('companies', 'employees.company_id', '=', 'companies.id')
                  ->orderBy('employees.id', 'desc')
                  ->paginate(10);
               
                return view('employees.employee_index',compact('employees'))->with('companies',$companies);
            }else{
            $employees = Employee::select('employees.*','companies.name as company_name')
                  ->leftJoin('companies', 'employees.company_id', '=', 'companies.id');
                    
                      if ($request->get('search_dropdown')=='first_name') {
                      $employees->where('first_name','LIKE','%'.$request->get('search').'%');
                      }   
                       if ($request->get('search_dropdown')=='last_name') {
                      $employees->where('last_name','LIKE','%'.$request->get('search').'%');
                      }  
                       if ($request->get('search_dropdown')=='company_name') {
                      $employees->where('company_name','LIKE','%'.$request->get('search').'%');
                      }  
                       if ($request->get('search_dropdown')=='email') {
                      $employees->where('email','LIKE','%'.$request->get('search').'%');
                      }  
                      
                      if ($request->get('search_dropdown')=='phone') {
                      $employees->where('phone','LIKE','%'.$request->search.'%');
                      }                       
                                            
                    $employees=$employees->orderBy('employees.id', 'desc');
                    $employees=$employees->paginate(10);

                    $employees->appends($request->only('search')); 
                          
              return view('employees.employee_index',compact('employees'))->with('companies',$companies);
           
        } 

    }

     public function insert(Request $request){
        
        $rules = array( 'first_name'                => 'required',
                        'last_name'                 => 'required',
                        'company_id'       			=> 'required|not_in:0', 
                        'email'                     => 'required',
                        'phone'                     => 'required'
                      );
        $error = Validator::make($request->all(),$rules);
        if($error->fails()){
            return response()->json(['errors'=>$error->errors()->all()]);
        }
        $form_data = array( 'first_name'       => $request->first_name,
                            'last_name'        => $request->last_name,
                            'company_id'       => $request->company_id,
                            'email'            => $request->email,
                            'phone'            => $request->phone
                             );
        //dd($form_data);
        Employee::create($form_data);
        return response()->json(['success' => 'Data Inserted Successfully.']);

    }

    public function edit($id){
        if(request()->ajax()){
            $data = Employee::findOrFail($id);
            return response()->json(['data' => $data]);            
        }
    }


       public function update(Request $request){
        
        $rules = array( 'first_name'                => 'required',
                        'last_name'                 => 'required',
                        'company_id'       			=> 'required|not_in:0', 
                        'email'                     => 'required',
                        'phone'                     => 'required' 
                      );
        $error = Validator::make($request->all(),$rules);
        if($error->fails()){
            return response()->json(['errors'=>$error->errors()->all()]);
        }
        $form_data = array( 'first_name'       => $request->first_name,
                            'last_name'        => $request->last_name,
                            'company_id'       => $request->company_id,
                            'email'            => $request->email,
                            'phone'            => $request->phone
                           );
        Employee::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data Updated Successfully.']);

    }

    public function delete($id){
        $data = Employee::findOrFail($id);
        $data->delete();
    }




}
