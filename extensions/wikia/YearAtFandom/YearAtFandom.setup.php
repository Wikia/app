<?php
/**
 * Wikia Search (v3) Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */

$dir = __DIR__ . '/';

$wgSpecialPages['YearAtFandom'] = 'YearAtFandomController';

$wgAutoloadClasses['YearAtFandomController'] = $dir . 'YearAtFandomController.class.php';
$wgWikiaApiControllers['YearAtFandomController'] = $dir . 'YearAtFandomController.class.php';

$wgExtensionCredits['other'][] = [
	'name' => 'Year at Fandom',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/YearAtFandom'
];
