<?php

/**
 * This class handles images upload with extra security checks.
 *
 * This code is mostly copied from WikiaMiniUpload extension.
 */

class WikiaPhotoGalleryUpload {
	const DEFAULT_FILE_FIELD_NAME = 'wpUploadFile';
	const USER_PERMISSION_ERROR = -1;

	/**
	 * Handle image upload
	 *
 	 * Returns array with uploaded files details or error details
	 */
	public static function uploadImage( $uploadFieldName = self::DEFAULT_FILE_FIELD_NAME, $destFileName = null, $forceOverwrite = false ) {
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
		$nameValidation = self::checkImageName( $imageName, $uploadFieldName );

		if ($nameValidation == UploadBase::SUCCESS) {
			// get path to uploaded image
			$imagePath = $wgRequest->getFileTempName( $uploadFieldName );

			// check if image with this name is already uploaded
			if ( self::imageExists( $imageName ) && !$forceOverwrite ) {
				// upload as temporary file
				self::log(__METHOD__, "image '{$imageName}' already exists!");

				$tempName = self::tempFileName($wgUser);

				$title = Title::makeTitle(NS_FILE, $tempName);
				$localRepo = RepoGroup::singleton()->getLocalRepo();

				$file = new FakeLocalFile($title, $localRepo);
				$file->upload( $wgRequest->getFileTempName( $uploadFieldName ), '', '' );

				// store uploaded image in GarbageCollector (image will be removed if not used)
				$tempId = self::tempFileStoreInfo($tempName);

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

				self::log(__METHOD__, 'upload successful');

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
					),
					'isImageStrict' => !!WikiaPhotoGalleryHelper::isImageStrict($file),
				);
			} else {
				// use regular MW upload
				self::log(__METHOD__, "image '{$imageName}' is new one - uploading as MW file");
				self::log(__METHOD__, "uploading '{$imagePath}' as File:{$imageName}");

				// create title and file objects for MW image to create
				$imageTitle = Title::newFromText( $imageName, NS_FILE );
				$imageFile = new LocalFile( $imageTitle, RepoGroup::singleton()->getLocalRepo() );

				// perform upload
				$result = $imageFile->upload( $imagePath, '' /* comment */, '' /* page text */);

				self::log( __METHOD__, !empty( $result->ok ) ? 'upload successful' : 'upload failed' );

				$ret = array(
					'success' => !empty( $result->ok ),
					'name' => $imageName,
					'size' => array(
					    'height' => ( !empty( $result->ok ) ) ? $imageFile->getHeight() : 0,
					    'width' => ( !empty( $result->ok ) ) ? $imageFile->getWidth() : 0
					),
				);

				// check if this image has correct dimensions to be placed in a slider (BugId:2787)
				if (!empty($result->ok)) {
					$ret['isImageStrict'] = !!WikiaPhotoGalleryHelper::isImageStrict($imageFile);
				}
			}
		} else {
			$reason = $nameValidation;

			self::log(__METHOD__, "upload failed - file name is not valid (error #{$reason})");

			$ret = array(
				'error' => true,
				'reason' => $reason,
				'message' => self::translateError($reason),
			);
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Try to resolve the conflict by overwriting existing image
	 */
	public static function conflictOverwrite($imageName, $tempId) {
		wfProfileIn(__METHOD__);

		$res = false;
		$tempId = intval($tempId);

		self::log(__METHOD__, "trying to resolve conflict by overwriting File:{$imageName} (temp file #{$tempId})");

		$res = self::uploadTempFileIntoMW($tempId, $imageName);

		if ($res) {
			self::log(__METHOD__, "conflicting photo uploaded as File:{$imageName}");
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Try to resolve the conflict by using different name for uploaded photo
	 */
	public static function conflictRename($newName, $tempId) {
		wfProfileIn(__METHOD__);

		$res = false;
		$tempId = intval($tempId);

		self::log(__METHOD__, "trying to resolve conflict by using new name '{$newName}' (temp file #{$tempId})");

		// check if given name is "free"?
		if (self::imageExists($newName)) {
			self::log(__METHOD__, "File:{$newName} exists!");
		} else {
			// check file name
			$nt = Title::makeTitleSafe( NS_FILE, $newName );
			if( is_null( $nt ) ) {
				self::log(__METHOD__, 'filename provided is illegal!');
			} else {
				$res = self::uploadTempFileIntoMW($tempId, $newName);

				if ($res) {
					self::log(__METHOD__, "conflicting photo uploaded as File:{$newName}");
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Perform image name check
	 */
	private static function checkImageName( $imageName, $uploadFieldName = self::DEFAULT_FILE_FIELD_NAME ) {
		global $wgRequest, $wgUser;

		$upload = new UploadFromFile();
		$upload->initializeFromRequest($wgRequest);
		$permErrors = $upload->verifyPermissions( $wgUser );

		if ( $permErrors !== true ) {
			return self::USER_PERMISSION_ERROR;
		}

		$ret = $upload->verifyUpload();

		// this hook is used by WikiaTitleBlackList extension
		if(!wfRunHooks('WikiaMiniUpload:BeforeProcessing', array($imageName))) {
			self::log(__METHOD__, 'Hook "WikiaMiniUpload:BeforeProcessing" broke processing the file');
			wfProfileOut(__METHOD__);
			return UploadBase::VERIFICATION_ERROR;
		}

		if(is_array($ret)) {
			return $ret['status'];
		} else {
			return $ret;
		}
	}

	/**
	 * Upload given file into MW
	 */
	private static function uploadIntoMW($imagePath, $imageName) {
		wfProfileIn(__METHOD__);

		self::log(__METHOD__, "uploading '{$imagePath}' as File:{$imageName}");

		// create title and file objects for MW image to create
		$imageTitle = Title::newFromText($imageName, NS_FILE);
		$imageFile = new LocalFile($imageTitle, RepoGroup::singleton()->getLocalRepo());

		// perform upload
		$result = $imageFile->upload($imagePath, '' /* comment */, '' /* page text */);

		wfProfileOut(__METHOD__);

		return !empty($result->ok);
	}

	/**
	 * Upload given temporary file (by ID) into MW
	 */
	private static function uploadTempFileIntoMW($tempId, $imageName) {
		wfProfileIn(__METHOD__);

		$res = false;

		$imagePath = self::tempFileGetPath($tempId);
		if ($imagePath) {
			$res = self::uploadIntoMW($imagePath, $imageName);
			if ($res) {
				self::log(__METHOD__, "temp file #{$tempId} uploaded as File:{$imageName}");

				// remove image from list of temporary files
				self::tempFileClearInfo($tempId);

				$res = true;
			}
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Return translated message for given upload error code
	 */
	private static function translateError ($errorCode) {
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

	/**
	 * Check if given image name is used on this wiki
	 */
	private static function imageExists($name) {
		$title = Title::makeTitleSafe(NS_IMAGE, $name);

		return !empty($title) && $title->exists();
	}

	private static function tempFileName($user) {
		return 'Temp_file_'. $user->getID(). '_' . time();
	}

	/**
	 * Store info in the db to enable the script to pick it up later during the day (via an automated cleaning routine)
	 */
	private static function tempFileStoreInfo( $filename ) {
		global $wgExternalSharedDB, $wgCityId;
		wfProfileIn(__METHOD__);

		$title = Title::makeTitle(NS_FILE, $filename);
		$localRepo = RepoGroup::singleton()->getLocalRepo();

		$path = LocalFile::newFromTitle($title, $localRepo)->getPath();

		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->insert(
			'garbage_collector',
			array(
				'gc_filename' => $path,
				'gc_timestamp' => $dbw->timestamp(),
				'gc_wiki_id' => $wgCityId,
			),
			__METHOD__
		);

		$id = $dbw->insertId();
		self::log(__METHOD__, "image stored as #{$id}");

		$dbw->commit();

		wfProfileOut(__METHOD__);
		return $id;
	}

	/**
	 * Remove the data about given file from the garbage collector
	 */
	private static function tempFileClearInfo($id) {
		global $wgExternalSharedDB;
		wfProfileIn(__METHOD__);

		$imagePath = self::tempFileGetPath($id);
		$imageName = basename($imagePath);

		self::log(__METHOD__, "removing temp file '{$imageName}' (#{$id})");

		// remove from file repo
		$imageTitle = Title::newFromText($imageName, NS_FILE);
		$repo = RepoGroup::singleton()->getLocalRepo();

		$imageFile = new FakeLocalFile($imageTitle, $repo);
		$imageFile->delete('');

		// remove from DB
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->delete(
			'garbage_collector',
			array('gc_id' => $id),
			__METHOD__
		);
		$dbw->commit();

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get temp image path by providing it's ID
	 */
	private static function tempFileGetPath($id) {
		global $wgExternalSharedDB, $wgCityId;
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

		$path = $dbr->selectField(
			'garbage_collector',
			'gc_filename',
			array('gc_id' => $id),
			__METHOD__
		);

		wfProfileOut(__METHOD__);
		return $path;
	}

	private function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}
}
