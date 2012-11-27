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

	public $_mockClassName = null;
	public static $instances = array();
	public static $instance = null;  // temporary holder for instance reference during construction

	// proxy takes the name of the class and the mock object classname and the mock object instance
	// We store a reference by both original class name "Foo" and mocked class name "Mock_Foo_1234asdf" for convenience
	static public function proxy($className, $mockClassName, $mockInstance) {
		self::$instances[$className] = $mockInstance;
		self::$instances[$mockClassName] = $mockInstance;
	}

	// Because overload is called _immediately_ before the __construct function
	// we can use a static instance to hold the instance of whatever class we are overloading
	// We have to do this because overload returns a string with the class name and not an object (grr)
	static public function overload($className) {

		if (array_key_exists($className, self::$instances)) {
			self::$instance = self::$instances[ $className ];
			return 'WikiaMockProxy';
		} else {
			return $className;
		}

	}

	// If something calls new on a MockProxy object, we return our mock object instance
	// The instance var is stored by overload()
	// Before returning, we store a "pointer" to our original class type so that __call can find it
	public function __construct() {
		$this->_mockClassName = get_class(self::$instance);
		return self::$instance;
	}

	// PHP thinks that it is dealing with a MockProxy object, which has no useful functions
	// So we have to map all function calls back to the original class/method
	public function __call($name, $arguments) {
		$class = new ReflectionClass($this->_mockClassName);
		if (method_exists($this->_mockClassName, $name)) {
			$mockObject = self::$instances[$this->_mockClassName];
			return call_user_func_array(array($mockObject, $name), $arguments);
		} else {
			return null;
		}
	}
}
