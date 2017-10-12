<?php

class NodeImageSanitizer extends NodeSanitizer {
	protected $allowedTags = [ 'a' ];
	protected $selectorsWrappingTextToPad = [ 'li' ];
	protected $selectorsWrappingAllowedFeatures = [ 'sup[@class="reference"]' ];
	protected $selectorsForFullRemoval = [ 'script', 'span[@itemprop="duration"]', 'a[starts-with(@href, \'javascript:\')]' ];

	/**
	 * @desc sanitize infobox image caption allowing only for links inside it
	 *
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		if ( isset( $data['images'] ) && is_array( $data['images'] ) ) {
			$data['images'] = array_map( function ( $image ) {
				$image['caption'] = $this->sanitizeElementData( $image['caption'] );
				return $image;
			}, $data['images'] );
		} else {
			$caption = $data['caption'] ?? '';
			$data['caption'] = $this->sanitizeElementData( $caption );
		}

		return $data;
	}
}
