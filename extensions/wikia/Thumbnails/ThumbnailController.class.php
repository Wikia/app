<?php

class ThumbnailController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

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
	 * @responseParam array linkAttrs
	 *	Keys:
	 *		id - id attribute for link,
	 *		class - css class
	 *		data-timestamp - timestamp of the file
	 *		itemprop - for RDF metadata
	 *		itemscope - for RDF metadata
	 *		itemtype - for RDF metadata
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

		$this->mediaType = 'video';

		$thumb   = $this->getVal( 'thumb' );
		$options = $this->getVal( 'options', array() );

		$file = $thumb->file;
		$imgSrc = $thumb->url;
		$width = $thumb->width;
		$height = $thumb->height;

		/** @var Title $title */
		$title = $file->getTitle();

		// Prefer the src given in options over what's passed in directly.
		// @TODO there is no reason to pass two versions of image source.  See if both are actually used and pick one
		$options['src'] = empty( $options['src'] ) ? $imgSrc : $options['src'];

		$linkClasses = ThumbnailHelper::getVideoLinkClasses( $options );
		$linkAttribs = ThumbnailHelper::getVideoLinkAttribs( $file, $options );
		$imgAttribs  = ThumbnailHelper::getVideoImgAttribs( $file, $options );

		// get href for a tag
		$linkHref = $title->getFullURL();

		// this is used for video thumbnails on file page history tables to insure you see the older version of a file when thumbnail is clicked.
		if ( $file instanceof OldLocalFile ) {
			$archive_name = $file->getArchiveName();
			if ( !empty( $archive_name ) ) {
				$linkHref .= '?t='.$file->getTimestamp();
			}
		}

		// set duration
		// The file is not always an instance of a class with magic getters implemented. see VID-1753
		if ( is_callable( [$file, 'getMetadataDuration'] ) ) {
			$duration = $file->getMetadataDuration();
		} else {
			$duration = null;
		}
		$durationAttribs = [];
		$metaAttribs = [];

		// Set a positive flag for whether we need to lazy load
		$lazyLoad = $this->shouldLazyLoad( $options );

		// Only add RDF metadata when the thumb is not lazy loaded
		if ( !$lazyLoad ) {
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

		// check fluid
		if ( empty( $options[ 'fluid' ] ) ) {
			$this->imgWidth = $width;
			$this->imgHeight = $height;
		}

		// set link attributes
		$this->linkHref = $linkHref;
		$this->linkClasses = array_unique( $linkClasses );
		$this->linkAttrs = ThumbnailHelper::getAttribs( $linkAttribs );

		if ( !empty( $options['forceSize'] ) ) {
			$this->size = $options['forceSize'];
		} else {
			$this->size = ThumbnailHelper::getThumbnailSize( $width );
		}

		// set image attributes
		$this->imgSrc = $options['src'];
		$this->mediaKey = htmlspecialchars( $title->getDBKey() );
		$this->mediaName = htmlspecialchars( $title->getText() );
		$this->imgClass = empty( $options['imgClass'] ) ? '' : $options['imgClass'];;
		$this->imgAttrs = ThumbnailHelper::getAttribs( $imgAttribs );
		$this->alt = $imgAttribs['alt'];

		// data-src attribute in case of lazy loading
		$this->noscript = '';
		$this->dataSrc = '';

		if ( $lazyLoad ) {
			$this->noscript = $this->app->renderView(
				'ThumbnailController',
				'imgTag',
				$this->response->getData()
			);
			ImageLazyLoad::setLazyLoadingAttribs( $this->dataSrc, $this->imgSrc, $this->imgClass, $this->imgAttrs );
		}

		// set duration
		$this->duration = WikiaFileHelper::formatDuration( $duration );
		$this->durationAttrs = ThumbnailHelper::getAttribs( $durationAttribs );

		// set meta
		$this->metaAttrs = $metaAttribs;

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
			$this->imgClass = $options['img-class'];
		} else {
			$this->imgClass = '';
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
		$lazyLoad = $this->shouldLazyLoad( $options );

		if ( $lazyLoad ) {
			$this->noscript = $this->app->renderView(
				'ThumbnailController',
				'imgTag',
				$this->response->getData()
			);
			ImageLazyLoad::setLazyLoadingAttribs( $this->dataSrc, $this->imgSrc, $this->imgClass, $this->imgAttrs );
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
		$this->showInfoIcon = !empty( $filePageLink ) && ThumbnailHelper::canShowInfoIcon( $width );
		$this->filePageLink = $filePageLink;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Determines by options if image should be lazyloaded
	 * @param array $options
	 * @return bool
	 */
	protected function shouldLazyLoad( array $options ) {
		return (
			empty( $options['noLazyLoad'] )
			&& isset( $options['src'] )
			&& ImageLazyLoad::isValidLazyLoadedImage( $options['src'] )
		);
	}
}
