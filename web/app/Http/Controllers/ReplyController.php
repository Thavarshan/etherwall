<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreReplyRequest $request
     * @param \App\Models\Thread                   $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReplyRequest $request, Thread $thread)
    {
        $request->user()
            ->replies()
            ->create(array_merge($request->validated(), [
                'thread_id' => $thread->id,
            ]));

        return redirect(route('threads.show', $thread));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateReplyRequest $request
     * @param \App\Models\Reply                     $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
    }
}
