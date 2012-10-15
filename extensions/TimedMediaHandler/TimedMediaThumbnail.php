<?php
class TimedMediaThumbnail {

	static function get( $options ){
		global $wgFFmpegLocation, $wgOggThumbLocation;

		// Set up lodal pointer to file
		$file = $options['file'];
		if( !is_dir( dirname( $options['dstPath'] ) ) ){
			wfMkdirParents( dirname( $options['dstPath'] ), null, __METHOD__ );
		}

		wfDebug( "Creating video thumbnail at" .  $options['dstPath']  . "\n" );
		// Else try ffmpeg and return result:
		return self::tryFfmpegThumb( $options );
	}

	static function tryFfmpegThumb( $options ){
		global $wgFFmpegLocation;

		$cmd = wfEscapeShellArg( $wgFFmpegLocation );

		$offset = intval( self::getThumbTime( $options ) );
		/*
		This is a workaround until ffmpegs ogg demuxer properly seeks to keyframes.
		Seek 2 seconds before offset and seek in decoded stream after that.
		 -ss before input seeks without decode
		 -ss after input seeks in decoded stream
		*/
		if($offset > 2) {
			$cmd .= ' -ss ' . ($offset - 2);
			$offset = 2;
		}
		$srcPath = $options['file']->getLocalRefPath();
		$cmd .= ' -y -i ' . wfEscapeShellArg( $srcPath );
		$cmd .= ' -ss ' . $offset . ' ';

		// Set the output size if set in options:
		if( isset( $options['width'] ) && isset( $options['height'] ) ){
			$cmd.= ' -s '. intval( $options['width'] ) . 'x' . intval( $options['height'] );
		}

			# MJPEG, that's the same as JPEG except it's supported by the windows build of ffmpeg
			# No audio, one frame
		$cmd .=	' -f mjpeg -an -vframes 1 ' .
			wfEscapeShellArg( $options['dstPath'] ) . ' 2>&1';

		$retval = 0;
		$returnText = wfShellExec( $cmd, $retval );
		// Check if it was successful
		if ( !$options['file']->getHandler()->removeBadFile( $options['dstPath'], $retval ) ) {
			return true;
		}
		// Filter nonsense
		$lines = explode( "\n", str_replace( "\r\n", "\n", $returnText ) );
		if ( substr( $lines[0], 0, 6 ) == 'FFmpeg' ) {
			for ( $i = 1; $i < count( $lines ); $i++ ) {
				if ( substr( $lines[$i], 0, 2 ) != '  ' ) {
					break;
				}
			}
			$lines = array_slice( $lines, $i );
		}
		// Return error box
		return new MediaTransformError( 'thumbnail_error', $options['width'], $options['height'], implode( "\n", $lines ) );
	}

	static function getThumbTime( $options ){
		$length = $options['file']->getLength();
		$thumbtime = false;

		// If start time param isset use that for the thumb:
		if(  isset( $options['start'] ) ) {
			$thumbtime = TimedMediaHandler::parseTimeString( $options['start'], $length );
			if( $thumbtime )
		 		return $thumbtime;
		}
		// else use thumbtime
		if ( isset( $options['thumbtime'] ) ) {
		 	$thumbtime = TimedMediaHandler::parseTimeString( $options['thumbtime'], $length );
		 	if( $thumbtime )
		 		return $thumbtime;
		}
		// Seek to midpoint by default, it tends to be more interesting than the start
		return $length / 2;
	}
}
