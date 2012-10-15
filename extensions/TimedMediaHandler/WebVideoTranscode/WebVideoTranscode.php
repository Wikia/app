<?php

/**
 * WebVideoTranscode provides:
 *  encode keys
 *  encode settings
 *
 * 	extends api to return all the streams
 *  extends video tag output to provide all the available sources
 */


/**
 * Main WebVideoTranscode Class hold some constants and config values
 */
class WebVideoTranscode {

	/**
	* Key constants for the derivatives,
	* this key is appended to the derivative file name
	*
	* If you update the wgDerivativeSettings for one of these keys
	* and want to re-generate the video you should also update the
	* key constant. ( Or just run a maintenance script to delete all
	* the assets for a given profile )
	*
	* Msg keys for derivatives are set as follows:
	* $messages['timedmedia-derivative-200_200kbs.ogv'] => 'Ogg 200';
	*/

	// Ogg Profiles
	const ENC_OGV_160P = '160p.ogv';
	const ENC_OGV_360P = '360p.ogv';
	const ENC_OGV_480P = '480p.ogv';
	const ENC_OGV_720P = '720p.ogv';

	// WebM profiles:
	const ENC_WEBM_360P = '360p.webm';
	const ENC_WEBM_480P = '480p.webm';
	const ENC_WEBM_720P = '720p.webm';

	// Static cache of transcode state per instantiation
	public static $transcodeState = array() ;

	/**
	* Encoding parameters are set via firefogg encode api
	*
	* For clarity and compatibility with passing down
	* client side encode settings at point of upload
	*
	* http://firefogg.org/dev/index.html
	*/
	public static $derivativeSettings = array(
		WebVideoTranscode::ENC_OGV_160P =>
			array(
				'maxSize'			=> '288x160',
				'videoBitrate'		=> '160',
				'framerate'			=> '15',
				'audioQuality'		=> '-1',
				'samplerate'		=> '44100',
				'channels'			=> '2',
				'noUpscaling'		=> 'true',
				'twopass'			=> 'true',
				'keyframeInterval'	=> '128',
				'bufDelay'			=> '256',
				'videoCodec' 		=> 'theora',
			),
		WebVideoTranscode::ENC_OGV_360P =>
			array(
				'maxSize'			=> '640x360',
				'videoBitrate'		=> '512',
				'audioQuality'		=> '1',
				'samplerate'		=> '44100',
				'channels'			=> '2',
				'noUpscaling'		=> 'true',
				'twopass'			=> 'true',
				'keyframeInterval'	=> '128',
				'bufDelay'			=> '256',
				'videoCodec'		=> 'theora',
			),
		WebVideoTranscode::ENC_OGV_480P =>
			array(
				'maxSize'			=> '854x480',
				'videoBitrate'		=> '1024',
				'audioQuality'		=> '2',
				'samplerate'		=> '44100',
				'channels'			=> '2',
				'noUpscaling'		=> 'true',
				'twopass'			=> 'true',
				'keyframeInterval'	=> '128',
				'bufDelay'			=> '256',
				'videoCodec' 		=> 'theora',
			),

		WebVideoTranscode::ENC_OGV_720P =>
			array(
				'maxSize'			=> '1280x720',
				'videoQuality'		=> 6,
				'audioQuality'		=> 3,
				'noUpscaling'		=> 'true',
				'keyframeInterval'	=> '128',
				'videoCodec' 		=> 'theora',
			),

		// WebM transcode:
		WebVideoTranscode::ENC_WEBM_360P =>
			array(
				'maxSize'			=> '640x360',
				'videoBitrate'		=> '512',
				'audioQuality'		=> '1',
				'samplerate'		=> '44100',
				'noUpscaling'		=> 'true',
				'twopass'			=> 'true',
				'keyframeInterval'	=> '128',
				'bufDelay'			=> '256',
				'videoCodec' 		=> 'vp8',
			),
		WebVideoTranscode::ENC_WEBM_480P =>
			array(
			 	'maxSize'			=> '854x480',
				'videoBitrate'		=> '1024',
				'audioQuality'		=> '2',
				'samplerate'		=> '44100',
				'noUpscaling'		=> 'true',
				'twopass'			=> 'true',
				'keyframeInterval'	=> '128',
				'bufDelay'			=> '256',
				'videoCodec' 		=> 'vp8',
			),
		WebVideoTranscode::ENC_WEBM_720P =>
			 array(
				'maxSize'			=> '1280x720',
				'videoQuality'		=> 7,
				'audioQuality'		=> 3,
				'noUpscaling'		=> 'true',
				'videoCodec' 		=> 'vp8',
			)
	);

