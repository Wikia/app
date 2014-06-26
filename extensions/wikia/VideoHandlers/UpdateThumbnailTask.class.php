<?php
use Wikia\Tasks\Tasks\BaseTask;

class UpdateThumbnailTask extends BaseTask {

	const DONT_RUN = -1;

	public function retryThumbUpload( $title, $delayIndex ) {
		$file = WikiaFileHelper::getVideoFileFromTitle( $title );
		$helper = new VideoHandlerHelper();
		$delayIndex++;
		$status = $helper->resetVideoThumb( $file, null, $delayIndex );
		return $status;
	}

}
