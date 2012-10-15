<?php 
class ImageServingDriverFileNS extends ImageServingDriverMainNS {
	
	function executeGetData($articles) {
		foreach($articles as $value) {
			$title = Title::newFromId( $value );
			if( !empty($title) && $img = wfFindFile( $title ) ) {
				$this->addImagesList($title->getText(), $value, 1);
				$this->addToFiltredList( $title->getText(), 1, $img->getWidth(), $img->getHeight(), $img->getMimeType());
			}
		}
	}
	
}