	static public function getDerivativeFilePath( &$file, $transcodeKey){
		return dirname(
				$file->getThumbPath(
					$file->thumbName( array() )
				)
			) . '/' .
			$file->getName() . '.' .
			$transcodeKey ;
	}

	/**
	 * Get the target encode path for a video encode
	 *
	 * @param $file File
	 * @param $transcodeKey String
	 *
	 * @return the local target encode path
	 */
	static public function getTargetEncodePath( &$file, $transcodeKey ){
		$filePath = self::getDerivativeFilePath( $file, $transcodeKey );
		$ext = strtolower( pathinfo( "$filePath", PATHINFO_EXTENSION ) );

		// Create a temp FS file with the same extension
		$tmpFile = TempFSFile::factory( 'transcode_' . $transcodeKey, $ext);
		if ( !$tmpFile ) {
			return False;
		}
		$tmpFile->bind( $file );
		return $tmpFile->getPath(); //path with 0-byte temp file
	}

	/**
	 * Get the max size of the web stream ( constant bitrate )
	 */
	static public function getMaxSizeWebStream(){
		global $wgEnabledTranscodeSet;
		$maxSize = 0;
		foreach( $wgEnabledTranscodeSet as $transcodeKey ){
			if( isset( self::$derivativeSettings[$transcodeKey]['videoBitrate'] ) ){
				$maxSize = self::$derivativeSettings[$transcodeKey]['maxSize'];
			}
		}
		return $maxSize;
	}
	/**
	 * Give a rough estimate on file size
	 * Note this is not always accurate.. especially with variable bitrate codecs ;)
	 */
	static public function getProjectedFileSize( $file, $transcodeKey){
		$settings = self::$derivativeSettings[$transcodeKey];
		if( $settings[ 'videoBitrate' ] && $settings['audioBitrate'] ){
			return $file->getLength * 8 * (
				self::$derivativeSettings[$transcodeKey]['videoBitrate']
				+
				self::$derivativeSettings[$transcodeKey]['audioBitrate']
			);
		}
		// Else just return the size of the source video ( we have no idea how large the actual derivative size will be )
		return $file->getLength * $file->getHandler()->getBitrate( $file ) * 8;
	}

	/**
	 * Static function to get the set of video assets
	 * Checks if the file is local or remote and grabs respective sources
	 */
	static public function getSources( &$file , $options = array() ){
		if( $file->isLocal() ){
			return self::getLocalSources( $file , $options );
		}else {
			return self::getRemoteSources( $file , $options );
		}
	}
	/**
	 * Grabs sources from the remote repo via ApiQueryVideoInfo.php entry point.
	 *
	 * Because this works with commons regardless of whether TimedMediaHandler is installed or not
	 */
	static public function getRemoteSources(&$file , $options = array() ){
		global $wgMemc;
		// Setup source attribute options
		$dataPrefix = in_array( 'nodata', $options )? '': 'data-';

		// Use descriptionCacheExpiry as our expire for timed text tracks info
		if ( $file->repo->descriptionCacheExpiry > 0 ) {
			wfDebug("Attempting to get sources from cache...");
			$key = $file->repo->getLocalCacheKey( 'WebVideoSources', 'url', $file->getName() );
			$sources = $wgMemc->get($key);
			if ( $sources ) {
				wfDebug("Success found sources in local cache\n");
				return $sources;
			}
			wfDebug("source cache miss\n");
		}
		wfDebug("Get Video sources from remote api \n");
		$data = $file->repo->fetchImageQuery(  array(
			'action' => 'query',
			'prop' => 'videoinfo',
			'viprop' => 'derivatives',
			'title' => $file->getTitle()->getDBKey()
		) );

		if( isset( $data['warnings'] ) && isset( $data['warnings']['query'] )
			&& $data['warnings']['query']['*'] == "Unrecognized value for parameter 'prop': videoinfo" )
		{
			// Commons does not yet have TimedMediaHandler.
			// Use the normal file repo system single source:
			return array( self::getPrimarySourceAttributes( $file, array( $dataPrefix ) ) );
		}
		$sources = array();
		// Generate the source list from the data response:
		if( $data['query'] && $data['query']['pages'] ){
			$vidResult = first( $data['query']['pages'] );
			if( $vidResult['videoinfo'] ){
				$derResult =  first( $vidResult['videoinfo'] );
				$derivatives = $derResult['derivatives'];
				foreach( $derivatives as $derivativeSource ){
					$sources[] = $derivativeSource;
				}
			}
		}

		// Update the cache:
		if ( $sources && $this->file->repo->descriptionCacheExpiry > 0 ) {
			$wgMemc->set( $key, $sources, $this->file->repo->descriptionCacheExpiry );
		}

		return $sources;

	}

