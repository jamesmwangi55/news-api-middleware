<?php

namespace App\Http\Controllers;

use App\Source;

class SourceController extends Controller
{
    public function index()
    {
        return Source::all();
    }
}
