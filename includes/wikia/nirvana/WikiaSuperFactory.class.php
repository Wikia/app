<?php

/**
 * Nirvana Framework - (Super)Factory class
 *
 * @ingroup nirvana
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */
abstract class WikiaSuperFactory {
	protected static $constructors = array();
	protected static $reflections = array();
	protected static $appInstance;

	/**
	 * add class constructor
	 * @param string $className class name
	 * @param array $params optional params to be set as defaults
	 * @param string $methodName factory method to call, leave default for "new" operator to be called
	 * @deprecated
	 */
	public static function addClassConstructor($className, Array $params = array(), $methodName = '__construct') {
		if(!isset(self::$constructors[$className])) {
			self::$constructors[$className] = array();
		}
		elseif(isset(self::$constructors[$className]['INSTANCE'])) {
			throw new WikiaException("WikiaFactory: Class $className has already defined instance by setInstance() call, unable to add constructor");
		}

		self::$constructors[$className][$methodName] = $params;
	}

	/**
	 * add predefined instance of given class (useful for mocks or singletons)
	 * @param string $className class name
	 * @param mixed $instance instance
	 * @deprecated
	 */
	public static function setInstance($className, $instance) {
		if ( $className == 'App' || $className == 'WikiaApp' ) {
			self::$appInstance = $instance;
		}
		if(!isset(self::$constructors[$className])) {
			self::$constructors[$className] = array();
		}

		self::$constructors[$className]['INSTANCE'] = $instance;
	}

	/**
	 * get predefined instance of given class (useful for mocks or singletons)
	 * @param string $className class name
	 * @deprecated
	 *
	 * @return JSMessages|mixed the class instance or null if one has not been registered
	 */
	public static function getInstance($className) {
		if(isset(self::$constructors[$className]) && array_key_exists('INSTANCE', self::$constructors[$className])) {
			return self::$constructors[$className]['INSTANCE'];
		}

		return null;
	}

	/**
	 * reset predefined instance of given class (if any)
	 * @param string $className
	 * @deprecated
	 */
	public static function unsetInstance($className) {
		if(isset(self::$constructors[$className]) && array_key_exists('INSTANCE', self::$constructors[$className])) {
			unset(self::$constructors[$className]['INSTANCE']);
		}
	}

	/**
	 * build object
	 * @param string $className class name
	 * @param array $params array of parameters for constructor or factory method ( param name => value )
	 * @param string $constructorMethod constructor or factory method to call
	 * @return JSMessages|JSSnippets|Title|User|Article|Category|AssetsManager|WikiaRequest|WikiaResponse|object|Wikia
	 */
	public static function build($className, Array $params = array(), $constructorMethod = '__construct') {
		if(isset(self::$constructors[$className]) && array_key_exists('INSTANCE', self::$constructors[$className])) {
			return self::$constructors[$className]['INSTANCE'];
		}

		if(($constructorMethod != '__construct') && !isset(self::$constructors[$className][$constructorMethod])) {
			try {
				$method = new ReflectionMethod($className, $constructorMethod);
			}
			catch(ReflectionException $e) {
				throw new WikiaException("WikiaFactory: Unknown constructor ($constructorMethod) for class: $className");
			}
			self::addClassConstructor($className, array(), $constructorMethod);
		}

		$object = null;
		$buildParams = $params;
		if(isset(self::$constructors[$className][$constructorMethod])) {
			$buildParams = array_merge(self::$constructors[$className][$constructorMethod], $params);
		}

		if($constructorMethod == '__construct') {
			if(empty(self::$reflections[$className])) {
				self::$reflections[$className] = new ReflectionClass($className);
			}
			if(!empty($buildParams)) {
				$object = self::$reflections[$className]->newInstanceArgs($buildParams);
			}
			else {
				$object = self::$reflections[$className]->newInstanceArgs();
			}
		}
		else {
			$object = call_user_func_array(array($className, $constructorMethod), $buildParams);
		}

		return $object;
	}

	/**
	 * reset factory configuration
	 * @param string $className class name (optional)
	 */
	public static function reset($className = null) {
		if(!empty($className)) {
			unset(self::$constructors[$className]);
		}
		else {
			// @codeCoverageIgnoreStart
			self::$constructors = array();
			// @codeCoverageIgnoreEnd
		}
	}

	/**
	 * get application object
	 * @return WikiaApp
	 */
	public static function app() {
		if (!isset(self::$appInstance)) {
			self::$appInstance = new WikiaApp();
		}
		return self::$appInstance;
	}
}

/**
 * WikiaFactory class alias
 * @author ADi
 *
 */
abstract class F extends WikiaSuperFactory { }

