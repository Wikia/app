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

		// set duration
		$duration = $file->getMetadataDuration();
		$durationAttribs = [];
		$metaAttribs = [];

		// Set a positive flag for whether we need to lazy load
		$options['lazyLoad'] = empty( $options['noLazyLoad'] ) && ImageLazyLoad::isValidLazyLoadedImage( $options['src'] );

		// Only add RDF metadata when the thumb is not lazy loaded
		if ( !$options['lazyLoad'] ) {
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
		$this->alt = $options['alt'];

		// data-src attribute in case of lazy loading
		$this->noscript = '';
		$this->dataSrc = '';

		if ( $options['lazyLoad'] ) {
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

		// This can be removed once we fully rollout the article thumbnails with the
		// details icon. This just allows us to do it in stages. (Don't forget to update
		// the mustached checks as well). See VID-1788
		$this->showInfoIcon =  !empty( $this->wg->ShowArticleThumbDetailsIcon );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Create an array of needed classes for video thumbs anchors.
	 *
	 * @param array $options The thumbnail options passed to toHTML.  This method cares about:
	 *
	 * - $options[ 'noLightbox' ]
	 * - $options[ 'linkAttribs' ][ 'class' ]
	 * - $options[ 'hidePlayButton' ]
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

		$linkAttrs   = $this->getImageLinkAttribs( $thumb, $options );
		$attribs     = $this->getImageAttribs( $thumb, $options );

		$this->imgSrc = $thumb->url;

		// Merge in imgClass as well
		if ( !empty( $options['img-class'] ) ) {
			$this->imgClass = $options['img-class'];
		}

		# Move the href out of the attrs and into its own value
		$this->linkHref = empty( $linkAttrs['href'] ) ? null : $linkAttrs['href'];
		unset( $linkAttrs['href'] );

		$this->linkAttrs = ThumbnailHelper::getAttribs( $linkAttrs );
		$this->imgAttribs  = ThumbnailHelper::getAttribs( $attribs );

		$file = $thumb->file;
		$title = $file->getTitle();
		$this->mediaKey = htmlspecialchars( $title->getDBKey() );
		$this->mediaName = htmlspecialchars( $title->getText() );
		$this->alt = $options['alt'];

		// This can be removed once we fully rollout the article thumbnails with the
		// details icon. This just allows us to do it in stages. (Don't forget to update
		// the mustached checks as well). See VID-1788
		$this->showInfoIcon =  !empty( $this->wg->ShowArticleThumbDetailsIcon );

		// Check fluid
		if ( empty( $options[ 'fluid' ] ) ) {
			$this->imgWidth = $thumb->width;
			$this->imgHeight = $thumb->height;
		}
	}

	/**
	 * Get anchor tag attributes for an image
	 *
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 * @return array|bool
	 */
	protected function getImageLinkAttribs( MediaTransformOutput $thumb, array $options ) {

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
			// Comes from hooks BeforeParserFetchFileAndTitle and only LinkedRevs subscribes
			// to this and it doesn't seem to be loaded ... ask if used and add logging to see if used
			$query = empty( $options['desc-query'] )  ? '' : $options['desc-query'];

			$linkAttribs = $this->getDescLinkAttribs( $thumb, empty( $options['title'] ) ? null : $options['title'], $query );
		} elseif ( !empty( $options['file-link'] ) ) {
			$linkAttribs = array( 'href' => $thumb->file->getURL() );
		} else {
			$linkAttribs = false;
		}

		return $linkAttribs;
	}

	/**
	 * Collect the img tag attributes from $options
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 * @return array
	 */
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

		$title = $thumb->file->getTitle();
		if ( $title instanceof Title ) {
			$attribs['data-image-name'] = htmlspecialchars( $title->getText() );
			$attribs['data-image-key']  = htmlspecialchars( urlencode( $title->getDBKey() ) );
		}

		return $attribs;
	}

	/**
	 * Used in getImageLinkAttribs when getting the linkAttribs
	 *
	 * @param MediaTransformOutput $thumb The thumbnail object
	 * @param string $title A title object
	 * @param array $params
	 * @return array
	 */
	public function getDescLinkAttribs( MediaTransformOutput $thumb, $title = null, $params = null ) {
		$query = $thumb->page ? ( 'page=' . urlencode( $thumb->page ) ) : '';
		if ( $params ) {
			$query .= $query ? '&'.$params : $params;
		}
		$attribs = [ 'href' => $thumb->file->getTitle()->getLocalURL( $query ) ];
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
