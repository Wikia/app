<?php
/*
 * @author Sebastian Marzjan
 */

class UploadVisualizationImageFromFile extends UploadFromFile {
	const VISUALIZATION_MAIN_IMAGE_NAME = 'Wikia-Visualization-Main.png';
	const VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const VISUALIZATION_ADDITIONAL_IMAGES_EXT = '.png';
	const VISUALIZATION_MAIN_IMAGE_MIN_WIDTH = 480;
	const VISUALIZATION_MAIN_IMAGE_MIN_HEIGHT = 320;

	const FILEDIMENSIONS_ERROR = 30;
	const FILETYPE_ERROR = 31;

	public function verifyUpload(){
		$this->getTitle(); //will fill in final destination and extension
		$details = parent::verifyUpload();

		if ( $details[ 'status' ] == self::OK ){
			$imageSize = getimagesize($this->getTempPath());

			// Currently the image size needs to be the same for main and additional
			if($imageSize[0] < self::VISUALIZATION_MAIN_IMAGE_MIN_WIDTH || $imageSize[1] < self::VISUALIZATION_MAIN_IMAGE_MIN_HEIGHT ) {
				$details[ 'status' ] = self::FILEDIMENSIONS_ERROR;
			}

			// check file type (just by extension)
			if ( !$this->checkFileExtension( $this->mFinalExtension, [ 'png' ] ) ) {
				$details[ 'status' ] = self::FILETYPE_ERROR;
			}
		}

		return $details;
	}

	public function checkWarnings(){
		$warnings = parent::checkWarnings();

		unset( $warnings[ 'exists' ]);
		unset( $warnings[ 'duplicate' ] );
		unset( $warnings[ 'duplicate-archive' ]);
		unset( $warnings[ 'badfilename' ]);

		return $warnings;
	}
}
