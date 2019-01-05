<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::create($this->validateCategory($request));

        return $this->response($category, 'Category created', 'Error creating category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $status = $category->update($this->validateCategory($request));

        return $this->response($$status, 'Category updated', 'Error updating category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $status = $category->delete();

        return $this->response($status, 'Category deleted', 'Error deleting category');
    }

    /**
     * return all tasks assoicated with a category in order of field 'order'
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function tasks(Category $category)
    {
        return $category
            ->tasks()
            ->orderBy('order')
            ->get();
    }

    public function validateCategory($request) {
        return $request->validate($this->rules());
    }

    public function rules() {
        return [
            'name' => 'requried'
        ];
    }

    public function response($category, $successMessage, $failureMessage) {
        return [
            'status' => (bool) $category,
            'message' => $category ? $successMessage : $failureMessage
        ];
    }
}
