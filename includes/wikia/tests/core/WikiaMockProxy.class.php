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
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
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
		return $this->get( array(
			'type' => self::CLASS_CONSTRUCTOR,
			'className' => $className,
		), array(
			'functionName' => '__construct',
		) );
	}

	/**
	 * Get a handler for static method/constructor
	 *
	 * @param $className string Class Name
	 * @param $methodName string Method name
	 * @return WikiaMockProxyAction
	 */
	public function getStaticMethod( $className, $methodName ) {
		// PLATFORM-280 - make sure a static method is mocked
		if (!is_callable("{$className}::{$methodName}")) {
			throw new WikiaException("Only static methods can be mocked via WikiaBaseTest::mockClass - got {$className}::{$methodName}");
		}

		return $this->get( array(
			'type' => self::STATIC_METHOD,
			'className' => $className,
			'methodName' => $methodName
		) );
	}

	/**
	 * Get a handler for regular method
	 *
	 * @param $className string Class Name
	 * @param $methodName string Method name
	 * @return WikiaMockProxyAction
	 */
	public function getMethod( $className, $methodName ) {
		return $this->get( array(
			'type' => self::DYNAMIC_METHOD,
			'className' => $className,
			'functionName' => $methodName
		) );
	}

	/**
	 * Get a handler for global function
	 *
	 * @param $functionName string Function name
	 * @return WikiaMockProxyAction
	 */
	public function getGlobalFunction( $functionName ) {
		return $this->get( array(
			'type' => self::GLOBAL_FUNCTION,
			'functionName' => $functionName
		) );
	}

	/**
	 * Get a handler for given event
	 *
	 * @param $type string Event type
	 * @param $params mixed Event params
	 * @return WikiaMockProxyAction
	 */
	protected function get( $baseData, $extraData = array() ) {
		$type = $baseData['type'];
		$id = implode('|',$baseData);

		if ( empty( $this->mocks[$type][$id] ) ) {
			$action = new WikiaMockProxyAction($type,$id,$this,
				array_merge( $baseData, $extraData ));
			// no need to update state of this action here because all actions start as inactive
			// action sends notification when it's being configured
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

	/**
	 * (internal use only)
	 *
	 * @param WikiaMockProxyAction $action
	 */
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
					$flags = RUNKIT_ACC_PUBLIC | ( $type == self::STATIC_METHOD ? RUNKIT_ACC_STATIC : 0);
					runkit_method_rename( $className, $methodName, $savedName);  // save the original method
					runkit_method_add($className, $methodName, '', $this->getExecuteCallCode($type,$id, $type === self::DYNAMIC_METHOD), $flags );
				} else { // diable
					runkit_method_remove($className, $methodName);  // remove the redefined instance
					runkit_method_rename($className, $savedName, $methodName); // restore the original
				}
				break;
			case self::GLOBAL_FUNCTION:
				$functionName = $parts[1];
				list($namespace,$baseName) = self::parseGlobalFunctionName($functionName);
				$functionName = $namespace . $baseName;
				$savedName = $namespace . self::SAVED_PREFIX . $baseName;
				if ( $state ) { // enable
					$tempName = "WikiaMockProxyTempFuncName"; // workaround for namespaces functions
					runkit_function_rename($functionName, $savedName);
					runkit_function_add($tempName, '', $this->getExecuteCallCode($type,$id));
					runkit_function_rename($tempName,$functionName);
				} else { // disable
					runkit_function_remove($functionName);  // remove the redefined instance
					runkit_function_rename($savedName, $functionName); // restore the original
				}
				break;
		}
	}

	protected function getExecuteCallCode( $type, $id, $passThis = false ) {
		$replace = array( '\'' => '\\\'', '\\' => '\\\\' );
		$type = strtr($type,$replace);
		$id = strtr($id,$replace);

		$passThisCode = $passThis ? ',$this' : '';
		return "return WikiaMockProxy::\$instance->execute('{$type}','{$id}',func_get_args(){$passThisCode});";
	}

	public static function parseGlobalFunctionName( $functionName ) {
		$last = strrpos($functionName,'\\');
		if ( $last === false ) {
			return [ '', $functionName ];
		} else {
			return [ ltrim( substr( $functionName, 0, $last + 1 ), '\\' ), substr( $functionName, $last + 1 ) ];
		}
	}

	/**
	 * (internal use only)
	 * Execute the specified action
	 *
	 * @param $type string Event type
	 * @param $id string Event ID
	 * @param $args array Arguments
	 * @return mixed Return value
	 * @throws Exception
	 */
	public function execute( $type, $id, $args, $context = null ) {
		if ( !isset($this->mocks[$type][$id]) ) {
			throw new Exception("WikiaMockProxy did not find action definition for: \"{$type}/{$id}\"");
		}

		/** @var $action WikiaMockProxyAction */
		$action = $this->mocks[$type][$id][self::PROP_ACTION];
		return $action->execute($args,$context);
	}

	public function callOriginalGlobalFunction( $functionName, $args ) {
		$invocationOptions = array(
			'functionName' => $functionName,
			'arguments' => $args,
		);
		return (new WikiaMockProxyInvocation($invocationOptions))->callOriginal();
	}

	public function callOriginalMethod( $object, $functionName, $args ) {
		$invocationOptions = array(
			'object' => $object,
			'functionName' => $functionName,
			'arguments' => $args,
		);
		return (new WikiaMockProxyInvocation($invocationOptions))->callOriginal();
	}

	public function callOriginalStaticMethod( $className, $functionName, $args ) {
		$invocationOptions = array(
			'className' => $className,
			'functionName' => $functionName,
			'arguments' => $args,
		);
		return (new WikiaMockProxyInvocation($invocationOptions))->callOriginal();
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

		# TODO: remove when PHP7 migration is completed (PLATFORM-2138)
		if (function_exists(('set_new_overload'))) {
			set_new_overload('WikiaMockProxy::overload');
		}

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

		# TODO: remove when PHP7 migration is completed (PLATFORM-2138)
		if (function_exists(('unset_new_overload'))) {
			unset_new_overload();
		}

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
