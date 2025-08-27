<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Dok/index');
    }
}
