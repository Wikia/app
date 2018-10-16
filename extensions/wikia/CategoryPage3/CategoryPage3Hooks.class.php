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

		$layout = static::getLayout( $title, $article );

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
	static public function onBeforeInitialize(
		Title $title, $unused, OutputPage $output,
		User $user, WebRequest $request, MediaWiki $mediawiki
	): bool {
		$article = Article::newFromTitle( $title, $output->getContext() );

		if ( $title->isRedirect() ) {
			$title = $article->getRedirectTarget();
		}

		if (
			is_null( $title ) ||
			!$title->inNamespace( NS_CATEGORY ) ||
			static::getLayout( $title, $article ) !== CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3
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

	static public function onUserGetDefaultOptions( &$defaultOptions ) {
		$defaultOptions[ static::GLOBAL_PREFERENCE_NAME ] = CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;

		return true;
	}

	static private function getLayout( Title $title, Article $article ): string {
		$context = $article->getContext();
		$user = $context->getUser();
		$isAnon = $user->isAnon();

		if ( $isAnon ) {
			return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;
		}

		$cookie = $context->getRequest()->getCookie( static::COOKIE_NAME, '' );

		if ( !empty( $cookie ) ) {
			$layoutFromCookie = static::getLayoutForKey( $title, $article, $cookie );

			if ( $layoutFromCookie !== null ) {
				return $layoutFromCookie;
			}
		}

		$globalPreference = $user->getGlobalPreference(
			static::GLOBAL_PREFERENCE_NAME,
			CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3
		);

		return static::getLayoutForKey( $title, $article, $globalPreference );
	}

	private static function getLayoutForKey( Title $title, Article $article, $key ) {
		if ( $key === CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI ) {
			return CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI;
		} else if (
			$key === CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION &&
			!CategoryExhibitionHooks::isExhibitionDisabledForTitle( $title, $article )
		) {
			return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION;
		} else if ( $key === CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3 ) {
			return CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3;
		}

		return null;
	}
}
