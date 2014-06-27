<?php
use Wikia\Tasks\Tasks\BaseTask;

class UpdateThumbnailTask extends BaseTask {

	const DONT_RUN = -1;

	/**
	 * This task is run when a video is uploaded but the provider does not have a
	 * thumbnail for us to use. This gets triggered the first time a thumbnail
	 * cannot be found, and is queued up again at longer intervals until we either
	 * get a thumbnail from the provider, or exhaust all of our attempts.
	 * @param $title
	 * @param $delayIndex
	 * @return FileRepoStatus
	 */
	public function retryThumbUpload( $title, $delayIndex ) {
		$file = WikiaFileHelper::getVideoFileFromTitle( $title );
		$helper = new VideoHandlerHelper();
		$status = $helper->resetVideoThumb( $file, null, $delayIndex+1 );
		return $status;
	}

}
