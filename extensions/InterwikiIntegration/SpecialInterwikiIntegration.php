<?php
/**
 * A special page that populates the Integration tables, specifically
 * integration_prefix and integration_namespace
 */
class PopulateInterwikiIntegrationTable extends SpecialPage {
	function __construct() {
		parent::__construct( 'PopulateInterwikiIntegrationTable', 'integration' );

	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgLanguageCode
			,$wgLocalisationCacheConf, $wgExtraNamespaces
			, $wgLocalDatabases, $wgInterwikiIntegrationPrefix
			, $wgMetaNamespace, $wgMetaNamespaceTalk
			, $wgSitename, $wgInterwikiIntegrationPWD;
		if ( !$this->userCanExecute($wgUser) ) {
			$this->displayRestrictionError();
			return;
		}
		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );
		$localDBname = $dbr -> getProperty ( 'mDBname' );
		$dbw->delete ( 'integration_prefix', '*' );
		if ( isset ( $wgInterwikiIntegrationPrefix ) ) {
			foreach ( $wgInterwikiIntegrationPrefix as $thisPrefix => $thisDatabase ) {
				$thisPWD = 0;
				if ( isset ( $wgInterwikiIntegrationPWD[$thisDatabase])
				    && $wgInterwikiIntegrationPWD[$thisDatabase] == true) {
					$thisPWD = '1';
				}
				$newDatabaseRow = array (
					'integration_dbname' => $thisDatabase,
					'integration_prefix' => $thisPrefix,
					'integration_pwd'    => $thisPWD
				);
				$dbw->insert ( 'integration_prefix', $newDatabaseRow );
				foreach ( $wgLocalDatabases as $thisDB ) {
					$foreignDbr = wfGetDB ( DB_SLAVE, array(), $thisDB );
					$foreignDbw = wfGetDB ( DB_MASTER, array(), $thisDB );
					if ( $thisDB != $localDBname && $thisDatabase == $localDBname ) {
						$foreignResult = $foreignDbr->selectRow(
							'interwiki',
							'iw_prefix',
							array( "iw_prefix" => $thisPrefix )
						);
						if ( !$foreignResult ) {
							$localTitle = Title::newFromText ( 'Foobarfoobar' );
							$localURL = $localTitle->getFullURL();
							$localURL = str_replace ( 'Foobarfoobar','$1',$localURL );
							$newInterwikiRow = array (
								'iw_prefix' => $thisPrefix,
								'iw_url' => $localURL,
								'iw_local' => '1',
								'iw_trans' => '0'
							);
							$foreignDbw->insert ( 'interwiki', $newInterwikiRow );
						}
					}
				}
			}
		}
		$myCache = new LocalisationCache ( $wgLocalisationCacheConf );
		$namespaceNames = $myCache->getItem ( $wgLanguageCode,'namespaceNames' );
		$namespaceNames[NS_PROJECT] = $wgMetaNamespace;
		$namespaceNames[NS_PROJECT_TALK] = $wgMetaNamespace."_talk";
		$dbw->delete ( 'integration_namespace', array( 'integration_dbname' => $localDBname ) );
		foreach ( $namespaceNames as $key => $thisName ) {
			$newNamespaceRow = array ( 'integration_dbname' => $localDBname,
				'integration_namespace_index' => $key,
				'integration_namespace_title' => $thisName
			);
			$dbw->insert ( 'integration_namespace', $newNamespaceRow);
		}
		foreach ( $wgExtraNamespaces as $key => $thisName ) {
			$newNamespaceRow = array ( 'integration_dbname' => $localDBname,
				'integration_namespace_index' => $key,
				'integration_namespace_title' => $thisName
			);
			$dbw->insert ( 'integration_namespace', $newNamespaceRow);
		}
		$newNamespaceRow = array ( 'integration_dbname' => $localDBname,
			'integration_namespace_index' => NS_SPECIAL,
			'integration_namespace_title' => 'DisregardSpecial'
		);
		$dbw->insert ( 'integration_namespace', $newNamespaceRow);
		$newNamespaceRow = array ( 'integration_dbname' => $localDBname,
			'integration_namespace_index' => NS_MEDIA,
			'integration_namespace_title' => 'DisregardForPWD'
		);
		$dbw->insert ( 'integration_namespace', $newNamespaceRow);
		$newNamespaceRow = array ( 'integration_dbname' => $localDBname,
			'integration_namespace_index' => NS_FILE,
			'integration_namespace_title' => 'DisregardForPWD'
		);
		$dbw->insert ( 'integration_namespace', $newNamespaceRow);
		$wgOut->setPagetitle( wfMsg( 'actioncomplete' ) );
		$wgOut->addWikiMsg( 'integration-setuptext', $wgSitename );
		return;
	}
}

