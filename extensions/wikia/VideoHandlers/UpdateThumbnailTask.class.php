<?php
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Logger\WikiaLogger;

class UpdateThumbnailTask extends BaseTask {

	const DEFAULT_PROVIDER = "default";
	const IVA = "ooyala/iva";
	const DEFAULT_THUMB_SHA = "m03a6fnvxhk8oj5kgnt11t6j7phj5nh";

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

		/** @var Title $title */
		$file = WikiaFileHelper::getVideoFileFromTitle( $title );
		if ( empty( $file ) ) {
			$msg = "File not found on wiki";
			$this->log( "error", $title, $delayIndex, $provider, [ "errorMsg" => $msg ] );
			return Status::newFatal( $msg );
		}

		$delayIndex++;
		$this->log( "start", $delayIndex, $title->getText(), $provider );

		// IVA requires extra steps to update their thumbnail, use the script we have for that
		if ( $provider == self::IVA ) {
			$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/wikia/VideoHandlers/updateOoyalaThumbnail.php --videoId={$videoId} --delayIndex={$delayIndex}" );
			$response = wfShellExec( $cmd, $exitStatus );
			if ( $exitStatus == 0 ) {
				$msg = "Video thumbnail uploaded successfully";
				$status = Status::newGood( $msg );
			} else {
				$status = Status::newFatal( $response );
			}
		} else {
			$helper = new VideoHandlerHelper();
			$status = $helper->resetVideoThumb( $file, null, $delayIndex );
		}

		if ( !$status->isGood() ) {
			$this->log( "error", $delayIndex, $title->getText(), $provider, [ 'errorMsg' => $status->getMessage() ] );
		} elseif ( $file->getSha1() != self::DEFAULT_THUMB_SHA ) {
			$this->log( "success", $delayIndex, $title->getText(), $provider, [ 'thumbnail' => $file->getThumbUrl() ] );
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

	public function log( $action, $delay, $title, $provider, $extraInfo = [] ) {
		$context = [
			"action" => $action,
			"attemptCount" => $delay,
			"timeWaited" => self::getDelay( $provider, $delay - 1 ),
			"title" => $title,
			"provider" => $provider
		];
		$context = array_merge( $context, $extraInfo );

		WikiaLogger::instance()->info( "UpdateThumbnailTaskLogging", $context );
	}
}
