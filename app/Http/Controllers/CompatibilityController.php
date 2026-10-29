<?php

namespace App\Http\Controllers;

use App\Services\Mbti\CompatibilityMatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompatibilityController extends Controller
{
    public function index(Request $request, CompatibilityMatcher $matcher): View|RedirectResponse
    {
        $left = strtoupper((string) $request->query('a', ''));
        $right = strtoupper((string) $request->query('b', ''));

        if ($left !== '' && $right !== '' && $matcher->allTypes()->contains('code', $left) && $matcher->allTypes()->contains('code', $right)) {
            return redirect()->route('compatibility.show', [$left, $right]);
        }

        return view('pages.compatibility.index', [
            'types' => $matcher->allTypes(),
            'selectedLeft' => $left ?: 'INFJ',
            'selectedRight' => $right ?: 'ENFP',
        ]);
    }

    public function show(string $left, string $right, CompatibilityMatcher $matcher): View
    {
        $pair = $matcher->pair($left, $right);

        return view('pages.compatibility.show', [
            'pair' => $pair,
            'overlap' => $matcher->dimensionOverlap($pair['type_a']->code, $pair['type_b']->code),
        ]);
    }
}
