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
	 * Size of preferred article image.
	 */
	const MIN_WIDTH = 200;
	const MIN_HEIGHT = 200;
	const MAX_WIDTH = 2000;
	const PREF_WIDTH = 600;
	const PREF_HEIGHT = 315;

	/**
	 * Given a file, return url to file, or thumbnail url if size larger than MAX_WIDTH
	 * @param $file File
	 * @return string|false
	 */
	static protected function getResizeImageUrlIfLargerThanMax( File $file ) {
		$fileUrl = false;
		$width = $file->getWidth();

		if ( $width > self::MAX_WIDTH ) {
			$thumbObj = $file->transform( [ 'width' => self::MAX_WIDTH ], 0 );

			if ( $thumbObj ) {
				$fileUrl = $thumbObj->getUrl();
			}
		} else {
			$fileUrl = $file->getUrl();
		}

		return $fileUrl;
	}

	static protected function makeOpenGraphKey( Title $title ): string {
		return wfMemcKey( 'OpenGraphTitleImage', md5( $title->getDBKey() ), $title->getLatestRevID() );
	}

	/**
	 * Return first image from an article, first check for infobox images,
	 * If not found, take the biggest as possible:
	 * first minimal recommended image size from facebook, and if not found, take minimal requirement
	 * @param $title
	 * @return null|Title
	 */
	static protected function getFirstArticleImage( Title $title ) {
		$retTitle = self::getFirstArticleImageLargerThan( $title, self::MIN_WIDTH, self::MIN_HEIGHT, "ImageServingDriverInfoboxImageNS" );

		if ( !empty( $retTitle ) ) {
			return $retTitle;
		}
		$retTitle = self::getFirstArticleImageLargerThan( $title, self::PREF_WIDTH, self::PREF_HEIGHT );

		if ( !empty( $retTitle ) ) {
			return $retTitle;
		}

		return self::getFirstArticleImageLargerThan( $title, self::MIN_WIDTH, self::MIN_HEIGHT );
	}

	/**
	 * Return first image from an article, matched criteria
	 * @param $title
	 * @param $width
	 * @param $height
	 * @param null $driverName
	 * @return null|\Title
	 */
	static protected function getFirstArticleImageLargerThan( Title $title, int $width, int $height, $driverName = null ) {
		$imageServing = new ImageServing( [ $title->getArticleID() ], $width, $height );
		$out = $imageServing->getImages( 1, $driverName );

		return self::createTitleFromResultArray( $out );
	}

	/**
	 * @desc Creates a Title object from array of file names
	 * @param $out array of file names
	 * @return null|\Title
	 */
	static protected function createTitleFromResultArray( $out ) {
		if ( !empty( $out ) ) {
			///used reset instead direct call because we can get hashmap from ImageServing driver.
			$first = reset( $out );
			$name = $first[0]['name'];

			return Title::newFromText( $name, NS_FILE );
		}

		return null;
	}

	/**
	 * @param $meta
	 * @param $title Title
	 * @return bool
	 */
	static public function onOpenGraphMetaHeaders( &$meta, $title ): bool {
		if ( !empty( $title ) && $title instanceof Title && !$title->isMainPage() ) {
			$namespace = $title->getNamespace();

			if ( $namespace == NS_USER ) {
				return true;
			}

			$imageUrl = WikiaDataAccess::cache(
				self::makeOpenGraphKey( $title ),
				WikiaResponse::CACHE_STANDARD,
				function () use ( $namespace, $title ) {

					if ( $namespace != NS_FILE ) {
						$title = self::getFirstArticleImage( $title );
					}

					if ( !empty( $title ) ) {
						$file = wfFindFile( $title );

						if ( !empty( $file ) ) {
							$thumb = self::getResizeImageUrlIfLargerThanMax( $file );

							if ( !empty( $thumb ) ) {
								return $thumb;
							}
						}
					}

					// Even if there is no og:image, we store the info in memcahe so we don't do the
					// processing again
					return '';
				}
			);

			// only when there is a thumbnail url add it to metatags
			if ( !empty( $imageUrl ) ) {
				$meta['og:image'] = $imageUrl;
			}
		}

		return true;
	}

	static public function onArticleRobotPolicy( &$policy, Title $title ) {

		$ns = MWNamespace::getSubject( $title->getNamespace() );

		if ( in_array( $ns, [ NS_MEDIAWIKI, NS_TEMPLATE ] ) ) {
			$policy = [
				'index' => 'noindex',
				'follow' => 'follow'
			];
		}

		return true;
	}

	static public function onShowMissingArticle( $article ) {
		if ( $article instanceof Article ) {
			if ( $article->getTitle()->getNamespace() == NS_USER || $article->getTitle()->getNamespace() == NS_USER_TALK ) {
				// bugId:PLA-844
				RequestContext::getMain()->getOutput()->setRobotPolicy( "noindex,nofollow" );
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
		/* @var $file WikiaLocalFile */
		$file = $imgPage->getDisplayedFile();
		/* @var $title Title */
		$title = $imgPage->getTitle();

		if ( !empty( $file ) && !empty( $title ) && !F::app()->checkSkin( 'monobook' ) ) {
			$newTitle = self::getTitleForFilePage( $title, $file );

			if ( !empty( $newTitle ) ) {
				F::app()->wg->Out->setPageTitle( $newTitle );
			}
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param File $file
	 *
	 * @return null|string
	 */
	public static function getTitleForFilePage( Title $title, File $file ) {
		$newTitle = null;

		if ( ( new WikiaFileHelper )->isFileTypeVideo( $file ) ) {
			$newTitle = wfMessage( 'seotweaks-video' )->escaped() . ' - ' . $title->getBaseText();
		} elseif ( $file instanceof LocalFile && $file->getHandler() instanceof BitmapHandler ) {
			$newTitle = wfMessage( 'seotweaks-image' )->escaped() . ' - ' . $title->getBaseText();
		}

		return $newTitle;
	}

	/**
	 * Prepends alt text for an image if that image does not have that option set
	 * @param  Parser $parser
	 * @param  Title $title
	 * @param $parts
	 * @param $params
	 * @param $time
	 * @param  bool $descQuery
	 * @param  array $options
	 * @return bool
	 */
	static public function onBeforeParserMakeImageLinkObjOptions( $parser, $title, &$parts, &$params, &$time, &$descQuery, $options ) {
		if ( !isset( $params['frame']['alt'] ) && $title->inNamespace( NS_FILE ) ) {
			$fileName = $title->getText();
			$finalDotPosition = strrpos( $fileName, '.' );

			// lop off text after the ultimate dot (e.g. JPG)
			$params['frame']['alt'] = $finalDotPosition ? substr( $fileName, 0,
				$finalDotPosition ) : $fileName;
		}

		return true;

	}

	/**
	 * Attempts to recover a URL that was truncated by an external service (e.g. /wiki/Wanted! --> /wiki/Wanted)
	 * @param Article $article
	 * @param bool $outputDone
	 * @param bool $pcache
	 * @return bool
	 */
	static public function onArticleViewHeader( Article $article, bool &$outputDone, bool &$pcache ): bool {
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
	public static function onCategoryPageView( CategoryPage $categoryPage ): bool {
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
