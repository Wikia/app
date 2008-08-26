<?php

class FancyCaptcha extends SimpleCaptcha {
	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * @param string $answer
	 * @param array $info
	 * @return bool
	 */
	function keyMatch( $answer, $info ) {
		global $wgCaptchaSecret;

		$digest = $wgCaptchaSecret . $info['salt'] . $answer . $wgCaptchaSecret . $info['salt'];
		$answerHash = substr( md5( $digest ), 0, 16 );

		if( $answerHash == $info['hash'] ) {
			wfDebug( "FancyCaptcha: answer hash matches expected {$info['hash']}\n" );
			return true;
		} else {
			wfDebug( "FancyCaptcha: answer hashes to $answerHash, expected {$info['hash']}\n" );
			return false;
		}
	}

	function addCaptchaAPI(&$resultArr) {
		$info = $this->pickImage();
		if( !$info ) {
			$resultArr['captcha']['error'] = 'Out of images';
			return;
		}
		$index = $this->storeCaptcha( $info );
		$title = Title::makeTitle( NS_SPECIAL, 'Captcha/image' );
		$resultArr['captcha']['type'] = 'image';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['url'] = $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) );		
	}

	/**
	 * Insert the captcha prompt into the edit form.
	 */
	function getForm() {
		$info = $this->pickImage();
		if( !$info ) {
			die( "out of captcha images; this shouldn't happen" );
		}

		// Generate a random key for use of this captcha image in this session.
		// This is needed so multiple edits in separate tabs or windows can
		// go through without extra pain.
		$index = $this->storeCaptcha( $info );

		wfDebug( "Captcha id $index using hash ${info['hash']}, salt ${info['salt']}.\n" );

		$title = Title::makeTitle( NS_SPECIAL, 'Captcha/image' );

		return "<p>" .
			wfElement( 'img', array(
				'src'    => $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) ),
				'width'  => $info['width'],
				'height' => $info['height'],
				'alt'    => '' ) ) .
			"</p>\n" .
			wfElement( 'input', array(
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ) ) .
			"<p>" .
			wfElement( 'input', array(
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord' ) ) .
			"</p>\n";
	}

	/**
	 * Select a previously generated captcha image from the queue.
	 * @fixme subject to race conditions if lots of files vanish
	 * @return mixed tuple of (salt key, text hash) or false if no image to find
	 */
	function pickImage() {
		global $wgCaptchaDirectory, $wgCaptchaDirectoryLevels;
		return $this->pickImageDir(
			$wgCaptchaDirectory,
			$wgCaptchaDirectoryLevels );
	}
	
	function pickImageDir( $directory, $levels ) {
		if( $levels ) {
			$dirs = array();
			
			// Check which subdirs are actually present...
			$dir = opendir( $directory );
			while( false !== ($entry = readdir( $dir ) ) ) {
				if( ctype_xdigit( $entry ) && strlen( $entry ) == 1 ) {
					$dirs[] = $entry;
				}
			}
			closedir( $dir );
			
			$place = mt_rand( 0, count( $dirs ) - 1 );
			// In case all dirs are not filled,
			// cycle through next digits...
			for( $j = 0; $j < count( $dirs ); $j++ ) {
				$char = $dirs[($place + $j) % count( $dirs )];
				$return = $this->pickImageDir( "$directory/$char", $levels - 1 );
				if( $return ) {
					return $return;
				}
			}
			// Didn't find any images in this directory... empty?
			return false;
		} else {
			return $this->pickImageFromDir( $directory );
		}
	}
	
	function pickImageFromDir( $directory ) {
		if( !is_dir( $directory ) ) {
			return false;
		}
		$n = mt_rand( 0, $this->countFiles( $directory ) - 1 );
		$dir = opendir( $directory );

		$count = 0;

		$entry = readdir( $dir );
		$pick = false;
		while( false !== $entry ) {
			$entry = readdir( $dir );
			if( preg_match( '/^image_([0-9a-f]+)_([0-9a-f]+)\\.png$/', $entry, $matches ) ) {
				$size = getimagesize( "$directory/$entry" );
				$pick = array(
					'salt' => $matches[1],
					'hash' => $matches[2],
					'width' => $size[0],
					'height' => $size[1],
					'viewed' => false,
				);
				if( $count++ == $n ) {
					break;
				}
			}
		}
		closedir( $dir );
		return $pick;
	}

	/**
	 * Count the number of files in a directory.
	 * @return int
	 */
	function countFiles( $dirname ) {
		$dir = opendir( $dirname );
		$count = 0;
		while( false !== ($entry = readdir( $dir ) ) ) {
			if( $entry != '.' && $entry != '..' ) {
				$count++;
			}
		}
		closedir( $dir );
		return $count;
	}

	function showImage() {
		global $wgOut, $wgRequest;

		$wgOut->disable();

		$info = $this->retrieveCaptcha();
		if( $info ) {
			/*
			// Be a little less restrictive for now; in at least some circumstances,
			// Konqueror tries to reload the image even if you haven't navigated
			// away from the page.
			if( $info['viewed'] ) {
				wfHttpError( 403, 'Access Forbidden', "Can't view captcha image a second time." );
				return false;
			}
			*/

			$info['viewed'] = wfTimestamp();
			$this->storeCaptcha( $info );

			$salt = $info['salt'];
			$hash = $info['hash'];
			$file = $this->imagePath( $salt, $hash );

			if( file_exists( $file ) ) {
				global $IP;
				require_once "$IP/includes/StreamFile.php";
				header( "Cache-Control: private, s-maxage=0, max-age=3600" );
				wfStreamFile( $file );
				return true;
			}
		}
		wfHttpError( 500, 'Internal Error', 'Requested bogus captcha image' );
		return false;
	}
	
	function imagePath( $salt, $hash ) {
		global $wgCaptchaDirectory, $wgCaptchaDirectoryLevels;
		$file = $wgCaptchaDirectory;
		$file .= DIRECTORY_SEPARATOR;
		for( $i = 0; $i < $wgCaptchaDirectoryLevels; $i++ ) {
			$file .= $hash{$i};
			$file .= DIRECTORY_SEPARATOR;
		}
		$file .= "image_{$salt}_{$hash}.png";
		return $file;
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param $action Action being performed
	 * @return string
	 */
	function getMessage( $action ) {
		$name = 'fancycaptcha-' . $action;
		$text = wfMsg( $name );
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMsg( 'fancycaptcha-edit' ) : $text;
	}

}
