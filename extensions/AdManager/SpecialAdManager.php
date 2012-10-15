<?php

class SpecialAdManager extends SpecialPage {
	const NUM_BLANK_ROWS = 5;
	const BLANK = '----';

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'AdManager', 'admanager' );
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

		$dbr = wfGetDB( DB_SLAVE );
		$fullTableName = AD_TABLE;
		$fullTableNameZones = AD_ZONES_TABLE;
		if (
			AdManagerUtils::checkForAndDisplayError(
				$dbr->tableExists( $fullTableName ) &&
					$dbr->tableExists( $fullTableNameZones ),
				'admanager_notable'
			)
		)
		{
			return;
		}

		$currentZones = $dbr->select(
			$fullTableNameZones,
			array( '*' ),
			array(),
			__METHOD__
		);
		if ( AdManagerUtils::checkForAndDisplayError( $currentZones->numRows() > 0, 'admanager_noAdManagerZones' ) ) {
			return;
		}

		// Fetch current zones table into array
		$this->adManagerZones = array();
		while ( $currentRow = $currentZones->fetchObject() ) {
			$this->adManagerZones[] = $currentRow->ad_zone_id;
		}

		$this->adManagerZones[] = wfMsg( 'admanager_noads' );

		$this->doSpecialAdManager();
	}

	function doSpecialAdManager() {
		global $wgRequest;

		$errors = array();

		$this->target['Page'] = array();
		$this->target['Category'] = array();

		if ( $wgRequest->getCheck( 'submitted' ) ) {
			// Load user input and do error checking
			$tableTypes = array( 'Page', 'Category' );
			foreach ( $this->adManagerZones as $zone ) {
				foreach ( $tableTypes as $tableType ) {
					$titles = explode( "\n", trim( $wgRequest->getVal( "textarea_{$zone}_{$tableType}" ) ) );

					foreach ( $titles as $title ) {
						$title = trim( $title );
						if ( !$title ) {
							continue;
						}

						/*if ( $zone == wfMsg( 'admanager_noads' ) ) {
							continue;
						}*/

						if ( $tableType == 'Page' ) {
							$pageObject = Title::newFromText( trim( $title ) );
							if ( !$pageObject->exists() ) {
								$errors['admanager_invalidtargetpage'][] = $title;
							} else {
								$this->target['Page'][$zone][] = $title;
							}
						} else {
							$categoryObject = Category::newFromName( $title );
							if ( !$categoryObject->getID() ) {
								$errors['admanager_invalidtargetcategory'][] = $title;
							} else {
								$this->target['Category'][$zone][] = $title;
							}
						}
					}
				}
			}

			if ( empty( $errors ) ) {
				$this->addZoneToTitle();
				return;
			}
		}

		$this->showForm( $errors );
	}

	function addZoneToTitle() {
		global $wgOut;

		$dbw = wfGetDB( DB_MASTER );
		$fullTableName = AD_TABLE;

		$dbw->delete( $fullTableName, '*', __METHOD__ );

		$tableTypes = array( 'Page', 'Category' );
		foreach ( $tableTypes as $tableType ) {
			foreach ( $this->target[$tableType] as $targetZoneID => $titlesArray ) {
				if ( $targetZoneID == wfMsg( 'admanager_noads' ) ) {
					$targetZoneID = 'NULL';
				}
				foreach ( $titlesArray as $title ) {
					// Depending on fields being processed, lookup either the
					// text's Page ID or Category ID
					if ( $tableType == 'Page' ) {
						$targetPageID = Title::newFromText( $title )->getArticleID();
					} else {
						$targetPageID = Category::newFromName( $title )->getID();
					}
					$dbw->insert(
						$fullTableName,
						array(
							'ad_page_id' => $targetPageID,
							'ad_zone' => $targetZoneID,
							'ad_page_is_category' => ( $tableType == 'Category' ? true : false )
						),
						__METHOD__
					);
				}
			}
		}

		$wgOut->wrapWikiMsg( "<div class=\"successbox\" style=\"margin-right:3em;\">$1</div>", 'admanager_added' );
		$wgOut->addWikiText( '<br clear="both" />' . wfMsg( 'admanager_return' ) );
	}

	function showForm( array $errors ) {
		global $wgOut, $wgRequest;

		if ( empty( $errors ) ) {
			$wgOut->addWikiMsg( 'admanager_docu' );
		} else {
			$text = "<div class=\"errorbox\">\n";
			foreach ( $errors as $message => $pageTitles ) {
				foreach ( $pageTitles as $pageTitle) {
					$text .= wfMsg( $message, $pageTitle ) . "<br />";
				}
			}
			$text .= "</div><br clear=\"both\" />";
			$wgOut->addWikiText( $text );
		}

		$text =	Xml::openElement( 'form', array( 'id' => 'admanager', 'action' => $this->getTitle()->getFullURL(), 'method' => 'post' ) ) . "\n" .
			AdManagerUtils::hiddenField( 'title', $this->getTitle()->getPrefixedText() ) .
			AdManagerUtils::hiddenField( 'submitted', 1 );

		$this->currentData['Page'] = $this->getCurrentData( 'Page' );
		$this->currentData['Category'] = $this->getCurrentData( 'Category' );

		foreach ( $this->adManagerZones as $zone ) {
			$text .= '<h2> ' .  wfMsg( 'admanager_zonenum', $zone ) . ' </h2>';
			$text .= '<div style="float:left; margin-right: 6em;">';
			$text .= $this->drawTable( 'Page', $zone );
			$text .= '</div><div style="float: left;">';
			$text .= $this->drawTable( 'Category', $zone );
			$text .= '</div> <br clear="all">';
		}
		$text .= Xml::element( 'br' );
		$text .= Xml::submitButton( wfMsg( 'admanager_submit' ) );
		$text .= Xml::closeElement( 'form' );
		$text .= Xml::element( 'br' );
		$wgOut->addHTML( $text );


		$wgOut->addWikiMsg( 'admanager_gotozones' );
	}

	function getCurrentData( $tableType ) {
		$fullTableName = AD_TABLE;
		$dbr = wfGetDB( DB_SLAVE );
		$current = $dbr->select(
			$fullTableName,
			array(
				'ad_id', 'ad_page_id', 'ad_zone', 'ad_page_is_category'
			),
			'ad_page_is_category IS '. ( $tableType == 'Page' ? 'NOT ' : '' ) . 'TRUE',
			__METHOD__
		);

		// Fetch current table into array
		$currentArray = array();
		while ( $currentRow = $current->fetchObject() ) {
			$currentArray[] = array(
				// Depending on if we're fetching pages or categories, match the ID to the appropriate Title
				'ad_page_name' => ( $tableType == 'Page' ? Title::newFromID( $currentRow->ad_page_id )->getFullText() : Category::newFromID( $currentRow->ad_page_id )->getName() ),
				'ad_zone' => $currentRow->ad_zone
			);
		}

		return $currentArray;
	}

	function drawTable( $tableType, $currentZone ) {
		global $wgRequest;

		$page_label = wfMsg( "admanager_label$tableType" );

		$text = <<<END
			<table id="table$tableType">
		<tr>
			<th>$page_label</th>
		</tr>

END;

		$display = '';
		if ( $wgRequest->getCheck( 'submitted' ) ) {
			$display = $wgRequest->getVal( "textarea_{$currentZone}_{$tableType}" );
		} else {
			foreach ( $this->currentData[$tableType] as $entry ) {
				if ( $entry['ad_zone'] == $currentZone ) {
					$display .= $entry['ad_page_name']. "\n";
				}
			}
		}

		$text .= '<tr><td>' . Xml::textarea( "textarea_{$currentZone}_{$tableType}" , $display, 30, 12, array( 'style' => 'width: auto;' ) );
		$text .= '</td></tr></table>';

		return $text;
	}
}