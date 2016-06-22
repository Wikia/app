<?php

use Wikia\DependencyInjection\Injector;
use Wikia\UserGroups\Maintenance\UserGroupUpdater;

$wgCommandLineSilentMode = true;

require_once(dirname(__FILE__).'/../Maintenance.php');

class SyncWikiUserGroups extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->addOption('wiki_id', '', true, true);
	}

	public function loadParamsAndArgs($self = null, $opts = null, $args = null) {
		parent::loadParamsAndArgs($self, $opts, $args);

		if (!empty($this->mOptions['wiki_id'])) {
			putenv("SERVER_ID={$this->mOptions['wiki_id']}");
		}
	}

	public function execute() {
		global $wgCityId;

		/** @var UserGroupUpdater $updater */
		$updater = Injector::getInjector()->get(UserGroupUpdater::class);
		$updater->updateForWiki($wgCityId, wfGetDB(DB_SLAVE));
	}
}

$maintClass = SyncWikiUserGroups::class;
require(RUN_MAINTENANCE_IF_MAIN);
