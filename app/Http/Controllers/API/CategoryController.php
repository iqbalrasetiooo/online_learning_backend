<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        try {
            //code...
            return response()->json([
                'result' => true,
                'message' => 'success',
                'data' => $category,
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

    public function addCategory(Request $request)
    {
        $categoryValidate = $request->validate([
            'name' => 'string|unique:categories'
        ]);
        
        $category = Category::create($categoryValidate);
        try {
            //code...
            return response()->json([
                'result'    => true,
                'message'   => 'Success added new category',
                'data'      => $category,
                'error'     => null
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'result'    => false,
                'message'   => 'Failed to add category',
                'data'      => null,
                'error'     => $th->getMessage()
            ]);
        }
    }
}
