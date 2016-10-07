<?php

class FlowTrackingHooks {
	const CREATE_PAGE_DIRECT_URL = 'create-page-direct-url';
	const CREATE_PAGE_CONTRIBUTE_BUTTON = 'create-page-contribute-button';
	const CREATE_PAGE_ARTICLE_REDLINK = 'create-page-article-redlink';
	const CREATE_PAGE_SPECIAL_REDLINK = 'create-page-special-redlink';
	const CREATE_PAGE_UNRECOGNIZED_FLOW = 'create-page-unrecognized';

	public static function onMakeGlobalVariablesScript( &$vars ) {
		$vars[ 'wgFlowTrackingFlows' ] = [
			'CREATE_PAGE_DIRECT_URL' => static::CREATE_PAGE_DIRECT_URL,
			'CREATE_PAGE_CONTRIBUTE_BUTTON' => static::CREATE_PAGE_CONTRIBUTE_BUTTON,
			'CREATE_PAGE_ARTICLE_REDLINK' => static::CREATE_PAGE_ARTICLE_REDLINK,
			'CREATE_PAGE_SPECIAL_REDLINK' => static::CREATE_PAGE_SPECIAL_REDLINK,
			'CREATE_PAGE_UNRECOGNIZED_FLOW' => static::CREATE_PAGE_UNRECOGNIZED_FLOW
		];

		return true;
	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'flow_tracking_create_page_js' );

		return true;
	}

	/**
	 * @param  Page $page The created page object
	 * @param  User $user The user who created the page
	 * @param  string $text Text of the new article
	 * @param  string $summary Edit summary
	 * @param  int $minoredit Minor edit flag
	 * @param  boolean $watchThis Whether or not the user should watch the page
	 * @param  null $sectionAnchor Not used, set to null
	 * @param  int $flags Flags for this page
	 * @param  Revision $revision The newly inserted revision object
	 * @return bool
	 */
	public static function onArticleInsertComplete( Page $page, User $user, $text, $summary, $minoredit,
		$watchThis, $sectionAnchor, &$flags, Revision $revision ) {
		$title = $revision->getTitle();
		if ( $title && $title->inNamespace( NS_MAIN ) ) {
			$request = RequestContext::getMain()->getRequest();
			$headers = $request->getAllHeaders();

			// transforms "a=1&b=2&c=3" into [ 'a' => 1, 'b' => 2, 'c' => 3 ]
			if ( isset( $headers[ 'REFERER' ] ) ) {
				$queryParams = static::getParamsFromUrlQuery( $headers[ 'REFERER' ] );
			} else {
				Wikia\Logger\WikiaLogger::instance()->warning( 'Flow Tracking - Referer header is not set', [
					'useragent' => $headers[ 'USER-AGENT' ]
				] );
				return true;
			}

			Track::event( 'trackingevent', [
				'ga_action' => 'flow-end',
				'editor' => static::getEditor( $request->getValues(), $queryParams ),
				'flowname' => $queryParams[ 'flow' ] ?? static::CREATE_PAGE_UNRECOGNIZED_FLOW,
				'useragent' => $headers[ 'USER-AGENT' ]
			] );
			Track::eventGA( 'flow-tracking', 'flow-end', $queryParams[ 'flow' ] );
		}

		return true;
	}

	public static function getParamsFromUrlQuery( $url ) {
		parse_str( parse_url( $url, PHP_URL_QUERY ), $queryParams );
		return $queryParams;
	}

	private static function getEditor( $requestValues, $queryParams ) {
		$editor = '';

		if ( isset( $queryParams[ 'veaction' ] ) ) {
			$editor = 'visualeditor';
		} elseif ( !empty( $requestValues[ 'RTEMode' ] ) ) {
			$editor = 'rte-' . $requestValues[ 'RTEMode' ];
		} elseif ( !empty( $requestValues[ 'isMediaWikiEditor' ] ) ) {
			$editor = 'sourceedit';
		}
		return $editor;
	}
}
