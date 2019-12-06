<?php
/**
 * Wikia Search (v3) Extension
 *
 * @author Robert Elwell <robert(at)wikia-inc.com>
 */

$dir = __DIR__ . '/';

$wgAutoloadClasses['YearAtFandomController'] = $dir . 'YearAtFandomController.php';
$wgAutoloadClasses['YearAtFandomDataProvider'] = $dir . 'YearAtFandomDataProvider.php';
foreach (scandir(__DIR__ . '/DTO') as $filename) {
	$wgAutoloadClasses[substr($filename, 0, -4)] = __DIR__ . '/DTO/' . $filename;
}
$wgWikiaApiControllers['YearAtFandomController'] = $dir . 'YearAtFandomController.php';

$wgExtensionCredits['other'][] = [
	'name' => 'Year at Fandom',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/YearAtFandom'
];
