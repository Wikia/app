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
		CLOSE_DELETE   = 2;

	private
		$mTitle,
		$mWikis     = array(),
		$mTmpl,
		$mStep      = 1,
		$mAction,
		$mErrors    = array(),
		$mRedirects = array();




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

		if( !$wgUser->isAllowed( 'wikifactory' ) ) {
			$this->displayRestrictionError();
			$fail = true;
		}

		if( !$fail ) {
			$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CloseWiki' );
		}

		/**
		 * initialize template class
		 */
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
		}
		else {
			/**
			 * show empty form
			 */
		}
		wfProfileOut( __METHOD__ );
		return !$fail;
	}

	/**
	 * multiple wikis can be posted
	 */
	private function parseRequest( ) {
		global $wgRequest, $wgOut;

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
		}
		else {
			$this->mAction = $wgRequest->getVal( "action", 0 );
		}
		$this->mRedirects = $wgRequest->getArray( "redirects", array() );
	}

	/**
	 * @access private
	 */
	private function doConfirm() {
		global $wgRequest, $wgOut;

		$this->mTmpl->reset();
		$this->mTmpl->set( "wikis",     $this->mWikis );
		$this->mTmpl->set( "title",     $this->mTitle );
		$this->mTmpl->set( "action",    $this->mAction );
		$this->mTmpl->set( "errors",    $this->mErrors );
		$this->mTmpl->set( "actions",   array( "Closing", "Closing and Redirecting", "Closing and Deleting") );
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
		if( $this->mAction == self::CLOSE_REDIRECT ) {
			$valid = true;
			print_pre( $this->mRedirects );
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
					}
				}
			}
			if( !$valid ) {
				/**
				 * back to form
				 */
				$this->doConfirm();
			}
			else {
				/**
				 * do other action
				 */
				switch( $this->mAction ) {
					case self::CLOSE:
						$this->doClose();
						break;
					case self::CLOSE_REDIRECT:
						$this->doCloseAndRedirect();
						break;
					case self::CLOSE_DELETE:
						$this->doCloseAndDelete();
						break;
				}
			}
		}
	}

	private function doClose() {

	}

	private function doCloseAndRedirect() {

	}

	private function doCloseAndDelete() {

	}
}
