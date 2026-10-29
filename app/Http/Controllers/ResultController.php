<?php

namespace App\Http\Controllers;

use App\Models\UserTest;
use App\Services\Mbti\CompatibilityMatcher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultController extends Controller
{
    public function show(Request $request, UserTest $userTest, CompatibilityMatcher $matcher): View
    {
        $result = $userTest->result()->with('mbtiType')->firstOrFail();
        $type = $result->mbtiType;

        return view('pages.result.show', [
            'userTest' => $userTest,
            'result' => $result,
            'type' => $type,
            'breakdown' => $result->dimensionBreakdown(),
            'matches' => $type ? $matcher->bestMatches($type->code) : collect(),
        ]);
    }

    public function certificate(UserTest $userTest, CompatibilityMatcher $matcher): View
    {
        $result = $userTest->result()->with('mbtiType')->firstOrFail();
        $type = $result->mbtiType;

        return view('pages.result.certificate', [
            'userTest' => $userTest,
            'result' => $result,
            'type' => $type,
            'breakdown' => $result->dimensionBreakdown(),
            'careers' => $type
                ? collect($type->careers)->take((int) config('mbti.certificate.careers'))
                : collect(),
            'matches' => $type
                ? $matcher->bestMatches($type->code, (int) config('mbti.certificate.matches'))
                : collect(),
        ]);
    }
}
