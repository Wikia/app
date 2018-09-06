<?php
$wgExtensionCredits['parserhook'][] = [
    'name' => 'Mark Wiki As Closed',
    'author' => [
        'bpiatek',
    ],
    'version' => '1',
    'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MarkWikiAsClosed',
];

// load classes controller
$wgAutoloadClasses['MarkWikiAsClosedController'] = __DIR__ . '/controllers/MarkWikiAsClosedController.class.php';