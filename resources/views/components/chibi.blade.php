@props(['type', 'size' => 128, 'decorative' => true])

@php
    $chibi = $type->chibi();
    $tone = $type->tonePalette();
    $hair = $chibi['hair'];
    $skin = $chibi['skin'];
    $outfit = $chibi['outfit'];
@endphp

<div
    @if ($decorative) aria-hidden="true" @else role="img" aria-label="Ilustrasi chibi {{ $type->code }} {{ $type->title }}" @endif
    style="width:{{ (int) $size }}px;max-width:100%;aspect-ratio:1 / 1;line-height:0;flex-shrink:0;"
>
    <svg viewBox="0 0 120 120" width="100%" height="100%" style="display:block;" xmlns="http://www.w3.org/2000/svg">
        {{-- Pastel backdrop --}}
        <rect x="1" y="1" width="118" height="118" rx="30" fill="{{ $tone['soft'] }}" />
        <circle cx="103" cy="17" r="30" fill="{{ $tone['base'] }}" opacity="0.35" />
        <circle cx="14" cy="106" r="24" fill="{{ $tone['base'] }}" opacity="0.28" />
        <circle cx="20" cy="22" r="2.4" fill="{{ $tone['deep'] }}" opacity="0.55" />
        <circle cx="29" cy="14" r="1.6" fill="{{ $tone['deep'] }}" opacity="0.4" />
        <circle cx="106" cy="99" r="2" fill="{{ $tone['deep'] }}" opacity="0.5" />

        {{-- Ground shadow --}}
        <ellipse cx="60" cy="112" rx="24" ry="3.5" fill="#2B2D42" opacity="0.08" />

        {{-- Body and hands --}}
        <circle cx="34" cy="98" r="6" fill="{{ $skin }}" />
        <circle cx="86" cy="98" r="6" fill="{{ $skin }}" />
        <rect x="55" y="68" width="10" height="12" rx="4" fill="{{ $skin }}" />
        <rect x="36" y="82" width="48" height="30" rx="15" fill="{{ $outfit }}" />
        <path d="M52 84 L60 92 L68 84" stroke="#FFF9F5" stroke-width="2.4" fill="none" stroke-linecap="round" stroke-linejoin="round" />
        <circle cx="60" cy="99" r="2" fill="#FFF9F5" opacity="0.85" />

        {{-- Head --}}
        <circle cx="36" cy="55" r="4" fill="{{ $skin }}" />
        <circle cx="84" cy="55" r="4" fill="{{ $skin }}" />
        <circle cx="60" cy="52" r="23" fill="{{ $skin }}" />

        {{-- Hair silhouette --}}
        @switch($chibi['hair_style'])
            @case('bob')
                <path d="M36 54c-1-16 10-27 24-27s25 11 24 27c-3-6-7-9-11-10-4-1-8-2-13-2s-9 1-13 2c-4 1-8 4-11 10z" fill="{{ $hair }}" />
                <rect x="33" y="46" width="8" height="30" rx="4" fill="{{ $hair }}" />
                <rect x="79" y="46" width="8" height="30" rx="4" fill="{{ $hair }}" />
                @break

            @case('long')
                <path d="M36 52c0-16 10-26 24-26s24 10 24 26c-2-7-7-10-11-11-4-1-8-2-13-2s-9 1-13 2c-4 1-9 4-11 11z" fill="{{ $hair }}" />
                <rect x="31" y="46" width="9" height="50" rx="4.5" fill="{{ $hair }}" />
                <rect x="80" y="46" width="9" height="50" rx="4.5" fill="{{ $hair }}" />
                @break

            @case('bun')
                <circle cx="60" cy="23" r="8" fill="{{ $hair }}" />
                <circle cx="60" cy="23" r="3" fill="{{ $tone['soft'] }}" opacity="0.6" />
                <path d="M37 52c0-15 10-25 23-25s23 10 23 25c-2-7-6-10-10-11-4-1-8-2-13-2s-9 1-13 2c-4 1-8 4-10 11z" fill="{{ $hair }}" />
                @break

            @case('ponytail')
                <circle cx="87" cy="43" r="8" fill="{{ $hair }}" />
                <circle cx="84" cy="43" r="2.2" fill="{{ $tone['soft'] }}" />
                <path d="M37 52c0-15 10-25 23-25s23 10 23 25c-2-7-6-10-10-11-4-1-8-2-13-2s-9 1-13 2c-4 1-8 4-10 11z" fill="{{ $hair }}" />
                @break

            @case('spiky')
                <path d="M36 52l4-10 5 5 4-11 5 7 4-10 5 9 5-7 4 10 6-5 3 12c-4-3-8-4-12-5-4-1-8-2-12-2-5 0-9 1-13 2-3 1-6 3-8 5z" fill="{{ $hair }}" />
                @break

            @case('messy')
                <path d="M37 51c0-14 9-24 23-24s23 10 23 24c-2-6-5-8-9-9l2-7-7 5-4-8-4 8-6-6-1 8c-5 1-13 3-17 9z" fill="{{ $hair }}" />
                @break

            @case('curly')
                <circle cx="43" cy="36" r="9" fill="{{ $hair }}" />
                <circle cx="60" cy="30" r="10" fill="{{ $hair }}" />
                <circle cx="77" cy="36" r="9" fill="{{ $hair }}" />
                <path d="M37 52c0-10 5-16 12-19 4 6 18 6 22 0 7 3 12 9 12 19-3-5-7-7-11-8-4-1-8-2-12-2s-8 1-12 2c-4 1-8 3-11 8z" fill="{{ $hair }}" />
                @break

            @default
                <path d="M37 52c-1-15 9-25 23-25s24 10 23 25c-2-7-6-9-9-10-4-1-8-2-14-2s-10 1-14 2c-3 1-7 3-9 10z" fill="{{ $hair }}" />
                <rect x="36" y="48" width="5" height="10" rx="2.5" fill="{{ $hair }}" />
                <rect x="79" y="48" width="5" height="10" rx="2.5" fill="{{ $hair }}" />
        @endswitch

        {{-- Face --}}
        <path d="M47 46.5q4-2 8 0" stroke="{{ $hair }}" stroke-width="1.6" fill="none" stroke-linecap="round" />
        <path d="M65 46.5q4-2 8 0" stroke="{{ $hair }}" stroke-width="1.6" fill="none" stroke-linecap="round" />
        <circle cx="51" cy="54" r="2.6" fill="#2B2D42" />
        <circle cx="69" cy="54" r="2.6" fill="#2B2D42" />
        <circle cx="51.9" cy="53.1" r="0.9" fill="#FFFFFF" />
        <circle cx="69.9" cy="53.1" r="0.9" fill="#FFFFFF" />
        <ellipse cx="45" cy="61" rx="4" ry="2.4" fill="#FFC8DD" opacity="0.8" />
        <ellipse cx="75" cy="61" rx="4" ry="2.4" fill="#FFC8DD" opacity="0.8" />
        <path d="M57 63q3 2.6 6 0" stroke="#2B2D42" stroke-width="1.6" fill="none" stroke-linecap="round" />

        @if ($chibi['glasses'])
            <g fill="none" stroke="#2B2D42" stroke-width="1.3">
                <circle cx="51" cy="54" r="6" />
                <circle cx="69" cy="54" r="6" />
                <path d="M57 54h6" />
                <path d="M45 53l-4-2M75 53l4-2" />
            </g>
        @endif

        {{-- Signature prop --}}
        @switch($chibi['prop'])
            @case('blueprint')
                <rect x="88" y="46" width="22" height="30" rx="3" fill="#FFF9F5" stroke="#2B2D42" stroke-width="1.6" />
                <path d="M92 53h14M92 58h14M92 63h9" stroke="#7FB6EE" stroke-width="1.8" stroke-linecap="round" />
                <circle cx="99" cy="69" r="3" fill="none" stroke="#A98FBB" stroke-width="1.4" />
                @break

            @case('atom')
                <g stroke="#2B2D42" stroke-width="1.5" fill="none">
                    <ellipse cx="100" cy="56" rx="12" ry="5" transform="rotate(-25 100 56)" />
                    <ellipse cx="100" cy="56" rx="12" ry="5" transform="rotate(25 100 56)" />
                </g>
                <circle cx="100" cy="56" r="2.6" fill="#2B2D42" />
                @break

            @case('flag')
                <path d="M93 42v54" stroke="#2B2D42" stroke-width="2.4" stroke-linecap="round" />
                <path d="M93 45l18 5-18 6z" fill="#FFC8DD" stroke="#2B2D42" stroke-width="1.4" stroke-linejoin="round" />
                @break

            @case('bulb')
                <circle cx="101" cy="50" r="10" fill="#FFF9F5" stroke="#2B2D42" stroke-width="1.6" />
                <rect x="97" y="58" width="8" height="5" rx="2" fill="#2B2D42" />
                <path d="M101 36v-4M88 44l-3-2M114 44l3-2M89 58l-3 2" stroke="#E8A8C4" stroke-width="1.8" stroke-linecap="round" />
                @break

            @case('lantern')
                <path d="M95 52c0-6 10-6 10 0" stroke="#2B2D42" stroke-width="1.6" fill="none" stroke-linecap="round" />
                <rect x="91" y="52" width="18" height="22" rx="4" fill="#EAF4FF" stroke="#2B2D42" stroke-width="1.6" />
                <path d="M96 54v18M106 54v18" stroke="#A2D2FF" stroke-width="1.2" />
                <circle cx="101" cy="63" r="4" fill="#FFC8DD" />
                @break

            @case('notebook')
                <rect x="89" y="54" width="21" height="28" rx="3" fill="#FFF0F5" stroke="#2B2D42" stroke-width="1.6" />
                <path d="M94 61h11M94 66h11M94 71h7" stroke="#CDB4DB" stroke-width="1.6" stroke-linecap="round" />
                <path d="M107 44l5 5" stroke="#565873" stroke-width="2.6" stroke-linecap="round" />
                @break

            @case('heart_banner')
                <path d="M94 42v54" stroke="#2B2D42" stroke-width="2.2" stroke-linecap="round" />
                <path d="M94 45h17v13H94z" fill="#CDB4DB" stroke="#2B2D42" stroke-width="1.4" stroke-linejoin="round" />
                <path d="M102 72c-4-3-7-5-7-8a3.4 3.4 0 016-2 3.4 3.4 0 016 2c0 3-3 5-5 8z" fill="#FFC8DD" stroke="#2B2D42" stroke-width="1.2" />
                @break

            @case('balloon')
                <ellipse cx="101" cy="44" rx="9" ry="11" fill="#FFC8DD" stroke="#2B2D42" stroke-width="1.4" />
                <path d="M101 55c2 4-2 6 0 10" stroke="#565873" stroke-width="1.2" fill="none" />
                <path d="M97 39c1-2 3-3 4-3" stroke="#FFF9F5" stroke-width="2" stroke-linecap="round" fill="none" />
                <path d="M110 30l1.4 3.4L115 35l-3.6 1.6L110 40l-1.4-3.4L105 35l3.6-1.6z" fill="#A2D2FF" />
                @break

            @case('tray')
                <path d="M92 60c0 4 2 6 2 6h12s2-2 2-6" fill="none" stroke="#2B2D42" stroke-width="1.6" stroke-linecap="round" />
                <rect x="95" y="54" width="10" height="9" rx="3" fill="#FFF9F5" stroke="#2B2D42" stroke-width="1.4" />
                <ellipse cx="100" cy="73" rx="15" ry="4.5" fill="#CDB4DB" stroke="#2B2D42" stroke-width="1.4" />
                <path d="M98 50c0-2 2-2 2-4M103 50c0-2 2-2 2-4" stroke="#A98FBB" stroke-width="1.3" stroke-linecap="round" fill="none" />
                @break

            @case('gavel')
                <g transform="rotate(-20 100 66)">
                    <rect x="88" y="57" width="20" height="9" rx="3" fill="#565873" stroke="#2B2D42" stroke-width="1.4" />
                    <rect x="98" y="66" width="5" height="19" rx="2.5" fill="#A98FBB" stroke="#2B2D42" stroke-width="1.2" />
                </g>
                <rect x="89" y="88" width="20" height="4" rx="2" fill="#2B2D42" />
                @break

            @case('shield')
                <path d="M100 49l12 4v10c0 8-6 13-12 16-6-3-12-8-12-16V53z" fill="#EAF4FF" stroke="#2B2D42" stroke-width="1.6" stroke-linejoin="round" />
                <path d="M100 60c-3-2-5-3-5-5a2.4 2.4 0 014.2-1.3A2.4 2.4 0 01104 55c0 2-1 3-4 5z" fill="#FFC8DD" />
                @break

            @case('paintbrush')
                <rect x="97" y="52" width="6" height="20" rx="3" fill="#565873" />
                <path d="M97 52h6l-3-7z" fill="#CDB4DB" />
                <rect x="97" y="72" width="6" height="5" rx="1.5" fill="#2B2D42" />
                <circle cx="108" cy="86" r="5" fill="#FFF9F5" stroke="#2B2D42" stroke-width="1.2" />
                <circle cx="107" cy="85" r="1.2" fill="#FFC8DD" />
                <circle cx="110" cy="88" r="1" fill="#A2D2FF" />
                @break

            @case('mic')
                <rect x="96" y="46" width="10" height="18" rx="5" fill="#565873" stroke="#2B2D42" stroke-width="1.4" />
                <path d="M92 60a9 9 0 0018 0" stroke="#2B2D42" stroke-width="1.8" fill="none" stroke-linecap="round" />
                <path d="M101 69v8M96 80h10" stroke="#2B2D42" stroke-width="1.8" stroke-linecap="round" />
                @break

            @case('clipboard')
                <rect x="89" y="52" width="21" height="28" rx="3" fill="#FFF9F5" stroke="#2B2D42" stroke-width="1.6" />
                <rect x="95" y="49" width="9" height="5" rx="2" fill="#CDB4DB" stroke="#2B2D42" stroke-width="1.2" />
                <path d="M93 60h13M93 66h13M93 72h8" stroke="#A98FBB" stroke-width="1.6" stroke-linecap="round" />
                @break

            @case('wrench')
                <g transform="rotate(30 100 64)">
                    <rect x="96" y="56" width="6" height="26" rx="3" fill="#565873" />
                    <path d="M95 56a7 7 0 0114 0l-4-2-3 5-3-5z" fill="#565873" stroke="#2B2D42" stroke-width="1" stroke-linejoin="round" />
                </g>
                @break

            @case('bolt')
                <path d="M104 39l-13 21h8l-3 17 14-22h-8z" fill="#A2D2FF" stroke="#2B2D42" stroke-width="1.6" stroke-linejoin="round" />
                @break

            @default
                <path d="M100 42l3.4 9.6L113 55l-9.6 3.4L100 68l-3.4-9.6L87 55l9.6-3.4z" fill="#CDB4DB" />
        @endswitch
    </svg>
</div>
