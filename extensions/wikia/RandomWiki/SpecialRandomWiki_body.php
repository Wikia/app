<?php

/**
 * RandomWiki
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @date 2009-01-30
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named RandomWiki.\n";
	exit( 1 );
}

class RandomWiki extends SpecialPage {
	const COOKIE_NAME_TOKEN = 'RandomWiki';
	const COOKIE_EXPIRY = 2; // hours

	private $mCookie = null;
	private $mData = null;

	public function __construct() {
		global $wgCookiePrefix;

		parent::__construct( 'RandomWiki' );
		$this->mCookieName = $wgCookiePrefix . self::COOKIE_NAME_TOKEN;
	}

	public function execute( $wikiID ) {
		global $wgOut, $wgRequest, $wgCityId, $wgUser;

		wfProfileIn( __METHOD__ );
		$this->setHeaders();
		$firstVisit = true;
		$wikiID = ( !empty( $wikiID ) ) ? ( int )$wikiID : $wgCityId;

		if ( isset( $_COOKIE[ $this->mCookieName ] ) ) {
			$this->mCookie = json_decode( $_COOKIE[ $this->mCookieName ] );
			$firstVisit = false;
		} else {
			$this->mCookie = new stdClass();
			$this->mCookie->origHub = null;
			$this->mCookie->langCode = null;
			$this->mCookie->history = array( );

			if ( !empty( $wikiID ) ) {
				$hub = WikiFactory::getCategory( $wikiID );

				if ( is_object( $hub ) ) {
					$this->mCookie->origHub = $hub->cat_id;
					$this->mCookie->langCode = WikiFactory::getWikiByID( $wikiID )->city_lang;
					$this->mCookie->history[ ] = $wikiID;
				}
			}
		}

		$this->loadData();
		$historyCount = count( $this->mCookie->history );

		// reset the history if the user visited all the possible targets
		if ( $historyCount >= $this->mData[ 'total' ] ) {
			$this->mCookie->history = array( $wikiID );
		}

		// if language other than English and list of targets exhausted fall back to english
		if (
			(
				( $historyCount >= $this->mData[ 'total' ] ) ||
				(
					( $this->mData[ 'total' ] == 0 ) &&
					(
						( count( $this->mData[ 'recommended' ] ) == 0 ) || !$firstVisit
					)
				)
			) &&
			$this->mCookie->langCode != 'en'
		) {
			$this->mCookie->langCode = 'en';
			$this->loadData();
		}

		$destinationID = null;
		$from = null;
		srand( time() );

		// pick a recommended wiki the first time
		if ( $firstVisit && !empty( $this->mData[ 'recommended' ] ) ) {
			$destinationID = $this->mData[ 'recommended' ][ array_rand( $this->mData[ 'recommended' ] ) ];
			$from = 'recommended';
		} elseif ( !empty( $this->mCookie->origHub ) && !empty( $this->mData[ 'hubs' ][ $this->mCookie->origHub ] ) ) {
			$currentHub = array_diff( $this->mData[ 'hubs' ][ $this->mCookie->origHub ], $this->mCookie->history );

			if ( count( $currentHub ) && ( count( $this->mCookie->history ) < RandomWikiHelper::TRACK_LIMIT ) ) {
				$destinationID = $currentHub[ array_rand( $currentHub ) ];
				$from = 'origHub';
			}
		}

		// in case no wiki has been selected in the previous block pick a wiki from a random hub
		if ( empty( $destinationID ) ) {
			$hubsCount = count( $this->mData[ 'hubs' ] );
			$hub = array_rand( $this->mData[ 'hubs' ], $hubsCount );

			if ( !is_array( $hub ) ) {
				$hub = array( $hub );
			}

			foreach ( $hub as $key ) {
				$tmpHub = array_diff( $this->mData[ 'hubs' ][ $key ], $this->mCookie->history );

				if ( !count( $tmpHub ) ) {
					continue;
				}

				$itemKey = array_rand( $tmpHub );
				$destinationID = $tmpHub[ $itemKey ];
				$from = "hub {$itemKey}";
			}
		}

		$this->mCookie->history[ ] = $destinationID;
		$cookieValue = json_encode( $this->mCookie );

		$wgRequest->response()->setcookie( self::COOKIE_NAME_TOKEN, $cookieValue, time() + ( 3600 * self::COOKIE_EXPIRY ) );

		$url = WikiFactory::getVarValueByName( 'wgServer', $destinationID );
		
		//FB#1033: avoid being sent to Special:WikiActivity when logged-in, see MyHomw::getInitialMainPage
		if ( $wgUser->isLoggedIn() ) {
			$url .= '?redirect=no';
		}

		// Redirect the user to a randomly-chosen wiki (or not if profiling requested)
		$profiling = $wgRequest->getInt( 'forceprofile', 0);

		if ( $profiling !== 1 ) {
			$wgOut->redirect( $url );
		}

		wfProfileOut( __METHOD__ );
	}

	private function loadData() {
		global $wgRequest;

		$this->mData = RandomWikiHelper::getData( ( $wgRequest->getText( 'action' ) == 'purge' ), $this->mCookie->langCode );
	}
}
