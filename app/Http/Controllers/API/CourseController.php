<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = Course::all();
        try {
            //code...
            return response()->json([
                'result' => true,
                'message' => 'success',
                'data' => $course,
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
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'author_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            // 'member_id' => 'required',
            // 'image' => 'required',
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
            $course = Course::create([
                'author_id' => $request->author_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                // 'member_id' => $request->member_id,
                'image' => $request->image,
            ]);
            // Check if image file exists
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Success created new course',
                'data' => $course,
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Failed to create',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        // Temukan pengguna berdasarkan ID yang diberikan
        $course = Course::where('author_id', $id)->get();
        try {
            return response()->json([
                'result' => true,
                'message' => 'Success',
                'data' => $course,
                'error' => null
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'result' => false,
                'message' => 'Course not found',
                'error' => $exception->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to retrieve course',
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        $course = Course::find($id);
        try {
            //code...
            $course->delete();
            return response()->json([
                'result' => true,
                'message' => 'Delete Course Success',
                'error' => null
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result' => false,
                'message' => 'Course not found',
                'error' => $th->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
