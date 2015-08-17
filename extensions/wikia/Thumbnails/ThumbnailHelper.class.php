<?php

/**
 * Thumbnail Helper
 * @author Saipetch
 */
class ThumbnailHelper extends WikiaModel {

	// Smaller thumbnail size used by picture tag.
	const SMALL_THUMB_SIZE = .8;

	// The 3 pixel size breakpoints used by the new grid.
	const SMALL_BREAKPOINT = 768;
	const MEDIUM_BREAKPOINT = 1024;
	const LARGE_BREAKPOINT = 1280;

	/**
	 * Get attributes for mustache template
	 * Don't use this for values that need to be escaped.
	 * Wrap attributes in three curly braces so quote marks don't get escaped.
	 * Ex: {{# attrs }}{{{ . }}} {{/ attrs }}
	 * @todo change output so we can use it like: {{key}}="{{value}}"
	 * @param array $attrs [ array( key => value ) ]
	 * @return array [ array( 'key="value"' ) ]
	 */
	protected  static function getAttribs( array $attrs ) {
		$attribs = [];
		foreach ( $attrs as $key => $value ) {
			$str = $key;
			if ( !empty( $value ) ) {
				$str .= '="' . $value . '"';
			}
			$attribs[] = $str;
		}

		return $attribs;
	}

