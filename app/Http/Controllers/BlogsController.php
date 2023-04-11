<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('blogs.index', [
            'blogs' => Blogs::with('user')->latest()->get(),
        ]);
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->blogs()->create($validated);

        return redirect(route('blogs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blogs $blogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blogs $blog): View
    {
        $this->authorize('update', $blog);

        return view('blogs.edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blogs $blog):RedirectResponse
    {
//        dd($blog,$request->all());

        $this->authorize('update', $blog);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $blog->update($validated);

        return redirect(route('blogs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blogs $blog):RedirectResponse
    {
        $this->authorize('delete', $blog);

        $blog->delete();

        return redirect(route('blogs.index'));
    }
}
