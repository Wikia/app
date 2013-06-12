<?php

/**
 * Replaces gallery images with ImageServing placeholders
 */
class FakeImageGalleryImageServing extends ImageGallery {
	private $images;

	function __construct($images) {
		$this->images = $images;
	}

	function toHTML() {
		wfProfileIn(__METHOD__);

		$res = "";
		foreach ( $this->images as $imageData ) {
			$title = Title::newFromText($imageData['name'], NS_FILE);

			if (empty($title) || !$title->exists()) {
				continue;
			}

			$file =  $this->getImage($title);
			$res .= ImageServingHelper::getPlaceholder($file);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Get File object out of given Title
	 *
	 * @param Title $nt image title
	 * @return File
	 */
	private function getImage(Title $nt) {
		wfProfileIn(__METHOD__);

		# Give extensions a chance to select the file revision for us
		$time = $descQuery = false;
		wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time, &$descQuery ) );

		# Render image thumbnail
		$img = wfFindFile( $nt, array('time' => $time) );
		wfProfileOut(__METHOD__);
		return $img;
	}
}
