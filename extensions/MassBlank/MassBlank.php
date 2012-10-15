<?php
/**
 * MassBlank by Tisane (adapted from Nuke by Brion Vibber)
 * URL: http://www.mediawiki.org/wiki/Extension:MassBlank
 *
 * This program is free software. You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. You can also redistribute and/or modify
 * those portions written by Tisane under the terms of the Creative Commons
 * Attribution-ShareAlike 3.0 license.
 *
 * This program gives sysops the ability to mass blank pages.
 */

if( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['MassBlank'] = $dir . 'MassBlank.i18n.php';
$wgExtensionMessagesFiles['MassBlankAlias'] = $dir . 'MassBlank.alias.php';

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'MassBlank',
	'descriptionmsg' => 'massblank-desc',
	'author'         => 'Tisane',
        'version'        => '0.0.1',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:MassBlank'
);

$wgGroupPermissions['sysop']['massblank'] = true;
$wgAvailableRights[] = 'massblank';

$wgAutoloadClasses['SpecialMassBlank'] = $dir . 'MassBlank_body.php';
$wgSpecialPages['MassBlank'] = 'SpecialMassBlank';
$wgSpecialPageGroups['MassBlank'] = 'pagetools';
