<?php

class NodeHorizontalGroupSanitizer extends NodeSanitizer {
	/**
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		foreach ( $data[ 'labels' ] as $key => $label ) {
			$sanitizedLabel = $this->sanitizeElementData( $label, '<a>' );
			if ( !empty( $sanitizedLabel ) ) {
				$data[ 'labels' ][ $key ] = $sanitizedLabel;
			}
		}

		return $data;
	}
}
