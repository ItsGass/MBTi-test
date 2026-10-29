<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sertifikat {{ $result->final_mbti }} — {{ $userTest->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin:0;background:#FFF9F5;font-family:'Instrument Sans',system-ui,sans-serif;color:#2B2D42;">
    @php
        $palette = config('mbti.palette');
        $tone = $type?->tonePalette() ?? $palette['tones']['lilac'];
        $dimensionFills = [
            'EI' => $palette['tones']['lilac']['base'],
            'SN' => $palette['tones']['sky']['base'],
            'TF' => $palette['tones']['blush']['base'],
            'JP' => $palette['ink'],
        ];
        $careerList = collect($careers ?? [])->take(config('mbti.certificate.careers'));
        $matchList = collect($matches ?? [])->take(config('mbti.certificate.matches'));
    @endphp

    <div style="max-width:1200px;margin:0 auto;padding:22px 20px 44px;">
        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;padding:4px 0 18px;">
            <a href="{{ route('result.show', $userTest) }}"
               style="font-size:13px;color:#85879C;text-decoration:none;">← Kembali ke hasil</a>

            <div style="display:flex;align-items:center;gap:10px;">
                <span id="certificate-status" style="font-size:12px;color:#85879C;">Siap diunduh · 1200 × 850</span>
                <button type="button" id="certificate-download"
                        style="appearance:none;border:0;border-radius:999px;background:#2B2D42;color:#FFF9F5;padding:12px 22px;font-size:13px;font-weight:600;cursor:pointer;">
                    Unduh PNG
                </button>
            </div>
        </div>

        <div data-certificate-viewport style="width:100%;overflow:hidden;">
            <div data-certificate-scale style="transform-origin:top center;">
                <div id="certificate"
                     data-width="{{ config('mbti.certificate.width') }}"
                     data-height="{{ config('mbti.certificate.height') }}"
                     data-scale="{{ config('mbti.certificate.scale') }}"
                     data-file="MBTI-Insight-{{ $result->final_mbti }}-{{ Str::slug($userTest->name) }}.png"
                     style="position:relative;width:{{ config('mbti.certificate.width') }}px;height:{{ config('mbti.certificate.height') }}px;box-sizing:border-box;padding:34px;background:#FFF9F5;overflow:hidden;">

                    {{-- Decorative pastel background --}}
                    <div style="position:absolute;top:-186px;right:-96px;width:310px;height:310px;border-radius:50%;background:#CDB4DB;opacity:0.30;"></div>
                    <div style="position:absolute;bottom:-150px;left:-104px;width:300px;height:300px;border-radius:50%;background:#FFC8DD;opacity:0.28;"></div>

                    <svg viewBox="0 0 1200 220" width="1200" height="220" style="position:absolute;left:0;bottom:0;" aria-hidden="true">
                        <path d="M0 150 C 220 70 380 210 620 140 S 980 60 1200 120 L1200 220 L0 220 Z" fill="#A2D2FF" opacity="0.16" />
                        <path d="M0 190 C 260 120 460 230 760 170 S 1040 110 1200 160 L1200 220 L0 220 Z" fill="#FFC8DD" opacity="0.18" />
                    </svg>

                    <div style="position:absolute;top:16px;left:16px;right:16px;bottom:16px;border:1px solid #E8DAD0;border-radius:24px;"></div>

                    <div style="position:relative;z-index:2;display:flex;flex-direction:column;height:100%;justify-content:space-between;box-sizing:border-box;">

                        {{-- Header --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;height:48px;">
                            <div style="display:flex;align-items:center;">
                                <div style="width:36px;height:36px;border-radius:12px;background:#2B2D42;color:#FFF9F5;font-size:16px;font-weight:700;display:flex;align-items:center;justify-content:center;">M</div>
                                <div style="margin-left:12px;">
                                    <div style="font-size:14px;font-weight:600;letter-spacing:-0.2px;line-height:1.2;">MBTI Insight</div>
                                    <div style="margin-top:2px;font-size:9px;color:#85879C;letter-spacing:2.4px;">KENALI DIRIMU</div>
                                </div>
                            </div>

                            <div style="text-align:right;">
                                <div style="font-size:10px;letter-spacing:3.4px;color:#85879C;font-weight:600;">SERTIFIKAT HASIL TES</div>
                                <div style="margin-top:4px;font-size:10px;color:#85879C;">No. {{ strtoupper(substr($result->userTest->token, -10)) }}</div>
                            </div>
                        </div>

                        {{-- Identity + chibi --}}
                        <div style="display:flex;align-items:stretch;justify-content:space-between;height:230px;">
                            <div style="width:730px;display:flex;flex-direction:column;justify-content:center;min-width:0;">
                                <div style="font-size:10px;letter-spacing:4px;color:#85879C;font-weight:600;">DIBERIKAN KEPADA</div>

                                <div style="margin-top:8px;height:50px;font-size:42px;line-height:1.1;font-weight:600;letter-spacing:-0.6px;white-space:nowrap;">
                                    {{ Str::limit($userTest->name, config('mbti.certificate.name_limit')) }}
                                </div>

                                <div style="margin-top:6px;font-size:12px;color:#85879C;">
                                    <span>{{ $userTest->age ? 'Usia '.$userTest->age.' tahun' : 'Usia tidak diisi' }}</span>
                                    <span style="margin:0 9px;color:#D8C8BE;">|</span>
                                    <span>Tes selesai {{ $userTest->completed_at->translatedFormat('d F Y') }}</span>
                                    <span style="margin:0 9px;color:#D8C8BE;">|</span>
                                    <span>Kekuatan sinyal {{ $result->clarity }}%</span>
                                </div>

                                <div style="margin-top:18px;display:flex;align-items:flex-end;">
                                    <div style="font-size:92px;line-height:0.82;font-weight:700;letter-spacing:-4px;color:{{ $tone['deep'] }};">
                                        {{ $result->final_mbti }}
                                    </div>

                                    <div style="margin-left:20px;padding-bottom:6px;min-width:0;">
                                        <div style="font-size:25px;line-height:1.15;font-weight:600;color:#2B2D42;">
                                            {{ Str::limit($type?->title ?? 'Tipe '.$result->final_mbti, 30) }}
                                        </div>
                                        <div style="margin-top:4px;font-size:10px;letter-spacing:3px;color:#85879C;">
                                            {{ strtoupper($type?->alias ?? 'MBTI TYPE') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="position:relative;width:330px;height:230px;display:flex;align-items:center;justify-content:center;">
                                <div style="position:absolute;width:224px;height:224px;border-radius:50%;background:{{ $tone['base'] }};opacity:0.20;"></div>
                                @if ($type)
                                    <div style="position:relative;">
                                        <x-chibi :type="$type" :size="212" />
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Dimensions, careers, matches --}}
                        <div style="display:flex;justify-content:space-between;height:340px;">

                            <div style="width:31.8%;height:100%;box-sizing:border-box;padding:20px;border:1px solid #EDE0D8;border-radius:20px;background:#FFFFFF;display:flex;flex-direction:column;">
                                <div style="font-size:10px;letter-spacing:2.4px;color:#85879C;font-weight:600;">EMPAT DIMENSI</div>

                                <div style="margin-top:14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                    @foreach ($breakdown as $dimension => $data)
                                        <div>
                                            <div style="display:flex;align-items:baseline;justify-content:space-between;">
                                                <span style="font-size:10px;letter-spacing:1.6px;color:#85879C;">
                                                    {{ strtoupper(config('mbti.dimensions.'.$dimension.'.title')) }}
                                                </span>
                                                <span style="font-size:11px;font-weight:600;color:#2B2D42;">
                                                    {{ $data['left'] }} {{ $data['left_score'] }}%
                                                    <span style="color:#C4B8AF;font-weight:400;">·</span>
                                                    {{ $data['right'] }} {{ $data['right_score'] }}%
                                                </span>
                                            </div>

                                            <div style="margin-top:7px;height:8px;border-radius:99px;background:#F2E6DE;overflow:hidden;">
                                                <div style="height:8px;width:{{ $data['left_score'] }}%;border-radius:99px;background:{{ $dimensionFills[$dimension] ?? '#CDB4DB' }};"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div style="width:33.2%;height:100%;box-sizing:border-box;padding:20px;border:1px solid #EDE0D8;border-radius:20px;background:#FFFFFF;display:flex;flex-direction:column;">
                                <div style="font-size:10px;letter-spacing:2.4px;color:#85879C;font-weight:600;">REKOMENDASI KARIER</div>

                                <div style="margin-top:14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                    @foreach ($careerList as $career)
                                        <div style="display:flex;align-items:center;height:52px;{{ $loop->last ? '' : 'border-bottom:1px solid #F2E6DE;' }}">
                                            <span style="width:7px;height:7px;border-radius:50%;background:{{ $tone['base'] }};flex-shrink:0;"></span>
                                            <span style="margin-left:10px;font-size:12px;line-height:1.35;color:#2B2D42;">
                                                {{ Str::limit($career, config('mbti.certificate.career_limit')) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div style="width:33.2%;height:100%;box-sizing:border-box;padding:20px;border:1px solid #EDE0D8;border-radius:20px;background:#FFFFFF;display:flex;flex-direction:column;">
                                <div style="font-size:10px;letter-spacing:2.4px;color:#85879C;font-weight:600;">PALING COCOK</div>

                                <div style="margin-top:14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                    @forelse ($matchList as $match)
                                        <div style="display:flex;align-items:center;justify-content:space-between;height:66px;{{ $loop->last ? '' : 'border-bottom:1px solid #F2E6DE;' }}">
                                            <div style="min-width:0;padding-right:8px;">
                                                <div style="font-size:14px;font-weight:600;color:#2B2D42;">
                                                    {{ $match['code'] }}
                                                    <span style="font-weight:400;color:#565873;">· {{ Str::limit($match['title'], 18) }}</span>
                                                </div>
                                                <div style="margin-top:2px;font-size:9px;letter-spacing:1.4px;color:#85879C;">
                                                    {{ strtoupper($match['label'] ?? 'KECOCOKAN') }}
                                                </div>
                                            </div>

                                            <div style="flex-shrink:0;padding:5px 10px;border-radius:99px;background:{{ $tone['soft'] }};font-size:11px;font-weight:700;color:#2B2D42;">
                                                {{ $match['score'] }}%
                                            </div>
                                        </div>
                                    @empty
                                        <div style="font-size:11px;color:#85879C;">Data kecocokan belum tersedia.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div style="height:64px;box-sizing:border-box;padding-top:14px;border-top:1px solid #EDE0D8;display:flex;align-items:flex-start;justify-content:space-between;">
                            <div>
                                <div style="font-size:9px;letter-spacing:2.4px;color:#85879C;">DITERBITKAN</div>
                                <div style="margin-top:4px;font-size:13px;color:#2B2D42;">
                                    {{ $userTest->completed_at->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <div style="text-align:right;max-width:540px;">
                                <div style="font-size:10px;line-height:1.5;color:#85879C;">
                                    Hasil ini bersifat reflektif dan bukan diagnosis psikologis.
                                    Skor {{ $result->scoring_version }} · kekuatan sinyal {{ $result->clarity }}%.
                                </div>
                                <div style="margin-top:4px;font-size:9px;letter-spacing:1.6px;color:#B9AFA6;">
                                    MBTI-INSIGHT · {{ strtoupper(substr($result->userTest->token, 0, 12)) }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
