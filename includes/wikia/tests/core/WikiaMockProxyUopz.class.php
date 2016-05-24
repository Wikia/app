<?php

/**
 * This class acts as temporary layer that allows us to use both uopz (PHP 7) and php-test-helpers / runkit (PHP 5.6)
 *
 * TODO: move to the base class when PHP7 migration is completed (PLATFORM-2138)
 */
class WikiaMockProxyUopz extends  WikiaMockProxy {

	protected function updateState( $type, $id, $state ) {
		$parts = explode('|',$id);

		switch ($type) {
			case self::STATIC_METHOD:
			case self::DYNAMIC_METHOD:
				$className = $parts[1];
				$methodName = $parts[2];
				$savedName = self::SAVED_PREFIX . $methodName;
				if ( $state ) { // enable
					is_callable( "{$className}::{$methodName}" ); // make sure the class is loaded (via autoloader)
					uopz_set_return($className, $methodName, function() use ($type, $id) {
						return WikiaMockProxy::$instance->execute($type,$id,func_get_args(), $type === WikiaMockProxy::DYNAMIC_METHOD);
					}, true /* execute closure */);
				} else { // disable
					uopz_unset_return($className, $methodName);
				}
				break;
			case self::GLOBAL_FUNCTION:
				$functionName = $parts[1];
				list($namespace,$baseName) = self::parseGlobalFunctionName($functionName);
				$functionName = $namespace . $baseName;
				$savedName = $namespace . self::SAVED_PREFIX . $baseName;
				if ( $state ) { // enable
					uopz_set_return($functionName, function() use ($functionName) {
						return WikiaMockProxy::$instance->getGlobalFunction($functionName)->execute( func_get_args() );
					}, true);
				} else { // disable
					uopz_unset_return($functionName);
				}
				break;
			case self::CLASS_CONSTRUCTOR:
				$className = $parts[1];
				$newClass = self::$instance->execute($type,$id,array());

				if ( $state ) { // enable
					var_dump(__METHOD__ . " - {$className} [mock]");

					uopz_set_mock($className, $newClass);
				}
				else { //disable
					var_dump(__METHOD__ . " - {$className} - $id [remove mock]");

					uopz_unset_mock($className);
				}
		}
	}
}
