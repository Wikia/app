<?
class WikiaUploadStash extends UploadStash {

	/**
	 * Helper function: Initialize the WikiaUploadStashFile for a given file.
	 *
	 * @param $path String: path to file
	 * @param $key String: key under which to store the object
	 * @throws UploadStashZeroLengthFileException
	 * @return bool
	 */
	protected function initFile( $key ) {
		$file = new WikiaUploadStashFile( $this->repo, $this->fileMetadata[$key]['us_path'], $key );
		if ( $file->getSize() === 0 ) {
			throw new UploadStashZeroLengthFileException( "File is zero length" );
		}
		$this->files[$key] = $file;
		return true;
	}
}
