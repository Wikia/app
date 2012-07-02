<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright © 2007 Roan Kattouw
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows changing the author of a revision
 * Written for the Bokt Wiki <http://www.bokt.nl/wiki/> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the ChangeAuthor extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ChangeAuthor/ChangeAuthor.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ChangeAuthor',
	'author' => 'Roan Kattouw',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ChangeAuthor',
	'version' => '1.1',
	'descriptionmsg' => 'changeauthor-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ChangeAuthor'] = $dir . 'ChangeAuthor.i18n.php';
$wgExtensionMessagesFiles['ChangeAuthorAliases'] = $dir . 'ChangeAuthor.alias.php';
$wgAutoloadClasses['ChangeAuthor'] = $dir . 'ChangeAuthor.body.php';

$wgSpecialPages['ChangeAuthor'] = 'ChangeAuthor';
$wgSpecialPageGroups['ChangeAuthor'] = 'pagetools';

// Required permission to use Special:ChangeAuthor
$wgAvailableRights[] = 'changeauthor';

// Add new log type
$wgLogTypes[] = 'changeauth';
$wgLogNames['changeauth'] = 'changeauthor-logpagename';
$wgLogHeaders['changeauth'] = 'changeauthor-logpagetext';
$wgLogActions['changeauth/changeauth'] = 'changeauthor-logentry';
