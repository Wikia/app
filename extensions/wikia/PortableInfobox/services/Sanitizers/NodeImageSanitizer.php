<?php

class NodeImageSanitizer extends NodeSanitizer implements NodeTypeSanitizerInterface {
	/**
	 * @desc sanitize infobox image caption allowing only for links inside it
	 *
	 * @param $data
	 * @return mixed
	 */
	public function sanitize( $data ) {
		$data[ 'caption' ] = $this->sanitizeElementData( $data[ 'caption' ], '<a>' );

		return $data;
	}

	protected function sanitizeElementData( $elementText, $allowedTags = null ) {
		return $this->stripUnneededElements( parent::sanitizeElementData( $elementText, $allowedTags ) );
	}
}
