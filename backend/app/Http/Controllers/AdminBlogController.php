<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\CustomerDetail;
use App\Models\Models\BlogPost;
use App\Notifications\RealTimeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;
use PhpParser\Node\Stmt\Echo_;

class AdminBlogController extends Controller
{
    public function index(Request $request){
        $request->validate([
            'postTitle' => 'required',
            'postContent' => 'required',
        ]);

        $b_post = new BlogPost();
        $b_post->created_by=  $request->Id;
        $b_post->title=  $request->postTitle;
        $b_post->content=  $request->postContent;
        $profile_picture = $request->hasFile('profile_picture');
       // $profile_picture = $request->file('selectedFile');
        if ($profile_picture) {
            $profile_picture = $request->file('profile_picture');
            $profilePictureWithExt = $profile_picture->getClientOriginalName();

            $random_value = Str::random(30);
            $profilePictureExtension = pathinfo($profilePictureWithExt, PATHINFO_EXTENSION);
            $profilePictureExtension = Str::lower($profilePictureExtension);
            $filenameProfilePicture = $random_value . '.' . $profilePictureExtension;

            $profile_picture_path = public_path('/assets/profile_picture/');
            if (!File::isDirectory($profile_picture_path)){
                File::makeDirectory($profile_picture_path, 777, true, true);
            }
            $profile_picture->storeAs('/public', $filenameProfilePicture);
            $img_link =  $this->getProfilePictureAttribute($filenameProfilePicture);
            $b_post->path =  $img_link;
           $b_post->photo = $filenameProfilePicture;
        }

        $b_post->save();

        $user = $request->Id;
        event(new PostCreated($b_post));

       // Event::listen(PostCreated::dispatch());
       // Notification::send($user, new RealTimeNotification("hello"));

        //$user->event(new PostCreated($b_post)) ;
       // $user->new PostCreated($b_post) ;
//        $user->notify(new RealTimeNotification($b_post)) ;
        return response()->json(['success']);

    }
    public function home_view_post(Request $request){
        //$blogPost= BlogPost::all();
        $blogPost= BlogPost::orderByDesc('id');
        $blogPost= $blogPost->paginate(3);
        return response()->json(['blogPost'=>$blogPost]);
    }

    public function view_post(Request $request){
       //$blogPost= BlogPost::all();
       $blogPost= BlogPost::orderByDesc('id');
       $blogPost= $blogPost->paginate(4);
        return response()->json(['blogPost'=>$blogPost]);
    }
    public function getProfilePictureAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        return url("/storage/{$value}");
    }
    public function delete_post(Request $request){
        $blog=  BlogPost::findOrFail($request->Id);
        $blog->delete();
    }
    public function update(Request $request) {
        $blogs_update= BlogPost::select(
            'blog_posts.id',
            'blog_posts.title',
            'blog_posts.content',
            'blog_posts.photo',
            'blog_posts.path',
        )
            ->leftjoin('users','users.id','blog_posts.created_by')
            ->where('blog_posts.id',$request->Id,)
            ->first();
        return response()->json(['blogs_update'=>$blogs_update]);

    }
    public function blog_update_confirm(Request $request) {
        $blog_update_confirm=  BlogPost::findOrFail($request->Id);
        $blog_update_confirm->title= $request->title;
        $blog_update_confirm->content= $request->bcontent;
        $profile_picture = $request->hasFile('update_blog_picture');
        // $profile_picture = $request->file('selectedFile');
        if ($profile_picture) {
            $profile_picture = $request->file('update_blog_picture');
            $profilePictureWithExt = $profile_picture->getClientOriginalName();

            $random_value = Str::random(30);
            $profilePictureExtension = pathinfo($profilePictureWithExt, PATHINFO_EXTENSION);
            $profilePictureExtension = Str::lower($profilePictureExtension);
            $filenameProfilePicture = $random_value . '.' . $profilePictureExtension;

            $profile_picture_path = public_path('/assets/profile_picture/');
            if (!File::isDirectory($profile_picture_path)){
                File::makeDirectory($profile_picture_path, 777, true, true);
            }
            $profile_picture->storeAs('/public', $filenameProfilePicture);
            $img_link =  $this->getProfilePictureAttribute($filenameProfilePicture);
            $blog_update_confirm->path =  $img_link;
            $blog_update_confirm->photo = $filenameProfilePicture;
        }
        $blog_update_confirm->save();

    }
}
