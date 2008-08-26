<?php
/**
 * @addtogroup SpecialPage
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "DeSysop extension\n";
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Desysop',
	'svn-date' => '$LastChangedDate: 2008-05-14 00:38:28 +0000 (Wed, 14 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 34773 $',
	'description' => 'Gives bureaucrats the ability to revoke Sysop access',
	'author' => 'Andrew Garrett',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Desysop',
);

$wgExtensionMessagesFiles['Desysop'] = dirname(__FILE__) . '/SpecialDesysop.i18n.php';

/**
 * Quick hack for clusters with multiple master servers; if an alternate
 * is listed for the requested database, a connection to it will be opened
 * instead of to the current wiki's regular master server.
 *
 * Requires that the other server be accessible by network, with the same
 * username/password as the primary.
 *
 * eg $wgAlternateMaster['enwiki'] = 'ariel';
 */
$wgAlternateMaster = array();

$wgGroupPermissions['bureaucrat']['desysop'] = true;
$wgAvailableRights[] = 'desysop';

# Register special page
if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}
extAddSpecialPage( dirname(__FILE__) . '/SpecialDesysop_body.php', 'Desysop', 'DesysopPage' );
