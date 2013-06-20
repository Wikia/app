<?php

class AchPlatinumService {

	public static function getAwardedUserNames($badge_type_id, $master = false) {
		wfProfileIn(__METHOD__);

		$userNames = array();

		$db = wfGetDB($master ? DB_MASTER : DB_SLAVE);
		$res = $db->select(
			'ach_user_badges',
			array('user_id'),
			array('badge_type_id' => $badge_type_id),
			__METHOD__,
			array('ORDER BY' => 'date, user_id'));

		while($row = $db->fetchObject($res)) {
			$user = User::newFromId($row->user_id);
			if($user && $user->isLoggedIn()) {
				$userNames[] = $user->getName();
			}
		}

		wfProfileOut(__METHOD__);
		return $userNames;
	}

	public static function getPlatinumForm($badge) {
		wfProfileIn(__METHOD__);

		$template = new EasyTemplate(dirname(__FILE__).'/../templates');
		$template->set_vars($badge);
		$out = $template->render('PlatinumForm');

		wfProfileOut(__METHOD__);
		return $out;
	}

	public static function getList() {
		wfProfileIn(__METHOD__);

		$badges = array();

		$where = array('type' => BADGE_TYPE_NOTINTRACKCOMMUNITYPLATINUM);
		$dbr = wfGetDB(DB_SLAVE);

		$res = $dbr->select(
			'ach_custom_badges',
			array('id', 'enabled', 'sponsored', 'badge_tracking_url', 'hover_tracking_url', 'click_tracking_url'),
			$where,
			__METHOD__,
			array('ORDER BY' => 'id DESC'));

		while($row = $dbr->fetchObject($res)) {
			$badge = array();

			$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($row->id));

			if($image) {
				$hoverImage = wfFindFile( AchConfig::getInstance()->getHoverPictureName( $row->id ) );

				$badge['type_id'] = $row->id;
				$badge['enabled'] = $row->enabled;
				$badge['thumb_url'] = $image->createThumb( 90 );
				$badge['awarded_users'] = AchPlatinumService::getAwardedUserNames($row->id);
				$badge[ 'is_sponsored' ] = $row->sponsored;
				$badge[ 'badge_tracking_url' ] = $row->badge_tracking_url;
				$badge[ 'hover_tracking_url' ] = $row->hover_tracking_url;
				$badge[ 'click_tracking_url' ] = $row->click_tracking_url;
				$badge[ 'hover_content_url' ] = ( is_object( $hoverImage ) ) ? wfReplaceImageServer( $hoverImage->getFullUrl() ) : null;

				$badges[] = $badge;
			}
		}

		wfProfileOut(__METHOD__);
		return $badges;
	}

	public static function getBadge( $badgeTypeId ) {
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);

		$res = $dbr->select(
			'ach_custom_badges',
			array('id', 'enabled', 'sponsored', 'badge_tracking_url', 'hover_tracking_url', 'click_tracking_url'),
			array('id' => $badgeTypeId ),
			__METHOD__
		);

		if($row = $dbr->fetchObject($res)) {
			$badge = array();

			$image = wfFindFile(AchConfig::getInstance()->getBadgePictureName($row->id));

			if($image) {
				$hoverImage = wfFindFile( AchConfig::getInstance()->getHoverPictureName( $row->id ) );

				$badge['type_id'] = $row->id;
				$badge['enabled'] = $row->enabled;
				$badge['thumb_url'] = $image->createThumb( 90 );
				$badge['awarded_users'] = AchPlatinumService::getAwardedUserNames($row->id);
				$badge[ 'is_sponsored' ] = $row->sponsored;
				$badge[ 'badge_tracking_url' ] = $row->badge_tracking_url;
				$badge[ 'hover_tracking_url' ] = $row->hover_tracking_url;
				$badge[ 'click_tracking_url' ] = $row->click_tracking_url;
				$badge[ 'hover_content_url' ] = ( is_object( $hoverImage ) ) ? wfReplaceImageServer( $hoverImage->getFullUrl() ) : null;

				wfProfileOut(__METHOD__);
				return $badge;
			}
		}

		wfProfileOut(__METHOD__);
		return false;
	}
}
