<?php
class FounderProgressBarController extends WikiaController {

	/**
	 * Initialize static data
	 */
	var $messages;
	var $counters;
	var $urls;
	var $bonus_tasks;
	var $click_events;

	const REGULAR_TASK_MAX_ID = 499;

	// Define founder events
	public static $tasks = array(
		'FT_PAGE_ADD_10' => 10,
		'FT_THEMEDESIGNER_VISIT' => 20,
		'FT_MAINPAGE_EDIT' => 30,
		'FT_PHOTO_ADD_10' => 40,
		'FT_CATEGORY_ADD_3' => 50,
		'FT_COMMCENTRAL_VISIT' => 60,
		'FT_WIKIACTIVITY_VISIT' => 70,
		'FT_PROFILE_EDIT' => 80,
		'FT_PHOTO_ADD_20' => 90,
		'FT_TOTAL_EDIT_75' => 100,
		'FT_PAGE_ADD_20' => 110,
		'FT_CATEGORY_EDIT' => 120,
		'FT_WIKIALABS_VISIT' => 130,
		'FT_FB_CONNECT' => 140,
		'FT_CATEGORY_ADD_5' => 150,
		'FT_GALLERY_ADD' => 170,
		'FT_TOPNAV_EDIT' => 180,
		'FT_MAINPAGE_ADDSLIDER' => 190,
		'FT_COMMCORNER_EDIT' => 200,
		'FT_VIDEO_ADD' => 210,
		'FT_USER_ADD_5' => 220,
		'FT_RECENTCHANGES_VISIT' => 230,
		'FT_WORDMARK_EDIT' => 240,
		'FT_MOSTVISITED_VISIT' => 250,
		'FT_TOPTENLIST_ADD' => 260,
		'FT_BLOGPOST_ADD' => 270,
		'FT_FB_LIKES_3' => 280,
		'FT_UNCATEGORIZED_VISIT' => 290,
		'FT_TOTAL_EDIT_300' => 300,

		// Bonus tasks start at ID 500 just to keep them separate if we add more "base" tasks
		'FT_BONUS_PHOTO_ADD_10' => 510,
		'FT_BONUS_PAGE_ADD_5' => 520,
		'FT_BONUS_EDIT_50' => 540,

		// special internal flag for "all tasks complete"
		'FT_COMPLETION' => 1000,
	);


