<?php

class NodeHeroImageSanitizer extends NodeSanitizer {
	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		if ( !empty( $data[ 'title' ][ 'value' ] ) ) {
			$data[ 'title' ][ 'value' ] = $this->sanitizeElementData( $data[ 'title' ][ 'value' ] );
		}

		return $data;
	}
}
