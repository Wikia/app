<?php

class FounderProgressBarController extends WikiaController {
	
	/**
	 * Initialize static data
	 */
	
	public function init() {
		// Messages are defined in the i18n file
		// Each message in i18n has a -label -description and -action version
		// If the message name has a % in it that means a $1 substitution is done
		$this->messages = array ( 
				FT_PAGE_ADD_10 => "page-add%",
				FT_THEMEDESIGNER_VISIT => "themedesigner-visit",
				FT_MAINPAGE_EDIT => "mainpage-edit",
				FT_PHOTO_ADD_10 => "photo-add%",
				FT_CATEGORY_ADD_3 => "category-add%",
				FT_COMMCENTRAL_VISIT => "commcentral-visit",
				FT_WIKIACTIVITY_VISIT => "wikiactivity-visit",
				FT_PROFILE_EDIT => "profile-edit",
				FT_PHOTO_ADD_20 => "photo-add%",
				FT_TOTAL_EDIT_75 => "total-edit%",
				FT_PAGE_ADD_20 => "page-add%",
				FT_CATEGORY_EDIT => "category-edit",
				FT_WIKIALABS_VISIT => "wikialabs-visit",
				FT_FB_CONNECT => "fb-connect",
				FT_CATEGORY_ADD_5 => "category-add%",
				FT_PAGELAYOUT_VISIT => "pagelayout-visit",
				FT_GALLERY_ADD => "gallery-add",
				FT_TOPNAV_EDIT => "topnav-edit",
				FT_MAINPAGE_ADDSLIDER => "mainpage-addslider",
				FT_COMMCORNER_EDIT => "commcorner-edit",
				FT_VIDEO_ADD => "video-add",
				FT_USER_ADD_5 => "user-add%",
				FT_RECENTCHANGES_VISIT => "recentchanges-visit",
				FT_WORDMARK_EDIT => "wordmark-edit",
				FT_MOSTVISITED_VISIT => "mostvisited-visit",
				FT_TOPTENLIST_ADD => "toptenlist-add",
				FT_BLOGPOST_ADD => "blogpost-add",
				FT_FB_LIKES_3 => "fb-likes%",
				FT_UNCATEGORIZED_VISIT => "uncategorized-visit",
				FT_TOTAL_EDIT_300 => "total-edit%",
				FT_BONUS_PHOTO_ADD_10 => "bonus-photo-add%",
				FT_BONUS_PAGE_ADD_5 => "bonus-page-add%",
				FT_BONUS_PAGELAYOUT_ADD => "bonus-pagelayout-add",
				FT_BONUS_EDIT_50 => "bonus-edit%",			
				FT_COMPLETION => "completion"
			);

		// This list says how many times an item needs to be counted to be finished
		$this->counters = array (
				FT_PAGE_ADD_10 => 10,
				FT_THEMEDESIGNER_VISIT => 1,
				FT_MAINPAGE_EDIT => 1,
				FT_PHOTO_ADD_10 => 10,
				FT_CATEGORY_ADD_3 => 3,
				FT_COMMCENTRAL_VISIT => 1,
				FT_WIKIACTIVITY_VISIT => 1,
				FT_PROFILE_EDIT => 1,
				FT_PHOTO_ADD_20 => 20,
				FT_TOTAL_EDIT_75 => 75,
				FT_PAGE_ADD_20 => 20,
				FT_CATEGORY_EDIT => 1,
				FT_WIKIALABS_VISIT => 1,
				FT_FB_CONNECT => 1,
				FT_CATEGORY_ADD_5 => 5,
				FT_PAGELAYOUT_VISIT => 1,
				FT_GALLERY_ADD => 1,
				FT_TOPNAV_EDIT => 1,
				FT_MAINPAGE_ADDSLIDER => 1,
				FT_COMMCORNER_EDIT => 1,
				FT_VIDEO_ADD => 1,
				FT_USER_ADD_5 => 5,
				FT_RECENTCHANGES_VISIT => 1,
				FT_WORDMARK_EDIT => 1,
				FT_MOSTVISITED_VISIT => 1,
				FT_TOPTENLIST_ADD => 1,
				FT_BLOGPOST_ADD => 1,
				FT_FB_LIKES_3 => 3,
				FT_UNCATEGORIZED_VISIT => 1,
				FT_TOTAL_EDIT_300 => 300,
				FT_BONUS_PHOTO_ADD_10 => 10,
				FT_BONUS_PAGE_ADD_5 => 5,
				FT_BONUS_PAGELAYOUT_ADD => 1,
				FT_BONUS_EDIT_50 => 50,			
				FT_COMPLETION => 1
		);

		// This list contains rules to build URLs for all the actions
		$this->urls = array (
				FT_PAGE_ADD_10 => array("newFromText", "CreatePage", NS_SPECIAL),
				FT_THEMEDESIGNER_VISIT => array("newFromText", "ThemeDesigner", NS_SPECIAL),
				FT_MAINPAGE_EDIT => array("newMainPage"),
				FT_PHOTO_ADD_10 => array("newFromText", "Upload", NS_SPECIAL),
				FT_CATEGORY_ADD_3 => array("newFromText", "Browse", NS_CATEGORY),
				FT_COMMCENTRAL_VISIT => "http://community.wikia.com/wiki/Community_Central",
				FT_WIKIACTIVITY_VISIT => array("newFromText", "WikiActivity", NS_SPECIAL),
				FT_PROFILE_EDIT => array("newFromText", $this->wg->User->getName(), NS_USER),
				FT_PHOTO_ADD_20 => array("newFromText", "Upload", NS_SPECIAL),
				FT_TOTAL_EDIT_75 => array("newFromText", "CreatePage", NS_SPECIAL),
				FT_PAGE_ADD_20 => array("newFromText", "CreatePage", NS_SPECIAL),
				FT_CATEGORY_EDIT => array("newFromText", "Browse", NS_CATEGORY),
				FT_WIKIALABS_VISIT => array("newFromText", "WikiaLabs", NS_SPECIAL),
				FT_FB_CONNECT => array("newFromText", "Connect", NS_SPECIAL),
				FT_CATEGORY_ADD_5 => array("newFromText", "Browse", NS_CATEGORY),
				FT_PAGELAYOUT_VISIT => array("newFromText", "LayoutBuilder", NS_SPECIAL),
				FT_GALLERY_ADD => "http://community.wikia.com/wiki/Help:Gallery",
				FT_TOPNAV_EDIT => array("newFromText", "Wiki-navigation", NS_MEDIAWIKI),
				FT_MAINPAGE_ADDSLIDER => array("newMainPage"),
				FT_COMMCORNER_EDIT => array("newFromText", "Community-corner", NS_MEDIAWIKI),
				FT_VIDEO_ADD => array("newFromText", "Upload", NS_SPECIAL),
				FT_USER_ADD_5 => "http://help.wikia.com/wiki/Advice:Building_a_Community",
				FT_RECENTCHANGES_VISIT => array("newFromText", "RecentChanges", NS_SPECIAL),
				FT_WORDMARK_EDIT => array("newFromText", "ThemeDesigner", NS_SPECIAL),
				FT_MOSTVISITED_VISIT => array("newFromText", "Mostvisitedpages", NS_SPECIAL),
				FT_TOPTENLIST_ADD => array("newFromText", "CreatePage", NS_SPECIAL),
				FT_BLOGPOST_ADD => array("newFromText", $this->wg->User->getName(), NS_BLOG_ARTICLE),
				FT_FB_LIKES_3 => array("newMainPage"),
				FT_UNCATEGORIZED_VISIT => array("newFromText", "UncategorizedPages", NS_SPECIAL),
				FT_BONUS_PHOTO_ADD_10 => array("newFromText", "Upload", NS_SPECIAL),
				FT_BONUS_PAGE_ADD_5 => array("newFromText", "CreatePage", NS_SPECIAL),
				FT_BONUS_PAGELAYOUT_ADD => array("newFromText", "LayoutBuilder", NS_SPECIAL),
				FT_BONUS_EDIT_50 => array("newFromText", "WikiActivity", NS_SPECIAL),		
				FT_TOTAL_EDIT_300 => array("newFromText", "CreatePage", NS_SPECIAL),
		);
		
		// This list contains additional "bonus" tasks that can be completed if all other tasks are skipped or completed
		$this->bonus_tasks = array (
				FT_BONUS_PHOTO_ADD_10,
				FT_BONUS_PAGE_ADD_5,
				FT_BONUS_PAGELAYOUT_ADD,
				FT_BONUS_EDIT_50			
		);
		
		// tracked events on the frontend
		$this->clickEvents = array(
				FT_THEMEDESIGNER_VISIT => true,
				FT_COMMCENTRAL_VISIT => true,
				FT_WIKIACTIVITY_VISIT => true,
				FT_WIKIALABS_VISIT => true,
				FT_PAGELAYOUT_VISIT => true,
				FT_RECENTCHANGES_VISIT => true,
				FT_MOSTVISITED_VISIT => true,
				FT_UNCATEGORIZED_VISIT => true,
		);
	}
	
