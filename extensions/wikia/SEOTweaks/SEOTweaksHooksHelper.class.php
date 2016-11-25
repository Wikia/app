<?php

/**
 * SEOTweaks Hooks Helper
 * @author mech
 * @author ADi
 * @author Jacek Jursza <jacek at wikia-inc.com>
 */

class SEOTweaksHooksHelper {
	const NOT_FOUND_STATUS_CODE = 404;

	/**
	 * List of hosts associated with external sharing services
	 */
	const SHARING_HOSTS_REGEX = '/\.(facebook|twitter|google)\./is';

	/**
	 * @author mech
	 * @param OutputPage $out
	 * @return bool true
	 */
	static function onBeforePageDisplay( $out ) {
		global $wgSEOGooglePlusLink;
		if ( !empty( $wgSEOGooglePlusLink ) ) {
			$out->addLink( array( 'href' => $wgSEOGooglePlusLink, 'rel' => 'publisher' ) );
		}
		return true;
	}

	/**
	 * change title tag for Video Page and Image Page
	 * @author Jacek Jursza
	 * @param ImagePage $imgPage
	 * @param $html
	 * @return bool
	 */
	static function onImagePageAfterImageLinks( $imgPage, $html ) {
		$file = $imgPage->getDisplayedFile(); /* @var $file LocalRepo */
		$title = $imgPage->getTitle();  /* @var $title Title */
		$newTitle = '';

		if ( !empty( $file ) && !empty( $title ) && !F::app()->checkSkin('monobook') ) {

			if ( (new WikiaFileHelper)->isFileTypeVideo( $file ) ) {

				$newTitle = wfMsg('seotweaks-video') . ' - ' . $title->getBaseText();
			} else {

				// It's not Video so lets check if it is Image
				if ( $file instanceof LocalFile && $file->getHandler() instanceof BitmapHandler ) {

					$newTitle = wfMsg('seotweaks-image') . ' - ' . $title->getBaseText();
				}
			}

			if ( !empty( $newTitle ) ) {
				F::app()->wg->Out->setPageTitle( $newTitle );
			}
		}
		return true;
	}

	/**
	 * Prepends alt text for an image if that image does not have that option set
	 * @param  Parser $parser
	 * @param  Title  $title
	 * @param  Array  $options
	 * @param  bool   $descQuery
	 * @return bool
	 */
	static public function onBeforeParserMakeImageLinkObjOptions( $parser, $title, &$parts, &$params, &$time, &$descQuery, $options ) {
		$grepped = preg_grep( '/^alt=/', (array) $parts);
		if ( $title->getNamespace() == NS_FILE && empty( $grepped ) ) {
			$text = $title->getText();
			$alt = implode( '.', array_slice( explode( '.', $text ), 0, -1 ) ); // lop off text after the ultimate dot (e.g. JPG)
			$parts[] = "alt={$alt}";
		}

		return true;

	}

	/**
	 * Attempts to recover a URL that was truncated by an external service (e.g. /wiki/Wanted! --> /wiki/Wanted)
	 * @param Article $article
	 * @param bool $outputDone
	 * @param bool $pcache
	 */
	static public function onArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		global $wgEnableCustom404PageExt;

		if ( !empty( $wgEnableCustom404PageExt ) ) {
			// Custom404Page does the same, just better
			return true;
		}

		$title = $article->getTitle();
		if ( !$title->exists()
				&& $title->isContentPage()
				&& isset( $_SERVER['HTTP_REFERER'] )
				&& preg_match( self::SHARING_HOSTS_REGEX, parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_HOST ) )
		) {
			$namespace = $title->getNamespace();
			$dbr = wfGetDB( DB_SLAVE );
			$query = sprintf(
				'SELECT page_title FROM page WHERE page_title %s AND page_namespace = %d LIMIT 1',
				$dbr->buildLike( $title->getDBKey(), $dbr->anyString() ),
				$namespace
			);
			$result = $dbr->query( $query, __METHOD__ );
			if ( $row = $dbr->fetchObject( $result ) ) {
				$title = Title::newFromText( $row->page_title, $namespace );
				F::app()->wg->Out->redirect( $title->getFullUrl() );
				$outputDone = true;
			}
		}
		return true;
	}

	/**
	 * Hook: set status code to 404 for category pages without pages or media
	 * @param CategoryPage $categoryPage
	 * @return bool
	 */
	public static function onCategoryPageView( &$categoryPage ) {
		$title = $categoryPage->getTitle();
		if ( $title->getNamespace() === NS_CATEGORY ) {
			$app = F::app();
			$cacheKey = wfMemcKey( 'category_has_members', sha1( $title->getDBkey() ) );
			$hasMembers = $app->wg->Memc->get( $cacheKey );
			if ( !is_numeric( $hasMembers ) ) {
				$category = Category::newFromTitle( $title );
				$hasMembers = empty( $category->getPageCount() ) ? 0 : 1;
				$app->wg->Memc->set( $cacheKey, $hasMembers, WikiaResponse::CACHE_VERY_SHORT );
			}

			if ( $hasMembers < 1 ) {
				$categoryPage->getContext()->getOutput()->setStatusCode( self::NOT_FOUND_STATUS_CODE );
			}
		}

		return true;
	}

}
