<?php

class CuratedContentValidator {
	const LABEL_MAX_LENGTH = 48;

	const ERR_OTHER_ERROR = 'otherError';
	const ERR_DUPLICATED_LABEL = 'duplicatedLabel';
	const ERR_IMAGE_MISSING = 'imageMissing';
	const ERR_TOO_LONG_LABEL = 'tooLongLabel';
	const ERR_ITEMS_MISSING = 'itemsMissing';
	const ERR_NOT_SUPPORTED_TYPE = 'notSupportedType';
	const ERR_VIDEO_WITHOUT_INFO = 'videoNotHaveInfo';
	const ERR_VIDEO_NOT_SUPPORTED = 'videoNotSupportProvider';
	const ERR_ARTICLE_NOT_FOUND = 'articleNotFound';
	const ERR_EMPTY_LABEL = 'emptyLabel';
	const ERR_NO_CATEGORY_IN_TAG = 'noCategoryInTag';

	/**
	 * This method validates data.
	 * Data are correct when:
	 * 1. Empty data is send - we set it to empty array
	 * 2. Section (including featured and optional) contains items which are not empty array
	 * 3. Label has to be not empty and no longer than 48 characters
	 * 4. Section titles can't duplicate
	 * 5. Image has to be set for items and sections
	 * 6. Items in sections and inside optional section contain only Categories
	 *
	 * @param array $data
	 * @return array
	 */
	public static function validateData( $data ) {
		$errors = [ ];
		$alreadyUsedSectionLabels = [ ];

		// If data is empty or not an array - return empty array.
		// So users have ability to erase all data by sending empty value.
		if ( !is_array( $data ) ) {
			return [ ];
		}

		foreach ( $data as $section ) {
			if ( !empty( $section[ 'featured' ] ) ) {
				if ( !self::validateItemsInFeatured( $section ) ) {
					$errors[] = self::ERR_OTHER_ERROR;
				}
			} else {
				$alreadyUsedSectionLabels[] = $section[ 'label' ];
				// in case of section without title (optional section) validate only items within it
				if ( $section[ 'label' ] === '' ) {
					if ( !self::validateItemsInSection( $section ) ) {
						$errors[] = self::ERR_OTHER_ERROR;
					}
					// in case of regular section validate section and items within it
				} elseif ( !empty( self::validateSectionWithItems( $section ) ) ) {
					$errors[] = self::ERR_OTHER_ERROR;
				}
			}
		}

		if ( !self::areLabelsUnique( $alreadyUsedSectionLabels ) ) {
			$errors[] = self::ERR_DUPLICATED_LABEL;
		}

		return $errors;
	}

	public static function areLabelsUnique( $labelsToCheck ) {
		foreach ( array_count_values( $labelsToCheck ) as $label => $count ) {
			if ( $count > 1 ) {
				return false;
			}
		}
		return true;
	}

	public static function validateFeaturedItem( $item ) {
		$errors = [ ];

		if ( empty( $item[ 'image_id' ] ) ) {
			$errors[] = self::ERR_IMAGE_MISSING;
		}

		// When category is passed as type we don't need article_id set.
		// For instance categories without content on Category: page are valid categories.
		// All remaining types require article_id. In case when article doesn't exist article_id is set to 0
		if ( self::needsArticleId( $item[ 'type' ] ) && empty( $item[ 'article_id' ] ) ) {
			$errors[] = self::ERR_ARTICLE_NOT_FOUND;
		}

		if ( empty( $item[ 'label' ] ) ) {
			$errors[] = self::ERR_EMPTY_LABEL;
		}

		if ( self::hasValidLabel( $item ) ) {
			$errors[] = self::ERR_TOO_LONG_LABEL;
		}

		if ( empty( $item[ 'type' ] ) ) {
			$errors[] = self::ERR_NOT_SUPPORTED_TYPE;
		}

		if ( $item[ 'type' ] === CuratedContentHelper::STR_VIDEO ) {
			if ( empty( $item[ 'video_info' ] ) ) {
				$errors[] = self::ERR_VIDEO_WITHOUT_INFO;
			} elseif ( !self::isSupportedProvider( $item[ 'video_info' ][ 'provider' ] ) ) {
				$errors[] = self::ERR_VIDEO_NOT_SUPPORTED;
			}
		}

		return $errors;
	}

