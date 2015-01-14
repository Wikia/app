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
		$promoImage = PromoImage::fromPathname($destName);

		if($promoImage->isValid() and ($promoImage->getCityId() == F::app()->wg->cityId)){
			// you cannot upload to this wiki an image with database name the same as this wiki
			$error = wfMsg('promote-manual-upload-error');
			return false;
		} else {
			return true;
		}
	}
}
