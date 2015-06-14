<?php
class ImageServingDriverFileNS extends ImageServingDriverMainNS {

	function loadFromDb( $articleIds ) {
		foreach ( $articleIds as $articleId ) {
			$title = Title::newFromId( $articleId );
			if ( !empty( $title ) && $img = wfFindFile( $title ) ) {
				$this->addImage( $title->getText(), $articleId, 1 );
				$this->addImageDetails( $title->getText(), 1, $img->getWidth(), $img->getHeight(), $img->getMimeType() );
			}
		}
	}

}