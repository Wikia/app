<?php

class CuratedContentValidator {
	const VALIDATE_LABEL_MAX_LENGTH = 48;

	private $errors;
	private $titles;
	private $hadEmptyLabel;

	public function __construct( $data ) {
		$this->errors = [];
		$this->titles = [];
		$this->hadEmptyLabel = false;

		// validate sections
		foreach( $data as $section ) {
			if ( !empty( $section['featured'] ) ) {
				$this->validateFeaturedSection( $section );
			} else {
				$this->validateSection( $section );
			}
		}
		// also check section for duplicate title
		foreach( array_count_values( $this->titles ) as $title => $count ) {
			if ( $count > 1 ) {
				$this->error( [ 'title' => $title ], 'duplicatedLabel' );
			}
		}
	}

	private function error( $itemWithTitle, $errorString ) {
		if ( array_key_exists( 'title', $itemWithTitle ) && !empty( $errorString ) ) {
			$this->errors[] = ['title' => $itemWithTitle['title'], 'reason' => $errorString];
		}
	}

	public function getErrors() {
		return $this->errors;
	}

	private function validateFeaturedSection( $section ) {
		foreach ( $section['items'] as $item ) {
			$this->validateItem( $item );
		}
	}

	private function validateImage( $sectionOrItem ) {
		if ( empty( $sectionOrItem['image_id'] ) ) {
			$this->error( $sectionOrItem, 'imageMissing' );
		}
	}

	private function validateSection ( $section ) {
		if ( empty( $section['title'] ) ) {
			if ($this->hadEmptyLabel) {
				$this->error( $section, 'duplicatedLabel' );
			} else {
				$this->hadEmptyLabel = true;
			}
		}

		if ( strlen( $section['title'] ) > self::VALIDATE_LABEL_MAX_LENGTH ) {
			$this->error( $section, 'tooLongLabel' );
		}

		if ( empty( $section['featured'] ) && $section['title'] !== '' ) {
			$this->validateImage( $section );
		}

		if ( !empty( $section['items'] ) && is_array( $section['items'] ) ) {
			foreach ($section['items'] as $item) {
				$this->validateCategoryItem($item);
				$this->validateImage($item);
			}
		} else {
			if ( empty( $section['featured'] ) ) {
				$this->error( $section, 'itemsMissing');
			}
		}

		if ( strlen( $section['title'] ) ) {
			$this->titles[] = $section['title'];
		}
	}

	private function validateCategoryItem( $item ) {
		$this->validateItem( $item );

		if ( $item['type'] !== CuratedContentHelper::STR_CATEGORY ) {
			$this->error( $item, 'noCategoryInTag' );
		}
	}

	private function validateItem( $item ) {
		$this->validateImage( $item );

		if ( empty( $item['label'] ) ) {
			$this->error( $item, 'emptyLabel' );
		}

		if ( strlen( $item['label'] ) > self::VALIDATE_LABEL_MAX_LENGTH ) {
			$this->error( $item, 'tooLongLabel' );
		}

		if ( $item['type'] == null ) {
			$this->error( $item, 'notSupportedType' );
		}

		if ( $item['type'] === 'video' ) {
			if ( empty( $item['info'] ) ) {
				$this->error( $item, 'videoNotHaveInfo' );
			} elseif ( !self::isSupportedProvider( $item['info']['provider'] ) ) {
				$this->error( $item, 'videoNotSupportProvider' );
			}
		}

		if ( self::needsArticleId( $item['type'] ) && empty( $item['article_id'] ) ) {
			$this->error( $item, 'articleNotFound' );
		}

		$this->titles[] = $item['title'];
	}

	private static function needsArticleId( $type ) {
		return $type != CuratedContentHelper::STR_CATEGORY;
	}

	private static function isSupportedProvider( $provider ) {
		return ($provider === 'youtube') || (startsWith( $provider, 'ooyala' ));
	}
}
