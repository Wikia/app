<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named MultipleLookup.\n";
	exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Multiple Lookup',
	'description' => 'Provides user lookup on multiple wikis',
	'descriptionmsg' => 'specialmultiplelookup-desc',
	'author' => array( 'Bartek Lapinski', 'Piotr Molski' ),
);
define( "MULTILOOKUP_NO_CACHE", false );
define( "ML_TEST", 0 );
$wgExtensionMessagesFiles["MultiLookup"] = dirname( __FILE__ ) . '/SpecialMultipleLookup.i18n.php';
require_once( dirname( __FILE__ ) . '/SpecialMultipleLookup_helper.php' );
require_once( dirname( __FILE__ ) . '/SpecialMultipleLookup_ajax.php' );
require_once( dirname( __FILE__ ) . '/SpecialMultipleLookup_hooks.php' );

$wgAvailableRights[] = 'multilookup';

extAddSpecialPage( dirname( __FILE__ ) . '/SpecialMultipleLookup_body.php', 'MultiLookup', 'MultipleLookupPage' );
$wgSpecialPageGroups['MultiLookup'] = 'users';
