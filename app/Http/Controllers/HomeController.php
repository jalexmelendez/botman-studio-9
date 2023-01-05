<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->query("fullscreen")) {
            return view('index', [
                'welcome' => 'Hey! Im Botman, to start a conversation write "hi".',
            ]);
        }

        return view('welcome');
    }
}
