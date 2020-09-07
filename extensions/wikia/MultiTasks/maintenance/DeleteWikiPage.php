<?php
/**
 * Script used in MultiTasks extension to delete given pages for a wiki.
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class DeleteWikiPage extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Delete given pages from wiki";
		$this->addOption( 'pagesToDelete', 'List of names of pages to be deleted' );
		$this->addOption( 'reason', 'Page deletion reason' );
		$this->addOption( 'userId', 'Id of user deleting pages' );
	}

	public function execute() {
		$pageName = $this->getOption( 'pageName', false );
		$reason = $this->getOption( 'reason', false );
		$userId = $this->getOption( 'userId', false );

		if ( $pageName === false || $reason === false || $userId === false ) {
			$this->output( "Failed to run scrip, missing parameters" );
			exit( 1 );
		}

		$page = WikiPage::factory( \Title::newFromText( $pageName ) );
		if ( $page !== null ) {
			$e = '';
			$successfullyDeleted = $page->doDeleteArticle( $reason, false, 0, true, $e, User::newFromId( $userId ) );
			if( !$successfullyDeleted ) {
				$this->output("Page selected to delete in MultiDelete is missing {$pageName}", []);
				exit( 1 );
			}
		} else {
			$this->output("Page selected to delete in MultiDelete is missing {$pageName}", []);
			exit( 1 );
		}
	}

}

$maintClass = DeleteWikiPage::class;
require_once RUN_MAINTENANCE_IF_MAIN;
