<?php

/**
 * This extension handles redirecting old Special:Contact and Special:DMCARequest contact pages
 * to Zendesk.
 */
$wgAutoloadClasses['ContactPageRedirect'] = __DIR__ . '/ContactPageRedirect.class.php';
$wgSpecialPages['Contact'] = 'ContactPageRedirect';

$wgAutoloadClasses['DMCARequestRedirect'] = __DIR__ . '/DMCARequestRedirect.class.php';
$wgSpecialPages['DMCARequest'] = 'DMCARequestRedirect';

$wgExtensionMessagesFiles['ContactPageRedirectsAliases']  = __DIR__ . '/ContactPageRedirects.alias.php';
