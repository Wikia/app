<?php

ini_set( 'display_errors', 1 );

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class RemoveClassificationForDeletedTemplates extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Removes classification data for deleted templates from TCS';
		$this->addOption( 'dry-run', 'Dry-run mode, make no changes' );
	}

	public function execute() {
		global $wgCityId;

		$dryRunMode = $this->hasOption( 'dry-run' );

		if ( $dryRunMode ) {
			$this->output( "Dry-run mode, no changes will be made!\n" );
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tcs = new TemplateClassificationService();

		$templates = $tcs->getTemplatesOnWiki( $wgCityId );
		$pageIds = array_keys( $templates );
		$invalid = 0;

		for ( $offset = 0, $batch = array_slice( $pageIds, $offset, 500 ); !empty( $batch ); $offset += 500, $batch = array_slice( $pageIds, $offset, 500 ) ) {
			$res = $dbr->select( 'page', [ 'page_id', 'page_title', 'page_namespace' ], [ 'page_id' => $batch ], __METHOD__ );

			foreach ( $res as $row ) {
				$title = Title::newFromRow( $row );
				$pageId = $title->getArticleID();

				if ( $title->inNamespace( NS_TEMPLATE ) && isset( $templates[$pageId] ) ) {
					continue;
				}

				$invalid++;

				if ( !$dryRunMode ) {
					$tcs->deleteTemplateInformation( $wgCityId, $pageId );
				}
			}

			$dbr->freeResult( $res );
		}

		$total = count( $pageIds );

		$this->output( "Deleted $invalid entries out of $total.\n" );
	}
}

$maintClass = RemoveClassificationForDeletedTemplates::class;
require_once RUN_MAINTENANCE_IF_MAIN;