	public function init() {
		// Messages are defined in the i18n file
		// Each message in i18n has a -label -description and -action version
		// If the message name has a % in it that means a $1 substitution is done
		$this->messages = array (
			self::$tasks['FT_PAGE_ADD_10'] => "page-add%",
			self::$tasks['FT_THEMEDESIGNER_VISIT'] => "themedesigner-visit",
			self::$tasks['FT_MAINPAGE_EDIT'] => "mainpage-edit",
			self::$tasks['FT_PHOTO_ADD_10'] => "photo-add%",
			self::$tasks['FT_CATEGORY_ADD_3'] => "category-add%",
			self::$tasks['FT_COMMCENTRAL_VISIT'] => "commcentral-visit",
			self::$tasks['FT_WIKIACTIVITY_VISIT'] => "wikiactivity-visit",
			self::$tasks['FT_PROFILE_EDIT'] => "profile-edit",
			self::$tasks['FT_PHOTO_ADD_20'] => "photo-add%",
			self::$tasks['FT_TOTAL_EDIT_75'] => "total-edit%",
			self::$tasks['FT_PAGE_ADD_20'] => "page-add%",
			self::$tasks['FT_CATEGORY_EDIT'] => "category-edit",
			self::$tasks['FT_WIKIALABS_VISIT'] => "wikialabs-visit",
			self::$tasks['FT_FB_CONNECT'] => "fb-connect",
			self::$tasks['FT_CATEGORY_ADD_5'] => "category-add%",
			self::$tasks['FT_GALLERY_ADD'] => "gallery-add",
			self::$tasks['FT_TOPNAV_EDIT'] => "topnav-edit",
			self::$tasks['FT_MAINPAGE_ADDSLIDER'] => "mainpage-addslider",
			self::$tasks['FT_COMMCORNER_EDIT'] => "commcorner-edit",
			self::$tasks['FT_VIDEO_ADD'] => "video-add",
			self::$tasks['FT_USER_ADD_5'] => "user-add%",
			self::$tasks['FT_RECENTCHANGES_VISIT'] => "recentchanges-visit",
			self::$tasks['FT_WORDMARK_EDIT'] => "wordmark-edit",
			self::$tasks['FT_MOSTVISITED_VISIT'] => "mostvisited-visit",
			self::$tasks['FT_TOPTENLIST_ADD'] => "toptenlist-add",
			self::$tasks['FT_BLOGPOST_ADD'] => "blogpost-add",
			self::$tasks['FT_FB_LIKES_3'] => "fb-likes%",
			self::$tasks['FT_UNCATEGORIZED_VISIT'] => "uncategorized-visit",
			self::$tasks['FT_TOTAL_EDIT_300'] => "total-edit%",
			self::$tasks['FT_BONUS_PHOTO_ADD_10'] => "bonus-photo-add%",
			self::$tasks['FT_BONUS_PAGE_ADD_5'] => "bonus-page-add%",
			self::$tasks['FT_BONUS_EDIT_50'] => "bonus-edit%",
			self::$tasks['FT_COMPLETION'] => "completion"
		);

		// This list says how many times an item needs to be counted to be finished
		$this->counters = array (
			self::$tasks['FT_PAGE_ADD_10'] =>  10,
			self::$tasks['FT_THEMEDESIGNER_VISIT'] =>  1,
			self::$tasks['FT_MAINPAGE_EDIT'] =>  1,
			self::$tasks['FT_PHOTO_ADD_10'] =>  10,
			self::$tasks['FT_CATEGORY_ADD_3'] =>  3,
			self::$tasks['FT_COMMCENTRAL_VISIT'] =>  1,
			self::$tasks['FT_WIKIACTIVITY_VISIT'] =>  1,
			self::$tasks['FT_PROFILE_EDIT'] =>  1,
			self::$tasks['FT_PHOTO_ADD_20'] =>  20,
			self::$tasks['FT_TOTAL_EDIT_75'] =>  75,
			self::$tasks['FT_PAGE_ADD_20'] =>  20,
			self::$tasks['FT_CATEGORY_EDIT'] =>  1,
			self::$tasks['FT_WIKIALABS_VISIT'] =>  1,
			self::$tasks['FT_FB_CONNECT'] =>  1,
			self::$tasks['FT_CATEGORY_ADD_5'] =>  5,
			self::$tasks['FT_GALLERY_ADD'] =>  1,
			self::$tasks['FT_TOPNAV_EDIT'] =>  1,
			self::$tasks['FT_MAINPAGE_ADDSLIDER'] =>  1,
			self::$tasks['FT_COMMCORNER_EDIT'] =>  1,
			self::$tasks['FT_VIDEO_ADD'] =>  1,
			self::$tasks['FT_USER_ADD_5'] =>  5,
			self::$tasks['FT_RECENTCHANGES_VISIT'] =>  1,
			self::$tasks['FT_WORDMARK_EDIT'] =>  1,
			self::$tasks['FT_MOSTVISITED_VISIT'] =>  1,
			self::$tasks['FT_TOPTENLIST_ADD'] =>  1,
			self::$tasks['FT_BLOGPOST_ADD'] =>  1,
			self::$tasks['FT_FB_LIKES_3'] =>  3,
			self::$tasks['FT_UNCATEGORIZED_VISIT'] =>  1,
			self::$tasks['FT_TOTAL_EDIT_300'] =>  300,
			self::$tasks['FT_BONUS_PHOTO_ADD_10'] =>  10,
			self::$tasks['FT_BONUS_PAGE_ADD_5'] =>  5,
			self::$tasks['FT_BONUS_EDIT_50'] =>  50,
			self::$tasks['FT_COMPLETION'] =>  1
		);

		// This list contains rules to build URLs for all the actions
		$this->urls = array (
			self::$tasks['FT_PAGE_ADD_10'] => array("newFromText", "CreatePage", NS_SPECIAL),
			self::$tasks['FT_THEMEDESIGNER_VISIT'] => array("newFromText", "ThemeDesigner", NS_SPECIAL),
			self::$tasks['FT_MAINPAGE_EDIT'] => array("newMainPage"),
			self::$tasks['FT_PHOTO_ADD_10'] => array("newFromText", "Upload", NS_SPECIAL),
			self::$tasks['FT_CATEGORY_ADD_3'] => array("newFromText", wfMsg('founderprogressbar-browse-page-name'), NS_CATEGORY),
			self::$tasks['FT_COMMCENTRAL_VISIT'] => wfMsg('founderprogressbar-commcentral-visit-url'),
			self::$tasks['FT_WIKIACTIVITY_VISIT'] => array("newFromText", "WikiActivity", NS_SPECIAL),
			self::$tasks['FT_PROFILE_EDIT'] => array("newFromText", $this->wg->User->getName(), NS_USER),
			self::$tasks['FT_PHOTO_ADD_20'] => array("newFromText", "Upload", NS_SPECIAL),
			self::$tasks['FT_TOTAL_EDIT_75'] => array("newFromText", "CreatePage", NS_SPECIAL),
			self::$tasks['FT_PAGE_ADD_20'] => array("newFromText", "CreatePage", NS_SPECIAL),
			self::$tasks['FT_CATEGORY_EDIT'] => array("newFromText", "Browse", NS_CATEGORY),
			self::$tasks['FT_WIKIALABS_VISIT'] => array("newFromText", "WikiaLabs", NS_SPECIAL),
			self::$tasks['FT_FB_CONNECT'] => array("newFromText", "Connect", NS_SPECIAL),
			self::$tasks['FT_CATEGORY_ADD_5'] => array("newFromText", wfMsg('founderprogressbar-browse-page-name'), NS_CATEGORY),
			self::$tasks['FT_GALLERY_ADD'] => wfMsg('founderprogressbar-gallery-add-url'),
			self::$tasks['FT_TOPNAV_EDIT'] => array("newFromText", "Wiki-navigation", NS_MEDIAWIKI),
			self::$tasks['FT_MAINPAGE_ADDSLIDER'] => array("newMainPage"),
			self::$tasks['FT_COMMCORNER_EDIT'] => array("newFromText", "Community-corner", NS_MEDIAWIKI),
			self::$tasks['FT_VIDEO_ADD'] => array("newFromText", "Upload", NS_SPECIAL),
			self::$tasks['FT_USER_ADD_5'] => wfMsg('founderprogressbar-user-add5-url'),
			self::$tasks['FT_RECENTCHANGES_VISIT'] => array("newFromText", "RecentChanges", NS_SPECIAL),
			self::$tasks['FT_WORDMARK_EDIT'] => array("newFromText", "ThemeDesigner", NS_SPECIAL),
			self::$tasks['FT_MOSTVISITED_VISIT'] => array("newFromText", "Mostvisitedpages", NS_SPECIAL),
			self::$tasks['FT_TOPTENLIST_ADD'] => array("newFromText", "CreatePage", NS_SPECIAL),
			self::$tasks['FT_FB_LIKES_3'] => array("newMainPage"),
			self::$tasks['FT_UNCATEGORIZED_VISIT'] => array("newFromText", "UncategorizedPages", NS_SPECIAL),
			self::$tasks['FT_BONUS_PHOTO_ADD_10'] => array("newFromText", "Upload", NS_SPECIAL),
			self::$tasks['FT_BONUS_PAGE_ADD_5'] => array("newFromText", "CreatePage", NS_SPECIAL),
			self::$tasks['FT_BONUS_EDIT_50'] => array("newFromText", "WikiActivity", NS_SPECIAL),
			self::$tasks['FT_TOTAL_EDIT_300'] => array("newFromText", "CreatePage", NS_SPECIAL),
		);

		// This task is optional on some wikis
		if (defined('NS_BLOG_ARTICLE')) {
			$this->urls[self::$tasks['FT_BLOGPOST_ADD']] = array("newFromText", $this->wg->User->getName(), NS_BLOG_ARTICLE);
		} else {
			$this->urls[self::$tasks['FT_BLOGPOST_ADD']] = array("newFromText", $this->wg->User->getName(), NS_USER);
		}

		// This list contains additional "bonus" tasks that can be completed if all other tasks are skipped or completed
		$this->bonus_tasks = array (
			self::$tasks['FT_BONUS_PHOTO_ADD_10'],
			self::$tasks['FT_BONUS_PAGE_ADD_5'],
			self::$tasks['FT_BONUS_EDIT_50']
		);

		// tracked events on the frontend
		$this->click_events = array(
			self::$tasks['FT_THEMEDESIGNER_VISIT'] => true,
			self::$tasks['FT_COMMCENTRAL_VISIT'] => true,
			self::$tasks['FT_WIKIACTIVITY_VISIT'] => true,
			self::$tasks['FT_WIKIALABS_VISIT'] => true,
			self::$tasks['FT_RECENTCHANGES_VISIT'] => true,
			self::$tasks['FT_MOSTVISITED_VISIT'] => true,
			self::$tasks['FT_UNCATEGORIZED_VISIT'] => true,
		);
	}

