<?php

/**
 * An image handler which adds support for Flash video (.flv) files.
 *
 * @author Adam Nielsen <malvineous@shikadi.net>
 * @copyright Copyright © 2009 Adam Nielsen
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * @file
 * @ingroup Media
 */

/**
 * @ingroup Media
 */
class FlvImageHandler extends ImageHandler {
	function isEnabled() {
		global $wgFLVConverters, $wgFLVConverter, $wgFLVProbes;
		wfDebug('probes is ' . print_r($wgFLVProbes, true) . "\n");
		if ((!isset( $wgFLVConverters[$wgFLVConverter])) || (!isset($wgFLVProbes[$wgFLVConverter]))) {
			wfDebug( "\$wgFLVConverter is invalid, disabling FLV preview frames.\n" );
			return false;
		} else {
			return true;
		}
	}

	function getImageSize($image, $filename) {
		global $wgFLVProbes, $wgFLVConverter, $wgFLVConverterPath;
		if( isset( $wgFLVProbes[$wgFLVConverter]['cmd'] ) ) {
			$cmd = str_replace(
				array( '$path/', '$input' ),
				array( $wgFLVConverterPath ? wfEscapeShellArg( "$wgFLVConverterPath/" ) : "",
					   wfEscapeShellArg( $filename ) ),
				$wgFLVProbes[$wgFLVConverter]['cmd'] ) . " 2>&1";
			wfProfileIn( 'rsvg' );
			wfDebug( __METHOD__.": $cmd\n" );
			$out = wfShellExec( $cmd, $retval );
			wfProfileOut( 'rsvg' );
			
			if (preg_match($wgFLVProbes[$wgFLVConverter]['regex'], $out, $matches)) {
				return array($matches[1], $matches[2]); // width/height
			} else {
				wfDebug(__METHOD__ . ': Unable to extract video dimensions from ' . $wgFLVConverter . ' output: ' . $out . "\n");
			}
		}
		wfDebug(__METHOD__ . ": No probe function defined, .flv previews unavailable.\n");
		return false;
	}

	function mustRender( $file ) {
		return true;
	}

	function normaliseParams( $image, &$params ) {
		if ( !parent::normaliseParams( $image, $params ) ) {
			return false;
		}

		$params['physicalWidth'] = $params['width'];
		$params['physicalHeight'] = $params['height'];
		return true;
	}

	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgFLVConverters, $wgFLVConverter, $wgFLVConverterPath;

		if ( !$this->normaliseParams( $image, $params ) ) {
			return new TransformParameterError( $params );
		}
		$clientWidth = $params['width'];
		$clientHeight = $params['height'];
		$physicalWidth = $params['physicalWidth'];
		$physicalHeight = $params['physicalHeight'];
		$srcPath = $image->getPath();

		if ( $flags & self::TRANSFORM_LATER ) {
			return new ThumbnailImage( $image, $dstUrl, $clientWidth, $clientHeight, $dstPath );
		}

		if ( !wfMkdirParents( dirname( $dstPath ) ) ) {
			return new MediaTransformError( 'thumbnail_error', $clientWidth, $clientHeight,
				wfMsg( 'thumbnail_dest_directory' ) );
		}

		$err = false;
		if( isset( $wgFLVConverters[$wgFLVConverter] ) ) {
			$cmd = str_replace(
				array( '$path/', '$width', '$height', '$input', '$output' ),
				array( $wgFLVConverterPath ? wfEscapeShellArg( "$wgFLVConverterPath/" ) : "",
					   intval( $physicalWidth ),
					   intval( $physicalHeight ),
					   wfEscapeShellArg( $srcPath ),
					   wfEscapeShellArg( $dstPath ) ),
				$wgFLVConverters[$wgFLVConverter] ) . " 2>&1";
			wfProfileIn( 'rsvg' );
			wfDebug( __METHOD__.": $cmd\n" );
			$err = wfShellExec( $cmd, $retval );
			wfProfileOut( 'rsvg' );
		}

		$removed = $this->removeBadFile( $dstPath, $retval );
		if ( $retval != 0 || $removed ) {
			wfDebugLog( 'thumbnail',
				sprintf( 'thumbnail failed on %s: error %d "%s" from "%s"',
					wfHostname(), $retval, trim($err), $cmd ) );
			return new MediaTransformError( 'thumbnail_error', $clientWidth, $clientHeight, $err );
		} else {
			return new ThumbnailImage( $image, $dstUrl, $clientWidth, $clientHeight, $dstPath );
		}
	}

	/*function getImageSize( $image, $path ) {
		return wfGetFLVsize( $path );
	}*/

	function getThumbType( $ext, $mime ) {
		return array( 'png', 'image/png' );
	}

	function getLongDesc( $file ) {
		global $wgLang;
		wfLoadExtensionMessages('FlvHandler');
		return wfMsgExt( 'flv-long-desc', 'parseinline',
			$wgLang->formatNum( $file->getWidth() ),
			$wgLang->formatNum( $file->getHeight() ),
			$wgLang->formatSize( $file->getSize() ) );
	}
}
