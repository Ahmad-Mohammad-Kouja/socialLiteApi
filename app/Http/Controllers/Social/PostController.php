<?php

namespace App\Http\Controllers\Social;

use App\Classes\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Social\Posts\CreatePostRequest;
use App\Http\Requests\Social\Posts\deletePostRequest;
use App\Http\Requests\Social\Posts\GetPostRequest;
use App\Http\Requests\Social\Posts\UpdatePostRequest;
use App\Models\Social\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{


    private $posts;

    /**
     * PostController constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->posts = $post;
    }


    public  function create(CreatePostRequest $request)
    {
        $user=Auth::user();
        $post=$request->only('description','attachment');
        $post['attachment_type']=$request->get('attachment_type',null);// for setter to work
        $post['user_id']=$user->id;
        $post=$this->posts->createPost($post);

        if(empty($post))
            return ResponseHelper::isEmpty('posting fail');
        return ResponseHelper::insert($post->refresh());
    }

    public  function update(UpdatePostRequest $request)
    {

        $user=Auth::user();
        $postId=$request->get('post_id');
        $post=$this->posts->getPost(['id' => $postId , 'user_id' => $user->id]);

       $this->authorize('update',$post);

        $updatedPost['description']=$request->get('description',$post['description']);
        $updatedPost['attachment']=$request->get('attachment',$post['attachment']);
        $updatedPost['attachment_type']=$request->get('attachment_type',$post['attachment_type']);
        $updatedPost=$this->posts->updatePost($postId,$updatedPost);
        if(empty($updatedPost))
            return ResponseHelper::isEmpty('updating fail');
        $post->refresh();
        return ResponseHelper::insert($post);
    }

    public function get(GetPostRequest $request)
    {
        $postId=$request->get('post_id',0);
        $filter= (empty($postId)) ? [] : ['id' => $postId];
        return ResponseHelper::select($this->posts->getPosts($filter,'id','desc'));
    }

    public function delete(deletePostRequest $request)
    {
        $this->authorize('delete',$this->posts->getPostById([$request->get('post_id')]));
        $deletedPost=$this->posts->deletePost($request->get('post_id'));
        if(empty($deletedPost))
            return ResponseHelper::isEmpty('deleting fail');
        return ResponseHelper::delete('deleting success');
    }

}
