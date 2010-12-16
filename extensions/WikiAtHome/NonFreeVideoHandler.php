<?php
/*
 * creates an stub for non-free video that is waiting to be transcoded once the free format file is available
 * it re-maps all requests to the free format file. (only transcoding jobs will get the non-free file)
 */
class NonFreeVideoHandler extends MediaHandler {
	const METADATA_VERSION = 22;

	function isEnabled() {
		return true;
	}

	function getParamMap() {
		/*return array(
			'img_width' => 'width',
			'ogg_noplayer' => 'noplayer',
			'ogg_noicon' => 'noicon',
			'ogg_thumbtime' => 'thumbtime',
		);*/
	}

	function validateParam( $name, $value ) {
		if ( $name == 'thumbtime' ) {
			if ( $this->parseTimeString( $value ) === false ) {
				return false;
			}
		}
		return true;
	}

	function parseParamString( $str ) {
		$m = false;
		if ( preg_match( '/^seek=(\d+)$/', $str, $m ) ) {
			return array( 'thumbtime' => $m[0] );
		}
		return array();
	}

	function normaliseParams( $image, &$params ) {
		if ( isset( $params['thumbtime'] ) ) {
			$length = $this->getLength( $image );
			$time = $this->parseTimeString( $params['thumbtime'] );
			if ( $time === false ) {
				return false;
			} elseif ( $time > $length - 1 ) {
				$params['thumbtime'] = $length - 1;
			} elseif ( $time <= 0 ) {
				$params['thumbtime'] = 0;
			}
		}
		return true;
	}

	function getImageSize( $file, $path, $metadata = false ) {
		// Just return the size of the first video stream
		if ( $metadata === false ) {
			$metadata = $file->getMetadata();
		}
		$metadata = $this->unpackMetadata( $metadata );
		if ( isset( $metadata['error'] ) ) {
			return false;
		}
		if( isset( $metadata['video'] )){
			foreach ( $metadata['video'] as $stream ) {
				return array(
					$stream->width,
					$stream->height
				);
			}
		}
		return array( false, false );
	}
	function makeParamString( $params ) {
		if ( isset( $params['thumbtime'] ) ) {
			$time = $this->parseTimeString( $params['thumbtime'] );
			if ( $time !== false ) {
				return 'seek=' . $time;
			}
		}
		return 'mid';
	}

	function getMetadata( $image, $path ) {
		global $wgffmpeg2theora;
		$metadata = array( 'version' => self::METADATA_VERSION );
		//if we have  fffmpeg2theora
		if( $wgffmpeg2theora && is_file( $wgffmpeg2theora ) ){

			$mediaMeta = wahGetMediaJsonMeta( $path );

			if( $mediaMeta ){
				foreach($mediaMeta as $k=>$v){
					if( !isset( $metadata[ $k ]))
						$metadata[ $k ] = $v;
				}
			}else{
				$metadata['error'] = array(
					'message' => 'could not parse ffmpeg2theora output',
					'code' => 2
				);
			}
		}else{
			$metadata['error'] = array(
				'message' => 'missing ffmpeg2theora<br /> check that ffmpeg2theora is installed and that $wgffmpeg2theora points to its location',
				'code' => 1
			);
		}
		return serialize( $metadata );
	}
	function unpackMetadata( $metadata ) {
		$unser = @unserialize( $metadata );
		if ( isset( $unser['version'] ) && $unser['version'] == self::METADATA_VERSION ) {
			return $unser;
		} else {
			return false;
		}
	}
	/*
	 * sucks we have to maintain two version of Ogg doTransform but it proved difficult to integrate them.
	 * in the future we should have a concept of "derivatives" and greatly simplify the media handlers.
	 */
	function doTransform( $file, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgEnabledDerivatives, $wgFFmpegLocation, $wgOut;

		$width = $params['width'];
		$srcWidth = $file->getWidth();
		$srcHeight = $file->getHeight();
		$height = $srcWidth == 0 ? $srcHeight : $width * $srcHeight / $srcWidth;
		$length = $this->getLength( $file );

		//make sure we have all the output classes of oggHandler loaded by the autoLoader:
		$oggHandle =  MediaHandler::getHandler( 'application/ogg' );

		//add the oggHandler js:
		$oggHandle->setHeaders( $wgOut );

		//do some arbitrary derivative selection logic:
		$encodeKey = WikiAtHome::getTargetDerivative($width, $file);
		//see if we have that encoding profile already:

		//get the job manager .. check status and output current state or defer to oggHanndler_body for output
		$wjm = WahJobManager::newFromFile( $file , $encodeKey );

		//check for the derivative file:
		//$fTitle = Title::newFromText( $wjm->getTitle(), $wjm->getNamespace() );
		//$oggFile = wfLocalFile( $fTitle );
		$thumbPath 	 = $file->getThumbPath( $wjm->getEncodeKey() );
		$oggThumbUrl = $file->getThumbUrl( $wjm->getEncodeKey() . '.ogg');

		//check that we have the requested theora derivative
		if( is_file ( "{$thumbPath}.ogg" )){
			//get the thumb time:
			$thumbTime = false;
			if ( isset( $params['thumbtime'] ) ) {
				$thumbTime = $this->parseTimeString( $params['thumbtime'], $length );
			}
			if ( $thumbTime === false ) {
				# Seek to midpoint by default, it tends to be more interesting than the start
				$thumbTime = $length / 2;
			}
			wfMkdirParents( dirname( $dstPath ) );
			if(!is_file($dstPath)){
				$cmd = wfEscapeShellArg( $wgFFmpegLocation ) .
				' -ss ' . intval( $thumbTime ) . ' ' .
				' -i ' . wfEscapeShellArg( $file->getPath() ) .
				# MJPEG, that's the same as JPEG except it's supported by the windows build of ffmpeg
				# No audio, one frame
				' -f mjpeg -an -vframes 1 ' .
				wfEscapeShellArg( $dstPath ) . ' 2>&1';

				$retval = 0;
				$returnText = wfShellExec( $cmd, $retval );
				//if Bad file return error:
				if ( $this->removeBadFile( $dstPath, $retval ) || $retval ) {
					$lines = explode( "\n", str_replace( "\r\n", "\n", $returnText ) );
					return new MediaTransformError( 'thumbnail_error', $width, $height, implode( "\n", $lines ) );
				}
			}
			return new OggTransformOutput( $file, $oggThumbUrl, $dstUrl, $width, $height, $length, $dstPath, $noIcon=false, $offset=0, 0);
		}else{
			//output our current progress
			return new MediaQueueTransformOutput($file, null, $width, $height, $wjm->getDonePerc() );
		}
	}

