<?php

class VideoThumbnailController extends WikiaController {

	public function thumbnail() {
		// use mustache for template
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$options = $this->getVal( 'options' );
		$file = $this->getVal( 'file' );
		$videoTitle = $file->getTitle();

		// flags
		$rdf = empty( $options[ 'disableRDF' ] );

		// set link attributes
		$this->linkHref = $videoTitle->getLocalURL();
		$this->linkClasses = [];
		$this->size = "medium";

		// set image attributes
		$this->videoKey = htmlspecialchars( urlencode( $videoTitle->getDBKey() ) );
		$this->videoName = htmlspecialchars( urlencode( $videoTitle->getText() ) );
		$this->imgSrc = $this->getVal( 'url' );

		// If responsive flag is not specified, set the width and height of the image
		// This is not related to wgOasisResponsiv
		$options[ 'responsive' ] = 1; // just for now
		if( empty( $options[ 'responsive' ] ) ) {
			// hard coded width and height - get this from toHtml
			$this->imgWidth = '300px';
			$this->imgHeight = '200px';
		} else {
			$this->linkClasses[] = 'responsive';
		}

		// set duration
		$this->duration = '3:46';
	}

	/*
	 * FIXME: Mustache doesn't handle key/value pairs very well, so this is one way we can handle image and link attributes.
	 * Just messing around for now.
	 */
	public function thumbnailAttrs() {
		$attrs = $this->getVal( 'attrs' );
		$resp = [];

		foreach( $attrs as $key => $val ) {
			$curr = [];
			$curr[ 'property' ] = $key;
			$curr[ 'value' ] = $val;
			$resp[] = $curr;
		}

		$this->attrs = $resp;
	}

}