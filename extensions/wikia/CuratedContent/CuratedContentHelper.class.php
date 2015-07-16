<?php
/**
 * CuratedContent Helper
 */
class CuratedContentHelper {
	const STR_ARTICLE = 'article';
	const STR_BLOG = 'blog';
	const STR_FILE = 'file';
	const STR_CATEGORY = 'category';
	const STR_EMPTY_CATEGORY = 'emptyCategory';

	public function processLogic( $sections ) {
		$processedSections = [];
		foreach ( $sections as $section ) {
			$processedSections[] = $this->processLogicForSection( $section );
		}
		return $processedSections;
	}

	private function processLogicForSection( $section ) {
		$section['image_id'] = (int)$section['image_id'];

		foreach ( $section['items'] as &$item ) {
			$this->fillItemInfo( $item );
		}

		return $section;
	}

	private function fillItemInfo( &$item ) {
		$title = Title::newFromText( $item[ 'title' ] );
		if ( !empty( $title ) ) {
			$articleId = $title->getArticleId();
			$namespaceId = $title->getNamespace();
			$imageId = (int)$item[ 'image_id' ];

			$item['type'] = self::getTypeFromNamespaceId( $namespaceId );

			switch ( $item['type'] ) {
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

	public static function getIdFromCategoryName( $categoryName ) {
		$cat = Title::newFromText( $categoryName, NS_CATEGORY );

		return ($cat instanceof Title) ? $cat->getArticleID() : 0;
	}

	public static function getImageUrl( $id ) {
		$thumbnail = (new ImageServing( [ $id ], 50, 50 ))->getImages( 1 );

		return !empty( $thumbnail ) ? $thumbnail[ $id ][ 0 ][ 'url' ] : '';
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
		if ( empty( $imageId ) ) {
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
}
