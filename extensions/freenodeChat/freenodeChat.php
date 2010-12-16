<?php
/**
 * Freenode Chat
 *
 * Integrates the freenode web IRC client into a special page.
 *
 * @author Robert Leverington <robert@rhl.me.uk>
 * @author Marco 27 <marco27.wiki@gmail.com>
 * @copyright Copyright © 2008 - 2009 Robert Leverington.
 * @copyright Copyright © 2009 Marco 27.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// If this is run directly from the web die as this is not a valid entry point.
if ( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

// Extension credits.
$wgExtensionCredits[ 'specialpage' ][] = array(
	'path'           => __FILE__,
	'name'           => 'Freenode Chat',
	'description'    => 'Adds a special page used to chat in real time with other wiki users (using freenode web IRC client).',
	'descriptionmsg' => 'freenodechat-desc',
	'version'        => '1.0.0',
	'author'         => array( 'Robert Leverington', 'Marco 27' )
);

$dir = dirname( __FILE__ ) . '/';

// Register special page.
$wgSpecialPages[ 'FreenodeChat' ] = 'FreenodeChat';
$wgSpecialPageGroups[ 'FreenodeChat' ] = 'wiki';
$wgAutoloadClasses[ 'FreenodeChat' ] = $dir . 'freenodeChat_body.php';

// Extension messages.
$wgExtensionMessagesFiles[ 'FreenodeChat' ] =  $dir . 'freenodeChat.i18n.php';
$wgExtensionAliasesFiles[ 'FreenodeChat' ] =  $dir . 'freenodeChat.alias.php';

// Default configuration.
$wgFreenodeChatChannel         = '#mediawiki-i18n';
$wgFreenodeChatExtraParameters = array();

// Permissions.
$wgAvailableRights[] = 'freenodechat';
$wgGroupPermissions[ '*'     ][ 'freenodechat' ] = false;
$wgGroupPermissions[ 'user'  ][ 'freenodechat' ] = true;
$wgGroupPermissions[ 'sysop' ][ 'freenodechat' ] = true;
