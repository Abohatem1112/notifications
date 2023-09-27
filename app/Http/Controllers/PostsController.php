<?php

namespace App\Http\Controllers;

use App\Models\posts;
use App\Models\User;
use App\Notifications\CreatePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post=posts::create([
            'title'=>$request->title,
            'body'=>$request->body,

        ]);
        $users= User::where('id','!=',auth()->user()->id)->get();
        $user_create = auth()->user()->name;
        Notification::send($users,new CreatePost($post->id,$user_create,$post->title));
        return redirect()->route('dashboard');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       $post=posts::findorFail($id);
       $getID= DB::table('notifications')->where('data->post_id',$id)->pluck('id');
       DB::table('notifications')->where('id',$getID)->update(['read_at'=>now()]);
       return $post;



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(posts $posts)
    {
        //
    }
    public function markasread($id)
    {
        $user=User::find(auth()->user()->id);
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return redirect()->back();

    }
}
