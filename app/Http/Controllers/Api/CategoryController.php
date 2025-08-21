<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Category::all();
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'status' => '500'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'msg' => $validator->errors(),
                    'status' => 400
                ], 400);
            }
            $name = $request->name;
            $category = new Category();
            $category->name = $name;
            $category->save();

            return response()->json($category, 201);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'status' => '500'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return Category::find($id);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'status' => '500'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'msg' => 'category not found',
                    'status' => '404'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'msg' => $validator->errors(),
                    'status' => 400
                ], 400);
            }
            $name = $request->name;
            $category->name = $name;
            $category->save();

            return response()->json($category, 201);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'status' => '500'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            return response()->json($category, 200);
        } catch (Exception $e) {
            return response()->json([
                'msg' => $e->getMessage(),
                'status' => '500'
            ], 500);
        }
    }
}