	/**
	 * @desc Get the short list of available founder tasks
	 *
	 * @requestParam list array of Founder tasks already gotten from getLongTaskList
	 * @responseParam list array of Founder tasks that are not completed or skipped, max of 2
	 */

	public function getShortTaskList () {

		// Allow a list to be passed in, otherwise we will get a new one
		if ($this->request->getCheck('list')) {
			$longList = $this->getVal('list');
			$list = $longList['list'];
			$data = $longList['data'];
		} else {
			$response = $this->sendSelfRequest("getLongTaskList");
			$list = $response->getVal('list');
			$data = $response->getVal('data');
		}

		$short_list = array();
		// Grab the first two available items from the long list
		foreach ($list as $id => $item) {
			if ($item['task_skipped'] == 0 && $item['task_completed'] == 0 && $item['task_id'] <= self::REGULAR_TASK_MAX_ID) {
				$short_list[$id] = $item;
			}
			if (count($short_list) == 2) break;
		}

		$this->setVal('list', $short_list);
		$this->setVal('data', $data);
	}

	/**
	 * @param int $db_type
	 * @return Database
	 */
	public function getDb($db_type=DB_SLAVE) {
		return wfGetDB($db_type, array(), $this->wg->ExternalSharedDB);
	}

	/**
	 * @return Memcache
	 */
	public function getMCache() {
		global $wgMemc;
		return $wgMemc;
	}