	/**
	 * Based on the $wgEnabledTranscodeSet set of enabled derivatives we
	 * sync the database with $wgEnabledTranscodeSet and return sources that are ready
	 *
	 * If no transcode is in progress or ready add the job to the jobQueue
	 *
	 * @param {Object} File object
	 * @param {Object} Options, a set of options:
	 * 					'nodata' Strips the data- attribute, useful when your output is not html
	 * @return an associative array of sources suitable for <source> tag output
	 */
	static public function getLocalSources( &$file , $options=array() ){
		global $wgEnabledTranscodeSet, $wgEnableTranscode, $wgLang;
		$sources = array();

		// Add the original file:
		$sources[] = self::getPrimarySourceAttributes( $file, $options );

		// If $wgEnableTranscode is false don't look for or add other local sources:
		if( $wgEnableTranscode === false ){
			return $sources;
		}

		// If an "oldFile" don't look for other sources:
		if( $file->isOld() ){
			return $sources;
		}

		// Just directly return audio sources ( No transcoding for audio for now )
		if( $file->getHandler()->isAudio( $file ) ){
			return $sources;
		}

		// Setup local variables
		$fileName = $file->getName();

		$addOggFlag = false;
		$addWebMFlag = false;

		$ext = pathinfo( "$fileName", PATHINFO_EXTENSION);

		// Check the source file for .webm extension
		if( strtolower( $ext )== 'webm' ) {
			$addWebMFlag = true;
		} else {
			// If not webm assume ogg as the source file
			$addOggFlag = true;
		}

		// Now Check for derivatives and add to transcode table if missing:
		foreach( $wgEnabledTranscodeSet as $transcodeKey ){
			$codec =  self::$derivativeSettings[$transcodeKey]['videoCodec'];
			// Check if we should add derivative to job queue
			// Skip if we have both an Ogg & WebM and if target encode larger than source
			if( self::isTargetLargerThanFile( $file, self::$derivativeSettings[$transcodeKey]['maxSize']) ){
				continue;
			}
			// if we going to try add source for this derivative, update codec flags:
			if( $codec == 'theora' ){
				$addOggFlag = true;
			}
			if( $codec == 'vp8' ){
				$addWebMFlag = true;
			}
			// Try and add the source
			self::addSourceIfReady( $file, $sources, $transcodeKey, $options );
		}
		// Make sure we have at least one ogg and webm encode
		if( !$addOggFlag || !$addWebMFlag ){
			foreach( $wgEnabledTranscodeSet as $transcodeKey ){
				if( !$addOggFlag && self::$derivativeSettings[$transcodeKey]['videoCodec'] == 'theora' ){
					self::addSourceIfReady( $file, $sources, $transcodeKey, $options );
					$addOggFlag = true;
				}
				if( !$addWebMFlag && self::$derivativeSettings[$transcodeKey]['videoCodec'] == 'vp8' ){
					self::addSourceIfReady( $file, $sources, $transcodeKey, $options );
					$addWebMFlag = true;
				}
			}
		}
		return $sources;
	}

