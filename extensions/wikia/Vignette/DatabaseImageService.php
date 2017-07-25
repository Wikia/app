<?php

class DatabaseImageService implements ImageService {
	const IMAGE_TABLE = 'image';
	const OLDIMAGE_TABLE = 'oldimage';

	private $database;
	private $fileRepo;

	public function __construct( DatabaseBase $database, FileRepo $fileRepo ) {
		$this->database = $database;
		$this->fileRepo = $fileRepo;
	}

	/**
	 * @param ImageRevision $revision
	 * @return bool|LocalFile|OldLocalFile|OldWikiaLocalFile
	 */
	public function getArchivedRevision( ImageRevision $revision ) {
		$whereMatches = [
			'oi_name' => $revision->getFileName(),
			'oi_timestamp' => $revision->getUploadDate()
		];

		$imageInfo = $this->database->selectRow( static::OLDIMAGE_TABLE, '*', $whereMatches, __METHOD__ );

		return $imageInfo ? OldWikiaLocalFile::newFromRow( $imageInfo, $this->fileRepo ) : false;
	}

	/**
	 * @param ImageRevision $revision
	 * @return bool|LocalFile
	 */
	public function getMostRecentRevision( ImageRevision $revision ) {
		$whereMatches = [
			'img_name' => $revision->getFileName(),
			'img_timestamp' => $revision->getUploadDate()
		];

		$imageInfo = $this->database->selectRow( static::IMAGE_TABLE, '*', $whereMatches, __METHOD__ );

		return $imageInfo ? WikiaLocalFile::newFromRow( $imageInfo, $this->fileRepo ) : false;
	}
}
