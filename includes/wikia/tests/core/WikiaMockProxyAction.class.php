<?php

/**
 * WikiaMockProxyAction exposes a common interface for mocked functions, methods etc.
 * and is independent of what happens when the function gets called.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class WikiaMockProxyAction {

	const ACTION_DISABLED = 0;
	const ACTION_RETURN = 1;
	const ACTION_CALL = 2;

	protected $eventType;
	protected $eventId;
	/** @var WikiaMockProxy */
	protected $parent;

	protected $action = self::ACTION_DISABLED;
	protected $data;

	protected $invocationOptions = array();

	/**
	 * Create a new Action object
	 *
	 * @param $eventType string Event type
	 * @param $eventId string Event ID
	 * @param $parent object Parent object that receives notifications when the action is enabled/disabled
	 */
	public function __construct( $eventType, $eventId, $parent, $invocationOptions = array() ) {
		$this->eventType = $eventType;
		$this->eventId = $eventId;
		$this->parent = $parent;
		$this->invocationOptions = $invocationOptions;
	}

	/**
	 * Get an event type
	 *
	 * @return string
	 */
	public function getEventType() {
		return $this->eventType;
	}

	/**
	 * Get an event ID
	 * @return string
	 */
	public function getEventId() {
		return $this->eventId;
	}

	/**
	 * Check if this action is configured to do anything
	 *
	 * @return bool
	 */
	public function isActive() {
		return $this->action != self::ACTION_DISABLED;
	}

	/**
	 * Configure the action to always return a given value
	 *
	 * @param $value mixed Return value
	 */
	public function willReturn( $value ) {
		$this->action = self::ACTION_RETURN;
		$this->data = $value;
		$this->parent->notify($this);
	}

	/**
	 * Configure the action to always call a given callback whenever it's executed
	 *
	 * @param $callback callable Callback
	 */
	public function willCall( callable $callback ) {
		$this->action = self::ACTION_CALL;
		$this->data = $callback;
		$this->parent->notify($this);
	}

	/**
	 * Execute this action and return its value
	 *
	 * @param $args array Arguments
	 * @return mixed Return value
	 * @throws Exception
	 */
	public function execute( $args, $context = null ) {
		switch ($this->action) {
			case self::ACTION_RETURN:
				return $this->data;
				break;
			case self::ACTION_CALL:
				$invocationOptions = $this->invocationOptions;
				$invocationOptions['arguments'] = $args;
				if ( $context !== null ) {
					$invocationOptions['object'] = $context;
				}
				$invocation = new WikiaMockProxyInvocation($invocationOptions);
				self::pushInvocation($invocation);
				$result = call_user_func_array($this->data,$args);
				self::popInvocation($invocation);
				return $result;
				break;
			default:
				throw new Exception("WikiaMockProxyAction::execute: called under invalid circumstances");
		}
	}

	private static $invocationStack = array();

	private static function getRandomString( $length ) {
		$str = '';
		for( $i = 0; $i < $length; $i++ ) {
			$char = rand( 32, 127 );
			$str .= chr( $char );
		}
		return $str;
	}

	private static function pushInvocation( WikiaMockProxyInvocation $invocation ) {
		// sanity check
		if ( !empty( $invocation->uuid ) ) {
			Wikia::log(__METHOD__, false, "could not push invocation: " . (string)$invocation );
			throw new Exception("Could not push invocation which is already in the stack");
		}
		$invocation->uuid = array(
			'index' => count(self::$invocationStack),
			'uuid' => self::getRandomString(16),
		);
		array_push(self::$invocationStack,$invocation);
	}

	private static function popInvocation( WikiaMockProxyInvocation $invocation ) {
		if ( empty( $invocation->uuid) ) {
			return;
		}
		$stackInfo = $invocation->uuid;
		$index = $stackInfo['index'];
		// no match, something stupid happened
		if ( count(self::$invocationStack) <= $index || $stackInfo !== $invocation->uuid ) {
			// todo: log it
			Wikia::log(__METHOD__, false, "could not pop invocation: " . (string)$invocation );
			return;
		}
		self::$invocationStack = array_slice(self::$invocationStack,0,$index);
	}

	/**
	 * Return a currently executed mock invocation that's handled by WikiaMockProxy
	 *
	 * @return WikiaMockProxyInvocation
	 */
	public static function currentInvocation() {
		return end(self::$invocationStack);
	}

}

