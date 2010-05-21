<?php
/**
 * @package MediaWiki
 * @subpackage MultiLookup
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named MultiLookup.\n";
	exit( 1 ) ;
}

class MultipleLookupCore {
	var $mUsername, $mNumRecords;

	public function __construct( $username ) {
		$this->mUsername = $username;
	}

	/* return if such user exists */
	public function checkIp() {
		global $wgUser;

		if ( empty( $this->mUsername ) ) {
			return false;
		}

		/* for all those anonymous users out there */
		if ( $wgUser->isIP( $this->mUsername ) ) {
			return true ;
		}

		return false;
	}

	function checkUserActivity( $username ) {
		global $wgMemc, $wgExternalSharedDB, $wgStatsDB;
		$userActivity = "";
		$memkey = wfForeignMemcKey( $wgExternalSharedDB, null, "MultiLookup", "UserActivity", $username );
		$cached = $wgMemc->get( $memkey );
		if ( !is_array ( $cached ) || MULTILOOKUP_NO_CACHE ) {
			$dbs = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
			if ( !is_null( $dbs ) ) {

				$oRow = $dbs->selectRow(
					array( "city_ip_activity" ),
					array( "ca_latest_activity" ),
					array( "ca_ip_text" => $username ),
					__METHOD__
				);

				if ( isset( $oRow->ca_latest_activity ) ) {
					$userActivity = $oRow->ca_latest_activity;
				}

				if ( !MULTILOOKUP_NO_CACHE ) {
					$wgMemc->set( $memkey, $userActivity, 60 * 3 );
				}
			}
		} else {
			$userActivity = $cached;
		}

		return $userActivity;
	}

	private function __getDBname( $database ) {
		global $wgDBname;
		return ( ML_TEST ) ? $wgDBname : $database;
	}

	/* fetch all contributions from that given database */
	function fetchContribs ( $database ) {
		global $wgOut, $wgRequest, $wgLang, $wgMemc;
		wfProfileIn( __METHOD__ );

		/* todo since there are now TWO modes, we need TWO keys to rule them all */
		$key = "$database:MultiLookup" . $this->mUsername;
		$cached = $wgMemc->get( $key );
		$fetched_data = array ();

		if ( !is_array( $cached ) || MULTILOOKUP_NO_CACHE ) {
			/* get that data from database */
			$dbr =& wfGetDB( DB_SLAVE, array(), $this->__getDBname( $database ) );
			/* don't check these databases - their structure is not overly compactible */
			$res = $dbr->select(
				"recentchanges",
				array( 'rc_user_text as user_name', 'max(rc_timestamp) as rc_timestamp' ),
				array(
					'rc_ip' => $this->mUsername
				),
				__METHOD__,
				array(
					'GROUP BY' => 'rc_user_text',
					'ORDER BY'	=> 'rc_user_text'
				)
			);

			$result_found_already = false ;
			$wikia = WikiFactory::getWikiByDB( $database );
			if ( !empty( $res ) && !empty( $wikia ) ) {
				while ( $row = $dbr->fetchObject( $res ) ) {
					$row->rc_database = $database;
					$row->rc_url = $wikia->city_url;
					$row->rc_city_title = $wikia->city_title;
					$row->log_comment = false;
					$fetched_data[$row->user_name] = $row;
				}
				$dbr->freeResult( $res );
				$this->mNumRecords = count( $fetched_data );
				$result_found_already = ( $this->mNumRecords > 	0 );
				unset( $res ) ;

				if ( !MULTILOOKUP_NO_CACHE ) {
					$wgMemc->set( $key, $fetched_data, 60 * 15 );
				}
			}
		} else {
			/* get that data from memcache */
			$this->mNumRecords = count( $cached ) ;
			$fetched_data = $cached ;
		}

		wfProfileOut( __METHOD__ );
		return $fetched_data;
	}

	/* a customized version of makeKnownLinkObj - hardened'n'modified for all those non-standard wikia out there */
	private function produceLink ( $nt, $text = '', $query = '', $url = '', $sk, $wiki_meta, $namespace, $article_id ) {
		global $wgContLang, $wgOut, $wgMetaNamespace ;

		$str = $nt->escapeLocalURL ( $query ) ;

		/* replace empty namespaces, namely: "/:Something" of "title=:Something" stuff it's ugly, it's brutal, it doesn't lead anywhere */
		$old_str = $str ;
		$str = preg_replace ( '/title=:/i', "title=ns-" . $namespace . ":", $str ) ;
		$append = '' ;
		/* if found and replaced, we need that curid */
		if ( $str != $old_str ) {
			$append = "&curid=" . $article_id ;
		}
		$old_str = $str ;
		$str = preg_replace ( '/\/:/i', "/ns-" . $namespace . ":", $str ) ;
		if ( $str != $old_str ) {
			$append = "?curid=" . $article_id ;
		}

		/* replace NS_PROJECT space - it gets it from $wgMetaNamespace, which is completely wrong in this case  */
		if ( NS_PROJECT == $nt->getNamespace() ) {
			$str = preg_replace ( "/$wgMetaNamespace/", "Project", $str ) ;
		}

		$part = explode ( "php", $str ) ;
		if ( $part[0] == $str ) {
			$part = explode ( "wiki/", $str ) ;
			$u = $url . "wiki/" . $part[1] ;
		} else {
			$u = $url . "index.php" . $part[1] ;
		}

		if ( $nt->getFragment() != '' ) {
			if ( $nt->getPrefixedDbkey() == '' ) {
				$u = '';
				if ( '' == $text ) {
					$text = htmlspecialchars( $nt->getFragment() );
				}
			}

			$anchor = urlencode( Sanitizer::decodeCharReferences( str_replace( ' ', '_', $nt->getFragment() ) ) );
			$replacearray = array(
 				'%3A' => ':',
				 '%' => '.'
		 	);
			$u .= '#' . str_replace( array_keys( $replacearray ), array_values( $replacearray ), $anchor );
		}
		if ( $text != '' ) {
			$r = "<a href=\"{$u}{$append}\">{$text}</a>";
		} else {
			$r = "<a href=\"{$u}{$append}\">" . urldecode( $u ) . "</a>";
		}

		return $r;
	}

	public function produceLine( $row, $ip ) {
		global $wgLang, $wgOut, $wgRequest, $wgUser;
		$sk = $wgUser->getSkin();
		$page_user = Title::makeTitle ( NS_USER, $row->user_name );
		$page_contribs = Title::makeTitle ( NS_SPECIAL, "Contributions/{$row->user_name}" );

		$meta = strtr( $row->rc_city_title, ' ', '_' );
		$contrib = $this->produceLink ( $page_contribs, $row->user_name, '', $row->rc_url, $sk, $meta, 0, 0 );
		return array( 'link' => $contrib, 'last_edit' => $wgLang->timeanddate( wfTimestamp( TS_MW, $row->rc_timestamp ), true ) );
	}
}

function wfLoadMultiLookupLink( $id, $nt, &$links ) {
	global $wgUser;
	if ( $id == 0 && $wgUser->isAllowed( 'multilookup' ) ) {
		wfLoadExtensionMessages( 'MultiLookup' );
		$attribs = array(
			'href' => 'http://community.wikia.com/wiki/Special:MultiLookup?target=' . urlencode( $nt->getText() ),
			'title' => wfMsg( 'multilookupselectuser' )
		);
		$links[] = Xml::openElement( 'a', $attribs ) . wfMsg( 'multilookup' ) . Xml::closeElement( 'a' );
	}
	return true;
}
