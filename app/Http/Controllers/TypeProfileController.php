<?php

namespace App\Http\Controllers;

use App\Models\MbtiType;
use App\Services\Mbti\CompatibilityMatcher;
use Illuminate\View\View;

class TypeProfileController extends Controller
{
    public function index(CompatibilityMatcher $matcher): View
    {
        return view('pages.types.index', [
            'types' => $matcher->allTypes(),
        ]);
    }

    public function show(MbtiType $mbtiType): View
    {
        return view('pages.types.show', [
            'type' => $mbtiType,
            'ranking' => $mbtiType->compatibilityRanking(),
        ]);
    }
}
