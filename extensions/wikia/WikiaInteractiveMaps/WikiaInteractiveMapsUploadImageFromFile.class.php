<?php

class WikiaInteractiveMapsUploadImageFromFile extends UploadFromFile {
	const POI_CATEGORY_MARKER_IMAGE_MIN_SIZE = 60;

	const POI_CATEGORY_MARKER_IMAGE_TOO_SMALL_ERROR = 30;

	const UPLOAD_TYPE_MAP = 'map';
	const UPLOAD_TYPE_POI_CATEGORY_MARKER = 'marker';

	/**
	 * Validates uploaded file. Currently it checks POI category marker dimensions.
	 * @param String $uploadType
	 * @return array
	 */
	public function verifyUpload( $uploadType ) {
		$details = parent::verifyUpload();

		if ( $details[ 'status' ] === self::OK ) {
			// check minimal dimensions for POI category marker
			if ( $uploadType === self::UPLOAD_TYPE_POI_CATEGORY_MARKER ) {
				$imageSize = getimagesize( $this->getTempPath() );
				if ( $imageSize[ 0 ] < self::POI_CATEGORY_MARKER_IMAGE_MIN_SIZE || $imageSize[ 1 ] < self::POI_CATEGORY_MARKER_IMAGE_MIN_SIZE ) {
					$details[ 'status' ] = self::POI_CATEGORY_MARKER_IMAGE_TOO_SMALL_ERROR;
				}
			}
		}

		return $details;
	}

	/**
	 * Clears warnings from things we don't need
	 * @return Array
	 */
	public function checkWarnings(){
		$warnings = parent::checkWarnings();

		unset( $warnings[ 'exists' ] );
		unset( $warnings[ 'duplicate' ] );
		unset( $warnings[ 'duplicate-archive' ] );
		unset( $warnings[ 'badfilename' ] );

		return $warnings;
	}
}
