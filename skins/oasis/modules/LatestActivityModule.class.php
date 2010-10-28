<?php
class LatestActivityModule extends Module {

	var $changeList;

	var $wgSingleH1;
	var $wgBlankImgUrl;
	var $moduleHeader;
	var $userName = '';

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		$maxElements = 4;

		global $wgLang, $wgContentNamespaces, $wgStylePath, $wgMemc, $wgSingleH1, $wgOut, $wgTitle, $wgEnableUserProfilePagesExt;
		//$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/LatestActivity.js"></script>');
		wfLoadExtensionMessages('MyHome');

		$this->moduleHeader = wfMsg('oasis-activity-header');

		if( !empty( $wgEnableUserProfilePagesExt ) && in_array($wgTitle->getNamespace(), array(NS_USER, NS_USER_TALK)) ) {
			$user = UserProfilePageHelper::getExistingUserFromTitle( $wgTitle );
			if( !empty( $user ) ) {
				$this->userName = $user->getName();
				$this->moduleHeader = wfMsg('userprofilepage-recent-activity-title', array( $this->userName ));
			}
		}

		$mKey = wfMemcKey('mOasisLatestActivity', $wgLang->getCode(), $this->userName);
		//$feedData = $wgMemc->get($mKey);
		if (empty($feedData)) {

			// data provider
			$includeNamespaces = implode('|', $wgContentNamespaces);
			$parameters = array(
					'type' => 'widget',
					//			'tagid' => $id,
					'maxElements' => $maxElements,
					'flags' => array('shortlist'),
					'uselang' => $wgLang->getCode(),
					'includeNamespaces' => $includeNamespaces
					);

			$feedProxy = new ActivityFeedAPIProxy($includeNamespaces, $this->userName);
			$feedProvider = new DataFeedProvider($feedProxy, 1, $parameters);
			$feedData = $feedProvider->get($maxElements);
			$wgMemc->set($mKey, $feedData);
		}

		// Time strings are slow to calculate, but we still want them to update frequently (60 seconds)
		$mKeyTimes = wfMemcKey('mOasisLatestActivity_times', $wgLang->getCode());
		$this->changeList = $wgMemc->get($mKeyTimes, array());

		if(empty($this->changeList) && !empty($feedData) && is_array($feedData['results'])) {
			foreach ( $feedData['results'] as $change ) {
				$item = array();
				$item['time_ago'] = wfTimeFormatAgoOnlyRecent($change['timestamp']);
				$item['user_name'] = $change['username'];
				$item['avatar_url'] = AvatarService::getAvatarUrl($item['user_name'], 20);
				$item['user_href'] = AvatarService::renderLink($item['user_name']);
				$item['page_title'] = $change['title'];
				$item['changetype'] = $change['type'];
				$title = Title::newFromText( $change['title'], $change['ns'] );
				if ( is_object($title) ) {
					$item['page_href'] = Xml::element('a', array('href' => $title->getLocalUrl()), $item['page_title']);
				}
				switch ($change['type']) {
					case 'new':
						if( empty( $this->userName ) ) {
							$item['changemessage'] = wfMsg("oasis-latest-activity-new", $item['user_href'], $item['page_href']);
						}
						else {
							$item['changemessage'] = wfMsg("userprofilepage-activity-new", $item['page_href']);
						}
						$item['changeicon'] = 'new';
						break;
					case 'edit':
						if( empty( $this->userName ) ) {
							$item['changemessage'] = wfMsg("oasis-latest-activity-edit", $item['user_href'], $item['page_href']);
						}
						else {
							$item['changemessage'] = wfMsg("userprofilepage-activity-edit", $item['page_href']);
						}
						$item['changeicon'] = 'edit';
						break;
					case 'delete':
						if( empty( $this->userName ) ) {
							$item['changemessage'] = wfMsg("oasis-latest-activity-delete", $item['user_href'], $item['page_href']);
						}
						else {
							$item['changemessage'] = wfMsg("userprofilepage-activity-delete", $item['page_href']);
						}
						$item['changeicon'] = 'delete';
						break;
					default:
						$item['changemessage'] = '';
						break;
				}
				$this->changeList[] = $item;
			}
			$wgMemc->set($mKeyTimes, $this->changeList, 60);
		}
		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgMemc, $wgLang;
		$wgMemc->delete(wfMemcKey('mOasisLatestActivity', $wgLang->getCode()));
		$wgMemc->delete(wfMemcKey('mOasisLatestActivity_times', $wgLang->getCode()));
		return true;
	}
}
