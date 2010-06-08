<?php

class AchAjaxService {

	public static function editPlatinumBadge() {
		global $wgCityId, $wgRequest, $wgSitename, $wgServer, $wgScriptPath, $wgExternalSharedDB;
		wfLoadExtensionMessages('AchievementsII');

		$badge_type_id = $wgRequest->getVal('type_id');

		$ret = array('errors' => null, 'typeId' => $badge_type_id);

		$usernamesToAward = $wgRequest->getArray('award_user');
		$usersToAward = array();
		
		if(is_array($usernamesToAward)) {//Webklit browsers don't send an empty array of inputs in a POST request
			foreach($usernamesToAward as $usernameToAward) {
				if($usernameToAward != '') {
					$user = User::newFromName($usernameToAward);
					if($user && $user->isLoggedIn()) {
						$usersToAward[] = $user;
					} else {
						$ret['errors'][] = "User '{$usernameToAward}' does not exists";
					}
				}
			}
		}

		// upload an image
		if($ret['errors'] == null && $wgRequest->getFileName('wpUploadFile')) {

			ob_start();
			$imageUrl = AchImageUploadService::uploadBadge(AchConfig::getInstance()->getBadgePictureName($badge_type_id), AchConfig::getInstance()->getLevelMsgKeyPart(BADGE_LEVEL_PLATINUM));
			ob_end_clean();
			if(!$imageUrl) {
				$ret['errors'][] = wfMsg('achievements-upload-error');
			}
		}

		// update a badge
		if($ret['errors'] == null) {
			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
			$dbw->update(
				'ach_custom_badges',
				array(
					'enabled' => $wgRequest->getBool('status'),
					'show_recents' => $wgRequest->getBool('show_recents')
				),
				array(
					'id' => $badge_type_id,
					'wiki_id' => $wgCityId));

			// edit/create MW articles
			$badgeNameKey = AchConfig::getInstance()->getBadgeNameKey($badge_type_id);
			$messagesToEdit = array();
			$messagesToEdit[$badgeNameKey] = 'badge_name';
			$messagesToEdit[AchConfig::getInstance()->getBadgeToGetKey($badge_type_id)] = 'how_to';
			$messagesToEdit[AchConfig::getInstance()->getBadgeDescKey($badge_type_id)] = 'awarded_for';

			foreach($messagesToEdit as $messageKey => $valueKey) {
				$value = $wgRequest->getVal($valueKey);
				if($value && wfMsgForContent($messageKey) != $value) {
					$article = new Article(Title::newFromText($messageKey, NS_MEDIAWIKI));
					$article->doEdit($value, '');
				}
			}

			// award users
			if(count($usersToAward) > 0) {
				foreach($usersToAward as $userToAward) {
					$awardingService = new AchAwardingService();
					$awardingService->awardCustomNotInTrackBadge($userToAward, $badge_type_id);

					if($userToAward->getEmail() != null) {
						$bodyParams = array(
							htmlspecialchars($userToAward->getName()),
							wfMsgHtml($badgeNameKey),
							"{$wgServer}{$wgScriptPath}",
							htmlspecialchars($wgSitename),
							$userToAward->getUserPage()->getFullURL()
						);

						$userToAward->sendMail(
							wfMsg('achievements-community-platinum-awarded-email-subject'),
							wfMsg('achievements-community-platinum-awarded-email-body-text', $bodyParams),
							null, //from
							null, //replyto
							'CommunityPlatinumBadgesAwardNotification',
							wfMsg('achievements-community-platinum-awarded-email-body-html', $bodyParams)
						);
					}
				}
			}

			$dbw->commit();

			$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($badge_type_id));

			// render form
			$badge = array();
			$badge['type_id'] = $badge_type_id;
			$badge['enabled'] = $wgRequest->getBool('status');
			$badge['show_recents'] = $wgRequest->getBool('show_recents');
			$badge['thumb_url'] = $image->getThumbnail(90)->getUrl()."?".rand();
			$badge['awarded_users'] = AchPlatinumService::getAwardedUserNames($badge_type_id, true);

			$ret['output'] = AchPlatinumService::getPlatinumForm($badge);
		}


