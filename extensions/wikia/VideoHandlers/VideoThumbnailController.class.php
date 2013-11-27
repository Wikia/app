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

	/**
	 * Get attributes for mustache template
	 * @param array $attrs [ array( key => value ) ]
	 * @return array $attribs [ array( "key='value'" ) ]
	 */
	protected function getAttribs( $attrs ) {
		$attribs = [];
		foreach ( $attrs as $key => $value ) {
			$attribs[] = "$key='$value'";
		}

		return $attribs;
	}

	/**
	 * Get thumbnail size
	 * @param integer $width
	 * @return string $size
	 */
	protected function getThumbnailSize( $width = 0 ) {
		$size = 'medium';
		if ( $width > 200 && $width <= 270 ) {
			$size = 'small';
		} else if ( $width > 270 && $width <= 470 ) {
			$size = 'medium';
		} else if ( $width > 470 && $width <= 720 ) {
			$size = 'large';
		} else if ( $width > 720 ) {
			$size = 'xlarge';
		}

		return $size;
	}

}
