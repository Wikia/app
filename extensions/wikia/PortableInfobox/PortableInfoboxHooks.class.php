<?php

class PortableInfoboxHooks {
	const PARSER_TAG_GALLERY = 'gallery';

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
			$infoboxImages = PortableInfoboxDataService::newFromTitle( $articleTitle )->getImages();
			if ( !empty( $infoboxImages ) ) {
				$imageNamesArray = array_merge( $infoboxImages, (array)$imageNamesArray );
			}
		}

		return true;
	}

	/**
	 * Store information about raw content of all galleries in article to handle images in infoboxes
	 *
	 * @param $name Parser tag name
	 * @param $marker substitution marker
	 * @param $content raw tag contents
	 * @param $attributes
	 * @param $parser
	 * @param $frame
	 *
	 * @return bool
	 */
	static public function onParserTagHooksBeforeInvoke( $name, $marker, $content, $attributes, $parser, $frame ) {
		if ( $name === self::PARSER_TAG_GALLERY ) {
			\Wikia\PortableInfobox\Helpers\PortableInfoboxDataBag::getInstance()->setGallery( $marker, $content );
		}

		return true;
	}

	static public function onWgQueryPages( &$queryPages = [ ] ) {
		$queryPages[] = [ 'AllinfoboxesQueryPage', 'AllInfoboxes' ];

		return true;
	}

	static public function onAllInfoboxesQueryRecached() {
		F::app()->wg->Memc->delete( wfMemcKey( ApiQueryAllinfoboxes::MCACHE_KEY ) );
		return true;
	}
}
