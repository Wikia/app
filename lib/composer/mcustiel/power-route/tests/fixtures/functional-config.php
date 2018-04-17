<?php

// Graph represented in this config:
//
// route1 ----< condition matches? > ---yes--- route2
//                                    \
//                                     --no--- default

return [
    'root' => 'route1',
    'nodes' => [
        // Node 1
        'route1' => [
            'condition' => [
                'all-of' => [
                    [
                        'input-source' => ['cookie' => 'cookieTest'],
                        'matcher' => ['notNull' => null],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    [
                        'displayFile' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html',
                    ],
                ],
                'else' => [
                    [
                        'goto' => 'route2',
                    ],
                ],
            ],
        ],

        // Node 2
        'route2' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['queryString' => 'potato'],
                        'matcher' => ['inArray' => ['baked', 'boiled', 'grilled']],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    [
                        'saveCookie' => [
                            'name' => 'cookieTest',
                            'value' => '{{get.potato}}',
                            'ttl' => '3600',
                            'domain' => '',
                            'path' => '',
                            'secure' => false,
                        ],
                    ],
                    [
                        'displayFile' => __DIR__ . '/files/potato-{{get.potato}}.html',
                    ],
                ],
                'else' => [
                    [
                        'goto' => 'default',
                    ],
                ],
            ],
        ],

        // Node 3
        'default' => [
            'condition' => [],
            'actions' => [
                'if-matches' => [
                    [
                        'redirect' => 'http://www.google.com',
                    ],
                    [
                        'middleware' => null,
                    ],
                ],
            ],
        ],
    ],
];
