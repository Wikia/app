<?php

class NodeDataSanitizer extends NodeSanitizer {
	protected $allowedTags = [ 'a' ];

	/**
	 * @desc remove all HTML tags but links from data labels.
	 * If label after sanitization became empty because contained only image
	 * do not sanitize it.
	 *
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		$sanitizedLabel = $this->sanitizeElementData( $data[ 'label' ] );

		if ( !empty( $sanitizedLabel) ) {
			$data[ 'label' ] = $sanitizedLabel;
		}

		return $data;
	}
}
