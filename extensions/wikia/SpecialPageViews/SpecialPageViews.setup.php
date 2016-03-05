<?php
/**
 * Special:PageViews
 * Displays data on PV for a given wikia.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 *
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Special:PageViews',
	'description' => 'Extension to present data on page views for a given wikia',
	'descriptionmsg' => 'special-pageviews-special-desc',
	'authors' => [
		'Adam Karmiński',
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialPageViews',
];

$wgAutoloadClasses['SpecialPageViewsController'] = $dir . 'SpecialPageViewsController.class.php';
$wgAutoloadClasses['SpecialPageViewsOutput'] = $dir . 'output/SpecialPageViewsOutput.class.php';
$wgAutoloadClasses['SpecialPageViewsSourceDatabase'] = $dir . 'SpecialPageViewsSourceDatabase.class.php';

$wgSpecialPages['PageViews'] = 'SpecialPageViewsController';
$wgSpecialPageGroups['PageViews'] = 'wikia';

$wgExtensionMessagesFiles['SpecialPageViews'] = $dir . 'SpecialPageViews.i18n.php';

$wgResourceModules['ext.SpecialPageViews'] = [
	'scripts' => '/extensions/wikia/SpecialPageViews/modules/SpecialPageViews.js',
	'styles' => '/extensions/wikia/SpecialPageViews/modules/SpecialPageViews.scss'
];
