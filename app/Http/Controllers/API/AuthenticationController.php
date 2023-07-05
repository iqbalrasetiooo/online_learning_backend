<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = User::all();
        try {
            //code...
            return response()->json([
                'result' => true,
                'message' => 'success',
                'data' => $user,
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'failed',
                'data' => null,
                'error'=> $th->getMessage()
            ]);
        }
    }
   

     /**
     * Update new user data.
     */
    public function updateUser(Request $request, string $id)
    {
        $validatorUser = $request->validate([
            'name' => 'required|unique:users,name,except,id',
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'required|min:5',
        ]);

        $validatorProfile = $request->validate([
            'full_name' => 'string',
            'date_of_birth' => 'date',
            'gender' => '',
            'id_lecturer'=> '',
            'highest_education' => '',
            'education_history' =>'',
            'contact_address' =>'',
            'short_bio' => 'string',
            'imageUrl' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validatorProfile['imageUrl'] = $request->file('imageUrl')->storeAs('public/images', $request->file('imageUrl')->getClientOriginalName());
        try {
            //code...
            DB::beginTransaction();
            // $user = User::findOrFail($id);
            // $profile = Profile::where('user_id', $id)->get();
            User::where('id', $id)->update($validatorUser);
            Profile::where('user_id', $id)->update($validatorProfile);

            $userUpdated = User::where('id', $id)->get();
            $profileUpdated = Profile::where('user_id', $id)->get(); 
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success update user and profile',
                'data' => [
                    'user' => $userUpdated,
                    'profile' => $profileUpdated,
                ],
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Failed update',
                'data' => [
                    'user' => null,
                    'profile' => null,
                ],
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|unique:profiles',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            // 'date_of_birth' => 'date',
            // 'gender' => 'required',
            // 'full_name' => 'required',
        ]);
        // $request->profile_picture = "default";
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->getMessageBag(),
                'data' => null,
                'error' => null
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            //code...
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $profile = Profile::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'profil_picture' => $request->profile_picture,
                'role' => 'STUDENT'
            ]);
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success created new user and profile',
                'data' => [
                    'user' => $user,
                    'profile' => $profile,
                ],
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Failed created new user and profile',
                'data' => [
                    'user' => null,
                    'member' => null,
                ],
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function registerLecturer(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|unique:profiles,full_name,except,id',
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'required|min:5',
            // 'date_of_birth' => 'date',
            // 'gender' => 'required',
            // 'full_name' => 'required',
        ]);
        // $request->profile_picture = "default";
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->getMessageBag(),
                'data' => null,
                'error' => null
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            //code...
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $profile = Profile::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'role' => 'LECTURER',
                'id_lecturer'=> "LEC" . $user->id,
                'highest_education' => $request->highest_education,
                'teaching_experience'=> $request->teaching_experience,
                'education_history'=>$request->education_history,
                'contact_address'=>$request->contact_address,
                'short_bio'=>$request->short_bio,
                'imageUrl'=>$request->imageUrl,
            ]);
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success created new Lecturer',
                'data' => [
                    'user' => $user,
                    'profile' => $profile,
                ],
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Failed created new Lecturer',
                'data' => [
                    'user' => null,
                    'profile' => null,
                ],
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
          // Temukan pengguna berdasarkan ID yang diberikan
          $user = User::findOrFail($id);
          $profile = Profile::where('user_id', $id)->get();
          try {
            // Berikan respons atau kembalikan data pengguna dalam format JSON
            return response()->json([
                'result' => true,   
                'message' => 'Data pengguna berhasil diambil',
                'data' => [
                    'user' => $user,
                    'profile' => $profile,
                ],
                'error' => null
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception){
            return response()->json([
                'result' => false,
                'message' => 'Data user not found',
                'data' => null,
                'error' => $exception->getMessage()
              ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Pengguna tidak ditemukan',
                'data' => null,
                'error' => $th->getMessage()
              ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }        
    }

    /**
     * Update the specified resource in storage.
     */
    public function login(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'email_or_username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->getMessageBag(),
                'data' => null,
                'error' => ""
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email_or_username)
            ->orWhere('name', $request->email_or_username)->first();
        $profile = Profile::where('user_id', $user->id)
            ->first();
        if (!Hash::check($request->password,  $user->password)) return response()->json([
            'result' => false,
            'message' => 'Username, Email or Password Incorrect',
            'data' => null,
            'error' => ""
        ], Response::HTTP_BAD_REQUEST);
        // $authUser = Auth::user();
        $token = $user->createToken('LearningApp')->plainTextToken;
        return response()->json([
            'result' => true,
            'message' => 'Login Success',
            'token' => $token,
            'data' => [
                'id_user' => $user->id,
                'email' => $user->email,
                'name' => $profile->full_name,
                'role' => $profile->role,
            ],
            'error' => ""
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
