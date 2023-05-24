<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function category()
    {
        try {
            return response()->json([
                'result' => true,
                'message' => 'Success mengirim category',
                'data' => [
                    [
                        'label' => 'It',
                        'value' => 1
                    ],
                    [
                        'label' => 'It',
                        'value' => 2
                    ],
                    [
                        'label' => 'Makanan',
                        'value' => 3
                    ],
                    [
                        'label' => 'Minuman',
                        'value' => 4
                    ]
                ],
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'result' => false,
                'message' => 'Failed created new user and member',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_id' => 'required',
            'category_id' => 'required',
            'member_id' => 'required',
            'transaction_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
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
            $member = Course::create([
                'author_id' => $request->author_id,
                'category_id' => $request->category_id,
                'member_id' => $request->member_id,
                'transaction_id' => $request->transaction_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $request->image,
            ]);
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success created new user and member',
                'data' => $member,
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Failed created new user and member',
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
