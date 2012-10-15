<?php

class TimedMediaHandler extends MediaHandler {

	static $magicDone = false;

	function isEnabled() {
		return true;
	}
	
	function getImageSize( $file, $path, $metadata = false ) {
		/* override by handler */	
		return array();
	}
	
	/**
	 * Get the list of supported wikitext embed params
	 */
	function getParamMap() {
		return array(
			'img_width' => 'width',
			'timedmedia_thumbtime' => 'thumbtime',
			'timedmedia_starttime'	=> 'start',
			'timedmedia_endtime'	=> 'end',
		);
	}
	/**
	 * Validate a embed file parameters
	 * 
	 * @param $name {String} Name of the param
	 * @param $value {Mixed} Value to validated 
	 */
	function validateParam( $name, $value ) {
		if ( $name == 'thumbtime' || $name == 'start' || $name == 'end' ) {
			if ( $this->parseTimeString( $value ) === false ) {
				return false;
			}
		}
		return true;
	}
	/**
	 * TODO we should really have "$file" available here to validate the param string 
	 */
	function makeParamString( $params ) {
		// Add the width param string ( same as images {width}px )
		$paramString ='';
		$paramString.= ( isset( $params['width'] ) )?  $params['width'] . 'px' : '';
		$paramString.= ( $paramString != '' )? '-' : '';
		
		// Get the raw thumbTime from thumbtime or start param
		$thumbTime = isset( $params['thumbtime'] )? $params['thumbtime'] : false;
		if( !$thumbTime )
			$thumbTime = isset( $params['start'] )? $params['start'] : false;
		
		if ( $thumbTime ) {
			$time = $this->parseTimeString( $thumbTime );
			if ( $time !== false ) {
				return $paramString. 'seek=' . $time;
			}
		}
		return $paramString ;
	}

	function parseParamString( $str ) {
		$m = false;
		if ( preg_match( '/^seek=(\d+)$/', $str, $m ) ) {
			return array( 'thumbtime' => $m[0] );
		}
		return array();
	}

	function normaliseParams( $image, &$params ) {
		$timeParam = array( 'thumbtime', 'start', 'end' );
		// Parse time values if endtime or thumbtime can't be more than length -1
		foreach($timeParam as $pn){
			if ( isset( $params[$pn] ) ) {
				$length = $this->getLength( $image );
				$time = $this->parseTimeString( $params[$pn] );
				if ( $time === false ) {
					return false;
				} elseif ( $time > $length - 1 ) {
					$params[$pn] = $length - 1;
				} elseif ( $time <= 0 ) {
					$params[$pn] = 0;
				}
			}
		}
		// Make sure we don't try and up-scale the asset:
		if( isset( $params['width'] ) && (int)$params['width'] > $image->getWidth() ){
			$params['width'] = $image->getWidth();
		}
		
		// Make sure start time is not > than end time
		if(isset($params['start']) && isset($params['end']) ){
			if($params['start'] > $params['end'])
				return false;
		}

		return true;
	}
	function parserTransformHook( $parser, $file ) {
		$parserOutput = $parser->getOutput();
		if ( isset( $parserOutput->hasTimedMediaTransform ) ) {
			return ;
		}
		$parserOutput->hasTimedMediaTransform = true;
		$parserOutput->addOutputHook( 'TimedMediaHandler' );
	}
	/**
	 * Output hook only adds the PopUpMediaTransform 
	 * 
	 * The core embedPlayer module is part of a "loaderScript" so it does not need to 
	 * be registered here. 
	 */
	static function outputHook( $outputPage, $parserOutput, $data ) {
		// Add the PopUpMediaTransform code 
		$outputPage->addModules( 'mw.PopUpMediaTransform' );
		$outputPage->addModuleStyles( 'mw.PopUpMediaTransform' );
	}
	/**
	 * Utility functions
	 */
	public static function parseTimeString( $timeString, $length = false ) {
		$parts = explode( ':', $timeString );
		$time = 0;
		// Check for extra :s 
		if( count( $parts ) > 3 ){	
			return false;
		}
		for ( $i = 0; $i < count( $parts ); $i++ ) {
			if ( !is_numeric( $parts[$i] ) ) {
				return false;
			}
			$time += intval( $parts[$i] ) * pow( 60, count( $parts ) - $i - 1 );
		}

		if ( $time < 0 ) {
			wfDebug( __METHOD__.": specified negative time, using zero\n" );
			$time = 0;
		} elseif ( $length !== false && $time > $length - 1 ) {
			wfDebug( __METHOD__.": specified near-end or past-the-end time {$time}s, using end minus 1s\n" );
			$time = $length - 1;
		}
		return $time;
	}	
	public static function getTimePassedMsg( $timePassed ){		
		$t['days'] = floor($timePassed/60/60/24);
		$t['hours'] = floor($timePassed/60/60)%24;
		$t['minutes'] = floor($timePassed/60)%60;
		$t['seconds'] = $timePassed%60;			
		
		foreach( $t as $k => $v ){
			if($v == 0 ){
				unset( $t[$k] );
			}else{
				$t[$k] = wfMsg( 'timedmedia-' . $k, $v);
			}
		}
		if( count( $t ) == 0 ){
			$t = array( wfMsg( 'timedmedia-seconds', 0) ) ;
		}
		// Call to the correct set of significant measurements:
		return wfMsgHtml( 'timedmedia-time-' . count($t) . '-measurements', $t);
	}
	/**
	 * Converts seconds to Normal play time (NPT) time format:
	 * consist of hh:mm:ss.ms
	 * also see: http://www.ietf.org/rfc/rfc2326.txt section 3.6
	 * 
	 * @param $time {Number} Seconds to be converted to npt time format
	 */	 
	public static function seconds2npt( $time ){ 
		if ( !is_numeric( $time ) ) {
			wfDebug( __METHOD__.": trying to get npt time on NaN:" + $time);			
			return false;
		}
		if( $time < 0 ){
			wfDebug( __METHOD__.": trying to time on negative value:" + $time);
			return false;
		}
		$hours = floor( $time / 3600 );
		$min = floor( ( $time / 60 ) % 60 );
		$sec = ($time % 60 );
		$ms = ( $time - round( $time, 3) != 0 ) ? '.' .( $time - round( $time, 3) ) : '';
		
		return "{$hours}:{$min}:{$sec}{$ms}";
	}	

