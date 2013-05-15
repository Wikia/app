<?php

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

	public function __construct( $eventType, $eventId, $parent ) {
		$this->eventType = $eventType;
		$this->eventId = $eventId;
		$this->parent = $parent;
	}

	public function getEventType() {
		return $this->eventType;
	}

	public function getEventId() {
		return $this->eventId;
	}

	public function isActive() {
		return $this->action != self::ACTION_DISABLED;
	}

	public function willReturn( $value ) {
		$this->action = self::ACTION_RETURN;
		$this->data = $value;
		$this->parent->notify($this);
	}

	public function willCall( callable $callback ) {
		$this->action = self::ACTION_CALL;
		$this->data = $callback;
		$this->parent->notify($this);
	}

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

