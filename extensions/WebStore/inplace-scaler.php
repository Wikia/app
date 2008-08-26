<?php

require( dirname( __FILE__ ) . '/WebStoreStart.php' );

class InplaceScaler extends WebStoreCommon {
	function execute() {
		global $wgRequest, $wgContLanguageCode;

		if ( !$this->scalerAccessRanges ) {
			$this->htmlError( 403, 'inplace_access_disabled' );
			return false;
		}

		/**
		 * Run access checks against REMOTE_ADDR rather than wfGetIP(), since we're not
		 * giving access even to trusted proxies, only direct clients.
		 */
		$allowed = false;
		foreach ( $this->scalerAccessRanges as $range ) {
			if ( IP::isInRange( $_SERVER['REMOTE_ADDR'], $range ) ) {
				$allowed = true;
				break;
			}
		}
		
		if ( !$allowed ) {
			$this->htmlError( 403, 'inplace_access_denied' );
			return false;
		}

		if ( !$wgRequest->wasPosted() ) {
			echo $this->dtd();
?>
<html>
<head><title>inplace-scaler.php Test Interface</title></head>
<body>
<form method="post" action="inplace-scaler.php" enctype="multipart/form-data" >
<p>File: <input type="file" name="data" /></p>
<p>Width: <input type="text" name="width" /></p>
<p>Page: <input type="page" name="page" /></p>
<p><input type="submit" value="OK" /></p>
</form>
</body>
</html>
<?php
			return true;
		}

		$tempDir = $this->tmpDir . '/' . gmdate( self::$tempDirFormat );
		if ( !is_dir( $tempDir ) ) {
			if ( !wfMkdirParents( $tempDir ) ) {
				$this->htmlError( 500, 'inplace_scaler_no_temp' );
				return false;
			}
		}

		$name = $wgRequest->getFileName( 'data' );
		$srcTemp = $wgRequest->getFileTempname( 'data' );

		$params = $_REQUEST;
		unset( $params['file'] );
		if ( get_magic_quotes_gpc() ) { 
			$params = array_map( 'stripslashes', $params );
		}

		$i = strrpos( $name, '.' );
		$ext = Image::normalizeExtension( $i ? substr( $name, $i + 1 ) : '' );

		$magic = MimeMagic::singleton();
		$mime = $magic->guessTypesForExtension( $ext );

		$image = UnregisteredLocalFile::newFromPath( $srcTemp, $mime );

		$handler = $image->getHandler();
		if ( !$handler ) {
			$this->htmlError( 400, 'inplace_scaler_no_handler' );
			return false;
		}

		if ( !isset( $params['page'] ) ) {
			$params['page'] = 1;
		}
		$srcWidth = $image->getWidth( $params['page'] );
		$srcHeight = $image->getHeight( $params['page'] );
		if ( $srcWidth <= 0 || $srcHeight <= 0 ) {
			$this->htmlError( 400, 'inplace_scaler_invalid_image' );
			return false;
		}

		list( $dstExt, $dstMime ) = $handler->getThumbType( $ext, $mime );
		if ( preg_match( '/[ \\n;=]/', $name ) ) {
			$dstName = "thumb.$ext";
		} else {
			$dstName = $name;
		}
		if ( $dstExt != $ext ) {
			$dstName = "$dstName.$dstExt";
		}

		$dstTemp = tempnam( $tempDir, 'mwimg' );

		$thumb = $handler->doTransform( $image, $dstTemp, false, $params );
		if ( !$thumb || $thumb->isError()  ) {
			$error = $thumb ? $thumb->getHtmlMsg() : '';
			$this->htmlErrorReal( 500, 'inplace_scaler_failed', array(''), $error );
			unlink( $dstTemp );
			return false;
		}
		$stat = stat( $dstTemp );
		if ( !$stat  ) {
			$this->htmlError( 500, 'inplace_scaler_no_output' );
			return false;
		}

		if ( $stat['size'] == 0 ) {
			$this->htmlError( 500, 'inplace_scaler_no_output' );
			unlink( $dstTemp );
			return false;
		}

		wfDebug( __METHOD__.": transformation completed successfully, streaming output...\n" );
		header( "Content-Type: $dstMime" );
		header( "Content-Disposition: inline;filename*=utf-8'$wgContLanguageCode'" . urlencode( $dstName ) );
		readfile( $dstTemp );
		unlink( $dstTemp );
	}
}

// Fatal errors can cause PHP to spew out some HTML and exit with a 200 response, 
// which would leave a corrupt image file permanently on disk. Prevent this from
// happening.
ini_set( 'display_errors', false );
$s = new InplaceScaler;
$s->execute();

?>
