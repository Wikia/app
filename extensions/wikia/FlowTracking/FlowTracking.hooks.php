<?php

class FlowTrackingHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'flow_tracking_js' );

		return true;
	}

	/**
	 * @param  Page     $page          The created page object
	 * @param  User     $user          The user who created the page
	 * @param  string   $text          Text of the new article
	 * @param  string   $summary       Edit summary
	 * @param  int      $minoredit     Minor edit flag
	 * @param  boolean  $watchThis     Whether or not the user should watch the page
	 * @param  null     $sectionAnchor Not used, set to null
	 * @param  int      $flags         Flags for this page
	 * @param  Revision $revision      The newly inserted revision object
	 * @return bool
	 */
	public static function onArticleInsertComplete( Page $page, User $user, $text, $summary, $minoredit,
													$watchThis, $sectionAnchor, &$flags, Revision $revision ) {
		$title = $revision->getTitle();
		if ( $title && $title->inNamespace( NS_MAIN ) ) {
			$params = [];
			$request = RequestContext::getMain()->getRequest();
			$headers = $request->getAllHeaders();

			// transforms "a=1&b=2&c=3" into [ 'a' => 1, 'b' => 2, 'c' => 3 ]
			if ( isset( $headers[ 'REFERER' ] ) ) {
				$params = static::getParamsFromUrlQuery( $headers[ 'REFERER' ] );
			} else {
				Wikia\Logger\WikiaLogger::instance()->warning( 'Flow Tracking - Referer header is not set', [
					'useragent' => $headers[ 'USER-AGENT' ]
				] );
			}
			if ( isset( $params['flow'] ) ) {
				Track::event( 'trackingevent', [
					'ga_action' => 'flow-end',
					'editor' => static::getEditor( $request->getValues(), $params ),
					'flowname' => $params[ 'flow' ],
					'useragent' => $headers[ 'USER-AGENT' ]
				] );
				Track::eventGA( 'flow-tracking', 'flow-end', $params[ 'flow' ] );
			}
		}
		return true;
	}

	public static function getParamsFromUrlQuery( $url ) {
		parse_str( parse_url( $url, PHP_URL_QUERY ), $params );
		return $params;
	}

	private static function getEditor( $values, $params ) {
		$editor = '';

		if ( isset( $params[ 'veaction' ] ) ) {
			$editor = 'visualeditor';
		} elseif ( !empty( $values[ 'RTEMode' ] ) ) {
			$editor = $values[ 'RTEMode' ];
		} elseif ( !empty( $values[ 'isMediaWikiEditor' ] ) ) {
			$editor = 'sourceedit';
		}
		return $editor;
	}
}