	/**
	 * @desc Get all founder tasks with more details (available, completed, skipped)
	 *
	 * @requestParam bool use_master true/false
	 * @responseParam list array of Founder actions in the format:
	 */

	public function getLongTaskList () {

		// Try to defeat potential race conditions by connecting to master for reads, default to slave
		$use_master = $this->request->getval("use_master", false);
		$list = null;
		$db_type = DB_SLAVE;
		$memKey = wfMemcKey('FounderLongTaskList');
		// try to get cached data, also use slave
		if ($use_master == true) {
			$db_type = DB_MASTER;
		} else {  // memcache ok for non-master requests
			$list = $this->getMCache()->get($memKey);
		}
		if (empty($list)) {
			wfProfileIn(__METHOD__ . '::miss');
			$list = array();

			$dbr = $this->getDB($db_type);
			$res = $dbr->select(
				'founder_progress_bar_tasks',
				array('task_id', 'task_count', 'task_completed', 'task_skipped', 'task_timestamp'),
				array('wiki_id' => $this->wg->CityId),
				__METHOD__
			);

			while($row = $dbr->fetchObject($res)) {
				$task_id = $row->task_id;
				if ($task_id == self::$tasks['FT_COMPLETION']) continue;  // Make sure the "completion" task does not show up as a task
				$list[$task_id] = array (
					"task_id" => $task_id,
					"task_count" => $row->task_count,
					"task_completed" => $row->task_completed,
					"task_skipped" => $row->task_skipped,
					"task_timestamp" => wfTimeFormatAgo($row->task_timestamp),
					);
			}

			if (!empty($list)) {
				$this->getMCache()->set($memKey, $list, 60*60); // 1 hour
			}

			wfProfileOut(__METHOD__ . '::miss');
		}
		$this->buildURLs($list);  // must build urls after getting data from memcache because we can't cache them
		$this->response->setVal("list", $list);
		$data = $this->getCompletionData($list);
		$this->response->setVal("data", $data);
	}

