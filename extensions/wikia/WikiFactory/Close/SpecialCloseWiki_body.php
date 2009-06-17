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

	const
		CLOSE          = 0,
		CLOSE_REDIRECT = 1,
		CLOSE_DELETE   = 2,
		CLOSE_ACTION   = 0,
		DELETE_ACTION  = -1,
		REDIR_ACTION   = 2;

	private
		$mTitle,
		$mWikis     = array(),
		$mTmpl,
		$mStep      = 1,
		$mAction,
		$mErrors    = array(),
		$mRedirects = array(),
		$mActionList = array( "Closing", "Closing and Redirecting", "Closing and Deleting");


	/**
	 * constructor
	 */
	public function  __construct() {
		parent::__construct( "CloseWiki", "wikifactory", true );
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
		wfLoadExtensionMessages("WikiFactory");
		$this->setHeaders();

		$fail = false;
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			$fail = true;
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

		if( $this->mStep == 1 ) {
			/**
			 * check which action was requested
			 */
			foreach( array_keys( $wgRequest->getValues() ) as $value ) {
				if( preg_match( "/^submit(\d+)$/", $value, $matches ) ) {
					$this->mAction = $matches[1];
					break;
				}
			}
			#---
		} else {
			$this->mAction = $wgRequest->getVal( "action", 0 );
		}
		$this->mRedirects = $wgRequest->getArray( "redirects", array() );
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
		$this->mTmpl->set( "actions",   $this->mActionList );
		$this->mTmpl->set( "redirects", $this->mRedirects );

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
		$newWikis = array();
		if( $this->mAction == self::CLOSE_REDIRECT ) {
			foreach( $this->mWikis as $wiki ) {
				Wikia::log( __METHOD__, $wiki->city_id, $this->mRedirects[ $wiki->city_id ] );
				if( !isset( $this->mRedirects[ $wiki->city_id ] ) ) {
					$valid = false;
					$this->mErrors[ $wiki->city_id ] = "";
				}
				else {
					$city_id = WikiFactory::DomainToID( trim( $this->mRedirects[ $wiki->city_id ] ) );
					if( !$city_id ) {
						Wikia::log( __METHOD__, $wiki->city_id, "not exists" );
						$valid = false;
						$this->mErrors[ $wiki->city_id ] = $this->mRedirects[ $wiki->city_id ];
					} else {
						$newWikis[ $wiki->city_id ] = $city_id;
					}
				}
			}
		}

		if( !$valid ) {
			/**
			 * back to form
			 */
			$this->doConfirm();
		} else {
			/**
			 * do other action
			 */
			if ( !empty($this->mWikis) ) {
				switch( $this->mAction ) {
					case self::CLOSE:
						$this->doClose();
						break;
					case self::CLOSE_REDIRECT:
						$this->doCloseAndRedirect($newWikis);
						break;
					case self::CLOSE_DELETE:
						$this->doCloseAndDelete();
						break;
				}
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
			$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalArchiveDB );
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

	/**
	 * close Wiki(s)
	 * @access private
	 */
	private function doClose() {
		global $wgRequest, $wgOut;
		wfProfileIn( __METHOD__ );

		$WFTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
		#---
		$output = "";
		if ( is_array($this->mWikis) && !empty($this->mWikis) ) {
			$output = Xml::openElement( 'ul', null );
			foreach( $this->mWikis as $wiki ) {
				Wikia::log( __METHOD__, "Closing: {$wiki->city_description} (url: {$wiki->city_url}) (id: {$wiki->city_id}) (dbname: {$wiki->city_dbname})" );
				#-- set public to 0
				$res = WikiFactory::setPublicStatus(self::CLOSE_ACTION, $wiki->city_id);
				if ($res === self::CLOSE_ACTION) {
					$output .= Xml::tags(
						'li',
						array( 'style' => 'list-style:none' ),
						wfMsgExt( 'closewiki-wiki-closed', array('parse'), $wiki->city_description, $wiki->city_url )
					);
				}
				WikiFactory::clearCache($wiki->city_id);
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
		wfProfileOut( __METHOD__ );
	}

	/**
	 * close and redirect Wiki(s)
	 * @access private
	 */
	private function doCloseAndRedirect($newWikis = array()) {
		global $wgRequest, $wgOut;
		wfProfileIn( __METHOD__ );

		$WFTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
		#---
		$output = "";
		if ( is_array($this->mWikis) && !empty($this->mWikis) && !empty($newWikis) ) {
			$output = Xml::openElement( 'ul', null );
			foreach( $this->mWikis as $wiki ) {
				Wikia::log( __METHOD__, "Closing: {$wiki->city_description} (url: {$wiki->city_url}) (id: {$wiki->city_id}) (dbname: {$wiki->city_dbname}) and redirecting to: {$this->mRedirects[$wiki->city_id]} (id: {$newWikis[$wiki->city_id]}) " );
				#-- move to archive
				$this->moveOldDomains( $wiki->city_id, $newWikis[$wiki->city_id] );
				#-- set new city ID in city_domains
				$isMoved = WikiFactory::redirectDomains( $wiki->city_id, $newWikis[$wiki->city_id] );
				if ( !empty($isMoved) ) {
					#-- set public to 0
					$res = WikiFactory::setPublicStatus(self::REDIR_ACTION, $wiki->city_id);
					if ($res === self::REDIR_ACTION) {
						$output .= Xml::tags(
							'li',
							array( 'style' => 'list-style:none' ),
							wfMsgExt(
								'closewiki-wiki-closed_redirect',
								array('parse'),
								$wiki->city_description,
								$wiki->city_url,
								sprintf( "%s%s", "http://", $this->mRedirects[ $wiki->city_id ] )
							)
						);
						WikiFactory::clearCache($wiki->city_id);
						WikiFactory::clearCache($newWikis[$wiki->city_id]);
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
		wfProfileOut( __METHOD__ );
	}

	/**
	 * close and remove Wiki(s)
	 * @access private
	 */
	private function doCloseAndDelete() {
		global $wgRequest, $wgOut;
		wfProfileIn( __METHOD__ );

		$WFTitle = Title::makeTitle( NS_SPECIAL, 'WikiFactory' );
		#---
		$output = "";
		if ( is_array($this->mWikis) && !empty($this->mWikis) ) {
			$output = Xml::openElement( 'ul', null );
			foreach( $this->mWikis as $wiki ) {
				Wikia::log( __METHOD__, "Closing and removing: {$wiki->city_description} (url: {$wiki->city_url}) (id: {$wiki->city_id}) (dbname: {$wiki->city_dbname})" );
				#-- move to archive
				$this->moveOldDomains( $wiki->city_id, self::DELETE_ACTION );
				#-- clear city_domains
				if ( WikiFactory::removeDomain( $wiki->city_id ) ) {
					#-- set public to -1
					$res = WikiFactory::setPublicStatus(self::DELETE_ACTION, $wiki->city_id);
					if ($res === self::DELETE_ACTION) {
						$output .= Xml::tags(
							'li',
							array( 'style' => 'list-style:none' ),
							wfMsgExt( 'closewiki-wiki-closed_removed', array('parse'), $wiki->city_description, $wiki->city_url )
						);
					}
					WikiFactory::clearCache($wiki->city_id);
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
		global $wgOut, $wgStylePath, $wgStyleVersion, $wgExtensionsPath;
		
		wfProfileIn( __METHOD__ );
		if ( $this->closedWiki === false ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/form.css?{$wgStyleVersion}\" />" );

		$dbDumpUrl = sprintf("http://wikistats.wikia.com/dbdumps/%s/%s/%s/",
			substr( $this->closedWiki->city_dbname, 0, 1),
			substr( $this->closedWiki->city_dbname, 0, 2),
			$this->closedWiki->city_dbname
		);

		$res = (($ftest = @fopen($dbDumpUrl, ‘r’)) === false) ? false : @fclose($ftest);
		$this->mTmpl->reset();
		$this->mTmpl->set_vars( array(
			"wgExtensionsPath" => $wgExtensionsPath,
			"wgStyleVersion" => $wgStyleVersion,
			"dbDumpUrl" => $dbDumpUrl,
			"dbDumpExist" => $res
		));

		$wgOut->setPageTitle( wfMsg('closed-wiki') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addHtml($this->mTmpl->execute("close-info"));
		
		wfProfileOut( __METHOD__ );
	}
}