	public static function validateSection( $section ) {
		$errors = [ ];

		if ( empty( $section[ 'label' ] ) ) {
			$errors[] = self::ERR_EMPTY_LABEL;
		}

		if ( strlen( $section[ 'label' ] ) > self::LABEL_MAX_LENGTH ) {
			$errors[] = self::ERR_TOO_LONG_LABEL;
		}

		if ( empty( $section[ 'image_id' ] ) ) {
			$errors[] = self::ERR_IMAGE_MISSING;
		}

		return $errors;
	}

	public static function validateSectionItem( $item ) {
		$errors = [ ];

		if ( empty( $item[ 'image_id' ] ) ) {
			$errors[] = self::ERR_IMAGE_MISSING;
		}

		if ( empty( $item[ 'label' ] ) ) {
			$errors[] = self::ERR_EMPTY_LABEL;
		}

		if ( self::hasValidLabel( $item ) ) {
			$errors[] = self::ERR_TOO_LONG_LABEL;
		}

		if ( empty( $item[ 'type' ] ) ) {
			$errors[] = self::ERR_NOT_SUPPORTED_TYPE;
		} elseif ( $item[ 'type' ] !== CuratedContentHelper::STR_CATEGORY ) {
			$errors[] = self::ERR_NO_CATEGORY_IN_TAG;
		}

		// When category is passed as type we don't need article_id set.
		// For instance categories without content on Category: page are valid categories.
		// All remaining types require article_id. In case when article doesn't exist article_id is set to 0
		if ( self::needsArticleId( $item[ 'type' ] ) && empty( $item[ 'article_id' ] ) ) {
			$errors[] = self::ERR_ARTICLE_NOT_FOUND;
		}

		return $errors;
	}

	public static function validateSectionWithItems( $section ) {
		$errors = [ ];

		// validate items exist
		if ( !self::areItemsCorrect( $section[ 'items' ] ) ) {
			$errors[] = self::ERR_ITEMS_MISSING;
		}

		// validate section
		if ( !empty( self::validateSection( $section ) ) ) {
			$errors[] = self::ERR_OTHER_ERROR;
		}

		// validate each item
		if ( is_array( $section[ 'items' ] ) ) {
			foreach ( $section[ 'items' ] as $item ) {
				if ( !empty( self::validateSectionItem( $item ) ) ) {
					$errors[] = self::ERR_OTHER_ERROR;
				}
			}
		}

		return $errors;
	}

	public static function hasValidLabel( $item ) {
		return strlen( $item[ 'label' ] ) > self::LABEL_MAX_LENGTH;
	}

	private static function validateItemsInFeatured( $section ) {
		if ( !self::areItemsCorrect( $section[ 'items' ] ) ) {
			return false;
		}

		foreach ( $section[ 'items' ] as $featuredItem ) {
			if ( !empty( self::validateFeaturedItem( $featuredItem ) ) ) {
				return false;
			}
		}
		return true;
	}

	private static function validateItemsInSection( $section ) {
		if ( !self::areItemsCorrect( $section[ 'items' ] ) ) {
			return false;
		}

		foreach ( $section[ 'items' ] as $item ) {
			if ( !empty( self::validateSectionItem( $item ) ) ) {
				return false;
			}
		}
		return true;
	}

	private static function needsArticleId( $type ) {
		return !in_array( $type, [ CuratedContentHelper::STR_CATEGORY ] );
	}

	public static function areItemsCorrect( $items ) {
		if ( empty( $items ) || !is_array( $items ) ) {
			return false;
		}
		return true;
	}

	private static function isSupportedProvider( $provider ) {
		return ( $provider === 'youtube' ) || ( startsWith( $provider, 'ooyala' ) );
	}
}
