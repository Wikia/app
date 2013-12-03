<?php

class VideoThumbnailController extends WikiaController {

	/**
	 * Thumbnail Template
	 * @requestParam File file
	 * @requestParam string url - img src
	 * @requestParam string width
	 * @requestParam string height
	 * @requestParam array options
	 * @responseParam string width
	 * @responseParam string height
	 * @responseParam string linkHref
	 * @responseParam array linkClasses
	 * @responseParam array linkAttrs
	 * @responseParam string size
	 * @responseParam string imgSrc
	 * @responseParam string videoKey
	 * @responseParam string videoName
	 * @responseParam array imgClasses
	 * @responseParam array imgAttrs
	 * @responseParam string duration
	 * @responseParam array metaAttrs
	 */
	public function thumbnail() {
		wfProfileIn( __METHOD__ );

		$file = $this->getVal( 'file' );
		$imgSrc = $this->getVal( 'url', '' );
		$width = $this->getVal( 'width', 0 );
		$height = $this->getVal( 'height', 0 );
		$options = $this->getVal( 'options', array() );

		// use mustache for template
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		// default value
		$linkAttribs = [];

		// get id for a tag
		if ( !empty( $options['id'] ) ) {
			$linkAttribs['id'] = $options['id'];
		}

		// let extension override any link attributes
		if ( isset( $options['linkAttribs'] ) && is_array( $options['linkAttribs'] ) ) {
			$linkAttribs = array_merge( $linkAttribs, $options['linkAttribs'] );
		}

		// get style for a tag
		if ( array_key_exists( 'constHeight', $options ) ) {
			$linkAttribs['style'] = empty( $linkAttribs['style'] ) ? '' : 'overlay:hidden;';
			if ( $height <= $options['constHeight'] ) {
				$linkAttribs['style'] .= "height:{$height}px;";
				$linkAttribs['style'] .= 'margin-bottom:'.( $options['constHeight'] - $height )."px;";
				$linkAttribs['style'] .= 'padding-top:'.floor( ( $options['constHeight'] - $height )/2 )."px;";
			} else {
				$linkAttribs['style'] .= "height:{$options['constHeight']}px;";
			}
		}

		// get class for a tag
		$linkClasses = ['video'];
		if ( empty( $options['noLightbox'] ) ) {
			$linkClasses[] = 'image';
			$linkClasses[] = 'lightbox';
		}

		if ( !empty( $linkAttribs['class'] ) ) {
			if ( !is_array( $linkAttribs['class'] ) ) {
				$linkAttribs['class'] = explode( ' ', $linkAttribs['class'] );
			}

			$linkClasses = array_merge( $linkClasses, $linkAttribs['class'] );
			unset( $linkAttribs['class'] );
		}

		// hide play button
		if ( !empty( $options['hideOverlay'] ) ) {
			$linkClasses[] = 'hide-play';
		}

		$title = $file->getTitle();

		// get href for a tag
		$linkHref = $title->getLocalURL();

		// this is used for video thumbnails on file page history tables to insure you see the older version of a file when thumbnail is clicked.
		if ( $file instanceof OldLocalFile ) {
			$archive_name = $this->file->getArchiveName();
			if ( !empty( $archive_name ) ) {
				$linkHref .= '?t='.$file->getTimestamp();
				$linkAttribs['data-timestamp'] = $file->getTimestamp();
			}
		}

		// update src for img tag
		if ( !empty( $options['src'] ) ) {
			$imgSrc = $options['src'];
		}

		// get class for img tag
		$imgClasses = [ 'wikia-video-thumb' ];	// used to be 'Wikia-video-thumb'
		if ( !empty( $options['img-class'] ) ) {
			if ( !is_array( $options['img-class'] ) ) {
				$options['img-class'] = explode( ' ', $options['img-class'] );
			}

			$imgClasses = array_merge( $imgClasses, $options['img-class'] );
		}

		// get alt for img tag
		$imgAttribs['alt'] = empty( $options['alt'] ) ? '' : $options['alt'];

		// lazy loading
		if ( !empty( $options['usePreloading'] ) ) {
			$imgAttribs['data-src'] = $imgSrc;
		}

		// set valign for img tag
		$imgAttribs['style'] = '';
		if ( !empty( $options['valign'] ) ) {
			$imgAttribs['style'] .= "vertical-align: {$options['valign']}";
		}

		// add extra border
		if ( $file instanceof WikiaLocalFile || $file instanceof WikiaForeignDBFile ) {
			$extraBorder = $file->addExtraBorder( $width );
			if ( !empty( $extraBorder ) ) {
				$imgAttribs['style'] .= 'border-top: 15px solid black; border-bottom: '.$extraBorder.'px solid black;';
			}
		}

		// get extra style for img tag
		if ( !empty( $options['imgExtraStyle'] ) ) {
			$imgAttribs['style'] .= $options['imgExtraStyle'];
		}

		// remove style from $imgAttribs if it is empty
		if ( $imgAttribs['style'] == '' ) {
			unset( $imgAttribs['style'] );
		}

		// set duration
		$duration = empty( $options['duration'] ) ? 0 : $file->getMetadataDuration();
		$durationAttribs = [];

		$metaAttribs = [];

		// disable RDF metadata in video thumbnails
		if ( empty( $options['disableRDF'] ) ) { // bugId: #46621
			// link
			$linkAttribs['itemprop'] = 'video';
			$linkAttribs['itemscope'] = '';
			$linkAttribs['itemtype'] = 'http://schema.org/VideoObject';

			// image
			$imgAttribs['itemprop'] = 'thumbnail';

			//duration
			if ( !empty( $duration ) ) {
				$durationAttribs['itemprop'] = 'duration';
				$metaAttribs[] = [
					'itemprop' => 'duration',
					'content' => WikiaFileHelper::getISO8601Duration( $duration ),
				];
			}
		}

		// check responsive
		if ( empty( $options[ 'responsive' ] ) ) {
			$width = $width.'px';
			$height = $height.'px';
		} else {
			$width = 0;
			$height = 0;
			$linkClasses[] = 'responsive';
		}

		// set width and height
		$this->width = $width;
		$this->height = $height;

		// set link attributes
		$this->linkHref = $linkHref;
		$this->linkClasses = array_unique( $linkClasses );
		$this->linkAttrs = $this->getAttribs( $linkAttribs );
		$this->size = $this->getThumbnailSize( $width );

		// set image attributes
		$this->imgSrc = $imgSrc;
		$this->videoKey = htmlspecialchars( urlencode( $title->getDBKey() ) );
		$this->videoName = htmlspecialchars( urlencode( $title->getText() ) );
		$this->imgClasses = array_unique( $imgClasses );
		$this->imgAttrs = $this->getAttribs( $imgAttribs );

		// set duration
		$this->duration = WikiaFileHelper::formatDuration( $duration );
		$this->durationAttrs = $this->getAttribs( $durationAttribs );

		// set meta
		$this->metaAttrs = $metaAttribs;

		wfProfileOut( __METHOD__ );
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
		if ( $width < 200 ) {
			$size = 'xsmall';
		} else if ( $width < 270 ) {
			$size = 'small';
		} else if ( $width < 470 ) {
			$size = 'medium';
		} else if ( $width < 720 ) {
			$size = 'large';
		} else {
			$size = 'xlarge';
		}

		return $size;
	}

}