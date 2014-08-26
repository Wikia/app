<?php

class ThumbnailController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * @const int Minimum width of thumbnail to show icon link to file page on hover
	 */
	const MIN_INFO_ICON_WIDTH = 100;

	/**
	 * Render core video thumbnail HTML
	 * @requestParam MediaTransformOutput thumb
	 * @requestParam array options - See ThumbnailHelper class for more detail
	 * @responseParam string width
	 * @responseParam string height
	 * @responseParam string linkHref
	 * @responseParam array linkClasses
	 * @responseParam string linkId
	 * @responseParam array linkAttrs
	 * @responseParam string imgSrc
	 * @responseParam string mediaKey
	 * @responseParam string mediaName
	 * @responseParam array imgClass
	 * @responseParam array extraImgAttrs
	 * @responseParam string dataSrc - data-src attribute for image lazy loading
	 * @responseParam string duration (HH:MM:SS)
	 * @responseParam array durationISO
	 * @responseParam string mediaType - 'image' | 'video'
	 */
	public function video() {
		wfProfileIn( __METHOD__ );

		$thumb = $this->getVal( 'thumb' );
		$options = $this->getVal( 'options', array() );

		ThumbnailHelper::setVideoLinkClasses( $this, $thumb, $options );
		ThumbnailHelper::setVideoLinkAttribs( $this, $thumb, $options );
		ThumbnailHelper::setVideoImgAttribs( $this, $thumb, $options );
		ThumbnailHelper::setExtraImgAttribs( $this, $options );
		ThumbnailHelper::setExtraLinkAttribs( $this, $options );

		// Set duration
		// The file is not always an instance of a class with magic getters implemented. see VID-1753
		$file = $thumb->file;
		if ( is_callable( [$file, 'getMetadataDuration'] ) ) {
			$duration = $file->getMetadataDuration();
		} else {
			$duration = null;
		}

		$this->duration = WikiaFileHelper::formatDuration( $duration );
		$this->mediaType = 'video';

		$lazyLoaded = ThumbnailHelper::setLazyLoad( $this, $options );
		if ( !$lazyLoaded ) {
			// Only add RDF metadata when the thumb is not lazy loaded
			$this->rdf = true;
			if ( !empty( $duration ) ) {
				$this->durationISO = WikiaFileHelper::formatDurationISO8601( $duration );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render core image thumbnail HTML
	 * @requestParam MediaTransformOutput thumb
	 * @requestParam array options - See ThumbnailHelper class for more detail
	 */
	public function image() {
		$this->mediaType = 'image';

		$thumb   = $this->getVal( 'thumb' );
		$options = $this->getVal( 'options', array() );

		ThumbnailHelper::setImageLinkAttribs( $this, $thumb, $options );
		ThumbnailHelper::setImageAttribs( $this, $thumb, $options );
		ThumbnailHelper::setImageLinkClasses( $this, $options );
		ThumbnailHelper::setExtraImgAttribs( $this, $options );
		ThumbnailHelper::setExtraLinkAttribs( $this, $options );
		ThumbnailHelper::setLazyLoad( $this, $options );
	}

	/**
	 * Render image tags for the MediaGallery
	 * @requestParam MediaTransformOutput thumb
	 */
	public function gallery() {
		$this->mediaType = 'image';

		$thumb = $this->getVal( 'thumb' );

		// Use the image template
		$this->overrideTemplate( 'image' );

		$this->linkHref = $thumb->file->getTitle()->getLinkURL();
		ThumbnailHelper::setImageAttribs( $this, $thumb, [ 'fluid' => true ] );
		ThumbnailHelper::setLazyLoad( $this );
	}

	/**
	 * Render the img tag for images, videos, and noscript tags in the case of lazy loading
	 */
	public function imgTag() {
		$this->response->setData( $this->request->getParams() );
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