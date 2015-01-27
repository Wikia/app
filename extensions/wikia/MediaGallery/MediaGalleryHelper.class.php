<?php

class MediaGalleryHelper {

	/**
	 * Approximation of column width at optimal break point
	 */
	const COLUMN_WIDTH = 80;

	const COLUMN_SPAN_DEFAULT = 3;

	/**
	 * A mapping of gallery image count to column span size
	 * Galleries with 1-7 image counts have customized span sizes
	 * Those with more images just go into equally-spanned 4-column rows
	 * @var array
	 */
	private static $columnSpans = [
		1 => [6],
		2 => [6, 6],
		3 => [4, 4, 4],
		4 => [3, 3, 3, 3],
		5 => [6, 3, 3, 3, 3],
		6 => [4, 4, 4, 4, 4, 4],
		7 => [4, 4, 4, 3, 3, 3, 3],
	];

	/**
	 * Get image width based on size and its order
	 *
	 * @param int $size
	 * @param int $order
	 * @return int
	 */
	public static function getImageWidth( $size, $order ) {
		if ( !empty( static::$columnSpans[$size][$order] ) ) {
			$span = static::$columnSpans[$size][$order];
		} else {
			$span = self::COLUMN_SPAN_DEFAULT;
		}

		return $span * self::COLUMN_WIDTH;
	}

}
