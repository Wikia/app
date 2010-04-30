<?php
define('ACHIEVEMENT_EDIT_ARTICLE', 1);
define('ACHIEVEMENT_NEW_ARTICLE', 2);
define('ACHIEVEMENT_IMAGE_ADDED_TO_ARTICLE', 3);
define('ACHIEVEMENT_VIDEO_ADDED_TO_ARTICLE', 4);
define('ACHIEVEMENT_CATEGORY_ADDED_TO_ARTICLE', 5);
define('ACHIEVEMENT_EDIT_MY_USERPAGE', 6);
define('ACHIEVEMENT_EDIT_SOMEONE_USERPAGE', 7);
define('ACHIEVEMENT_EDIT_FOR_5_DAYS', 8);
define('ACHIEVEMENT_EDIT_10_ARTICLES', 9);

// i18n
$wgExtensionMessagesFiles['Achievements'] = dirname(__FILE__) . '/' . 'Achievements.i18n.php';

$wgExtensionFunctions[] = 'Achievements_Setup';

$wgAutoloadClasses['SpecialLeaderboard'] = dirname(__FILE__) . '/' . 'SpecialLeaderboard.php';

$wgSpecialPages['Leaderboard'] = 'SpecialLeaderboard';

/**
 * @author: Inez Korczyński
 */
function Achievements_Setup() {
	global $wgHooks, $achievementTypes;
	$wgHooks['ArticleSaveComplete'][] = 'Achievements_ArticleSaveComplete';
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'Achievements_Display';

	$achievementTypes = array();

	// be very careful with this array editing
	$achievementTypes[ACHIEVEMENT_EDIT_ARTICLE] = array(
		'name' => 'edits',
		'type' => 'repeat',
		'levels' => array(1, 5, 10, 25, 50, 100, 200)
	);
	$achievementTypes[ACHIEVEMENT_IMAGE_ADDED_TO_ARTICLE] = array(
		'name' => 'pictures',
		'type' => 'repeat',
		'levels' => array(1, 5, 10, 20, 40)
	);
	$achievementTypes[ACHIEVEMENT_NEW_ARTICLE] = array(
		'name' => 'newpage',
		'type' => 'repeat',
		'levels' => array(1, 5, 10, 20, 40)
	);
	$achievementTypes[ACHIEVEMENT_CATEGORY_ADDED_TO_ARTICLE] = array(
		'name' => 'category',
		'type' => 'repeat',
		'levels' => array(1, 5, 10, 20, 40)
	);
	$achievementTypes[ACHIEVEMENT_VIDEO_ADDED_TO_ARTICLE] = array(
		'name' => 'videos',
		'type' => 'repeat',
		'levels' => array(1, 5, 10, 20, 40)
	);

	$achievementTypes[ACHIEVEMENT_EDIT_MY_USERPAGE] = array('name' => 'userpage', 'type' => 'onetime');
	$achievementTypes[ACHIEVEMENT_EDIT_SOMEONE_USERPAGE] = array('name' => 'makingfriends', 'type' => 'onetime');
	$achievementTypes[ACHIEVEMENT_EDIT_10_ARTICLES] = array('name' => 'busyday', 'type' => 'onetime');
	$achievementTypes[ACHIEVEMENT_EDIT_FOR_5_DAYS] = array('name' => 'keytothewiki', 'type' => 'onetime');
}

/**
 * @author: Inez Korczyński
 */
