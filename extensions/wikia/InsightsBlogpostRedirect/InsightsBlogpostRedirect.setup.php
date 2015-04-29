<?php

/**
 * InsightsBlogpostRedirect
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'InsightsBlogpostRedirect',
	'descriptionmsg' => 'insightsblogpostredirect-desc',
	'authors' => [
		'Kamil Koterba <kamil@wikia-inc.com>',
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InsightsBlogpostRedirect'
];

//classes
$wgAutoloadClasses['InsightsBlogpostRedirectController'] = $dir . 'InsightsBlogpostRedirectController.class.php';

//special page
$wgSpecialPages['Insights'] = 'InsightsBlogpostRedirectController';

//message files
$wgExtensionMessagesFiles['InsightsBlogpostRedirect'] = $dir . 'InsightsBlogpostRedirect.i18n.php';
