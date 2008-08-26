<?php
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 * This is an extension that let you protect some part of a text. You just
 * have to be a member of a group with the 'protectsection' user right.
 *
 * To protect a text, enclose use in a <protect> </protect> block.
 *
 * @addtogroup Extensions
 *
 * @author ThomasV <thomasv1@gmx.de>
 * @author Jim Hu (remove Section Edit links in protected text, bug fixes)
 * @author Siebrand Mazeland (i18n and SVN merge)
 * @copyright Copyright © 2006, ThomasV
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'ProtectSection',
	'author' => 'ThomasV',
	'description' => 'Allows authorised users to protect parts of a text',
	'descriptionmsg' => 'protectsection_desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ProtectSection'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ProtectSection'] = $dir . 'ProtectSection.i18n.php';

// Two new permissions
$wgGroupPermissions['sysop']['protectsection']         = true;
$wgGroupPermissions['bureaucrat']['protectsection']    = true;
$wgAvailableRights[] = 'protectsection';

$wgExtensionFunctions[] = 'wfProtectSectionSetup';

// Register hooks
$wgHooks['ParserAfterTidy'][] = 'wfStripProtectTags' ;
$wgHooks['EditFilter'][] = 'wfCheckProtectSection' ;

function wfProtectSectionSetup() {
	wfLoadExtensionMessages( 'ProtectSection' );
}

/**
 * @param &$parser The parser object
 * @param &$text The text being parsed
 * @param &$x Something not used FIXME
 */
function wfStripProtectTags ( &$parser , &$text) {

	global $wgUser;

	$tmp = explode("&lt;protect&gt;",$text);
	$sections = array();
	$sections[] = array_shift($tmp);
	foreach($tmp as $block){
		$tmp = explode("&lt;/protect&gt;",$block);
		if ( $wgUser->isAllowed( 'protectsection' ) ) {
			$sections[] = "<span class='protected'>".$tmp[0]."</span>";
		}else{
			$sections[] = "<span class='protected'>".preg_replace("/<div class=\"editsection(.*?)<\/div>/i", "", $tmp[0])."</span>";
		}
		array_shift($tmp);
		$sections[] = implode('',$tmp);
	}
	$text = implode("",$sections);
	return true;
}

/**
 * @todo Document
 * @param $editpage
 * @param $textbox1
 * @param $section
 */
function wfCheckProtectSection ( $editpage, $textbox1, $section )  {

	# check for partial protection
	global $wgUser,$wgParser;

	if ( !$wgUser->isAllowed( 'protectsection' ) ) {
		$modifyProtect = false;
		$text1 = $editpage->mArticle->getContent(true);

		if( $section != '' ) {
			if( $section == 'new' ) {
				$text1 = "";
			} else {
				$text1 = $wgParser->getSection( $text1, $section );
			}
		}

		$text2 = $textbox1 ;

		preg_match_all( "/<protect>(.*?)<\/protect>|<protect>(.*?)$/si", $text1, $list1, PREG_SET_ORDER );
		preg_match_all( "/<protect>(.*?)<\/protect>|<protect>(.*?)$/si", $text2, $list2, PREG_SET_ORDER );

		if( count($list1) != count($list2)) {
			$msg = wfMsg( 'protectsection_add_remove');
			$modifyProtect = true;
		}
		else for ( $i=0 ; $i < count( $list1 ); $i++ ) {
			if( $list1[$i][0] != $list2[$i][0]) {
				$msg = wfMsg( 'protectsection_modify' );
				$modifyProtect = true;
				break;
			}
		}

		if( $modifyProtect ) {
			global $wgOut;
			$wgOut->setPageTitle( wfMsg( 'protectsection_forbidden' ) );
			$wgOut->addWikiText($msg);
			return false;
		}
	}
	return true;
}
