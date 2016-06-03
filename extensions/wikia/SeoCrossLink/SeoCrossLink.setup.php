<?php

// Autoload
$wgAutoloadClasses['Wikia\SeoCrossLink\CrossLinkHooks'] =  __DIR__ . '/classes/CrossLinkHooks.class.php';

$wgHooks['OutputPageBeforeHTML'][] = 'Wikia\SeoCrossLink\CrossLinkHooks::onOutputPageBeforeHTML';
