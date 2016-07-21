<?php
/**
 * SMW_MigrationJob
 *
 * This job run SMW_refreshData that is migrate Storage for smw from store2 to store3 version
 *
 */

use Wikia\Tasks\Tasks\BaseTask;

class SMW_MigrationJob extends BaseTask {

	var $cityId;

	public function run($cityId) {
		$this->cityId = $cityId;
		if (!$this->refreshPageProperties()) {
			return false;
		};
		if (!$this->refreshPages()) {
			return false;
		}
		return $this->setDb();
	}

	private function refreshPageProperties() {
		$options = [
			'-v',
			'-b SMWSQLStore3',
			'-fp',
			'--verbose'
		];
		return $this->runMaintenanceScript($options, 'refreshing page properties', "extensions/wikia/SemanticMediaWiki/maintenance/SMW_refreshData.php");
	}

	private function refreshPages() {
		$options = [
			'-v',
			'-b SMWSQLStore3',
			'--verbose'
		];
		return $this->runMaintenanceScript($options, 'refreshing all pages', "extensions/wikia/SemanticMediaWiki/maintenance/SMW_refreshData.php");
	}

	private function setDb() {
		$options = [
			'--verbose',
			'--varName=smwgDefaultStore',
			'--set=SMWSQLStore3',
			"--wikiId={$this->cityId}",
			'--reason="SMW storage migrator"',
		];
		return $this->runMaintenanceScript($options, 'setting storage migration', "maintenance/wikia/setWikiFactoryVariable.php");
	}

	private function runMaintenanceScript($options, $processName, $maintenanceScript) {
		global $IP;
		$cmd = "SERVER_ID=" . $this->cityId . " php {$IP}/{$maintenanceScript} " . implode(' ', $options);
		$logContext = [
			'wiki_id' => $this->cityId,
			'cmd' => $cmd,
			'process_name' => $processName,
			'task_id' => $this->getTaskId()
		];

		$this->info(__CLASS__ . " Start {$processName}", $logContext);

		wfShellExec($cmd, $retval);

		if ($retval) {
			$this->error(__CLASS__ . " Error while {$processName}", $logContext);
		} else {
			$this->info(__CLASS__ . " Done {$processName}", $logContext);
		}
		return $retval == 0;
	}
}
