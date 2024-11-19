<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryExecutorResource;
use Illuminate\Http\Request;
use App\Models\CategoryExecutor;

class CategoryExecutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryExecutorResource::collection(CategoryExecutor::with('executor', 'category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_category_executor = CategoryExecutor::create($request->all());

        return $created_category_executor;
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
    public function destroy(CategoryExecutor $category_executor)
    {
        $category_executor->delete();
    }
}
