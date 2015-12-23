<?php

class NodeTitleSanitizer extends NodeSanitizer implements NodeTypeSanitizerInterface {
	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		$data[ 'value' ] = $this->sanitizeElementData( $data[ 'value' ] );

		return $data;
	}
}
