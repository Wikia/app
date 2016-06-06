<?php

// Autoload
$wgAutoloadClasses['Wikia\SeoCrossLink\CrossLinkHooks'] =  __DIR__ . '/classes/CrossLinkHooks.class.php';
$wgAutoloadClasses['Wikia\SeoCrossLink\CrossLinkInserter'] =  __DIR__ . '/classes/CrossLinkInserter.class.php';

$wgHooks['OutputPageBeforeHTML'][] = 'Wikia\SeoCrossLink\CrossLinkHooks::onOutputPageBeforeHTML';
