<?php
class RecentWikiActivityController extends WikiaController {
	public function index() {
		global $wgContentNamespaces, $wgLang;

		Wikia::addAssetsToOutput('//extensions/wikia/RecentWikiActivity/styles/RecentWikiActivity.scss');

		$this->userName = ''; // TODO

		wfProfileIn(__METHOD__);
		$maxElements = 4;

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

		$this->changeList = $feedData['results'];

		wfProfileOut( __METHOD__ );
	}
}
