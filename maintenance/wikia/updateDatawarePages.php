<?php

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL );

require_once( __DIR__ . '/../Maintenance.php' );

class UpdateDatawarePages extends Maintenance {
	private $dryRun;
	private $debug;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Do not update anything.' );
		$this->addOption( 'debug', 'Show debugging information.' );
		$this->mDescription = "Update page index in dataware";
	}

	public function execute() {
		global $wgCityId;
		$this->dryRun = $this->getOption( 'dry-run' );
		$this->debug = $this->getOption( 'debug' );

		$this->addRuntimeStatistics( [
			'dry_run_bool' => boolval( $this->dryRun ),
		] );

		$this->output( "Started updateDatawarePages.php for wiki id = $wgCityId...\n" );

		$localPages = $this->getLocalPages();
		$datawarePages = $this->getDatawarePages();

		$this->comparePages( $localPages, $datawarePages );
		$this->output( "Finished.\n" );
	}

	private function getLocalPages() {
		global $wgContentNamespaces;

		$this->output( "Fetching local list of pages...\n" );

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			[ 'page', 'revision' ],
			[
				'page_id',
				'page_is_redirect',
				'page_latest',
				'page_title',
				'page_namespace',
				'count(rev_id) as page_edits',
				'max(rev_timestamp) as page_last_edited',
				'rev_user'
			],
			[ ],
			__METHOD__,
			[
				'GROUP BY' => 'page_id',
				'ORDER BY' => 'page_id',
			],
			[
				'revision' => [ 'INNER JOIN', 'rev_page = page_id' ],
			]
		);

		$pages = array();
		/** @var stdClass $row */
		foreach ( $res as $row ) {
			$row->page_latest = intval( $row->page_latest );
			$row->page_edits = intval( $row->page_edits );
			$row->page_is_redirect = intval( $row->page_is_redirect );
			$row->page_is_content = intval( in_array( $row->page_namespace, $wgContentNamespaces ) );
			$row->page_last_edited = $row->page_last_edited ? wfTimestamp( TS_DB, $row->page_last_edited ) : null;
			$this->attachTextualTitle( $row );
			$pages[$row->page_id] = $row;
		}
		$res->free();

		$this->output( "Got " . count( $pages ) . " local pages.\n" );
		$this->addRuntimeStatistics( [
			'local_pages_count_int' => count( $pages ),
		] );

		return $pages;
	}

	private function attachTextualTitle( $page ) {
		$nsText = '';
		if ( $page->page_namespace ) {
			$nsText = MWNamespace::getCanonicalName( $page->page_namespace );
			if ( !$nsText ) {
				$nsText = $page->page_namespace;
			}
			$nsText .= ':';
		}

		$page->page_textual_title = "{$nsText}{$page->page_title} (id={$page->page_id})";
	}

	private function getDatawarePages() {
		global $wgCityId, $wgExternalDatawareDB;

		$this->output( "Fetching page index from dataware...\n" );

		$dbr = wfGetDB( DB_SLAVE, [ ], $wgExternalDatawareDB );
		$res = $dbr->select(
			'pages',
			[
				'page_id',
				'page_status',
				'page_latest',
				'page_title',
				'page_title_lower',
				'page_namespace',
				'page_is_redirect',
				'page_is_content',
				'page_edits',
				'page_last_edited'
			],
			[
				'page_wikia_id' => $wgCityId,
			],
			__METHOD__
		);

		$pages = [ ];
		/** @var stdClass $row */
		foreach ( $res as $row ) {
			$this->attachTextualTitle( $row );
			$pages[$row->page_id] = $row;
		}
		$res->free();

		$this->output( "Got " . count( $pages ) . " pages from dataware.\n" );
		$this->addRuntimeStatistics( [
			'dataware_pages_count_int' => count( $pages ),
		] );

		return $pages;
	}

	private function comparePages( $localPages, $datawarePages ) {
		global $wgExternalDatawareDB;

		$ids = array_merge( array_keys( $localPages ), array_keys( $datawarePages ) );
		$ids = array_unique( $ids );

		$this->output( "Comparing pages between local list and index...\n" );
		$dbw = wfGetDB( DB_MASTER, null, $wgExternalDatawareDB );
		$stats = [
			'added' => 0,
			'updated' => 0,
			'removed' => 0,
		];
		foreach ( $ids as $id ) {
			$localPage = isset( $localPages[$id] ) ? $localPages[$id] : null;
			$datawarePage = isset( $datawarePages[$id] ) ? $datawarePages[$id] : null;

			$this->comparePage( $stats, $dbw, $localPage, $datawarePage );
		}
		$this->output( "Update statistics: added={$stats['added']} updated={$stats['updated']} removed={$stats['removed']}.\n" );
		$this->addRuntimeStatistics( [
			'pages_added_int' => $stats['added'],
			'pages_updated_int' => $stats['updated'],
			'pages_removed_int' => $stats['removed'],
		] );

		wfWaitForSlaves( $wgExternalDatawareDB );
	}

	private function comparePage( &$stats, $dbw, $localPage, $datawarePage ) {
		if ( $this->shouldUpdatePage( $localPage, $datawarePage ) ) {
			$this->updateDatawarePage( $dbw, $localPage, $datawarePage );
			$stats[$datawarePage ? 'updated' : 'added']++;
		} else if ( $this->shouldRemovePage( $localPage, $datawarePage ) ) {
			$this->removeDatawarePage( $dbw, $datawarePage );
			$stats['removed']++;
		}
	}

	/**
	 * @param DatabaseBase $dbw
	 * @param $datawarePage
	 */
	private function updateDatawarePage( $dbw, $localPage, $datawarePage ) {
		global $wgCityId;

		$action = $datawarePage ? "Updating index:" : "Adding to index:";
		$this->output( "{$action} {$localPage->page_textual_title}...\n" );

		if ( $this->debug ) {
			$this->output( "  * local page: " . json_encode( $localPage ) . "\n" );
			$this->output( "  * page index: " . json_encode( $datawarePage ) . "\n" );
		}

		if ( $this->dryRun ) {
			return;
		}

		$dbw->replace(
			'pages',
			[
				'page_wikia_id',
				'page_id',
			],
			[
				'page_wikia_id' => $wgCityId,
				'page_id' => $localPage->page_id,
				'page_namespace' => $localPage->page_namespace,
				'page_title_lower' => mb_strtolower( $localPage->page_title ),
				'page_title' => $localPage->page_title,
				'page_status' => 0,
				'page_is_content' => $localPage->page_is_content,
				'page_is_redirect' => $localPage->page_is_redirect,
				'page_edits' => $localPage->page_edits,
				'page_latest' => $localPage->page_latest,
				'page_last_edited' => $localPage->page_last_edited,
			],
			__METHOD__
		);
	}

	/**
	 * @param DatabaseBase $dbw
	 * @param $datawarePage
	 */
	private function removeDatawarePage( $dbw, $datawarePage ) {
		global $wgCityId;

		$this->output( "Removing from index: {$datawarePage->page_textual_title}...\n" );
		if ( $this->debug ) {
			$this->output( "  * page index: " . json_encode( $datawarePage ) . "\n" );
		}

		if ( $this->dryRun ) {
			return;
		}

		$dbw->delete(
			'pages',
			[
				'page_wikia_id' => $wgCityId,
				'page_id' => $datawarePage->page_id,
			],
			__METHOD__
		);
	}

	/**
	 * @param $localPage
	 * @param $datawarePage
	 * @return bool
	 */
	private function shouldUpdatePage( $localPage, $datawarePage ) {
		if ( !$localPage ) {
			return false;
		}

		if ( !$datawarePage ) {
			return true;
		}

		$FIELDS = [
			'page_title',
			'page_namespace',
			'page_is_content',
			'page_is_redirect',
		];
		foreach ( $FIELDS as $field ) {
			if ( $localPage->$field != $datawarePage->$field ) {
				if ( $this->debug ) {
					$this->output( "Difference found: {$localPage->page_textual_title}\n" );
					$this->output( "  * field={$field} local={$localPage->$field} index={$datawarePage->$field}\n" );
				}

				return true;
			}
		}

		return false;
	}

	/**
	 * @param $localPage
	 * @param $datawarePage
	 * @return bool
	 */
	private function shouldRemovePage( $localPage, $datawarePage ) {
		if ( !$localPage ) {
			return true;
		}

		return false;
	}

}

$maintClass = 'UpdateDatawarePages';
require_once( RUN_MAINTENANCE_IF_MAIN );
