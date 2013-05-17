<?php

/* fake class for replace image gallery in hook*/
class FakeImageGalleryImageServing extends ImageGallery {
	private $in;

	function __construct($in) {
		$this->in = $in;
	}

	function toHTML() {
		$res = "";
		foreach ( $this->in as $imageData ) {
			$file =  $this->getImage($imageData['name']);

			if($file) {
				$res .= " <image mw='".$file->getTitle()->getDBkey()."' /> ";
			}
		}
		return $res;
	}

	private function getImage($nt) {
		wfProfileIn(__METHOD__);

		# Give extensions a chance to select the file revision for us
		$time = $descQuery = false;
		wfRunHooks( 'BeforeGalleryFindFile', array( &$this, &$nt, &$time, &$descQuery ) );

		# Render image thumbnail
		$img = wfFindFile( $nt, $time );
		wfProfileOut(__METHOD__);
		return $img;
	}
}
