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

	/**
	 * Create a new Action object
	 *
	 * @param $eventType string Event type
	 * @param $eventId string Event ID
	 * @param $parent object Parent object that receives notifications when the action is enabled/disabled
	 */
	public function __construct( $eventType, $eventId, $parent ) {
		$this->eventType = $eventType;
		$this->eventId = $eventId;
		$this->parent = $parent;
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
	public function execute( $args ) {
		switch ($this->action) {
			case self::ACTION_RETURN:
				return $this->data;
				break;
			case self::ACTION_CALL:
				return call_user_func_array($this->data,$args);
				break;
			default:
				throw new Exception("WikiaMockProxyAction::execute: called under invalid circumstances");
		}
	}

}

