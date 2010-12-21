<?php

// TODO: Fix core printable stylesheet. Descendant selectors suck.

class OggHandler extends MediaHandler {
	const OGG_METADATA_VERSION = 2;

	function isEnabled() {
		return true;
	}

	function getParamMap() {
		return array(
			'img_width' => 'width',
			'ogg_noplayer' => 'noplayer',
			'ogg_noicon' => 'noicon',
			'ogg_thumbtime' => 'thumbtime',
		);
	}

	function validateParam( $name, $value ) {
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

	function parseTimeString( $seekString, $length = false ) {
		$parts = explode( ':', $seekString );
		$time = 0;
		$multiplier = 1;
		for ( $i = count( $parts ) - 1; $i >= 0; $i--, $multiplier *= 60 ) {
			if ( !is_numeric( $parts[$i] ) ) {
				return false;
			}
			$time +=  $parts[$i] * $multiplier;
		}

		if ( $time < 0 ) {
			wfDebug( __METHOD__.": specified negative time, using zero\n" );
			$time = 0;
		} elseif ( $length !== false && $time > $length - 1 ) {
			wfDebug( __METHOD__.": specified near-end or past-the-end time {$time}s, using end minus 1s\n" );
			$time = $length - 1;
		}
		// Round to nearest 0.1s
		$time = round( $time, 1 );
		return $time;
	}

	function makeParamString( $params ) {
		if ( isset( $params['thumbtime'] ) ) {
			$time = $this->parseTimeString( $params['thumbtime'] );
			if ( $time !== false ) {
				$s = sprintf( "%.1f", $time );
				if ( substr( $s, -2 ) == '.0' ) {
					$s = substr( $s, 0, -2 );
				}
				return 'seek=' . $s;
			}
		}
		return 'mid';
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
		global $wgOggVideoTypes;
		// Just return the size of the first video stream
		if ( $metadata === false ) {
			$metadata = $file->getMetadata();
		}
		$metadata = $this->unpackMetadata( $metadata );
		if ( isset( $metadata['error'] ) || !isset( $metadata['streams'] ) ) {
			return false;
		}
		foreach ( $metadata['streams'] as $stream ) {
			if ( in_array( $stream['type'], $wgOggVideoTypes ) ) {
				$pictureWidth = $stream['header']['PICW'];
				$parNumerator = $stream['header']['PARN'];
				$parDenominator = $stream['header']['PARD'];
				if( $parNumerator && $parDenominator ) {
					// Compensate for non-square pixel aspect ratios
					$pictureWidth = $pictureWidth * $parNumerator / $parDenominator;
				}
				return array(
					$pictureWidth,
					$stream['header']['PICH']
				);
			}
		}
		return array( false, false );
	}

	function getMetadata( $image, $path ) {
		$metadata = array( 'version' => self::OGG_METADATA_VERSION );

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
		} catch ( PEAR_Exception $e ) {
			// File not found, invalid stream, etc.
			$metadata['error'] = array(
				'message' => $e->getMessage(),
				'code' => $e->getCode()
			);
		}
		return serialize( $metadata );
	}

	function unpackMetadata( $metadata ) {
		$unser = @unserialize( $metadata );
		if ( isset( $unser['version'] ) && $unser['version'] == self::OGG_METADATA_VERSION ) {
			return $unser;
		} else {
			return false;
		}
	}

	function getMetadataType( $image ) {
		return 'ogg';
	}

	function isMetadataValid( $image, $metadata ) {
		return $this->unpackMetadata( $metadata ) !== false;
	}

	function getThumbType( $ext, $mime, $params = null ) {
		return array( 'jpg', 'image/jpeg' );
	}

