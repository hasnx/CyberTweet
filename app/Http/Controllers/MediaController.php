<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:5120'
        ]);

        $path = $request->file('file')->store('public/media');

        return response()->json([
            'url' => Storage::url($path)
        ]);
    }
}
