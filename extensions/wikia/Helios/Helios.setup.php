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
$wgAutoloadClasses["Wikia\\Helios\\User"]   = __DIR__ . "/User.class.php";
$wgAutoloadClasses["Wikia\\Helios\\Client"] = __DIR__ . "/Client.class.php";
$wgAutoloadClasses["Wikia\\Helios\\SampleController"] = __DIR__ . "/SampleController.class.php";

/**
 * Internationalisation.
 */
$wgExtensionMessagesFiles['Helios'] = __DIR__ . '/Helios.i18n.php';
