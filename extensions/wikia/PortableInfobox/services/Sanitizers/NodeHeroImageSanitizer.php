<?php

class NodeHeroImageSanitizer extends NodeSanitizer {
	protected $allowedTags = [ 'a' ];
	protected $selectorsWrappingTextToPad = [ 'li' ];
	protected $selectorsWrappingAllowedFeatures = [ 'sup[@class="reference"]' ];
	protected $selectorsForFullRemoval = [ 'script', 'span[@itemprop="duration"]' ];

	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		if ( !empty( $data[ 'title' ][ 'value' ] ) ) {
			$data[ 'title' ][ 'value' ] = $this->sanitizeElementData( $data[ 'title' ][ 'value' ] );
		}
		if ( !empty( $data[ 'image' ][ 'caption' ] ) ) {
			$data[ 'image' ]['caption'] = $this->sanitizeElementData( $data[ 'image' ]['caption'] );
		}

		return $data;
	}
}
