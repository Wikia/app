<?php

class CuratedContentErrors {
	private static $errors = [];

	public static function clear() {
		self::$errors = [];
	}

	public static function add( $itemWithTitle, $errorString ) {
		if ( array_key_exists('title', $itemWithTitle ) && empty( $errorString ) ) {
			self::$errors[] = ['title' => $itemWithTitle['title'], 'reason' => $errorString];
		}
	}

	public static function get() {
		return self::$errors;
	}
}

/**
 * CuratedContent Helper
 */
class CuratedContentHelper {
	const STR_ARTICLE = 'article';
	const STR_BLOG = 'blog';
	const STR_FILE = 'file';
	const STR_CATEGORY = 'category';
	const STR_EMPTY_CATEGORY = 'emptyCategory';

	const VALIDATE_LABEL_MAX_LENGTH = 48;

	public static function processLogic( $sections ) {
		$processedSections = [];
		foreach ( $sections as $section ) {
			$processedSections[] = self::processLogicForSection( $section );
		}
		return $processedSections;
	}

	private static function processLogicForSection( $section ) {
		$section['image_id'] = (int)$section['image_id'];

		foreach ( $section['items'] as &$item ) {
			self::fillItemInfo( $item );
		}

		return $section;
	}

	private static function fillItemInfo( &$item ) {
		$title = Title::newFromText( $item[ 'title' ] );
		if ( !empty( $title ) ) {
			$articleId = $title->getArticleId();
			$namespaceId = $title->getNamespace();
			$type = self::getTypeFromNamespaceId( $namespaceId );
			$imageId = (int)$item[ 'image_id' ];

			switch ( $type ) {
				case self::STR_FILE:
					$info = self::getVideoInfo( $title );
					if ( !empty( $info ) ) {
						$item['type'] = 'video';
						$item['video_info'] = $info;
					}
					break;

				case self::STR_CATEGORY:
					$category = Category::newFromTitle( $title );
					if ( !empty( $category ) ) {
						$count = $category->getPageCount();
						if ( empty( $count ) ) {
							$item['type'] = self::STR_EMPTY_CATEGORY;
						}
					}
					break;
			}

			if ( $imageId === 0 ) {
				$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
				if ( !empty( $imageTitle ) ) {
					$articleId = $imageTitle->getArticleId();
				}
			}
			$item['article_id'] = $articleId;
			$item['image_id'] = $imageId;
		}
	}

	public static function validate( $data ) {
		CuratedContentErrors::clear();

		// validate sections
		foreach( $data as $section ) {
			if ( !empty( $section['featured'] ) ) {
				self::validateFeaturedSection( $section );
			} else {
				self::validateSection( $section );
			}
		}
		// also check section for duplicate name

		// flattern and return data
		return CuratedContentErrors::get();
	}

	private static function validateFeaturedSection( $section ) {
		foreach ( $section['items'] as $item ) {
			self::validateItem( $item );
		}
	}

	private static function validateImage( $sectionOrItem ) {
		if ( $sectionOrItem['image_id'] === 0) {
			CuratedContentErrors::add( $sectionOrItem, 'imageMissing' );
		}
	}

	private static function validateSection ( $section ) {
		static $hadEmptyLabel = false;

		if ( empty( $section['title'] ) ) {
			if ($hadEmptyLabel) {
				CuratedContentErrors::add( '', 'duplicatedLabel' );
			} else {
				$hadEmptyLabel = true;
			}
		}

		if ( strlen( $section['title'] ) > self::VALIDATE_LABEL_MAX_LENGTH ) {
			CuratedContentErrors::add( $section, 'tooLongLabel' );
		}

		if ( empty( $section['featured'] ) && $section['title'] !== '' ) {
			self::validateImage( $section );
		}

		if ( !empty( $section['items'] ) && is_array( $section['items'] ) ) {
			foreach ($section['items'] as $item) {
				self::validateCategoryItem($item);
				self::validateImage($item);
			}
		} else {
			if ( empty( $section['featured'] ) ) {
				CuratedContentErrors::add( $section, 'itemsMissing');
			}
		}
	}

	private static function validateCategoryItem( $item ) {
		self::validateItem( $item );

		if ( $item['type'] !== self::STR_CATEGORY ) {
			CuratedContentErrors::add( $item, 'noCategoryInTag' );
		}
	}

