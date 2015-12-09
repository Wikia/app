<?php

/**
 * Class TwitterCards
 */
class TwitterCards extends WikiaModel {

	const DESCRIPTION_MAX_LENGTH = 200;
	const IMAGE_CACHE_TTL = 604800; // 7 days
	const IMAGE_MIN_HEIGHT = 200;
	const IMAGE_MIN_WIDTH = 200;
	const IMAGE_PREF_HEIGHT = 315;
	const IMAGE_PREF_WIDTH = 600;
	const THUMB_MAX_WIDTH = 2000;
	const TITLE_MAX_LENGTH = 70;

	/**
	 * Get meta tags
	 * @param OutputPage $output
	 * @return array
	 */
	public function getMeta( $output ) {
		$title = $output->getTitle();
		if ( !( $title instanceof Title ) ) {
			return [];
		}

		$meta['twitter:card'] = 'summary';
		$meta['twitter:site'] = $this->wg->TwitterAccount;
		$meta['twitter:url'] = $title->getFullURL();
		$meta['twitter:title'] = $this->getPageTitle( $title );

		// add description
		$description = $this->getDescription( $output );
		if ( !empty( $description ) ) {
			$meta['twitter:description'] = $description;
		}

		// add image url
		$imageUrl = $this->getImageUrl( $title );
		if ( !empty( $imageUrl ) ) {
			$meta['twitter:image'] = $imageUrl;
		}

		return $meta;
	}

	/**
	 * Get page title
	 * @param Title $title
	 * @return string
	 */
	protected function getPageTitle( $title ) {
		if ( $title->isMainPage() ) {
			$pageTitle = $this->wg->Sitename;
		} else if ( !empty( $this->wg->EnableBlogArticles )
			&& ( $title->getNamespace() == NS_BLOG_ARTICLE || $title->getNamespace() == NS_BLOG_ARTICLE_TALK ) )
		{
			$pageTitle = $title->getSubpageText();
		} else {
			$pageTitle = $title->getText();
		}

		return mb_substr( $pageTitle, 0, self::TITLE_MAX_LENGTH );
	}

	/**
	 * Get page description
	 * @param OutputPage $output
	 * @return string
	 */
	protected function getDescription( $output ) {
		$description = '';
		if ( !empty( $output->mDescription ) ) {
			$description = mb_substr( $output->mDescription, 0, self::DESCRIPTION_MAX_LENGTH );
		}

		return $description;
	}

	/**
	 * Get image url
	 * @param Title $title
	 * @return string
	 */
	protected function getImageUrl( Title $title ) {
		if ( $title->isMainPage() ) {
			return wfExpandUrl( $this->wg->Logo );
		}

		$namespace = $title->getNamespace();
		if ( $namespace == NS_USER ) {
			return '';
		}

		$cacheKey = $this->getMemcKey( $title );
		$imageUrl = $this->wg->Memc->get( $cacheKey );
		if ( !is_string( $imageUrl ) ) {
			if ( $namespace != NS_FILE ) {
				$title = $this->getFirstArticleImage( $title );
			}

			$imageUrl = '';
			if ( !empty( $title ) ) {
				$file = wfFindFile( $title );
				if ( !empty( $file ) ) {
					if ( $file->getWidth() > self::THUMB_MAX_WIDTH ) {
						$thumb = $file->transform( [ 'width' => self::THUMB_MAX_WIDTH ], 0 );
						if ( !empty( $thumb ) ) {
							$imageUrl = $thumb->getUrl();
						}
					} else {
						$imageUrl = $file->getUrl();
					}
				}
			}

			$this->wg->Memc->set( $cacheKey, $imageUrl, IMAGE_CACHE_TTL );
		}

		return $imageUrl;
	}

	/**
	 * Get first image from the article
	 * @param Title $title
	 * @return Title|null
	 */
	protected function getFirstArticleImage( $title ) {
		// check for infobox image
		$driver = 'ImageServingDriverInfoboxImageNS';
		$retTitle = $this->getFirstImageLargerThan( $title, self::IMAGE_MIN_WIDTH, self::IMAGE_MIN_HEIGHT, $driver);
		if ( !empty( $retTitle ) ) {
			return $retTitle;
		}

		// check for preferred size image
		$retTitle = $this->getFirstImageLargerThan( $title, self::IMAGE_PREF_WIDTH, self::IMAGE_PREF_HEIGHT );
		if ( !empty( $retTitle ) ) {
			return $retTitle;
		}

		return $this->getFirstImageLargerThan( $title, self::IMAGE_MIN_WIDTH, self::IMAGE_MIN_HEIGHT );
	}

	/**
	 * Get first image from the article that matched the criteria
	 * @param Title $title
	 * @param int $width
	 * @param int $height
	 * @param string $driverName
	 * @return Title|null
	 */
	protected function getFirstImageLargerThan( $title, $width, $height, $driverName = null ) {
		$imageServing = new ImageServing( [ $title->getArticleID() ], $width, $height );
		$images = $imageServing->getImages( 1, $driverName );
		if ( empty( $images ) ) {
			return null;
		}

		// used reset instead direct call because we can get hashmap from ImageServing driver.
		$first = reset( $images );
		$name = $first[ 0 ][ 'name' ];
		return Title::newFromText( $name, NS_FILE );
	}

	/**
	 * Get Memcache key
	 * @param Title $title
	 * @return String
	 */
	protected function getMemcKey( $title ) {
		return wfMemcKey( 'TwitterCardsImage', md5( $title->getDBkey() ) );
	}

}
