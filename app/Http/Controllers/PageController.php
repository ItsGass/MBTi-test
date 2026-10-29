<?php

namespace App\Http\Controllers;

use App\Services\Mbti\CompatibilityMatcher;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(CompatibilityMatcher $matcher): View
    {
        return view('pages.home', [
            'types' => $matcher->allTypes(),
            'spotlight' => $matcher->pair('INFJ', 'ENFP'),
        ]);
    }
}
