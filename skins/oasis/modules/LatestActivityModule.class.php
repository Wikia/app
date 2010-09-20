<?php
class LatestActivityModule extends Module {

	var $total;
	var $changeList;

	var $wgSingleH1;
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		$maxElements = 3;

		global $wgLang, $wgContentNamespaces, $wgStylePath, $wgMemc, $wgSingleH1;
		$this->total = $wgLang->formatNum(SiteStats::articles());

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
		$this->changeList = $wgMemc->get($mKeyTimes);

		if(empty($this->changeList) && !empty($feedData) && is_array($feedData['results'])) {
			foreach ( $feedData['results'] as $change ) {
				$item = array();
				$item['time_ago'] = wfTimeFormatAgoOnlyRecent($change['timestamp']);
				$item['user_name'] = $change['username'];
				$item['avatar_url'] = AvatarService::getAvatarUrl($item['user_name'], 20);
				$item['user_href'] = $change['user'];
				$item['page_title'] = $change['title'];
				$title = Title::newFromText( $change['title'], $change['ns'] );
				if ( is_object($title) ) {
					$item['page_href'] = Xml::element('a', array('href' => $title->getLocalUrl()), $item['page_title']);
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
