<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function _construct(){
        $this->middleware('auth');
    }
    
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request){
        if(!$request->user()->authorizeRoles(['user', 'administrator'])){ abort(401, "You shouldn't be here..."); }
        $data = array('notify' => '');
        return view('account')->with($data);
    }
    
    /**
    * Change the user's password
    *
    * @return \Illuminate\Http\Response
    */
    public function changePassword(Request $request){
        // Fetch current user
        $user = Auth::user();
        
        // Validate the passwords
        $this->validate(request(), [
        'current_password' => 'required|current_password',
        'new_password' => 'required|string|min:6|confirmed',
        ]);
        
        // Hash the new password
        $password = Hash::make(request()->input('new_password'));
        
        // Insert new password into user table based on fetched id
        DB::table('users')
        ->where('id', $user->id)
        ->update(['password' => $password]);
        
        // Redirect user back to account page for feedback
        return redirect('account')->with('success', 'Password changed!');
    }
    
    /*
    * Administrator functionality
    */
    public function admin(){
        $data = array(
        "users" => $this->getUsers(),
        "roles" => $this->getRoles()
        );
        
        return view('admin')->with('data', $data);
    }
    
    /**
    * Handle change roles ajax request
    */
    public function changeRoles(Request $request){
        // Set response template and initial response code.
        $code = 400;
        $response = array(
        "status" => "error",
        "message" => ""
        );
        
        // Return if we don't find any user ids
        if(!$request->input('user_ids')){
            $response["message"] = "No user ids";
            return response()->json($response, $code);
        }
        
        // Return if we don't find any role ids
        if(!$request->input('role_id')){
            $response["message"] = "No role data";
            return response()->json($response, $code);
        }
        
        // Set data variables
        $user_ids = $request->input('user_ids');
        $role_id = $request->input('role_id');
        
        if($request){
            // Update roles
            $updated = $this->updateRoles($user_ids, $role_id);
            
            if($updated){
              // Set success message and code
              $response = array(
              "status" => "success",
              "message" => "Roles updated!"
              );
              $code = 200;
            }else{
              // Set error message and code
              $response = array(
              "status" => "success",
              "message" => "No updating the root user!"
              );
              $code = 200;
            }
        }else{
            // ... else add an error message
            $response["message"] = "Couldn't send the emails.";
        }
        
        // Return JSON for AJAX request
        return response()->json($response, $code);
    }
    
    /*
    * Return database user data
    */
    private function getUsers(){
        $users = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->select('users.id', 'users.name', 'users.email', 'role_user.role_id')
        ->where('users.id', '!=', 1)
        ->get();
        
        return $users;
    }
    
    /*
    * Return database role data
    */
    private function getRoles(){
        $roles = array();
        $data = DB::table('roles')
        ->select('roles.id', 'roles.name')
        ->get();
        
        if($data){
            foreach($data as $role_data){
                $roles[$role_data->id] = $role_data->name;
            }
        }
        return $roles;
    }
    
    /*
    * Update role data
    */
    private function updateRoles($user_ids, $role_id){
      // Make a check remove user_id 1 - This will be root migration account and should be 
      $user_ids = array_diff($user_ids, [1]);

      // If id 1 was the only user in the array then return an error.
      if(!$user_ids){ return false; }

      // Update role data
      DB::table('role_user')->whereIn('user_id', $user_ids)->update(['role_id' => $role_id]);

      return true;
    }
}