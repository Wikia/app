<?php
define('ACHIEVEMENT_EDIT_ARTICLE', 1);
define('ACHIEVEMENT_NEW_ARTICLE', 2);
define('ACHIEVEMENT_IMAGE_ADDED_TO_ARTICLE', 3);
define('ACHIEVEMENT_VIDEO_ADDED_TO_ARTICLE', 4);
define('ACHIEVEMENT_CATEGORY_ADDED_TO_ARTICLE', 5);

$wgExtensionFunctions[] = 'Achievements_Setup';

/**
 * @author: Inez Korczyński
 */
function Achievements_Setup() {
  global $wgHooks, $achievementTypeLevels;
  $wgHooks['ArticleSaveComplete'][] = 'Achievements_ArticleSaveComplete';

  $achievementTypeLevels = array();

  // be very careful with this array editing
  $achievementTypeLevels[ACHIEVEMENT_EDIT_ARTICLE] =				array(1, 5, 10, 25, 50, 100, 200);
  $achievementTypeLevels[ACHIEVEMENT_NEW_ARTICLE] =					array(1, 5, 10, 20, 40);
  $achievementTypeLevels[ACHIEVEMENT_IMAGE_ADDED_TO_ARTICLE] =		array(1, 5, 10, 20, 40);
  $achievementTypeLevels[ACHIEVEMENT_VIDEO_ADDED_TO_ARTICLE] =		array(1, 5, 10, 20, 40);
  $achievementTypeLevels[ACHIEVEMENT_CATEGORY_ADDED_TO_ARTICLE] =	array(1, 5, 10, 20, 40);
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

  $achievementCountersToIncrease[ACHIEVEMENT_EDIT_ARTICLE] = 1;

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
  global $achievementTypeLevels;

  $rows = array();

  foreach($counters as $achievementTypeId => $counter) {
    $level = array_search($counter, $achievementTypeLevels[$achievementTypeId]);

    if(!$level) {
      $valuesNo = count($achievementTypeLevels[$achievementTypeId]);
      $maxValue = $achievementTypeLevels[$achievementTypeId][$valuesNo-1];
      $secondMaxValue = $achievementTypeLevels[$achievementTypeId][$valuesNo-2];
      if($counter > $maxValue) {
        $diff = $maxValue - $secondMaxValue;
        if($counter % $diff == 0) {
          $level = ($counter - $maxValue) /  $diff + $valuesNo - 1;
        }
      }
    }

    if($level) {
	    $rows[] = array('user_id' => $userId,
	            'achievement_type_id' => $achievementTypeId,
	            'level' => $level);
    }
  }

  $dbw = wfGetDB(DB_MASTER);
  $dbw->insert('achievements_badges', $rows, 'Achievements_AddBadgesIfNeeded');
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