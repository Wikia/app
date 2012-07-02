<?php
/**
 * PrivatePageProtection extension - implements per page acccess restrictions based on user group.
 * Which groups are authorized for viewing is defined on-page, using a parser function.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

/*
* WARNING: you can use this extension to deny read access to some pages. Keep in mind that this
* may be circumvented in several ways. This extension doesn't try to
* plug such holes. Also note that pages that are not readable will still be shown in listings,
* such as the search page, categories, etc.
*
* Known ways to access "hidden" pages:
* - transcluding as template. can be avoided using $wgNonincludableNamespaces.
* Some search messages may reveal the page existance by producing links to it (MediaWiki:searchsubtitle,
* MediaWiki:noexactmatch, MediaWiki:searchmenu-exists, MediaWiki:searchmenu-new...).
*
* NOTE: you cannot GRANT access to things forbidden by $wgGroupPermissions. You can only DENY access
* granted there.
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['parserfunction'][] = array(
	'path' => __FILE__,
	'name' => 'PrivatePageProtection',
	'author' => array( 'Daniel Kinzler'),
	'url' => 'http://mediawiki.org/wiki/Extension:PrivatePageProtection',
	'descriptionmsg' => 'privatepp-desc',
);

$wgExtensionMessagesFiles['PrivatePageProtection'] = dirname(__FILE__) . '/PrivatePageProtection.i18n.php';
$wgExtensionMessagesFiles['PrivatePageProtectionMagic'] = dirname(__FILE__) . '/PrivatePageProtection.i18n.magic.php';

$wgHooks['ParserFirstCallInit'][] = 'privateppParserFirstCallInit';
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'privateppUserPermissionsErrors';
$wgHooks['ArticleSave'][] = 'privateppArticleSave';

// Tell MediaWiki that the parser function exists.
function privateppParserFirstCallInit( &$parser ) {
 
   // Create a function hook associating the magic word
   $parser->setFunctionHook('allow-groups', 'privateppRenderTag');
   return true;
}
 
// Render the output of the parser function.
function privateppRenderTag( $parser, $param1 = '', $param2 = '' ) {
   $args = func_get_args();
   
   if ( count( $args ) <= 1 ) {
	   return true;
   }
   
   $groups = array();
   
   for ( $i = 1; $i < count( $args ); $i++ ) {
	   $groups[] = strtolower( trim( $args[$i] ) ); #XXX: allow localized group names?!
   }
   
   $groups = implode( "|", $groups );
	
   $out = $parser->getOutput();
   
   $ppp = $out->getProperty('ppp_allowed_groups');
   if ( $ppp ) {
	   $groups = $ppp . '|' . $groups;
   }
 
   $out->setProperty('ppp_allowed_groups', $groups);
 
   return array( 'text' => '', 'ishtml' => true, 'inline' => true );
}

/**
 * Returns a list of allowed groups for the given page.
 */
function privateppGetAllowedGroups( $title ) {
	$result = array();
	$id = $title->getArticleID();

	if ( $id == 0 ) {
		return array();
	}

	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select( array( 'page_props' ),
		array( 'pp_value' ),
		array( 'pp_page' => $id, 'pp_propname' => 'ppp_allowed_groups' ),
		__METHOD__ );

	if ( $res !== false ) {
		foreach ( $res as $row ) {
			$result[] = $row->pp_value;
		}
	}

	#TODO: use object cache?! get from parser cache?!
	return $result;
}

function privateppGetAccessError( $groups, $user ) {
	global $wgLang;
	
	if ( !$groups ) return null;
	if ( is_string( $groups ) ) $groups = explode('|', $groups);
	
	$ugroups = $user->getEffectiveGroups( true );;

	$match = array_intersect( $ugroups, $groups );

	if ( $match ) {
		# group is allowed - keep processing
		return null;
	} else {
		# group is denied - abort
		$groupLinks = array_map( array( 'User', 'makeGroupLinkWiki' ), $groups );
		
		$err = array(
			'badaccess-groups',
			$wgLang->commaList( $groupLinks ),
			count( $groups )
		);
				
		return $err;
	}
}

function privateppUserPermissionsErrors( $title, $user, $action, &$result ) {
	$groups = privateppGetAllowedGroups( $title );
	$result = privateppGetAccessError( $groups, $user );
	
	if ( !$result ) return true;
	else return false;
}

function privateppArticleSave( &$wikipage, &$user, &$text, &$summary,
							$minor, $watchthis, $sectionanchor, &$flags, &$status ) {
				
	# prevent users from saving a page with access restrictions that
	# would lock them out opf the page.
			
	#XXX: calling prepareTextForEdit() causes the text to be parsed a second time! 
	#     but there doesn't seem to be a hook that has access to the parseroutput...
	$editInfo = $wikipage->prepareTextForEdit( $text, null, $user ); 
	$groups = $editInfo->output->getProperty('ppp_allowed_groups');

	$err = privateppGetAccessError( $groups, $user );
	if ( !$err ) return true;
	
	$err[0] = 'privatepp-lockout-prevented'; #override message key
	throw new PermissionsError( 'edit', array( $err ) );
	
	#$status->fatal( $err[0], $err[1], $err[2] ); # message, groups, count
	#return false;
}
