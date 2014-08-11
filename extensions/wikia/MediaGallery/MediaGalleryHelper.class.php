<?php

class MediaGalleryHelper {

	const DIMENSION_UNIT = 83.333; // 500/6

	private $dimensionMultiples = [
		1 => [6],
		2 => [6, 6],
		3 => [4, 4, 4],
		4 => [3, 3, 3, 3],
		5 => [6, 3, 3, 3, 3],
		6 => [4, 4, 4, 4, 4, 4],
		7 => [4, 4, 4, 3, 3, 3, 3],
		8 => [3, 3, 3, 3, 3, 3, 3, 3],
	];

	/**
	 * Get the dimensions of items in order
	 *
	 * @param int $itemCount
	 * @return array
	 * @throws InvalidArgumentException
	 */
	public function getDimensionMultiples( $itemCount ) {
		if ( !isset( $this->dimensionMultiples[$itemCount] ) ) {
			throw new InvalidArgumentException(
				sprintf( "%s count must be between 1 & %d", __METHOD__, count( $this->dimensionMultiples ) )
			);
		}

		return $this->dimensionMultiples[$itemCount];
	}


}
