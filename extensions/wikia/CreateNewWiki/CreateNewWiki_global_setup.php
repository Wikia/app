<?php

/**
 * This setup file is meant to be loaded site-wide to provide classes
 * required by CreateNewWiki process run in the context of newly created wikis
 *
 * @author macbre
 */

$dir = __DIR__;

$wgAutoloadClasses['CreateWikiException'] = $dir . '/CreateWikiException.class.php';
$wgAutoloadClasses['Wikia\\CreateNewWiki\\Starters'] = $dir . '/classes/Starters.class.php';
