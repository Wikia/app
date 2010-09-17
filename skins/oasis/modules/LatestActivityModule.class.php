<?php
class LatestActivityModule extends Module {

	var $total;
	var $changeList;

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		$maxElements = 3;

		global $wgLang, $wgContentNamespaces, $wgStylePath, $wgMemc;
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

		$this->changeList = array();

		if(!empty($feedData) && is_array($feedData['results'])) {
			foreach ( $feedData['results'] as $change ) {
				$item = array();
				$item['time_ago'] = wfTimeFormatAgoOnlyRecent($change['timestamp']);
				$item['user_name'] = $change['username'];

				$oUser = User::newFromName( $change['username'] );
				if ( ( $oUser instanceof User ) ) {
					$item['avatar_url'] = Masthead::newFromUser($oUser)->getUrl();
					//$item['image_src'] = Masthead::newFromUser($oUser)->getImageTag('20', '20');  // TODO: FIXME
				} else {
					$randomInt = rand(1, 3);
					$item['avatar_url'] = "{$wgStylePath}/oasis/images/generic_avatar{$randomInt}.png";
				}
				$item['user_href'] = $change['user'];
				$item['page_title'] = $change['title'];
				$title = Title::newFromText( $change['title'], $change['ns'] );
				if ( is_object($title) ) {
					$item['page_href'] = Xml::element('a', array('href' => $title->getLocalUrl()), $item['page_title']);
				}
				$this->changeList[] = $item;

			}
		}
		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgMemc;
		$mKey = wfMemcKey('mOasisLatestActivity');
		$wgMemc->delete($mKey);
		return true;
	}

}