	/**
	 * @desc Get one founder tasks only
	 *
	 * @requestParam int task_id The ID of the task completed
	 * @requestParam bool use_master true/false
	 * @responseParam list array of Founder actions in the format:
	 */

	public function getSingleTask() {

		$task_id = $this->request->getVal("task_id");
		$use_master = $this->request->getval("use_master", false);
		$db_type = $use_master ? DB_MASTER : DB_SLAVE;

		if ( $task_id ) {
			$dbr = $this->getDB($db_type);
			$res = $dbr->select(
				'founder_progress_bar_tasks',
				array('task_id', 'task_count', 'task_completed', 'task_skipped', 'task_timestamp'),
				array('task_id' => $task_id, 'wiki_id' => $this->wg->CityId),
				__METHOD__
			);

			$row = $res->fetchRow();
			$list[$task_id] = array (
				"task_id" => $task_id,
				"task_count" => $row['task_count'],
				"task_completed" => $row['task_completed'],
				"task_skipped" => $row['task_skipped'],
				"task_timestamp" => wfTimeFormatAgo($row['task_timestamp']),
			);
			$this->setVal("list", $list);
		} else {
			$this->setVal('result', 'error');
			$this->setVal('error', 'invalid task_id');
		}
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
		$isBonusTask = in_array($task_id, $this->bonus_tasks) ? true : false;
		$response = $this->sendSelfRequest('isTaskComplete', array("task_id" => $task_id));
		if (!$isBonusTask && $response->getVal('task_completed', 0) == "1") {
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
		$dbw->query($sql, __METHOD__);
		$res = $dbw->select (
			'founder_progress_bar_tasks',
			array('task_id', 'task_count'),
			array('wiki_id' => $wiki_id, 'task_id' => $task_id),
			__METHOD__
		);

		$row = $dbw->fetchRow($res);
		if (!$row) {
			// Some kind of crazy error happened?
			$this->setVal('result', 'error');
			$this->setVal('error', 'invalid task_id');
			return;
		}
		$actions_completed = (int) $row['task_count'];
		$actions_remaining = $this->counters[$task_id] - $actions_completed;
		$this->setVal('actions_completed', $actions_completed);
		$this->setVal('actions_remaining', $actions_remaining);
		$this->setVal('result', 'OK');
		if ($actions_remaining <= 0) {
			$completedSQL = "task_completed = 1";
			// Bonus tasks can be completed more than once
			if (in_array($task_id, $this->bonus_tasks)) {
				$completedSQL = "task_completed = task_completed + 1";
			}
			$dbw->update(
				'founder_progress_bar_tasks',
				array('task_count' => '0', $completedSQL),
				array('wiki_id' => $wiki_id, 'task_id' => $task_id),
				__METHOD__
			);
			$this->setVal('result', "task_completed");
			// Check to see if we got to 100% complete
			FounderProgressBarHooks::allTasksComplete(true);
			// Open bonus task if necessary
			$this->setVal("bonus_tasks_unlocked", $this->openBonusTask());
		}
		$dbw->commit();
		// DB update was done, so force refresh of memcache data
		$this->sendSelfRequest("getLongTaskList", array("use_master" => true));

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
		if (in_array($task_id, $this->bonus_tasks)) {
			$this->setVal('result', 'error');
			$this->setVal('error', 'illegal_task');
			return;
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
			),
			__METHOD__
		);
		$dbw->commit();
		// Checks if everything is completed or skipped and possibly open up a bonus task
		// Do this before the memcache clear so that we load correct data into memcache if a bonus task is added
		$this->setVal("bonus_tasks_unlocked", $this->openBonusTask());
		// DB updated so clear memcache val
		$this->sendSelfRequest("getLongTaskList", array("use_master" => true));
		$this->setVal("result", "OK");
	}

