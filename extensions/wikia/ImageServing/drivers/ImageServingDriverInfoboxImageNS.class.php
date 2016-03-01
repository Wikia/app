<?php

/*
 * @author: Diana Falkowska
 *
 * This class is used to get image list from infoboxes only.
 * Manages images which are used only in portable infoboxes.
 */
class ImageServingDriverInfoboxImageNS extends ImageServingDriverMainNS {

	/**
	 * @desc This method overrides loadImagesFromDb from ImageServingDriverMainNS
	 * because in this case we are interested in infobox images only, not in all
	 * images from articles.
	 * @param array $articleIds
	 */
	protected function loadImagesFromDb( $articleIds = [ ] ) {
		wfProfileIn( __METHOD__ );

		$this->loadImagesFromInfoboxes( $articleIds );

		wfProfileOut( __METHOD__ );
	}
}