	function doTransform( $file, $dstPath, $dstUrl, $params, $flags = 0 ) {

		$width = $params['width'];
		$srcWidth = $file->getWidth();
		$srcHeight = $file->getHeight();
		$height = $srcWidth == 0 ? $srcHeight : $width * $srcHeight / $srcWidth;
		$length = $this->getLength( $file );
		$noPlayer = isset( $params['noplayer'] );
		$noIcon = isset( $params['noicon'] );
		$targetFileUrl = $file->getURL();

		if ( !$noPlayer ) {
			// Hack for miscellaneous callers
			global $wgOut;
			$this->setHeaders( $wgOut );
		}

		if ( $srcHeight == 0 || $srcWidth == 0 ) {
			// Make audio player
			$height = empty( $params['height'] ) ? 20 : $params['height'];
			if ( $noPlayer ) {
				if ( $height > 100 ) {
					global $wgStylePath;
					$iconUrl = "$wgStylePath/common/images/icons/fileicon-ogg.png";
					return new ThumbnailImage( $file, $iconUrl, 120, 120 );
				} else {
					$scriptPath = self::getMyScriptPath();
					$iconUrl = "$scriptPath/info.png";
					return new ThumbnailImage( $file, $iconUrl, 22, 22 );
				}
			}
			if ( empty( $params['width'] ) ) {
				$width = 200;
			} else {
				$width = $params['width'];
			}
			return new OggAudioDisplay( $file, $targetFileUrl, $width, $height, $length, $dstPath, $noIcon );
		}

		// Video thumbnail only
		if ( $noPlayer ) {
			return new ThumbnailImage( $file, $dstUrl, $width, $height, $dstPath, $noIcon );
		}

		if ( $flags & self::TRANSFORM_LATER ) {
			return new OggVideoDisplay( $file, $targetFileUrl, $dstUrl, $width, $height, $length, $dstPath, $noIcon );
		}


		$thumbTime = false;
		if ( isset( $params['thumbtime'] ) ) {
			$thumbTime = $this->parseTimeString( $params['thumbtime'], $length );
		}
		if ( $thumbTime === false ) {
			# Seek to midpoint by default, it tends to be more interesting than the start
			$thumbTime = $length / 2;
		}

		wfMkdirParents( dirname( $dstPath ) );

		global $wgOggThumbLocation;
		if ( $wgOggThumbLocation !== false ) {
			$status = $this->runOggThumb( $file->getPath(), $dstPath, $thumbTime );
		} else {
			$status = $this->runFFmpeg( $file->getPath(), $dstPath, $thumbTime );
		}
		if ( $status === true ) {
			return new OggVideoDisplay( $file, $file->getURL(), $dstUrl, $width, $height, 
				$length, $dstPath );
		} else {
			return new MediaTransformError( 'thumbnail_error', $width, $height, $status );
		}
	}

	/**
	 * Run FFmpeg to generate a still image from a video file, using a frame close 
	 * to the given number of seconds from the start.
	 *
	 * Returns true on success, or an error message on failure.
	 */
	function runFFmpeg( $videoPath, $dstPath, $time ) {
		global $wgFFmpegLocation;
		wfDebug( __METHOD__." creating thumbnail at $dstPath\n" );
		$cmd = wfEscapeShellArg( $wgFFmpegLocation ) . 
			# FFmpeg only supports integer numbers of seconds
			' -ss ' . intval( $time ) . ' ' .
			' -i ' . wfEscapeShellArg( $videoPath ) . 
			# MJPEG, that's the same as JPEG except it's supported ffmpeg
			# No audio, one frame
			' -f mjpeg -an -vframes 1 ' .
			wfEscapeShellArg( $dstPath ) . ' 2>&1';

		$retval = 0;
		$returnText = wfShellExec( $cmd, $retval );

		if ( $this->removeBadFile( $dstPath, $retval ) || $retval ) {
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
			// Return error message
			return implode( "\n", $lines );
		}
		// Success
		return true;
	}

