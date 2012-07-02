<?php
/*
 * @author Sebastian Marzjan
 */

class UploadVisualizationImageFromFile extends UploadFromFile {
	const VISUALIZATION_MAIN_IMAGE_NAME = 'Wikia-Visualization-Main.jpg';
	const VISUALIZATION_ADDITIONAL_IMAGES_BASE_NAME = 'Wikia-Visualization-Add';
	const VISUALIZATION_ADDITIONAL_IMAGES_EXT = '.jpg';
	const VISUALIZATION_MAIN_IMAGE_MIN_WIDTH = 320;
	const VISUALIZATION_MAIN_IMAGE_MIN_HEIGHT = 320;

	const FILEDIMENSIONS_ERROR = 30;
	const FILETYPE_ERROR = 31;

	public function verifyUpload(){
		$this->getTitle(); //will fill in final destination and extension
		$details = parent::verifyUpload();

		if ( $details[ 'status' ] == self::OK ){

			$uploadType = F::app()->wg->request->getVal('uploadType');

			if($uploadType == 'main') {
				$imageSize = getimagesize($this->getTempPath());

				if($imageSize[0] < self::VISUALIZATION_MAIN_IMAGE_MIN_WIDTH || $imageSize[1] < self::VISUALIZATION_MAIN_IMAGE_MIN_HEIGHT ) {
					$details[ 'status' ] = self::FILEDIMENSIONS_ERROR;
				}
			}

			// check file type (just by extension)
			if ( !$this->checkFileExtension( $this->mFinalExtension, array( 'jpg' ) ) ) {
				$details[ 'status' ] = self::FILETYPE_ERROR;
			}
		}

		return $details;
	}


	public function performUpload() {
		global $wgUser;
		return parent::performUpload('', '', false, $wgUser);
	}

	public function getLocalFile() {
		if( is_null( $this->mLocalFile ) ) {
			$this->mLocalFile = new FakeLocalFile( Title::newFromText( 'Temp_file_' . time() . '.jpg', NS_FILE ), RepoGroup::singleton()->getLocalRepo() );
		}

		return $this->mLocalFile;
	}

	public function checkWarnings(){
		$warnings = parent::checkWarnings();

		unset( $warnings[ 'exists' ]);
		unset( $warnings[ 'duplicate' ] );
		unset( $warnings[ 'duplicate-archive' ]);
		unset( $warnings[ 'badfilename' ]);

		return $warnings;
	}

	public function isVisualizationImageName($fileName) {
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

		if(in_array($destName,$visualizationImageNames)) {
			return true;
		}
		return false;
	}

	public function UploadVerification($destName, $tempPath, &$error) {
		$result = $this->isVisualizationImageName($destName);

		if($result) {
			$error = wfMsg('promote-manual-upload-error');
			return false;
		}

		return true;
	}
}
?>
