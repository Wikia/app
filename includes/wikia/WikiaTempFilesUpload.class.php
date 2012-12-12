<?php

/**
 * This class handles images with temp store
 *
 **/

class WikiaTempFilesUpload {

	const USER_PERMISSION_ERROR = -1;

	/**
	 * Upload given file into MW
	 */
	public function uploadIntoMW($imagePath, $imageName) {
		wfProfileIn(__METHOD__);

		$this->log(__METHOD__, "uploading '{$imagePath}' as File:{$imageName}");

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
	public function uploadTempFileIntoMW($tempId, $imageName) {
		wfProfileIn(__METHOD__);

		$res = false;

		$imagePath = $this->tempFileGetPath($tempId);
		if ($imagePath) {
			$res = $this->uploadIntoMW($imagePath, $imageName);
			if ($res) {
				$this->log(__METHOD__, "temp file #{$tempId} uploaded as File:{$imageName}");

				// remove image from list of temporary files
				$this->tempFileClearInfo($tempId);

				$res = true;
			}
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Check if given image name is used on this wiki
	 */
	public function imageExists($name) {
		$title = Title::makeTitleSafe(NS_IMAGE, $name);

		return !empty($title) && $title->exists();
	}

	public function tempFileName($user) {
		return 'Temp_file_'. $user->getID(). '_' . time();
	}

	/**
	 * Store info in the db to enable the script to pick it up later during the day (via an automated cleaning routine)
	 */
	public function tempFileStoreInfo( $filename ) {
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
		$this->log(__METHOD__, "image stored as #{$id}");

		$dbw->commit();

		wfProfileOut(__METHOD__);
		return $id;
	}

	/**
	 * Remove the data about given file from the garbage collector
	 */
	public function tempFileClearInfo($id) {
		global $wgExternalSharedDB;
		wfProfileIn(__METHOD__);

		$imagePath = $this->tempFileGetPath($id);
		$imageName = basename($imagePath);

		$this->log(__METHOD__, "removing temp file '{$imageName}' (#{$id})");

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
	public function tempFileGetPath($id) {
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

	/**
	 * Perform image name check
	 */
	public function checkImageName( $imageName, $uploadFieldName ) {
		global $wgRequest, $wgUser;
		wfProfileIn(__METHOD__);

		$upload = new UploadFromFile();
		$upload->initializeFromRequest($wgRequest);
		$permErrors = $upload->verifyPermissions( $wgUser );

		if ( $permErrors !== true ) {
			wfProfileOut(__METHOD__);
			return self::USER_PERMISSION_ERROR;
		}

		$ret = $upload->verifyUpload();

		// this hook is used by WikiaTitleBlackList extension
		if(!wfRunHooks('WikiaMiniUpload:BeforeProcessing', array($imageName))) {
			$this->log(__METHOD__, 'Hook "WikiaMiniUpload:BeforeProcessing" broke processing the file');
			wfProfileOut(__METHOD__);
			return UploadBase::VERIFICATION_ERROR;
		}

		wfProfileOut(__METHOD__);
		if(is_array($ret)) {
			return $ret['status'];
		} else {
			return $ret;
		}
	}

	public function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}
}
