<?php

/**
 * @method setBlock
 * @method getBlock
 * @method setText
 * @method getText
 * @method getLang
 * @method setShouldLogInStats
 * @method getShouldLogInStats
 */
abstract class PhalanxModel extends WikiaObject {
	public $model = null;
	public $text = null;
	public $block = null;
	public $lang = null;
	/* @var User */
	public $user = null;
	/* @var PhalanxService */
	private $service = null;
	public $ip = null;

	protected $shouldLogInStats = true;

	public function __construct( $model, $data = array() ) {
		parent::__construct();
		$this->model = $model;

		$this->user = $this->wg->user;
		if ( !empty( $data ) ) {
			foreach ( $data as $key => $value ) {
				$method = "set{$key}";
				$this->$method( $value );
			}
		}
		$this->service = new PhalanxService();
		$this->ip = $this->wg->request->getIp();
	}

	/**
	 * Determines the Phalanx block type from a piece of content that
	 * was not passed in with a specified type.
	 *
	 * @param $content string|Title|User content to guess type for
	 * @return int
	 */
	public static function determineTypeId($content) {
		// Allow extensions to pass in unspecified content types to
		// eliminate dependence on Phalanx from other extensions;
		// Phalanx is not enabled on the internal wiki and causes
		// extensions with a dependency on it to fail hard (500 errors)
		// See CE-377
		// default to TYPE_CONTENT
		$typeId = Phalanx::TYPE_CONTENT;
		if ($content instanceof Title) {
			$typeId = Phalanx::TYPE_TITLE;
		} else if ($content instanceof User) {
			$typeId = Phalanx::TYPE_USER;
		}

		return $typeId;
	}

	/**
	 * Returns instence of a proper PhalanxModel based on provided block type (Phalanx::TYPE_*)
	 *
	 * @param $typeId int type ID
	 * @param $content string|Title|User content to check (text, title, user name, ...)
	 * @return PhalanxModel|null
	 */
	public static function newFromType($typeId, $content) {
		$instance = null;

		switch($typeId) {
			case Phalanx:: TYPE_TITLE:
				$title = ($content instanceof Title) ? $content : Title::newFromText($content);
				$instance = new PhalanxContentModel($title);
				break;

			case Phalanx:: TYPE_SUMMARY:
			case Phalanx:: TYPE_CONTENT:
			case Phalanx:: TYPE_ANSWERS_QUESTION_TITLE:
			case Phalanx:: TYPE_ANSWERS_RECENT_QUESTIONS:
			case Phalanx:: TYPE_WIKI_CREATION:
			case Phalanx:: TYPE_EMAIL:
				$instance = new PhalanxTextModel($content);
				break;

			case Phalanx:: TYPE_USER:
				$user = ($content instanceof User) ? $content : User::newFromName($content);
				$instance = new PhalanxUserModel($user);
				break;
		}

		return $instance;
	}

	/**
	 * Skip calls to Phalanx service if this method returns true
	 *
	 * @return bool
	 */
	public function isOk() {
		return (
			( ( $this->user instanceof User ) && ( $this->user->getName() == $this->wg->User->getName() && $this->wg->User->isAllowed( 'phalanxexempt' ) ) ) ||
			( ( $this->user instanceof User ) && $this->user->isAllowed( 'phalanxexempt' ) ) ||
			$this->isWikiaInternalRequest()
		);
	}

	public function __call($name, $args) {
		$method = substr($name, 0, 3);
		$key = lcfirst( substr( $name, 3 ) );

		$result = null;
		switch($method) {
			case 'get':
				if ( isset( $this->$key ) ) {
					$result = $this->$key;
				}
				break;
			case 'set':
				$this->$key = $args[0];
				$result = $this;
				break;
		}
		return $result;
	}

	protected function fallback( $method, $type ) {
		$fallback = "{$method}_{$type}_old";
		$ret = false;
		if ( method_exists( $this, $fallback ) ) {
			Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [
				'method' => $method,
				'exception' => new Exception( 'Phalanx fallback triggered' )
			] );

			$ret = call_user_func( array( $this, $fallback ) );
		}
		return $ret;
	}

	public function logBlock() {
		$txt = $this->getText();
		wfDebug( __METHOD__ . ":". __LINE__. ": Block '#{$this->block->id}' blocked '{" . ( ( is_array( $txt ) ) ? implode(",", $txt) : $txt ) . "}'.\n", true );
	}

	public function match( $type, $method = 'logBlock' ) {
		$ret = true;

		if ( !$this->isOk() ) {
			$content = $this->getText();

			# send request to service
			$result = $this->service
				->setLimit(1)
				->setUser( ( $this->getShouldLogInStats() && $this->user instanceof User ) ? $this->user : null )
				->match( $type, $content, $this->getLang() );

			if ( $result !== false ) {
				# we have response from Phalanx service - check block
				if ( is_object( $result ) && isset( $result->id ) && $result->id > 0 ) {
					$this->setBlock( $result )->$method();
					$ret = false;
				}
			} else {
				$ret = $this->fallback( "match", $type );
			}
		}

		return $ret;
	}

	public function check( $type ) {
		# send request to service
		$result = $this->service->check( $type, $this->getText(), $this->getLang() );

		if ( $result !== false ) {
			# we have response from Phalanx service - 0/1
			$ret = $result;
		} else {
			$ret = $this->fallback( "check", $type );
		}

		return $ret;
	}

	/**
	 * Check if the current request is an internal one (has the required header and is a GET)
	 *
	 * @see PLATFORM-1473
	 *
	 * @return bool
	 */
	public function isWikiaInternalRequest() {
		$request = $this->wg->Request;
		return !$request->wasPosted() && $request->isWikiaInternalRequest();
	}
}