	private static function validateItem( $item ) {
		self::validateImage( $item );

		if ( $item['type'] == null ) {
			CuratedContentErrors::add( $item, 'notSupportedType' );
		}

		if ( $item['type'] === 'video' ) {
			if ( empty( $info ) ) {
				CuratedContentErrors::add( $item, 'videoNotHaveInfo' );
			} elseif ( self::isSupportedProvider( $info['provider'] ) ) {
				CuratedContentErrors::add( $item, 'videoNotSupportProvider' );
			}
		}

		if ( self::needsArticleId( $item['type'] ) && $item['article_id'] === 0 ) {
			CuratedContentErrors::add( $item, 'articleNotFound' );
		}
	}

	public static function getIdFromCategoryName( $categoryName ) {
		$cat = Title::newFromText( $categoryName, NS_CATEGORY );

		return ($cat instanceof Title) ? $cat->getArticleID() : 0;
	}

	public static function getImageUrl( $file, $id = 0 ) {
		$url = '';

		if ( !empty( $file ) ) {
			$img = Title::newFromText( $file );

			if ( !empty( $img ) && $img instanceof Title ) {
				$id = $img->getArticleID();
			}
		}

		if ( $id != 0 ) {
			$thumbnail = (new ImageServing( [ $id ], 50, 50 ))->getImages( 1 );

			if ( !empty( $thumbnail ) ) {
				$url = $thumbnail[ $id ][ 0 ][ 'url' ];
			}
		}


		return $url;
	}

	private function getVideoInfo( $title ) {
		$mediaService = new MediaQueryService();
		$mediaInfo = $mediaService->getMediaData( $title );
		if ( !empty( $mediaInfo ) ) {
			if ( $mediaInfo[ 'type' ] === 'video' ) {
				$provider = $mediaInfo [ 'meta' ][ 'provider' ];
				$thumbUrl = $mediaInfo [ 'thumbUrl' ];
				$videoId = $mediaInfo[ 'meta' ][ 'videoId' ];
				return [
					'provider' => $provider,
					'thumb_url' => $thumbUrl,
					'videoId' => $videoId
				];
			}
		}
		return null;
	}

	public static function findImageIfNotSet( $imageId, $articleId = 0 ) {
		$url = '';

		$imageTitle = null;
		if ( $imageId == 0 ) {
			$imageId = null;
			$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
		} else {
			$imageTitle = Title::newFromID( $imageId );
		}
		if ( !empty( $imageTitle ) ) {
			$url = self::getUrlFromImageTitle( $imageTitle );
			$imageId = $imageTitle->getArticleId();
		}

		return [ $imageId, $url ];
	}

	public static function findFirstImageTitleFromArticle( $articleId ) {
		$imageTitle = null;
		if ( !empty( $articleId ) ) {
			$is = new ImageServing( [ $articleId ] );
			$image = $is->getImages( 1 );
			if ( !empty( $image ) ) {
				$image_title_name = $image[ $articleId ][ 0 ][ 'name' ];
				if ( !empty( $image_title_name ) ) {
					$imageTitle = Title::newFromText( $image_title_name, NS_FILE );
				}
			}
		}
		return $imageTitle;
	}

	public static function getUrlFromImageTitle( $imageTitle ) {
		$imageUrl = null;
		if ( !empty( $imageTitle ) ) {
			$imageFile = wfFindFile( $imageTitle );
			if ( !empty( $imageFile ) ) {
				$imageUrl = $imageFile->getUrl();
			}
		}
		return $imageUrl;
	}

	public static function getTypeFromNamespaceId( $namespaceId ) {
		switch ( $namespaceId ) {
			case NS_MAIN:
				return self::STR_ARTICLE;
				break;
			case NS_BLOG_ARTICLE:
				return self::STR_BLOG;
				break;
			case NS_CATEGORY:
				return self::STR_CATEGORY;
				break;
			case NS_FILE:
				return self::STR_FILE;
				break;
			default:
				return null;
				break;
		}
	}

	public function needsArticleId( $type ) {
		return $type != self::STR_CATEGORY;
	}

	public function isSupportedProvider( $provider ) {
		return ($provider === 'youtube') || (startsWith( $provider, 'ooyala' ));
	}
}
