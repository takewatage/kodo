<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $posts = Post::query()
            ->with(['user'])
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Home', [
            'posts' => $posts,
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
    public function store(StoreGroupRequest $request)
    {
        //
    }
}
