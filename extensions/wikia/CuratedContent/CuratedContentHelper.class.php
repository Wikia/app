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
	const STR_VIDEO = 'video';

	public function processSections( $sections ) {
		$processedSections = [ ];
		if ( !empty( $sections ) && is_array( $sections ) ) {
			foreach ( $sections as $section ) {
				$processedSections[ ] = $this->processLogicForSection( $section );
			}
		}
		return $processedSections;
	}

	private function processLogicForSection( $section ) {
		$section['image_id'] = (int)$section['image_id']; // fallback to 0 if it's not set in request

		if ( !empty( $section['items'] ) && is_array( $section['items'] ) ) {
			foreach ( $section['items'] as &$item ) {
				$this->fillItemInfo( $item );
			}
		}

		return $section;
	}

	private function fillItemInfo( &$item ) {
		$title = Title::newFromText( $item['title'] );
		// We cannot check for $title->isEmpty() because it's empty for non-exisitng Articles.
		// Categories without content are non-existing Articles (their article_id is 0)
		if ( !empty( $title ) ) {
			$articleId = $title->getArticleId();
			$namespaceId = $title->getNamespace();
			$imageId = (int)$item['image_id'];

			$item['type'] = self::getTypeFromNamespaceId( $namespaceId );

			switch ( $item['type'] ) {
				case self::STR_FILE:
					$info = self::getVideoInfo( $title );
					if ( !empty( $info ) ) {
						$item['type'] = self::STR_VIDEO;
						$item['video_info'] = $info;
					}
					break;

				case self::STR_CATEGORY:
					$category = Category::newFromTitle( $title );
					if ( $category instanceof Category && $category->getID() ) {
						$count = $category->getPageCount();
						if ( empty( $count ) ) {
							$item['type'] = self::STR_EMPTY_CATEGORY;
						}
					} else {
						$item['type'] = null;
					}
					break;
			}

			if ( empty( $imageId ) ) {
				$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
				if ( !empty( $imageTitle ) ) {
					$imageId = $imageTitle->getArticleId();
				}
			}
			$item['article_id'] = $articleId;
			$item['image_id'] = $imageId;
		}
	}

	public static function getImageUrl( $id, $imageSize = 50 ) {
		$thumbnail = (new ImageServing( [ $id ], $imageSize, $imageSize ))->getImages( 1 );

		return !empty( $thumbnail ) ? $thumbnail[$id][0]['url'] : '';
	}

	private function getVideoInfo( $title ) {
		$mediaService = new MediaQueryService();
		$mediaInfo = $mediaService->getMediaData( $title );
		if ( !empty( $mediaInfo ) ) {
			if ( $mediaInfo['type'] === MediaQueryService::MEDIA_TYPE_VIDEO ) {
				return [
					'provider' => $mediaInfo['meta']['provider'],
					'thumb_url' => $mediaInfo['thumbUrl'],
					'videoId' => $mediaInfo['meta']['videoId']
				];
			}
		}
		return null;
	}

	public static function findImageUrl( $imageId ) {
		list( $_imageId, $imageUrl ) = self::findImageIdAndUrl( $imageId );

		return $imageUrl;
	}

	public static function findImageIdAndUrl( $imageId, $articleId = 0 ) {
		$url = null;
		$imageTitle = null;

		if ( empty( $imageId ) ) {
			$imageId = null;
			$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
		} else {
			$imageTitle = Title::newFromID( $imageId );
		}
		if ( $imageTitle instanceof Title && $imageTitle->exists() ) {
			$url = self::getUrlFromImageTitle( $imageTitle );
			$imageId = $imageTitle->getArticleId();
		}

		return [ $imageId, $url ];
	}

	public static function findFirstImageTitleFromArticle( $articleId ) {
		$imageTitle = null;
		if ( !empty( $articleId ) ) {
			$imageServing = new ImageServing( [ $articleId ] );
			$image = $imageServing->getImages( 1 );
			if ( !empty( $image ) ) {
				$imageTitleName = $image[$articleId][0]['name'];
				if ( !empty( $imageTitleName ) ) {
					$imageTitle = Title::newFromText( $imageTitleName, NS_FILE );
				}
			}
		}
		return ($imageTitle instanceof Title && $imageTitle->exists()) ? $imageTitle : null;
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
