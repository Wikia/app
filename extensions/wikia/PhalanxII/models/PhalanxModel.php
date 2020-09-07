<?php

/**
 * @method PhalanxModel setBlock( PhalanxBlockInfo $block )
 * @method PhalanxBlockInfo getBlock
 * @method PhalanxModel setText( string $text )
 * @method getText
 * @method PhalanxModel setShouldLogInStats( bool $shouldLogInStats )
 * @method bool getShouldLogInStats
 * @method User getUser
 * @method PhalanxModel setUser( User $user )
 * @method PhalanxModel setService( PhalanxService $service )
 */
abstract class PhalanxModel extends WikiaObject {
	/** @var string $text */
	protected $text = null;

	/** @var null|PhalanxBlockInfo $block Information about the current block that was triggered */
	protected $block = null;

	/* @var User */
	protected $user = null;

	/* @var PhalanxService */
	private $service = null;
	protected $ip = null;

	protected $shouldLogInStats = true;

	public function __construct() {
		parent::__construct();

		$this->user = $this->wg->user;
		$this->service = PhalanxServiceFactory::getServiceInstance();
		$this->ip = $this->wg->request->getIp();
	}

	/**
	 * Determines the Phalanx block type from a piece of content that
	 * was not passed in with a specified type.
	 *
	 * @param $content string|Title|User content to guess type for
	 * @return int
	 */
	public static function determineTypeId( $content ) {
		// Allow extensions to pass in unspecified content types to
		// eliminate dependence on Phalanx from other extensions;
		// Phalanx is not enabled on the internal wiki and causes
		// extensions with a dependency on it to fail hard (500 errors)
		// See CE-377
		// default to TYPE_CONTENT
		$typeId = Phalanx::TYPE_CONTENT;
		if ( $content instanceof Title ) {
			$typeId = Phalanx::TYPE_TITLE;
		} else if ( $content instanceof User ) {
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
	public static function newFromType( $typeId, $content ) {
		$instance = null;

		switch( $typeId ) {
			case Phalanx:: TYPE_TITLE:
				$title = ( $content instanceof Title ) ? $content : Title::newFromText( $content );
				$instance = new PhalanxContentModel( $title );
				break;

			case Phalanx:: TYPE_SUMMARY:
			case Phalanx:: TYPE_CONTENT:
			case Phalanx:: TYPE_WIKI_CREATION:
			case Phalanx:: TYPE_EMAIL:
				$instance = new PhalanxTextModel( $content );
				break;

			case Phalanx:: TYPE_USER:
				$user = ( $content instanceof User ) ? $content : User::newFromName( $content );
				$instance = new PhalanxUserModel( $user );
				break;
		}

		return $instance;
	}

	/**
	 * Skip calls to Phalanx service if this method returns true
	 * We must skip check if and only if:
	 * - user has 'phalanxexempt' right (staff/SOAP/helper)
	 * - this is an internal request (except if it's looking up different user, e.g. user-permissions service)
	 *
	 * @return bool whether to skip call to Phalanx service
	 */
	public function isOk(): bool {
		global $wgUser;

		return (
			// SUS-1522: Permit user-permissions service to look up Phalanx blocks for different users
			( $this->isWikiaInternalRequest() && $this->user->equals( $wgUser ) ) ||
			$this->user->isAllowed( 'phalanxexempt' )
		);
	}

	public function __call( $name, $args ) {
		$method = substr( $name, 0, 3 );
		$key = lcfirst( substr( $name, 3 ) );

		$result = null;
		switch( $method ) {
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

	/**
	 * Perform a match request against Phalanx with the given content and type
	 * @param $type
	 * @return bool true if content is valid, false if it triggers some filter
	 */
	public function match( $type ) {
		if ( $this->isOk() ) {
			return true;
		}

		$phalanxMatchParams = PhalanxMatchParams::withGlobalDefaults()
			->content( $this->getText() )
			->type( $type );

		if ( $this->getShouldLogInStats() && $this->user instanceof User ) {
			$phalanxMatchParams->userName( $this->user->getName() );

			if ( $this->user->isLoggedIn() ) {
				$phalanxMatchParams->userId( $this->user->getId() );
			}
		}

		try {
			$phalanxBlockList = $this->service->doMatch( $phalanxMatchParams );
			$this->block = array_shift( $phalanxBlockList );

			return empty( $this->block );
		} catch ( PhalanxServiceException $phalanxServiceException ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Phalanx service failed' );
			return true;
		}
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