function Achievements_Display(&$template, &$templateEngine) {
	global $wgTitle, $achievementTypes, $wgExtensionsPath, $wgRequest;

	if($wgRequest->getVal('action', 'view') != 'view') {
		return true;
	}

	if(empty($wgTitle) || $wgTitle->getNamespace() != NS_USER) {
		return true;
	}

	$user = User::newFromName($wgTitle->getText());

	if(empty($user) || !$user->isLoggedIn()) {
		return true;
	}


	wfLoadExtensionMessages('Achievements');

	$userBadges = Achievements_GetUserTopBadges($user->getID());
	$userCounters = Achievements_GetUserCounters($user->getID());

	$dbr = wfGetDB(DB_MASTER);

	$dbr->query('set @rank = 0');
	$res = $dbr->query('select c from (select @rank:=@rank+1 as c, user_id, count(user_id) as rank from achievements_badges group by user_id order by rank DESC) as c where user_id = '.$user->getID());
	$allWiki = $res->fetchObject()->c;

	$dbr->query('set @rank = 0');
	$res = $dbr->query('select c from (select @rank:=@rank+1 as c, user_id, count(user_id) as rank from achievements_badges where data >= date_sub(now(), interval 7 day) group by user_id order by rank DESC) as c where user_id = '.$user->getID());
	$thisWeek = $res->fetchObject()->c;

	$badgesTemplate = new EasyTemplate(dirname(__FILE__).'/templates');
	$badgesTemplate->set_vars(array('userBadges' => $userBadges,
									'userCounters' => $userCounters,
									'user' => $user,
									'allWiki' => $allWiki,
									'thisWeek' => $thisWeek));
	$badgesHTML = $badgesTemplate->render('badges');

	$templateEngine->data['bodytext'] = $badgesHTML . $templateEngine->data['bodytext'];

	return true;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_GetUserCounters($userId) {
	$userCounters = array();
	$dbr = wfGetDB(DB_MASTER);

	$res = $dbr->select('achievements_counters',
						array('achievement_type_id', 'counter'),
			            array('user_id' => $userId),
			            'Achievements_GetUserCounters');

	while($row = $dbr->fetchObject($res)) {
		$userCounters[$row->achievement_type_id] = $row->counter;
	}

	return $userCounters;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_GetUserTopBadges($userId) {
	$userBadges = array();
	$dbr = wfGetDB(DB_MASTER);

	$res = $dbr->select('achievements_badges',
						array('achievement_type_id', 'MAX(level) as level'),
			            array('user_id' => $userId),
			            'Achievements_Display',
			            array('GROUP BY' => 'achievement_type_id'));

	while($row = $dbr->fetchObject($res)) {
		$userBadges[$row->achievement_type_id] = $row->level;
	}

	return $userBadges;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_ArticleSaveComplete(&$article, &$user, $text, $summary, &$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
	global $wgContentNamespaces;

	if(!$user->isLoggedIn()) {
		return true;
	}

	if(!($status instanceof Status) || $status->ok != true || count($status->errors) != 0) {
		return true;
	}

	if(!$article) {
		return true;
	}

	$achievementCountersToIncrease = array();

	$title = $article->getTitle();

	$userBadges = Achievements_GetUserTopBadges($user->getID());

	if(!isset($userBadges[ACHIEVEMENT_EDIT_MY_USERPAGE])) {
		if($title->getNamespace() == NS_USER && $title->getText() == $user->getName()) {
			$achievementCountersToIncrease[ACHIEVEMENT_EDIT_MY_USERPAGE] = 1;
		}
	}

	if(!isset($userBadges[ACHIEVEMENT_EDIT_SOMEONE_USERPAGE])) {
		if($title->getNamespace() == NS_USER_TALK && $title->getText() != $user->getName()) {
			$achievementCountersToIncrease[ACHIEVEMENT_EDIT_SOMEONE_USERPAGE] = 1;
		}
	}

	if(in_array($title->getNamespace(), $wgContentNamespaces)) {

		if(!isset($userBadges[ACHIEVEMENT_EDIT_10_ARTICLES])) {
			$dbr = wfGetDB(DB_MASTER);
			$res = $dbr->query('SELECT count(DISTINCT(rc_cur_id)) as cnt FROM (SELECT rc_cur_id FROM recentchanges WHERE rc_type = 0 AND rc_user_text =  '.$dbr->addQuotes($user->getName()).' AND rc_timestamp >= date_sub(now(), interval 24 hour) AND rc_namespace IN ('.join(',', $wgContentNamespaces).')) AS c');
			if($res->fetchObject()->cnt >= 9) {
				$achievementCountersToIncrease[ACHIEVEMENT_EDIT_10_ARTICLES] = 1;
			}
		}

		if(!isset($userBadges[ACHIEVEMENT_EDIT_FOR_5_DAYS])) {
		}

		// article edit and article creation
		if($status->value['new'] == true) {
			$achievementCountersToIncrease[ACHIEVEMENT_NEW_ARTICLE] = 1;
		} else {
			$achievementCountersToIncrease[ACHIEVEMENT_EDIT_ARTICLE] = 1;
		}

		// adding video or image to an article
		$mediaInserts = Wikia::getVar('imageInserts');
		if(!empty($mediaInserts) && is_array($mediaInserts)) {
			foreach($mediaInserts as $insert) {
				if($insert['il_to']{0} == ':') {
					$type = ACHIEVEMENT_VIDEO_ADDED_TO_ARTICLE;
				} else {
					$type = ACHIEVEMENT_IMAGE_ADDED_TO_ARTICLE;
				}

				if(!isset($achievementCountersToIncrease[$type])) {
					$achievementCountersToIncrease[$type] = 0;
				}

				$achievementCountersToIncrease[$type]++;
			}
		}

		// adding category to an article
		$categoryInserts = Wikia::getVar('categoryInserts');
		if(!empty($categoryInserts) && is_array($categoryInserts)) {
			$achievementCountersToIncrease[ACHIEVEMENT_CATEGORY_ADDED_TO_ARTICLE] = count($categoryInserts);
		}

	}

	// if there are any achievement counters to increase then let's do that and if needed add badges
	if(count($achievementCountersToIncrease) > 0) {
		$currentCounters = Achievements_GetCurrentCounters($user->getId(), array_keys($achievementCountersToIncrease));
		$newCounters = array();

		foreach($achievementCountersToIncrease as $achievementTypeId => $counter) {
			$newCounters[$achievementTypeId] = $currentCounters[$achievementTypeId] + $counter;
		}

		Achievements_UpdateCounters($user->getId(), $newCounters);
		Achievements_AddBadgesIfNeeded($user->getId(), $newCounters);

		// invalidate cache
		$userpageTitle = Title::newFromText($user->getName(), NS_USER);
		if($userpageTitle instanceof Title) {
			$userpageTitle->invalidateCache();
		}

	}

	return true;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_AddBadgesIfNeeded($userId, $counters /* achievementTypeId => counter */) {
	global $achievementTypes;

	$userBadges = Achievements_GetUserTopBadges($userId);

	$rows = array();

	foreach($counters as $achievementTypeId => $counter) {
		if($achievementTypes[$achievementTypeId]['type'] == 'repeat') {
			$valuesNo = count($achievementTypes[$achievementTypeId]['levels']);
			$maxValue = $achievementTypes[$achievementTypeId]['levels'][$valuesNo-1];

			if($counter > $maxValue) {
				$secondMaxValue = $achievementTypes[$achievementTypeId]['levels'][$valuesNo-2];
				$diff = $maxValue - $secondMaxValue;
				if($counter % $diff == 0) {
					$level = ($counter - $maxValue) /  $diff + $valuesNo - 1;
				}
			} else {
				$level = -1;
				for($l = 0; $l < count($achievementTypes[$achievementTypeId]['levels']); $l++) {
					if($counter >= $achievementTypes[$achievementTypeId]['levels'][$l]) {
						$level++;
					}
				}
			}

			if(!isset($userBadges[$achievementTypeId])) {
				$userBadges[$achievementTypeId] = -1;
			}

			if($level > $userBadges[$achievementTypeId]) {
				for($i = $userBadges[$achievementTypeId] + 1; $i <= $level; $i++) {
					$rows[] = array('user_id' => $userId,
									'achievement_type_id' => $achievementTypeId,
									'level' => $i);
				}
			}
		} else {
			$rows[] = array('user_id' => $userId,
							'achievement_type_id' => $achievementTypeId,
							'level' => 0);
		}
	}

	$dbw = wfGetDB(DB_MASTER);
	$dbw->insert('achievements_badges', $rows, 'Achievements_AddBadgesIfNeeded');
	$dbw->commit();
}

/**
 * @author: Inez Korczyński
 */
function Achievements_GetCurrentCounters($userId, $achievementTypeIds) {
	$dbw = wfGetDB(DB_MASTER);

	// this query is intentionally perform at master database because it uses SELECT .. FOR UPDATE,
	// which sets the locks on selected rows for later update
	$res = $dbw->select('achievements_counters',
						array('achievement_type_id', 'counter'),
						array('user_id' => $userId, 'achievement_type_id IN ('.join(',', $achievementTypeIds).')'),
						'Achievements_GetCounters',
						array('FOR UPDATE'));

	$counters = array_fill_keys($achievementTypeIds, 0);

	while($row = $dbw->fetchObject($res)) {
		$counters[$row->achievement_type_id] = $row->counter;
	}

	return $counters;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_UpdateCounters($userId, $newCounters /* achievementTypeId => counter */) {
	$rows = array();

	// prepare query data for sql replace statement
	foreach($newCounters as $achievementTypeId => $counter) {
		$rows[] = array('user_id' => $userId,
						'achievement_type_id' => $achievementTypeId,
						'counter' => $counter);
	}

	$dbw = wfGetDB(DB_MASTER);
	$dbw->replace('achievements_counters', null, $rows, 'Achievements_UpdateCounters');
	$dbw->commit();
}