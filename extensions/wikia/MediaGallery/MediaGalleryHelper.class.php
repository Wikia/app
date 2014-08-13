<?php

class MediaGalleryHelper {

	const DIMENSION_UNIT = 80; // Approximation of column width at optimal break point

	const DIMENSION_MULTIPLE_DEFAULT = 3;

	/**
	 * Maps dimension multiples of items (images) based on count of items
	 * Galleries with image counts of 1 through 7 have customized sizes
	 * Those with more images just go into equal-sized 4-column rows
	 * @var array
	 */
	private static $dimensionMultiples = [
		1 => [6],
		2 => [6, 6],
		3 => [4, 4, 4],
		4 => [3, 3, 3, 3],
		5 => [6, 3, 3, 3, 3],
		6 => [4, 4, 4, 4, 4, 4],
		7 => [4, 4, 4, 3, 3, 3, 3],
	];

	/**
	 * Get dimension of item based on size and its order
	 *
	 * @param int $size
	 * @param int $order
	 * @return int
	 */
	public static function getDimensionBySizeAndOrder( $size, $order ) {
		if ( $size > count( static::$dimensionMultiples ) ) {
			$multiple = self::DIMENSION_MULTIPLE_DEFAULT;
		} else {
			$multiple = self::getDimensionMultiples( $size )[$order];
		}

		return $multiple * self::DIMENSION_UNIT;
	}

	/**
	 * Get the dimensions of items in order
	 *
	 * @param int $itemCount
	 * @return array
	 * @throws InvalidArgumentException
	 */
	public static function getDimensionMultiples( $itemCount ) {
		if ( $itemCount < 1 ) {
			throw new InvalidArgumentException(
				sprintf( "%s itemCount must be integer 1 or greater", __METHOD__ )
			);
		}

		if ( !isset( static::$dimensionMultiples[$itemCount] ) ) {
			return [];
		}

		return static::$dimensionMultiples[$itemCount];
	}


}
