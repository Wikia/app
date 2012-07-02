<?php 
/**
 * ogg handler 
 */
class OggHandler extends TimedMediaHandler {
	const METADATA_VERSION = 2;
	
	function getMetadata( $image, $path ) {
		$metadata = array( 'version' => self::METADATA_VERSION );

		if ( !class_exists( 'File_Ogg' ) ) {
			require( 'File/Ogg.php' );
		}
		try {
			$f = new File_Ogg( $path );
			$streams = array();
			foreach ( $f->listStreams() as $streamIDs ) {
				foreach ( $streamIDs as $streamID ) {
					$stream = $f->getStream( $streamID );
					$streams[$streamID] = array(
						'serial' => $stream->getSerial(),
						'group' => $stream->getGroup(),
						'type' => $stream->getType(),
						'vendor' => $stream->getVendor(),
						'length' => $stream->getLength(),
						'size' => $stream->getSize(),
						'header' => $stream->getHeader(),
						'comments' => $stream->getComments()
					);
				}
			}
			$metadata['streams'] = $streams;
			$metadata['length'] = $f->getLength();
			// Get the offset of the file (in cases where the file is a segment copy)
			$metadata['offset'] = $f->getStartOffset();
		} catch ( PEAR_Exception $e ) {
			// File not found, invalid stream, etc.
			$metadata['error'] = array(
				'message' => $e->getMessage(),
				'code' => $e->getCode()
			);
		}
		return serialize( $metadata );
	}
	/**
	 * Get the "media size" 
	 *
	 */	 
	function getImageSize( $file, $path, $metadata = false ) {
		global $wgMediaVideoTypes;
		// Just return the size of the first video stream
		if ( $metadata === false ) {
			$metadata = $file->getMetadata();
		}
		$metadata = $this->unpackMetadata( $metadata );
		if ( isset( $metadata['error'] ) || !isset( $metadata['streams'] ) ) {
			return false;
		}
		foreach ( $metadata['streams'] as $stream ) {
			if ( in_array( $stream['type'], $wgMediaVideoTypes ) ) {
				$pictureWidth = $stream['header']['PICW'];
				$parNumerator = $stream['header']['PARN'];
				$parDenominator = $stream['header']['PARD'];
				if( $parNumerator && $parDenominator ) {
					// Compensate for non-square pixel aspect ratios
					$pictureWidth = $pictureWidth * $parNumerator / $parDenominator;
				}
				return array(
					intval( $pictureWidth ),
					intval( $stream['header']['PICH'] )
				);
			}
		}
		return array( false, false );
	}
	
	function unpackMetadata( $metadata ) {
		$unser = @unserialize( $metadata );
		if ( isset( $unser['version'] ) && $unser['version'] == self::METADATA_VERSION ) {
			return $unser;
		} else {
			return false;
		}
	}
	
	function getMetadataType( $image = '' ) {
		return 'ogg';
	}
	
	function getStreamTypes( $file ) {
		$streamTypes = array();
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return false;
		}
		foreach ( $metadata['streams'] as $stream ) {
			$streamTypes[] = $stream['type'];
		}
		return array_unique( $streamTypes );
	}
	
	function getOffset( $file ){
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) || !isset( $metadata['offset']) ) {
			return 0;
		} else {
			return $metadata['offset'];
		}
	}
	
	function getLength( $file ) {
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return 0;
		} else {
			return $metadata['length'];
		}
	}
	function getFramerate( $file ){
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return 0;
		} else {
			// Return the first found theora stream framerate: 
			foreach ( $metadata['streams'] as $stream ) {
				if( $stream['type'] == 'Theora' ){
					return  $stream['header']['FRN'] / $stream['header']['FRD'];
				}
			}			
			return 0;
		}
	}
	function getShortDesc( $file ) {
		global $wgLang, $wgMediaAudioTypes, $wgMediaVideoTypes;

		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			return parent::getShortDesc( $file );
		}
		if ( array_intersect( $streamTypes, $wgMediaVideoTypes ) ) {
			// Count multiplexed audio/video as video for short descriptions
			$msg = 'timedmedia-ogg-short-video';
		} elseif ( array_intersect( $streamTypes, $wgMediaAudioTypes ) ) {
			$msg = 'timedmedia-ogg-short-audio';
		} else {
			$msg = 'timedmedia-ogg-short-general';
		}
		return wfMsg( $msg, implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $this->getLength( $file ) ) );
	}

	function getLongDesc( $file ) {
		global $wgLang, $wgMediaVideoTypes, $wgMediaAudioTypes;

		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			$unpacked = $this->unpackMetadata( $file->getMetadata() );
			return wfMsg( 'timedmedia-ogg-long-error', $unpacked['error']['message'] );
		}
		if ( array_intersect( $streamTypes,$wgMediaVideoTypes  ) ) {
			if ( array_intersect( $streamTypes, $wgMediaAudioTypes ) ) {
				$msg = 'timedmedia-ogg-long-multiplexed';
			} else {
				$msg = 'timedmedia-ogg-long-video';
			}
		} elseif ( array_intersect( $streamTypes, $wgMediaAudioTypes ) ) {
			$msg = 'timedmedia-ogg-long-audio';
		} else {
			$msg = 'timedmedia-ogg-long-general';
		}
		$size = 0;
		$unpacked = $this->unpackMetadata( $file->getMetadata() );
		if ( !$unpacked || isset( $metadata['error'] ) ) {
			$length = 0;
		} else {
			$length = $this->getLength( $file );
			foreach ( $unpacked['streams'] as $stream ) {
				if( isset( $stream['size'] ) )
					$size += $stream['size'];
			}
		}
		return wfMsg( $msg, implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $length ),
			$wgLang->formatBitrate( $this->getBitRate( $file ) ),
			$wgLang->formatNum( $file->getWidth() ),
			$wgLang->formatNum( $file->getHeight() )
	   	);
	}
	
	function getBitRate( &$file ){ 
		$size = 0;
		$unpacked = $this->unpackMetadata( $file->getMetadata() );
		if ( !$unpacked || isset( $metadata['error'] ) ) {
			$length = 0;
		} else {
			$length = $this->getLength( $file );
			foreach ( $unpacked['streams'] as $stream ) {
				if( isset( $stream['size'] ) )
					$size += $stream['size'];
			}
		}
		return $length == 0 ? 0 : $size / $length * 8;
	}
	
}
