<?php

/**
 * MockProxy class to encapsulate the runkit functionality that allows us to override static constructors
 *
 * It manages the construction of objects and function mapping from a generic MockProxy wrapper to the specific Mock object we are using
 *
 * _mockClassName is used by __call to figure out what the original class is because get_class() and get_called_class() dont have it
 * $instances is an array of class name -> mock instance mappings
 *   Title => Mock_Title (String=>object)
 *   Mock_Title_2e631b09 => Mock_Title (String=>object)
 */

class WikiaMockProxy {

	const CLASS_CONSTRUCTOR = 'constructor';
	const STATIC_METHOD = 'static_method';
	const DYNAMIC_METHOD = 'dynamic_method';
	const GLOBAL_FUNCTION = 'global_function';

	const PROP_STATE = 'state';
	const PROP_ACTION = 'action';

	const SAVED_PREFIX = '_saved_';

	/**
	 * Active WikiaMockProxy instance
	 *
	 * @var WikiaMockProxy
	 */
	public static $instance;

	protected $enabled = false;

	protected $mocks = array();

	/**
	 * Get a handler for class constructor
	 *
	 * @param $className string Class name
	 * @return WikiaMockProxyAction
	 */
	public function getClassConstructor( $className ) {
		return $this->get( self::CLASS_CONSTRUCTOR, $className );
	}

	/**
	 * Get a handler for static method/constructor
	 *
	 * @param $className string Class Name
	 * @param $methodName string Method name
	 * @return WikiaMockProxyAction
	 */
	public function getStaticMethod( $className, $methodName ) {
		return $this->get( self::STATIC_METHOD, $className, $methodName );
	}

	/**
	 * Get a handler for regular method
	 *
	 * @param $className string Class Name
	 * @param $methodName string Method name
	 * @return WikiaMockProxyAction
	 */
	public function getMethod( $className, $methodName ) {
		return $this->get( self::DYNAMIC_METHOD, $className, $methodName );
	}

	/**
	 * Get a handler for global function
	 *
	 * @param $functionName string Function name
	 * @return WikiaMockProxyAction
	 */
	public function getGlobalFunction( $functionName ) {
		return $this->get( self::GLOBAL_FUNCTION, $functionName );
	}

	/**
	 * Get a handler for given event
	 *
	 * @param $type string Event type
	 * @param $params mixed Event params
	 * @return WikiaMockProxyAction
	 */
	protected function get( $type, $params = null ) {
		$id = implode('|',func_get_args());

		if ( empty( $this->mocks[$type][$id] ) ) {
			$action = new WikiaMockProxyAction($type,$id,$this);
			$this->mocks[$type][$id] = array(
				self::PROP_STATE => false,
				self::PROP_ACTION => $action,
			);
		}
		return $this->mocks[$type][$id][self::PROP_ACTION];
	}

	protected function retrieve( $type, $params = null ) {
		$id = implode('|',func_get_args());

		if ( !isset( $this->mocks[$type][$id] ) ) {
			return false;
		}

		return $this->mocks[$type][$id][self::PROP_ACTION];
	}

	public function notify( WikiaMockProxyAction $action ) {
		$type = $action->getEventType();
		$id = $action->getEventId();
		$currentState = $this->mocks[$type][$id][self::PROP_STATE];
		$desiredState = $this->enabled && $action->isActive();

		if ( $currentState != $desiredState ) {
			$this->updateState($type,$id,$desiredState);
			$this->mocks[$type][$id][self::PROP_STATE] = $desiredState;
		}
	}

	protected function updateState( $type, $id, $state ) {
		$parts = explode('|',$id);
		switch ($type) {
			case self::STATIC_METHOD:
			case self::DYNAMIC_METHOD:
				$className = $parts[1];
				$methodName = $parts[2];
				$savedName = self::SAVED_PREFIX . $methodName;
				if ( $state ) { // enable
					is_callable( "{$className}::{$methodName}" );
					$flags = RUNKIT_ACC_PUBLIC | ( $type == self::DYNAMIC_METHOD ? RUNKIT_ACC_STATIC : 0);
					runkit_method_rename( $className, $methodName, $savedName);  // save the original method
					runkit_method_add($className, $methodName, '', $this->getExecuteCall($type,$id), $flags );
				} else { // diable
					runkit_method_remove($className, $methodName);  // remove the redefined instance
					runkit_method_rename($className, $savedName, $methodName); // restore the original
				}
				break;
			case self::GLOBAL_FUNCTION:
				$functionName = $parts[1];
				$savedName = self::SAVED_PREFIX . $functionName;
				if ( $state ) { // enable
					runkit_function_rename($functionName, $savedName);
					runkit_function_add($functionName, '', $this->getExecuteCall($type,$id));
				} else { // disable
					runkit_function_remove($functionName);  // remove the redefined instance
					runkit_function_rename($savedName, $functionName); // restore the original
				}
				break;
		}
	}

	protected function getExecuteCall( $type, $id ) {
		$replace = array( '\'' => '\\\'', '\\' => '\\\\' );
		$type = strtr($type,$replace);
		$id = strtr($id,$replace);

		return "return WikiaMockProxy::\$instance->execute('{$type}','{$id}',func_get_args());";
	}

	public function execute( $type, $id, $args ) {
		if ( !isset($this->mocks[$type][$id]) ) {
			throw new Exception("WikiaMockProxy did not find action definition for: \"{$type}/{$id}\"");
		}

		/** @var $action WikiaMockProxyAction */
		$action = $this->mocks[$type][$id][self::PROP_ACTION];
		return $action->execute($args);
	}

	public function callOriginalGlobalFunction( $functionName, $args ) {
		$savedName = self::SAVED_PREFIX . $functionName;
		$functionToCall = is_callable( $savedName ) ? $savedName : $functionName;
		return call_user_func_array( $functionToCall, $args );
	}

	public function enable() {
		if ( !empty( self::$instance ) ) {
			if ( self::$instance == $this ) {
				return;
			}
			throw new Exception("Another WikiaMockProxy is already enabled");
		}

		// enable this instance
		self::$instance = $this;
		$this->enabled = true;
		set_new_overload('WikiaMockProxy::overload');
		foreach ($this->mocks as $list1) {
			foreach ($list1 as $type => $mock) {
				$this->notify($mock[self::PROP_ACTION]);
			}
		}
	}

	public function disable() {
		if ( self::$instance != $this ) {
			if ( self::$instance == null ) {
				return;
			}
			throw new Exception("Another WikiaMockProxy is enabled now");
		}

		// disable this instance
		$this->enabled = false;
		unset_new_overload();
		foreach ($this->mocks as $list1) {
			foreach ($list1 as $type => $mock) {
				$this->notify($mock[self::PROP_ACTION]);
			}
		}
		self::$instance = null;
	}

	// Because overload is called _immediately_ before the __construct function
	// we can use a static instance to hold the instance of whatever class we are overloading
	// We have to do this because overload returns a string with the class name and not an object (grr)
	static public function overload($className) {
		/** @var $action WikiaMockProxyAction */
		if ( self::$instance
			&& ($action = self::$instance->retrieve(self::CLASS_CONSTRUCTOR,$className) )
			&& $action->isActive()
		) {
			$type = $action->getEventType();
			$id = $action->getEventId();
			try {
				$value = self::$instance->execute($type,$id,array());
			} catch (Exception $e) {
				echo "WikiaMockProxy::overload: caught exception: {$e->getMessage()}\n";
				echo $e->getTraceAsString();
				echo "\n";
				$value = $className;
			}
			return $value;
		}
		return $className;
	}

}
