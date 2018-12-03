<?php

// Autoload
$wgAutoloadClasses['SeoLinkHreflang'] =  __DIR__ . '/SeoLinkHreflang.class.php';

// Hooks
$wgHooks['OutputPageBeforeHTML'][] = 'SeoLinkHreflang::onOutputPageBeforeHTML';
