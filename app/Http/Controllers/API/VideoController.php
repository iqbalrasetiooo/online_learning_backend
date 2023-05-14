<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'author_id' => 'required',
            'thumbnail' => 'required',
            'title' => 'required',
            'description' => 'required',
            'video' => 'required',
        ], [
            'required' => 'Field :attribute harus diisi.'
        ]);
        if ($validator->fails()) {
            $messages = collect($validator->getMessageBag()->toArray())->flatten()->each(function ($error) {
                return [
                    'message' => $error
                ];
            });
            return response()->json([
                'result' => false,
                'message' => $messages[0],
                'data' => null,
                'error' => null
            ], Response::HTTP_BAD_REQUEST);
        }
        try {

            $video = new Video;
            $video->course_id = $request->course_id;
            $video->author_id = $request->author_id;
            $video->thumbnail = $request->thumbnail;
            $video->title = $request->title;
            $video->description = $request->description;
            $video->video = $request->video;

            $video->save();
            return response()->json([
                'result' => true,
                'message' => 'Success created new user and member',
                'data' => $video,

            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'result' => false,
                'message' => 'failed',
                'data' => "",
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
        $data =  Video::find($id);
        if (!$data) {
            return response()->json([
                'result' => false,
                'message' => 'Data tidak ditemukan.',
                'data' => null,
                'error' => null
            ], Response::HTTP_NOT_FOUND);
        }
        $data->delete();
        return response()->json([
            'result' => true,
            'message' => 'Data berhasil dihapus.',
            'data' => null,
            'error' => null
        ], Response::HTTP_NO_CONTENT);
    }
}
