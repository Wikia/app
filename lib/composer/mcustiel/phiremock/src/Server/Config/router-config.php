<?php

return [
    'start' => 'expectationUrl',
    'nodes' => [
// -------------------------------- API: expectations ---------------------------

        'expectationUrl' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['url' => 'path'],
                        'matcher'      => [
                            'matches' => '/\\_\\_phiremock\/expectations\/?$/',
                        ],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['goto' => 'expectationMethodIsPost'],
                ],
                'else' => [
                    ['goto' => 'scenariosUrl'],
                ],
            ],
        ],
        'expectationMethodIsPost' => [
            'condition' => [
                'all-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'POST'],
                    ],
                    [
                        'input-source' => ['header' => 'Content-Type'],
                        'matcher'      => ['isEqualTo' => 'application/json'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['addExpectation' => null],
                ],
                'else' => [
                    ['goto' => 'expectationMethodIsGet'],
                ],
            ],
        ],
        'expectationMethodIsGet' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'GET'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['listExpectations' => null],
                ],
                'else' => [
                    ['goto' => 'expectationMethodIsDelete'],
                ],
            ],
        ],
        'expectationMethodIsDelete' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'DELETE'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['clearExpectations' => null],
                ],
                'else' => [
                    ['goto' => 'apiError'],
                ],
            ],
        ],

// -------------------------------- API: scenarios ---------------------------

        'scenariosUrl' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['url' => 'path'],
                        'matcher'      => [
                            'matches' => '/\\_\\_phiremock\/scenarios\/?$/',
                        ],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['goto' => 'scenariosMethodIsPut'],
                ],
                'else' => [
                    ['goto' => 'verifyUrl'],
                ],
            ],
        ],
        'scenariosMethodIsPut' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'PUT'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['setScenarioState' => null],
                ],
                'else' => [
                    ['goto' => 'scenariosMethodIsDelete'],
                ],
            ],
        ],
        'scenariosMethodIsDelete' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'DELETE'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['clearScenarios' => null],
                ],
                'else' => [
                    ['goto' => 'apiError'],
                ],
            ],
        ],

// -------------------------------- API: executions ---------------------------

        'verifyUrl' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['url' => 'path'],
                        'matcher'      => [
                            'matches' => '/\\_\\_phiremock\/executions\/?$/',
                        ],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['goto' => 'verifyMethodIsPost'],
                ],
                'else' => [
                    ['goto' => 'resetUrl'],
                ],
            ],
        ],
        'verifyMethodIsPost' => [
            'condition' => [
                'all-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'POST'],
                    ],
                    [
                        'input-source' => ['header' => 'Content-Type'],
                        'matcher'      => ['isEqualTo' => 'application/json'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['countRequests' => null],
                ],
                'else' => [
                    ['goto' => 'verifyMethodIsPut'],
                ],
            ],
        ],
        'verifyMethodIsPut' => [
            'condition' => [
                'all-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'PUT'],
                    ],
                    [
                        'input-source' => ['header' => 'Content-Type'],
                        'matcher'      => ['isEqualTo' => 'application/json'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['listRequests' => null],
                ],
                'else' => [
                    ['goto' => 'verifyMethodIsDelete'],
                ],
            ],
        ],
        'verifyMethodIsDelete' => [
            'condition' => [
                'all-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'DELETE'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['resetCount' => null],
                ],
                'else' => [
                    ['goto' => 'apiError'],
                ],
            ],
        ],

// -------------------------------- API: reset ---------------------------

        'resetUrl' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['url' => 'path'],
                        'matcher'      => [
                            'matches' => '~\\_\\_phiremock/reset/?$~',
                        ],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['goto' => 'resetMethodIsPost'],
                ],
                'else' => [
                    ['goto' => 'default'],
                ],
            ],
        ],
        'resetMethodIsPost' => [
            'condition' => [
                'one-of' => [
                    [
                        'input-source' => ['method' => null],
                        'matcher'      => ['isEqualTo' => 'POST'],
                    ],
                ],
            ],
            'actions' => [
                'if-matches' => [
                    ['clearScenarios' => null],
                    ['resetCount'         => null],
                    ['clearExpectations'  => null],
                    ['reloadExpectations' => null],
                ],
                'else' => [
                    ['goto' => 'apiError'],
                ],
            ],
        ],

// -------------------------------- API: error happened ---------------------------

        'apiError' => [
            'condition' => [],
            'actions'   => [
                'if-matches' => [
                    ['serverError' => null],
                ],
                'else' => [],
            ],
        ],

// ---------------------------- Verify configured expectations -----------------------

        'default' => [
            'condition' => [],
            'actions'   => [
                'if-matches' => [
                    ['storeRequest' => null],
                    ['checkExpectations'  => null],
                    ['verifyExpectations' => null],
                ],
                'else' => [],
            ],
        ],
    ],
];
