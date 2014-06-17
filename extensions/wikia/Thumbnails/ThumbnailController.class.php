<?php

class ThumbnailController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function makeThumb() {
		$thumb = $this->getVal( 'thumb' );
		if ( $thumb instanceof ThumbnailVideo ) {
			$handler = 'video';
		} else {
			$handler = 'image';
		}

		// Dispatch to the appropriate handler
		$this->forward( __CLASS__, $handler );
	}

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
	 *		valign - valign for image
	 *		fluid - image will take the width of it's container
	 *		forceSize - 'xsmall' | 'small' | 'medium' | 'large' | 'xlarge'
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
	 * @responseParam string videoKey
	 * @responseParam string videoName
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

		$file = $this->getVal( 'file' );
		$imgSrc = $this->getVal( 'url', '' );
		$width = $this->getVal( 'width', 0 );
		$height = $this->getVal( 'height', 0 );
		$options = $this->getVal( 'options', array() );

		/** @var Title $title */
		$title = $file->getTitle();

		$linkClasses = $this->getVideoLinkClasses( $options );
		$linkAttribs = $this->getVideoLinkAttribs( $file, $options );
		$imgAttribs  = $this->getVideoImgAttribs( $file, $options );

		// get href for a tag
		$linkHref = $title->getFullURL();

		// this is used for video thumbnails on file page history tables to insure you see the older version of a file when thumbnail is clicked.
		if ( $file instanceof OldLocalFile ) {
			$archive_name = $file->getArchiveName();
			if ( !empty( $archive_name ) ) {
				$linkHref .= '?t='.$file->getTimestamp();
			}
		}

		// get class for img tag
		$imgClass = empty( $options['imgClass'] ) ? '' : $options['imgClass'];

		// update src for img tag
		$imgSrc = empty( $options['src'] ) ? $imgSrc : $options['src'];

		$lazyLoadImg = empty( $options['noLazyLoad'] ) && ImageLazyLoad::isValidLazyLoadedImage( $imgSrc );

		// set duration
		$duration = $file->getMetadataDuration();
		$durationAttribs = [];

		$metaAttribs = [];

		// disable RDF metadata in video thumbnails
		if ( !$lazyLoadImg ) {
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
		$this->imgSrc = $imgSrc;
		$this->videoKey = htmlspecialchars( $title->getDBKey() );
		$this->videoName = htmlspecialchars( $title->getText() );
		$this->imgClass = $imgClass;
		$this->imgAttrs = ThumbnailHelper::getAttribs( $imgAttribs );



		// data-src attribute in case of lazy loading
		$this->noscript = '';
		$this->dataSrc = '';

		if ( $lazyLoadImg ) {
			$this->noscript = $this->app->renderView(
				'ThumbnailController',
				'imgTag',
				$this->response->getData()
			);
			ImageLazyLoad::setLazyLoadingAttribs( $this->dataSrc, $this->imgSrc, $this->imgClass, $this->imgAttrs );
		}

		$this->imgTag = $this->app->renderView( 'ThumbnailController', 'imgTag', $this->response->getData());

		// set duration
		$this->duration = WikiaFileHelper::formatDuration( $duration );
		$this->durationAttrs = ThumbnailHelper::getAttribs( $durationAttribs );

		// set meta
		$this->metaAttrs = $metaAttribs;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Create an array of needed classes for video thumbs anchors.
	 *
	 * @param array $options The thumbnail options passed to toHTML.  This method cares about:
	 *
	 * - $options['noLightbox']
	 * - $options['linkAttribs']['class']
	 * - $options['hidePlayButton']
	 * - $options[ 'fluid' ]
	 *
	 * @return array
	 */
	protected function getVideoLinkClasses( array &$options ) {
		$linkClasses = [];
		if ( empty( $options['noLightbox'] ) ) {
			$linkClasses[] = 'image';
			$linkClasses[] = 'lightbox';
		}

		// Pull out any classes found in the linkAttribs parameter
		if ( !empty( $options['linkAttribs']['class'] ) ) {
			$classes = $options['linkAttribs']['class'];

			// If we got a string, treat it like space separated values and turn it into an array
			if ( !is_array( $classes ) ) {
				$classes = explode( ' ', $classes );
			}

			$linkClasses = array_merge( $linkClasses, $classes );
			unset( $options['linkAttribs']['class'] );
		}

		// Hide the play button
		if ( !empty( $options['hidePlayButton'] ) ) {
			$linkClasses[] = 'hide-play';
		}

		// Check for fluid
		if ( ! empty( $options[ 'fluid' ] ) ) {
			$linkClasses[] = 'fluid';
		}

		return array_unique( $linkClasses );
	}

	protected function getVideoLinkAttribs( File $file, array $options ) {
		$linkAttribs = [];

		// Get the id parameter for a tag
		if ( !empty( $options['id'] ) ) {
			$linkAttribs['id'] = $options['id'];
		}

		// Let extension override any link attributes
		if ( isset( $options['linkAttribs'] ) && is_array( $options['linkAttribs'] ) ) {
			$linkAttribs = array_merge( $linkAttribs, $options['linkAttribs'] );
		}

		return $linkAttribs;
	}

	protected function getVideoImgAttribs( File $file, array $options ) {
		// Get alt for img tag
		$title = $file->getTitle();

		$alt = empty( $options['alt'] ) ? $title->getText() : $options['alt'];
		$imgAttribs['alt'] = htmlspecialchars( $alt );

		// set data-params for img tag on mobile
		if ( !empty( $options['dataParams'] ) ) {
			$imgSrc = empty( $options['src'] ) ? null : $options['src'];

			$imgAttribs['data-params'] = ThumbnailHelper::getDataParams( $file, $imgSrc, $options );
		}

		return $imgAttribs;
	}

	public function imgTag() {
		$this->response->setData( $this->request->getParams() );
	}

	/**
	 * Image controller
	 */
	public function image() {
		/** @var File $file */
		$thumb   = $this->getVal( 'thumb' );
		$options = $this->getVal( 'options', array() );

		$this->mediaType = 'image';

		$linkAttribs = $this->getImageLinkAttribs( $thumb, $options );
		$attribs     = $this->getImageAttribs( $thumb, $options );

		$this->linkAttribs = $linkAttribs;
		$this->imgAttribs  = $attribs;
	}

	protected function getImageLinkAttribs( MediaTransformOutput $thumb, array $options ) {

		// Comes from hooks BeforeParserFetchFileAndTitle and only LinkedRevs subscribes
		// to this and it doesn't seem to be loaded ... ask if used and add logging to see if used
		$query = empty( $options['desc-query'] )  ? '' : $options['desc-query'];

		if ( !empty( $options['custom-url-link'] ) ) {
			$linkAttribs = array( 'href' => $options['custom-url-link'] );
			if ( !empty( $options['title'] ) ) {
				$linkAttribs['title'] = $options['title'];
			}
			if ( !empty( $options['custom-target-link'] ) ) {
				$linkAttribs['target'] = $options['custom-target-link'];
			}
		} elseif ( !empty( $options['custom-title-link'] ) ) {
			/** @var Title $title */
			$title = $options['custom-title-link'];
			$linkAttribs = array(
				'href' => $title->getLinkURL(),
				'title' => empty( $options['title'] ) ? $title->getFullText() : $options['title']
			);
		} elseif ( !empty( $options['desc-link'] ) ) {
			$linkAttribs = $this->getDescLinkAttribs( empty( $options['title'] ) ? null : $options['title'], $query );
		} elseif ( !empty( $options['file-link'] ) ) {
			$linkAttribs = array( 'href' => $thumb->file->getURL() );
		} else {
			$linkAttribs = false;
		}

		return $linkAttribs;
	}

	protected function getImageAttribs( MediaTransformOutput $thumb, array $options ) {
		/** @var Title $title */
		$title = $thumb->file->getTitle();
		$alt = empty( $options['alt'] ) ? $title->getText() : $options['alt'];

		$attribs = array(
			'alt'    => $alt,
			'src'    => $thumb->url,
			'width'  => $thumb->width,
			'height' => $thumb->height,
		);

		if ( !empty( $options['valign'] ) ) {
			$attribs['style'] = "vertical-align: {$options['valign']}";
		}

		if ( !empty( $options['img-class'] ) ) {
			$attribs['class'] = $options['img-class'];
		}

		$title = $thumb->file->getTitle();
		if ( $title instanceof Title ) {
			$attribs['data-image-name'] = htmlspecialchars( $title->getText() );
			$attribs['data-image-key']  = htmlspecialchars( urlencode( $title->getDBKey() ) );
		}

		return $attribs;
	}

	/**
	 * @param MediaTransformOutput $thumb
	 * @param $title string
	 * @param array|string $params array
	 * @return array
	 */
	public function getDescLinkAttribs( MediaTransformOutput $thumb, $title = null, $params = '' ) {
		$query = $thumb->page ? ( 'page=' . urlencode( $thumb->page ) ) : '';
		if( $params ) {
			$query .= $query ? '&'.$params : $params;
		}
		$attribs = array(
			'href' => $thumb->file->getTitle()->getLocalURL( $query ),
			'class' => 'image',
		);
		if ( $title ) {
			$attribs['title'] = $title;
		}
		return $attribs;
	}

	/**
	 * Article figure tags with thumbnails inside
	 */
	public function articleThumbnail() {
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
		if ( $file instanceof File ) {
			$isVideo = WikiaFileHelper::isVideoFile( $file );
			if ( $isVideo ) {
				$title = $file->getTitle()->getText();
			}
		}

		$this->thumbnail = $thumbnail;
		$this->title = $title;
		$this->figureClass = $alignClass;
		$this->url = $url;
		$this->caption = $caption;
		$this->width = $width;

		wfProfileOut( __METHOD__ );
	}

}
