<?php
if (!defined('MEDIAWIKI'))
{
	exit(1);
}
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MyExtension',
	'author' => 'Pepe',
	'url' => 'www.jakasstrona.pl',
	'description' => "Domyslne info",
	'descriptionmsg' => 'myextension-desc',
	'version' => '0.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['SpecialMyExtension'] = $dir . 'SpecialMyExtension.php';
$wgExtensionMessagesFiles['MyExtension'] = $dir . 'MyExtension.i18n.php';
$wgSpecialPages['MyExtension'] = 'SpecialMyExtension';
//$wgSpecialPageGroups['MyExtension'] = 'other;
