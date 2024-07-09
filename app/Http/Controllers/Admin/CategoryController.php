<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.category.index', compact('categories'))->with('id');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories,name'],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input = $request->except('_token');
        $input['slug'] = Str::slug($request->name);
        $category = Category::create($input);
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories,name,'.$id],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = Category::find($id);
        $input = $request->except('_token');
        $input['slug'] = Str::slug($request->name);
        $category->update($input);
        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index');
    }

}
