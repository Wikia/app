<?php

/**
 * This is an example use of SpecialPage controller
 * @author MoLi
 *
 */

if ( !defined( 'MW_NO_OUTPUT_COMPRESSION' ) ) {
	define( 'MW_NO_OUTPUT_COMPRESSION', 1 );
}

class AuthImageSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'AuthImage', '', false );
	}

	/**
	 * this is default method, which in this example just redirects to helloWorld method
	 */
	public function index() {
		$this->forward( 'AuthImageSpecialPage', 'getImage' );
	}

	/**
	 * getImage method
	 *
	 */
	public function getImage() {
		wfProfileIn( __METHOD__ );

		if ( $this->wg->User->isLoggedIn() ) {
			# make proper thumb path: c/central/images/thumb/....
			$path = sprintf( "%s/%s/images", substr( $this->wg->DBname, 0, 1 ), $this->wg->DBname );
			# take thumb request from request
			$img = $this->getVal( 'image' );

			if ( preg_match( '/^(\/?)thumb\//', $img ) ) {
				# build proper thumb url for thumbnailer
				$thumb_url = sprintf( "%s/%s/%s", $this->wg->ThumbnailerService, $path, $img );

				# call thumbnailer
				$options = array( 'method' => 'GET', 'timeout' => 'default', 'noProxy' => 1 );
				$thumb_request = MWHttpRequest::factory( $thumb_url, $options );
				$status = $thumb_request->execute();
				$headers = $thumb_request->getResponseHeaders();

				if ( $status->isOK() ) {
					if ( !empty( $headers ) ) {
						foreach ( $headers as $header_name => $header_value ) {
							if ( is_array( $header_value ) ) {
								list( $value ) = $header_value;
							} else {
								$value = $header_value;
							}
							header( sprintf( "%s: %s", $header_name, $value ) );
						}
					}
					echo $thumb_request->getContent();
				} else {
					wfdebug("Cannot generate auth thumb");
					$this->_access_forbidden( 'img-auth-accessdenied', 'img-auth-nofile', $img );
				}
			} else {
				# serve original image
				$filename = realpath( sprintf( "%s/%s", $this->wg->UploadDirectory, $img ) );
				$stat = @stat( $filename );
				if ( $stat ) {
					wfResetOutputBuffers();
					$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
					$imageType = finfo_file( $fileinfo, $filename);

					header( sprintf( "Content-Disposition: inline;filename*=utf-8'%s'%s", $this->wg->ContLanguageCode, urlencode( basename( $filename ) ) ) );
					header( sprintf( "Content-Type: %s", $imageType ) );
					header( sprintf( "Content-Length: %d" . $stat['size'] ) );

					readfile( $filename );
				} else {
					$this->_access_forbidden( 'img-auth-accessdenied', 'img-auth-nopathinfo', $img );
				}
			}
		} else {
			$this->_access_forbidden( 'img-auth-accessdenied','img-auth-public', '' );
		}

		wfProfileOut( __METHOD__ );
		exit;
	}

	private function _access_forbidden( $msg1, $msg2, $img ) {
		$msgHdr = htmlspecialchars( wfMsg( $msg1 ) );
		$detailMsg = htmlspecialchars( wfMsg( ( $this->wg->ImgAuthDetails ? $msg2 : 'badaccess-group0'), $img ) );

		$header = wfMsgExt( $msg1, array('language' => 'en') );
		$message = wfMsgExt( $msg2, array('language' => 'en'), $img );
		wfDebugLog( __METHOD__, "access forbidden header: $header, Msg: $message");

		header( 'HTTP/1.0 403 Forbidden' );
		header( 'Cache-Control: no-cache' );
		header( 'Content-Type: text/html; charset=utf-8' );
		echo "<html><body><h1>$msgHdr</h1><p>$detailMsg</p></body></html>";
	}
}
