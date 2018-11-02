<?php

class CategoryPage3Hooks {

	const COOKIE_NAME = 'category-page-layout';
	const GLOBAL_PREFERENCE_NAME = 'category-page-layout';

	private static $oldQueryParams = [
		'display',
		'filefrom',
		'fileuntil',
		'page',
		'pagefrom',
		'pageuntil',
		'sort',
		'subcatfrom',
		'subcatuntil',
	];

	/**
	 * @param $categoryInserts
	 * @param $categoryDeletes
	 * @return bool
	 * @throws MWException
	 */
	public static function onAfterCategoriesUpdate( $categoryInserts, $categoryDeletes/*, $title*/ ): bool {
		$categories = $categoryInserts + $categoryDeletes;

		foreach ( array_keys( $categories ) as $categoryTitle ) {
			$title = Title::newFromText( $categoryTitle, NS_CATEGORY );
			CategoryPage3CacheHelper::setTouched( $title );

			$surrogateKey = CategoryPage3CacheHelper::getSurrogateKey( $title );
			// CDN
			Wikia::purgeSurrogateKey( $surrogateKey );
			// icache
			Wikia::purgeSurrogateKey( $surrogateKey, 'mercury' );
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	public static function onArticleFromTitle( $title, &$article ): bool {
		if ( is_null( $title ) || !$title->inNamespace( NS_CATEGORY ) ) {
			return true;
		}

		$layout = static::getLayout( $title, $article->getPage(), $article->getContext() );

		switch ( $layout ) {
			case CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI:
				$article = new CategoryPageMediawiki( $title );
				break;
			case CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION:
				$article = new CategoryExhibitionPage( $title );
				break;
			default:
				$article = new CategoryPage3( $title );
		}

		return true;
	}

	/**
	 * Redirect to the canonical category URL if any of the older
	 * pagination URL params were used.
	 *
	 * @param Title $title
	 * @param $unused
	 * @param OutputPage $output
	 * @param User $user
	 * @param WebRequest $request
	 * @param MediaWiki $mediawiki
	 * @return bool
	 */
	public static function onBeforeInitialize(
		Title $title, $unused, OutputPage $output,
		User $user, WebRequest $request, MediaWiki $mediawiki
	): bool {
		$wikiPage = new WikiPage( $title );

		if ( $title->isRedirect() ) {
			$title = $wikiPage->getRedirectTarget();
		}

		if (
			is_null( $title ) ||
			!$title->inNamespace( NS_CATEGORY ) ||
			static::getLayout( $title, $wikiPage, $output->getContext() ) !== CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3
		) {
			return true;
		}

		$oldParamsUsed = array_intersect( static::$oldQueryParams, array_keys( $request->getQueryValues() ) );

		if ( !empty( $oldParamsUsed ) ) {
			$output->redirect( $title->getFullURL(), '301', 'CanonicalCategoryURL' );
		}

		return true;
	}

	public static function onGetPreferences( $user, &$defaultPreferences ) {
		$preference = [
			'label-message' => 'category-page3-layout-selector-label',
			'section' => 'personal/appearance',
			'type' => 'select'
		];

		$options = [];
		$options[ wfMessage( 'category-page3-layout-selector-category-page3' )->escaped() ] = CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;
		$options[ wfMessage( 'category-page3-layout-selector-mediawiki' )->escaped() ] = CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI;
		$options[ wfMessage( 'category-page3-layout-selector-category-exhibition' )->escaped() ] = CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION;
		$preference['options'] = $options;

		$defaultPreferences[ static::GLOBAL_PREFERENCE_NAME ] = $preference;

		return true;
	}

	public static function onLinkerMakeExternalLink( string $url, string $text, string &$link, array $attribs ): bool {
		global $wgCityId, $wgContLang, $wgFandomBaseDomain, $wgWikiaBaseDomain;

		$host = parse_url( $url, PHP_URL_HOST );
		$host = wfNormalizeHost( $host );

		// External-external links
		if (
			!endsWith( $host, ".${wgFandomBaseDomain}" ) &&
			!endsWith( $host, ".${wgWikiaBaseDomain}" )
		) {
			return true;
		}

		// Not this wiki
		if ( WikiFactory::UrlToID( $host ) !== $wgCityId ) {
			return true;
		}

		$path = parse_url( $url, PHP_URL_PATH );
		$categoryNsText = $wgContLang->getNsText( NS_CATEGORY );

		// Not a category
		if ( strpos( $path, "${categoryNsText}:" ) === false ) {
			return true;
		}

		$queryParams = [];
		parse_str( parse_url( $url, PHP_URL_QUERY ), $queryParams );
		$paramsToHideFromCrawlers = array_merge( static::$oldQueryParams, [ 'from' ] );

		// Not a problem
		if ( empty ( array_intersect( array_keys( $queryParams ), $paramsToHideFromCrawlers ) ) ) {
			return true;
		}

		$attribs['href'] = '#';
		$attribs['rel'] = 'nofollow';
		$attribs['data-category-url-encoded'] = base64_encode( $url );
		$link = Html::rawElement( 'a', $attribs, $text );

		return false;
	}

	public static function onUserGetDefaultOptions( &$defaultOptions ) {
		$defaultOptions[ static::GLOBAL_PREFERENCE_NAME ] = CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;

		return true;
	}

	private static function getLayout( Title $title, WikiPage $wikiPage, IContextSource $context ): string {
		$user = $context->getUser();
		$isAnon = $user->isAnon();

		if ( $isAnon ) {
			return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;
		}

		$cookie = $context->getRequest()->getCookie( static::COOKIE_NAME, '' );

		if ( !empty( $cookie ) ) {
			$layoutFromCookie = static::getLayoutForKey( $title, $wikiPage, $cookie );

			if ( $layoutFromCookie !== null ) {
				return $layoutFromCookie;
			}
		}

		$globalPreference = $user->getGlobalPreference(
			static::GLOBAL_PREFERENCE_NAME,
			CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3
		);

		return static::getLayoutForKey( $title, $wikiPage, $globalPreference );
	}

	private static function getLayoutForKey( Title $title, WikiPage $wikiPage, $key ) {
		if ( $key === CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI ) {
			return CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI;
		} else if (
			$key === CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION &&
			!CategoryExhibitionHooks::isExhibitionDisabledForTitle( $title, $wikiPage )
		) {
			return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION;
		} else if ( $key === CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3 ) {
			return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;
		}

		return null;
	}
}
