<?php
class LatestActivityController extends WikiaController {

	protected static $memcKey = 'mOasisLatestActivity2';

	public function executeIndex() {
		wfProfileIn( __METHOD__ );

		$this->changeList = WikiaDataAccess::cache(
			wfMemcKey( self::$memcKey ),
			0,
			function () {
				global $wgContentNamespaces, $wgLang;
				$maxElements = 4;

				$includeNamespaces = implode( '|', $wgContentNamespaces );
				$params = [
					'type' 		=> 'widget',
					'maxElements'		=> $maxElements,
					'flags'		=> ['shortlist'],
					'uselang'		=> $wgLang->getCode(),
					'includeNamespaces'	=> $includeNamespaces
				];

				$feedProxy = new ActivityFeedAPIProxy( $includeNamespaces );
				$feedProvider = new DataFeedProvider( $feedProxy, 1, $params );
				$feedData = $feedProvider->get( $maxElements );

				foreach ( $feedData['results'] as &$item ) {
					$timeAgo = wfTimeFormatAgoOnlyRecent( $item['timestamp'] );
					$userHref = AvatarService::renderLink( $item['username'] );

					// @todo change message so it can be parsed or escaped
					//       blocked by AvatarSerivce::renderLink returning html
					$item['change'] = wfMessage( "oasis-latest-activity-{$item['type']}-details" )
						->params( $userHref, $timeAgo )
						->text();

					if ( !empty( $item['articleComment'] ) ) {
						$title = Title::newFromText( $item['title'], $item['ns'] );

						if ( $title instanceof Title ) {
							$item['url'] = $title->getLocalUrl();
						}
					}

					// VOLDEV-75
					// add in beakpoints after colons and slashes
					// (namespace and subpage separators)
					$item['title'] = htmlspecialchars( $item['title'] );
					$item['title'] = implode( '/<wbr>', explode( '/', $item['title'] ) );
					$item['title'] = implode( ':<wbr>', explode( ':', $item['title'] ) );
				}

				return $feedData['results'];
			}
		);
		
		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete( &$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		WikiaDataAccess::cachePurge( wfMemcKey( self::$memcKey ) );
		return true;
	}
}
