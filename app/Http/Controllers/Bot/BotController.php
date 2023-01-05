<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;

/**
 * This is the base Bot controller,
 * it has to be inherited and extended.
 */
class BotController extends Controller
{
    protected $botman;

    public function __construct()
    {
        $this->botman = app('botman');
    }
}