	/**
	 * Get the transcode state for a given filename and transcodeKey
	 *
	 * @param {string} $fileName
	 */
	public static function isTranscodeReady( $fileName, $transcodeKey ){

		// Check if we need to populate the transcodeState cache:
		$transcodeState =  self::getTranscodeState( $fileName );

		// If no state is found the cache for this file is false:
		if( !isset( $transcodeState[ $transcodeKey ] ) ) {
			return false;
		}
		// Else return boolean ready state ( if not null, then ready ):
		return !is_null( $transcodeState[ $transcodeKey ]['time_success'] );
	}
	/**
	 * Clear the transcode state cache:
	 * @param String $fileName Optional fileName to clear transcode cache for
	 */
	public static function clearTranscodeCache( $fileName = null){
		if( $fileName ){
			unset( self::$transcodeState[ $fileName ] );
		} else {
			self::$transcodeState = array();
		}
	}

	/**
	 * Populates the transcode table with the current DB state of transcodes
	 * if transcodes are not found in the database their state is set to "false"
	 *
	 * @param string $fileName key
	 */
	public static function getTranscodeState( $fileName ){
		if( ! isset( self::$transcodeState[$fileName] ) ){
			wfProfileIn( __METHOD__ );
			// initialize the transcode state array
			self::$transcodeState[ $fileName ] = array();
			$res = wfGetDB( DB_SLAVE )->select( 'transcode',
					'*',
					array( 'transcode_image_name' => $fileName ),
					__METHOD__,
					array( 'LIMIT' => 100 )
			);
			// Populate the per transcode state cache
			foreach ( $res as $row ) {
				// strip the out the "transcode_" from keys
				$trascodeState = array();
				foreach( $row as $k => $v ){
					$trascodeState[ str_replace( 'transcode_', '', $k ) ] = $v;
				}
				self::$transcodeState[ $fileName ][ $row->transcode_key ] = $trascodeState;
			}
			wfProfileOut( __METHOD__ );
		}
		return self::$transcodeState[ $fileName ];
	}

	/**
	 * Remove any transcode files and db states associated with a given $title
	 *
	 * also remove the transcode files:
	 * @param $titleObj Title Object
	 * @param $transcodeKey String Optional transcode key to remove only this key
	 */
	public static function removeTranscodes( &$titleObj, $transcodeKey = false ){
		$file = wfFindFile($titleObj );

		// if transcode key is non-false, non-null:
		if( $transcodeKey ){
			// only remove the requested $transcodeKey
			$removeKeys = array( $transcodeKey );
		} else {
			// Remove any existing files ( regardless of their state )
			$res = wfGetDB( DB_SLAVE )->select( 'transcode',
				array( 'transcode_key' ),
				array( 'transcode_image_name' => $titleObj->getDBKey() )
			);
			$removeKeys = array();
			foreach( $res as $transcodeRow ){
				$removeKeys[] = $transcodeRow->transcode_key;
			}
		}

		// Remove files by key:
		foreach( $removeKeys as $tKey){
			$filePath = self::getDerivativeFilePath($file,  $tKey);
			if( is_file( $filePath ) ){
				if( ! @unlink( $filePath ) ){
					wfDebug( "Could not delete file $filePath\n" );
				}
			}
		}

		// Build the sql query:
		$dbw = wfGetDB( DB_MASTER );
		$deleteWhere = array( 'transcode_image_name ='. $dbw->addQuotes( $titleObj->getDBkey() ) );
		// Check if we are removing a specific transcode key
		if( $transcodeKey !== false ){
			$deleteWhere[] = 'transcode_key =' . $dbw->addQuotes( $transcodeKey );
		}
		// Remove the db entries
		$dbw->delete( 'transcode', $deleteWhere, __METHOD__ );

		// Purge the cache for pages that include this video:
		self::invalidatePagesWithFile( $titleObj );

		// Remove from local WebVideoTranscode cache:
		self::clearTranscodeCache(  $titleObj->getDBKey()  );
	}

