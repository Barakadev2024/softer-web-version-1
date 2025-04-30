<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Company; // Fixed namespace casing
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController
{
    public function  my_update(Request $r,$model){
        die("good to go!");
    }

    public function login(Request $r)
    {
        //check if email is provided
        if($r->email == null){
            User::error('email is required');
        };
        //check if email is valid
        if(!filter_var($r->email, FILTER_VALIDATE_EMAIL)){
            User::error('email is invalid');
        };

        //check if password is provided
        if($r->password == null){
            User::error('password is required');
        };

        $user = User::where('email'. $r->email)->first();
        if($user == null){
            User::error("Account not found.");
        }
        if(!password_verify($r->password, $user->password) == false){
            User::error("Invalid password");
        }
        $company = Company::find($user->company_id);
        if($company == null){
            User::error("company not found");
        }
        User::success([
            'user' => $user,
            'company' => $company,
        ], "login successful");

  


    }
    
    public function register(Request $r)
    {
    
        if($r->first_name == null){
            User::error('first name is required');
        }
        //check if last name is provided
        
        if($r->last_name == null){
            User::error('last name is required');
        };
        //check if email is provided
        if($r->email == null){
            User::error('email is required');
        };
        //check if email is valid
        if(!filter_var($r->email, FILTER_VALIDATE_EMAIL)){
            User::error('email is invalid');
        };
        //check if email is already register
        $user = User::where('email', $r->email)->first();
        if($user != null){
            User::error('email is already registered');
        };

        //check if password is provided
        if($r->password == null){
            User::error('password is required');
        };
        //check if password is atleast 8 characters
        if(strlen($r->password) < 8){
            User::error('password must be atleast 8 characters');
        };

        //check if company name is provided
        if($r->company_name == null){
            User::error('company name is required');
        };

      $new_user = new User();
      $new_user->first_name = $r->first_name;
      $new_user->last_name = $r->last_name;
      $new_user->username =$r->email;
      $new_user->password = $r->password_hash($r->password, PASSWORD_DEFAULT);
      $new_user->NAME=$r->first_name ."". $r->last_name;
      $new_user->phone_number=$r->phone_number;
      $new_user->company_id = 1;
      $new_user->status= "Active";
      try{
        $new_user->save();
      }catch(\Exception $e){
        User::error($e->getMessage());
      }

      $registered_user = User::find($new_user->id);
      if( $registered_user== null){
        User::error("failed to register user.");
      }

     $company = new Company();
     $company->owner_id = $registered_user->id;
     $company->name = $r->company_name;
     $company->email = $r->email;
     $company->phone_number = $r->phone_number;
     $company->status = 'active';
     $company->license_expire = date('Y-m-d', strtotime('+1 year'));


     try{
        $company->save();
     }catch(\Exception $e){
        User::error($e->getMessage());
     }

     $registered_company = Company::find($company->id);
     if($registered_company == null){
        User::error("failed to register company");
     }

     //DB insert into admin_role_users
     DB::table('admin_role_users')->insert([
        'user_id' =>$registered_user->id,
        'role_id' => 2
     ]);

User::success([
    'user' => $registered_user,
    'company' =>$registered_company,
],"registration successful.");

    }

}
  