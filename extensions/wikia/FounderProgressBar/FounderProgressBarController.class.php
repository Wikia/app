<?php

class FounderProgressBarController extends WikiaController {
	
	protected $messages;
	
	/**
	 * Initialize static data
	 */
	
	public function init() {
		// Messages defined in i18n file
		// Each message in i18n has a -label -description and -action suffix
		// This list just has the prefix for the messages
		$this->messages = array ( 
				10 => "add_10_pages",
				20 => "do_something",
				100 => "advanced_thing"
			);


	}
	
	/**
	 * @desc Get the short list of available founder tasks
	 * 
	 * @responseParam list array of 2 Founder tasks
	 */

	
	public function getShortTaskList () {
		// try to get cached data
		$memKey = $this->wf->MemcKey('FounderShortTaskList');
		$list = $this->wg->Memc->get($memKey);
		if (empty($list)) {
			$this->wf->ProfileIn(__METHOD__ . '::miss');

			$list = array();

			// get the next two available non-skipped, non-completed items
			$dbr = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$res = $dbr->select(
				'founder_progress_bar_tasks',
				array('task_id', 'task_count'),
				array('task_skipped' => 0, 'task_completed' => 0, 'wiki_id' => $this->wg->CityId),
				__METHOD__,
				array( 'LIMIT' => 2, 'ORDER BY' => 'task_id ASC' )
			);
			while($row = $dbr->fetchObject($res)) {
				$task_id = $row->task_id;
				$list[$task_id] = array (
					"task_id" => $task_id,
					"task_count" => $row->task_count,
					"task_label" => $this->getMsgForTask($task_id, "label"),
					"task_description" => $this->getMsgForTask($task_id, "description"),
					"task_action" => $this->getMsgForTask($task_id, "action"),
					);
			}

			if (!empty($list)) {
				$this->wg->Memc->set($memKey, $list, 3600);
			}

			$this->wf->ProfileOut(__METHOD__ . '::miss');
		}
		$this->response->setVal("list", $list);
	}

	/**
	 * @desc Get all founder tasks with more details (available, completed, skipped)
	 * 
	 * @responseParam list array of Founder actions in the format:
	 */
	
	public function getLongTaskList () {
		// try to get cached data
		$memKey = $this->wf->MemcKey('FounderLongTaskList');
		$list = $this->wg->Memc->get($memKey);
		$list = null;  // no memcache for now while developing
		if (empty($list)) {
			$this->wf->ProfileIn(__METHOD__ . '::miss');

			$list = array();

			// get the next two available non-skipped, non-completed items
			$dbr = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->ExternalSharedDB);
			$res = $dbr->select(
				'founder_progress_bar_tasks',
				array('task_id', 'task_count', 'task_completed', 'task_skipped', 'task_timestamp'),
				array('wiki_id' => $this->wg->CityId)
				);

			while($row = $dbr->fetchObject($res)) {
				$task_id = $row->task_id;
				$list[$task_id] = array (
					"task_id" => $task_id,
					"task_count" => $row->task_count,
					"task_completed" => $row->task_completed,
					"task_skipped" => $row->task_skipped,
					"task_timestamp" => $this->wf->TimeFormatAgo($row->task_timestamp),
					"task_label" => $this->getMsgForTask($task_id, "label"),
					"task_description" => $this->getMsgForTask($task_id, "description"),
					"task_action" => $this->getMsgForTask($task_id, "action"),
					);
			}

			if (!empty($list)) {
				$this->wg->Memc->set($memKey, $list, 3600);
			}

			$this->wf->ProfileOut(__METHOD__ . '::miss');
		}
		$this->response->setVal("list", $list);
		
	}
	
	/**
	 * @desc
	 * @requestParam int task_id The ID of the task to skip 
	 * @requestParam int task_skipped 1 to skip, 0 to "un-skip"
	 * @responseParam string result OK or error
	 */
	
	public function skipTask() {
		
		$task_id = $this->request->getVal("task_id");
		$task_skipped = $this->request->getVal("task_skipped");
		//if (empty($task_id)) throw error;
		//if (empty($task_skipped)) throw error;
		
		$dbw = wfGetDB(DB_MASTER, array(), $this->wg->ExternalSharedDB);
		$dbw->update(
			'founder_progress_bar_tasks',
			array(
					'task_skipped' => $task_skipped
			),
			array(
					'task_id' => $task_id,
					'wiki_id' => $this->wg->CityId
			)
		);

		$this->response->setVal("result", "OK");
	}
	
	public function widget() {
		global $wgBlankImgUrl;
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/FounderProgressBar/css/FounderProgressBar.scss'));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/FounderProgressBar/js/FounderProgressBar.js');
		$this->response->setVal("wgBlankImgUrl", $wgBlankImgUrl);
	}
	
	// Messages defined in i18n file
	// Each message in i18n has a -label -description and -action version
	// This helper function will get the proper message for the proper type
	private function getMsgForTask($task_id, $type) {

		// For development, return placeholder messages if a message is not defined
		if (! isset($this->messages[$task_id]) ) {
			if ($type == "label") return "Task $type";
			if ($type == "description") return "Task $type Description Placeholder";
			if ($type == "action") return "Button Label";
		}
		
		$fullMessageName = $this->messages[$task_id] . "-" . $type;
		return wfMsg($fullMessageName);
	}
}
