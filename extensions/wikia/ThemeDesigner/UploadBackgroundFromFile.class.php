<?php
/*
 * @author Federico "Lox" Lucignano
 */

class UploadBackgroundFromFile extends UploadFromFile {
	const FILESIZE_LIMIT = 153600;
	const FILESIZE_ERROR = 20;
	const FILETYPE_ERROR = 21;

	private $mImageAlign;

	public function getImageAlign(){
		return $this->mImageAlign;
	}
	public function verifyUpload(){
		$this->getTitle(); //will fill in final destination and extension
		$details = parent::verifyUpload();


		if ( $details[ 'status' ] == self::OK ){
			// check file type (just by extension)

			if ( $this->checkFileExtension( $this->mFinalExtension, array( 'png', 'jpg', 'jpeg', 'gif' ) ) ) {
				$tempPath = $this->getTempPath();
				// check if file is correct file size
				$imageFileSize = filesize( $tempPath );

				if ( $imageFileSize <= self::FILESIZE_LIMIT ) {

					// center image if wider than 1050, otherwise left align
					$imageSize = getimagesize( $tempPath );
					if( $imageSize[0] > 1050 ) {
						$this->mImageAlign = "center";
					} else {
						$this->mImageAlign = "left";
					}
				} else {
					$details[ 'status' ] = self::FILESIZE_ERROR;
				}
			} else {
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
			$this->mLocalFile = new FakeLocalFile( Title::newFromText( 'Temp_file_' . time(), NS_FILE ), RepoGroup::singleton()->getLocalRepo() );
		}

		return $this->mLocalFile;
	}

	public function checkWarnings(){
		$warnings = parent::checkWarnings();

		//for background image we allow overwriting and don't care of
		//filname mismatch for FakeLocalFile (see UploadBase::checkWarnings)
		unset( $warnings[ 'exists' ]);
		unset( $warnings[ 'duplicate' ] );
		unset( $warnings[ 'duplicate-archive' ]);
		unset( $warnings[ 'badfilename' ]);

		return $warnings;
	}
}
