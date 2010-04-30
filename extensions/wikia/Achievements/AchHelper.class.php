<?php
class AchHelper {

	public static function getBadgeName($type, $lap) {
		return wfMsg(AchHelper::getBadgeMessageName($type, $lap));
	}

	public static function getBadgeMessageName($type, $lap) {
		if($lap === null) {
			return 'achievements-badge-name-'.AchStatic::$mBadgeNames[$type];
		} else {
			if($lap >= count(AchStatic::$mInTrackConfig[$type])) {
				return 'achievements-badge-name-'.AchStatic::$mBadgeNames[$type].'-'.(count(AchStatic::$mInTrackConfig[$type])-1);
			} else {
				return 'achievements-badge-name-'.AchStatic::$mBadgeNames[$type].'-'.$lap;
			}
		}
	}

	public static function getGivenFor($type, $lap, $hover = false) {
		if($hover) {
			$prefix = 'achievements-badge-hover-desc-';
		} else {
			$prefix = 'achievements-badge-desc-';
		}
		return wfMsgExt($prefix.AchStatic::$mBadgeNames[$type], array('parsemag'), number_format(AchHelper::getNeededEventsFor($type, $lap)));
	}

	public static function getYourGivenFor($type, $lap) {
		return wfMsgExt('achievements-badge-your-desc-'.AchStatic::$mBadgeNames[$type], array('parsemag'), number_format(AchHelper::getNeededEventsFor($type, $lap)));
	}

	public static function getNeededEventsFor($type, $lap) {
		if($lap !== null) {
			$lapsCount = count(AchStatic::$mInTrackConfig[$type]);
			if($lap >= $lapsCount) {
				$max = AchStatic::$mInTrackConfig[$type][$lapsCount-1]['events'];
				$events = ($lap - $lapsCount + 2) * $max;
			} else {
				$events = AchStatic::$mInTrackConfig[$type][$lap]['events'];
			}
		} else {
			$events = null;
		}
		return $events;
	}

	public static function getBadgeUrl($type, $lap, $width, $forceOriginal = false) {
		global $wgExtensionsPath;

		if($lap === null) {
			$postfix = '';
		} else if($lap >= count(AchStatic::$mInTrackConfig[$type])) {
			$postfix = '-'.(count(AchStatic::$mInTrackConfig[$type])-1);
		} else {
			$postfix = '-'.$lap;
		}

		if(!$forceOriginal) {
			$image = wfFindFile('badge-'.AchStatic::$mBadgeNames[$type].$postfix.'.png');

			if($image) {
				$thumb = $image->getThumbnail($width);
				return $thumb->getUrl();
			}
		}

		return "{$wgExtensionsPath}/wikia/Achievements/images/badges/".AchStatic::$mBadgeNames[$type]."{$postfix}-128px.png";
	}

	/**
	 * get achievement score for specified user
	 *
	 * @author Marooned
	 */
	public static function getScoreForUser($userId) {
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);
		$score = $dbr->selectField('achievements_counters', 'score', array('user_id' => $userId), __METHOD__);

		wfProfileOut(__METHOD__);
		return $score === false ? 0 : $score;
	}
}