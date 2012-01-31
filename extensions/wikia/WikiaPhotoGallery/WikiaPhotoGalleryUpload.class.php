<?php

/**
 * This class handles images upload with extra security checks.
 *
 * This code is mostly copied from WikiaMiniUpload extension.
 */

class WikiaPhotoGalleryUpload extends WikiaTempFilesUpload{
	const DEFAULT_FILE_FIELD_NAME = 'wpUploadFile';
	const USER_PERMISSION_ERROR = -1;

	/**
	 * Handle image upload
	 *
 	 * Returns array with uploaded files details or error details
	 */
	public function uploadImage( $uploadFieldName = self::DEFAULT_FILE_FIELD_NAME, $destFileName = null, $forceOverwrite = false ) {
		global $IP, $wgRequest, $wgUser;

		wfProfileIn(__METHOD__);

		$ret = false;

		// check whether upload is enabled (RT #53714)
		if (!WikiaPhotoGalleryHelper::isUploadAllowed()) {
			$ret = array(
				'error' => true,
				'message' => wfMsg('uploaddisabled'),
			);

			wfProfileOut(__METHOD__);
			return $ret;
		}

		$imageName =  stripslashes( ( !empty( $destFileName ) ) ? $destFileName : $wgRequest->getFileName( $uploadFieldName ) );

		// validate name and content of uploaded photo
		$nameValidation = $this->checkImageName( $imageName, $uploadFieldName );

		if ($nameValidation == UploadBase::SUCCESS) {
			// get path to uploaded image
			$imagePath = $wgRequest->getFileTempName( $uploadFieldName );

			// check if image with this name is already uploaded
			if ( $this->imageExists( $imageName ) && !$forceOverwrite ) {
				// upload as temporary file
				$this->log(__METHOD__, "image '{$imageName}' already exists!");

				$tempName = $this->tempFileName($wgUser);

				$title = Title::makeTitle(NS_FILE, $tempName);
				$localRepo = RepoGroup::singleton()->getLocalRepo();

				$file = new FakeLocalFile($title, $localRepo);
				$file->upload( $wgRequest->getFileTempName( $uploadFieldName ), '', '' );

				// store uploaded image in GarbageCollector (image will be removed if not used)
				$tempId = $this->tempFileStoreInfo($tempName);

				// generate thumbnail (to fit 200x200 box) of temporary file
				$width = min(WikiaPhotoGalleryHelper::thumbnailMaxWidth, $file->width);
				$height = min(WikiaPhotoGalleryHelper::thumbnailMaxHeight, $file->height);

				$thumbnail = $file->transform(array(
					'height' => $height,
					'width' => $width,
				));
		
				// split uploaded file name into name + extension (foo-bar.png => foo-bar + png)
				list($fileName, $extensionsName) = UploadBase::splitExtensions($imageName);
				$extensionName = !empty($extensionsName) ? end($extensionsName) : '';

				$this->log(__METHOD__, 'upload successful');

				$ret = array(
					'conflict' => true,
					'name' => $imageName,
					'nameParts' => array(
						$fileName,
						$extensionName
					),
					'tempId' => $tempId,
					'size' => array(
					    'height' => $file->height,
					    'width' => $file->width
					),
					'thumbnail' => array(
						'height' => $thumbnail->height,
						'url' => $thumbnail->url,
						'width' => $thumbnail->width,
					)
				);
			} else {
				// use regular MW upload
				$this->log(__METHOD__, "image '{$imageName}' is new one - uploading as MW file");
				$this->log(__METHOD__, "uploading '{$imagePath}' as File:{$imageName}");

				// create title and file objects for MW image to create
				$imageTitle = Title::newFromText( $imageName, NS_FILE );
				$imageFile = new LocalFile( $imageTitle, RepoGroup::singleton()->getLocalRepo() );

				// perform upload
				$result = $imageFile->upload( $imagePath, '' /* comment */, '' /* page text */);

				$this->log( __METHOD__, !empty( $result->ok ) ? 'upload successful' : 'upload failed' );

				$ret = array(
					'success' => !empty( $result->ok ),
					'name' => $imageName,
					'size' => array(
					    'height' => ( !empty( $result->ok ) ) ? $imageFile->getHeight() : 0,
					    'width' => ( !empty( $result->ok ) ) ? $imageFile->getWidth() : 0
					),
				);
			}
		} else {
			$reason = $nameValidation;

			$this->log(__METHOD__, "upload failed - file name is not valid (error #{$reason})");

			$ret = array(
				'error' => true,
				'reason' => $reason,
				'message' => $this->translateError($reason),
			);
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Try to resolve the conflict by overwriting existing image
	 */
	public function conflictOverwrite($imageName, $tempId) {
		wfProfileIn(__METHOD__);

		$res = false;
		$tempId = intval($tempId);

		$this->log(__METHOD__, "trying to resolve conflict by overwriting File:{$imageName} (temp file #{$tempId})");

		$res = $this->uploadTempFileIntoMW($tempId, $imageName);

		if ($res) {
			$this->log(__METHOD__, "conflicting photo uploaded as File:{$imageName}");
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Try to resolve the conflict by using different name for uploaded photo
	 */
	public function conflictRename($newName, $tempId) {
		wfProfileIn(__METHOD__);

		$res = false;
		$tempId = intval($tempId);

		$this->log(__METHOD__, "trying to resolve conflict by using new name '{$newName}' (temp file #{$tempId})");

		// check if given name is "free"?
		if ($this->imageExists($newName)) {
			$this->log(__METHOD__, "File:{$newName} exists!");
		} else {
			// check file name
			$nt = Title::makeTitleSafe( NS_FILE, $newName );
			if( is_null( $nt ) ) {
				$this->log(__METHOD__, 'filename provided is illegal!');
			} else {
				$res = $this->uploadTempFileIntoMW($tempId, $newName);

				if ($res) {
					$this->log(__METHOD__, "conflicting photo uploaded as File:{$newName}");
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $res;
	}
	/**
	 * Return translated message for given upload error code
	 */
	protected function translateError ($errorCode) {
		wfProfileIn(__METHOD__);

		$ret = false;

		switch($errorCode) {
			case UploadBase::ILLEGAL_FILENAME:
				$ret = wfMsg('wikiaPhotoGallery-upload-error-filename-incorrect');
				break;

			case UploadBase::FILETYPE_MISSING:
				$ret = wfMsg('wikiaPhotoGallery-upload-error-filetype-missing');
				break;

			case UploadBase::FILETYPE_BADTYPE:
				$ret = wfMsg('wikiaPhotoGallery-upload-error-filetype-incorrect');
				break;

			case UploadBase::VERIFICATION_ERROR:
				$ret = "File type verification error!" ;
				break;

			case self::USER_PERMISSION_ERROR:
				$ret = wfMsg( 'badaccess' );
				break;
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}
}
