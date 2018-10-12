<?php

class CategoryPage3Hooks {

	const COOKIE_NAME = 'category-page-layout';

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
	 * @param $title
	 * @return bool
	 * @throws MWException
	 */
	static public function onAfterCategoriesUpdate( $categoryInserts, $categoryDeletes, $title ): bool {
		$categories = $categoryInserts + $categoryDeletes;

		foreach ( array_keys( $categories ) as $categoryTitle ) {
			$title = Title::newFromText( $categoryTitle, NS_CATEGORY );

			CategoryPage3CacheHelper::setTouched( $title );
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onArticleFromTitle( $title, &$article ): bool {
		if ( $title->isRedirect() ) {
			$title = $article->getRedirectTarget();
		}

		if ( is_null( $title ) || !$title->inNamespace( NS_CATEGORY ) ) {
			return true;
		}

		$request = $article->getContext()->getRequest();
		$cookie = $request->getCookie( self::COOKIE_NAME, '' );

		if ( !empty( $cookie ) ) {
			switch ( $cookie ) {
				case CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI:
					$article = new CategoryPageMediawiki( $title );
					break;
				case CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION:
					if ( !CategoryExhibitionHooks::isExhibitionDisabledForTitle( $title, $article ) ) {
						$article = new CategoryExhibitionPage( $title );
					} else {
						$article = new CategoryPage3( $title );
					}
					break;
				default:
					$article = new CategoryPage3( $title );
			}
		} else {
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
	static public function onBeforeInitialize(
		Title $title, $unused, OutputPage $output,
		User $user, WebRequest $request, MediaWiki $mediawiki
	): bool {
		if (
			!$title->inNamespace( NS_CATEGORY ) ||
			// TODO check the current layout
			$user->isLoggedIn()
		) {
			return true;
		}

		$oldParamsUsed = array_intersect( static::$oldQueryParams, array_keys( $request->getQueryValues() ) );
		if ( !empty( $oldParamsUsed ) ) {
			if ( $title->isRedirect() ) {
				$canonicalCategoryURL = $output->getWikiPage()->getRedirectTarget()->getFullURL();
			} else {
				$canonicalCategoryURL = $title->getFullURL();
			}
			$output->redirect( $canonicalCategoryURL, '301', 'CanonicalCategoryURL' );
		}

		return true;
	}
}