	/**
	 * @desc Get the short list of available founder tasks
	 * 
	 * @responseParam list array of Founder tasks that are not completed or skipped, max of 2
	 */

	public function getShortTaskList () {

		// Long list is cached, and also generates some data we need as a side effect
		// so just use it instead of writing a different query
		$response = $this->sendSelfRequest("getLongTaskList");

		$list = $response->getVal('list');
		$data = $response->getVal('data');
		
		$short_list = array();
		// Grab the first two available items from the long list
		foreach ($list as $id => $item) {
			if ($item['task_skipped'] == 0 && $item['task_completed'] == 0) {
				$short_list[$id] = $item;
			}
			if (count($short_list) == 2) break; 
		}
		
		$this->setVal('list', $short_list);
		$this->setVal('data', $data);
	}
	
	public function getDb($db_type=DB_SLAVE) {
		return $this->app->runFunction( 'wfGetDB', $db_type, array(), $this->wg->ExternalSharedDB);
	}
	
	public function getMCache() {
		return $this->app->getGlobal('wgMemc');
	}

	/**
	 * @desc Get all founder tasks with more details (available, completed, skipped)
	 * 
	 * @responseParam list array of Founder actions in the format:
	 */
	
	public function getLongTaskList () {

		// Defeat potential race conditions by connecting to master for reads, default to slave
		$use_master = $this->request->getval("use_master", false);
		$list = null;
		$db_type = DB_SLAVE;
		$memKey = $this->wf->MemcKey('FounderLongTaskList');
		// try to get cached data, also use slave
		if ($use_master == true) {
			$db_type = DB_MASTER;
		} else {  // memcache ok for non-master requests
			$list = $this->getMCache()->get($memKey);
		}
		if (empty($list)) {
			$this->wf->ProfileIn(__METHOD__ . '::miss');
			$list = array();

			// get the next two available non-skipped, non-completed items
			$dbr = $this->getDB($db_type);
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
					"task_url" => $this->getURLForTask($task_id)
					);
			}
			
