<?php

class AchAjaxService {

	public static function editPlatinumBadge() {
		global $wgCityId, $wgRequest, $wgSitename, $wgServer, $wgScriptPath, $wgExternalSharedDB;
		wfLoadExtensionMessages('AchievementsII');

		$badge_type_id = $wgRequest->getVal('type_id');
		$ret = array('errors' => null, 'typeId' => $badge_type_id);
		$isSponsored = $wgRequest->getBool( 'is_sponsored' );
		$usernamesToAward = $wgRequest->getArray('award_user');
		$usersToAward = array();
		
		if(is_array($usernamesToAward)) {//Webklit browsers don't send an empty array of inputs in a POST request
			foreach($usernamesToAward as $usernameToAward) {
				if($usernameToAward != '') {
					$user = User::newFromName($usernameToAward);
					if($user && $user->isLoggedIn()) {
						$usersToAward[] = $user;
					} else {
						// FIXME: needs i18n.
						$ret['errors'][] = "User '{$usernameToAward}' does not exist";
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

		//upload Sponsored achievement hover content
		if ( $isSponsored && $wgRequest->getFileName( 'hover_content' ) ) {
			$result = AchImageUploadService::uploadHover( AchConfig::getInstance()->getHoverPictureName( $badge_type_id ) );
			
			if ( empty( $result[ 'success' ] ) ) {
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
					'sponsored' => $isSponsored,
					'badge_tracking_url' => $wgRequest->getText( 'badge_impression_pixel_url' ),
					'hover_tracking_url' => $wgRequest->getText( 'hover_impression_pixel_url' ),
					'click_tracking_url' => $wgRequest->getText( 'badge_redirect_url' )
				),
				array(
					'id' => $badge_type_id,
					'wiki_id' => $wgCityId
				)
			);

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

					if($userToAward->getEmail() != null && !($userToAward->getOption('hidepersonalachievements'))) {
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
			$hoverImage = wfFindFile( AchConfig::getInstance()->getHoverPictureName( $badge_type_id ) );

			// render form
			$badge = array();
			$badge['type_id'] = $badge_type_id;
			$badge['enabled'] = $wgRequest->getBool('status');
			$badge['thumb_url'] = $image->getThumbnail(90)->getUrl()."?".rand();
			$badge['awarded_users'] = AchPlatinumService::getAwardedUserNames($badge_type_id, true);
			$badge[ 'is_sponsored' ] = $isSponsored;
			$badge[ 'badge_tracking_url' ] = $wgRequest->getText( 'badge_impression_pixel_url' );
			$badge[ 'hover_tracking_url' ] = $wgRequest->getText( 'hover_impression_pixel_url' );
			$badge[ 'click_tracking_url' ] = $wgRequest->getText( 'badge_redirect_url' );
			$badge[ 'hover_content_url' ] = ( is_object( $hoverImage ) ) ? wfReplaceImageServer( $hoverImage->getFullUrl() ) . "?" . rand() : null;

			$ret['output'] = AchPlatinumService::getPlatinumForm($badge);
		}


		return '<script type="text/javascript">window.document.responseContent = '.json_encode($ret).';</script>';
	}

	public static function addPlatinumBadge() {
		global $wgCityId, $wgRequest, $wgExternalSharedDB;
		wfLoadExtensionMessages('AchievementsII');

		$ret = array('errors' => null);
		$isSponsored = $wgRequest->getBool( 'is_sponsored' );
		
		// create a badge
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->insert(
			'ach_custom_badges',
			array(
				'wiki_id' => $wgCityId,
				'type' => BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM,
				'sponsored' => $isSponsored,
				'badge_tracking_url' => $wgRequest->getText( 'badge_impression_pixel_url' ),
				'hover_tracking_url' => $wgRequest->getText( 'hover_impression_pixel_url' ),
				'click_tracking_url' => $wgRequest->getText( 'badge_redirect_url' )
			)
		);

		$badge_type_id = $dbw->insertId();

		// upload an image
		if($ret['errors'] == null && $wgRequest->getFileName('wpUploadFile')) {

			ob_start();
			$imageUrl = AchImageUploadService::uploadBadge(AchConfig::getInstance()->getBadgePictureName($badge_type_id), AchConfig::getInstance()->getLevelMsgKeyPart(BADGE_LEVEL_PLATINUM));
			ob_end_clean();

			if(!$imageUrl) {
				$ret['errors'][] = wfMsg('achievements-upload-error');
			}
		}

		//upload Sponsored achievement hover content
		if ( $isSponsored && $wgRequest->getFileName( 'hover_content' ) ) {
			$result = AchImageUploadService::uploadHover( AchConfig::getInstance()->getHoverPictureName( $badge_type_id ) );

			if ( empty( $result[ 'success' ] ) ) {
				$ret['errors'][] = wfMsg('achievements-upload-error');
			}
		}

		if($ret['errors'] == null) {
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
			$hoverImage = wfFindFile( AchConfig::getInstance()->getHoverPictureName( $badge_type_id ) );
			
			// render form
			$badge = array();
			$badge['type_id'] = $badge_type_id;
			$badge['enabled'] = false;
			$badge['thumb_url'] = $image->getThumbnail(90)->getUrl();
			$badge['awarded_users'] = null;
			$badge[ 'is_sponsored' ] = $isSponsored;
			$badge[ 'badge_tracking_url' ] = $wgRequest->getText( 'badge_impression_pixel_url' );
			$badge[ 'hover_tracking_url' ] = $wgRequest->getText( 'hover_impression_pixel_url' );
			$badge[ 'click_tracking_url' ] = $wgRequest->getText( 'badge_redirect_url' );
			$badge[ 'hover_content_url' ] = ( is_object( $hoverImage ) ) ? wfReplaceImageServer( $hoverImage->getFullUrl() ) . "?" . rand() : null;

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

	public static function resetPlatinumBadge() {
		global $wgRequest;
		wfLoadExtensionMessages('AchievementsII');
		$badge_type_id = ( int ) $wgRequest->getVal('type_id');
		$ret = null;
		
		if( !empty( $badge_type_id ) ) {
			$ret = array(
				'typeId' => $badge_type_id,
				'output' => AchPlatinumService::getPlatinumForm( AchPlatinumService::getBadge( $badge_type_id ) )
			);
		}

		return json_encode($ret);
	}
}
