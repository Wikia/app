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
			if ( !$this->checkFileExtension( $this->mFinalExtension, array( 'png' ) ) ) {
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

	static public function isVisualizationImageName($fileName) {
		$destName = strtolower($fileName);

		$visualizationImageNames = array(
			strtolower(self::VISUALIZATION_MAIN_IMAGE_NAME),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-1.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-2.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-3.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-4.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-5.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-6.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-7.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-8.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
			strtolower(self::VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME . '-9.' . self::VISUALIZATION_ADDITIONAL_IMAGES_EXT),
		);

		if( in_array($destName, $visualizationImageNames) ) {
			return true;
		}
		return false;
	}

	/**
	 * @desc A file upload verification hook; if it returns false UploadBase::verifyUpload() will return UploadBase::HOOK_ABORTED error; we return it here when somebody tries to upload visualization files manually not on development environment
	 *
	 * @param string $destName
	 * @param string $tempPath
	 * @param $error
	 *
	 * @return bool true because it's a hook
	 */
	static public function UploadVerification($destName, $tempPath, &$error) {
		global $wgDevelEnvironment;
		$result = self::isVisualizationImageName($destName);

		if( $result && !$wgDevelEnvironment ) {
			$error = wfMsg('promote-manual-upload-error');
			return false;
		}

		return true;
	}
}
