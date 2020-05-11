<?php

namespace App\Http\Controllers\Social;

use App\Classes\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Social\Reactions\ReactRequest;
use App\Models\Social\Reaction;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    private $reactions;

    /**
     * ReactionController constructor.
     * @param $reactions
     */
    public function __construct(Reaction $reactions)
    {
        $this->reactions = $reactions;
    }

    public function react(ReactRequest $request)
    {

        $user=Auth::user();
        $reaction=$request->only('post_id','reaction_type');
        $reaction['user_id'] = $user->id;
        $oldReaction=$this->reactions->getReactionWithTrashed(['user_id' => $reaction['user_id'],
            'post_id' => $reaction['post_id']]);

        if(empty($oldReaction))
            $react=$this->reactions->createReaction($reaction);
        else if(empty($oldReaction['deleted_at']) && $reaction['reaction_type'] != $oldReaction['reaction_type']
            && $this->authorize('update',$oldReaction))
                 $react=$this->reactions->updateReaction($reaction,$oldReaction['id']);
        else if(empty($oldReaction['deleted_at']) && $reaction['reaction_type'] == $oldReaction['reaction_type']
            && $this->authorize('delete',$oldReaction))
                 $react=$this->reactions->deleteReaction($oldReaction['id']);
        else if($this->authorize('restore',$oldReaction))
            $react=$this->reactions->restoreReact($oldReaction['id']);
         if(empty($react))
             return ResponseHelper::isEmpty('react fail');
         else return ResponseHelper::insert('react success');
    }


}
