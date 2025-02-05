<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PodcastController extends Controller
{
    public function createPodcastEpisode()
    {
        $pageTitle = 'New Podcast Episode';
        $podcastCategory = Category::where('status', 1)->get();
        $podcast = Podcast::all();
        return view('admin.podcast.new_episodes',compact('pageTitle', 'podcastCategory', 'podcast'));
    }

    public function podcastDelete($id)
    {
        $podcast = Podcast::findOrFail($id);
        $episodes = Episode::where('podcast_id', $podcast->id)->get();

        if($episodes->count()>0)
        {
            foreach($episodes as $item)
            {
                if($item->file_type == 2 || $item->file_type == 3)
                {
                    $oldPath = getFilePath('podcastEpisode');
                    fileManager()->removeFile($oldPath.'/'.$item->file_path.'/'.$item->filename);

                    $oldPathImage = getFilePath('podcastEpisode');
                    fileManager()->removeFile($oldPathImage.'/'.$item->image_path.'/'.$item->image);
                }
                $bookmarks = Bookmark::where('episode_id', $item->id)->delete();
        
                $item->delete();
            }
        }

        $oldPath = getFilePath('podcast');
        fileManager()->removeFile($oldPath.'/'.$podcast->path.'/'.$podcast->image);

        $podcast->delete();


        $notify[]           = ['success', 'Podcast deleted successfully.'];
        return back()->withNotify($notify);

    }

    public function episodeDelete($id)
    {
        $episode               = Episode::findOrFail($id);

        if($episode->file_type == 2 || $episode->file_type == 3)
        {
            $oldPath = getFilePath('podcastEpisode');
            fileManager()->removeFile($oldPath.'/'.$episode->file_path.'/'.$episode->filename);

            $oldPathImage = getFilePath('podcastEpisode');
            fileManager()->removeFile($oldPathImage.'/'.$episode->image_path.'/'.$episode->image);
        }
        $bookmarks = Bookmark::where('episode_id', $episode->id)->delete();

        $podcast = Podcast::findOrFail($episode->podcast_id);
        $podcast->decrement('episode_count');
        $podcast->save();
        $episode->delete();
        $notify[]           = ['success', 'Episode deleted successfully.'];
        return back()->withNotify($notify);
    }

    public function podcastEpisodeStore(Request $request)
    {

        if($request->add_new_podcast == 1){
            $check = Podcast::where('title', $request->new_podcast_title)->where('category_id', $request->new_podcast_category_id)->get();
            if($check->count() > 0)
            {
                $array = ['exists' => 'Podcast title already exists'];
                return response()->json(['errors' => $array], 400);
            }

            $validator = Validator::make($request->all(), [
                'new_podcast_title'         => 'required|string',
                'new_podcast_category_id' => 'required|exists:categories,id',
                'new_podcast_description'   => 'required',
                'monthly_price' => 'nullable|numeric',
                'yearly_price' => 'nullable|numeric',
                'podcast_image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png'])],
                'title'         => 'required|string',
                'description'   => 'required|string',
                'image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png'])],
                'filename' => [
                    'required_if:file_type_select,2,3',
                    Rule::when($request->file_type_select == 3, 'mimetypes:video/mp4,video/mpeg,video/quicktime'),
                    Rule::when($request->file_type_select == 2, 'mimetypes:audio/mpeg,audio/wav,audio/x-wav'),
                ],
                'link' => [
                    'required_if:file_type_select,1',
                    'regex:/^https?:\/\/[^\s\/$.?#].[^\s]*$/',
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->first()], 400);
            }

        }
        else{
            $validator = Validator::make($request->all(), [
                'podcast_id' => 'required|exists:podcasts,id',
                'title'         => 'required',
                'description'   => 'required',
                'image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png'])],
                'filename' => [
                    'required_if:file_type_select,2,3',
                    Rule::when($request->file_type_select == 3, 'mimetypes:video/mp4,video/mpeg,video/quicktime'),
                    Rule::when($request->file_type_select == 2, 'mimetypes:audio/mpeg,audio/wav,audio/x-wav'),
                ],
                'link' => [
                    'required_if:file_type_select,1',
                    'regex:/^https?:\/\/[^\s\/$.?#].[^\s]*$/',
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
        }



        if($request->add_new_podcast == 1){

            $podcast                = new Podcast();
            $podcast->title         = $request->new_podcast_title;
            $podcast->category_id      = $request->new_podcast_category_id;
            $podcast->description   = $request->new_podcast_description;

            if($request->monthly_price != null)
            {
                $podcast->monthly_price = $request->monthly_price;
            }

            if($request->yearly_price != null)
            {
                $podcast->yearly_price = $request->yearly_price;
            }

            if($request->hasFile('podcast_image')){
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('podcast').'/'.$directory;
                    $image = fileUploader($request->image, $path);
                    $podcast->image = $image;
                    $podcast->path = $directory;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }

            $podcast->creator_id    = 0;
            $podcast->save();

            $episode                = new Episode();
            $episode->title         = $request->title;
            $episode->podcast_id    = $podcast->id;


            if($request->file_type_select == 1)
            {
                $episode->file_type = 1;
                $episode->link = $request->link;
            }
            else if($request->file_type_select == 2)
            {
                $episode->file_type = 2;
            }
            else if($request->file_type_select == 3)
            {
                $episode->file_type = 3;
            }

            if($request->filename)
            {
                try{
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('podcastEpisode').'/'.$directory;
                    $filename = fileUploader($request->filename, $path);
                    $episode->filename = $filename;
                    $episode->file_path = $directory;
                }catch(\Exception $exp){
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }


            if($request->hasFile('image')){
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('podcastEpisode').'/'.$directory;
                    $image = fileUploader($request->image, $path);
                    $episode->image = $image;
                    $episode->image_path = $directory;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }


            $episode->description   = $request->description;

            if($request->is_premium == 1){
                $episode->is_special    = 1;
            }else{
                $episode->is_special    = 0;
            }
            $episode->save();

            $podcast->increment('episode_count');
            $podcast->save();

        }else{

            $episode                = new Episode();
            $episode->title         = $request->title;
            $episode->podcast_id    = $request->podcast_id;


            if($request->file_type_select == 1)
            {
                $episode->file_type = 1;
                $episode->link = $request->link;
            }else if($request->file_type_select == 2)
            {
                $episode->file_type = 2;
            }else if($request->file_type_select == 3)
            {
                $episode->file_type = 3;
            }

            if($request->filename)
            {
                try{
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('podcastEpisode').'/'.$directory;
                    $filename = fileUploader($request->filename, $path);
                    $episode->filename = $filename;
                    $episode->file_path = $directory;
                }catch(\Exception $exp){
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }


            if($request->hasFile('image')){
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('podcastEpisode').'/'.$directory;
                    $image = fileUploader($request->image, $path);
                    $episode->image = $image;
                    $episode->image_path = $directory;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }


            $episode->description   = $request->description;


            if($request->is_premium == 1){
                $episode->is_special    = 1;
            }else{
                $episode->is_special    = 0;
            }
            $podcast = Podcast::findOrFail($request->podcast_id);
            $podcast->increment('episode_count');
            $podcast->save();
            $episode->save();

        }

        if($request->file_type_select == 1)
        {
            return response()->json(['success' => 'Episode created successfully.']);
        }else if($request->file_type_select == 2)
        {
            return response()->json(['success' => 'File uploaded successfully.']);
        }else if($request->file_type_select == 3)
        {
            return response()->json(['success' => 'File uploaded successfully.']);
        }

    }

    public function index()
    {
        $pageTitle = 'Manage Podcast';
        $podcasts = Podcast::with('episode', 'user', 'category')->latest()->paginate(getPaginate());
        $categories = Category::all();
        return view('admin.podcast.list',compact('podcasts','pageTitle','categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'         =>  'required|string|unique:podcasts',
            'description'   => 'required',
            'category_id' => 'required|exists:categories,id',
            'monthly_price' => 'nullable|numeric',
            'yearly_price' => 'nullable|numeric',
            'image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);

        $podcast = new Podcast();
        $podcast->title         = $request->title;
        $podcast->category_id      = $request->category_id;

        if($request->monthly_price != null)
        {
            $podcast->monthly_price = $request->monthly_price;
        }

        if($request->yearly_price != null)
        {
            $podcast->yearly_price = $request->yearly_price;
        }

        if($request->hasFile('image')){
            try {
                $directory = date("Y")."/".date("m");
                $path       = getFilePath('podcast').'/'.$directory;
                $image = fileUploader($request->image, $path);
                $podcast->image = $image;
                $podcast->path = $directory;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $podcast->description   = $request->description;
        $podcast->save();
        $notify[]               = ['success','Podcast created successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'         =>  'required|string',
            'description'   => 'required',
            'monthly_price' => 'nullable|numeric',
            'yearly_price' => 'nullable|numeric',
            'podcast_image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);

        $podcast                = Podcast::findOrFail($request->id);
        $check =Podcast::whereNot('id', $podcast->id)->where('title', $request->title)->where('category_id', $request->category)->get();

        if($check->count()>0){
            $notify[]               = ['error','Podcast title already exists'];
            return redirect()->back()->withNotify($notify);
        }

        $podcast->title         = $request->title;
        $podcast->category_id      = $request->category;
        $podcast->description   = $request->description;

        if($request->monthly_price != null)
        {
            $podcast->monthly_price = $request->monthly_price;
        }else{
            $podcast->monthly_price = 0.00;
        }

        if($request->yearly_price != null)
        {
            $podcast->yearly_price = $request->yearly_price;
        }else{
            $podcast->yearly_price = 0.00;
        }


        if($request->hasFile('podcast_image')){
            try {

                $oldPath = getFilePath('podcast');
                fileManager()->removeFile($oldPath.'/'.$podcast->path.'/'.$podcast->image);

                $directory = date("Y")."/".date("m");
                $path       = getFilePath('podcast').'/'.$directory;
                $image = fileUploader($request->podcast_image, $path);
                $podcast->image = $image;
                $podcast->path = $directory;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $podcast->save();
        $notify[]               = ['success','Podcast updated successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function episodeList($id)
    {
        $podcast = Podcast::findOrFail($id);
        $episodeList = Episode::where('podcast_id', $podcast->id)->paginate(getPaginate());
        $pageTitle = 'Episode List';
        return view('admin.podcast.episode_list',compact('podcast','pageTitle', 'episodeList'));

    }

    public function episodeUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:episodes,id',
            'title'         => 'required',
            'description'   => 'required',
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);
        $id = $request->id;
        $title = $request->title;
        $description = $request->description;

        $episode = Episode::findOrFail($id);
        $podcast = Podcast::findOrFail($episode->podcast_id);

        if($podcast->creator_id == 0){
            $episode->title = $title;
            $episode->description = $description;

            if($request->hasFile('image')){
                try {

                    $oldPath = getFilePath('podcastEpisode');
                    fileManager()->removeFile($oldPath.'/'.$episode->image_path.'/'.$episode->image);

                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('podcastEpisode').'/'.$directory;
                    $image = fileUploader($request->image, $path);
                    $episode->image = $image;
                    $episode->image_path = $directory;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }

            $episode->save();
            $notify[]               = ['success','Episode updated successfully'];
            return redirect()->back()->withNotify($notify);
        }else{
            $notify[]               = ['error','You are not allow to update this episode.'];
            return redirect()->back()->withNotify($notify);
        }




    }
}