		return '<script type="text/javascript">window.document.responseContent = '.json_encode($ret).';</script>';
	}

	public static function addPlatinumBadge() {
		global $wgCityId, $wgRequest, $wgExternalSharedDB;
		wfLoadExtensionMessages('AchievementsII');

		$ret = array('errors' => null);

		// create a badge
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->insert(
			'ach_custom_badges',
			array('wiki_id' => $wgCityId, 'type' => BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM));

		$badge_type_id = $dbw->insertId();

		// upload an image
		ob_start();
		$imageUrl = AchImageUploadService::uploadBadge(AchConfig::getInstance()->getBadgePictureName($badge_type_id), AchConfig::getInstance()->getLevelMsgKeyPart(BADGE_LEVEL_PLATINUM));
		ob_end_clean();

		if(!$imageUrl) {
			$ret['errors'][] = wfMsg('achievements-upload-error');
		} else {
			// create MW articles
			$messagesToEdit = array();
			$messagesToEdit[AchConfig::getInstance()->getBadgeNameKey($badge_type_id)] = 'badge_name';
			$messagesToEdit[AchConfig::getInstance()->getBadgeToGetKey($badge_type_id)] = 'how_to';
			$messagesToEdit[AchConfig::getInstance()->getBadgeDescKey($badge_type_id)] = 'awarded_for';

			foreach($messagesToEdit as $messageKey => $valueKey) {
				$value = $wgRequest->getVal($valueKey);
				if($value && wfMsgForContent($messageKey) != $value) {
					$article = new Article(Title::newFromText($messageKey, NS_MEDIAWIKI));
					$article->doEdit($value, '');
				}
			}

			$dbw->commit();

			$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($badge_type_id));

			// render form
			$badge = array();
			$badge['type_id'] = $badge_type_id;
			$badge['enabled'] = false;
			$badge['show_recents'] = false;
			$badge['thumb_url'] = $image->getThumbnail(90)->getUrl();
			$badge['awarded_users'] = null;

			$ret['output'] = AchPlatinumService::getPlatinumForm($badge);
		}

		return '<script type="text/javascript">window.document.responseContent = '.json_encode($ret).';</script>';
	}

	public function uploadBadgeImage() {
		global $wgRequest, $wgUser;
		wfLoadExtensionMessages('AchievementsII');

		$badge_type_id = $wgRequest->getVal('type_id');
		$lap = ($wgRequest->getVal('lap') != '') ? $wgRequest->getVal('lap') : null;
		$level = $wgRequest->getVal('level');

		$imageUrl = AchImageUploadService::uploadBadge(AchConfig::getInstance()->getBadgePictureName($badge_type_id, $lap), AchConfig::getInstance()->getLevelMsgKeyPart($level));

		$ret = array();

		if(!$imageUrl)
			$ret['error'] = wfMsg('achievements-upload-error');
		else {
			$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($badge_type_id, $lap));
			$ret['output'] = $image->getThumbnail(90)->getUrl();
		}
		return '<script type="text/javascript">window.document.responseContent = '.json_encode($ret).';</script>';
	}

	public static function resetBadge() {
		global $wgRequest, $wgUser;
		wfLoadExtensionMessages('AchievementsII');

		if(!$wgUser->isAllowed('editinterface')) {
			return false;
		}

		$badge_type_id = $wgRequest->getVal('type_id');
		$lap = ($wgRequest->getVal('lap') != '') ? $wgRequest->getVal('lap') : null;
		$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($badge_type_id, $lap));

		if($image) {
			$image->delete('');
		}

		$badge = new AchBadge($badge_type_id, $lap);

		$ret = array('output' => $badge->getPictureUrl(90, true), 'message' => wfMsg('achievements-reverted'));
		return json_encode($ret);
	}
}
