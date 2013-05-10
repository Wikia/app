<?php

/**
 * Class WikiaRevertVideoAction
 *
 * There is a core class called RevertVideoAction that is the old method of doing this.
 *
 * @author Garth Webb
 */
class WikiaRevertVideoAction extends RevertFileAction {

	/**
	 * Impliments revert functionality for videos
	 * @param Array $data - Not used but maintaining method signature
	 * @return bool - Whether the action was successful
	 */
	public function onSubmit( $data ) {
		// Get the archive name of the video
		$oldImageName = $this->getRequest()->getText( 'oldimage' );

		// Get the video file page
		$page = $this->page;

		// Get the DB version of the title text
		$title = $page->getTitle();
		$dbKey = $title->getDBkey();

		// Get the repo for this file
		$file = $page->getDisplayedFile();
		$repo = $file->repo;

		// This returns a file object for an archived version of a video
		$archiveImg = WikiaLocalFile::newFromArchiveTitle( $dbKey, $oldImageName, $repo );
		if ( empty($archiveImg) ) {
			return false;
		}

		// Get the original URL used to upload this video
		$handler = $archiveImg->getHandler();
		$providerURL = $handler->getProviderDetailUrl();

		// Upload this video again to this DB key.  This will create a new version
		$title = VideoFileUploader::URLtoTitle( $providerURL, $dbKey );

		return $title ? true : false;
	}
}