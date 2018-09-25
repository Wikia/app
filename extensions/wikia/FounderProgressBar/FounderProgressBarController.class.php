<?php
class FounderProgressBarController extends WikiaController {

	use BonusTasksHelperTrait;

	/**
	 * Initialize static data
	 */
	var $messages;
	var $counters;
	var $urls;
	var $click_events;

	const REGULAR_TASK_MAX_ID = 499;


	public function init() {
		// Messages are defined in the i18n file
		// Each message in i18n has a -label -description and -action version
		// If the message name has a % in it that means a $1 substitution is done
		$this->messages = array (
			FounderTask::TASKS['FT_PAGE_ADD_10'] => "page-add%",
			FounderTask::TASKS['FT_THEMEDESIGNER_VISIT'] => "themedesigner-visit",
			FounderTask::TASKS['FT_MAINPAGE_EDIT'] => "mainpage-edit",
			FounderTask::TASKS['FT_PHOTO_ADD_10'] => "photo-add%",
			FounderTask::TASKS['FT_CATEGORY_ADD_3'] => "category-add%",
			FounderTask::TASKS['FT_COMMCENTRAL_VISIT'] => "commcentral-visit",
			FounderTask::TASKS['FT_WIKIACTIVITY_VISIT'] => "wikiactivity-visit",
			FounderTask::TASKS['FT_PROFILE_EDIT'] => "profile-edit",
			FounderTask::TASKS['FT_PHOTO_ADD_20'] => "photo-add%",
			FounderTask::TASKS['FT_TOTAL_EDIT_75'] => "total-edit%",
			FounderTask::TASKS['FT_PAGE_ADD_20'] => "page-add%",
			FounderTask::TASKS['FT_CATEGORY_EDIT'] => "category-edit",
			FounderTask::TASKS['FT_WIKIALABS_VISIT'] => "wikialabs-visit",
			FounderTask::TASKS['FT_CATEGORY_ADD_5'] => "category-add%",
			FounderTask::TASKS['FT_GALLERY_ADD'] => "gallery-add",
			FounderTask::TASKS['FT_TOPNAV_EDIT'] => "topnav-edit",
			FounderTask::TASKS['FT_MAINPAGE_ADDSLIDER'] => "mainpage-addslider",
			FounderTask::TASKS['FT_COMMCORNER_EDIT'] => "commcorner-edit",
			FounderTask::TASKS['FT_VIDEO_ADD'] => "video-add",
			FounderTask::TASKS['FT_USER_ADD_5'] => "user-add%",
			FounderTask::TASKS['FT_RECENTCHANGES_VISIT'] => "recentchanges-visit",
			FounderTask::TASKS['FT_WORDMARK_EDIT'] => "wordmark-edit",
			FounderTask::TASKS['FT_MOSTVISITED_VISIT'] => "mostvisited-visit",
			FounderTask::TASKS['FT_BLOGPOST_ADD'] => "blogpost-add",
			FounderTask::TASKS['FT_FB_LIKES_3'] => "fb-likes%",
			FounderTask::TASKS['FT_UNCATEGORIZED_VISIT'] => "uncategorized-visit",
			FounderTask::TASKS['FT_TOTAL_EDIT_300'] => "total-edit%",
			FounderTask::TASKS['FT_BONUS_PHOTO_ADD_10'] => "bonus-photo-add%",
			FounderTask::TASKS['FT_BONUS_PAGE_ADD_5'] => "bonus-page-add%",
			FounderTask::TASKS['FT_BONUS_EDIT_50'] => "bonus-edit%",
			FounderTask::TASKS['FT_COMPLETION'] => "completion"
		);

		// This list contains rules to build URLs for all the actions
		$this->urls = array (
			FounderTask::TASKS['FT_PAGE_ADD_10'] => array("newFromText", "CreatePage", NS_SPECIAL),
			FounderTask::TASKS['FT_THEMEDESIGNER_VISIT'] => array("newFromText", "ThemeDesigner", NS_SPECIAL),
			FounderTask::TASKS['FT_MAINPAGE_EDIT'] => array("newMainPage"),
			FounderTask::TASKS['FT_PHOTO_ADD_10'] => array("newFromText", "Upload", NS_SPECIAL),
			FounderTask::TASKS['FT_CATEGORY_ADD_3'] => array("newFromText", wfMsg('founderprogressbar-browse-page-name'), NS_CATEGORY),
			FounderTask::TASKS['FT_COMMCENTRAL_VISIT'] => wfMsg('founderprogressbar-commcentral-visit-url'),
			FounderTask::TASKS['FT_WIKIACTIVITY_VISIT'] => array("newFromText", "WikiActivity", NS_SPECIAL),
			FounderTask::TASKS['FT_PROFILE_EDIT'] => array("newFromText", $this->wg->User->getName(), NS_USER),
			FounderTask::TASKS['FT_PHOTO_ADD_20'] => array("newFromText", "Upload", NS_SPECIAL),
			FounderTask::TASKS['FT_TOTAL_EDIT_75'] => array("newFromText", "CreatePage", NS_SPECIAL),
			FounderTask::TASKS['FT_PAGE_ADD_20'] => array("newFromText", "CreatePage", NS_SPECIAL),
			FounderTask::TASKS['FT_CATEGORY_EDIT'] => array("newFromText", "Browse", NS_CATEGORY),
			FounderTask::TASKS['FT_WIKIALABS_VISIT'] => array("newFromText", "WikiaLabs", NS_SPECIAL),
			FounderTask::TASKS['FT_CATEGORY_ADD_5'] => array("newFromText", wfMsg('founderprogressbar-browse-page-name'), NS_CATEGORY),
			FounderTask::TASKS['FT_GALLERY_ADD'] => wfMsg('founderprogressbar-gallery-add-url'),
			FounderTask::TASKS['FT_TOPNAV_EDIT'] => array("newFromText", "Wiki-navigation", NS_MEDIAWIKI),
			FounderTask::TASKS['FT_MAINPAGE_ADDSLIDER'] => array("newMainPage"),
			FounderTask::TASKS['FT_COMMCORNER_EDIT'] => array("newFromText", "Community-corner", NS_MEDIAWIKI),
			FounderTask::TASKS['FT_VIDEO_ADD'] => array("newFromText", "Upload", NS_SPECIAL),
			FounderTask::TASKS['FT_USER_ADD_5'] => wfMsg('founderprogressbar-user-add5-url'),
			FounderTask::TASKS['FT_RECENTCHANGES_VISIT'] => array("newFromText", "RecentChanges", NS_SPECIAL),
			FounderTask::TASKS['FT_WORDMARK_EDIT'] => array("newFromText", "ThemeDesigner", NS_SPECIAL),
			FounderTask::TASKS['FT_MOSTVISITED_VISIT'] => array("newFromText", "Mostvisitedpages", NS_SPECIAL),
			FounderTask::TASKS['FT_FB_LIKES_3'] => array("newMainPage"),
			FounderTask::TASKS['FT_UNCATEGORIZED_VISIT'] => array("newFromText", "UncategorizedPages", NS_SPECIAL),
			FounderTask::TASKS['FT_BONUS_PHOTO_ADD_10'] => array("newFromText", "Upload", NS_SPECIAL),
			FounderTask::TASKS['FT_BONUS_PAGE_ADD_5'] => array("newFromText", "CreatePage", NS_SPECIAL),
			FounderTask::TASKS['FT_BONUS_EDIT_50'] => array("newFromText", "WikiActivity", NS_SPECIAL),
			FounderTask::TASKS['FT_TOTAL_EDIT_300'] => array("newFromText", "CreatePage", NS_SPECIAL),
		);

		// This task is optional on some wikis
		if (defined('NS_BLOG_ARTICLE')) {
			$this->urls[FounderTask::TASKS['FT_BLOGPOST_ADD']] = array("newFromText", $this->wg->User->getName(), NS_BLOG_ARTICLE);
		} else {
			$this->urls[FounderTask::TASKS['FT_BLOGPOST_ADD']] = array("newFromText", $this->wg->User->getName(), NS_USER);
		}

		// tracked events on the frontend
		$this->click_events = array(
			FounderTask::TASKS['FT_THEMEDESIGNER_VISIT'] => true,
			FounderTask::TASKS['FT_COMMCENTRAL_VISIT'] => true,
			FounderTask::TASKS['FT_WIKIACTIVITY_VISIT'] => true,
			FounderTask::TASKS['FT_WIKIALABS_VISIT'] => true,
			FounderTask::TASKS['FT_RECENTCHANGES_VISIT'] => true,
			FounderTask::TASKS['FT_MOSTVISITED_VISIT'] => true,
			FounderTask::TASKS['FT_UNCATEGORIZED_VISIT'] => true,
		);
	}

