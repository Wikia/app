<?php

class WikiaHookDispatcher {

	private $hookHandlers = array();

	private function generateHookId($className, $methodName) {
		return 'HOOK__'.$className."__".$methodName."__" . count($this->hookHandlers);
	}

	public function registerHook($className, $methodName, array $options = array(), $alwaysRebuild = false) {
		$hookId = $this->generateHookId($className, $methodName);

		$this->hookHandlers[$hookId] = array();

		$this->hookHandlers[$hookId] = array(
			'class' => $className,
			'method' => $methodName,
			'options' => $options,
			'rebuild' => $alwaysRebuild,
			'object' => null
		);

		return array( $this, $hookId );
	}

	public function __call($method, $args) {
		if(empty($this->hookHandlers[$method])) {
			throw new WikiaException("Unknown hook handler: $method");
		}

		if($this->hookHandlers[$method]['rebuild']) {
			$handler = WF::build($this->hookHandlers[$method]['class']);
		} else {
			if(!is_object($this->hookHandlers[$method]['object'])) {
				$this->hookHandlers[$method]['object'] = WF::build($this->hookHandlers[$method]['class']);
			}
			$handler = $this->hookHandlers[$method]['object'];
		}

		return call_user_func_array( array( $handler, $this->hookHandlers[$method]['method'] ), $args );
	}

}