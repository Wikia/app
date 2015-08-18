<?php

class CuratedContentValidator {
	const LABEL_MAX_LENGTH = 48;

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

	private $errors;
	private $existingSectionLabels;
	private $existingItemLabels;
	private $existingFeaturedItemLabels;
	private $hasOptionalSection;

	public function __construct() {
		$this->reset();
	}

	public function reset() {
		$this->errors = [ ];
		$this->existingSectionLabels = [ ];
		$this->existingItemLabels = [ ];
		$this->existingFeaturedItemLabels = [ ];
		$this->hasOptionalSection = false;
	}

	public function validateData( $data ) {
		$this->reset();

		// validate sections
		foreach ( $data as $section ) {
			if ( !empty( $section['featured'] ) ) {
				$this->validateItems( $section, true );
			} else {
				$this->validateSection( $section );
				$this->validateItemsExist( $section );
				$this->validateItems( $section );
				$this->validateItemsTypes( $section );
			}
		}
		// also check for duplicate labels
		$this->validateDuplicatedLabels();

		return $this->errors;
	}

	public function validateDuplicatedLabels() {
		foreach ( array_count_values( $this->existingFeaturedItemLabels ) as $label => $count ) {
			if ( $count > 1 ) {
				$this->error( $label, 'featured', self::ERR_DUPLICATED_LABEL );
			}
		}
		foreach ( array_count_values( $this->existingSectionLabels ) as $label => $count ) {
			if ( $count > 1 ) {
				$this->error( $label, 'section', self::ERR_DUPLICATED_LABEL );
			}
		}
		foreach ( array_count_values( $this->existingItemLabels ) as $label => $count ) {
			if ( $count > 1 ) {
				$this->error( $label, 'item', self::ERR_DUPLICATED_LABEL );
			}
		}
	}

	public function getErrors() {
		return $this->errors;
	}

	private function error( $labelOrTitle, $type, $errorString ) {
		if ( !empty( $errorString ) ) {
			$this->errors[] = [ 'target' => $labelOrTitle, 'type' => $type, 'reason' => $errorString ];
		}
	}

	public function validateFeaturedSectionItems( $section ) {
		if ( !empty( $section['items'] ) && is_array( $section['items'] ) ) {
			foreach ($section['items'] as $item) {
				$this->validateItem( $item );
			}
		}
	}

	private function validateImage( $sectionOrItem, $isFeatured = false ) {
		if ( empty( $sectionOrItem['image_id'] ) ) {
			if ( $isFeatured ) {
				// featured item has missing image
				$this->error( $sectionOrItem['label'], 'featured', self::ERR_IMAGE_MISSING );
			} elseif ( array_key_exists( 'label', $sectionOrItem ) ) {
				// item has missing image
				$this->error( $sectionOrItem['label'], 'item', self::ERR_IMAGE_MISSING );
			} else {
				// section has missing image
				$this->error( $sectionOrItem['title'], 'section', self::ERR_IMAGE_MISSING );
			}
		}
	}

	public function validateItemsExist( $section ) {
		// only non-optional, non-featured section has mandatory items
		if ( ( empty( $section['featured'] ) && !empty( $section['title'] ) ) &&
			( empty( $section['items'] ) || !is_array( $section['items'] ) ) )
			{
			$this->error( $section['title'], 'section', self::ERR_ITEMS_MISSING );
		}
	}

	public function validateItems( $section, $isFeatured = false ) {
		if ( !empty($section['items'] ) && is_array( $section['items'] ) ) {
			foreach ($section['items'] as $item) {
				$this->validateItem( $item, $isFeatured );
			}
		}
	}

	public function validateSection( $section ) {
		// check for "optional" section - it has empty label, but there can be only ONE
		if ( empty( $section['title'] ) ) {
			if ( $this->hasOptionalSection ) {
				$this->error( $section['title'], 'section', self::ERR_DUPLICATED_LABEL );
			} else {
				$this->hasOptionalSection = true;
			}
		}

		if ( strlen( $section['title'] ) > self::LABEL_MAX_LENGTH ) {
			$this->error( $section['title'], 'section', self::ERR_TOO_LONG_LABEL );
		}

		if ( empty( $section['featured'] ) && !empty( $section['title'] ) ) {
			$this->validateImage( $section );
			// label for section is the same as it's title
			$this->existingSectionLabels[] = $section['title'];
		}
	}

	public function validateItemType( $item ) {
		if ( $item['type'] !== CuratedContentHelper::STR_CATEGORY ) {
			$this->error( $item['label'], 'item', self::ERR_NO_CATEGORY_IN_TAG );
		}
	}

	public function validateItemsTypes( $section ) {
		if ( !empty( $section['items'] ) && is_array( $section['items'] ) ) {
			foreach ( $section['items'] as $item ) {
				$this->validateItemType( $item );
			}
		}
	}

	public function validateItem( $item, $isFeatured = false ) {
		$this->validateImage( $item, $isFeatured );
		$type = $isFeatured ? 'featured' : 'item';

		if ( empty( $item['label'] ) ) {
			$this->error( '', $type, self::ERR_EMPTY_LABEL );
		}

		if ( strlen( $item['label'] ) > self::LABEL_MAX_LENGTH ) {
			$this->error( $item['label'], $type, self::ERR_TOO_LONG_LABEL );
		}

		if ( empty( $item['type'] ) ) {
			$this->error( $item['label'], $type, self::ERR_NOT_SUPPORTED_TYPE );
		}

		if ( self::needsArticleId( $item['type'] ) && empty( $item['article_id'] ) ) {
			$this->error( $item['label'], $type, self::ERR_ARTICLE_NOT_FOUND );
		}

		if ( $isFeatured ) {
			if ( $item['type'] === CuratedContentHelper::STR_VIDEO ) {
				if ( empty( $item['video_info'] ) ) {
					$this->error( $item['label'], 'featured', self::ERR_VIDEO_WITHOUT_INFO );
				} elseif ( !self::isSupportedProvider( $item['video_info']['provider'] ) ) {
					$this->error( $item['label'], 'featured', self::ERR_VIDEO_NOT_SUPPORTED );
				}
			}

			$this->existingFeaturedItemLabels[] = $item['label'];
		} else {
			$this->existingItemLabels[] = $item['label'];
		}

	}

	private static function needsArticleId( $type ) {
		return !in_array( $type, [CuratedContentHelper::STR_CATEGORY ] );
	}

	private static function isSupportedProvider( $provider ) {
		return ( $provider === 'youtube' ) || ( startsWith( $provider, 'ooyala' ) );
	}
}