	function getMetadataType( $image ) {
		return 'vid';
	}

	function isMetadataValid( $image, $metadata ) {
		return $this->unpackMetadata( $metadata ) !== false;
	}

	function getThumbType( $ext, $mime ) {
		return array( 'jpg', 'image/jpeg' );
	}

	function canRender( $file ) { return true; }
	function mustRender( $file ) { return true; }

	function getLength( $file ) {
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return 0;
		} else {
			return $metadata['duration'];
		}
	}
	function getStreamTypes( $file ) {
		$streamTypes = array();
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return false;
		}
		if(isset($metadata['video'])){
			foreach ( $metadata['video'] as $stream ) {
				$streamTypes[ $stream->codec ] = true;
			}
		}
		if(isset($metadata['audio'])){
			foreach ( $metadata['audio'] as $stream ) {
				$streamTypes[ $stream->codec ] = true;
			}
		}
		return array_keys( $streamTypes );
	}
	function getShortDesc( $file ) {
		global $wgLang;
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			return parent::getShortDesc( $file );
		}
		if ( isset( $metadata['video'] ) && $metadata['video'] ) {
			// Count multiplexed audio/video as video for short descriptions
			$msg = 'wah-short-video';
		} elseif ( isset( $metadata['audio'] ) && $metadata['audio'] ) {
			$msg = 'wah-short-audio';
		} else {
			$msg = 'wah-short-general';
		}
		return wfMsg( $msg, implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $this->getLength( $file ) ) );
	}

	function getLongDesc( $file ) {
		global $wgLang;
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			$unpacked = $this->unpackMetadata( $file->getMetadata() );
			return wfMsg( 'wah-long-error', $unpacked['error']['message'] );
		}
		if ( isset( $metadata['video'] ) && $metadata['video'] ) {
			if ( isset( $metadata['audio'] ) && $metadata['audio'] ) {
				$msg = 'wah-long-multiplexed';
			} else {
				$msg = 'wah-long-video';
			}
		} elseif ( isset( $metadata['audio'] ) && $metadata['audio'] ) {
			$msg = 'wah-long-audio';
		} else {
			$msg = 'wah-long-general';
		}
		$size = 0;
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			$length = 0;
		} else {
			$length = $this->getLength( $file );
			$size = $metadata['size'];
		}
		$bitrate = $length == 0 ? 0 : $size / $length * 8;
		return wfMsg( $msg, implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $length ),
			$wgLang->formatBitrate( $bitrate ),
			$wgLang->formatNum( $file->getWidth() ),
			$wgLang->formatNum( $file->getHeight() )
	   	);
	}

	function getDimensionsString( $file ) {
		global $wgLang;
		if ( $file->getWidth() ) {
			return wfMsg( 'video-dims', $wgLang->formatTimePeriod( $this->getLength( $file ) ),
				$wgLang->formatNum( $file->getWidth() ),
				$wgLang->formatNum( $file->getHeight() ) );
		} else {
			return $wgLang->formatTimePeriod( $this->getLength( $file ) );
		}
	}
}
class MediaQueueTransformOutput extends MediaTransformOutput {
	static $serial = 0;

	function __construct( $file, $thumbUrl, $width, $height, $percDone )
	{
		$this->file = $file;
		$this->width = round( $width );
		$this->height = round( $height );
		$this->percDone = $percDone;
		$this->url = $thumbUrl;
	}

	function toHtml( $options = array() ) {
		global $wgJobTypeConfig;

		if( $this->percDone == -1){
			$waitHtml =  wfMsgWikiHtml( 'wah-transcode-fail');
		}else{
			$waitHtml = wfMsgWikiHtml( 'wah-transcode-working' );
			//check if we doing it ~at~ home then we know how far it is done:
			if( $wgJobTypeConfig['transcode'][ 'assignAtHome' ] ){
		 		$waitHtml .= wfMsgWikiHtml('wah-transcode-helpout', $this->percDone);
			}
		}

		//@@this is just a placeholder
		if( $this->height !=0 && $this->width != 0 ){
			return Xml::tags( 'div',
				array(
					'style' => 'border:solid thin black;padding:5px;overflow:hidden;'.
								'width:'.$this->width.'px;height:'.$this->height.'px'
				),
				$waitHtml
			);
		}else{
			return $waitHtml;
		}

	}
}
?>