/**
 * A special page that populates the Interwiki watchlist table.
 */
class PopulateInterwikiWatchlistTable extends SpecialPage {
	function __construct() {
		parent::__construct( 'PopulateInterwikiWatchlistTable', 'integration' );

	}

	function execute( $par ) {
		global $wgInterwikiIntegrationPrefix, $wgOut;
		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete ( 'integration_watchlist', '*' );
		$dbList = array_unique ( $wgInterwikiIntegrationPrefix );
		foreach ( $dbList as $thisDb ) {
			$thisDbr = wfGetDB( DB_SLAVE, array(), $thisDb );
			$watchlistRes = $thisDbr->select(
				'watchlist',
				'*'
			);
			if( $watchlistRes->numRows() > 0 ) {
				while( $row = $watchlistRes->fetchObject() ) {
					foreach ( $row as $key => $value ) {
						$newKey = "integration_" . $key;
						$iWatchlist[$newKey] = $value;
					}
					$iWatchlist['integration_wl_db'] = $thisDb;
					$dbw->insert( 'integration_watchlist', $iWatchlist );
				}
			}
		}
		$wgOut->setPagetitle( wfMsg( 'actioncomplete' ) );
		$wgOut->addWikiMsg( 'interwikiwatchlist-setuptext' );
		return;
	}
}

/**
 * A special page that populates the interwiki recent changes table.
 */
class PopulateInterwikiRecentChangesTable extends SpecialPage {
	function __construct() {
		parent::__construct( 'PopulateInterwikiRecentChangesTable', 'integration' );

	}

	function execute( $par ) {
		global $wgInterwikiIntegrationPrefix, $wgOut;
		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete ( 'integration_recentchanges', '*' );
		$dbList = array_unique ( $wgInterwikiIntegrationPrefix );
		foreach ( $dbList as $thisDb ) {
			$thisDbr = wfGetDB( DB_SLAVE, array(), $thisDb );
			$recentchangesRes = $thisDbr->select(
				'recentchanges',
				'*'
			);
			if( $recentchangesRes->numRows() > 0 ) {
				while( $row = $recentchangesRes->fetchObject() ) {
					foreach ( $row as $key => $value ) {
						$newKey = "integration_" . $key;
						$iRecentChange[$newKey] = $value;
					}
					$iRecentChange['integration_rc_db'] = $thisDb;
					$dbw->insert( 'integration_recentchanges', $iRecentChange );
				}
			}
		}
		$wgOut->setPagetitle( wfMsg( 'actioncomplete' ) );
		$wgOut->addWikiMsg( 'interwikirecentchanges-setuptext' );
		return;
	}
}

/**
 * A special page that populates the interwiki recent changes table.
 */
class PopulateInterwikiPageTable extends SpecialPage {
	function __construct() {
		parent::__construct( 'PopulateInterwikiPageTable', 'integration' );

	}

	function execute( $par ) {
		global $wgInterwikiIntegrationPrefix, $wgOut;
		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete ( 'integration_page', '*' );
		$dbList = array_unique ( $wgInterwikiIntegrationPrefix );
		foreach ( $dbList as $thisDb ) {
			$thisDbr = wfGetDB( DB_SLAVE, array(), $thisDb );
			$pageRes = $thisDbr->select(
				'page',
				'*'
			);
			if( $pageRes->numRows() > 0 ) {
				while( $row = $pageRes->fetchObject() ) {
					foreach ( $row as $key => $value ) {
						$newKey = "integration_" . $key;
						$iPage[$newKey] = $value;
					}
					$iPage['integration_page_db'] = $thisDb;
					$dbw->insert( 'integration_page', $iPage );
				}
			}
		}
		$wgOut->setPagetitle( wfMsg( 'actioncomplete' ) );
		$wgOut->addWikiMsg( 'interwikipage-setuptext' );
		return;
	}
}
