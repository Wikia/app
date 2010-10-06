<?php
class LatestActivityModule extends Module {

	var $changeList;

	var $wgSingleH1;
	var $wgBlankImgUrl;
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		$maxElements = 4;

		global $wgLang, $wgContentNamespaces, $wgStylePath, $wgMemc, $wgSingleH1;

		wfLoadExtensionMessages('MyHome');

		$mKey = wfMemcKey('mOasisLatestActivity');
		$feedData = $wgMemc->get($mKey);
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

			$feedProxy = new ActivityFeedAPIProxy($includeNamespaces);
			$feedProvider = new DataFeedProvider($feedProxy, 1, $parameters);
			$feedData = $feedProvider->get($maxElements);
			$wgMemc->set($mKey, $feedData);
		}

		// Time strings are slow to calculate, but we still want them to update frequently (60 seconds)
		$mKeyTimes = wfMemcKey('mOasisLatestActivity_times');
		$this->changeList = $wgMemc->get($mKeyTimes, array());

		if(empty($this->changeList) && !empty($feedData) && is_array($feedData['results'])) {
			foreach ( $feedData['results'] as $change ) {
				$item = array();
				$item['time_ago'] = wfTimeFormatAgoOnlyRecent($change['timestamp']);
				$item['user_name'] = $change['username'];
				$item['avatar_url'] = AvatarService::getAvatarUrl($item['user_name'], 20);
				$item['user_href'] = $change['user'];
				$item['page_title'] = $change['title'];
				$item['changetype'] = $change['type'];
				$title = Title::newFromText( $change['title'], $change['ns'] );
				if ( is_object($title) ) {
					$item['page_href'] = Xml::element('a', array('href' => $title->getLocalUrl()), $item['page_title']);
				}
				switch ($change['type']) {
					case 'new':
						$item['changetype'] = wfMsg("oasis-latest-activity-new");
						$item['changeicon'] = 'new';
						break;
					case 'edit':
						$item['changetype'] = wfMsg("oasis-latest-activity-edit");
						$item['changeicon'] = 'edit';
						break;
					case 'delete':
						$item['changetype'] = wfMsg("oasis-latest-activity-delete");
						$item['changeicon'] = 'delete';
						break;
					default:
						$item['changetype'] = '';
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
		global $wgMemc;
		$wgMemc->delete(wfMemcKey('mOasisLatestActivity'));
		$wgMemc->delete(wfMemcKey('mOasisLatestActivity_times'));
		return true;
	}

}
