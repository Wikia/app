<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class RenameUserRelatedPages extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Rename user related pages (user page/blog/Wall etc.) on a wiki' );
		$this->addOption('old-name', 'Old user name', true );
		$this->addOption('new-name', 'New user name', true );
	}

	public function execute() {
		$localTask = new \Wikia\Tasks\Tasks\RenameUserPagesTask();
		$localTask->renameLocalPages( $this->getOption( 'old-name' ), $this->getOption( 'new-name' ) );
	}
}

$maintClass = RenameUserRelatedPages::class;
require_once RUN_MAINTENANCE_IF_MAIN;
