<?php

namespace Captcha\Modules;

class FancyCaptcha extends BaseCaptcha {
	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * @param string $answer
	 * @param array $info
	 * @return bool
	 */
	public function keyMatch( $answer, $info ) {
		global $wgCaptchaSecret;

		$digest = $wgCaptchaSecret . $info['salt'] . $answer . $wgCaptchaSecret . $info['salt'];
		$answerHash = substr( md5( $digest ), 0, 16 );

		if ( $answerHash == $info['hash'] ) {
			wfDebug( "FancyCaptcha: answer hash matches expected {$info['hash']}\n" );
			return true;
		} else {
			wfDebug( "FancyCaptcha: answer hashes to $answerHash, expected {$info['hash']}\n" );
			return false;
		}
	}

	public function addCaptchaAPI( &$resultArr ) {
		$info = $this->pickImage();
		if ( !$info ) {
			$resultArr['captcha']['error'] = 'Out of images';
			return;
		}
		$index = $this->storeCaptcha( $info );
		$title = \SpecialPage::getTitleFor( 'Captcha', 'image' );
		$resultArr['captcha']['type'] = 'image';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['url'] = $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) );
	}

	/**
	 * Insert the captcha prompt into the edit form.
	 *
	 * @param string $class
	 *
	 * @return string
	 *
	 * @throws \MWException
	 */
	public function getForm( $class = '' ) {
		$info = $this->pickImage();
		if ( !$info ) {
			throw new \MWException( "Ran out of captcha images" );
		}

		// Generate a random key for use of this captcha image in this session.
		// This is needed so multiple edits in separate tabs or windows can
		// go through without extra pain.
		$index = $this->storeCaptcha( $info );

		wfDebug( "Captcha id $index using hash ${info['hash']}, salt ${info['salt']}.\n" );

		$title = \SpecialPage::getTitleFor( 'Captcha', 'image' );

		return "<p>" .
			\Xml::element( 'img', [
				'src'    => $title->getLocalUrl( 'wpCaptchaId=' . urlencode( $index ) ),
				'width'  => $info['width'],
				'height' => $info['height'],
				'alt'    => ''
			] ) .
			"</p>\n" .
			\Xml::element( 'input', [
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index
			] ) .
			"<p>" .
			\Html::element( 'input', [
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'autocorrect' => 'off',
				'autocapitalize' => 'off',
				'required',
				'class' => $class,
				'placeholder' => wfMsg('captcha-input-placeholder')
			] ) .
			"</p>\n";
	}

	/**
	 * Select a previously generated captcha image from the queue.
	 * @fixme subject to race conditions if lots of files vanish
	 *
	 * @return mixed tuple of (salt key, text hash) or false if no image to find
	 */
	public function pickImage() {
		global $wgCaptchaDirectory, $wgCaptchaDirectoryLevels;
		return $this->pickImageDir(
			$wgCaptchaDirectory,
			$wgCaptchaDirectoryLevels );
	}

	public function pickImageDir( $directory, $levels ) {
		if ( $levels ) {
			$dirs = [];

			// Check which subdirs are actually present...
			$dir = opendir( $directory );
			if ( !$dir ) {
				return false;
			}
			while ( false !== ( $entry = readdir( $dir ) ) ) {
				if ( ctype_xdigit( $entry ) && strlen( $entry ) == 1 ) {
					$dirs[] = $entry;
				}
			}
			closedir( $dir );

			$place = mt_rand( 0, count( $dirs ) - 1 );
			// In case all dirs are not filled,
			// cycle through next digits...
			for ( $j = 0; $j < count( $dirs ); $j++ ) {
				$char = $dirs[( $place + $j ) % count( $dirs )];
				$return = $this->pickImageDir( "$directory/$char", $levels - 1 );
				if ( $return ) {
					return $return;
				}
			}
			// Didn't find any images in this directory... empty?
			return false;
		} else {
			return $this->pickImageFromDir( $directory );
		}
	}

	public function pickImageFromDir( $directory ) {
		if ( !is_dir( $directory ) ) {
			return false;
		}
		$n = mt_rand( 0, $this->countFiles( $directory ) - 1 );
		$dir = opendir( $directory );

		$count = 0;

		$entry = readdir( $dir );
		$pick = false;
		while ( false !== $entry ) {
			$entry = readdir( $dir );
			if ( preg_match( '/^image_([0-9a-f]+)_([0-9a-f]+)\\.png$/', $entry, $matches ) ) {
				$size = getimagesize( "$directory/$entry" );
				$pick = [
					'salt' => $matches[1],
					'hash' => $matches[2],
					'width' => $size[0],
					'height' => $size[1],
					'viewed' => false,
				];
				if ( $count++ == $n ) {
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
	public function countFiles( $dirname ) {
		$dir = opendir( $dirname );
		$count = 0;
		while ( false !== ( $entry = readdir( $dir ) ) ) {
			if ( $entry != '.' && $entry != '..' ) {
				$count++;
			}
		}
		closedir( $dir );
		return $count;
	}

	public function showImage() {
		$error = null;

		\F::app()->wg->Out->disable();

		$info = $this->retrieveCaptcha();
		if ( $info ) {
			$info['viewed'] = wfTimestamp();
			$this->storeCaptcha( $info );

			$salt = $info['salt'];
			$hash = $info['hash'];
			$file = $this->imagePath( $salt, $hash );

			if ( file_exists( $file ) ) {
				global $IP;
				require_once "$IP/includes/StreamFile.php";
				header( "Cache-Control: private, s-maxage=0, max-age=3600" );
				wfStreamFile( $file );
				return true;
			} else {
				$error = 'File ' . $file . ' does not exist';
			}
		} else {
			$error = 'Info is empty';
		}
		wfHttpError( 404, '404 not found', 'Requested non-existing captcha image' );
		$this->log( __METHOD__ . ' : Captcha returned 404: ' . $error );

		return false;
	}

	/**
	 * @param $salt
	 * @param $hash
	 *
	 * @return string
	 */
	public function imagePath( $salt, $hash ) {
		$wg = \F::app()->wg;

		$file = $wg->CaptchaDirectory;
		$file .= DIRECTORY_SEPARATOR;

		for ( $i = 0; $i < $wg->CaptchaDirectoryLevels; $i++ ) {
			$file .= $hash { $i } ;
			$file .= DIRECTORY_SEPARATOR;
		}
		$file .= "image_{$salt}_{$hash}.png";
		return $file;
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param string $action Action being performed
	 *
	 * @return string
	 */
	public function getMessage( $action ) {
		// Possible keys for easy grepping:
		// fancycaptcha-edit, fancycaptcha-addurl, fancycaptcha-createaccount, fancycaptcha-create
		return $this->getModuleMessage( 'fancycaptcha', $action );
	}

	/**
	 * Delete a solved captcha image, if $wgCaptchaDeleteOnSolve is true.
	 *
	 * @return bool
	 */
	public function passCaptcha() {
		$info = $this->retrieveCaptcha(); // get the captcha info before it gets deleted
		$pass = parent::passCaptcha();

		if ( $pass && \F::app()->wg->CaptchaDeleteOnSolve ) {
			$filename = $this->imagePath( $info['salt'], $info['hash'] );
			if ( file_exists( $filename ) ) {
				unlink( $filename );
			}
		}

		return $pass;
	}
}
