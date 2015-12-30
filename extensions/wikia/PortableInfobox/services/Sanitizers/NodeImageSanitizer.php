<?php

class NodeImageSanitizer extends NodeSanitizer {
	protected $fullyAllowedTags = [ 'sup[@class="reference"]' ];
	protected $fullyRemovedTags = [ 'script', 'span[@itemprop="duration"]' ];

	/**
	 * @desc sanitize infobox image caption allowing only for links inside it
	 *
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		$data[ 'caption' ] = $this->sanitizeElementData( $data[ 'caption' ], [ 'a' ] );

		return $data;
	}
}
