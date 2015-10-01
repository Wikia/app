<?php
class ImageServingDriverInfoboxImageNS extends ImageServingDriverMainNS {

	/**
	 * @param array $articleIds
	 */
	protected function loadImagesFromDb( $articleIds = [ ] ) {
		wfProfileIn( __METHOD__ );

		$this->loadImagesFromInfoboxes( $articleIds );

		wfProfileOut( __METHOD__ );
	}
}
