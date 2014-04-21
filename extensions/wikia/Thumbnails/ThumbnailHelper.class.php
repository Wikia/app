<?php

/**
 * Thumbnail Helper
 * @author Saipetch
 */
class ThumbnailHelper extends WikiaModel {

	/**
	 * Get attributes for mustache template
	 * Don't use this for values that need to be escaped.
	 * Wrap attributes in three curly braces so quote markes don't get escaped.
	 * Ex: {{# attrs }}{{{ . }}} {{/ attrs }}
	 * @param array $attrs [ array( key => value ) ]
	 * @return array [ array( 'key="value"' ) ]
	 */
	public static function getAttribs( $attrs ) {
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
	 * @param array $thumbOptions
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

		// get link to user page
		$link = AvatarService::renderLink( $file->getUser() );
		$addedBy = wfMessage( 'thumbnails-added-by', $link, wfTimeFormatAgo( $addedAt ) )->text();

		return $addedBy;
	}

}
