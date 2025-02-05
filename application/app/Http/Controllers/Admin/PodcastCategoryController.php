<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PodcastCategoryController extends Controller
{
    public function index(){
        $pageTitle = 'Manage Podcast Category';
        $podcastCategory = Category::latest()->paginate(getPaginate());
        return view('admin.podcast_category.list',compact('podcastCategory','pageTitle'));
    }


    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:255|unique:categories',
        ]);

        $category = new Category();
        $category->name=$request->name;
        $category->status = $request->status ? 1 : 0;
        if($request->hasFile('image')){
            try {
                $directory          = date("Y")."/".date("m");
                $path               = getFilePath('category').'/'.$directory;
                $image              = fileUploader($request->image, $path);
                $category->image    = $image;
                $category->path     = $directory;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $category->save();

        $notify[] = ['success', 'Category has been created'];
        return back()->withNotify($notify);

    }

    public function update(Request $request){

        $request->validate([
            'name'         =>  'required|string'
        ]);

        $category  = Category::findOrFail($request->id);
        $check =Category::whereNot('id', $category->id)->where('name', $request->name)->get();

        if($check->count()>0){
            $notify[]               = ['error','Category name already exists'];
            return redirect()->back()->withNotify($notify);
        }

        $category->name     = $request->name;
        $category->status   = $request->status ? 1 : 0;
        if($request->hasFile('image')){
            try {
                $directory          = date("Y")."/".date("m");
                $path               = getFilePath('category').'/'.$directory;
                $image              = fileUploader($request->image, $path);
                $category->image    = $image;
                $category->path     = $directory;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $category->save();

        $notify[] = ['success', 'Category has been Updated'];
        return back()->withNotify($notify);

    }
}
