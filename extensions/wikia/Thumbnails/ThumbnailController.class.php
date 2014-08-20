<?php

class ThumbnailController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * @const int Minimum width of thumbnail to show icon link to file page on hover
	 */
	const MIN_INFO_ICON_WIDTH = 100;

	/**
	 * Thumbnail Template
	 * @requestParam MediaTransformOutput thumb
	 * @requestParam array options
	 *	Keys:
	 *      alt - alt for image
	 *      fluid - image will take the width of it's container
	 *      forceSize - 'xsmall' | 'small' | 'medium' | 'large' | 'xlarge'
	 *      hidePlayButton - hide play buttonforceSize - 'xsmall' | 'small' | 'medium' | 'large' | 'xlarge'
	 *      id - id for link
	 *      imgClass - string of space separated classes for image
	 *      ???used??? linkAttribs - link attributes [ array( 'class' => 'video' ) ]
	 *      noLightbox - not show image or video in lightbox,
	 *      ???used??? src - source for image
	 *
	 * @responseParam string width
	 * @responseParam string height
	 * @responseParam string linkHref
	 * @responseParam array linkClasses
	 * @responseParam string linkId
	 * @responseParam array linkAttrs
	 * @responseParam string size [ xsmall, small, medium, large, xlarge ]
	 * @responseParam string imgSrc
	 * @responseParam string mediaKey
	 * @responseParam string mediaName
	 * @responseParam array imgClass
	 * @responseParam array imgAttrs
	 *	Keys:
	 *		alt - alt for image
	 *		itemprop - for RDF metadata
	 * @responseParam string dataSrc - data-src attribute for image lazy loading
	 * @responseParam string duration (HH:MM:SS)
	 * @responseParam array durationAttrs
	 *	Keys:
	 *		itemprop - for RDF metadata
	 * @responseParam array metaAttrs - for RDF metadata [ array( array( 'itemprop' => '', 'content' => '' ) ) ]
	 * @responseParam string mediaType - 'image' | 'video'
	 */
	public function video() {
		wfProfileIn( __METHOD__ );

		$thumb   = $this->getVal( 'thumb' );
		$options = $this->getVal( 'options', array() );

		ThumbnailHelper::setVideoLinkClasses( $this, $thumb, $options );
		ThumbnailHelper::setVideoLinkAttribs( $this, $thumb, $options );
		ThumbnailHelper::setVideoImgAttribs( $this, $thumb, $options );

		// set duration
		// The file is not always an instance of a class with magic getters implemented. see VID-1753
		$file = $thumb->file;
		if ( is_callable( [$file, 'getMetadataDuration'] ) ) {
			$duration = $file->getMetadataDuration();
		} else {
			$duration = null;
		}

		$this->duration = WikiaFileHelper::formatDuration( $duration );
		$this->mediaType = 'video';

		// data-src attribute in case of lazy loading
		$this->noscript = '';
		$this->dataSrc = '';

		if ( ThumbnailHelper::shouldLazyLoad( $this, $options ) ) {
			$this->noscript = $this->app->renderView(
				'ThumbnailController',
				'imgTag',
				$this->response->getData()
			);
			ImageLazyLoad::setLazyLoadingAttribs( $this );
		} else {
			// Only add RDF metadata when the thumb is not lazy loaded
			$this->rdf = true;
			if ( !empty( $duration ) ) {
				$this->durationISO = WikiaFileHelper::formatDurationISO8601( $duration );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function imgTag() {
		$this->response->setData( $this->request->getParams() );
	}

	/**
	 * Image controller
	 * @requestParam MediaTransformOutput thumb
	 * @requestParam array options
	 *	Keys:
	 * 		alt
	 * 		custom-target-link
	 * 		custom-title-link
	 * 		custom-url-link
	 * 		desc-query
	 * 		desc-link
	 * 		file-link
	 *	 	img-class
	 * 		title
	 * 		valign
	 */
	public function image() {
		$this->mediaType = 'image';

		/** @var MediaTransformOutput $thumb */
		$thumb   = $this->getVal( 'thumb' );
		$options = $this->getVal( 'options', array() );

		$linkAttrs   = ThumbnailHelper::getImageLinkAttribs( $thumb, $options );
		$attribs     = ThumbnailHelper::getImageAttribs( $thumb, $options );

		$this->imgSrc = $thumb->url;

		// Merge in imgClass as well
		if ( !empty( $options['img-class'] ) ) {
			$this->imgClass = explode( ' ', $options['img-class'] );
		} else {
			$this->imgClass = [];
		}

		$this->noscript = '';
		$this->dataSrc = '';

		# Move the href out of the attrs and into its own value
		$this->linkHref = empty( $linkAttrs['href'] ) ? null : $linkAttrs['href'];
		unset( $linkAttrs['href'] );

		$this->linkAttrs = ThumbnailHelper::getAttribs( $linkAttrs );
		$this->imgAttrs  = ThumbnailHelper::getAttribs( $attribs );
		$this->linkClasses = ThumbnailHelper::getImageLinkClasses( $options );

		$file = $thumb->file;
		$title = $file->getTitle();
		$this->mediaKey = htmlspecialchars( $title->getDBKey() );
		$this->mediaName = htmlspecialchars( $title->getText() );
		$this->alt = $attribs['alt'];

		// Check fluid
		if ( empty( $options[ 'fluid' ] ) ) {
			$this->imgWidth = $thumb->width;
			$this->imgHeight = $thumb->height;
		}

		// Set a positive flag for whether we need to lazy load
		$options['src'] = $this->imgSrc;
		$lazyLoad = ThumbnailHelper::shouldLazyLoad( $this, $options );

		if ( $lazyLoad ) {
			$this->noscript = $this->app->renderView(
				'ThumbnailController',
				'imgTag',
				$this->response->getData()
			);
			ImageLazyLoad::setLazyLoadingAttribs( $this );
		}
	}

	/**
	 * Article figure tags with thumbnails inside. All videos and block images use this.
	 */
	public function articleBlock() {
		wfProfileIn( __METHOD__ );

		$file = $this->getVal( 'file' );
		$width = $this->getVal( 'outerWidth' );
		$url = $this->getVal( 'url' );
		$align = $this->getVal( 'align' );
		$thumbnail = $this->getVal( 'html' );
		$caption = $this->getVal( 'caption' );

		// align classes are prefixed by "t"
		$alignClass = "t" . $align;

		// only show titles for videos
		$title = '';
		$filePageLink = false;
		if ( $file instanceof File ) {
			$isVideo = WikiaFileHelper::isVideoFile( $file );
			if ( $isVideo ) {
				$title = $file->getTitle()->getText();
			}
			$filePageLink = $file->getTitle()->getLocalURL();
		}

		$this->thumbnail = $thumbnail;
		$this->title = $title;
		$this->figureClass = $alignClass;
		$this->url = $url;
		$this->caption = $caption;
		$this->width = $width;
		$this->showInfoIcon = !empty( $filePageLink ) && $width >= self::MIN_INFO_ICON_WIDTH;
		$this->filePageLink = $filePageLink;

		wfProfileOut( __METHOD__ );
	}
}
