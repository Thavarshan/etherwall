<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\Category;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(?string $name = null)
    {
        $user = User::whereName($name)->first();

        return Inertia::render('Threads/Index', [
            'threads' => Thread::latest()
                ->when($user, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['user', 'category'])
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Threads/Create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreThreadRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThreadRequest $request)
    {
        $thread = Thread::create($request->validated());

        return response()->redirectToRoute('threads.show', $thread, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        $thread->load(['replies', 'user', 'category']);

        return Inertia::render('Threads/Show', ['thread' => $thread]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        return Inertia::render('Threads/Edit', $thread);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateThreadRequest $request
     * @param \App\Models\Thread                     $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        $thread->update($request->validated());

        $thread->fresh();

        return response()->redirectToRoute('threads.show', $thread);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return response()->redirectToRoute('threads.index');
    }
}