	public static function invalidatePagesWithFile( &$titleObj ){
		wfDebug("WebVideoTranscode:: Invalidate pages that include: " . $titleObj->getDBKey() );
		// Purge the main image page:
		$titleObj->invalidateCache();

		// TODO if the video is used in over 500 pages add to 'job queue'
		// TODO interwiki invalidation ?
		$limit = 500;
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'imagelinks', 'page' ),
			array( 'page_namespace', 'page_title' ),
			array( 'il_to' => $titleObj->getDBkey(), 'il_from = page_id' ),
			__METHOD__,
			array( 'LIMIT' => $limit + 1 )
		);
		foreach ( $res as $page ) {
			$title = Title::makeTitle( $page->page_namespace, $page->page_title );
			$title->invalidateCache();
		}
	}

	/**
	 * Add a source to the sources list if the transcode job is ready
	 * if the source is not found update the job queue
	 */
	public static function addSourceIfReady( &$file, &$sources, $transcodeKey, $dataPrefix = '' ){
		global $wgLang;
		$fileName = $file->getTitle()->getDbKey();
		// Check if the transcode is ready:
		if( self::isTranscodeReady( $fileName, $transcodeKey ) ){
			$sources[] = self::getDerivativeSourceAttributes( $file, $transcodeKey, $dataPrefix );
		} else {
			self::updateJobQueue( $file, $transcodeKey );
		}
	}
	/**
	 * Get the primary "source" asset used for other derivatives
	 */
	static public function getPrimarySourceAttributes($file, $options = array() ){
		global $wgLang;
		// Setup source attribute options
		$dataPrefix = in_array( 'nodata', $options )? '': 'data-';
		$src = in_array( 'fullurl', $options)?  wfExpandUrl( $file->getUrl() ) : $file->getUrl();

		$source = array(
			'src' => $src,
			'title' => wfMsg('timedmedia-source-file-desc',
								$file->getHandler()->getMetadataType(),
								$wgLang->formatNum( $file->getWidth() ),
								$wgLang->formatNum( $file->getHeight() ),
								$wgLang->formatBitrate( $file->getHandler()->getBitrate( $file ) )
							),
			"{$dataPrefix}shorttitle" => wfMsg('timedmedia-source-file', wfMsg( 'timedmedia-' . $file->getHandler()->getMetadataType() ) ),
			"{$dataPrefix}width" => $file->getWidth(),
			"{$dataPrefix}height" => $file->getHeight(),
		);

		$bitrate = $file->getHandler()->getBitrate( $file );
		if( $bitrate )
			$source["{$dataPrefix}bandwidth"] = round ( $bitrate );

		// For video include framerate:
		if( !$file->getHandler()->isAudio( $file ) ){
			$framerate = $file->getHandler()->getFramerate( $file );
			if( $framerate )
				$source[ "{$dataPrefix}framerate" ] = $framerate;
		}
		return $source;
	}
	/**
	 * Get derivative "source" attributes
	 */
	static public function getDerivativeSourceAttributes($file, $transcodeKey, $options = array() ){
		$dataPrefix = in_array( 'nodata', $options )? '': 'data-';


		$fileName = $file->getTitle()->getDbKey();

		$thumbName = $file->thumbName( array() );
		$thumbUrl = $file->getThumbUrl( $thumbName );
		$thumbUrlDir = dirname( $thumbUrl );

		list( $width, $height ) = WebVideoTranscode::getMaxSizeTransform(
			$file,
			self::$derivativeSettings[$transcodeKey]['maxSize']
		);

		$framerate = ( isset( self::$derivativeSettings[$transcodeKey]['framerate'] ) )?
						self::$derivativeSettings[$transcodeKey]['framerate'] :
						$file->getHandler()->getFramerate( $file );
		// Setup the url src:
		$src = $thumbUrlDir . '/' .$file->getName() . '.' . $transcodeKey;
		$src = in_array( 'fullurl', $options)?  wfExpandUrl( $src ) : $src;
		return array(
				'src' => $src,
				'title' => wfMsg('timedmedia-derivative-desc-' . $transcodeKey ),
				"{$dataPrefix}shorttitle" => wfMsg('timedmedia-derivative-' . $transcodeKey),

				// Add data attributes per emerging DASH / webTV adaptive streaming attributes
				// eventually we will define a manifest xml entry point.
				"{$dataPrefix}width" => $width,
				"{$dataPrefix}height" => $height,
				// a "ready" transcode should have a bitrate:
				"{$dataPrefix}bandwidth" => self::$transcodeState[$fileName][ $transcodeKey ]['final_bitrate'],
				"{$dataPrefix}framerate" => $framerate,
			);
	}
	/**
	 * Update the job queue if the file is not already in the job queue:
	 * @param $file File object
	 * @param $transcodeKey String transcode key
	 */
	public static function updateJobQueue( &$file, $transcodeKey ){
		wfProfileIn( __METHOD__ );

		$fileName = $file->getTitle()->getDbKey();

		// Check if we need to update the transcode state:
		$transcodeState = self::getTranscodeState( $fileName );
		// Check if the job has been added:
		if( !isset( $transcodeState[ $transcodeKey ] ) || is_null( $transcodeState[ $transcodeKey ]['time_addjob'] ) ) {
			// Add to job queue and update the db
			$job = new WebVideoTranscodeJob( $file->getTitle(), array(
				'transcodeMode' => 'derivative',
				'transcodeKey' => $transcodeKey,
			) );
			$jobId = $job->insert();
			if( $jobId ){
				$db = wfGetDB( DB_MASTER );
				// update the transcode state:
				if( ! isset( $transcodeState[$transcodeKey] ) ){
					// insert the transcode row with jobadd time
					$db->insert(
						'transcode',
						array(
							'transcode_image_name' => $fileName,
							'transcode_key' => $transcodeKey,
							'transcode_time_addjob' => $db->timestamp()
						),
						__METHOD__
					);
				} else {
					// update job start time
					$db->update(
						'transcode',
						array(
							'transcode_time_addjob' => $db->timestamp()
						),
						array(
							'transcode_image_name' => $fileName,
							'transcode_key' => $transcodeKey,
						),
						__METHOD__
					);
				}
				// Clear the state cache ( now that we have updated the page )
				self::clearTranscodeCache( $fileName );
			}
			// no jobId ? error out in some way?
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Transforms the size per a given "maxSize"
	 *  if maxSize is > file, file size is used
	 */
	public static function getMaxSizeTransform( &$file, $targetMaxSize ){
		$maxSize = self::getMaxSize( $targetMaxSize );
		$sourceWidth = intval( $file->getWidth() );
		$sourceHeight = intval( $file->getHeight() );
		$sourceAspect = intval( $sourceWidth ) / intval( $sourceHeight );
		$targetWidth = $sourceWidth;
		$targetHeight = $sourceHeight;
		if ( $sourceAspect <= $maxSize['aspect'] ) {
			if ( $sourceHeight > $maxSize['height'] ) {
				$targetHeight = $maxSize['height'];
				$targetWidth = intval( $targetHeight * $sourceAspect );
			}
		} else {
			if ( $sourceWidth > $maxSize['width'] ) {
				$targetWidth = $maxSize['width'];
				$targetHeight = intval( $targetWidth / $sourceAspect );
				//some players do not like uneven frame sizes
			}
		}
		//some players do not like uneven frame sizes
		$targetWidth += $targetWidth%2;
		$targetHeight += $targetHeight%2;
		return array( $targetWidth, $targetHeight );
	}
	/**
	 * Test if a given transcode target is larger than the source file
	 *
	 * @param $transcodeKey The static transcode key
	 * @param $file {Object} File object
	 */
	public static function isTargetLargerThanFile( &$file, $targetMaxSize ){
		$maxSize = self::getMaxSize( $targetMaxSize );
		$sourceWidth = $file->getWidth();
		$sourceHeight = $file->getHeight();
		$sourceAspect = intval( $sourceWidth ) / intval( $sourceHeight );
		if ( $sourceAspect <= $maxSize['aspect'] ) {
			return ( $maxSize['height'] > $sourceHeight );
		} else {
			return ( $maxSize['width'] > $sourceWidth );
		}
	}
	/**
	 * Return maxSize array for given maxSize setting
	 *
	 * @param $maxSize maxSize settings string (i.e. 640x480)
	 */
	public static function getMaxSize( $targetMaxSize ){
		$maxSize = array();
		$targetMaxSize = explode('x', $targetMaxSize);
		if (count($targetMaxSize) == 1) {
			$maxSize['width'] = intval($targetMaxSize[0]);
			$maxSize['height'] = intval($targetMaxSize[0]);
		} else {
			$maxSize['width'] = intval($targetMaxSize[0]);
			$maxSize['height'] = intval($targetMaxSize[1]);
		}
		$maxSize['aspect'] = $maxSize['width'] / $maxSize['height'];
		return $maxSize;
	}
}