	/**
	 * Run oggThumb to generate a still image from a video file, using a frame 
	 * close to the given number of seconds from the start.
	 *
	 * Returns true on success, or an error message on failure.
	 */
	function runOggThumb( $videoPath, $dstPath, $time ) {
		global $wgOggThumbLocation;
		wfDebug( __METHOD__." creating thumbnail at $dstPath\n" );
		$cmd = wfEscapeShellArg( $wgOggThumbLocation ) .
			' -t ' . floatval( $time ) .
			' -n ' . wfEscapeShellArg( $dstPath ) .
			' ' . wfEscapeShellArg( $videoPath ) . ' 2>&1';
		$retval = 0;
		$returnText = wfShellExec( $cmd, $retval );

		if ( $this->removeBadFile( $dstPath, $retval ) || $retval ) {
			// oggThumb spams both stderr and stdout with useless progress
			// messages, and then often forgets to output anything when 
			// something actually does go wrong. So interpreting its output is
			// a challenge.
			$lines = explode( "\n", str_replace( "\r\n", "\n", $returnText ) );
			if ( count( $lines ) > 0 
				&& preg_match( '/invalid option -- \'n\'$/', $lines[0] ) )
			{
				return wfMsgForContent( 'ogg-oggThumb-version', '0.9' );
			} else {
				return wfMsgForContent( 'ogg-oggThumb-failed' );
			}
		}
		return true;
	}

	function canRender( $file ) { return true; }
	function mustRender( $file ) { return true; }

