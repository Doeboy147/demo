<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Repositories\Post as PostRepository;
use Illuminate\Support\Facades\Auth;
use Laravel5Helpers\Exceptions\LaravelHelpersExceptions;

class Welcome extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        if (empty($query)) {
            $posts = $this->getRepository()->setResultOrder('created_at', 'DESC')->getByPageSize(2);
        } else {
            $posts = $this->getRepository()->search($query);
        }
        $data = [
            'posts' => $posts,
        ];
        return view('welcome', $data);
    }

    public function post($id)
    {
        try {
            $post = $this->getRepository()->getById($id);
            return view('post', ['post' => $post]);
        } catch (LaravelHelpersExceptions $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function like($id)
    {
        $post = $this->getRepository()->getResource($id);
        if (empty(Auth::user())) {
            return $this->ajaxWarning("You must to be logged in to like this post");
        }elseif (Auth::user()->uuid === $post->user_id) {
            return $this->ajaxWarning("You not allowed to like your own post");
        }
        $exist = Like::where(['user_id' => Auth::user()->uuid, 'post_id' => $id])->first();

        if (empty($exist)) {
            $like = new Like();
            $like->user_id = Auth::user()->uuid;
            $like->post_id = $id;
            $like->save();
            Like::where('user_id', Auth::user()->uuid)->increment('likes');
        }else {
            return $this->ajaxWarning("You liked this post already");
        }
        return $this->ajaxSuccess('Liked', false, true);
    }

    protected function getRepository()
    {
        return new PostRepository;
    }
}
