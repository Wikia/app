<?php

namespace Captcha\Module;

/**
 * Class FancyCaptcha
 *
 * @package Captcha\Module
 */
class FancyCaptcha extends BaseCaptcha {

	const DIRECTORY_LEVELS = 0;
	const CAPTCHA_LOADED_ID = 'wpCaptchaWord';
	const CAPTCHA_FIELD = 'wpCaptchaWord';

	public function checkCaptchaField() {
		return self::CAPTCHA_FIELD;
	}

	/**
	 * Check if the submitted form matches the captcha session data provided
	 * by the plugin when the form was generated.
	 *
	 * @param string $answer
	 * @param array $info
	 *
	 * @return bool
	 */
	public function keyMatch( $answer, $info ) {
		$digest = $this->wg->CaptchaSecret . $info['salt'] . $answer . $this->wg->CaptchaSecret . $info['salt'];
		$answerHash = substr( md5( $digest ), 0, 16 );

		if ( $answerHash == $info['hash'] ) {
			$this->log( "FancyCaptcha: answer hash matches expected {$info['hash']}\n" );
			return true;
		} else {
			$this->log( "FancyCaptcha: answer hashes to $answerHash, expected {$info['hash']}\n" );
			return false;
		}
	}

	/**
	 * @param array $resultArr
	 */
	public function addCaptchaAPI( &$resultArr ) {
		$info = $this->pickImage();
		if ( !$info ) {
			$resultArr['captcha']['error'] = 'Out of images';
			return;
		}
		$index = $this->storeCaptcha( $info );

		$resultArr['captcha']['type'] = 'fancyCaptcha';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['url'] = $this->getImageURL( $index );
	}

	/**
	 * @param int $index
	 *
	 * @return string
	 */
	public function getImageURL( $index ) {
		return $this->wg->Server . '/wikia.php?' . implode( '&', [
			'controller=Captcha',
			'method=showImage',
			'wpCaptchaId=' . urlencode( $index ),
		] );
	}

	/**
	 * Insert the captcha prompt into the edit form.
	 *
	 * @param string $class
	 *
	 * @return string
	 * @throws \MWException
	 */
	public function getForm( $class = null ) {
		$info = $this->pickImage();
		if ( !$info ) {
			throw new \MWException( "Ran out of captcha images" );
		}

		// Generate a random key for use of this captcha image in this session.
		// This is needed so multiple edits in separate tabs or windows can
		// go through without extra pain.
		$index = $this->storeCaptcha( $info );

		$this->log( "Captcha id $index using hash ${info['hash']}, salt ${info['salt']}.\n" );

		return "<div class='fancy-captcha'>" .
			\Xml::element( 'img', [
				'src'    => $this->getImageURL( $index ),
				'width'  => $info['width'],
				'height' => $info['height'],
				'alt'    => '',
			] ) .
			\Html::element( 'input', [
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'autocorrect' => 'off',
				'autocapitalize' => 'off',
				'required',
				'class' => $class,
				'placeholder' => wfMessage( 'captcha-input-placeholder' )->escaped(),
			] ) .
			\Xml::element( 'input', [
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index,
			] ) .
			\Xml::element( 'input', [
				'type'  => 'hidden',
				'name'  => 'wpCaptchaClass',
				'id'    => 'wpCaptchaClass',
				'value'    => '\Captcha\Module\FancyCaptcha',
			] ) .
			"</div>\n";
	}

	/**
	 * Select a previously generated captcha image from the queue.
	 * @fixme subject to race conditions if lots of files vanish
	 *
	 * @return mixed tuple of (salt key, text hash) or false if no image to find
	 */
	public function pickImage() {
		return $this->pickImageDir(
			$this->wg->CaptchaDirectory,
			self::DIRECTORY_LEVELS
		);
	}

	/**
	 * @param $directory
	 * @param $levels
	 *
	 * @return array|bool
	 */
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
				$imageDir = $this->pickImageDir( "$directory/$char", $levels - 1 );
				if ( $imageDir ) {
					return $imageDir;
				}
			}
			// Didn't find any images in this directory... empty?
			return false;
		} else {
			return $this->pickImageFromDir( $directory );
		}
	}

	/**
	 * @param string $directory
	 *
	 * @return array|bool
	 */
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
	 *
	 * @param string $dirName
	 *
	 * @return int
	 */
	public function countFiles( $dirName ) {
		$dir = opendir( $dirName );
		$count = 0;
		while ( false !== ( $entry = readdir( $dir ) ) ) {
			if ( $entry != '.' && $entry != '..' ) {
				$count++;
			}
		}
		closedir( $dir );
		return $count;
	}

	/**
	 * @return bool
	 *
	 * @throws \MWException
	 */
	public function showImage() {
		$error = null;

		$this->wg->Out->disable();

		$info = $this->retrieveCaptcha();
		if ( $info ) {
			$info['viewed'] = wfTimestamp();
			$this->storeCaptcha( $info );

			$salt = $info['salt'];
			$hash = $info['hash'];
			$file = $this->imagePath( $salt, $hash );

			if ( file_exists( $file ) ) {
				header( "Cache-Control: private, s-maxage=0, max-age=3600" );
				\StreamFile::stream( $file );
				return true;
			} else {
				$error = 'File ' . $file . ' does not exist';
			}
		} else {
			$error = 'Info is empty';
		}
		wfHttpError( 404, '404 not found', 'Requested non-existing captcha image' );
		$this->log( 'Captcha returned 404: ' . $error );

		return false;
	}

	/**
	 * @param $salt
	 * @param $hash
	 *
	 * @return string
	 */
	public function imagePath( $salt, $hash ) {
		$file = $this->wg->CaptchaDirectory;
		$file .= DIRECTORY_SEPARATOR;
		for ( $i = 0; $i < self::DIRECTORY_LEVELS; $i++ ) {
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
		// Possible keys for easy grepping: recaptcha-edit, recaptcha-addurl, recaptcha-createaccount, recaptcha-create
		// NOTE: we're using the same messages as reCaptcha. The reCaptcha messages are generic enough to work for both
		// reCaptcha and FancyCaptcha, and the old FancyCaptcha message included links to a deprecated Special:Captcha/Help page.
		$name = 'recaptcha-' . $action;
		$text = wfMessage( $name )->escaped();
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMessage( 'recaptcha-edit' )->escaped() : $text;
	}

	/**
	 * Determine if a captcha is correct. This will possibly delete the solved captcha image
	 * if wgCaptchaDeleteOnSolve is true
	 *
	 * @return bool
	 */
	public function passCaptcha() {
		$info = $this->retrieveCaptcha(); // get the captcha info before it gets deleted
		$pass = parent::passCaptcha();

		if ( $pass && $this->wg->CaptchaDeleteOnSolve ) {
			$filename = $this->imagePath( $info['salt'], $info['hash'] );
			if ( file_exists( $filename ) ) {
				unlink( $filename );
			}
		}

		return $pass;
	}
}
