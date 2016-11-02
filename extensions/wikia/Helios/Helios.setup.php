<?php
$wgExtensionCredits['other'][] = [
	'path'			=> __FILE__,
	'name'			=> 'Helios',
	'description'		=> 'Wikia approach to user authentication.',
	'descriptionmsg'	=> 'helios-desc',
	'author'		=> [ '[http://community.wikia.com/wiki/User:Mroszka Michał Roszka]' ],
	'url'			=> 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Helios',
];


/**
 * Class loader entries.
 */
$wgAutoloadClasses["Wikia\\Helios\\HelperController"] = __DIR__ . "/HelperController.class.php";
