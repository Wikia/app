<?php
/**
 * Main part of Special:CloseWiki
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia Inc.
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia Inc.
 *
 * @copyright © 2009, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

class CloseWikiPage extends SpecialPage {

	const CLOSED_WIKI_DOMAIN_PREFIX = 'old';

	public $closedWiki;

	private
		$mTitle,
		$mWikis     	= array(),
		$mTmpl,
		$mStep      	= 1,
		$mAction,
		$mReason,
		$mErrors    	= array(),
		$mRedirects 	= array(),
		$mRedirect		= "",
		$mFlags 		= array(),
		$mUrlDump		= "http://s3.amazonaws.com/wikia_xml_dumps/";

	/**
	 * constructor
	 */
	public function  __construct() {
		parent::__construct( "CloseWiki", "wikifactory", false );
	}

	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 *
	 */
	public function execute( $subpage ) {

		global $wgUser, $wgOut, $wgRequest;

		wfProfileIn( __METHOD__ );
		$this->setHeaders();

		$fail = false;
		if( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			$fail = true;
		}

		if ( !empty($subpage) && (strpos($subpage, 'information') === 0 ) ) {
			# don't check permission - show all users
		} else {
			if( !$wgUser->isAllowed( 'wikifactory' ) ) {
				$this->displayRestrictionError();
				$fail = true;
			}
		}

		if( !$fail ) {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CloseWiki' );
		}

		/**
		 * initialize template class
		 */
		if ( empty($fail) ) {
			$this->mTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			if( $wgRequest->wasPosted() ) {
				/**
				 * check if something was posted
				 */
				$this->parseRequest();
				if( $this->mStep != 1 ) {
					$this->doProcess();
				}
				else {
					$this->doConfirm();
				}
			}
			elseif( !empty( $subpage ) ){
				/**
				 * if not posted then we check if $subpage is set to something
				 * reasonable
				 */
				if (strpos($subpage, 'information') === 0 ) {
					if( strpos( $subpage, "/" ) ) {
						$parts = explode( "/", $subpage, 2 );
						if( is_array( $parts ) && sizeof( $parts ) == 2 ) {
							$closedWiki = $parts[1];
							$this->closedWiki = false;
							if ($this->isClosed($closedWiki) === true) {
								$this->showClosedMsg();
							}
						}
					}
				}
			}
			else {
				/**
				 * show empty form
				 */
				$oWFTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
				$wgOut->redirect( $oWFTitle->getLocalURL() );
			}
		}
		wfProfileOut( __METHOD__ );
		return !$fail;
	}

	/**
	 * multiple wikis can be posted
	 */
	private function parseRequest( ) {
		global $wgRequest, $wgOut;

		wfProfileIn( __METHOD__ );
		$this->mStep = $wgRequest->getVal( "step", 1 );
		$this->mReason = $wgRequest->getVal( "close_reason" );

		/**
		 * get numeric values for checkboxes
		 */
		$wikis = $wgRequest->getArray( "wikis", array() );
		if( is_array( $wikis ) ) {
			foreach( $wikis as $city_id ) {
				$wiki = WikiFactory::getWikiByID( $city_id );
				if( $wiki ) {
					$this->mWikis[] = $wiki;
				}
			}
		}

		/**
		 * check which action was requested
		 */
		$flags = $wgRequest->getArray( "close_flags", array() );
		foreach ($flags as $flag) {
			if ( in_array($flag, array(
				WikiFactory::FLAG_CREATE_DB_DUMP,
				WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE,
				WikiFactory::FLAG_DELETE_DB_IMAGES,
				WikiFactory::FLAG_FREE_WIKI_URL,
				WikiFactory::FLAG_HIDE_DB_IMAGES,
				WikiFactory::FLAG_REDIRECT
			) ) ) {
				$this->mFlags[$flag] = $flag;
			}
		}
		$this->mRedirect = $wgRequest->getVal( "redirect_url", "" );
		#---
		wfProfileOut( __METHOD__ );
	}

	/**
	 * @access private
	 */
	private function doConfirm() {
		global $wgRequest, $wgOut;

		#---
		$this->mTmpl->reset();
		$this->mTmpl->set( "wikis",     $this->mWikis );
		$this->mTmpl->set( "title",     $this->mTitle );
		$this->mTmpl->set( "action",    $this->mAction );
		$this->mTmpl->set( "errors",    $this->mErrors );
		$this->mTmpl->set( "redirect", 	$this->mRedirect );
		$this->mTmpl->set( "flags", 	$this->mFlags );
		$this->mTmpl->set( "reason", 	$this->mReason );

		$wgOut->addHTML( $this->mTmpl->render( "confirm" ) );
	}

	/**
	 * @access private
	 */
	private function doProcess() {
		/**
		 * if we redirecting check if target wikia exists and is active wiki
		 */
		$valid = true;
		$newWiki = 0;
		if ( isset($this->mRedirect) && !empty($this->mRedirect) ) {
			if ('http://' == substr($this->mRedirect, 0, 7)) {
				$this->mRedirect = str_replace('http://', '', $this->mRedirect);
			}
			Wikia::log( __METHOD__, "check domain {$this->mRedirect}" );
			$city_id = WikiFactory::DomainToID( trim( $this->mRedirect ) );
			if( !$city_id ) {
				Wikia::log( __METHOD__, "domain doesn't exist" );
				$valid = false;
				$this->mErrors[] = wfMsg('closed-wiki-invalid-redirect-url',$this->mRedirect);
			} else {
				$newWiki = $city_id;
			}
		}

		if( $valid === false ) {
			/**
			 * back to form
			 */
			$this->doConfirm();
		} else {
			/**
			 * do other action
			 */
			if ( !empty($this->mWikis) ) {
				$this->doClose($newWiki);
			}
		}
	}

	/**
	 * @access private
	 */
	private function moveOldDomains($wikiaId, $newWikiaId = null, $remove = 0) {
		global $wgExternalArchiveDB;

		$aDomainsToMove = WikiFactory::getDomains( $wikiaId );

		if ( !empty($aDomainsToMove) ) {
			#-- connect to dataware;
			$dbs = wfGetDB( DB_MASTER, array(), $wgExternalArchiveDB );
			if (!is_null($dbs)) {
				#-- save domains in archive DB
				$dbs->begin();
				foreach ($aDomainsToMove as $domain) {
					$dbs->insert(
						"city_domains",
						array(
							"city_id" => $wikiaId,
							"city_domain" => $domain,
							"city_timestamp" => wfTimestampNow(),
							"city_new_id" => $newWikiaId,
						),
						__METHOD__
					);
				}
				$dbs->commit();
			}
		}
	}

	private function prefixMainDomain( $cityId ) {
		$mainDomain = substr( WikiFactory::getVarValueByName("wgServer", $cityId), 7 );
		if(!empty($mainDomain)) {
			$index = null;
			do {
				$prefixedDomain = self::CLOSED_WIKI_DOMAIN_PREFIX . ( !empty($index) ? $index : '' ) . "." . $mainDomain;
				$exists = WikiFactory::DomainToID( $prefixedDomain );
				$index = is_null($index) ? 1 : ( $index + 1 );
			} while( !empty($exists) );

			WikiFactory::addDomain( $cityId, $prefixedDomain );
			WikiFactory::setmainDomain( $cityId, $prefixedDomain );

			return $prefixedDomain;
		}
		return null;
	}

	/**
	 * close Wiki(s)
	 * @access private
	 */
	private function doClose( $newWiki = "" ) {
		global $wgRequest, $wgOut;
		wfProfileIn( __METHOD__ );

		$WFTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
		#---
		$output = "";
		if ( !empty($this->mWikis) ) {
			$output = Xml::openElement( 'ul', null );
			foreach( $this->mWikis as $wiki ) {
				Wikia::log( __METHOD__, "Closing: {$wiki->city_title} (url: {$wiki->city_url}) (id: {$wiki->city_id}) (dbname: {$wiki->city_dbname}) " );
				#-- move to archive
				$message = wfMsgExt( 'closewiki-wiki-closed', array('parse'), $wiki->city_title, $wiki->city_url );
				if ( !empty($newWiki) ) {
					Wikia::log( __METHOD__,  " ... and redirecting to: {$this->mRedirect} (id: {$newWiki})" );
					$this->moveOldDomains( $wiki->city_id, $newWiki );

					#-- add "old" prefix to main domain and set is as primary
					$prefixedDomain = $this->prefixMainDomain( $wiki->city_id );
					Wikia::log( __METHOD__,  " ... primary domain set to: {$prefixedDomain}" );

					#-- set new city ID in city_domains (except for just created "old" domain)
					$isMoved = WikiFactory::redirectDomains( $wiki->city_id, $newWiki, ( !empty( $prefixedDomain ) ? array( $prefixedDomain ) : array() ) );
					#---
					$message = wfMsgExt(
						'closewiki-wiki-closed_redirect',
						array('parse'),
						$wiki->city_title,
						$wiki->city_url,
						sprintf( "%s%s", "http://", $this->mRedirect )
					);
				}
				#-- set public to 0
				$status = ( isset($this->mFlags[WikiFactory::FLAG_HIDE_DB_IMAGES]) ) ? WikiFactory::HIDE_ACTION : WikiFactory::CLOSE_ACTION;
				#-- set flags as a number
				if (!empty($this->mFlags)) {
					$city_flags = 0;
					foreach ($this->mFlags as $flag) {
						$city_flags |= $flag;
					}
					WikiFactory::setFlags($wiki->city_id, $city_flags);
				}

				// Let's request the XML dump if needed
				if ( isset( $this->mFlags[WikiFactory::FLAG_CREATE_DB_DUMP] ) ) {
					DumpsOnDemand::queueDump( $wiki->city_id, isset( $this->mFlags[WikiFactory::FLAG_HIDE_DB_IMAGES] ), true );
				}

				if ( empty($this->mReason) ) {
					$this->mReason = "-";
				}
				$res = WikiFactory::setPublicStatus($status, $wiki->city_id, $this->mReason);
				if ($res === $status) {
					$output .= Xml::tags( 'li', array( 'style' => 'padding:4px;' ), $message );
					WikiFactory::clearCache($wiki->city_id);
					if ( !empty($newWiki) ) {
						WikiFactory::clearCache($newWiki);
					}
				}
			}
			$output .= Xml::closeElement( 'ul' );
		}

		$output .= Xml::element( 'input',
			array(
				'name' 		=> 'wiki-return',
				'type' 		=> 'button',
				'value' 	=> wfMsg( 'closewiki-return', wfMsg('wikifactory') ),
				'onclick' 	=> "window.location='{$WFTitle->getFullURL()}'",
			)
		);

		$wgOut->addHtml( $output );
		$aHookParams = [
			'city_id' => $wiki->city_id,
		];
		wfRunHooks( 'WikiFactoryWikiClosed', array( $aHookParams ) );
		wfProfileOut( __METHOD__ );
	}

	/*
	 * is closed Wiki
	 */
	function isClosed($dbname) {
		wfProfileIn( __METHOD__ );

		$res = false;
		$cityId = WikiFactory::DBtoID($dbname, true);
		if ( !empty($cityId) ) {
			$oRow = WikiFactory::getWikiByID($cityId);
			if ($oRow->city_public == 0) {
				$this->closedWiki = $oRow;
				$res = true;
			}
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	/*
	 * show closed message
	 */
	function showClosedMsg() {
		global $wgOut, $wgStylePath, $wgExtensionsPath;

		wfProfileIn( __METHOD__ );
		if ( $this->closedWiki === false ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$bShowDumps = false;
		$aFiles = array();

		if ( !($this->closedWiki->city_flags & WikiFactory::FLAG_HIDE_DB_IMAGES)
				&& $this->closedWiki->city_lastdump_timestamp >= DumpsOnDemand::S3_MIGRATION ) {
			$dumpInfo = DumpsOnDemand::getLatestDumpInfo($this->closedWiki->city_id);
			$extension = DumpsOnDemand::getExtensionFromCompression($dumpInfo?$dumpInfo['compression']:false);
			$aFiles = array(
				'pages_current'	=> "_pages_current.xml{$extension}",
				'pages_full'	=> "_pages_full.xml{$extension}",
			);

			foreach ( $aFiles as $sKey => $sValue ) {
				$aFiles[$sKey] = $this->mUrlDump . DumpsOnDemand::getPath( $this->closedWiki->city_dbname . $sValue );
			}

			$bShowDumps = true;
		}

		$this->mTmpl->reset();
		$this->mTmpl->set_vars( array(
			"wgExtensionsPath" => $wgExtensionsPath,
			"aDumps" => $aFiles,
			"bShowDumps" => $bShowDumps,
			"isDisabled" => (($this->closedWiki->city_flags == 0) && ($this->closedWiki->city_public == 0))
		) );

		$wgOut->setPageTitle( wfMsg('closed-wiki') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml($this->mTmpl->render("close-info"));

		wfProfileOut( __METHOD__ );
	}
}
