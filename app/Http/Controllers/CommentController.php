<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Activity;
use App\Models\Review;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use ApiResponses;

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:500',
            'review_id' => 'required|integer|exists:reviews,id'
        ]);

        $comment = Comment::create([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
            'review_id' => $request->input('review_id')
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'type' => 'comment',
            'activitable_type' => Comment::class,
            'activitable_id' => $comment->id
        ]);

        return $this->ok('Комментарий успешно добавлен!');

    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment->update([
            'body' => $request->input('body')
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
