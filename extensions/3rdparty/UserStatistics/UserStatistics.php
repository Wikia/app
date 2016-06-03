<?php
# Copyright (C) 2005 - 2006 Thomas Klein <tkl-online@gmx.de>
# http://www.mediawiki.org/
#
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
* Extension to counting of working article on a user
*
* Use with:
*
* <useredit>UserName[|UserName]</useredit>
* <useredittopten>[all]|[number]|[]</useredittopten>
* <usercreate [all]>UserName</usercreate>
* <usereditfirst>UserName</usereditfirst>
* <usereditlast>UserName</usereditlast>
*
* @author Thomas Klein <tkl-online@gmx.de>
* @package MediaWiki
* @subpackage Extensions
*/

/**
* Version History
*
* 27.09.2006 1.1.2
*  - Having problems with MySQL 4.0.x fixed
*
* 25.09.2006 1.1.1
*  - Query the first edit date >> sample: <usereditfirst>UserName</usereditfirst>
*  - Query the last edit date >> sample: <usereditlast>UserName</usereditlast>
*
* 17.07.2006 1.1.0
*  - UserCreate is working with MySQL 4.0.x
*
* 17.07.2006 1.0.9
*  - In editcout an error with not user found fixed.
*
* 10.05.2006 1.0.8
*  - For the keyword useredit now several users can indicate, separately through |
*
* 10.05.2006 1.0.7
*  - EditCount sql query and TopTenEditCount sql query adjusted
*
* 04.05.2006 1.0.6
*  - Listing the top ten with count >> sample: <useredittopten>[all] | [number] | []</useredittopten>
*
* 03.04.2006 1.0.5
*  - Listing the top ten of edits
*
* 13.12.2005 1.0.4
*  - Counting the create dokument with namespace
*
* 23.11.2005 1.0.2
*  - Disable caching for pages using this extension
*
* 22.11.2005 1.0.1
*  - Checking the database version of MySQL
*
* 15.11.2005 1.0.0
*  - Release of the first version
*/
if( !defined( 'MEDIAWIKI' ) ) {
  die();
}

require_once( 'Sanitizer.php' );
require_once( 'HttpFunctions.php' );

$wgMySQL40Userright = true;

$wgHooks['ParserFirstCallInit'][] = "wfUserStatistics";
$wgExtensionCredits['parserhook'][] = array(
                                      'name' => 'UserStatistics',
                                      'author' => 'Thomas Klein',
                                      'url' => 'http://www.perrypedia.proc.org/index.php?title=Benutzer:Bully1966/UserStatistics',
                                      'description' => 'Extension to counting of working article on a user',
                                      'version'=>'1.1.2');

/**
 * @param Parser $parser
 * @return bool
 */
function wfUserStatistics( $parser ) {
  $parser->setHook( "useredit" , 'counting_useredit' ) ;
  $parser->setHook( "useredittopten" , 'counting_useredit_topten' ) ;

  $parser->setHook( "usercreate" , 'counting_usercreate' ) ;

  $parser->setHook( "usereditfirst" , 'first_useredit' ) ;
  $parser->setHook( "usereditlast" , 'last_useredit' ) ;

  //$parser->setHook( "usercreate4_0_x" , 'counting_usercreate_4_0_x' ) ;

  return true;
}

function counting_useredit( $text ) {
  global $wgVersion;

  if ( version_compare( $wgVersion, '1.5beta4', '<' ) ) {
    $ret = "1.5.x  of MediaWiki required";
    return $ret ;
  }

//  $wgParser->disableCache();

  $totalall = 0;
  // Parse each parameter
  $params = explode('|', $text);
  foreach ($params as $param)
  {
    list( $username, $namespace ) = extractParamaters( $param );

    $username = Title::newFromText( $username );
    $username = is_object( $username ) ? $username->getText() : '';

    $uid = User::idFromName( $username );

    if ($uid != 0) {
      $total = editsByNumber( $uid );
      $totalall = $totalall + $total;
    } else {
      $total = editsByName( $username );

      if ($uid != $total) {
        $totalall = $totalall + $total;
      } else {
        $totalall = -1;
        break;
      }
    }
  }

  if ($totalall != -1) {
    global $wgLang;

	  /* @var Language $wgLang */
    $ret = $wgLang->formatNum( $totalall );
  } else {
    $ret = "Benutzer nicht bekannt";
  }

  return $ret ;
}

