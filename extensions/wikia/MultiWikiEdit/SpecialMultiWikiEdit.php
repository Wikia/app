<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named Listusers.\n";
    exit( 1 ) ;
}
$wgExtensionCredits['specialpage'][] = array(
    "name" => "Multi Wiki Edit",
    "description" => "Special Multi Wiki Edit",
    "author" => "Bartek Łapiński, Piotr Molski"
);

define ("MULTIWIKIEDIT_THIS", 0) ;
define ("MULTIWIKIEDIT_ALL", 1) ;
define ("MULTIWIKIEDIT_SELECTED", 2) ;
define ("MULTIWIKIEDIT_CHUNK_SIZE", 250) ;

$wgExtensionMessagesFiles["Multiwikiedit"] = dirname(__FILE__) . '/MultiWikiEdit.i18n.php';

$wgAvailableRights[] = 'multiwikiedit';
$wgGroupPermissions['staff']['multiwikiedit'] = true;
#$wgGroupPermissions['helper']['multiwikiedit'] = true;

extAddSpecialPage( dirname(__FILE__) . '/SpecialMultiWikiEdit_body.php', 'Multiwikiedit', 'Multiwikiedit' );
$wgSpecialPageGroups['Multiwikiedit'] = 'pagetools';
