<?php

define('OGGCHOP_META_VERSION', 1);
define('OGGCHOP_META_EXT', '.meta');

$oggDir = dirname(__FILE__);

//require the PEAR php module
ini_set( 'include_path',
	"$oggDir/PEAR/File_Ogg" .
	PATH_SEPARATOR .
	ini_get( 'include_path' ));

class OggChop {
	//initial variable values:
	var $meta = false;
	var $loadWaitCount = 0;

	//header values:
	var $contentLength = 0;
	var $contentRanges = array();
	var $boundary = '';

	function __construct( $oggPath ){
		$this->oggPath = $oggPath;
	}
	/**
	 * play takes in start_sec and end_sec and sends out packet
	 *
	 * @param float $start_sec ( start time in float seconds)
	 * @param floast $end_sec (optional end time in float)
	 */
	function play($start_sec=false, $end_sec = false){
		//make sure we have the metadata ready:
		$this->loadMeta();

		//get http byte range headers::
		if( !$this->getByteRangeRequest() ){
			//failed to get byte range
			header("Status: 416 Requested range not satisfiable");
    		header("Content-Range: */$filesize");
    		exit();

		}

		//if both start and end are false send the full file:
		if(!$start_sec && !$end_sec){
			$this->duration = $this->getMeta('duration');
			$this->sendHeaders();
			//output the full file:

			//turn off output buffering
			while (ob_get_level() > 0) {
		   		ob_end_flush();
			}
			//check for byte range output:
			if( count( $this->contentRanges) ){
				//byte range request send the requested byte ranges:
				if( count( $this->contentRanges)>1){
					//output the content
					foreach ($this->contentRanges as $range){
						echo "\r\n--$boundary\r\n";
						echo "Content-Type: {$this->contentType}\r\n";
						echo "Content-Range: bytes ". $range['s'] . "-" .
								$range['e'] . "/". filesize( $this->oggPath ) . "\r\n\r\n";
						$this->outputByteRange( $range['s'], $range['e'] );
					}
				}else{
				  //A single range is requested.
			      $range = $this->contentRanges[0];
			      $this->outputByteRange( $range['s'], $range['e'] );

				}
			}else{
				//just start sending the whole file
				@readfile( $this->oggPath );
			}
			//exit the application
			exit();
		}else{
			$kEnd = false;
			//we have a temporal request
			if(!$start_sec || $start_sec < 0)
				$start_sec = 0;

			if(!$end_sec || $end_sec > $this->getMeta('duration')){
				$end_sec = $this->getMeta('duration');
				$kEnd = array(
					$this->getMeta('duration'),
					filesize( $this->oggPath )
				);
			}

			//set the duration:
			$this->duration = $end_sec - $start_sec;

			//set the content size for the segment:
			$kStart = $this->getKeyFrameByteFromTime( $start_sec );
			if( ! $kEnd )
				$kEnd = $this->getKeyFrameByteFromTime( $end_sec , false);

			//debug output:
			/*
			print_r($this->meta['theoraKeyFrameInx']);
			print "Start : ". print_r($kStart, true) ."\n";
			print "End Byte:" . print_r($kEnd, true) . "\n";
			die();

			@@todo build the ogg skeleton header from stream set
			$kStart time and the requested time.
			*/
			//for now just start output at the given byte range
			//(DOES NOT WORK) can't play stream without header
			$this->outputByteRange( $kStart[1], $kEnd[1]);
		}

	}
	function getKeyFrameByteFromTime( $reqTime, $prev_key=true ){
		//::binary array search goes here::

		//linear search (may be faster in some cases (like start of the file seeks)
		$timeDiff = $this->getMeta('duration');
		reset($this->meta['theoraKeyFrameInx']);
		$pByte = current( $this->meta['theoraKeyFrameInx'] );
		$pKtime = key( $this->meta['theoraKeyFrameInx'] );
		foreach($this->meta['theoraKeyFrameInx'] as $kTime => $byte){
			if($kTime > $reqTime)
				break;
			$pByte = $byte;
			$pKtime = $kTime;
		}
		//return the keyframe array by default the prev key
		if($prev_key){
			return array($pKtime, $pByte);
		}else{
			return array($kTime, $byte);
		}
	}
	/**
	 * outputByteRange
	 */
	function outputByteRange($startByte, $endByte = null){
		//media files use large chunk size:
		$chunkSize = 32768;
		$this->fp = fopen( $this->oggPath, 'r');
		fseek($this->fp, $startByte);
		while (! feof($this->fp))
		{
			if( $endByte != null ){
				if( ftell( $this->fp ) + $chunkSize > $endByte ){
					$read_amount = ( ftell ( $this->fp ) + $chunkSize ) - $endByte;
					echo fread($this->fp, $read_amount);
					break;
				}
			}
			echo fread($this->fp, $chunkSize);
		}
		//flush the buffer (make sure we are not buffering the above output)
		flush();
	}
	function getByteRangeRequest(){
		//set local vars for byte range request handling
		if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_SERVER['HTTP_RANGE'])){
			$range = stristr( trim ( $_SERVER['HTTP_RANGE'] ) , 'bytes=' );
			if(!$range)
				return ;
			$range 	= substr($range,6);
			$ranges = explode( ',', $range );

			//set to a variable to support segment byte range requests
			$reqestedFileSize = filesize( $this->oggPath );
			//also see: http://www.w3.org/Protocols/rfc2616/rfc2616.html
			foreach( $ranges as $range ){
				$rParts = explode( $range );
				if( count( $rParts ) != 2){
					return false;
				}
				list($start, $end) = $rParts;
				if( $start == '' && $end != ''){
					//get last bytes -500
					$this->contentRanges[] = array(
						's' => $reqestedFileSize - $end,
						'e' => $reqestedFileSize -1
					);
					continue;
				}
				if( $end == '' && $start != ''){
					//get start bytes ( 500-
					$this->contentRanges[] = array(
						's' => $start,
						'e' => $reqestedFileSize -1
					);
					continue;
				}
				if( $start != '' && $end != ''){
					//get start and end: (0-500)
					$this->contentRanges[] = array(
						's' => $start,
						'e' => $end
					);
					continue;
				}
				//check for not valid request range:
				if( $start > $end ){
					return false;
				}
				//did not fit any of the above
				return false;
			}
			//done with byte ranges:
			return true;
		}else{
			//set from full file context::
			$this->contentLength = filesize( $this->oggPath );
			$this->contentRanges = array(
				array(
					's' => 0,
					'e' => $this->contentLength -1
				)
			);
			return true;
		}

	}
	function sendHeaders(){
		header ("Accept-Ranges: bytes");

		//only set type to
		$this->contentType = 'video/ogg';

		//set content range see spec:
		// http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.16
		if( count( $this->contentRanges ) ){
			//we are sending out partial content set the header:
			header("HTTP/1.1 206 Partial content");

			if( count( $this->contentRanges) > 1){
				//set a random boundary:
				$this->boundary = '4qf5xy4z0084c7cb30zwvcm33' ;
				//multiple ranges build the content length:
				$content_length=0;
				foreach($this->contentRanges as $range ){
					$content_length += strlen( "\r\n--$boundary\r\n" );
			        $content_length += strlen( "Content-Range: bytes ". $range['s'] . "-" .
			        	$range['e'] . "/" . filesize( $this->oggPath ) ."\r\n\r\n" );
			        $content_length += $last-$first+1;
				}
				$content_length+=strlen("\r\n--$boundary--\r\n");
				header("Content-Type: multipart/x-byteranges; boundary=$boundary");
				$this->contentLength = $content_length;
			}else{
				$range = $this->contentRanges[0];
				//single range:
				header ( "Content-Range: bytes " .
					$range['s'] . "-" .
					$range['e'] . "/" .
					filesize( $this->oggPath )
				);
				//set mime type
				header ("Content-Type: $this->contentType");
			}
		}
		//set range conditional headers:
		if( $this->contentLength )
			header ( "Content-Length: " . $this->contentLength );

		//set the X-content duration:
		if( $this->duration )
			header ( "X-Content-Duration: " . $this->duration );

		//constant headers (for video)
		if( isset($this->meta['height']) )
			header( "X-Content-Video-Height: " . $this->meta['height'] );

		if( isset($this->meta['width']) )
			header( "X-Content-Video-Width: " . $this->meta['width'] );

	}
	/**
	 * getMeta (returns the value of a metadata key)
	 */
	function getMeta( $key ){
		if( !$this->meta ){
			$this->loadMeta();
		}
		if( isset( $this->meta[$key] ) )
			return $this->meta[ $key ];
		return false;
	}
	function loadMeta(){
		//load from the file:
		if( is_file( $this->oggPath . OGGCHOP_META_EXT ) ){
			$oggMeta = file_get_contents( $this->oggPath . OGGCHOP_META_EXT);
			//check if a separate request is working on generating the file:
			if( trim( $oggMeta ) == 'loading' ){
				if( $this->loadWaitCount >= 24 ){
					//we have waited 2 min with no luck..
					//@@todo we should flag that ogg file as broken?
					// and just redirect to normal output? (for now just set meta to false)
					$this->meta = false;
					//fail:
					return false;
				}else{
					//some other request is "loading" metadata sleep for 5 seconds and try again
					sleep( 5 );
					$this->loadWaitCount++;
					return $this->loadMeta();
				}
			}else{
				$this->meta = unserialize ( $oggMeta );
				if( $this->meta['version'] == 'OGGCHOP_META_VERSION' ){
					//we have a good version of the metadata return true:
					return true;
				}else{
					$this->meta = false;
				}
			}
		}
		//if the file does not exist or $this->meta is still false::
		if( ! is_file( $this->oggPath . OGGCHOP_META_EXT ) || $this->meta === false ){
			//set the meta file to "loading" (avoids multiple indexing requests)
			file_put_contents( $this->oggPath . OGGCHOP_META_EXT, 'loading');

			//load up the File/Ogg Pear module
			if ( !class_exists( 'File_Ogg' ) ) {
				require( 'File/Ogg.php' );
			}
			$f = new File_Ogg( $this->oggPath );
			$streams = array();
			$this->meta = array(
				'version' => OGGCHOP_META_VERSION
			);
			foreach ( $f->listStreams() as $streamType => $streamIDs ) {
				foreach ( $streamIDs as $streamID ) {
					$stream = $f->getStream( $streamID );
					//for now only support a fist theora stream we find:
					if( strtolower( $stream->getType() ) == 'theora'){
						$this->meta['theoraKeyFrameInx'] = $stream->getKeyFrameIndex();
						//set the width and height:
						$head =  $stream->getHeader();
						$this->meta['width'] = $head['PICW'];
						$this->meta['height'] = $head['PICH'];
						break;
					}
					/* more detailed per-stream metadata::
					 * $this->meta['streams'][$streamID] = array(
						'serial' => $stream->getSerial(),
						'group' => $stream->getGroup(),
						'type' => $stream->getType(),
						'vendor' => $stream->getVendor(),
						'length' => $stream->getLength(),
						'size' => $stream->getSize(),
						'header' => $stream->getHeader(),
						'comments' => $stream->getComments()
					);*/
				}
			}
			$this->meta['duration'] = $f->getLength();
			//cache the metadata::
			file_put_contents( $this->oggPath . OGGCHOP_META_EXT, serialize( $this->meta) );
			return true;
		}
	}
}
