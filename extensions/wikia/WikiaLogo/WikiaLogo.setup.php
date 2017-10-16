<?php
/**
 * WikiaLogo
 *
 * @author Bogna 'bognix' Knychała
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'WikiaLogo',
	'author' => 'Bogna "bognix" Knychała',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaLogo'
];

// controller classes
$wgAutoloadClasses[ 'WikiaLogoHelper' ] =  __DIR__ . '/WikiaLogoHelper.class.php';

