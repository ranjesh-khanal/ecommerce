<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::paginate(10);
        return view('admin.banner.index', compact('banners'))->with('id');
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $input = $request->except('_token');
        if($request->hasFile('image')){
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $input['image'] = $imageName;
            if(!file_exists('images/banners')){
                mkdir('images/banners', 0777, true);
            }
            $request->image->move('images/banners', $imageName);

            $banner = Banner::create($input);
        }
        return redirect()->route('banner.index');
    }
    public function edit($id)
    {
        $banner =Banner::findorFail($id);
        return view('admin.banner.edit',compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $banner = Banner::find($id);
        $oldImage = $banner->image;
        $input = $request->except('_token');
        if($request->hasFile('image')){
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $input['image'] = $imageName;
            if(!file_exists('images/banners')){
                mkdir('images/banners', 0777, true);
            }
            $request->image->move('images/banners', $imageName);

            $banner->update($input);

            if(file_exists('images/banners/'.$oldImage)){
                unlink('images/banners/'.$oldImage);
            }
        }
        return redirect()->route('banner.index');
    }

    public function delete ($id)
    {
        $banner =Banner::find($id);
        $image = $banner->image;
        $banner->delete();
        if(file_exists('images/banners/'.$image)){
            unlink('images/banners/'.$image);
        }
        return redirect()->route('banner.index');
    }
}
