<?php 
class ImageServingDriverFileNS extends ImageServingDriverMainNS {
	
	function loadFromDb($articleIds) {
		foreach($articleIds as $value) {
			$title = Title::newFromId( $value );
			if( !empty($title) && $img = wfFindFile( $title ) ) {
				$this->addImage($title->getText(), $value, 1);
				$this->addToFilteredList( $title->getText(), 1, $img->getWidth(), $img->getHeight(), $img->getMimeType());
			}
		}
	}
	
}