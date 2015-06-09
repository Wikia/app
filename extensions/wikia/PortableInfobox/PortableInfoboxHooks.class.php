<?php

class PortableInfoboxHooks {
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( F::app()->checkSkin( 'monobook', $skin ) ) {
			Wikia::addAssetsToOutput( 'portable_infobox_monobook_scss' );
		} else {
			Wikia::addAssetsToOutput( 'portable_infobox_scss' );
		}

		return true;
	}

	static public function onImageServingCollectImages( &$imageNamesArray, $articleTitle ) {
		if ( $articleTitle ) {

			$dataService = new PortableInfoboxDataService();
			$infoboxData = $dataService->getInfoboxDataByTitle( $articleTitle );
			$infoboxImages = $dataService->getImageListFromInfoboxesData( $infoboxData );
			if ( !empty( $infoboxImages ) ) {
				$imageNamesArray = array_merge( $infoboxImages, (array) $imageNamesArray );
			}
		}
		return true;
	}
}
