<?php

namespace App\Http\Controllers\Social;


use App\Classes\ResponseHelper;
use App\Http\Controllers\Controller;;
use App\Http\Requests\Social\Comments\AddCommentRequest;
use App\Http\Requests\Social\Comments\DeleteCommentRequest;
use App\Http\Requests\Social\Comments\UpdateCommentRequest;
use App\Models\Social\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    private $comments;

    /**
     * CommentController constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comments=$comment;
    }

    public function add(AddCommentRequest $request)
    {
        $user=Auth::user();
        $comment=$request->only('post_id','description');
        $comment['user_id']=$user->id;
        $newComment=$this->comments->createComment($comment);
        if(empty($newComment))
            return ResponseHelper::isEmpty('commenting fail');
        return ResponseHelper::insert($newComment->refresh());
    }

    public function update(UpdateCommentRequest $request)
    {
        $commentId=$request->get('comment_id');
        $comment=$this->comments->getCommentById($commentId);
        $this->authorize('update',$comment);
        $updatedComment=$request->only('description');

        $updatedComment=$this->comments->updateComment($updatedComment,$commentId);
        if(empty($updatedComment))
            return ResponseHelper::isEmpty('updating fail');
        return ResponseHelper::update($comment->refresh());
    }

    public function delete(DeleteCommentRequest $request)
    {
        $this->authorize('delete',$this->comments->getCommentById($request->get('comment_id')));

        $commentId=$request->get('comment_id');
        $deletedComment=$this->comments->deleteComment($commentId);

        if(empty($deletedComment))
            return ResponseHelper::isEmpty('deleting fail');
        return ResponseHelper::delete('deleting success');
    }
}
