<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //code...
            $lecturers = Profile::where('role', 'LECTURER')->get();
            return response()->json([
                'result' => true,
                'message' => 'Success',
                'data' => $lecturers,
                'error' => null,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'No data',
                'data' => null,
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createLecturer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,name,except,id',
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'required|min:5',
            'full_name' => '',
            'date_of_birth' => 'nullable',
            'gender' => 'nullable',
            'id_lecturer' => 'nullable',
            'highest_education' => 'nullable',
            'teaching_experience' => 'nullable',
            'education_history' => 'nullable',
            'contact_address' => 'nullable',
            'short_bio' => 'nullable',
            'imageUrl' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable'
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
            $member = Profile::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'profil_picture' => $request->profile_picture,
                'id_lecturer' => $request->id_lecturer,
                'highest_education' => $request->highest_education,
                'teaching_experience' => $request->teaching_experience,
                'education_history' => $request->education_history,
                'contact_address' => $request->contact_address,
                'short_bio' => $request->short_bio,
                'image_url' => $request->image_url->move(public_path('image')),
                'role' => 'LECTURER'
            ]);
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success created new user and member',
                'data' => [
                    'user' => $user,
                    'member' => $member,
                ],
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Failed created new user and member',
                'data' => [
                    'user' => null,
                    'member' => null,
                ],
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
