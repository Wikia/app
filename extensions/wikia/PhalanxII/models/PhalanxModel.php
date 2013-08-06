<?php

/**
 * @method setBlock
 * @method getBlock
 * @method setText
 * @method getText
 * @method getLang
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

	public function __construct( $model, $data = array() ) {
		parent::__construct();
		$this->model = $model;
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

	public function isOk() {
		return (
			( ( $this->user instanceof User ) && ( $this->user->getName() == $this->wg->User->getName() && $this->wg->User->isAllowed( 'phalanxexempt' ) ) ) ||
			( ( $this->user instanceof User ) && $this->user->isAllowed( 'phalanxexempt' ) )
		);
	}

	public function __call($name, $args) {
		$method = substr($name, 0, 3);
		$key = strtolower( substr( $name, 3 ) );

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
			Wikia::log( __METHOD__, __LINE__, "Call method from previous version of Phalanx - check Phalanx service!\n" );
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
			$isUser = ($this->user instanceof User) && ( $this->user->getName() == $this->wg->User->getName() );

			$content = $this->getText();

			# send request to service
			$result = $this->service
				->setLimit(1)
				->setUser( $isUser ? $this->user : null )
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
}
