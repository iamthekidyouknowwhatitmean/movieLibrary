<?php

namespace App\Http\Filters;
use Illuminate\Support\Facades\Auth;

class ActivitiesFilter extends QueryFilter
{
    public function mine(){
        $authUser = Auth::user();
        $this->builder
            ->selectRaw('activities.id,activities.user_id')
            ->where('activities.user_id',$authUser->id)
            ->orderByDesc('activities.created_at');
    }

    public function friends(){
        $authUser = Auth::user();
        $this->builder
            ->selectRaw('activities.id,activities.user_id')
            ->join('network','network.following_id','=','activities.user_id')
            ->orderByDesc('activities.created_at');
    }

    public function all(){
        $authUser = Auth::user();

        $this->builder
            ->where(function ($query) use ($authUser) {
                $query->where('activities.user_id', $authUser->id)
                    ->orWhereIn('activities.user_id', function ($sub) use ($authUser) {
                        $sub->select('following_id')
                            ->from('network')
                            ->where('user_id', $authUser->id);
                    });
            })
            ->orderByDesc('activities.created_at');
    }
}
