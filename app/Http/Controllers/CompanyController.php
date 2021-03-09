<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\Notifications\CompanyRegisteredNotification;
use Validator;
use Session;
use DB;
use Input;
use File;

class CompanyController extends Controller
{
    public function index(Request $request){ 
        if($request->search==""){
            $companies = Company::orderBy('id','asc')->paginate(10);
                return view('companies.company_index',compact('companies'));
            }else{
            $companies = Company::orderBy('id','asc');
            			
             if ($request->get('search_dropdown')=='name') {
                      $companies->where('name','LIKE','%'.$request->get('search').'%');
                      }  
                   if ($request->get('search_dropdown')=='email') {
                      $companies->where('email','LIKE','%'.$request->get('search').'%');
                      }  
                   if ($request->get('search_dropdown')=='website') {
                      $companies->where('website','LIKE','%'.$request->get('search').'%');
                      }  

                     
                      $companies=$companies->paginate(10);
                      $companies->appends($request->only('search'));
                          
            return view('companies.company_index',compact('companies'));
           
        } 
        
    }



    public function insert(Request $request){
    	$rules = array( 'name' 		=> 'required',
    					'email' 	=> 'required|email|unique:users',
    					'logo' => 'required',
        				'logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2 MB',
    					'website' 	=> 'required' );
    	$error = Validator::make($request->all(),$rules);
    	if($error->fails()){
    		return response()->json(['errors'=>$error->errors()->all()]);
    	}
    	if($request->hasFile('logo')) {
    	$logo = $request->file('logo');
    	$new_logo_name = rand().'.'.$logo->getClientOriginalExtension();
    	//dd($new_logo_name);
    		$logo->move(storage_path('app/public'),$new_logo_name);
//dd($new_logo_name);
    		}
    	$form_data = array('name' 		=> $request->name,
    					   'email' 		=> $request->email,
    					   'logo'   	=> $new_logo_name,
    					   'website' 	=> $request->website
    						 );
    	Company::create($form_data);


    	$company = Company::where('email',$request->email)->first();

        $company->notify(new CompanyRegisteredNotification("A new user has visited on your application."));

        return response()->json(['success' => 'Data Inserted Successfully.']);

    	

    }

  

    public function edit($id){
    	if(request()->ajax()){
    		$data = Company::findOrFail($id);
    		return response()->json(['data' => $data]);
    	}

    }

    public function update(Request $request){

    	$logo_image_name = $request->hidden_image;
    	$logo = $request->file('logo');
    	if($logo != ''){
    	$rules = array( 'name' => 'required', 
    					'email' 	=> 'required|email',
    					'logo' => 'required',
        				'logo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2 MB',
    					'website' 	=> 'required');
    	$error = Validator::make($request->all(),$rules);
    	if($error->fails()){
    		return response()->json(['errors'=>$error->errors()->all()]);
    	}
    	 $logo_image_name = rand() . '.' . $logo->getClientOriginalExtension();
                $logo->move(storage_path('app/public'), $logo_image_name);
                //dd($logo_image_name);

    }
    else{

    	$rules = array( 'name' => 'required', 
    					'email' 	=> 'required|email',
    					'website' 	=> 'required');
    	$error = Validator::make($request->all(),$rules);
    	if($error->fails()){
    		return response()->json(['errors'=>$error->errors()->all()]);
    	}

    }
    	$form_data = array('name' => $request->name,
    					   'email' => $request->email,
    					   'logo'      => $logo_image_name,
    					   'website' => $request->website );
    	Company::whereId($request->hidden_id)->update($form_data);
    	return response()->json(['success' => 'Data Updated Successfully.']);

    }

    public function delete($id){
    	$data = Company::findOrFail($id);
    	$logo_path = base_path()."/storage/app/public/".$data->logo;
        if(file_exists($logo_path)){
            //File::delete($image_path);
            File::delete($logo_path);
        } 
    	$data->delete(); 
    }
}
