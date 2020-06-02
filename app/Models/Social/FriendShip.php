<?php

namespace App\Models\Social;

use App\Enums\Social\FriendShipTypes;
use App\Models\Clients\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendShip extends Model
{

    use SoftDeletes,CastsEnums;

    protected $table='friend_ships';

    protected $fillable=['sender_id','receiver_id','status'];

    protected $hidden=['deleted_at'];

    protected $dates= ['created_at','updated_at','deleted_at'];

    protected $enumCasts = [
        'status' => FriendShipTypes::class,
    ];

    protected $casts=[
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'created_at' =>'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function senderUser()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }


    public  function createFriendShip($friendShip)
    {
        return FriendShip::create($friendShip);
    }

    public  function updateFriendShip($friendShipId,$friendShip)
    {
        return FriendShip::where('id',$friendShipId)
            ->update($friendShip);
    }

    public  function deleteFriendShip($friendShipId)
    {
        return FriendShip::where('id',$friendShipId)
            ->delete();
    }

    public  function getFriendShip($filter)
    {
        return FriendShip::where($filter)->first();
    }
}
