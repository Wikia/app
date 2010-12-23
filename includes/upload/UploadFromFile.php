<?php
/**
 * @file
 * @ingroup upload
 *
 * @author Bryan Tong Minh
 *
 * Implements regular file uploads
 */
class UploadFromFile extends UploadBase {

	const FILE_FIELD_NAME = 'wpUploadFile';
	const DEST_FIELD_NAME = 'wpDestFile';

	function initializeFromRequest( &$request, $fileField = UploadFromFile::FILE_FIELD_NAME, $destField = UploadFromFile::DEST_FIELD_NAME ) {
		$desiredDestName = $request->getText( $destField );
		if( !$desiredDestName )
			$desiredDestName = $request->getFileName( $fileField );
		return $this->initializePathInfo(
			$desiredDestName,
			$request->getFileTempName( $fileField ),
			$request->getFileSize( $fileField )
		);
	}
	/**
	 * Entry point for upload from file.
	 */
	function initialize( $name, $tempPath, $fileSize ) {
		 return $this->initializePathInfo( $name, $tempPath, $fileSize );
	}
	static function isValidRequest( $request ) {
		return (bool)$request->getFileTempName( 'wpUploadFile' );
	}
}
