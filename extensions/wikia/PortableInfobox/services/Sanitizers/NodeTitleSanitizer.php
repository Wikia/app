<?php

class NodeTitleSanitizer extends NodeSanitizer {
	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		$data[ 'value' ] = $this->sanitizeElementData( $data[ 'value' ] );

		return $data;
	}
}
