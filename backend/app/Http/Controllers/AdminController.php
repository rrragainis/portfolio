<?php

namespace App\Http\Controllers;

use App\Models\Photoshop;
use App\Models\Audio;
use App\Models\Programming;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $photoshops = Photoshop::all();
        $audios = Audio::all();
        $programmings = Programming::with('pictures')->get();

        return view('admin.index', compact('photoshops', 'audios', 'programmings'));
    }
} 