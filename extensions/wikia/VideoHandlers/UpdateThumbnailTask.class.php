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
			if ( $title instanceof Title ) {
				$title = $title->getText();
			}
			$this->log( "error", $delayIndex, $title, $provider, [ "errorMsg" => $msg ] );
			return Status::newFatal( $msg );
		}

		if ( !$file->isLocal() ) {
			return Status::newFatal( "Cannot update foreign video thumbnail" );
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
				$msg = "Error uploading video thumbnail: $response";
				$status = Status::newFatal( $msg );
			}
		} else {
			$helper = new VideoHandlerHelper();
			$status = $helper->resetVideoThumb( $file, null, $delayIndex );
		}

		if ( $status->isGood() ) {
			// A good status doesn't necessarily mean we updated the actual thumbnail. A good status is returned for
			// successfully uploading the default thumb as well. Actually check the img sha to see if the thumb changed
			if ( $file->getSha1() != self::DEFAULT_THUMB_SHA ) {
				$this->log( "success", $delayIndex, $title->getText(), $provider, [ 'thumbnail' => $file->getThumbUrl() ] );
			}
		} else {
			$this->log( "error", $delayIndex, $title->getText(), $provider, [ 'errorMsg' => $status->getMessage() ] );
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

	/**
	 * Logs a message regarding the status of an UpdateThumbnail Task.
	 * @param $action String, one of "start", "error" or "success"
	 * @param $delayIndex Integer, Corresponds to an index in one of the self::$delays
	 * @param $title String, The title of the video
	 * @param $provider String, The provider of the video
	 * @param array $extraInfo, Any extra information we want to log
	 */
	public function log( $action, $delayIndex, $title, $provider, $extraInfo = [] ) {
		$context = [
			"action" => $action,
			"attemptCount" => $delayIndex,
			"timeWaited" => self::getDelay( $provider, $delayIndex - 1 ),
			"title" => $title,
			"provider" => $provider
		];
		$context = array_merge( $context, $extraInfo );

		if ( $action == "error" ) {
			WikiaLogger::instance()->error( "UpdateThumbnailTaskLogging", $context );
		} else {
			WikiaLogger::instance()->info( "UpdateThumbnailTaskLogging", $context );
		}
	}
}
