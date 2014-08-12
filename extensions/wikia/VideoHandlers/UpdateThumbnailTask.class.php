<?php
use Wikia\Tasks\Tasks\BaseTask;

class UpdateThumbnailTask extends BaseTask {

	const DEFAULT_PROVIDER = "default";
	const IVA = "ooyala/iva";

	private static $delays = [
		self::DEFAULT_PROVIDER => [
			"5 minutes",
			"1 hour",
			"1 day" ],
		self::IVA => [
			"5 minutes",
			"1 hour",
			"1 week" ]
	];

	/**
	 * This task is run when a video is uploaded but the provider does not have a
	 * thumbnail for us to use. This gets triggered the first time a thumbnail
	 * cannot be found, and is queued up again at longer intervals until we either
	 * get a thumbnail from the provider, or exhaust all of our attempts.
	 * @param $title
	 * @param $delayIndex
	 * @param $provider
	 * @param $videoId
	 * @return FileRepoStatus
	 */
	public function retryThumbUpload( $title, $delayIndex, $provider, $videoId ) {
		global $IP, $wgCityId;
		// IVA requires extra steps to update their thumbnail, use the script we have for that
		$delayIndex++;
		if ( $provider == self::IVA ) {
			$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/wikia/VideoHandlers/updateOoyalaThumbnail.php --videoId={$videoId} --delayIndex={$delayIndex}" );
			$response = wfShellExec( $cmd, $exitStatus );
			if ( $exitStatus == 0 ) {
				$msg = "Video thumbnail uploaded successfully";
				$status = Status::newGood( $msg );
			} else {
				$msg = "Error uploading video thumbnail";
				$status = Status::newFatal( $msg );
			}
		} else {
			$file = WikiaFileHelper::getVideoFileFromTitle( $title );
			$helper = new VideoHandlerHelper();
			$status = $helper->resetVideoThumb( $file, null, $delayIndex );
		}
		return $status;
	}

	/**
	 * Get a delay value determined by 1.) the provider, and 2.)
	 * the number of times we've tried to reupload the video
	 * @param $provider
	 * @param $index
	 * @return string Length of time to delay the job
	 */
	public static function getDelay( $provider, $index ) {
		if ( !isset( self::$delays[$provider] ) ) {
			$provider = self::DEFAULT_PROVIDER;
		}
		return self::$delays[$provider][$index];
	}

	/**
	 * Get the number of times we should try and re-upload
	 * a video's thumbnail, based on provider.
	 * @param $provider
	 * @return int Number of times to retry the thumbnail upload
	 */
	public static function getDelayCount( $provider ) {
		if ( !isset( self::$delays[$provider] ) ) {
			$provider = self::DEFAULT_PROVIDER;
		}
		return count( self::$delays[$provider] );
	}
}