	/**
	 * @requestParam int task_id
	 * @responseParam int task_completed 0 or 1+  (bonus tasks can be completed more than once)
	 */
	public function isTaskComplete() {
		$task_id = $this->getVal("task_id");
		$response = $this->sendSelfRequest("getSingleTask");
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

		$activityFull = F::app()->sendRequest('FounderProgressBar', 'getLongTaskList', array())->getData();
		$activityListPreview = F::app()->sendRequest( 'FounderProgressBar', 'getShortTaskList', array('list' => $activityFull))->getData();

		$showCompletionMessage = false;

		$activeTaskList = array();
		$skippedTaskList = array();
		$bonusTaskList = array();
		foreach($activityFull['list'] as $activity) {
			if(!empty($activity['task_skipped'])) {
				$activity['task_skippable'] = 0;
				$skippedTaskList[] = $activity;
			} else if (in_array($activity['task_id'], $this->bonus_tasks)) {
				// bonus task list is built in the next step
			} else if ($activity['task_id'] == self::$tasks['FT_COMPLETION']) {
				$showCompletionMessage = !$activity['task_skipped'];
			} else {
				$activity['task_skippable'] = 1;
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
			if (isset($activityFull['list'][$task_id])) {
				$bonusTask["task_count"] = $activityFull['list'][$task_id]["task_count"];
				$bonusTask["task_completed"] = $activityFull['list'][$task_id]["task_completed"];
				if(!is_int($activityFull['list'][$task_id]["task_timestamp"])) {
					$activityFull['list'][$task_id]["task_timestamp"] = strtotime($activityFull['list'][$task_id]["task_timestamp"]);
				}
				$bonusTask["task_timestamp"] = wfTimeFormatAgo($activityFull['list'][$task_id]["task_timestamp"]);
				$bonusTask["task_locked"] = 0;
			} else {
				$bonusTask["task_completed"] = 0;
				$bonusTask["task_locked"] = 1;
			}
			$bonusTask["task_skippable"] = 0;
			$bonusTask["task_is_bonus"] = 1;

			$bonusTaskList[] = $bonusTask;
		}

		$this->response->setVal('progressData', $activityListPreview['data']);
		$this->response->setVal('activityListPreview', $activityListPreview['list']);
		$this->response->setVal('activeTaskList', $activeTaskList);
		$this->response->setVal('skippedTaskList', $skippedTaskList);
		$this->response->setVal('bonusTaskList', $bonusTaskList);
		$this->response->setVal('clickEvents', $this->click_events);
		$this->response->setVal('showCompletionMessage', $showCompletionMessage);
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
			$html = F::app()->getView( 'FounderProgressBar', 'widgetActivityPreview', array('activity' => $activity, 'clickEvents' => $this->click_events, 'index' => 1, 'wgBlankImgUrl' => F::app()->wg->BlankImgUrl, 'visible' => false ))->render();
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
		// don't show it on production (BugId:45724)
		if (!empty($this->wg->DevelEnvironment)) {
			if (! isset($this->messages[$task_id]) ) {
				if ($type == "label") return "Task $type";
				if ($type == "description") return "Task $type Placeholder";
				if ($type == "action") return "Call to action Label";
			}
		}

		$messageStr = $this->messages[$task_id];
		if (substr($messageStr, -1) == '%') {
			$number = $this->counters[$task_id];
			$messageStr = "founderprogressbar-". str_replace('%', $number, $messageStr) . "-" . $type;  // Chop off the %
			return wfMsgExt($messageStr, array('parsemag'), $number);
		}
		// Default case
		$messageStr = "founderprogressbar-". $messageStr . "-" . $type;
		return wfMsg($messageStr);
	}

	// Build URLs by lookup into $this->urls
	private function buildURLs(Array &$list) {
		foreach ($list as $task_id => $data) {
			$list[$task_id]["task_label"] = $this->getMsgForTask($task_id, "label");
			$list[$task_id]["task_description"] = $this->getMsgForTask($task_id, "description");
			$list[$task_id]["task_action"] = $this->getMsgForTask($task_id, "action");
			$list[$task_id]["task_url"] = $this->getURLForTask($task_id);
		}
	}

	// URL list defined above in init()
	private function getURLForTask($task_id) {

		if (!isset($this->urls[$task_id])) return "";
		// Entry can be an array of function, params or a string which is just a plain URL to use
		if (is_array($this->urls[$task_id])) {
			$method = array_shift($this->urls[$task_id]);
			$params = $this->urls[$task_id];
			$title = call_user_func_array("Title::$method", $params);
			if (is_object($title)) {
				if ($method == "newMainPage") {
					return $title->getFullURL("action=edit");
				}
				return $title->getFullURL();
			} else {
				return ""; 	// bad title -- throw exception?
			}
		} else {
			return $this->urls[$task_id];
		}
	}

	// Check task list, and if all tasks are completed or skipped open a bonus task
	private function openBonusTask() {

		$response = $this->sendSelfRequest("getLongTaskList", array("use_master" => true));
		$list = $response->getVal('list');

		// If bonus tasks already exist in the task list, no need to continue
		if (isset($list[$this->bonus_tasks[0]])) {
			return false;
		}

		$total_tasks = count($list);
		$tasks_completed_or_skipped = 0;
		foreach ($list as $task) {
			if ($task["task_skipped"] || $task["task_completed"]) $tasks_completed_or_skipped += 1;
		}
		if ($tasks_completed_or_skipped >= $total_tasks) {
			$wiki_id = $this->wg->CityId;
			// Special case, unlock all bonus tasks
			foreach ($this->bonus_tasks as $bonus_task_id) {
				if (!isset($list[$bonus_task_id])) {
					$sql = "INSERT IGNORE INTO founder_progress_bar_tasks SET wiki_id=$wiki_id, task_id=$bonus_task_id";
					$dbw = $this->getDB(DB_MASTER);
					$dbw->query($sql, __METHOD__);
					$dbw->commit();
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Returns array of task data
	 * @param Array $list
	 * @param Array $data
	 */
	private function getCompletionData(Array $list) {
		$data = array();
		$total_tasks = max(count($list), 1); // Prevent any divide by zero possibility
		$tasks_completed = 0;
		$tasks_skipped = 0;
		$bonus_tasks = 0;
		foreach ($list as $task) {
			if ($task['task_skipped'] == 1) $tasks_skipped ++;
			if ($task['task_completed'] > 0) $tasks_completed += $task['task_completed'];
			if (in_array($task['task_id'], $this->bonus_tasks)) {
				$bonus_tasks ++;
			}
		}
		$data['tasks_completed'] = $tasks_completed;  // bonus tasks do count as completed tasks, like any task
		$data['tasks_skipped'] = $tasks_skipped;
		$adjusted_total_tasks =  $total_tasks - $bonus_tasks;  // bonus tasks do NOT count against total # of tasks
		$data['total_tasks'] = $adjusted_total_tasks;
		$data['completion_percent'] = min(100, round(100 * ($tasks_completed / $adjusted_total_tasks), 0));
		return $data;
	}
}
