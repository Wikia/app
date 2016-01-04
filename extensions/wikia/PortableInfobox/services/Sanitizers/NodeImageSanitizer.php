<?php

class NodeImageSanitizer extends NodeSanitizer {
	protected $allowedTags = [ 'a' ];
	protected $selectorsWrappingAllowedFeatures = [ 'sup[@class="reference"]' ];
	protected $selectorsForFullRemoval = [ 'script', 'span[@itemprop="duration"]' ];

	/**
	 * @desc sanitize infobox image caption allowing only for links inside it
	 *
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		$data[ 'caption' ] = $this->sanitizeElementData( $data[ 'caption' ] );

		return $data;
	}
}
