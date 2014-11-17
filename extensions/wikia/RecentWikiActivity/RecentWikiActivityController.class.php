<?php
class RecentWikiActivityController extends WikiaController {
	protected static $memcKey = 'RecentWikiActivityFeed';

	public function index() {

		wfProfileIn(__METHOD__);

		Wikia::addAssetsToOutput('recent_wiki_activity_scss');

		$this->changeList = WikiaDataAccess::cache(
			wfMemcKey( self::$memcKey ),
			0,
			function() {
				global $wgContentNamespaces, $wgLang;
				$maxElements = 4;

				$includeNamespaces = implode('|', $wgContentNamespaces);
				$parameters = array(
					'type' => 'widget',
					'maxElements' => $maxElements,
					'flags' => array('shortlist'),
					'uselang' => $wgLang->getCode(),
					'includeNamespaces' => $includeNamespaces
				);

				$feedProxy = new ActivityFeedAPIProxy($includeNamespaces, $this->userName);
				$feedProvider = new DataFeedProvider($feedProxy, 1, $parameters);
				$feedData = $feedProvider->get($maxElements);

				foreach ( $feedData['results'] as &$result ) {
					if ( !empty( $result['articleComment'] ) ) {
						$title = Title::newFromText( $result['title'], $result['ns'] );
						if ( $title instanceof Title ) {
							$result['url'] = $title->getLocalURL();
						}
					}
				}

				return $feedData['results'];
			}
		);

		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete(&$article, &$user, $text, $summary,
		  $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		WikiaDataAccess::cachePurge( wfMemcKey( self::$memcKey ) );
		return true;
	}
}