	function getLength( $file ) {
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return 0;
		} else {
			return $metadata['length'];
		}
	}

	function getStreamTypes( $file ) {
		$streamTypes = '';
		$metadata = $this->unpackMetadata( $file->getMetadata() );
		if ( !$metadata || isset( $metadata['error'] ) ) {
			return false;
		}
		foreach ( $metadata['streams'] as $stream ) {
			$streamTypes[$stream['type']] = true;
		}
		return array_keys( $streamTypes );
	}

	function getShortDesc( $file ) {
		global $wgLang, $wgOggAudioTypes, $wgOggVideoTypes;
		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			return parent::getShortDesc( $file );
		}
		if ( array_intersect( $streamTypes, $wgOggVideoTypes ) ) {
			// Count multiplexed audio/video as video for short descriptions
			$msg = 'ogg-short-video';
		} elseif ( array_intersect( $streamTypes, $wgOggAudioTypes ) ) {
			$msg = 'ogg-short-audio';
		} else {
			$msg = 'ogg-short-general';
		}
		return wfMsg( $msg, implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $this->getLength( $file ) ) );
	}

	function getLongDesc( $file ) {
		global $wgLang, $wgOggVideoTypes, $wgOggAudioTypes;

		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			$unpacked = $this->unpackMetadata( $file->getMetadata() );
			return wfMsg( 'ogg-long-error', $unpacked['error']['message'] );
		}
		if ( array_intersect( $streamTypes, $wgOggVideoTypes ) ) {
			if ( array_intersect( $streamTypes, $wgOggAudioTypes ) ) {
				$msg = 'ogg-long-multiplexed';
			} else {
				$msg = 'ogg-long-video';
			}
		} elseif ( array_intersect( $streamTypes, $wgOggAudioTypes ) ) {
			$msg = 'ogg-long-audio';
		} else {
			$msg = 'ogg-long-general';
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

	static function getMyScriptPath() {
		global $wgScriptPath;
		return "$wgScriptPath/extensions/OggHandler";
	}

	function setHeaders( $out ) {
		global $wgOggScriptVersion, $wgCortadoJarFile, $wgServer;

		if ( $out->hasHeadItem( 'OggHandlerScript' ) && $out->hasHeadItem( 'OggHandlerInlineScript' ) &&
			$out->hasHeadItem( 'OggHandlerInlineCSS' ) ) {
			return;
		}

		$msgNames = array( 'ogg-play', 'ogg-pause', 'ogg-stop', 'ogg-no-player',
			'ogg-player-videoElement', 'ogg-player-oggPlugin', 'ogg-player-cortado', 'ogg-player-vlc-mozilla',
			'ogg-player-vlc-activex', 'ogg-player-quicktime-mozilla', 'ogg-player-quicktime-activex',
			'ogg-player-totem', 'ogg-player-kaffeine', 'ogg-player-kmplayer', 'ogg-player-mplayerplug-in',
			'ogg-player-thumbnail', 'ogg-player-selected', 'ogg-use-player', 'ogg-more', 'ogg-download',
			'ogg-desc-link', 'ogg-dismiss', 'ogg-player-soundthumb', 'ogg-no-xiphqt' );
		$msgValues = array_map( 'wfMsg', $msgNames );
		$jsMsgs = Xml::encodeJsVar( (object)array_combine( $msgNames, $msgValues ) );
		$cortadoUrl = $wgCortadoJarFile;
		$scriptPath = self::getMyScriptPath();
		if( substr( $cortadoUrl, 0, 1 ) != '/'
			&& substr( $cortadoUrl, 0, 4 ) != 'http' ) {
			$cortadoUrl = "$wgServer$scriptPath/$cortadoUrl";
		}
		$encCortadoUrl = Xml::encodeJsVar( $cortadoUrl );
		$encExtPathUrl = Xml::encodeJsVar( $scriptPath );

		$out->addHeadItem( 'OggHandlerScript' , Html::linkedScript( "{$scriptPath}/OggPlayer.js?$wgOggScriptVersion" ) );

		$out->addHeadItem( 'OggHandlerInlineScript',  Html::inlineScript( <<<EOT

wgOggPlayer.msg = $jsMsgs;
wgOggPlayer.cortadoUrl = $encCortadoUrl;
wgOggPlayer.extPathUrl = $encExtPathUrl;

EOT
) );
		$out->addHeadItem( 'OggHandlerInlineCSS', Html::inlineStyle( <<<EOT

.ogg-player-options {
	border: solid 1px #ccc;
	padding: 2pt;
	text-align: left;
	font-size: 10pt;
}

.center .ogg-player-options ul {
	margin: 0.3em 0px 0px 1.5em;
}

EOT
) );
	}

	function parserTransformHook( $parser, $file ) {
		if ( isset( $parser->mOutput->hasOggTransform ) ) {
			return;
		}
		$parser->mOutput->hasOggTransform = true;
		$parser->mOutput->addOutputHook( 'OggHandler' );
	}

	static function outputHook( $outputPage, $parserOutput, $data ) {
		$instance = MediaHandler::getHandler( 'application/ogg' );
		if ( $instance ) {
			$instance->setHeaders( $outputPage );
		}
	}
}

class OggTransformOutput extends MediaTransformOutput {
	static $serial = 0;

	function __construct( $file, $videoUrl, $thumbUrl, $width, $height, $length, $isVideo,
		$path, $noIcon = false )
	{
		$this->file = $file;
		$this->videoUrl = $videoUrl;
		$this->url = $thumbUrl;
		$this->width = round( $width );
		$this->height = round( $height );
		$this->length = round( $length );
		$this->isVideo = $isVideo;
		$this->path = $path;
		$this->noIcon = $noIcon;
	}

