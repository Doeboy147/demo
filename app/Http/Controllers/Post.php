<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Definitions\Post as Definition;
use App\Repositories\Post as Repository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravel5Helpers\Exceptions\LaravelHelpersExceptions;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class Post extends Controller
{
    public function save(Request $request)
    {
        try {
            $request->validate([
                'title'  =>  ['required', 'string', 'max:255'],
                'body'    => ['required', 'string', 'max:5000'],
                'user_id' => ['required', 'string', 'max:255', 'exists:users,uuid']
            ]);
            if ($request->hasFile('imageFile')) {
                $path = public_path('images/posts');
                $request['image'] = $this->uploadFile($request['imageFile'], $path);
            }
            $this->getRepository()->createResource($this->getDefinition($request->all()));
            return $this->ajaxSuccess('Post created successfully', false, true);
        } catch (LaravelHelpersExceptions $exception) {
            return $this->ajaxError($exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $post = $this->getRepository()->getResource($id);
            return view('posts.edit', ['post' => $post]);
        }catch (LaravelHelpersExceptions $exception){
            return $this->ajaxError($exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = $this->getRepository()->getResource($id);
            if ($request->hasFile('imageFile')){
                $path = public_path('images/posts');
                $request['image'] = $this->uploadFile($request['imageFile'], $path);
                $this->deleteFile($post->getImagePath());
            }else{
                $request['image'] = $post->image;
            }
            $request['user_id'] = $post->user_id;
            $this->getRepository()->editResource($this->getDefinition($request->all()), $id);
            return $this->ajaxSuccess('Post updated successfully', false, true);
        } catch (LaravelHelpersExceptions $exception) {
            return $this->ajaxError($exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $post = $this->getRepository()->getResource($id);
            $this->deleteFile($post->getImagePath());
            $this->getRepository()->deleteResource($post->uuid);
            return $this->ajaxSuccess('Post removed successfully');
        }catch (LaravelHelpersExceptions $exception){
            return $this->ajaxError($exception->getMessage());
        }
    }

    protected function uploadFile($file, $filePath)
    {
        try {
            if (!File::exists($filePath)) {
                File::makeDirectory($filePath, 0777, true, true);
            }
            $fileName = Str::random(24) . '.' . $file->getClientOriginalExtension();
            $file->move($filePath, $fileName);
            return $fileName;
        } catch (UploadException $exception) {
            return $this->ajaxError($exception->getMessage());
        }
    }

    protected function deleteFile($path)
    {
        try {
            if (File::exists($path)){
                return File::delete($path);
            }
            return false;
        }catch (FileException $exception){
            return $this->ajaxError($exception->getMessage());
        }
    }

    protected function getRepository()
    {
        return new Repository;
    }

    protected function getDefinition($post)
    {
        return new Definition($post);
    }
}
