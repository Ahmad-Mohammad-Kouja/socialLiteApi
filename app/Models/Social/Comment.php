<?php

namespace App\Models\Social;

use App\Models\Clients\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table='comments';

    protected $fillable=['user_id','post_id','description'];

    protected $hidden=['updated_at','deleted_at'];

    protected $dates=['created_at','updated_at','deleted_at'];

    protected $casts=[
        'user_id' => 'integer',
        'post_id' => 'integer',
        'created_at' =>'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
        ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }



    public  function createComment($comment)
    {
       return Comment::create($comment);
    }

    public function getCommentById($commentId)
    {
        return Comment::where('id',$commentId)->first();
    }

    public function getComment(array $filter)
    {
        return Comment::where($filter)
                ->first();
    }


    public function updateComment($comment,$commentId)
    {
        return Comment::where('id',$commentId)
            ->update($comment);
    }

    public function deleteComment($commentId)
    {
        return Comment::where('id',$commentId)
            ->delete();
    }




}
