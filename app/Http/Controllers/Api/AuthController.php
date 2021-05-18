<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware(['jwtauth'])->except('login','android_login');
    }

    public function login(Request $request) {
        if(!$token = JWTAuth::attempt($request->only('email','password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(compact('token'));
    }
	
	public function android_login(Request $request) {
        if(!$token = JWTAuth::attempt($request->only('email','password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }

    public function me() {
        $user = auth()->user();

        return response()->json(['name' => $user->name,'email'=>$user->email]);
    }

    public function checkToken() {
        return response()->json(['success'=>true], 200);
    }

    public function logout() {
        auth()->logout();
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function updateProfile(Request $request) {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email'
        ]);

        $user = auth()->user();

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);


        return response()->json(['message' => 'Profile Saved']);
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'password'=>'required|confirmed',
        ]);

        $credentials = $request->only('password', 'password_confirmation');

        $credentials['email'] = auth()->user()->email;

        $user = auth()->user();

        $user->update(['password'=> bcrypt($credentials['password'])]);

        $user->save();

        return response()->json(['message'=>'Password Changed']);
    }

    public function createUser(Request $request) {
        try {
            $user = User::where('email', $request->email)->get();
            
            if(count($user) > 0){
                return response()->json(['status'=>'0','message'=>'meron na']);
            }
            else {
                $validated = $this->validate($request,[
                    'email' => 'required|email',
                    'password'=>'required|confirmed',
                    'name'=>'required',
                    'position'=>'required'
                ]);
                    
                $userr = new User;
                $userr->name = $request->name;
                $userr->email = $request->email;
                $userr->password = bcrypt($request->password);
                $userr->position = $request->position;
                // $userr->create(['email' => $request->email, 'name' => $request->name, 'password' => bcrypt($request->password), 'position' => $request->position]);
                $userr->save();
                    
                return response()->json(['status'=>'1','message'=>'success']);
            }
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

    public function getUsers() {
        try {
            $users = User::select('id','name','email','position',DB::raw('DATE_FORMAT(created_at, "%M %d, %Y") as created_att'))->get();
            
        
            return response()->json(['status'=>'1','result'=>$users]);
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }
	
	public function updateUser(Request $request) {
        try{
            if($request->pass_nochange) {
                $update = User::where('id', $request->user_id)
                    ->update([
                        'name'=>$request->name,
                        'position'=>$request->position,
                        'email'=>$request->email
                    ]);
                return response()->json(['status'=>'1','message'=>'goods2']);
            }
            else {
                $update = User::where('id', $request->user_id)
                    ->update([
                        'name'=>$request->name,
                        'position'=>$request->position,
                        'email'=>$request->email,
                        'password'=>bcrypt($request->password)
                    ]);
                return response()->json(['status'=>'1','message'=>'goods']);
            }
        }
        catch(\Exception $e) {
            return response()->json(['status'=>'0','message'=>$e->getMessage()]);
        }
    }

}
