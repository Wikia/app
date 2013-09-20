<?php

/**
 * SEOTweaks Hooks Helper
 * @author mech
 * @author ADi
 * @author Jacek Jursza <jacek at wikia-inc.com>
 */

class SEOTweaksHooksHelper {
	const DELETED_PAGES_STATUS_CODE = 410;
	
	/**
	 * List of hosts associated with external sharing services
	 */
	const SHARING_HOSTS_REGEX = '/\.(facebook)|(twitter)|(google)\./is';

	/**
	 * @author mech
	 * @param OutputPage $out
	 * @return bool true
	 */
	static function onBeforePageDisplay( $out ) {
		global $wgSEOGoogleSiteVerification, $wgSEOGooglePlusLink;
		if ( !empty( $wgSEOGoogleSiteVerification ) ) {
			$out->addMeta( 'google-site-verification', $wgSEOGoogleSiteVerification );
		}
		if ( !empty( $wgSEOGooglePlusLink ) ) {
			$out->addLink( array( 'href' => $wgSEOGooglePlusLink, 'rel' => 'publisher' ) );
		}
		return true;
	}

	/**
	 * set appropriate status code for deleted pages
	 *
	 * @author ADi
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param Title $title
	 * @param Article $article
	 * @return bool
	 */
	static public function onAfterInitialize( &$title, &$article, &$output ) {
		if( !$title->exists() && $title->isDeleted() ) {
			$setDeletedStatusCode = true;
			// handle special cases
			switch( $title->getNamespace() ) {
				case NS_CATEGORY:
					// skip non-empty categories
					if ( Category::newFromTitle($title)->getPageCount() > 0 ) {
						$setDeletedStatusCode = false;
					}
					break;
				case NS_FILE:
					// skip existing file with deleted description
					$file = wfFindFile( $title );
					if ( $file && $file->exists() ) {
						$setDeletedStatusCode = false;
					}
					break;
			}
			if ( $setDeletedStatusCode ) {
				$output->setStatusCode( SEOTweaksHooksHelper::DELETED_PAGES_STATUS_CODE );
			}
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

		if ( !empty( $file ) && !empty( $title ) ) {

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
		$title = $article->getTitle();
		if ( ( ! $title->exists() ) 
			&& ( isset( $_SERVER['HTTP_REFERER'] ) ) 
			&& preg_match( self::SHARING_HOSTS_REGEX, parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_HOST ) ) 
		    ) {
			$dbr = wfGetDB( DB_SLAVE );
			$result = $dbr->query( sprintf( 'SELECT page_title FROM page WHERE page_title %s LIMIT 1', $dbr->buildLike( $title->getDBKey(), $dbr->anyString() ) ), __METHOD__ );
			if ( $row = $dbr->fetchObject( $result ) ) {
				$title = Title::newFromText( $row->page_title );
				F::app()->wg->Out->redirect( $title->getFullUrl() );
			    $outputDone = true;
			}
		}
		return true;
	}

}
