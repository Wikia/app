<?php

class PNGHandler extends BitmapHandler
{
	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $egPngdsPath, $egPngdsFallback, $egPngdsMinSize;
			
		if ( !$this->normaliseParams( $image, $params ) ) {
			return new TransformParameterError( $params );
		}
		
		$clientWidth = $params['width'];
		$clientHeight = $params['height'];
		$srcWidth = $image->getWidth();
		$srcHeight = $image->getHeight();
		$srcPath = $image->getPath();
		$retval = 0;
		
		if (!is_null($egPngdsMinSize) && (($srcWidth * $srcHeight) < $egPngdsMinSize))
			return parent::doTransform($image, $dstPath, $dstUrl, $params, $flags);

		if ( $params['physicalWidth'] == $srcWidth && $params['physicalHeight'] == $srcHeight ) {
			# normaliseParams (or the user) wants us to return the unscaled image
			wfDebug( __METHOD__.": returning unscaled image\n" );
			return new ThumbnailImage( $image, $image->getURL(), $clientWidth, $clientHeight, $srcPath );
		}

		wfDebug( __METHOD__.": creating {$physicalWidth}x{$physicalHeight} thumbnail at $dstPath\n" );

		$cmd = "{$egPngdsPath}pngds ".
			"--width {$params['physicalWidth']} ".
			"--height {$params['physicalHeight']} ".
			"--no-filtering ".
			wfEscapeShellArg( $srcPath )." ".
			wfEscapeShellArg( $dstPath );
			

		wfDebug( __METHOD__.": Running pngds: $cmd\n" );
		wfProfileIn( 'convert' );
		$err = wfShellExec( $cmd, $retval );
		wfProfileOut( 'convert' );

		if ($err !== 0 && $egPngdsFallback)
			return parent::doTransform($image, $dstPath, $dstUrl, $params, $flags);

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
}