	function toHtml( $options = array() ) {
		if ( count( func_get_args() ) == 2 ) {
			throw new MWException( __METHOD__ .' called in the old style' );
		}

		OggTransformOutput::$serial++;

		if ( substr( $this->videoUrl, 0, 4 ) != 'http' ) {
			global $wgServer;
			$url = $wgServer . $this->videoUrl;
		} else {
			$url = $this->videoUrl;
		}
		// Normalize values
		$length = floatval( $this->length );
		$width = intval( $this->width );
		$height = intval( $this->height );

		$alt = empty( $options['alt'] ) ? $this->file->getTitle()->getText() : $options['alt'];
		$scriptPath = OggHandler::getMyScriptPath();
		$showDescIcon = false;

		if ( $this->isVideo ) {
			$msgStartPlayer = wfMsg( 'ogg-play-video' );
			$imgAttribs = array(
				'src' => $this->url,
				'width' => $width,
				'height' => $height,
				'alt' => $alt );
			$playerHeight = $height;
		} else {
			// Sound file
			if ( $height > 100 ) {
				// Use a big file icon
				global $wgStylePath;
				$imgAttribs = array(
					'src' => "$wgStylePath/common/images/icons/fileicon-ogg.png",
					'width' => 125,
					'height' => 125,
					'alt' => $alt,
				);
			} else {
				 // Make an icon later if necessary
				$imgAttribs = false;
				$showDescIcon = !$this->noIcon;
				//$thumbDivAttribs = array( 'style' => 'text-align: right;' );
			}
			$msgStartPlayer = wfMsg( 'ogg-play-sound' );
			$playerHeight = 35;
		}

		// Set $thumb to the thumbnail img tag, or the thing that goes where
		// the thumbnail usually goes
		$descIcon = false;
		if ( !empty( $options['desc-link'] ) ) {
			$linkAttribs = $this->getDescLinkAttribs( $alt );
			if ( $showDescIcon ) {
				// Make image description icon link
				$imgAttribs = array(
					'src' => "$scriptPath/info.png",
					'width' => 22,
					'height' => 22,
					'alt' => $alt,
				);
				$linkAttribs['title'] = wfMsg( 'ogg-desc-link' );
				$descIcon = Xml::tags( 'a', $linkAttribs,
					Xml::element( 'img', $imgAttribs ) );
				$thumb = '';
			} elseif ( $imgAttribs ) {
				$thumb = Xml::tags( 'a', $linkAttribs,
					Xml::element( 'img', $imgAttribs ) );
			} else {
				$thumb = '';
			}
			$linkUrl = $linkAttribs['href'];
		} else {
			// We don't respect the file-link option, click-through to download is not appropriate
			$linkUrl = false;
			if ( $imgAttribs ) {
				$thumb = Xml::element( 'img', $imgAttribs );
			} else {
				$thumb = '';
			}
		}

		$id = "ogg_player_" . OggTransformOutput::$serial;

		$playerParams = Xml::encodeJsVar( (object)array(
			'id' => $id,
			'videoUrl' => $url,
			'width' => $width,
			'height' => $playerHeight,
			'length' => $length,
			'linkUrl' => $linkUrl,
			'isVideo' => $this->isVideo ) );

		$s = Xml::tags( 'div',
			array( 'id' => $id ),
			( $thumb ? Xml::tags( 'div', array(), $thumb ) : '' ) .
			Xml::tags( 'div', array(),
				Xml::tags( 'button',
					array(
						'onclick' => "if (typeof(wgOggPlayer) != 'undefined') wgOggPlayer.init(false, $playerParams);",
						'style' => "width: {$width}px; text-align: center",
						'title' => $msgStartPlayer,
					),
					Xml::element( 'img',
						array(
							'src' => "$scriptPath/play.png",
							'width' => 22,
							'height' => 22,
							'alt' => $msgStartPlayer
						)
					)
				)
			) .
			( $descIcon ? Xml::tags( 'div', array(), $descIcon ) : '' )
		);
		return $s;
	}
}

class OggVideoDisplay extends OggTransformOutput {
	function __construct( $file, $videoUrl, $thumbUrl, $width, $height, $length, $path, $noIcon=false ) {
		parent::__construct( $file, $videoUrl, $thumbUrl, $width, $height, $length, true, $path, false );
	}
}

class OggAudioDisplay extends OggTransformOutput {
	function __construct( $file, $videoUrl, $width, $height, $length, $path, $noIcon = false ) {
		parent::__construct( $file, $videoUrl, false, $width, $height, $length, false, $path, $noIcon );
	}
}
