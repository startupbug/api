<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Post;

class UserController extends Controller
{
    //

    public function register(Request $request){
    	$user = User::create([
    		'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'address' => $request->address,
            'password' => bcrypt($request->password),
        ]);
    	return \Response()->json(['user' => $user]);
    }


    public function all_users(){
    	$users = User::all();
        return \Response()->json(['users' => $users]);
    }


    public function login(Request $request){

        $users = User::where('email' , $request->email)->first();
        if ($users) {
            if (Hash::check($request->password, $users->password)) {
                return \Response()->json(['access_token' => bcrypt($request->email), 'user' => $users]);
            }
            else {
              return \Response()->json('unauthorize');
            }
        }
        else {
          return \Response()->json('unauthorize');
        }
    }

    public function post(Request $request){
        define('UPLOAD_DIR', 'photos/');
        $img = $request->image['value'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . base64_encode($request->image['filename'].\Carbon\Carbon::now()) . '.'.explode('/',$request->image['filetype'])[1];
        $success = Storage::put($file, $data);

        $post = Post::create([
            'message' => $request->message,
            'title' => $request->title,
            'image' => $file,
        ]);
        return \Response()->json(['post' => $post]);

      
    }

    public function posts_all(){
        $posts = Post::all();
        return \Response()->json(['posts' => $posts]);
    }

    public function post_single($id){
        $post = Post::find($id);
        return \Response()->json(['post' => $post]);

    }

}