	/**
	 * Get thumbnail size. Mainly used for the class name that determines the size of the play button.
	 * @param integer $width
	 * @return string $size
	 */
	public static function getThumbnailSize( $width = 0 ) {
		if ( $width < 100 ) {
			$size = 'xxsmall';
		} else if ( $width < 200 ) {
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

	/**
	 * Get data-params attribute (for video on mobile)
	 * @param File $file
	 * @param string $imgSrc
	 * @param array $options
	 * @return string
	 */
	public static function getDataParams( $file, $imgSrc, $options ) {
		if ( is_callable( [ $file, 'getProviderName' ] ) ) {
			$provider = $file->getProviderName();
		} else {
			$provider = '';
		}

		$dataParams = [
			'type'     => 'video',
			'name'     => htmlspecialchars( $file->getTitle()->getDBKey() ),
			'full'     => $imgSrc,
			'provider' => $provider,
		];

		if ( !empty( $options['caption'] ) ) {
			$dataParams['capt'] = 1;
		}

		return htmlentities( json_encode( [ $dataParams ] ) , ENT_QUOTES );
	}

	/**
	 * Collect the img tag attributes from $options
	 * @param WikiaController $controller
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 *  Keys:
	 *      alt
	 *      fluid
	 *      valign
	 *      img-class
	 */
	public static function setImageAttribs( WikiaController $controller, MediaTransformOutput $thumb, array $options ) {
		/** @var Title $title */
		$title = $thumb->file->getTitle();

		if ( $title instanceof Title ) {
			$titleText = $title->getText();
			$controller->mediaKey = htmlspecialchars( urlencode( $title->getDBKey() ) );
			$controller->mediaName = htmlspecialchars( $titleText );
		} else {
			$titleText = '';
		}

		$controller->alt = Sanitizer::encodeAttribute(
			empty( $options['alt'] ) ? $titleText : $options['alt']
		);

		$controller->imgSrc = $thumb->url;

		// Check fluid
		if ( empty( $options[ 'fluid' ] ) ) {
			$controller->imgWidth = $thumb->width;
			$controller->imgHeight = $thumb->height;
		}

		if ( !empty( $options['valign'] ) ) {
			$controller->style = "vertical-align: {$options['valign']}";
		}

		$controller->imgClass = self::getImgClass( $options );
	}

	/**
	 * Get anchor tag attributes for an image
	 * @param WikiaController $controller
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 *  Keys:
	 *      custom-url-link
	 *      custom-target-link
	 *      title
	 *      custom-title-link
	 *      desc-link
	 *      file-link
	 */
	public static function setImageLinkAttribs( WikiaController $controller, MediaTransformOutput $thumb, array $options ) {
		$href = false;
		$title = false;
		$target = false;

		if ( !empty( $options['custom-url-link'] ) ) {
			$href = $options['custom-url-link'];
			if ( !empty( $options['title'] ) ) {
				$title = $options['title'];
			}
			if ( !empty( $options['custom-target-link'] ) ) {
				$target = $options['custom-target-link'];
			}

		} elseif ( !empty( $options['custom-title-link'] ) ) {
			/** @var Title $title */
			$titleObj = $options['custom-title-link'];
			$href = $titleObj->getLinkURL();
			$title = empty( $options['title'] ) ? $titleObj->getFullText() : $options['title'];

		} elseif ( !empty( $options['desc-link'] ) ) {
			$href = self::getContextualFileUrl( $thumb );
			if ( !empty( $options['title'] ) ) {
				$title = $options['title'];
			}

		} elseif ( !empty( $options['file-link'] ) ) {
			$href = self::getContextualFileUrl( $thumb );
		}

		$controller->linkHref = $href;
		$controller->title = $title;
		$controller->target = $target;
	}

	/**
	 * Get the proper file URL for given thumb
	 *
	 * @param MediaTransformOutput $thumb
	 * @return String
	 */
	public static function getContextualFileUrl( MediaTransformOutput $thumb ) {
		// If skin is not monobook, have the anchor wrapping the image link to the
		// raw file. If not, keep previous behavior and link to the file page
		if ( !F::app()->checkSkin( 'monobook' ) ) {
			$defaultHref = $thumb->file->getUrl();
		} else {
			$defaultHref = $thumb->file->getTitle()->getLocalURL();
		}

		return $defaultHref;
	}

	/**
	 * Set attributes for video's img tag
	 * @param WikiaController $controller
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 *  Keys:
	 *      alt
	 *      src
	 *      img-class
	 *      fluid
	 *      src
	 *      dataParams
	 */
	public static function setVideoImgAttribs( WikiaController $controller, MediaTransformOutput $thumb, array $options ) {
		// get alt for img tag
		$file = $thumb->file;
		$title = $file->getTitle();
		$controller->alt = empty( $options['alt'] ) ? $title->getText() : $options['alt'];

		// set image attributes
		$controller->mediaKey = htmlspecialchars( $title->getDBKey() );
		$controller->mediaName = htmlspecialchars( $title->getText() );
		$controller->imgClass = self::getImgClass( $options );

		// check fluid
		if ( empty( $options['fluid'] ) ) {
			$controller->imgWidth = $thumb->width;
			$controller->imgHeight = $thumb->height;
		}

		// Prefer the src given in options over what's passed in directly.
		// @TODO there is no reason to pass two versions of image source.  See if both are actually used and pick one
		$imgSrc = empty( $options['src'] ) ? $thumb->url : $options['src'];
		$controller->imgSrc = $imgSrc;

		// set data-params for img tag on mobile
		// TODO: only used on mobile, could be made into separate template
		if ( !empty( $options['dataParams'] ) ) {
			$controller->dataParams = self::getDataParams( $file, $imgSrc, $options );
		}
	}

	/**
	 * Set attributes for video's anchor tag
	 * @param WikiaController $controller
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 *  Keys:
	 *      id
	 */
	public static function setVideoLinkAttribs( WikiaController $controller, MediaTransformOutput $thumb, array $options ) {
		// Get href for a tag
		$file = $thumb->file;
		$title = $file->getTitle();
		$linkHref = $title->getFullURL();

		// Get timestamp for older versions of files (used on file page history tab)
		if ( $file instanceof OldLocalFile ) {
			$archiveName = $file->getArchiveName();
			if ( !empty( $archiveName ) ) {
				$linkHref .= '?t='.$file->getTimestamp();
			}
		}
		$controller->linkHref = $linkHref;

		// Get the id parameter for a tag
		if ( !empty( $options['id'] ) ) {
			$controller->linkId = $options['id'];
		}
	}

	/**
	 * Set classes for video's anchor tag
	 * @param WikiaController $controller
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 *  Keys:
	 *      noLightbox
	 *      linkAttribs
	 *      hidePlayButton
	 *      fluid
	 *      forceSize
	 */
	public static function setVideoLinkClasses( WikiaController $controller, MediaTransformOutput $thumb, array &$options ) {
		$linkClasses = [];

		if ( empty( $options['noLightbox'] ) ) {
			$linkClasses[] = 'image';
			$linkClasses[] = 'lightbox';
		}

		// Hide the play button
		if ( !empty( $options['hidePlayButton'] ) ) {
			$linkClasses[] = 'hide-play';
		}

		// Check for fluid
		if ( ! empty( $options[ 'fluid' ] ) ) {
			$linkClasses[] = 'fluid';
		}

		if ( !empty( $options['forceSize'] ) ) {
			$linkClasses[] = $options['forceSize'];
		} else {
			$linkClasses[] = self::getThumbnailSize( $thumb->width );
		}

		self::setLinkAttribsClass( $linkClasses, $options );
		$controller->linkClasses = array_unique( $linkClasses );
	}

	/**
	 * Set classes for image's anchor tag
	 * @param $controller
	 * @param array $options
	 */
	public static function setImageLinkClasses( $controller, array &$options ) {
		$linkClasses = [];

		if ( !empty( $options['custom-title-link'] ) ) {
			$linkClasses[] = 'link-internal';
		} elseif ( !empty( $options['custom-url-link'] ) ) {
			$linkClasses[] = 'link-external';
		}

		self::setLinkAttribsClass( $linkClasses, $options );
		$controller->linkClasses = $linkClasses;
	}

	/**
	 * Create array of any image attributes that are sent in by extensions
	 * All values MUST BE SANITIZED before reaching this point
	 * @param WikiaController $controller
	 * @param array $options
	 */
	public static function setExtraImgAttribs( WikiaController $controller, array $options ) {
		// Let extensions add any link attributes
		if ( isset( $options['imgAttribs'] ) && is_array( $options['imgAttribs'] ) ) {
			$controller->extraImgAttrs = self::getAttribs( $options['imgAttribs'] );
		}
	}

	/**
	 * Create array of any link attributes that are sent in by extensions
	 * All values MUST BE SANITIZED before reaching this point
	 * @param WikiaController $controller
	 * @param array $options
	 */
	public static function setExtraLinkAttribs( WikiaController $controller, array $options ) {
		if ( isset( $options['linkAttribs'] ) && is_array( $options['linkAttribs'] ) ) {
			$controller->extraLinkAttrs = self::getAttribs( $options['linkAttribs'] );
		}
	}

	/**
	 * Checks if an image should be lazy loaded, and if so sets the necessary attributes
	 * @param WikiaController $controller
	 * @param array $options
	 * @return bool
	 */
	public static function setLazyLoad( WikiaController $controller, array $options = [] ) {
		$lazyLoaded = self::shouldLazyLoad( $controller, $options );
		if ( $lazyLoaded ) {
			$controller->noscript = $controller->app->renderView(
				'ThumbnailController',
				'imgTag',
				$controller->response->getData()
			);
			ImageLazyLoad::setLazyLoadingAttribs( $controller );
		}

		return $lazyLoaded;
	}

	/**
	 * Determines if image should be lazyloaded
	 * @param WikiaController $controller
	 * @param array $options
	 * @return bool
	 */
	public static function shouldLazyLoad( WikiaController $controller, array $options ) {
		return (
			empty( $options['noLazyLoad'] )
			&& isset( $controller->imgSrc )
			&& ImageLazyLoad::isValidLazyLoadedImage( $controller->imgSrc )
		);
	}

	/**
	 * Pull out any classes found in the img-class parameter
	 * @param array $options
	 * @return array
	 */
	protected static function getImgClass( array $options ) {
		return empty( $options['img-class'] ) ? [] : explode( ' ', $options['img-class'] );
	}

	/**
	 * Pull out any classes found in the linkAttribs parameter.
	 * @param array $linkClasses
	 * @param array $options
	 */
	protected static function setLinkAttribsClass( array &$linkClasses, array &$options ) {
		if ( !empty( $options['linkAttribs']['class'] ) ) {
			$classes = $options['linkAttribs']['class'];

			// If we got a string, treat it like space separated values and turn it into an array
			if ( !is_array( $classes ) ) {
				$classes = explode( ' ', $classes );
			}

			$linkClasses = array_merge( $linkClasses, $classes );
			unset( $options['linkAttribs']['class'] );
		}
	}

	/**
	 * Set urls to be used for <picture> tags. Sets both thumbnails in the original format (jpeg, png, etc),
	 * and WebP to be used if the browser supports it.
	 * @param WikiaController $controller
	 * @param MediaTransformOutput $thumb
	 */
	public static function setPictureTagInfo( WikiaController $controller, MediaTransformOutput $thumb ) {
		$file = $thumb->file;
		$fullSizeDimension = max( $thumb->getWidth(), $thumb->getHeight() );
		$smallSizeDimension = $fullSizeDimension * self::SMALL_THUMB_SIZE;
		$useWebP = true;

		// get small images (original and WebP)
		$controller->smallUrl = WikiaFileHelper::getSquaredThumbnailUrl( $file, $smallSizeDimension );
		$controller->smallUrlWebP = WikiaFileHelper::getSquaredThumbnailUrl( $file, $smallSizeDimension, $useWebP );

		// Set the breakpoint used by the <picture> tag to determine which image to load
		$controller->breakPoint = self::MEDIUM_BREAKPOINT;

		// get full size WebP image
		$controller->imgSrcWebP = WikiaFileHelper::getSquaredThumbnailUrl( $file, $fullSizeDimension, $useWebP );

		// Let image template know to use <picture> tag instead of <img> tag
		$controller->usePictureTag = true;
	}
}
