<?php
/*
 * @author Federico "Lox" Lucignano
 */

class UploadWordmarkFromFile extends UploadFromFile {
	const FILEDIMENSIONS_ERROR = 30;
	const FILETYPE_ERROR = 31;
	
	public function verifyUpload(){
		$this->getTitle(); //will fill in final destination and extension
		$details = parent::verifyUpload();
		
		if ( $details[ 'status' ] == self::OK ){ 
			// check file type (just by extension)
			
			if ( $this->checkFileExtension( $this->mFinalExtension, array( 'png' ) ) ) {
				$imageSize = getimagesize( $this->getTempPath() );

				if($imageSize[0] > 250 || $imageSize[1] > 65) {
					$details[ 'status' ] = self::FILEDIMENSIONS_ERROR;
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
			//TODO: find out what namespace constant 6 is
			$this->mLocalFile = new FakeLocalFile( Title::newFromText( 'Temp_file_' . time(), 6 ), RepoGroup::singleton()->getLocalRepo() );
		}
		
		return $this->mLocalFile;
	}
	
	public function checkWarnings(){
		$warnings = parent::checkWarnings();
		
		//for wordmark we allow overwriting and don't care of
		//filname mismatch for FakeLocalFile (see UploadBase::checkWarnings)
		unset( $warnings[ 'exists' ]);
		unset( $warnings[ 'duplicate' ] );
		unset( $warnings[ 'duplicate-archive' ]);
		unset( $warnings[ 'badfilename' ]);
		
		return $warnings;
	}
}
