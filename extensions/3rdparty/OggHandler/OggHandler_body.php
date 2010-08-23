<?php

// TODO: Fix core printable stylesheet. Descendant selectors suck.

class OggHandler extends MediaHandler {
	const OGG_METADATA_VERSION = 1;

	static $magicDone = false;

	var $videoTypes = array( 'Theora' );
	var $audioTypes = array( 'Vorbis', 'Speex', 'FLAC' );

	function isEnabled() {
		return true;
	}

	static function registerMagicWords( &$magicData, $code ) {
		wfLoadExtensionMessages( 'OggHandler' );
		return true;
	}

	function getParamMap() {
		wfLoadExtensionMessages( 'OggHandler' );
		return array(
			'img_width' => 'width',
			'ogg_noplayer' => 'noplayer',
			'ogg_noicon' => 'noicon',
			'ogg_thumbtime' => 'thumbtime',
		);
	}

	function validateParam( $name, $value ) {
		if ( $name == 'thumbtime' ) {
			if ( $this->parseTimeString( $value ) === false ) {
				return false;
			}
		}
		return true;
	}

	function parseTimeString( $seekString, $length = false ) {
		$parts = explode( ':', $seekString );
		$time = 0;
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

	function makeParamString( $params ) {
		if ( isset( $params['thumbtime'] ) ) {
			$time = $this->parseTimeString( $params['thumbtime'] );
			if ( $time !== false ) {
				return 'seek=' . $time;
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
		// Just return the size of the first video stream
		if ( $metadata === false ) {
			$metadata = $file->getMetadata();
		}
		$metadata = $this->unpackMetadata( $metadata );
		if ( isset( $metadata['error'] ) ) {
			return false;
		}
		foreach ( $metadata['streams'] as $stream ) {
			if ( in_array( $stream['type'], $this->videoTypes ) ) {
				return array(
					$stream['header']['PICW'],
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
			foreach ( $f->listStreams() as $streamType => $streamIDs ) {
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

	function getThumbType( $ext, $mime ) {
		return array( 'jpg', 'image/jpeg' );
	}

	function doTransform( $file, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgFFmpegLocation;

		$width = $params['width'];
		$srcWidth = $file->getWidth();
		$srcHeight = $file->getHeight();
		$height = $srcWidth == 0 ? $srcHeight : $width * $srcHeight / $srcWidth;
		$length = $this->getLength( $file );
		$noPlayer = isset( $params['noplayer'] );
		$noIcon = isset( $params['noicon'] );

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
			return new OggAudioDisplay( $file, $file->getURL(), $width, $height, $length, $dstPath, $noIcon );
		}

		// Video thumbnail only
		if ( $noPlayer ) {
			return new ThumbnailImage( $file, $dstUrl, $width, $height, $dstPath );
		}

		if ( $flags & self::TRANSFORM_LATER ) {
			return new OggVideoDisplay( $file, $file->getURL(), $dstUrl, $width, $height, $length, $dstPath );
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

		wfDebug( "Creating video thumbnail at $dstPath\n" );

		$cmd = wfEscapeShellArg( $wgFFmpegLocation ) .
			' -ss ' . intval( $thumbTime ) . ' ' .
			' -i ' . wfEscapeShellArg( $file->getPath() ) .
			# MJPEG, that's the same as JPEG except it's supported by the windows build of ffmpeg
			# No audio, one frame
			' -f mjpeg -an -vframes 1 ' .
			wfEscapeShellArg( $dstPath ) . ' 2>&1';

		$retval = 0;
		$returnText = wfShellExec( $cmd, $retval );

		if ( $this->removeBadFile( $dstPath, $retval ) || $retval ) {
			#re-attempt encode command on frame time 1 and with mapping (special case for chopped oggs)
			$cmd = wfEscapeShellArg( $wgFFmpegLocation ) .
			' -map 0:1 '.
			' -ss 1 ' .
			' -i ' . wfEscapeShellArg( $file->getPath() ) .
			' -f mjpeg -an -vframes 1 ' .
			wfEscapeShellArg( $dstPath ) . ' 2>&1';

			$retval = 0;
			$returnText = wfShellExec( $cmd, $retval );
			//if still bad return error:
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
				// Return error box
				return new MediaTransformError( 'thumbnail_error', $width, $height, implode( "\n", $lines ) );
			}
		}
		return new OggVideoDisplay( $file, $file->getURL(), $dstUrl, $width, $height, $length, $dstPath );
	}

	function canRender( $file ) { return true; }
	function mustRender( $file ) { return true; }

	/*
	function formatMetadata( $image, $metadata ) {
		if ( !$this->isMetadataValid( $image, $metadata ) ) {
			return false;
		}
		$metadata = unserialize( $metadata );
		$formatted = array();
		if ( isset( $metadata['error'] ) ) {
			self::addMeta( $formatted, 'visible', 'ogg', 'error', $metadata['error']['message'] );
			return $formatted;
		}
		$formatted = array();
		$n = 0;
		foreach ( $metadata['streams'] as $stream ) {
			$prefix = "Stream $n ";
			$type = strtolower( $stream['type'] );
			self::addMeta( $formatted, 'visible', 'ogg', 'type', $stream['type'], $n );
			self::addMeta( $formatted, 'visible', 'ogg', 'vendor', $stream['vendor'], $n );
			self::addMeta( $formatted, 'visible', 'ogg', 'length', $stream['length'], $n );
			self::addMeta( $formatted, 'visible', 'ogg', 'size', $stream['size'], $n );

			foreach ( $stream['header'] as $name => $value ) {
				self::addMeta( $formatted, 'visible', $type, $name, $value, $n );
				$visible[$prefix . $name] = wfEscapeWikiText( $value );
			}
			foreach ( $stream['comments'] as $name => $value ) {
				self::addMeta( $formatted, 'visible', $type, $name, $value, $n );
			}
		}
		return $formatted;
	}*/

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
		global $wgLang;
		wfLoadExtensionMessages( 'OggHandler' );
		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			return parent::getShortDesc( $file );
		}
		if ( array_intersect( $streamTypes, $this->videoTypes ) ) {
			// Count multiplexed audio/video as video for short descriptions
			$msg = 'ogg-short-video';
		} elseif ( array_intersect( $streamTypes, $this->audioTypes ) ) {
			$msg = 'ogg-short-audio';
		} else {
			$msg = 'ogg-short-general';
		}
		return wfMsg( $msg, implode( '/', $streamTypes ),
			$wgLang->formatTimePeriod( $this->getLength( $file ) ) );
	}

	function getLongDesc( $file ) {
		global $wgLang;
		wfLoadExtensionMessages( 'OggHandler' );
		$streamTypes = $this->getStreamTypes( $file );
		if ( !$streamTypes ) {
			$unpacked = $this->unpackMetadata( $file->getMetadata() );
			return wfMsg( 'ogg-long-error', $unpacked['error']['message'] );
		}
		if ( array_intersect( $streamTypes, $this->videoTypes ) ) {
			if ( array_intersect( $streamTypes, $this->audioTypes ) ) {
				$msg = 'ogg-long-multiplexed';
			} else {
				$msg = 'ogg-long-video';
			}
		} elseif ( array_intersect( $streamTypes, $this->audioTypes ) ) {
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
		wfLoadExtensionMessages( 'OggHandler' );
		if ( $file->getWidth() ) {
			return wfMsg( 'video-dims', $wgLang->formatTimePeriod( $this->getLength( $file ) ),
				$wgLang->formatNum( $file->getWidth() ),
				$wgLang->formatNum( $file->getHeight() ) );
		} else {
			return $wgLang->formatTimePeriod( $this->getLength( $file ) );
		}
	}

	static function getMyScriptPath() {
		global $wgExtensionsPath;
		return "{$wgExtensionsPath}/3rdparty/OggHandler";
	}

	function setHeaders( $out ) {
		global $wgOggScriptVersion, $wgCortadoJarFile, $wgServer, $wgUser, $wgScriptPath,
				$wgPlayerStatsCollection;

		if ( $out->hasHeadItem( 'OggHandler' ) ) {
			return;
		}

		wfLoadExtensionMessages( 'OggHandler' );

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

		$out->addHeadItem( 'OggHandler', <<<EOT
<script type="text/javascript" src="$scriptPath/OggPlayer.js?$wgOggScriptVersion"></script>
<script type="text/javascript">
wgOggPlayer.msg = $jsMsgs;
wgOggPlayer.cortadoUrl = $encCortadoUrl;
wgOggPlayer.extPathUrl = $encExtPathUrl;
</script>
<style type="text/css">
.ogg-player-options {
	border: solid 1px #ccc;
	padding: 2pt;
	text-align: left;
	font-size: 10pt;
}
</style>
EOT
);

		//if collecting stats add relevant code:
		if( $wgPlayerStatsCollection ){
			//the player stats js file  MUST be on the same server as OggHandler
			$playerStats_js = htmlspecialchars ( $wgScriptPath ). '/extensions/PlayerStatsGrabber/playerStats.js';

			$jsUserHash = sha1( $wgUser->getName() . $wgProxyKey );
			$enUserHash = Xml::encodeJsVar( $jsUserHash );

			$out->addHeadItem( 'playerStatsCollection',  <<<EOT
<script type="text/javascript">
wgOggPlayer.userHash = $enUserHash;
</script>
<script type="text/javascript" src="$playerStats_js"></script>
EOT
);
		}

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

		// Wikia: use fixed width (RT #46188)
		if (!$this->isVideo) {
			$this->width = 150;
		}
	}

	function toHtml( $options = array() ) {
		global $wgStylePath;

		// Wikia - begin
		// RT #25329
		global $wgWysiwygParserEnabled;
		if(!empty($wgWysiwygParserEnabled)) {
			return "\x7f-WYSIWYG-IMAGE-\x7f";
		}
		// Wikia - end

		wfLoadExtensionMessages( 'OggHandler' );
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
		$length = intval( $this->length );
		$width = intval( $this->width );
		$height = intval( $this->height );
		$alt = empty( $options['alt'] ) ? $this->file->getTitle()->getText() : $options['alt'];
		$scriptPath = OggHandler::getMyScriptPath();
		$thumbDivAttribs = array();
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
				$imgAttribs = array(
					'src' => "$wgStylePath/common/images/icons/fileicon-ogg.png",
					'width' => 125,
					'height' => 125,
					'alt' => $alt,
				);
			} else {
				 // make an icon later if necessary
				$imgAttribs = false;
				$showDescIcon = !$this->noIcon;
				//$thumbDivAttribs = array( 'style' => 'text-align: right;' );
			}
			$msgStartPlayer = wfMsg( 'ogg-play-sound' );
			$playerHeight = 0;
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
			array(
				'id' => $id,
				'style' => "width: ".( $thumb ? '150' : $width )."px; text-align: center" 
			),
			( $thumb ? Xml::tags( 'div', array(), $thumb ) : '' ) .
			Xml::tags( 'div', array(),
				Xml::tags( 'button',
					array(
						'onclick' => "if (typeof(wgOggPlayer) != 'undefined') wgOggPlayer.init(false, $playerParams);",
						'style' => "width: 150px; background-image: url('$wgStylePath/common/images/ogg-button.png'); height: 30px; -moz-box-shadow: none; border: none",
						'title' => $msgStartPlayer,
					),
					'&nbsp;'
				)
			) .
			( $descIcon ? Xml::tags( 'div', array(), $descIcon ) : '' )
		);
		return $s;
	}
}

class OggVideoDisplay extends OggTransformOutput {
	function __construct( $file, $videoUrl, $thumbUrl, $width, $height, $length, $path ) {
		parent::__construct( $file, $videoUrl, $thumbUrl, $width, $height, $length, true, $path, false );
	}
}

class OggAudioDisplay extends OggTransformOutput {
	function __construct( $file, $videoUrl, $width, $height, $length, $path, $noIcon = false ) {
		parent::__construct( $file, $videoUrl, false, $width, $height, $length, false, $path, $noIcon );
	}
}
