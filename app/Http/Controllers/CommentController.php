<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Activity;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update([
            'body' => $request->input('body')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
