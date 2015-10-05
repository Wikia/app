<?php

/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * @author Jacek 'mech' Woźniak <mech@wikia-inc.com>
 * Date: 28.02.13 14:45
 */
class SEOTweaksGlobalHooksHelper {

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
	static protected function getResizeImageUrlIfLargerThanMax( $file ) {
		$fileUrl = false;
		$width = $file->getWidth();
		if ( $width > self::MAX_WIDTH ) {
			$thumbObj = $file->transform( [ 'width' => self::MAX_WIDTH ], 0 );
			if ( $thumbObj ) $fileUrl = $thumbObj->getUrl();
		} else {
			$fileUrl = $file->getUrl();
		}
		return $fileUrl;
	}

	static protected function makeKey( $title ) {
		return wfMemcKey( 'OpenGraphTitleImage', md5( $title->getDBKey() ) );
	}

	/**
	 * Return first image from an article, first check for infobox images,
	 * If not found, take the biggest as possible:
	 * first minimal recommended image size from facebook, and if not found, take minimal requirement
	 * @param $title
	 * @return null|Title
	 */
	static protected function getFirstArticleImage( $title ) {
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
	static protected function getFirstArticleImageLargerThan( $title, $width, $height, $driverName = null ) {
		$imageServing = new ImageServing( [ $title->getArticleID() ], $width, $height );
		$out = $imageServing->getImages( 1, $driverName);
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
			$name = $first[ 0 ][ 'name' ];
			return Title::newFromText( $name, NS_FILE );
		}
		return null;
	}

	/**
	 * @param $meta
	 * @param $title Title
	 * @return bool
	 */
	static public function onOpenGraphMetaHeaders( &$meta, $title ) {
		global $wgMemc;
		if ( !empty( $title ) && $title instanceof Title && !$title->isMainPage() ) {
			$namespace = $title->getNamespace();
			if ( $namespace == NS_USER ) {
				return true;
			}
			$cacheKey = self::makeKey( $title );
			$imageUrl = $wgMemc->get( $cacheKey );

			//if no image in memcache
			if ( empty( $imageUrl ) ) {
				if ( $namespace != NS_FILE ) {
					$title = self::getFirstArticleImage( $title );
				}
				if ( !empty( $title ) ) {
					$file = wfFindFile( $title );
					if ( !empty( $file ) ) {
						$thumb = self::getResizeImageUrlIfLargerThanMax( $file );
						if ( !empty( $thumb ) ) $meta[ "og:image" ] = $thumb;
					}
				}
				if ( isset( $meta[ "og:image" ] ) && ( !empty( $meta[ "og:image" ] ) ) ) {
					$imageUrl = $meta[ "og:image" ];
				} else {
					// Even if there is no og:image, we store the info in memcahe so we don't do the
					// processing again
					$imageUrl = '';
				}
				$wgMemc->set( $cacheKey, $imageUrl );
			}

			// only when there is a thumbnail url add it to metatags
			if ( !empty( $imageUrl ) ) {
				$meta[ 'og:image' ] = $imageUrl;
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
		global $wgOut;

		if ( $article instanceof Article ) {
			if ( $article->getTitle()->getNamespace() == NS_USER || $article->getTitle()->getNamespace() == NS_USER_TALK ) {
				// bugId:PLA-844
				$wgOut->setRobotPolicy( "noindex,nofollow" );
			}
		}
		return true;
	}
}