	/**
	 * @desc Get the short list of available founder tasks
	 *
	 * @param array $tasks
	 * @return array list of Founder tasks that are not completed or skipped, max of 2
	 */

	private function getShortTaskList( array $tasks = null ): array {
		// Allow a list to be passed in, otherwise we will get a new one
		if ( is_null( $tasks ) ) {
			list( $tasks, ) = $this->getLongTaskList();
		}

		$short_list = array();
		// Grab the first two available items from the long list
		foreach ($tasks as $id => $item) {
			if ($item['task_skipped'] == 0 && $item['task_completed'] == 0 && $item['task_id'] <= self::REGULAR_TASK_MAX_ID) {
				$short_list[$id] = $item;
			}
			if (count($short_list) == 2) break;
		}

		return $short_list;
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
	 * @return array list of Founder actions and completion data
	 */

	private function getLongTaskList(): array {
		$list = null;
		$memKey = wfMemcKey('FounderLongTaskList');
		$list = $this->getMCache()->get($memKey);

		if (empty($list)) {
			$list = array();

			$dbr = $this->getDB( DB_SLAVE );
			$res = $dbr->select(
				'founder_progress_bar_tasks',
				array('task_id', 'task_count', 'task_completed', 'task_skipped', 'task_timestamp'),
				array('wiki_id' => $this->wg->CityId),
				__METHOD__
			);

			while($row = $dbr->fetchObject($res)) {
				$task_id = $row->task_id;
				if ($task_id == FounderTask::TASKS['FT_COMPLETION']) continue;  // Make sure the "completion" task does not show up as a task
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
		}
		$this->buildURLs($list);  // must build urls after getting data from memcache because we can't cache them
		$data = $this->getCompletionData($list);

		return [ $list, $data ];
	}

	/**
	 * @desc
	 * @requestParam int task_id The ID of the task to skip
	 * @requestParam int task_skipped 1 to skip, 0 to "un-skip"
	 * @responseParam string result OK or error
	 */

	public function skipTask() {
		$task_id = $this->request->getInt( "task_id" );
		$task_skipped = (bool) $this->request->getInt( "task_skipped", 1 );

		if ( empty( $task_id ) || in_array( $task_id, FounderTask::BONUS ) ) {
			$this->setVal( 'result', 'error' );
			$this->setVal( 'error', 'illegal_task' );
			return;
		}

		$model = new FounderProgressBarModel();
		$tasks = $model->getTasksStatus();

		$tasks[$task_id]->setSkipped( $task_skipped );

		$model->skipTask( $task_id, $task_skipped );

		$shouldUnlockBonusTasks = $this->shouldUnlockBonusTasks( $tasks );

		if ( $shouldUnlockBonusTasks ) {
			$model->unlockBonusTasks();
		}

		$this->setVal( "bonus_tasks_unlocked", $shouldUnlockBonusTasks );
		$this->setVal( "result", "OK" );
	}

	public function widget() {
		global $wgBlankImgUrl;
		$this->response->addAsset( 'extensions/wikia/FounderProgressBar/css/FounderProgressBar.scss' );
		$this->response->addAsset( 'extensions/wikia/FounderProgressBar/js/modernizr.custom.founder.js' );
		$this->response->addAsset( 'extensions/wikia/FounderProgressBar/js/FounderProgressBar.js' );
		$this->response->setVal("wgBlankImgUrl", $wgBlankImgUrl);

		list( $tasks, $completion ) = $this->getLongTaskList();

		$activityListPreview = $this->getShortTaskList( $tasks );

		$showCompletionMessage = false;

		$activeTaskList = array();
		$skippedTaskList = array();
		$bonusTaskList = array();
		foreach ( $tasks as $activity ) {
			if(!empty($activity['task_skipped'])) {
				$activity['task_skippable'] = 0;
				$skippedTaskList[] = $activity;
			} else if (in_array($activity['task_id'], FounderTask::BONUS)) {
				// bonus task list is built in the next step
			} else if ($activity['task_id'] == FounderTask::TASKS['FT_COMPLETION']) {
				$showCompletionMessage = !$activity['task_skipped'];
			} else {
				$activity['task_skippable'] = 1;
				$activeTaskList[] = $activity;
			}
		}
		// Bonus tasks don't exist in the DB until they are opened up.  display them but default to "locked" status
		// If they exist in the task list from the DB, they are by definition unlocked (skipTask contains that biz logic)
		foreach (FounderTask::BONUS as $task_id) {
			$bonusTask = array (
					"task_id" => $task_id,
					"task_label" => $this->getMsgForTask($task_id, "label"),
					"task_description" => $this->getMsgForTask($task_id, "description"),
					"task_action" => $this->getMsgForTask($task_id, "action"),
					"task_url" => $this->getURLForTask($task_id)
				);
			// Task is opened up
			if ( isset( $tasks[$task_id] ) ) {
				$bonusTask["task_count"] = $tasks[$task_id]["task_count"];
				$bonusTask["task_completed"] = $tasks[$task_id]["task_completed"];
				if ( !is_int( $tasks[$task_id]["task_timestamp"] ) ) {
					$tasks[$task_id]["task_timestamp"] = strtotime( $tasks[$task_id]["task_timestamp"] );
				}
				$bonusTask["task_timestamp"] = wfTimeFormatAgo( $tasks['list'][$task_id]["task_timestamp"] );
				$bonusTask["task_locked"] = 0;
			} else {
				$bonusTask["task_completed"] = 0;
				$bonusTask["task_locked"] = 1;
			}
			$bonusTask["task_skippable"] = 0;
			$bonusTask["task_is_bonus"] = 1;

			$bonusTaskList[] = $bonusTask;
		}

		$this->response->setVal( 'progressData', $completion );
		$this->response->setVal( 'activityListPreview', $activityListPreview );
		$this->response->setVal('activeTaskList', $activeTaskList);
		$this->response->setVal('skippedTaskList', $skippedTaskList);
		$this->response->setVal('bonusTaskList', $bonusTaskList);
		$this->response->setVal('clickEvents', $this->click_events);
		$this->response->setVal('showCompletionMessage', $showCompletionMessage);
	}

	public function getNextTask() {
		$excluded_task_id = $this->request->getVal('excluded_task_id', '');
		$shortList = $this->getShortTaskList();
		$activity = '';
		foreach ($shortList as $task) {
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
			$number = FounderTask::COUNTERS[$task_id];
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
			if (in_array($task['task_id'], FounderTask::BONUS)) {
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

	public static function purgeTaskList() {
		global $wgMemc;

		$wgMemc->delete( wfMemcKey('FounderLongTaskList') );
	}
}
