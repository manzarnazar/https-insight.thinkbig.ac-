<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Deposit;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Podcast;
use App\Models\Episode;
use App\Rules\FileTypeValidate;
use Illuminate\Validation\Rule;

class PodcastController extends Controller
{

    public function podcastList(Request $request)
    {
        $pageTitle      = 'Podcast List';
        $categories     = Category::all();
        $podcasts       = Podcast::where('creator_id',auth()->user()->id)->with('episode', 'category');
        if($request->search)
        {
            $podcasts   = $podcasts->where('title',$request->search);

        }
        $podcasts       = $podcasts->paginate(getPaginate(10));

        return view($this->activeTemplate.'user.podcast.podcast_list',compact('pageTitle','categories','podcasts'));
    }


    public function newPodcast()
    {
        $pageTitle = "New Podcast";
        $categories = Category::all();

        return view($this->activeTemplate.'user.podcast.new_podcast',compact('pageTitle','categories'));
    }


    public function podcastStore(Request $request)
    {

        $request->validate([
            'title'         =>  'required|string|unique:podcasts',
            'description'   => 'required',
            'monthly_price' => 'nullable|numeric',
            'yearly_price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => ['nullable','image',new FileTypeValidate(['jpg', 'jpeg','png'])]
        ]);

        $podcast                = new Podcast();
        $podcast->title         = $request->title;
        $podcast->category_id   = $request->category_id;
        $podcast->description   = $request->description;
        $podcast->creator_id	= auth()->user()->id;
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
                $directory      = date("Y")."/".date("m");
                $path           = getFilePath('podcast').'/'.$directory;
                $image          = fileUploader($request->image, $path,getFileSize('podcast'));
                $podcast->image = $image;
                $podcast->path  = $directory;

            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $podcast->save();
        $notify[]               = ['success','Podcast created successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function podcastUpdate(Request $request)
    {

        $request->validate([
            'title'         =>  'required|string',
            'description'   => 'required',
            'image'         => ['nullable','image',new FileTypeValidate(['jpg', 'jpeg','png'])]
        ]);

        $podcast                = Podcast::findOrFail($request->id);
        $check =Podcast::whereNot('id', $podcast->id)->where('title', $request->title)->where('category_id', $request->category)->get();

        if($check->count()>0){
            $notify[]               = ['error','Podcast title already exists'];
            return redirect()->back()->withNotify($notify);
        }

        $podcast                = Podcast::findOrFail($request->id);
        $podcast->title         = $request->title;
        $podcast->category_id   = $request->category;
        $podcast->description   = $request->description;

        if($request->hasFile('image')){
            try {

                $oldPath = getFilePath('podcast');
                fileManager()->removeFile($oldPath.'/'.$podcast->path.'/'.$podcast->image);

                $directory      = date("Y")."/".date("m");
                $path           = getFilePath('podcast').'/'.$directory;
                $image          = fileUploader($request->image, $path,getFileSize('podcast'));
                $podcast->image = $image;
                $podcast->path  = $directory;

            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $podcast->save();
        $notify[]               = ['success','Podcast Updated Successfully'];
        return redirect()->back()->withNotify($notify);
    }


    public function podcastDelete($id)
    {
        $podcast = Podcast::findOrFail($id);
   
        $user = auth()->user();

        if($podcast->creator_id == $user->id){
            $episodes = Episode::where('podcast_id', $podcast->id)->get();

            if($episodes->count()>0)
            {
                foreach($episodes as $item)
                {
                    if($item->file_type == 2 || $item->file_type == 3)
                    {
                        $oldPath = getFilePath('podcastEpisode');
                        fileManager()->removeFile($oldPath.'/'.$item->file_path.'/'.$item->filename);
                    }
                    $oldPathImage = getFilePath('podcastEpisode');
                    fileManager()->removeFile($oldPathImage.'/'.$item->image_path.'/'.$item->image);
                    $bookmarks = Bookmark::where('episode_id', $item->id)->delete();
            
                    $item->delete();
                }
            }

            $oldPath = getFilePath('podcast');
            fileManager()->removeFile($oldPath.'/'.$podcast->path.'/'.$podcast->image);
    
            $podcast->delete();
    
    
            $notify[]           = ['success', 'Podcast deleted successfully.'];
            return back()->withNotify($notify);

        }else{
            $notify[]           = ['error', 'Your are not allow to delete this Podcast.'];
            return back()->withNotify($notify);
        }


    }

    public function episodeDelete($id)
    {
      
        $episode               = Episode::with('podcast')->findOrFail($id);
        $user = auth()->user();
        if($episode->podcast->creator_id == $user->id)
        {
            if($episode->file_type == 2 || $episode->file_type == 3)
            {
                $oldPath = getFilePath('podcastEpisode');
                fileManager()->removeFile($oldPath.'/'.$episode->file_path.'/'.$episode->filename);
            }
            $oldPathImage = getFilePath('podcastEpisode');
            fileManager()->removeFile($oldPathImage.'/'.$episode->image_path.'/'.$episode->image);

            $bookmarks = Bookmark::where('episode_id', $episode->id)->delete();
    
            $podcast = Podcast::findOrFail($episode->podcast_id);
            $podcast->decrement('episode_count');
            $podcast->save();
            $episode->delete();
            $notify[]           = ['success', 'Episode deleted successfully.'];
            return back()->withNotify($notify);
        }else{
            $notify[]           = ['error', 'You are not allow to delete this episode.'];
            return back()->withNotify($notify);
        }

    }

    public function newEpisode()
    {
        $pageTitle = 'Upload New Episode';
        $podcasts  = Podcast::where('creator_id',auth()->user()->id)->get();
        return view($this->activeTemplate.'user.episode.create',compact('pageTitle','podcasts'));
    }

    public function createEpisode(Request $request)
    {
        if($request->file_type_select == 1){
            $request->validate([
                'link' => [

                    'regex:/^https?:\/\/[^\s\/$.?#].[^\s]*$/'
                ]
            ]);
        }
        else if($request->file_type_select == 2)
        {
            $request->validate([
                'filename' => 'nullable|mimetypes:audio/mpeg,audio/wav,audio/x-wav'
            ]);
        }
        else if($request->file_type_select == 3)
        {

            $request->validate([
                'filename' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime'
            ]);
        }


        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'image'         => ['nullable','image',new FileTypeValidate(['jpg', 'jpeg','png'])]

        ]);

        $episode                = new Episode();
        $episode->title         = $request->title;
        $episode->podcast_id    = $request->podcast_id;

        $podcast = Podcast::findOrFail($request->podcast_id);
        $podcast->increment('episode_count');
        $podcast->save();
        if($podcast->episode_count >= 5)
        {
            $podcast->verified = 1;
            $podcast->save();
        }



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

        if($request->hasFile('image')){
            try {
                $directory = date("Y")."/".date("m");
                $path       = getFilePath('podcastEpisode').'/'.$directory;
                $image = fileUploader($request->image, $path,getFileSize('podcastEpisode'));
                $episode->image = $image;
                $episode->image_path = $directory;
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        if($request->filename)
        {
            try{
                $directory          = date("Y")."/".date("m");
                $path               = getFilePath('podcastEpisode').'/'.$directory;
                $filename           = fileUploader($request->filename, $path);
                $episode->filename  = $filename;
                $episode->file_path = $directory;
            }catch(\Exception $exp){
                $notify[] = ['error', 'Couldn\'t upload your file'];
                return back()->withNotify($notify);
            }
        }

        $episode->description   = $request->description;

        if($request->is_special)
        {

            $episode->is_special   = 1;
        }else{

            $episode->is_special   = 0;
        }
        $episode->save();

        $notify[] = ['success','Episode upload successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function episodeUpdate(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'image'         => ['nullable','image',new FileTypeValidate(['jpg', 'jpeg','png'])],

        ]);

        $episode                = Episode::findOrFail($request->id);
        $episode->title         = $request->title;
        $episode->description   = $request->description;
        if($request->hasFile('image')){
            try {
                $directory      = date("Y")."/".date("m");
                $path           = getFilePath('podcastEpisode').'/'.$directory;
                $image          = fileUploader($request->image, $path,getFileSize('podcastEpisode'));
                $episode->image = $image;
                $episode->image_path  = $directory;

            } catch (\Exception $exp) {
                $notify[]       = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }


        $episode->save();
        $notify[]               = ['success','Episode Update Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function episodeList(Request $request)
    {
        $pageTitle  = " Episodes";
        $user = auth()->user();

        $episodes = Episode::orderBy('created_at','desc')->with('podcast')->whereHas('podcast', function ($query) use ($user){
                            $query->where('creator_id',$user->id);
        });

        $episodes = $episodes->paginate(getPaginate(10));

        return view($this->activeTemplate.'user.episode.list',compact('pageTitle','episodes'));
    }


    public function audio($id)
    {
        $pageTitle      = "Listen Episode";
        $episode        = Episode::with('podcast')->findOrFail($id);
        $episode->increment('listen_count');
        $extension      = pathinfo($episode->filename,PATHINFO_EXTENSION);

        return view($this->activeTemplate.'user.episode.audio',compact('pageTitle','episode','extension'));
    }


    public function bookmark($id) {

        if(auth()->check())
        {
            $userid = auth()->user()->id;
            $check = Bookmark::where('user_id', $userid)->where('episode_id', $id)->first();
            if ($check) {
                    $notify[] = ['error', 'Already has this episode in your bookmark list.'];
                    return back()->withNotify($notify);

                } else {
                    $data = new Bookmark();
                    $data->user_id = $userid;
                    $data->episode_id = $id;
                    $data->save();
                    $notify[] = ['success', 'Episode added to your bookmark list'];
                    return back()->withNotify($notify);
                }
            }
            else
            {

                $notify[] = ['error', 'You have to login first'];
                return back()->withNotify($notify);
            }

        }

    public function bookmarks()
    {
        $pageTitle  = "Listen Episode";
        $user = auth()->user();
        $bookmarks      = Bookmark::with('bookmark')->where('user_id', $user->id)->paginate(getPaginate(10));
        return view($this->activeTemplate.'user.bookmarks',compact('pageTitle','bookmarks'));
    }

    public function subscriberList()
    {
        $pageTitle  = "Subscriber List";
        $user = auth()->user();
        $subscriptionList          = Subscription::with('podcast', 'user')->whereHas('podcast', function ($query) use ($user){
            $query->where('creator_id',$user->id);
            })->paginate(getPaginate(10));
        return view($this->activeTemplate.'user.subscription_list',compact('pageTitle','subscriptionList'));
    }

    public function subscription()
    {
        $pageTitle  = "Subscription";
        $user       = auth()->user();

        $subscriptions = Subscription::where('user_id',$user->id)->with('podcast','user')->paginate(getPaginate(10));

        return view($this->activeTemplate.'user.subscription',compact('pageTitle','subscriptions'));

    }
}
