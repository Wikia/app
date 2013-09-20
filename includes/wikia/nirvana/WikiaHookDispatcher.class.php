<?php

/**
 * Nirvana Framework - Hook dispatcher
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaHookDispatcher {

	private $hookHandlers = array();

	private function generateHookId( $className, $methodName ) {
		return "HOOK__{$className}__{$methodName}__" . count($this->hookHandlers);
	}

	/**
	 * registers new hook callback
	 *
	 * @param string $className
	 * @param string $methodName
	 * @param array $options
	 * @param bool $alwaysRebuild
	 * @param mixed $object
	 */
	public function registerHook( $className, $methodName, Array $options = array(), $alwaysRebuild = false, $object = null ) {
		$hookId = $this->generateHookId( $className, $methodName );

		$this->hookHandlers[$hookId] = array();

		$this->hookHandlers[$hookId] = array(
			'class' => $className,
			'method' => $methodName,
			'options' => $options,
			'rebuild' => $alwaysRebuild,
			'object' => $object
		);

		return array( $this, $hookId );
	}

	public function __call( $method, $args ) {
		if ( empty( $this->hookHandlers[$method] ) ) {
			throw new WikiaException( "Unknown hook handler: {$method}" );
		}

		if ( $this->hookHandlers[$method]['rebuild'] ) {
			$class = $this->hookHandlers[$method]['class'];
			$handler = new $class;
		} else {
			if ( !is_object( $this->hookHandlers[$method]['object'] ) ) {
				$class = $this->hookHandlers[$method]['class'];
				$this->hookHandlers[$method]['object'] = new $class;
			}
			$handler = $this->hookHandlers[$method]['object'];
		}

		return call_user_func_array( array( $handler, $this->hookHandlers[$method]['method'] ), $args );
	}

}