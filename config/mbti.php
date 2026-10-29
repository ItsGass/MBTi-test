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
        'height' => 1600,
        'scale' => 2,
    ],

];
