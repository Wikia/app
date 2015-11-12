<?php
/**
 * CuratedContent Helper
 */
class CuratedContentHelper {
	const STR_ARTICLE = 'article';
	const STR_BLOG = 'blog';
	const STR_FILE = 'file';
	const STR_CATEGORY = 'category';
	const STR_VIDEO = 'video';

	public static function shouldDisplayToolButton() {
		global $wgEnableCuratedContentExt, $wgUser;

		return WikiaPageType::isMainPage() &&
			!empty( $wgEnableCuratedContentExt ) &&
			$wgUser->isAllowed( 'curatedcontent' );
	}

	public function processSections( $sections ) {
		$processedSections = [ ];

		if ( is_array( $sections ) ) {
			foreach ( $sections as $section ) {
				$processedSections[] = $this->processLogicForSection( $section );
			}
		}

		// remove null elements from array
		return $this->removeEmptySections( $processedSections );
	}

	public function processSectionsFromSpecialPage( $sections ) {
		$processedSections = [ ];
		if ( is_array( $sections ) ) {
			foreach ( $sections as $section ) {
				$processedSections[] = $this->processLogicForSectionSpecialPage( $section );
			}
		}
		// remove null elements from array
		return $this->removeEmptySections( $processedSections );
	}

	public function removeEmptySections( $sections ) {
		return array_values( array_filter( $sections, function( $section ) { return !is_null( $section ); } ) );
	}

	public function processLogicForSectionSpecialPage( $section ) {
		if ( empty ( $section['items'] ) || !is_array( $section['items'] ) ) {
			// return null if we don't have any items inside section
			return null;
		}
		$section['image_id'] = (int)$section['image_id']; // fallback to 0 if it's not set in request
		$this->processCrop( $section );
		foreach ( $section['items'] as &$item ) {
			$this->fillItemInfo( $item );
			$this->processCrop( $item );
		}
		return $section;
	}

	public function processLogicForSection( $section ) {
		$section['image_id'] = (int)$section['image_id']; // fallback to 0 if it's not set in request
		$this->processCrop( $section );

		if ( is_array( $section['items'] ) ) {
			foreach ( $section['items'] as &$item ) {
				$this->fillItemInfo( $item );
				$this->processCrop( $item );
			}
		}

		return $section;
	}

	public function decodeCrop( $string = null ) {
		return empty( $string ) ? null : json_decode( html_entity_decode( $string ), true );
	}

	public function encodeCrop( Array $cropData = null ) {
		return empty( $cropData ) ? '' : htmlentities( json_encode( $cropData ), ENT_QUOTES );
	}

	private function processCrop( &$itemOrSection ) {
		if ( array_key_exists( 'image_crop', $itemOrSection ) ) {
			if ( is_string( $itemOrSection['image_crop'] ) ) {
				$itemOrSection['image_crop'] = $this->decodeCrop( $itemOrSection['image_crop'] );
			}

			$itemOrSection['image_crop'] = $this->sanitizeCrop( $itemOrSection['image_crop'] );

			// do not keep empty or unknown data
			if ( empty( $itemOrSection['image_crop'] ) ) {
				unset( $itemOrSection['image_crop'] );
			}
		}
	}

	private function sanitizeCrop( $cropData ) {
		if ( is_array( $cropData ) ) {
			$sanitizedCropData = [ ];
			$coordNames = [ 'x', 'y', 'width', 'height' ];

			// iterate through all the coord arrays
			foreach ( $cropData as $type => $originalCoords ) {
				$coords = [ ];

				// iterate through all the coords
				foreach ( $coordNames as $coordName ) {
					$coords[$coordName] = intval( $originalCoords[$coordName], 10 );
				}

				// only save when coords we've got are valid
				if ( $coords['x'] >= 0 && $coords['y'] >= 0 && $coords['width'] > 0 && $coords['height'] > 0 ) {
					$sanitizedCropData[$type] = $coords;
				}
			}

			return $sanitizedCropData;
		}
		return null;
	}

	public function fillItemInfo( &$item ) {
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
					if ( !( $category instanceof Category && $category->getID() ) ) {
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
		$thumbnail = ( new ImageServing( [ $id ], $imageSize, $imageSize ) )->getImages( 1 );
		return !empty( $thumbnail ) ? $thumbnail[$id][0]['url'] : null;
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

	/**
	 * Get image ID and URL for an image base on passed data.
	 * When imageId is null and articleId is an id of existing page ask image serving for first image's title.
	 * Base on this title generate thumb URL.
	 * When imageId isn't empty ask image serving for thumb URL.
	 * @param int $imageId
	 * @param int $articleId
	 * @return array
	 */
	public static function findImageIdAndUrl( $imageId, $articleId = 0 ) {
		$url = null;
		$imageTitle = null;

		if ( empty( $imageId ) ) {
			$imageId = null;
			if ( !empty( $articleId ) ) {
				$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
				if ( $imageTitle instanceof Title && $imageTitle->exists() ) {
					$imageId = $imageTitle->getArticleID();
					$url = self::getUrlFromImageTitle( $imageTitle );
				}
			}
		} else {
			$imageTitle = Title::newFromID( $imageId );
			if ( $imageTitle instanceof Title && $imageTitle->exists() ) {
				$url = self::getUrlFromImageTitle( $imageTitle );
			}
		}

		if ( empty( $url ) ) {
			$url = self::getImageUrl( $imageId );
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
		return ( $imageTitle instanceof Title && $imageTitle->exists() ) ? $imageTitle : null;
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
