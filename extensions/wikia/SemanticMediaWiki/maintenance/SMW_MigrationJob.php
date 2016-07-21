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

	public function run($wikis) {

		$this->cityId = $this->getWikiId();
		if (!$this->refreshPageProperties()) {
			return false;
		};
		if (!$this->refreshPages()) {
			return false;
		}
		if (!$this->setDb()) {
			return false;
		}
		$this->startNextJob($wikis);
		return true;
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
		$cmd = "SERVER_ID=" . $this->cityId . " php {$IP}/{$maintenanceScript} " . implode(' ', $options) . " --task_id " . $this->getTaskId();
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

	private function startNextJob($wikis) {
		$wiki = array_shift($wikis);
		if (empty($wiki)) {
			$this->info(__CLASS__ . " Finished migration queue", ['task_id' => $this->getTaskId()]);
		} else {
			$task = new SMW_MigrationJob();
			(new \Wikia\Tasks\AsyncTaskList())
				->wikiId($wiki)
				->add($task->call('run', $wikis))
				->queue();
		}
	}
}
