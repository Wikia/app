<?php

class SpecialAdManagerZones extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'AdManagerZones', 'admanager' );
	}

	/**
	 * Show the special page
	 *
	 * @param $query Mixed: parameter passed to the special page or null
	 */
	public function execute( $query ) {
		global $wgUser, $wgOut;

		// Check that the user is allowed to access this special page
		if ( !$wgUser->isAllowed( 'admanager' ) ) {
			$wgOut->permissionRequired( 'admanager' );
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Set the page title, robot policies, etc.
		$this->setHeaders();

		// Add CSS via ResourceLoader
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$wgOut->addModuleStyles( 'mediawiki.special' );
		}

		$fullTableName = AD_ZONES_TABLE;
		$dbr = wfGetDB( DB_SLAVE );
		if ( AdManagerUtils::checkForAndDisplayError( $dbr->tableExists( $fullTableName ), 'admanager_notable' ) ) {
			return;
		}

		$this->doSpecialAdManagerZones();
	}

	function doSpecialAdManagerZones() {
		global $wgRequest;

		$errors = array();

		if ( $wgRequest->getCheck( 'submitted' ) ) {
			$this->zones = explode( "\n", trim( $wgRequest->getVal( 'zones' ) ) );
			foreach ( $this->zones as $zone ) {
				$zone = trim( $zone );
				if ( !is_numeric( $zone ) ) {
					$errors['admanager_zonenotnumber'][] = $zone;
				}
			}
			if ( empty( $errors ) ) {
				$this->addZones();
			}
		}

		$this->showForm( $errors );
	}

	function addZones() {
		global $wgOut;

		$zones = $this->zones;

		$dbw = wfGetDB( DB_MASTER );
		$fullTableName = AD_ZONES_TABLE;

		$dbw->delete( $fullTableName, '*', __METHOD__ );
		$text = "<div class=\"successbox\">\n";
		foreach ( $zones as $zone ) {
			if ( $zone ) {
				$dbw->insert(
					$fullTableName,
					array( 'ad_zone_id' => $zone ),
					__METHOD__
				);
				$text .= '* ' . wfMsg( 'admanager_addedzone' ) . " $zone";
			}
		}
		$text .= "</div><br clear=\"both\" />";
		$wgOut->addWikiText( $text );
	}

	function showForm( array $errors ) {
		global $wgOut;

		if ( empty( $errors ) ) {
			$wgOut->addWikiMsg( 'admanagerzones_docu' );
		} else {
			$text = "<div class=\"errorbox\">\n";
			foreach ( $errors as $message => $pageTitles ) {
				foreach ( $pageTitles as $pageTitle ) {
					$text .= wfMsg( $message, $pageTitle ) . '<br />';
				}
			}
			$text .= "</div><br clear=\"both\" />";
			$wgOut->addWikiText( $text );
		}

		$fullTableName = AD_ZONES_TABLE;
		$dbr = wfGetDB( DB_SLAVE );
		$current = $dbr->select(
			$fullTableName,
			array( '*' ),
			array(),
			__METHOD__
		);

		// Fetch current table into array
		$currentArray = array();
		while ( $currentRow = $current->fetchObject() ) {
			$currentArray[] = $currentRow->ad_zone_id;
		}

		$display = '';
		foreach ( $currentArray as $zone ) {
			$display .= "$zone\n";
		}

		$text =	Xml::openElement( 'form', array( 'id' => 'admanagerzones', 'action' => $this->getTitle()->getFullURL(), 'method' => 'post' ) ) . "\n" .
			AdManagerUtils::hiddenField( 'title', $this->getTitle()->getPrefixedText() ) .
			AdManagerUtils::hiddenField( 'submitted', 1 );
		$text .= Xml::textarea( 'zones' , $display, 25, 20, array( 'style' => 'width: auto; margin-bottom: 1em;' ) );
		$text .= Xml::element( 'br' );
		$text .= Xml::submitButton( wfMsg( 'admanager_submit' ) );
		$text .= Xml::closeElement( 'form' );
		$text .= Xml::element( 'br' );

		$wgOut->addHTML( $text );

		$wgOut->addWikiMsg( 'admanager_gotoads' );
	}
}