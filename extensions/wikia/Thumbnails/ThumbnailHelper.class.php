<?php

/**
 * Thumbnail Helper
 * @author Saipetch
 */
class ThumbnailHelper extends WikiaModel {

	/**
	 * @const int Minimum width of thumbnail to show icon link to file page on hover
	 */
	const MIN_INFO_ICON_WIDTH = 100;

	/**
	 * Get attributes for mustache template
	 * Don't use this for values that need to be escaped.
	 * Wrap attributes in three curly braces so quote marks don't get escaped.
	 * Ex: {{# attrs }}{{{ . }}} {{/ attrs }}
	 * @param array $attrs [ array( key => value ) ]
	 * @return array [ array( 'key="value"' ) ]
	 */
	public static function getAttribs( array $attrs ) {
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
	 * Get message for by user section
	 * @param File $file
	 * @param boolean $isVideo
	 * @return string $addedBy
	 */
	public static function getByUserMsg( $file, $isVideo ) {
		$addedAt = $file->getTimestamp();
		if ( $isVideo ) {
			$videoInfo = VideoInfo::newFromTitle( $file->getTitle()->getDBkey() );
			if ( !empty( $videoInfo ) ) {
				$addedAt = $videoInfo->getAddedAt();
			}
		}

		return WikiaFileHelper::getByUserMsg( $file->getUser(), $addedAt );
	}

	/**
	 * Collect the img tag attributes from $options
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 * @return array
	 */
	public static function getImageAttribs( MediaTransformOutput $thumb, array $options ) {
		/** @var Title $title */
		$title = $thumb->file->getTitle();
		$alt = empty( $options['alt'] ) ? $title->getText() : $options['alt'];

		$attribs = array(
			'alt'    => Sanitizer::encodeAttribute($alt),
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
	 * Get anchor tag attributes for an image
	 *
	 * @param MediaTransformOutput $thumb
	 * @param array $options
	 * @return array|bool
	 */
	public static function getImageLinkAttribs( MediaTransformOutput $thumb, array $options ) {
		// If we have the details icon enabled, have the anchor wrapping the image link to the
		// raw file.  If not, keep previous behavior and link to the file page

		if ( F::app()->wg->ShowArticleThumbDetailsIcon && !F::app()->checkSkin( 'monobook' ) ) {
			$defaultHref = $thumb->file->getUrl();
		} else {
			$defaultHref = $thumb->file->getTitle()->getLocalURL();
		}


		if ( !empty( $options['custom-url-link'] ) ) {
			$linkAttribs = [ 'href' => $options['custom-url-link'] ];
			if ( !empty( $options['title'] ) ) {
				$linkAttribs['title'] = Sanitizer::encodeAttribute( $options['title'] );
			}
			if ( !empty( $options['custom-target-link'] ) ) {
				$linkAttribs['target'] = $options['custom-target-link'];
			}
		} elseif ( !empty( $options['custom-title-link'] ) ) {
			/** @var Title $title */
			$title = $options['custom-title-link'];
			$linkAttribs = [
				'href' => $title->getLinkURL(),
				'title' => Sanitizer::encodeAttribute( empty( $options['title'] ) ? $title->getFullText() : $options['title'] )
			];
		} elseif ( !empty( $options['desc-link'] ) ) {
			$linkAttribs = [ 'href' => $defaultHref ];
			if ( !empty( $options['title'] ) ) {
				$linkAttribs['title'] = Sanitizer::encodeAttribute( $options['title'] );
			}
		} elseif ( !empty( $options['file-link'] ) ) {
			$linkAttribs = [ 'href' => $defaultHref ];
		} else {
			$linkAttribs = [];
		}

		return $linkAttribs;
	}

	public static function getVideoImgAttribs( File $file, array $options ) {
		// Get alt for img tag
		$title = $file->getTitle();

		$alt = empty( $options['alt'] ) ? $title->getText() : $options['alt'];
		$imgAttribs['alt'] = htmlspecialchars( $alt );

		// set data-params for img tag on mobile
		if ( !empty( $options['dataParams'] ) ) {
			$imgSrc = empty( $options['src'] ) ? null : $options['src'];

			$imgAttribs['data-params'] = self::getDataParams( $file, $imgSrc, $options );
		}

		return $imgAttribs;
	}

	public static function getVideoLinkAttribs( File $file, array $options ) {
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
	public static function getVideoLinkClasses( array &$options ) {
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

	/**
	 * Create an array of needed classes for image thumbs anchors.
	 *
	 * @param array $options The thumbnail options passed to toHTML.
	 * @return array
	 */
	public static function getImageLinkClasses ( array $options ) {

		$classes = [];
		if ( !empty( $options["custom-title-link"] ) ) {
			$classes[] = "link-internal";
		} elseif ( !empty( $options["custom-url-link"] ) ) {
			$classes[] = "link-external";
		}

		return $classes;
	}

	/**
	 * Logic for whether to display the link to the file page overlayed on an image.
	 *
	 * @param $width
	 * @return bool
	 */
	public static function canShowInfoIcon( $width ) {
		return !empty( F::app()->wg->ShowArticleThumbDetailsIcon )
			&& $width >= self::MIN_INFO_ICON_WIDTH;

	}
}
