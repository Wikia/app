<?php

/*
 * @author Federico "Lox" Lucignano
 */

class UploadWordmarkFromFile extends UploadFromFile {
	const FILEDIMENSIONS_ERROR = 30;
	const FILETYPE_ERROR = 31;

	public function verifyUpload() {
		//will fill in final destination and extension
		$this->getTitle();
		$details = parent::verifyUpload();

		if ( $details['status'] == self::OK ) {
			// check file type (just by extension)

			if ( $this->checkFileExtension( $this->mFinalExtension, [ 'png' ] ) ) {
				$imageSize = getimagesize( $this->getTempPath() );

				if ( $imageSize[0] > 250 || $imageSize[1] > 65 ) {
					$details['status'] = self::FILEDIMENSIONS_ERROR;
				}
			} else {
				$details['status'] = self::FILETYPE_ERROR;
			}
		}

		return $details;
	}

	public function getLocalFile() {
		if ( is_null( $this->mLocalFile ) ) {
			$this->mLocalFile = new FakeLocalFile(
				Title::newFromText( 'Temp_file_' . time(), NS_FILE ),
				RepoGroup::singleton()->getLocalRepo()
			);
		}

		return $this->mLocalFile;
	}

	public function checkWarnings() {
		$warnings = parent::checkWarnings();

		//for wordmark we allow overwriting and don't care of
		//filname mismatch for FakeLocalFile (see UploadBase::checkWarnings)
		unset( $warnings['exists'] );
		unset( $warnings['duplicate'] );
		unset( $warnings['duplicate-archive'] );
		unset( $warnings['badfilename'] );

		return $warnings;
	}
}
