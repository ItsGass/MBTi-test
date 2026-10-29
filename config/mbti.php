<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Instrument composition
    |--------------------------------------------------------------------------
    |
    | Forty items split evenly across the four dimensions. Each dimension must
    | contain the same number of positively and negatively directed items so
    | that a respondent who simply agrees with everything cannot drift toward
    | one pole of a dimension.
    |
    */

    'questions' => [
        'total' => 40,
        'per_dimension' => 10,
        'per_page' => 5,
        'per_direction' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Answer scale
    |--------------------------------------------------------------------------
    */

    'likert' => [
        'min' => 1,
        'max' => 5,
        'neutral' => 3,
        'labels' => [
            1 => 'Sangat Tidak Setuju',
            2 => 'Tidak Setuju',
            3 => 'Netral',
            4 => 'Setuju',
            5 => 'Sangat Setuju',
        ],
        'short_labels' => [
            1 => 'STS',
            2 => 'TS',
            3 => 'N',
            4 => 'S',
            5 => 'SS',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dimensions
    |--------------------------------------------------------------------------
    |
    | The left pole is the one a "+1" item supports. Display labels are kept
    | here so the enums and the views never hardcode copy.
    |
    */

    'dimensions' => [
        'EI' => [
            'label' => 'E / I',
            'left' => 'E',
            'right' => 'I',
            'title' => 'Sumber Energi',
            'description' => 'Bagaimana kamu mengisi ulang energi: dari orang lain atau dari waktu sendiri.',
            'poles' => [
                'E' => 'Ekstrovert',
                'I' => 'Introvert',
            ],
        ],
        'SN' => [
            'label' => 'S / N',
            'left' => 'S',
            'right' => 'N',
            'title' => 'Cara Menyerap Informasi',
            'description' => 'Apakah kamu lebih percaya fakta konkret atau pola dan kemungkinan.',
            'poles' => [
                'S' => 'Sensing',
                'N' => 'Intuisi',
            ],
        ],
        'TF' => [
            'label' => 'T / F',
            'left' => 'T',
            'right' => 'F',
            'title' => 'Cara Mengambil Keputusan',
            'description' => 'Apakah keputusan lebih banyak dipandu logika atau nilai dan perasaan.',
            'poles' => [
                'T' => 'Thinking',
                'F' => 'Feeling',
            ],
        ],
        'JP' => [
            'label' => 'J / P',
            'left' => 'J',
            'right' => 'P',
            'title' => 'Gaya Hidup',
            'description' => 'Apakah kamu lebih nyaman dengan rencana yang rapi atau ruang untuk spontan.',
            'poles' => [
                'J' => 'Judging',
                'P' => 'Perceiving',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Session lifetime
    |--------------------------------------------------------------------------
    |
    | An unfinished attempt may be resumed for this long. Completed results are
    | permanent and remain reachable through their token forever.
    |
    */

    'session_ttl_hours' => 24,

    /*
    |--------------------------------------------------------------------------
    | Tie breaking
    |--------------------------------------------------------------------------
    |
    | A dimension whose raw sum is exactly zero is a tie. The pole with more
    | strong answers (5 for a positive item, 1 for a negative item) wins; if
    | both sides are equally strong the left pole is used as the final default.
    |
    */

    'tie_break' => [
        'default_pole' => 'left',
        'strong_value' => 5,
        'strong_offset' => 2,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scoring
    |--------------------------------------------------------------------------
    */

    'scoring_version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Compatibility
    |--------------------------------------------------------------------------
    */

    'compatibility' => [
        'recommendations' => 3,
        'bands' => [
            ['min' => 70, 'label' => 'Sangat Cocok', 'tone' => 'purple'],
            ['min' => 55, 'label' => 'Baik', 'tone' => 'blue'],
            ['min' => 40, 'label' => 'Cukup', 'tone' => 'pink'],
            ['min' => 0, 'label' => 'Tantangan', 'tone' => 'slate'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Certificate
    |--------------------------------------------------------------------------
    */

    'certificate' => [
        'width' => 1200,
        'height' => 850,
        'scale' => 2,
        'careers' => 4,
        'matches' => 3,
        'name_limit' => 28,
        'career_limit' => 46,
    ],

    /*
    |--------------------------------------------------------------------------
    | Visual palette
    |--------------------------------------------------------------------------
    |
    | The whole interface draws from five hues. The certificate template repeats
    | these values as inline hex so html2canvas never has to resolve a CSS
    | variable or an oklch() colour.
    |
    */

    'palette' => [
        'cream' => '#FFF9F5',
        'cream_deep' => '#FDF1E7',
        'ink' => '#2B2D42',
        'ink_soft' => '#565873',
        'ink_muted' => '#85879C',
        'line' => '#EDE0D8',
        'track' => '#F2E6DE',
        'white' => '#FFFFFF',
        'tones' => [
            'lilac' => ['base' => '#CDB4DB', 'soft' => '#F4EDF8', 'deep' => '#A98FBB'],
            'blush' => ['base' => '#FFC8DD', 'soft' => '#FFF0F5', 'deep' => '#E8A8C4'],
            'sky' => ['base' => '#A2D2FF', 'soft' => '#EAF4FF', 'deep' => '#7FB6EE'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chibi character catalog
    |--------------------------------------------------------------------------
    |
    | Each of the sixteen types gets a deterministic avatar: a pastel tone, a
    | hair silhouette and one signature prop. The values feed an inline SVG so
    | the catalog renders without external image files.
    |
    */

    'chibi' => [
        'types' => [
            'ENFJ' => ['tone' => 'lilac', 'hair' => '#2B2D42', 'hair_style' => 'bob', 'outfit' => '#2B2D42', 'prop' => 'heart_banner', 'glasses' => false, 'skin' => '#FFE0CE'],
            'ENFP' => ['tone' => 'sky', 'hair' => '#8C5C6E', 'hair_style' => 'curly', 'outfit' => '#A2D2FF', 'prop' => 'balloon', 'glasses' => false, 'skin' => '#F7CDB4'],
            'ENTJ' => ['tone' => 'blush', 'hair' => '#2B2D42', 'hair_style' => 'short', 'outfit' => '#2B2D42', 'prop' => 'flag', 'glasses' => false, 'skin' => '#FFE0CE'],
            'ENTP' => ['tone' => 'lilac', 'hair' => '#4A3B52', 'hair_style' => 'spiky', 'outfit' => '#CDB4DB', 'prop' => 'bulb', 'glasses' => false, 'skin' => '#FFE0CE'],
            'ESFJ' => ['tone' => 'sky', 'hair' => '#6E4B3A', 'hair_style' => 'bob', 'outfit' => '#A2D2FF', 'prop' => 'tray', 'glasses' => false, 'skin' => '#F7CDB4'],
            'ESFP' => ['tone' => 'blush', 'hair' => '#8C5C6E', 'hair_style' => 'ponytail', 'outfit' => '#FFC8DD', 'prop' => 'mic', 'glasses' => false, 'skin' => '#FFE0CE'],
            'ESTJ' => ['tone' => 'lilac', 'hair' => '#2B2D42', 'hair_style' => 'short', 'outfit' => '#565873', 'prop' => 'gavel', 'glasses' => false, 'skin' => '#F7CDB4'],
            'ESTP' => ['tone' => 'sky', 'hair' => '#2B2D42', 'hair_style' => 'spiky', 'outfit' => '#A2D2FF', 'prop' => 'bolt', 'glasses' => false, 'skin' => '#E8B79A'],
            'INFJ' => ['tone' => 'blush', 'hair' => '#2B2D42', 'hair_style' => 'long', 'outfit' => '#CDB4DB', 'prop' => 'lantern', 'glasses' => false, 'skin' => '#FFE0CE'],
            'INFP' => ['tone' => 'sky', 'hair' => '#6E4B3A', 'hair_style' => 'long', 'outfit' => '#FFC8DD', 'prop' => 'notebook', 'glasses' => false, 'skin' => '#F7CDB4'],
            'INTJ' => ['tone' => 'lilac', 'hair' => '#2B2D42', 'hair_style' => 'short', 'outfit' => '#2B2D42', 'prop' => 'blueprint', 'glasses' => true, 'skin' => '#FFE0CE'],
            'INTP' => ['tone' => 'blush', 'hair' => '#4A3B52', 'hair_style' => 'messy', 'outfit' => '#565873', 'prop' => 'atom', 'glasses' => true, 'skin' => '#E8B79A'],
            'ISFJ' => ['tone' => 'lilac', 'hair' => '#6E4B3A', 'hair_style' => 'bun', 'outfit' => '#CDB4DB', 'prop' => 'shield', 'glasses' => false, 'skin' => '#FFE0CE'],
            'ISFP' => ['tone' => 'sky', 'hair' => '#8C5C6E', 'hair_style' => 'bob', 'outfit' => '#A2D2FF', 'prop' => 'paintbrush', 'glasses' => false, 'skin' => '#F7CDB4'],
            'ISTJ' => ['tone' => 'blush', 'hair' => '#4A3B52', 'hair_style' => 'short', 'outfit' => '#2B2D42', 'prop' => 'clipboard', 'glasses' => true, 'skin' => '#E8B79A'],
            'ISTP' => ['tone' => 'lilac', 'hair' => '#4A3B52', 'hair_style' => 'messy', 'outfit' => '#565873', 'prop' => 'wrench', 'glasses' => false, 'skin' => '#FFE0CE'],
        ],
        'fallback' => [
            'tone' => 'lilac',
            'hair' => '#2B2D42',
            'hair_style' => 'short',
            'outfit' => '#CDB4DB',
            'prop' => 'sparkle',
            'glasses' => false,
            'skin' => '#FFE0CE',
        ],
    ],

];
