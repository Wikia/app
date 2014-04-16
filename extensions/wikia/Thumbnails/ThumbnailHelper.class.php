<?php

/**
 * Thumbnail Helper
 * @author Saipetch
 */
class ThumbnailHelper extends WikiaModel {

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

}