	function isMetadataValid( $image, $metadata ) {
		return $this->unpackMetadata( $metadata ) !== false;
	}
	function getThumbType( $ext, $mime, $params = null ) {
		return array( 'jpg', 'image/jpeg' );
	}
	// checks if a given file is an audio file
	function isAudio( $file ){
		return ( $file->getWidth() == 0 && $file->getHeight() == 0 );
	}
	function doTransform( $file, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgFFmpegLocation, $wgEnabledDerivatives;
	
		$srcWidth = $file->getWidth();
		$srcHeight = $file->getHeight();
		
		// Audio should not be transformed by size, give it a default width and height
		if( $this->isAudio( $file ) ){
			$srcWidth = 220;
			$srcHeight = 23;
		}
		
		$params['width'] = isset( $params['width'] ) ? $params['width'] : $srcWidth;
		
		$options = array(
			'file' => $file,
			'length' => $this->getLength( $file ),
			'offset' => $this->getOffset( $file ),
			'width' => $params['width'],
			'height' =>  $srcWidth == 0 ? $srcHeight : round( $params['width']* $srcHeight / $srcWidth ),
			'isVideo' => !$this->isAudio( $file ),
			'thumbtime' => isset( $params['thumbtime'] ) ? $params['thumbtime'] : intval( $file->getLength() / 2 ),
			'start' => isset( $params['start'] ) ? $params['start'] : false,
			'end' => isset( $params['end'] ) ? $params['end'] : false
		);
		
		// No thumbs for audio
		if( !$options['isVideo'] ){			
			return new TimedMediaTransformOutput( $options );
		}

		// Setup pointer to thumb arguments
		$options[ 'thumbUrl' ] = $dstUrl;
		$options[ 'dstPath' ] = $dstPath;
		$options[ 'path' ] = $dstPath;
		
		// Check if transform is deferred:
		if ( $flags & self::TRANSFORM_LATER ) {
			return new TimedMediaTransformOutput($options);
		}
		
		// Generate thumb:
		$thumbStatus = TimedMediaThumbnail::get( $options );
		if( $thumbStatus !== true ){
			return $thumbStatus;
		}
	
		return new TimedMediaTransformOutput( $options );
	}

	function canRender( $file ) { return true; }
	function mustRender( $file ) { return true; }

	// Get a stream offset time
	function getOffset( $file ){
		return 0;
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