function counting_useredit_topten( $text ) {
  global $wgVersion, $wgUser, $wgLang;

  if ( version_compare( $wgVersion, '1.5beta4', '<' ) ) {
    $ret = "1.5.x  of MediaWiki required";
    return $ret ;
  }

//  $wgParser->disableCache();

  $skin = $wgUser->getSkin();

  $ret  = '<ol>';
  $dbr  =& wfGetDB( DB_SLAVE );
  $rev  = $dbr->tableName( 'revision' );

  if (empty( $text )) {
    $limit= "LIMIT 0,11";
  }
  else {
    if (is_numeric( $text )) {
      $text = $text + 1;
      $limit= "LIMIT 0,$text";
    }
    else {
      $limit= "";
    }
  }

  # We fetch 11, even though we want 10, because we *don't* want MediaWiki default (and we might get it)
  $sql  = "SELECT COUNT(*) AS count, rev_user FROM $rev GROUP BY rev_user ORDER BY count DESC $limit";
  $res  = $dbr->query( $sql, "UserStatistics::counting_useredit_topten" );

  while( $row = $dbr->fetchObject( $res ) ) {
    if( $row->rev_user != 0 ) {
      $upt  = Title::makeTitle( NS_USER, User::whoIs($row->rev_user) );
      $cpt  = Title::makeTitle( NS_SPECIAL, 'Contributions/' . User::whoIs($row->rev_user) );
      $upl  = $skin->makeLinkObj( $upt, $upt->getText() );
      $tpl  = $skin->makeLinkObj( $upt->getTalkPage(), $wgLang->getNsText( NS_TALK ) );
      $cpl  = $skin->makeKnownLinkObj( $cpt, wfMsgHtml( 'contribslink' ) );
      $uec  =  $wgLang->formatNum( $row->count );
      $ret .= "<li>$upl ($tpl | $cpl) - $uec</li>";
    }
  }
  $ret .= '</ol>';

  return( $ret == '<ul></ul>' ? '' : $ret );
}

function first_useredit( $text ) {
  global $wgVersion;

  $ret = "hallo" ;

  if ( version_compare( $wgVersion, '1.5beta4', '<' ) ) {
    $ret = "1.5.x  of MediaWiki required";
    return $ret ;
  }

  list( $username, $namespace ) = extractParamaters( $text );

  $username = Title::newFromText( $username );
  $username = is_object( $username ) ? $username->getText() : '';

  $uid = User::idFromName( $username );

  if ($uid != 0) {
    $ret = editFirstDate( $uid );
  }

  return $ret ;
}

function last_useredit( $text ) {
  global $wgVersion;

  $ret = "" ;

  if ( version_compare( $wgVersion, '1.5beta4', '<' ) ) {
    $ret = "1.5.x  of MediaWiki required";
    return $ret ;
  }

//  $wgParser->disableCache();

  list( $username, $namespace ) = extractParamaters( $text );

  $username = Title::newFromText( $username );
  $username = is_object( $username ) ? $username->getText() : '';

  $uid = User::idFromName( $username );

  if ($uid != 0) {
    $ret = editLastDate( $uid );
  }

  return $ret ;
}


function counting_usercreate( $text, $params = array() ) {
  global $wgVersion, $wgMySQL40Userright;

  if ( version_compare( $wgVersion, '1.5beta4', '<' ) ) {
    $ret = "1.5.x  of MediaWiki required";
    return $ret ;
  }

  $dbr =& wfGetDB( DB_SLAVE );

  if ( version_compare( $dbr->getServerVersion(), '4.1', '<' ) ) {
    if ( version_compare( $dbr->getServerVersion(), '4.0', '<' ) ) {
      $ret = "4.0 or higher of MySQL required";
      return $ret;
    }
    else {
      if (!empty($wgMySQL40Userright)) {
//        return counting_usercreate_4_0_x ( $text, $params );
      }
      else {
        $ret = "DBUser need user right DROP and CREATE_TMP_TABLE";
        return $ret;
      }
    }
  }

  list( $username, $namespace ) = extractParamaters( $text );

  $username = Title::newFromText( $username );
  $username = is_object( $username ) ? $username->getText() : '';

  $uid = User::idFromName( $username );

  if ($uid != 0) {
    global $wgLang;

    if (isset( $params['all'] )) {
      $total = createsByUserAll( $uid );
    }
    else {
      $total = createsByUser( $uid );
    }

	  /* @var Language $wgLang */
    $ret = $wgLang->formatNum( $total );
  } else {
    $ret = "Benutzer nicht bekannt";
  }

  return $ret ;
}