			if (!empty($list)) {
				$this->getMCache()->set($memKey, $list, 24*60*60); // 1 day
			}

			$this->wf->ProfileOut(__METHOD__ . '::miss');
		}
		$data = $this->getCompletionData($list);
		$this->response->setVal("list", $list);
		$this->response->setVal("data", $data);
	}

	/**
	 * @desc
	 * @requestParam int task_id The ID of the task completed
	 * @responseParam string result OK or completed error
	 * @responseParam int tasks_completed number of tasks completed so far
	 * @responseParam int tasks_remaining number of tasks remaining
	 */
	
	public function doTask() {
		$wiki_id = $this->wg->CityId;
		$task_id = $this->request->getVal("task_id");
		
		if (! isset($this->counters[$task_id])) {
			$this->setVal('result', 'error');
			$this->setVal('error', 'invalid task_id');
			return;
		}
		$response = $this->sendSelfRequest('isTaskComplete', array("task_id" => $task_id));
		if ($response->getVal('task_completed', 0) == "1") {
			$this->setVal('result', 'error');
			$this->setVal('error', 'task_completed');
			return;
		}
		$dbw = $this->getDB(DB_MASTER);
		$sql = "INSERT INTO founder_progress_bar_tasks 
			SET wiki_id=$wiki_id, 
				task_id=$task_id, 
				task_count=1
			ON DUPLICATE KEY UPDATE task_count = task_count + 1";
		$dbw->query ($sql);
//		file_put_contents("/tmp/founder.log", "doing INSERT sql\n", FILE_APPEND);
		$res = $dbw->select (
				'founder_progress_bar_tasks',
				array('task_id', 'task_count'),
				array('wiki_id' => $wiki_id, 'task_id' => $task_id)
			);
		
		$row = $dbw->fetchRow($res);
		if (!$row) {
			// Some kind of crazy error happened?
			$this->setVal('result', 'error');
			$this->setVal('error', 'invalid task_id');
			return;
		}
		$actions_completed = $row['task_count'];
		$actions_remaining = $this->counters[$task_id] - $actions_completed;

		$this->setVal('actions_completed', $actions_completed);
		$this->setVal('actions_remaining', $actions_remaining);
		$this->setVal('result', 'OK');
		if ($actions_remaining <= 0) {
			$dbw->update(
				'founder_progress_bar_tasks',
				array('task_completed' => '1'),
				array('wiki_id' => $wiki_id, 'task_id' => $task_id)
			);
			$this->setVal('result', "task_completed");
		}
		$dbw->commit();
		// Task data was updated so clear task list from memcache
		$memKey = $this->wf->MemcKey('FounderLongTaskList');
		$this->getMCache()->delete($memKey);
		// else error?
	}
	
	/**
	 * @desc
	 * @requestParam int task_id The ID of the task to skip 
	 * @requestParam int task_skipped 1 to skip, 0 to "un-skip"
	 * @responseParam string result OK or error
	 */
	
	public function skipTask() {
		
		$task_id = $this->request->getVal("task_id");
		$task_skipped = $this->request->getVal("task_skipped", 1);
		//if (empty($task_id)) throw error;
		//if (empty($task_skipped)) throw error;
		//if (Task_Completed) throw error;
		$response = $this->sendSelfRequest('isTaskComplete');
		if ($response->getVal('task_completed')) {
			$this->response->setVal("error", "task_completed");
			$this->response->setVal("result", "error");
		}
		
		$dbw = $this->getDB(DB_MASTER);
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
		
		//TODO: If everything is completed or skipped, open up a bonus task
		$response = $this->sendSelfRequest("getLongTaskList", array("use_master" => true));
		$list = $response->getVal('list');
		$total_tasks = count($list);
		$tasks_skipped = 0; 
		$tasks_completed = 0;
		foreach ($list as $task) {
			$tasks_skipped += $task["task_skipped"];
			$tasks_completed += $task["task_completed"];
		}
		if ($total_tasks <= ($tasks_skipped + $tasks_completed)) {
			$wiki_id = $this->wg->CityId;
			// Special case, unlock one bonus task, in the order in which they appear in our bonus_tasks array
			foreach ($this->bonus_tasks as $bonus_task_id) {
				if (!isset($list[$bonus_task_id])) {
					$sql = "INSERT IGNORE INTO founder_progress_bar_tasks SET wiki_id=$wiki_id, task_id=$bonus_task_id";
					$dbw->query ($sql);
					break;
				}
			}
		}
		$dbw->commit();
		// DB updated so clear memcache val
		$memKey = $this->wf->MemcKey('FounderLongTaskList');
		$this->getMCache()->delete($memKey);
		$this->response->setVal("result", "OK");
	}
	
	/**
	 * @requestParam int task_id
	 * @responseParam int task_completed 0 or 1
	 */
	public function isTaskComplete() {
		$task_id = $this->getVal("task_id");
		// Long list is cached so just use it instead of writing a different query
		$response = $this->sendSelfRequest("getLongTaskList");
		$list = $response->getVal('list');
		if (isset($list[$task_id])) {
			$this->setVal('task_completed', $list[$task_id]['task_completed']);
		} 	
	}
	
	public function widget() {
		global $wgBlankImgUrl;
		$this->response->addAsset( 'extensions/wikia/FounderProgressBar/css/FounderProgressBar.scss' );
		$this->response->addAsset( 'extensions/wikia/FounderProgressBar/js/modernizr.custom.founder.js' );
		$this->response->addAsset( 'extensions/wikia/FounderProgressBar/js/FounderProgressBar.js' );
		$this->response->setVal("wgBlankImgUrl", $wgBlankImgUrl);
		
		$activityListPreview = F::app()->sendRequest( 'FounderProgressBar', 'getShortTaskList', array())->getData();
		$activityFull = F::app()->sendRequest('FounderProgressBar', 'getLongTaskList', array())->getData();
		
		$activeTaskList = array();
		$skippedTaskList = array();
		$bonusTaskList = array();
		foreach($activityFull['list'] as $activity) {
			if(!empty($activity['task_skipped'])) {
				$skippedTaskList[] = $activity;
			} else {
				$activeTaskList[] = $activity;
			}
		}
		// Bonus tasks don't exist in the DB until they are opened up.  display them but default to "locked" status
		// If they exist in the task list from the DB, they are by definition unlocked (skipTask contains that biz logic)
		foreach ($this->bonus_tasks as $task_id) {
			$bonusTask = array (
					"task_id" => $task_id,
					"task_label" => $this->getMsgForTask($task_id, "label"),
					"task_description" => $this->getMsgForTask($task_id, "description"),
					"task_action" => $this->getMsgForTask($task_id, "action"),
					"task_url" => $this->getURLForTask($task_id)
				);
			// Task is opened up
			if (isset($activityFull[$task_id])) {
				$bonusTask["task_count"] = $activityFull[$task_id]["task_count"];
				$bonusTask["task_completed"] = $activityFull[$task_id]["task_completed"];
				$bonusTask["task_timestamp"] = $this->wf->TimeFormatAgo($activityFull[$task_id]["task_timestamp"]);
				$bonusTask["task_locked"] = 0;	
			} else {				
				$bonusTask["task_completed"] = 0;
				$bonusTask["task_locked"] = 1;
			}
			
			$bonusTaskList[] = $bonusTask;
		}
		
		$this->response->setVal('progressData', $activityListPreview['data']);
		$this->response->setVal('activityListPreview', $activityListPreview['list']);
		$this->response->setVal('activeTaskList', $activeTaskList);
		$this->response->setVal('skippedTaskList', $skippedTaskList);
		$this->response->setVal('bonusTaskList', $bonusTaskList);
		$this->response->setVal('clickEvents', $this->clickEvents);
	}
	
	public function getNextTask() {
		$excluded_task_id = $this->request->getVal('excluded_task_id', '');
		$shortList = F::app()->sendRequest( 'FounderProgressBar', 'getShortTaskList', array())->getData();
		$activity = '';
		foreach ($shortList['list'] as $task) {
			if($task['task_id'] == $excluded_task_id) {
				continue;
			} else {
				$activity = $task;
				break;
			}
		}
		if(!empty($activity)) {
			$html = F::app()->getView( 'FounderProgressBar', 'widgetActivityPreview', array('activity' => $activity, 'clickEvents' => $this->clickEvents, 'index' => 1, 'wgBlankImgUrl' => F::app()->wg->BlankImgUrl, 'visible' => false ))->render();
		} else {
			$html = '';
		}
		$this->response->setVal('html', $html);
	}
	
	// Messages defined in i18n file
	// Each message in i18n has a -label -description and -action version
	// This helper function will get the proper message for the proper type
	// If a task has a % at the end of the name then a $1 substitution is done,  
	private function getMsgForTask($task_id, $type) {

		// For development, return placeholder messages if a message is not defined
		if (! isset($this->messages[$task_id]) ) {
			if ($type == "label") return "Task $type";
			if ($type == "description") return "Task $type Placeholder";
			if ($type == "action") return "Call to action Label";
		}

		$messageStr = $this->messages[$task_id];
		if (substr($messageStr, -1) == '%') {
			$number = $this->counters[$task_id];
			$messageStr = "founderprogressbar-". str_replace('%', $number, $messageStr) . "-" . $type;  // Chop off the %
			return wfMsg($messageStr, $number);
		} 
		// Default case
		$messageStr = "founderprogressbar-". $messageStr . "-" . $type;			
		return wfMsg($messageStr);
	}
	
	// URL list defined above in init()
	private function getURLForTask($task_id) {

		if (!isset($this->urls[$task_id])) return "";
		// Entry can be an array of function, params or a string which is just a plain URL to use
		if (is_array($this->urls[$task_id])) {
			$method = array_shift($this->urls[$task_id]);
			$params = $this->urls[$task_id];
			$title = call_user_func_array("Title::$method", $params);
			return $title->getFullURL();
		} else {
			return $this->urls[$task_id];
		}
	}

	/**
	 * Returns array of task data
	 * @param Array $list
	 * @param Arra $data 
	 */
	private function getCompletionData(Array $list) {
		$data = array();
		$total_tasks = count($list);
		if ($total_tasks == 0) return $data;  // Prevent any divide by zero possibility
		$tasks_completed = 0;
		$tasks_skipped = 0;
		$bonus_tasks = 0;
		foreach ($list as $task) {
			if ($task['task_skipped'] == 1) $tasks_skipped ++;
			if ($task['task_completed'] == 1) $tasks_completed ++;
			if (in_array($task['task_id'], $this->bonus_tasks)) {
				$bonus_tasks ++;
			}
		}
		$data['tasks_completed'] = $tasks_completed;  // bonus tasks do count as completed tasks, like any task
		$data['tasks_skipped'] = $tasks_skipped;
		$data['total_tasks'] = $total_tasks - $bonus_tasks;  // bonus tasks do NOT count against total # of tasks
		$data['completion_percent'] = min(100, round(100 * ($tasks_completed / $total_tasks), 0));
		return $data;
	}
}
