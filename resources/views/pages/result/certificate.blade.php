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
    <div style="max-width:1200px;margin:0 auto;padding:24px 20px 48px;">
        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;padding:8px 0 20px;">
            <a href="{{ route('result.show', $userTest) }}"
               style="font-size:13px;color:#85879C;text-decoration:none;">← Kembali ke hasil</a>

            <div style="display:flex;align-items:center;gap:10px;">
                <span id="certificate-status" style="font-size:12px;color:#85879C;">Siap diunduh</span>
                <button type="button" id="certificate-download"
                        style="appearance:none;border:0;border-radius:999px;background:#2B2D42;color:#FFF9F5;padding:12px 22px;font-size:13px;font-weight:600;cursor:pointer;">
                    Unduh PNG
                </button>
            </div>
        </div>

        <div data-certificate-viewport style="width:100%;overflow:hidden;">
            <div data-certificate-scale style="transform-origin:top center;">
                <div id="certificate"
                     data-file="MBTI-Insight-{{ $result->final_mbti }}-{{ Str::slug($userTest->name) }}.png"
                     style="position:relative;width:1200px;height:1600px;box-sizing:border-box;padding:64px;background:#FFF9F5;overflow:hidden;">

                    <div style="position:absolute;top:-140px;right:-120px;width:460px;height:460px;border-radius:50%;background:#EFE9FE;"></div>
                    <div style="position:absolute;bottom:-160px;left:-120px;width:420px;height:420px;border-radius:50%;background:#FDEAF4;"></div>
                    <div style="position:absolute;top:260px;right:-60px;width:200px;height:200px;border-radius:50%;background:#E6F0FE;opacity:0.85;"></div>

                    <div style="position:absolute;inset:28px;border:1px solid #EADFD5;border-radius:32px;"></div>

                    <div style="position:relative;z-index:2;display:flex;flex-direction:column;height:100%;box-sizing:border-box;padding:56px;">

                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:24px;">
                            <div style="display:flex;align-items:center;gap:14px;">
                                <div style="width:44px;height:44px;border-radius:14px;background:#2B2D42;color:#FFF9F5;font-size:18px;font-weight:700;display:flex;align-items:center;justify-content:center;">M</div>
                                <div>
                                    <div style="font-size:16px;font-weight:600;letter-spacing:-0.2px;">MBTI Insight</div>
                                    <div style="font-size:12px;color:#85879C;letter-spacing:1.6px;">KENALI DIRIMU</div>
                                </div>
                            </div>

                            <div style="text-align:right;">
                                <div style="font-size:12px;letter-spacing:4px;color:#85879C;">SERTIFIKAT HASIL TES</div>
                                <div style="margin-top:6px;font-size:12px;color:#85879C;">No. {{ strtoupper(substr($result->userTest->token, -10)) }}</div>
                            </div>
                        </div>

                        <div style="margin-top:72px;">
                            <div style="font-size:14px;letter-spacing:4px;color:#85879C;">DIBERIKAN KEPADA</div>
                            <div style="margin-top:18px;font-size:72px;line-height:1.05;font-weight:600;letter-spacing:-1.5px;color:#2B2D42;">
                                {{ $userTest->name }}
                            </div>
                            <div style="margin-top:26px;width:140px;height:1px;background:#EADFD5;"></div>
                        </div>

                        <div style="margin-top:56px;display:flex;align-items:flex-end;gap:40px;">
                            <div style="font-size:210px;line-height:0.86;font-weight:700;letter-spacing:-8px;color:{{ $type?->accent_color ?? '#A78BFA' }};">
                                {{ $result->final_mbti }}
                            </div>
                            <div style="padding-bottom:14px;">
                                <div style="font-size:42px;line-height:1.15;font-weight:600;color:#2B2D42;">{{ $type?->title }}</div>
                                <div style="margin-top:8px;font-size:15px;letter-spacing:5px;color:#85879C;">{{ strtoupper($type?->alias ?? 'MBTI TYPE') }}</div>
                            </div>
                        </div>

                        <div style="margin-top:34px;max-width:820px;font-size:19px;line-height:1.7;color:#565873;">
                            {{ $type?->description }}
                        </div>

                        <div style="margin-top:44px;display:flex;flex-wrap:wrap;justify-content:space-between;">
                            @foreach ($breakdown as $dimension => $data)
                                @php
                                    $fill = ['EI' => '#A78BFA', 'SN' => '#93C5FD', 'TF' => '#F9A8D4', 'JP' => '#99E2C4'][$dimension] ?? '#A78BFA';
                                @endphp
                                <div style="width:47%;margin-bottom:26px;">
                                    <div style="display:flex;align-items:baseline;justify-content:space-between;gap:12px;">
                                        <div style="font-size:12px;letter-spacing:2.4px;color:#85879C;">{{ strtoupper(config('mbti.dimensions.'.$dimension.'.title')) }}</div>
                                        <div style="font-size:14px;font-weight:600;color:#2B2D42;">
                                            {{ $data['left'] }} {{ $data['left_score'] }}%
                                            <span style="color:#85879C;font-weight:400;">·</span>
                                            {{ $data['right'] }} {{ $data['right_score'] }}%
                                        </div>
                                    </div>
                                    <div style="margin-top:10px;height:10px;border-radius:999px;background:#F0E2D8;overflow:hidden;">
                                        <div style="height:10px;width:{{ $data['left_score'] }}%;border-radius:999px;background:{{ $fill }};"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div style="margin-top:auto;padding-top:36px;border-top:1px solid #EADFD5;display:flex;align-items:flex-end;justify-content:space-between;gap:24px;">
                            <div>
                                <div style="font-size:12px;letter-spacing:2.4px;color:#85879C;">DITERBITKAN</div>
                                <div style="margin-top:8px;font-size:16px;color:#2B2D42;">
                                    {{ $userTest->completed_at->translatedFormat('d F Y') }}
                                </div>
                                @if ($userTest->age)
                                    <div style="margin-top:4px;font-size:13px;color:#85879C;">Usia {{ $userTest->age }} tahun</div>
                                @endif
                            </div>

                            <div style="text-align:right;max-width:420px;">
                                <div style="font-size:13px;line-height:1.6;color:#85879C;">
                                    Hasil ini bersifat reflektif dan bukan diagnosis psikologis.
                                    Kekuatan sinyal {{ $result->clarity }}% · skor {{ $result->scoring_version }}.
                                </div>
                                <div style="margin-top:10px;font-size:11px;letter-spacing:1.6px;color:#B9AFA6;">
                                    MBTI-INSIGHT · {{ strtoupper(substr($result->userTest->token, 0, 10)) }}
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
