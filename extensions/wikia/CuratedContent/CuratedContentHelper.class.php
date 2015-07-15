<?php

/**
 * CuratedContent Helper
 */
class CuratedContentHelper {
	const STR_ARTICLE = 'article';
	const STR_BLOG = 'blog';
	const STR_FILE = 'file';
	const STR_CATEGORY = 'category';

	const VALIDATE_LABEL_MAX_LENGTH = 48;


	private static function validateSection( $section ) {
		if ( strlen( $section[ 'title' ] ) > self::VALIDATE_LABEL_MAX_LENGTH ) {
			return [
				'title' => $section[ 'title' ],
				'reason' => 'tooLongLabel'
			];
		}

		if ( empty( $section[ 'featured' ] ) && $section[ 'title' ] !== '' && $section[ 'image_id' ] === '0' ) {
			return [
				'title' => $section[ 'title' ],
				'reason' => 'imageMissing'
			];
		}

		if ( !empty( $section[ 'items' ] ) && is_array( $section[ 'items' ] ) ) {
			foreach ( $section[ 'items' ] as $item ) {
				if ( $item[ 'image_id' ] === '0' ) {
					return [
						'title' => $item[ 'title' ],
						'reason' => 'imageMissing'
					];
				}
			}
		}
		return [];
	}

	public static function processSaveLogic( $sections ) {
		$err = [ ];
		$sectionsAfterProcess = [ ];
		if ( !empty( $sections ) ) {
			foreach ( $sections as $section ) {
				$sectionErr = self::validateSection( $section );
				if ( sizeof( $sectionErr ) ) {
					$err = array_merge( $err, $sectionErr );
				}
				list( $newSection, $sectionErr ) = self::processTagBeforeSave( $section, $err );
				// Don't push to output array featured section without items
				if ( empty( $section['featured'] ) || !empty( $section['items'] ) ) {
					array_push( $sectionsAfterProcess, $newSection );
					$err = array_merge( $err, $sectionErr );
				}
			}
		}
		return empty( $err ) ? $ $sectionsAfterProcess : $err[0];
	}

	private static function processTagBeforeSave( $section, $err ) {
		$errFromTag = [ ];
		$section[ 'image_id' ] = (int)$section[ 'image_id' ];
		if ( !empty( $section[ 'items' ] ) ) {
			list( $section, $sectionErr ) = self::processSection( $section );
			if ( !empty( $sectionErr ) ) {
				$errFromTag = array_merge( $errFromTag, $sectionErr );
			}
		}
		return [ $section, $errFromTag ];
	}

	private static function processSection( $section ) {
		$sectionErr = [ ];
		foreach ( $section[ 'items' ] as &$row ) {
			list( $articleId, $namespaceId, $type, $info, $imageId ) = self::getInfoFromRow( $row );
			$row[ 'article_id' ] = $articleId;
			$row[ 'type' ] = $type;
			$row[ 'image_id' ] = $imageId;
			if ( !empty( $info ) ) {
				$row[ 'video_info' ] = $info;
			}
			$reason = self::checkForErrors( $row, $type, $articleId, $info, $section[ 'featured' ] );
			if ( !empty( $reason ) ) {
				$rowErr = [ ];
				$rowErr[ 'title' ] = $row[ 'title' ];
				$rowErr[ 'reason' ] = $reason;
				$sectionErr[ ] = $rowErr;
			}
		}
		return [ $section, $sectionErr ];
	}

	private static function checkForErrors( $row, $type, $articleId, $info, $isFeatured ) {
		$reason = '';
		if ( empty( $row[ 'label' ] ) ) {
			$reason = 'emptyLabel';
		}
		if ( strlen( $row[ 'label' ] ) > self::VALIDATE_LABEL_MAX_LENGTH ) {
			$reason = 'tooLongLabel';
		}

		if ( $type == null ) {
			$reason = 'notSupportedType';
		}

		if ( $type === 'video' ) {
			if ( empty( $info ) ) {
				$reason = 'videoNotHaveInfo';
			} elseif ( self::isSupportedProvider( $info['provider'] ) ) {
				$reason = 'videoNotSupportProvider';
			}
		}

		if ( !(bool)$isFeatured && $type !== 'category' ) {
			$reason = 'noCategoryInTag';
		}

		if ( self::needsArticleId( $type ) && $articleId === 0 ) {
			$reason = 'articleNotFound';
		}
		return $reason;
	}

	private static function getInfoFromRow( $row ) {
		$title = Title::newFromText( $row[ 'title' ] );
		if ( !empty( $title ) ) {
			$articleId = $title->getArticleId();
			$namespaceId = $title->getNamespace();
			$type = self::getTypeFromNamespaceId( $namespaceId );
			$image_id = (int)$row[ 'image_id' ];
			$info = [ ];

			switch ( $type ) {
				case self::STR_FILE :
					list( $type, $info ) = self::getVideoInfo( $title );
					break;

				case self::STR_CATEGORY:
					$category = Category::newFromTitle( $title );
					if ( !empty( $category ) ) {
						$count = $category->getPageCount();
						if ( empty( $count ) ) {
							$type = 'emptyCategory';
						}
					}
					break;
			}
			if ( $image_id === 0 ) {
				$imageTitle = self::findFirstImageTitleFromArticle( $articleId );
				if ( !empty( $imageTitle ) ) {
					$image_id = $imageTitle->getArticleId();
				}
			}

			return [
				$articleId,
				$namespaceId,
				$type,
				$info,
				$image_id
			];
		}
		return [ null, null, null, null, null ];
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
				$type = 'video';
				$provider = $mediaInfo [ 'meta' ][ 'provider' ];
				$thumbUrl = $mediaInfo [ 'thumbUrl' ];
				$videoId = $mediaInfo[ 'meta' ][ 'videoId' ];
				return [ $type, [
					'provider' => $provider,
					'thumb_url' => $thumbUrl,
					'videoId' => $videoId
				]
				];
			}
		}
		return [ null, null ];
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
