<?php

namespace Captcha\Module;

/**
 * Class FancyCaptcha
 *
 * @package Captcha\Module
 */
class FancyCaptcha extends BaseCaptcha {

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
		global $wgCaptchaS3Bucket;

		return $this->pickImageFromS3( $wgCaptchaS3Bucket );
	}

	/**
	 * @param string $bucket
	 * @return array|bool
	 */
	private function pickImageFromS3( $bucket ) {
		$objects = self::getCaptchaObjects( $bucket );

		// get a random file from the bucket
		$n = mt_rand( 0, count( $objects ) - 1 );
		$entry = $objects[$n];

		// get image metadata
		$s3 = self::getS3Client();
		$tempFile = tempnam( wfTempDir(), 'captcha' );
		$s3->getObject( $bucket, $entry, $tempFile );

		$size = getimagesize( $tempFile );
		unlink( $tempFile );

		preg_match( '/image_([0-9a-f]+)_([0-9a-f]+)\\.png$/', $entry, $matches );

		$pick = [
			'salt' => $matches[1],
			'hash' => $matches[2],
			'width' => $size[0],
			'height' => $size[1],
			'viewed' => false,
		];

		return $pick;
	}

	/**
	 * Get the list of available captcha images from S3 storage.
	 *
	 * Cache the list in memcache
	 *
	 * @param string $bucket
	 * @return string[]
	 */
	private static function getCaptchaObjects( $bucket) {
		return \WikiaDataAccess::cache(
			wfSharedMemcKey( __METHOD__ . $bucket ),
			\WikiaResponse::CACHE_STANDARD,
			function() use ( $bucket ) {
				$s3 = self::getS3Client();
				return array_keys( $s3->getBucket( $bucket ) );
			}
		);
	}

	/**
	 * Get PHP client to access S3 storage
	 *
	 * @return \S3
	 */
	private static function getS3Client() {
		global $wgAWSAccessKey, $wgAWSSecretKey;

		$s3 = new \S3( $wgAWSAccessKey, $wgAWSSecretKey );
		\S3::setExceptions( true );

		return $s3;
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
		$name = 'captcha-recaptcha-' . $action;
		$text = wfMessage( $name )->escaped();
		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMessage( 'captcha-recaptcha-edit' )->escaped() : $text;
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
