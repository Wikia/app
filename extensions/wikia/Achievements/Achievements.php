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
	global $wgTitle, $achievementTypes, $wgExtensionsPath;

	wfLoadExtensionMessages('Achievements');

	if(empty($wgTitle) || $wgTitle->getNamespace() != NS_USER) {
		return true;
	}

	$user = User::newFromName($wgTitle->getText());

	if(empty($user) || !$user->isLoggedIn()) {
		return true;
	}

	$userBadges = Achievements_GetUserTopBadges($user->getID());
	$userCounters = Achievements_GetUserCounters($user->getID());

	$badgesDisplay = '';

	foreach($achievementTypes as $achievementTypeId => $achievement) {
		$text = '<big><b>'.wfMsg('achievement-'.$achievement['name'].'-name').'</b></big>';

		if(!isset($userBadges[$achievementTypeId])) {
			$src = $wgExtensionsPath . '/wikia/Achievements/Images/'.$achievement['name'].'/'.$achievement['name'].'-bw.jpg';
			$text .= wfMsg('achievement-'.$achievement['name'].'-info');
		} else {
			$src = $wgExtensionsPath . '/wikia/Achievements/Images/'.$achievement['name'].'/'.$achievement['name'].($userBadges[$achievementTypeId] > 4 ? 'x' : $userBadges[$achievementTypeId] + 1).'.jpg';
			$text .= '<strong>' . wfMsg('achievement-level', $userBadges[$achievementTypeId] + 1) . '</strong>';
			$text .= wfMsg('achievement-'.$achievement['name'].'-summary', $userCounters[$achievementTypeId]);

			if(isset($achievement['levels'][$userBadges[$achievementTypeId] + 1])) {
				$next = $achievement['levels'][$userBadges[$achievementTypeId] + 1];
			} else {
				$valuesNo = count($achievement['levels']);
				$maxValue = $achievement['levels'][$valuesNo-1];
				$secondMaxValue = $achievement['levels'][$valuesNo-2];
				$diff = $maxValue - $secondMaxValue;
				$next = $diff * ($userBadges[$achievementTypeId] + 2);
			}

			$text .= '<em>'.wfMsg('achievement-'.$achievement['name'].'-next', $next).'</em>';
		}

		$badgesDisplay .= <<<EOT
		<div>
			<img width="150" height="150" src="{$src}">
			<span>{$text}</span>
		</div>
EOT;
	}

	$achievementsDisplay = <<<EOT
<style>
#achievements-info {
	float: right;
	width: 200px;
	line-height: 3.5em;
	text-align: center;
	padding-top: 7px;
}
#achievements-badges {
	margin-right: 210px;
}
#achievements-badges div {
	display: inline-block;
	width: 170px;
	text-align: center;
	vertical-align: top;
	margin-right: 20px;
}
#achievements-badges span {
	display: block;
	margin-top: 10px;
	margin-bottom: 25px;
}
#achievements-badges big,
#achievements-badges strong,
#achievements-badges em {
	display: block;
}
</style>

<div id="achievements" class="clearfix">
	<div id="achievements-info"><span style="font-size: 15pt; font-weight: bold; margin-right: 3px;">Danny</span> has earned <br/> <span style="font-size: 45pt; font-weight: bold; color: green;">10</span> badges</div>
	<div id="achievements-badges">$badgesDisplay</div>
</div>
EOT;

	$templateEngine->data['bodytext'] = $achievementsDisplay . $templateEngine->data['bodytext'];

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
			            'Achievements_Display');

	while($row = $dbr->fetchObject($res)) {
		$userBadges[$row->achievement_type_id] = $row->level;
	}

	return $userBadges;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_ArticleSaveComplete(&$article, &$user, $text, $summary, &$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
  if(!$user->isLoggedIn()) {
    return true;
  }

  // determine for which achievement counters should be increased and how much

  $achievementCountersToIncrease = array();

  if($status instanceof Status) {
    if($status->ok == true && count($status->errors) == 0) {

      // new article && edit article
      if($status->value['new'] == true) {
        $achievementCountersToIncrease[ACHIEVEMENT_NEW_ARTICLE] = 1;
      } else {
        $achievementCountersToIncrease[ACHIEVEMENT_EDIT_ARTICLE] = 1;
      }

      // images inserts && video inserts
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

  }

  return true;
}

/**
 * @author: Inez Korczyński
 */
function Achievements_AddBadgesIfNeeded($userId, $counters /* achievementTypeId => counter */) {
  global $achievementTypes;

  $rows = array();

  foreach($counters as $achievementTypeId => $counter) {
    $level = array_search($counter, $achievementTypes[$achievementTypeId]['levels']);

    if($level === false) {
      $valuesNo = count($achievementTypes[$achievementTypeId]['levels']);
      $maxValue = $achievementTypes[$achievementTypeId]['levels'][$valuesNo-1];
      $secondMaxValue = $achievementTypes[$achievementTypeId]['levels'][$valuesNo-2];
      if($counter > $maxValue) {
        $diff = $maxValue - $secondMaxValue;
        if($counter % $diff == 0) {
          $level = ($counter - $maxValue) /  $diff + $valuesNo - 1;
        }
      }
    }

    if($level !== false) {
	    $rows[] = array('user_id' => $userId,
			            'achievement_type_id' => $achievementTypeId,
			            'level' => $level);
    }
  }

  $dbw = wfGetDB(DB_MASTER);
  $o = $dbw->insert('achievements_badges', $rows, 'Achievements_AddBadgesIfNeeded');
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
}