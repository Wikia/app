<?php

use Wikia\DependencyInjection\Injector;
use Wikia\UserGroups\Maintenance\UserGroupUpdater;

$wgCommandLineSilentMode = true;

require_once(dirname(__FILE__).'/../Maintenance.php');

class SyncWikiUserGroups extends Maintenance {

	public function execute() {
		global $wgCityId;

		/** @var UserGroupUpdater $updater */
		$updater = Injector::getInjector()->get(UserGroupUpdater::class);
		$updater->updateForWiki($wgCityId, wfGetDB(DB_SLAVE));
	}
}

$maintClass = SyncWikiUserGroups::class;
require(RUN_MAINTENANCE_IF_MAIN);
