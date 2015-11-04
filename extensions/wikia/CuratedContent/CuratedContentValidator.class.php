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

	public function validateData( $data ) {

		$errors = [];
		// validate sections
		foreach ( $data as $section ) {
			// todo fix me
		}
		// also check for duplicate labels

		return $errors;
	}

	private static function needsArticleId( $type ) {
		return !in_array( $type, [ CuratedContentHelper::STR_CATEGORY ] );
	}

	private static function isSupportedProvider( $provider ) {
		return ( $provider === 'youtube' ) || ( startsWith( $provider, 'ooyala' ) );
	}

	public function validateFeaturedItem($item) {
		$errors = [];

		if ( empty( $item['image_id'] )) {
			$errors[] = self::ERR_IMAGE_MISSING;
		};

		if ( self::needsArticleId( $item['type'] ) && empty( $item['article_id'] ) ) {
			$errors[] = self::ERR_ARTICLE_NOT_FOUND;
		}

		if ( empty( $item['label'] ) ) {
			$errors[] = self::ERR_EMPTY_LABEL;
		}

		if ( strlen( $item['label'] ) > self::LABEL_MAX_LENGTH ) {
			$errors[] = self::ERR_TOO_LONG_LABEL;
		}

		if ( empty( $item['type'] ) ) {
			$errors[] = self::ERR_NOT_SUPPORTED_TYPE;
		}

		if ( $item['type'] === CuratedContentHelper::STR_VIDEO ) {
			if ( empty( $item['video_info'] ) ) {
				$errors[] = self::ERR_VIDEO_WITHOUT_INFO;
			} else if ( !self::isSupportedProvider( $item['video_info']['provider'] ) ) {
				$errors[] = self::ERR_VIDEO_NOT_SUPPORTED;
			}
		}

		return $errors;
	}

	public function validateSection( $section ) {
		$errors = [];

		// check for "optional" section - it has empty label, but there can be only ONE
		if ( empty( $section['title'] ) ) {
			$errors[] =  self::ERR_EMPTY_LABEL;
		}

		if ( strlen( $section['title'] ) > self::LABEL_MAX_LENGTH ) {
			$errors[] = self::ERR_TOO_LONG_LABEL;
		}

		if ( empty( $section['image_id'] )) {
			$errors[] = self::ERR_IMAGE_MISSING;
		}

		return $errors;
	}

	public function validateSectionItem( $item ) {
		$errors = [];

		if ( empty( $item['image_id'] )) {
			$errors[] = self::ERR_IMAGE_MISSING;
		}

		if ( empty( $item['label'] ) ) {
			$errors[] =  self::ERR_EMPTY_LABEL;
		}

		if ( strlen( $item['label'] ) > self::LABEL_MAX_LENGTH ) {
			$errors[] = self::ERR_TOO_LONG_LABEL;
		}

		if ( empty( $item['type'] ) ) {
			$errors[] = self::ERR_NOT_SUPPORTED_TYPE;
		} elseif ( $item['type'] !== CuratedContentHelper::STR_CATEGORY ) {
			$errors[] = self::ERR_NO_CATEGORY_IN_TAG;
		}

		if ( self::needsArticleId( $item['type'] ) && empty( $item['article_id'] ) ) {
			$errors[] = self::ERR_ARTICLE_NOT_FOUND;
		}

		return $errors;
	}

	public function validateSectionWithItems( $section ) {
		$errors = [ ];
		$usedLabels = [ ];

		// validate items exist

		if ( empty( $section['items'] ) ) {
			$errors[] = self::ERR_ITEMS_MISSING;
		}

		// validate section
		if ( !empty( $this->validateSection( $section ) ) ) {
			$errors[] = self::ERR_OTHER_ERROR;
		}

		// validate each item
		if ( is_array( $section['items'] ) ) {
			foreach ( $section['items'] as $item ) {
				$usedLabels[] = $item['label'];

				if ( !empty( $this->validateSectionItem( $item ) ) ) {
					$errors[] = self::ERR_OTHER_ERROR;
				}
			}
		}

		// validate duplicated labels
		foreach ( array_count_values( $usedLabels ) as $label => $count ) {
			if ( $count > 1 ) {
				$errors[] = self::ERR_DUPLICATED_LABEL;
			}
		}

		return $errors;
	}
}
