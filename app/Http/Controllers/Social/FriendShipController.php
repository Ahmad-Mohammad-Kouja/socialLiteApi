<?php

namespace App\Http\Controllers\Social;

use App\Classes\ResponseHelper;
use App\Enums\Social\FriendShipTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Social\FriendShips\deleteFriendShipRequest;
use App\Http\Requests\Social\FriendShips\sendFriendRequestRequest;
use App\Http\Requests\Social\FriendShips\updateFriendShipRequest;
use App\Models\Social\FriendShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FriendShipController extends Controller
{
    private $friendShip=null;

    /**
     * FriendShipController constructor.
     * @param FriendShip $friendShip
     */
    public function __construct(FriendShip $friendShip)
    {
        $this->friendShip=$friendShip;
    }

    public function sendFriendRequest(sendFriendRequestRequest $request)
    {
        $user=Auth::user();
        $friendShipData=$request->only('receiver_id');
        $friendShipData['sender_id']=$user->id;
        $addedFriendShip=$this->friendShip->createFriendShip($friendShipData);
        if(empty($addedFriendShip))
            return ResponseHelper::isEmpty('sending friend request fail');
        return ResponseHelper::insert('sending friend Request fail');
    }

    public function updatingFriendShip(updateFriendShipRequest $request)
    {
        $user=Auth::id();
        $friendShipData=$request->only('status');
        $userSenderId=$request->get('user_sender_id');
        $friendShipHistory=$this->friendShip->getFriendShip(['sender_id'=>$userSenderId,'receiver_id'=>$user->id]);
        if(empty($friendShipHistory))
            return ResponseHelper::notAuthorized('not authorized');

        if($friendShipHistory->status==FriendShipTypes::pending)
        {
            if($friendShipData['status']!=FriendShipTypes::accepted||$friendShipData['status']!=FriendShipTypes::rejected)
                return ResponseHelper::errorMissingParameter();
            if($friendShipData['status']==FriendShipTypes::rejected)
                $this->friendShip->deleteFriendShip($friendShipHistory->id);
        }
        $updatedFriendShip=$this->friendShip->updateFriendShip($friendShipHistory->id,$friendShipData);
        if(empty($updatedFriendShip))
            return ResponseHelper::isEmpty('updating friendShip fail');
        return ResponseHelper::update('updating friendShip success');
    }

    public function deletedFriendShip(deleteFriendShipRequest $request)
    {

        $user=Auth::id();
        $receiverId=$request->get('receiver_id');
        $friendShipHistory=$this->friendShip->getFriendShip(['sender_id'=>$user->id,'receiver_id'=>$receiverId]);
        if(empty($friendShipHistory))
            return ResponseHelper::notAuthorized('not authorized');
        $deletedFriendShip=$this->friendShip->deleteFriendShip($friendShipHistory->id);
        if(empty($deletedFriendShip))
            return ResponseHelper::isEmpty('deleting friendShip fail');
        return ResponseHelper::update('deleting friendShip success');
    }
}
