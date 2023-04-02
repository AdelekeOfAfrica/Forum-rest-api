<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    //

    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => ['required','max:100'],
            'email' => ['required', 'email:filter', 'max:255'],
            'password' => ['required', 'confirmed','min:5', 'string']
        ]);

        #if validator fails 
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->first()
            ]);
        }

        #check if user uploads an image 
            if ($request->hasFile('profile_image')) {
                #validate profile image
                $validate_image = Validator::make($request->all(),[
                    'profile_image' => [ 'image']
                ]);

                if ($validate_image->fails()) {
                    return response()->json([
                        'errors' =>$validate_image->errors()->first()
                    ]);
                }

                $profile_image = $request->profile_image->store('profile_images','public');
                #save user records
                if (User::create(array_merge($validator->validated(), ['profile_image'=>$profile_image]))) {
                        return response()->json([
                            'message' => 'registered successfully',
                            'password' => Hash::make($request->password)
                        ]);
                } else{
                    return response()->json([
                        'message'=>'an error occur'
                    ], 500);
                }
            }

            #if user does not provide image during registration

            if(User::create(array_merge($validator->validated(),
            
            ['password'=>Hash::make($request->password)]
            ))) {
                return response()->json([
                    'message' => 'registered successfully'
                ]);
            }else{
                return response()->json([
                    'message'=>'an error occur'
                ], 500);
            }

    }

    public function login (Request $request) {
        $validator = validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
           #authenticate the user 
        if (!Auth::attempt($request->only(['email','password']))) { //here we are usig the admin guard for authentication
            return response()->json(['error' => 'invalid email or password'], 401);
        }

            $token= Auth::user()->createToken('adelekeofafrica')->plainTextToken;

            return response()->json([
                'user'=>Auth::user(),
                'token' =>$token
            ]);
       
    }

    public function logout() {
        try {

            if (auth()->user()->currentAccessToken()->delete()){
                return response()->json([
                    'status' => 'success',
                    'message' =>'admin successfully logged out'
                ]); 
            } else{

                return response()->json([
                    'status' => 'failed',
                    'message' =>'an error occured while logging out'
                ]); 

            }
        } catch(Exception $e){
            return response()->json([
                'errors' => 'an exceptional error has occured'
            ],500);
        } catch(Error $e){
            return response()->json([
                'errors' => 'an exceptional error has occured'
            ],500);
        }
        
    
    }
}
