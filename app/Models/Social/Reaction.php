<?php

namespace App\Models\Social;



use App\Enums\Social\ReactionTypes;
use App\Models\Clients\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reaction extends Model
{
    use SoftDeletes,CastsEnums;

    protected $table ='reactions';

    protected $fillable=['user_id','post_id','reaction_type'];

    protected $hidden=['created_at','updated_at','deleted_at'];

    protected $enumCasts = [
        'reaction_type' => ReactionTypes::class,
        ];

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public  function createReaction($reaction)
    {
        return Reaction::create($reaction);
    }

    public function getReactionById($reactionId)
    {
        return Reaction::find($reactionId)->first();
    }



    public function getReaction(array $filter)
    {
        return Reaction::where($filter)
            ->first();
    }

    public function getReactionWithTrashed(array $filter)
    {
        return Reaction::where($filter)
            ->withTrashed()->latest()->first();
    }

    public function updateReaction($reaction,$reactionId)
    {
        return Reaction::where('id',$reactionId)
            ->update($reaction);
    }

    public function deleteReaction($reactionId)
    {
        return Reaction::where('id',$reactionId)->delete();
    }

    public function restoreReact($reactionId)
    {
        return Reaction::where('id',$reactionId)->restore();
    }
}
