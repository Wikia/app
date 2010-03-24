<?php

/**
 * This class handles images upload with extra security checks.
 *
 * This code is mostly copied from WikiaMiniUpload extension.
 */

class WikiaPhotoGalleryUpload {

	const uploadFieldName = 'wpUploadFile';

	/**
	 * Handle image upload
	 *
 	 * Returns array with uploaded files details or error details
	 */
	public static function uploadImage() {
		global $IP, $wgRequest, $wgUser;

		wfProfileIn(__METHOD__);

		$ret = false;

		$imageName = stripslashes($wgRequest->getFileName(self::uploadFieldName));

		// validate name and content of uploaded photo
		$nameValidation = self::checkImageName($imageName);
		$contentValidation = self::checkUploadedContent();

		if ($nameValidation == UploadForm::SUCCESS && $contentValidation == UploadForm::SUCCESS) {
			// get path to uploaded image
			$imagePath = $wgRequest->getFileTempName(self::uploadFieldName);

			// check if image with this name is already uploaded
			if (self::imageExists($imageName)) {
				// upload as temporary file
				self::log(__METHOD__, "image '{$imageName}' already exists!");

				$tempName = self::tempFileName($wgUser);

				$title = Title::makeTitle(NS_FILE, $tempName);
				$localRepo = RepoGroup::singleton()->getLocalRepo();

				$file = new FakeLocalFile($title, $localRepo);
				$file->upload($wgRequest->getFileTempName(self::uploadFieldName), '', '');

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
				list($fileName, $extensionsName) = UploadForm::splitExtensions($imageName);
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
					'thumbnail' => array(
						'height' => $thumbnail->height,
						'url' => $thumbnail->url,
						'width' => $thumbnail->width,
					),
				);
			}
			else {
				// use regular MW upload
				self::log(__METHOD__, "image '{$imageName}' is new one - uploading as MW file");

				$result = self::uploadIntoMW($imagePath, $imageName);
				self::log(__METHOD__, $result ? 'upload successful' : 'upload failed');

				$ret = array(
					'success' => $result,
					'name' => $imageName,
				);
			}
		}
		else {
			$reason = $nameValidation | $contentValidation;

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
		}
		// check file name
		else if (self::checkImageName($newName) != UploadForm::SUCCESS) {
			self::log(__METHOD__, 'filename provided is illegal!');
		}
		else {
			$res = self::uploadTempFileIntoMW($tempId, $newName);

			if ($res) {
				self::log(__METHOD__, "conflicting photo uploaded as File:{$newName}");
			}
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Perform image name check
	 */
	private static function checkImageName($imageName) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		self::log(__METHOD__, "checking image name '{$imageName}'");

		$form = new UploadForm($wgRequest);

		// validate image name
		$filtered = wfStripIllegalFilenameChars($imageName);
		if ($imageName != $filtered) {
			wfProfileOut(__METHOD__);
			return UploadForm::ILLEGAL_FILENAME;
		}

		// illegal filename
		$imageTitle = Title::makeTitleSafe(NS_IMAGE, $imageName);
		if (empty($imageTitle)) {
			wfProfileOut(__METHOD__);
			return UploadForm::ILLEGAL_FILENAME;
		}

		// extensions check
		list($partname, $ext) = $form->splitExtensions($imageName);

		$finalExt = !empty($ext) ? end($ext) : '';

		// for more than one "extension" (like foo.tar.gz)
		if (count($ext) > 1) {
			$partname .= '.' . implode('.', $ext);
		}

		if ($partname == '') {
			wfProfileOut(__METHOD__);
			return UploadForm::ILLEGAL_FILENAME;
		}

		self::log(__METHOD__, "validating '{$partname}' filename and '{$finalExt}' extension");

		global $wgCheckFileExtensions, $wgStrictFileExtensions;
		global $wgFileExtensions, $wgFileBlacklist;
		if ($finalExt == '') {
			wfProfileOut(__METHOD__);
			return UploadForm::FILETYPE_MISSING;
		}

		elseif ( $form->checkFileExtensionList( $ext, $wgFileBlacklist ) ||
				($wgCheckFileExtensions && $wgStrictFileExtensions &&
					!$form->checkFileExtension( $finalExt, $wgFileExtensions ) ) ) {
			wfProfileOut(__METHOD__);
			return UploadForm::FILETYPE_BADTYPE;
		}

		// this hook is used by WikiaTitleBlackList extension
		if(!wfRunHooks('WikiaMiniUpload:BeforeProcessing', $imageName)) {
			self::log(__METHOD__, 'Hook "WikiaMiniUpload:BeforeProcessing" broke processing the file');
			wfProfileOut(__METHOD__);
			return UploadForm::VERIFICATION_ERROR;
		}

		self::log(__METHOD__, "'{$imageName}' validated");

		wfProfileOut(__METHOD__);
		return UploadForm::SUCCESS;
	}

	/**
	 * Perform uploaded content check
	 */
	private static function checkUploadedContent() {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$form = new UploadForm($wgRequest);

		// get name of uploaded image
		$imageName = stripslashes($wgRequest->getFileName(self::uploadFieldName));

		// file is empty - don't perform any further checks
		if ($imageName == '') {
			self::log(__METHOD__, 'failed!');

			wfProfileOut(__METHOD__);
			return UploadForm::ILLEGAL_FILENAME;
		}

		// get extension from image name
		list($partname, $ext) = $form->splitExtensions($imageName);
		$finalExt = !empty($ext) ? end($ext) : '';

		// check uploaded content
		$form->mFileProps = File::getPropsFromPath($form->mTempPath, $finalExt);
		$form->checkMacBinary();
		$result = $form->verify($form->mTempPath, $finalExt);

		if (!$result) {
			self::log(__METHOD__, 'failed!');

			wfProfileOut(__METHOD__);
			return UploadForm::VERIFICATION_ERROR;
		}
		else {
			self::log(__METHOD__, 'validated');

			wfProfileOut(__METHOD__);
			return UploadForm::SUCCESS;
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
			case UploadForm::ILLEGAL_FILENAME:
				$ret = wfMsg('wikiaPhotoGallery-upload-error-filename-incorrect');
				break;

			case UploadForm::FILETYPE_MISSING:
				$ret = wfMsg('wikiaPhotoGallery-upload-error-filetype-missing');
				break;

			case UploadForm::FILETYPE_BADTYPE:
				$ret = wfMsg('wikiaPhotoGallery-upload-error-filetype-incorrect');
				break;

			case UploadForm::VERIFICATION_ERROR:
				$ret = "File type verification error!" ;
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
