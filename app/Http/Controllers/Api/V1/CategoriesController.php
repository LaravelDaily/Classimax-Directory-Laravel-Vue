<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Requests\Admin\StoreCategoriesRequest;
use App\Http\Requests\Admin\UpdateCategoriesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class CategoriesController extends Controller
{
    public function index()
    {
        if (! Gate::allows('category_access')) {
            return abort(401);
        }

        return new CategoryResource(Category::with([])->get());
    }

    public function show($id)
    {
        if (! Gate::allows('category_view')) {
            return abort(401);
        }

        $category = Category::with([])->findOrFail($id);

        return new CategoryResource($category);
    }

    public function store(StoreCategoriesRequest $request)
    {
        if (! Gate::allows('category_create')) {
            return abort(401);
        }

        $category = Category::create($request->all());
        
        

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCategoriesRequest $request, $id)
    {
        if (! Gate::allows('category_edit')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->update($request->all());
        
        
        

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (! Gate::allows('category_delete')) {
            return abort(401);
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return response(null, 204);
    }
}
