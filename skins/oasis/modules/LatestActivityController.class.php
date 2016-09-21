<?php
class LatestActivityController extends WikiaController {

	public function init() {
		$this->userName = '';
	}

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		$maxElements = 4;

		global $wgLang, $wgContentNamespaces, $wgMemc, $wgUser;
		$this->moduleHeader = wfMsg('oasis-activity-header');
		
		if( empty($this->userName) ) {
			$mKey = wfMemcKey('mOasisLatestActivity');
			$feedData = $wgMemc->get($mKey);
		}
		
		if (empty($feedData)) {
			// data provider
			$includeNamespaces = implode('|', $wgContentNamespaces);
			$parameters = array(
				'type' => 'widget',
				//'tagid' => $id,
				'maxElements' => $maxElements,
				'flags' => array('shortlist'),
				'uselang' => $wgLang->getCode(),
				'includeNamespaces' => $includeNamespaces
			);
			
			$feedProxy = new ActivityFeedAPIProxy($includeNamespaces, $this->userName);
			$feedProvider = new DataFeedProvider($feedProxy, 1, $parameters);
			$feedData = $feedProvider->get($maxElements);
			if( empty($this->userName) ) {
				$wgMemc->set($mKey, $feedData);
			}
		}
		
		// Time strings are slow to calculate, but we still want them to update frequently (60 seconds)
		if( empty($this->userName)) {
			$mKeyTimes = wfMemcKey('mOasisLatestActivity_times', $wgLang->getCode());
			$this->changeList = $wgMemc->get($mKeyTimes, array());
		}
		
		if(empty($this->changeList) && !empty($feedData) && is_array($feedData['results'])) {
			$changeList = array();
			foreach( $feedData['results'] as $change ) {
				$item = array();
				$item['time_ago'] = wfTimeFormatAgoOnlyRecent($change['timestamp']); // TODO: format the timestamp on front-end to allow longer caching in memcache?
				$item['user_name'] = $change['username'];
				$item['avatar_url'] = AvatarService::getAvatarUrl( $item['user_name'], 20 );
				$item['user_profile_url'] = AvatarService::getUrl( $item['user_name'] );
				$item['user_href'] = AvatarService::renderLink( $item['user_name'] );
				$item['page_title'] = $change['title'];
				$item['changetype'] = $change['type'];
				$title = Title::newFromText( $change['title'], $change['ns'] );

				if( !empty($change['articleComment']) && !empty($change['url']) ) {
					$item['page_href'] = Xml::element('a', array('href' => $change['url']), $item['page_title']);
				} else {
					if( is_object($title) ) {
						$item['page_url'] = $title->getLocalURL();
						$item['page_href'] = Xml::element('a', array('href' => $item['page_url']), $item['page_title']);
					}
				}
				
				switch ($change['type']) {
					case 'new':
					case 'edit':
					case 'delete':
						// different formatting for User Profile Pages
						if( !empty( $this->userName ) ) {
							$item['page_href'] = wfMsg("userprofilepage-activity-{$change['type']}", $item['page_href']);
							$item['changemessage'] = $item['time_ago'];
						}
						else {
							// format message (RT #144814)
							$item['changemessage'] = wfMsg("oasis-latest-activity-{$change['type']}-details", $item['user_href'], $item['time_ago']);
						}
						
						$item['changeicon'] = $change['type'];
						break;
					default:
						// show just a timestamp
						$item['changemessage'] = $item['time_ago'];
						break;
				}
				$changeList[] = $item;
			}
			$this->changeList = $changeList;
			if( empty($this->userName) ) {
				$wgMemc->set($mKeyTimes, $this->changeList, 60);
			}
		}

		// Cache the response in CDN and browser
		$this->response->setCacheValidity(600);
		
		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		global $wgMemc, $wgLang;
		$wgMemc->delete(wfMemcKey('mOasisLatestActivity'));
		$wgMemc->delete(wfMemcKey('mOasisLatestActivity_times', $wgLang->getCode()));
		return true;
	}
}
