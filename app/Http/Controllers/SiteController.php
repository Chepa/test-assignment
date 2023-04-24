<?php

namespace App\Http\Controllers;

use App\Enums\Language;

final class SiteController extends Controller
{
    public function __invoke()
    {
        return view('app', ['languages' => Language::toArray()]);
    }
}
