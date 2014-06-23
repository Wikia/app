<?php

class WikiaInteractiveMapsUploadImageFromFile extends UploadFromFile {
	const PIN_TYPE_MARKER_IMAGE_MIN_SIZE = 60;

	const PIN_TYPE_MARKER_IMAGE_TOO_SMALL_ERROR = 30;

	const UPLOAD_TYPE_MAP = 'map';
	const UPLOAD_TYPE_PIN_TYPE_MARKER = 'marker';

	/**
	 * Validates uploaded file. Currently it checks pin type marker dimensions.
	 * @param String $uploadType
	 * @return array
	 */
	public function verifyUpload( $uploadType ) {
		$details = $this->getUploadDetails();

		if ( $this->isUploadSuccessful( $details[ 'status' ] ) ) {
			// check minimal dimensions for pin type marker
			if ( $this->isUploadPoiCategory( $uploadType ) ) {
				$imageSize = $this->getUploadedImageSize();
				if ( $imageSize[ 0 ] < self::PIN_TYPE_MARKER_IMAGE_MIN_SIZE || $imageSize[ 1 ] < self::PIN_TYPE_MARKER_IMAGE_MIN_SIZE ) {
					$details[ 'status' ] = self::PIN_TYPE_MARKER_IMAGE_TOO_SMALL_ERROR;
				}
			}
		}

		return $details;
	}

	/**
	 * Returns upload details
	 *
	 * @return array
	 */
	public function getUploadDetails() {
		return parent::verifyUpload();
	}

	/**
	 * Returns width and height of uploaded image
	 *
	 * @return array
	 */
	public function getUploadedImageSize() {
		$imageSize = getimagesize( $this->getTempPath() );
		return [ $imageSize[ 0 ], $imageSize[ 1 ] ];
	}

	/**
	 * Returns true if the upload was successful
	 *
	 * @param $status
	 * @return bool
	 */
	public function isUploadSuccessful( $status ) {
		return $status === self::OK;
	}

	/**
	 * Returns true if the upload type is POI category
	 *
	 * @param String $uploadType
	 * @return bool
	 */
	public function isUploadPoiCategory( $uploadType ) {
		return $uploadType === self::UPLOAD_TYPE_PIN_TYPE_MARKER;
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