/**
 * Compute and return the total edits in all namespaces
 *
 * @access private
 *
 * @param array $nscount An associative array
 * @return int
 */
function getTotal( $nscount ) {
  $total = 0;
  foreach ( array_values( $nscount ) as $i )
    $total += $i;

  return $total;
}

/**
 * Parse the username and namespace parts of the input and return them
 *
 * @access private
 *
 * @param string $par
 * @return array
 */
function extractParamaters( $par ) {
  global $wgContLang;

  @list($user, $namespace) = explode( '/', $par, 2 );

  // str*cmp sucks
  if ( isset( $namespace ) )
    $namespace = $wgContLang->getNsIndex( $namespace );

  return array( $user, $namespace );
}

/**
 * Count the number of edits of a userid
 *
 * @param int $uid The user ID to check
 * @return array
 */
function editsByNumber( $uid ) {
   $ret = '';

   $service = new UserStatsService( $uid );
   $stats = $service->getStats();

  if ( !empty( $stats ) ) {
	$ret = $stats['edits'];
  }

  return $ret;
}

/**
 * First edit of a user
 *
 * @param int $uid The user ID to check
 * @return array
 */
function editFirstDate( $uid ) {
  global $wgLang;

  $ret = "";

   $service = new UserStatsService( $uid );
   $stats = $service->getStats();

   if ( !empty( $stats ) ) {
	   /* @var Language $wgLang */
	$ret = $wgLang->timeanddate( wfTimestamp(TS_MW, $stats['firstContributionTimestamp']), true);
   }

   return $ret;
}

/**
 * Last edit of a user
 *
 * @param int $uid The user ID to check
 * @return array
 */
function editLastDate( $uid ) {
  global $wgLang;

  $ret = "";

  $dbr = wfGetDB( DB_SLAVE );
  $timestamp = $dbr->selectField(
	'revision',
	'rev_timestamp',
	array( 'rev_user' => $uid ),
	__METHOD__,
	array( 'ORDER BY' => 'rev_timestamp DESC', 'LIMIT' => 1 )
  );

  if ($timestamp)  {
	  /* @var Language $wgLang */
    $ret = $wgLang->timeanddate( wfTimestamp(TS_MW, $timestamp), true);
  }

  return $ret;
}

/**
 * Count the number of edits of a username
 *
 * @param string $usName The username to check
 * @return array
 */
function editsByName( $usName ) {
  $ret = '';

  $user = User::newFromName( $usName );

  if ( $user instanceof User ) {
	$ret = editsByNumber( $user->getId() );
  }

  return $ret;
}

/**
 * Count the number of creates of a user
 *
 * @param int $uid The user ID to check
 * @return array
 */
function createsByUser( $uid ) {
  $db = wfGetDB( DB_SLAVE );
  $revision = $db->tableName( 'revision' );
  $page = $db->tableName( 'page' );

  $sql = "SELECT COUNT(*) AS Counter FROM (SELECT MIN(rev_id), rev_user, rev_page FROM " .
         "$revision GROUP BY rev_page ORDER BY rev_page, rev_timestamp) AS temp, $page " .
         "WHERE rev_user = $uid AND rev_page = page_id AND page_is_redirect=0 AND page_namespace = 0 ORDER BY rev_page";
  $res = $db->query( $sql, "UserStatistics::createsByUser" );

  $obj = $db->fetchObject( $res );
  $nscount = 0;
  if ($obj)  {
    $nscount = $obj->Counter;
  }

  $db->freeResult( $res );

  return $nscount;
}

/**
 * Count the number of creates of a user
 *
 * @param int $uid The user ID to check
 * @return array
 */
function createsByUserAll( $uid ) {
  $db = wfGetDB( DB_SLAVE );
  $revision = $db->tableName( 'revision' );
  $page = $db->tableName( 'page' );

  $sql = "SELECT COUNT(*) AS Counter FROM (SELECT MIN(rev_id), rev_user, rev_page FROM " .
         "$revision GROUP BY rev_page ORDER BY rev_page, rev_timestamp) AS temp, $page " .
         "WHERE rev_user = $uid AND rev_page = page_id AND page_is_redirect=0 ORDER BY rev_page";
  $res = $db->query( $sql, "UserStatistics::createsByUser" );

  $obj = $db->fetchObject( $res );
  $nscount = 0;
  if ($obj)  {
    $nscount = $obj->Counter;
  }

  $db->freeResult( $res );

  return $nscount;
}
