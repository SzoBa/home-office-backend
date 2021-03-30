<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $path = config("app.readme");
        $file = base_path($path);
        return response()->download($file, "Readme.md");
    }
}
