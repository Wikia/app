<?php

class ThumbnailVideoController extends WikiaController {

	/**
	 * Thumbnail Template
	 * @requestParam File file
	 * @requestParam string url - img src
	 * @requestParam string width
	 * @requestParam string height
	 * @requestParam array options
	 *	Keys:
	 *		id - id for link,
	 *		linkAttribs - link attributes [ array( 'class' => 'video' ) ]
	 *		noLightbox - not show image or video in lightbox,
	 *		hidePlayButton - hide play button
	 *		src - source for image
	 *		imgClass - string of space separated classes for image
	 *		alt - alt for image
	 *		usePreloading - for lazy loading
	 *		valign - valign for image
	 *		imgExtraStyle - extra style for image
	 *		disableRDF - disable RDF metadata
	 *		fluid - image will take the width of it's container
	 *		forceSize - 'xsmall' | 'small' | 'medium' | 'large' | 'xlarge'
	 * @responseParam string width
	 * @responseParam string height
	 * @responseParam string linkHref
	 * @responseParam array linkClasses
	 * @responseParam array linkAttrs
	 *	Keys:
	 *		id - id attribute for link,
	 *		class - class of link attributes
	 *		data-timestamp - timestamp of the file
	 *		itemprop - for RDF metadata
	 *		itemscope - for RDF metadata
	 *		itemtype - for RDF metadata
	 * @responseParam string size [ xsmall, small, medium, large, xlarge ]
	 * @responseParam string imgSrc
	 * @responseParam string videoKey
	 * @responseParam string videoName
	 * @responseParam array imgClass
	 * @responseParam array imgAttrs
	 *	Keys:
	 *		alt - alt for image
	 *		style - style for image
	 *		itemprop - for RDF metadata
	 * @responseParam string dataSrc - data-src attribute for image lazy loading
	 * @responseParam string duration (HH:MM:SS)
	 * @responseParam array durationAttrs
	 *	Keys:
	 *		itemprop - for RDF metadata
	 * @responseParam array metaAttrs - for RDF metadata [ array( array( 'itemprop' => '', 'content' => '' ) ) ]
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
		$this->response->getView()->setTemplatePath( dirname(__FILE__) . '/templates/mustache/thumbnailVideo.mustache' );


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
		if ( !empty( $options['hidePlayButton'] ) ) {
			$linkClasses[] = 'hide-play';
		}

		/** @var Title $title */
		$title = $file->getTitle();

		// get href for a tag
		$linkHref = $title->getFullURL();

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

		// get alt for img tag
		$imgAttribs['alt'] = empty( $options['alt'] ) ? '' : $options['alt'];

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
		$duration = $file->getMetadataDuration();
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
					'content' => WikiaFileHelper::formatDurationISO8601( $duration ),
				];
			}
		}

		// data-src attribute in case of lazy loading
		if ( !empty( $options['usePreloading'] ) ) {
			$this->dataSrc = $imgSrc;
		}

		// check fluid
		if ( empty( $options[ 'fluid' ] ) ) {
			$this->imgWidth = $width;
			$this->imgHeight = $height;
		} else {
			$linkClasses[] = 'fluid';
		}

		// set link attributes
		$this->linkHref = $linkHref;
		$this->linkClasses = array_unique( $linkClasses );
		$this->linkAttrs = $this->getAttribs( $linkAttribs );

		if ( !empty( $options['forceSize'] ) ) {
			$this->size = $options['forceSize'];
		} else {
			$this->size = $this->getThumbnailSize( $width );
		}

		// set image attributes
		$this->imgSrc = $imgSrc;
		$this->videoKey = htmlspecialchars( $title->getDBKey() );
		$this->videoName = htmlspecialchars( $title->getText() );
		$this->imgClass = empty( $options['imgClass'] ) ? '' : $options['imgClass'];
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
	 * Don't use this for values that need to be escaped.
	 * Wrap attributes in three curly braces so quote markes don't get escaped.
	 * Ex: {{# attrs }}{{{ . }}} {{/ attrs }}
	 * @param array $attrs [ array( key => value ) ]
	 * @return array [ array( 'key="value"' ) ]
	 */
	protected function getAttribs( $attrs ) {
		$attribs = [];
		foreach ( $attrs as $key => $value ) {
			$str = $key;
			if ( !empty( $value ) ) {
				$str .= "=" . '"' . $value . '"';
			}
			$attribs[] = $str;
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