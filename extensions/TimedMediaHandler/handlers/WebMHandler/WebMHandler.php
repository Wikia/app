<?php 
/**
 * WebM handler
 */
class WebMHandler extends TimedMediaHandler {	
	// XXX match GETID3_VERSION ( too bad version is not a getter )
	const METADATA_VERSION = 1;
	
	function getMetadata( $image, $path ) {
		// Create new id3 object:		
		$getID3 = new getID3();
		
		// Don't grab stuff we don't use: 
		$getID3->option_tag_id3v1         = false;  // Read and process ID3v1 tags
		$getID3->option_tag_id3v2         = false;  // Read and process ID3v2 tags
		$getID3->option_tag_lyrics3       = false;  // Read and process Lyrics3 tags
		$getID3->option_tag_apetag        = false;  // Read and process APE tags
		$getID3->option_tags_process      = false;  // Copy tags to root key 'tags' and encode to $this->encoding
		$getID3->option_tags_html         = false;  // Copy tags to root key 'tags_html' properly translated from various encodings to HTML entities
	
		// Analyze file to get metadata structure:
		$id3 = $getID3->analyze( $path );
		
		// Unset some parts of id3 that are too detailed and matroska specific:
		unset( $id3['matroska'] ); 
		// remove file paths
		unset( $id3['filename'] );
		unset( $id3['filepath'] );
		unset( $id3['filenamepath']);

		// Update the version
		$id3['version'] = self::METADATA_VERSION;
		
		return serialize( $id3 );
	}	
	
	/**
	 * Get the "media size" 
	 */	 
	function getImageSize( $file, $path, $metadata = false ) {
		global $wgMediaVideoTypes;
		// Just return the size of the first video stream
		if ( $metadata === false ) {
			$metadata = $file->getMetadata();
		}		
		$metadata = $this->unpackMetadata( $metadata );
		if ( isset( $metadata['error'] ) ) {
			return false;
		}
		if( isset( $metadata['video']['resolution_x']) 
				&& 
			isset( $metadata['video']['resolution_y'])
		){
			return array ( 
				$metadata['video']['resolution_x'],
				$metadata['video']['resolution_y']
			);
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
		return 'webm';
	}

	function getStreamTypes( $file ) {
		$streamTypes = array();
		$metadata = self::unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return false;
		}		
		if( isset( $metadata['audio'] ) && $metadata['audio']['dataformat'] == 'vorbis' ){
			$streamTypes[] =  'Vorbis';
		}
		// id3 gives 'V_VP8' for what we call VP8
		if( $metadata['video']['dataformat'] == 'V_VP8' ){
			$streamTypes[] =  'VP8';
		}	
		
		return $streamTypes;
	}
	function getBitrate($file ){
		$metadata = self::unpackMetadata( $file->getMetadata() );
		return $metadata['bitrate'];		
	}
	function getLength( $file ) {
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return 0;
		} else {
			return $metadata['playtime_seconds'];
		}
	}
	function getFramerate( $file ){
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return 0;
		} else {			
			// return the frame rate of the first found video stream: 
			if( isset( $metadata['video']['frame_rate'] ) ){
				return $metadata['video']['frame_rate'];
			}
			return false;
		}
	}
	
	function getShortDesc( $file ) {
		global $wgLang, $wgMediaAudioTypes, $wgMediaVideoTypes;

		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			return parent::getShortDesc( $file );
		}
		return wfMsg( 'timedmedia-webm-short-video', implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $this->getLength( $file ) ) );
	}

	function getLongDesc( $file ) {
		global $wgLang;
		return wfMsg('timedmedia-webm-long-video',
			implode( '/', $this->getStreamTypes( $file ) ),
			$wgLang->formatTimePeriod( $this->getLength($file) ),
			$wgLang->formatBitrate( $this->getBitRate( $file ) ),
			$wgLang->formatNum( $file->getWidth() ),
			$wgLang->formatNum( $file->getHeight() )
	   	);
		
	}

}