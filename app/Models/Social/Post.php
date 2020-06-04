<?php

namespace App\Models\Social;


use App\Classes\FileClass;
use App\Enums\General\FileTypes;
use App\Enums\Social\ReactionTypes;
use App\Models\Clients\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes,CastsEnums;

    protected $table='posts';

    protected $fillable=['description','user_id','image','attachment','attachment_type'];

    protected $hidden=['deleted_at'];

    protected $dates= ['created_at','updated_at','deleted_at'];

    protected $enumCasts = [
        'attachment_type' => FileTypes::class,
    ];

    protected $appends = ['reacted'];

    protected $casts=[
        'user_id' => 'integer',
        'created_at' =>'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getReactedAttribute()
    {
        $reactStatus=$this->checkPostReactStatus($this->attributes['id'],$this->attributes['user_id']);
        return $this->attributes['reacted']= (empty($reactStatus)) ? false : $reactStatus->reaction_type;
    }

    public function setAttachmentTypeAttribute()
    {
        $url=$this->attributes['attachment'];
        if(!empty($url))
            $this->attributes['attachment_type']=FileClass::determineAttachmentType(FileClass::getExtensionFromUrl($url));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Reaction::class)
            ->where('reaction_type',ReactionTypes::like)
            ->join('users','users.id','=','reactions.user_id');
    }

    public function sad()
    {
        return $this->hasMany(Reaction::class)
            ->where('reaction_type',ReactionTypes::sad);
    }

    public function loves()
    {
        return $this->hasMany(Reaction::class)
            ->where('reaction_type',ReactionTypes::love);
    }

    public function angers()
    {
        return $this->hasMany(Reaction::class)
            ->where('reaction_type',ReactionTypes::anger);
    }

    public function laughs()
    {
        return $this->hasMany(Reaction::class)
            ->where('reaction_type',ReactionTypes::laugh);
    }
    public function wonder()
    {
        return $this->hasMany(Reaction::class)
            ->where('reaction_type',ReactionTypes::wonder);
    }



    public  function createPost($post)
    {
        return Post::create($post);
    }
    public  function getPosts(array $filter = [],$orderColumn = 'id',$orderType = 'ASC')
    {
        return Post::with([
            'likes' => function($like)
            {
            $like->with('user');
        }
        ,'loves' => function($love)
            {
            $love->with('user');
        }
        ,'sad' => function($sad)
            {
            $sad->with('user');
        }
        ,'angers' => function($anger)
            {
             $anger->with('user');
        }
        ,'laughs' => function($laugh)
            {
            $laugh->with('user');
        },'wonder' => function($laugh)
            {
                $laugh->with('user');
            },'comments'=> function($comment)
            {
                $comment->with('user');
            },'user'])
            ->withCount(['likes','loves','angers','sad','laughs','wonder'])
            ->when(count($filter) != 0 , function ($post) use ($filter)
            {
                return $post->where($filter)->first();
            },function ($posts) use ($orderColumn,$orderType)
            {
               return $posts->orderBy($orderColumn,$orderType)->get();
            });
    }

    public  function getPost(array $filter)
    {
        return Post::where($filter)
            ->first();
    }

    public  function getPostById($postId)
    {
        return Post::where('id',$postId)->first();

    }

    public  function updatePost($postId,$post)
    {
        return Post::where('id',$postId)
            ->update($post);
    }

    public  function deletePost($postId)
    {
        return Post::where('id',$postId)
            ->delete();
    }

    public function checkPostReactStatus($postId,$userId)
    {
        return Post::join('reactions','reactions.post_id','=','posts.id')
            ->where('reactions.user_id',$userId)
            ->where('posts.id',$postId)
            ->where('reactions.deleted_at',null)
            ->first();
    }

}
