<?php
/**
 * Class definition for Wikia\Search\ProfiledClassFactory
 */
namespace Wikia\Search;
use Reflection, ReflectionClass, ReflectionMethod, ReflectionParameter;
/**
 * A class responsible for creating classes decorated with profiling info
 * @author relwell
 */
class ProfiledClassFactory
{
	/**
	 * Associative array storing class names to the dynamically-generated class definition.
	 * @var array
	 */
	static protected $classDefs = [];
	
	/**
	 * If profiled, creates a class with a "Profiled" suffix after the terminal classname.
	 * These all inherit from parent classes, with decorator wrappers for profiling information.
	 * Examples would include Wikia\Search\MediaWikiServiceProfiled and \ApiServiceProfiled.
	 * @param string $className
	 * @param array $instanceArgs
	 * @param bool $profiled
	 * @return object
	 */
	public function get( $className, array $instanceArgs = array() ) {
		global $wgProfiler;
		if ( empty( $wgProfiler ) ) {
			$refl = new ReflectionClass( $className );
			return $refl->newInstanceArgs( $instanceArgs );
		} else {
			$namespaces = explode( '\\', $className );
			$terminal = array_pop( $namespaces );
			array_push( $namespaces, $terminal.'Profiled' );
			$profiledClassName = implode( '\\', $namespaces ); 
			if (! class_exists( $profiledClassName ) ) {
				$this->declareProfiledClass( $className );
			}
			$refl = new ReflectionClass( $profiledClassName );
			return $refl->newInstanceArgs( $instanceArgs );
		}
	}
	
	/**
	 * Responsible for creating the eval text for our decorated child class, and running it.
	 * @param string $className
	 */
	protected function declareProfiledClass( $className ) {
		$namespaces = explode( '\\', $className );
		$terminal = array_pop( $namespaces );
		$nsString = implode( '\\', $namespaces );
		$classDef = <<<STOP
namespace {$nsString};
class {$terminal}Profiled extends {$terminal}
{
STOP;
		
		$parentRefl = new ReflectionClass( $nsString . '\\' . $terminal );
		$methods = $parentRefl->getMethods();
		foreach ( $methods as $method ) {
			if ( $method->isFinal() || $method->isPrivate() ) {
				continue;
			}
			$paramSigs = [];
			$modifierNames = implode( ' ', Reflection::getModifierNames( $method->getModifiers() ) );
			foreach ( $method->getParameters() as $parameter ) {
				$class = $parameter->getClass();
				if ( empty( $class ) ) {
					if ( $parameter->isArray() ) {
						$class = 'array';
					}
				}
				$default = '';
				if ( $parameter->isDefaultValueAvailable() ) {
					$defaultValue = $parameter->getDefaultValue();
					if ( is_array( $defaultValue ) ) {
						$default = '[ "' . implode( '", "', $defaultValue ) . '" ]';
					} else {
						$default = $parameter->getDefaultValue();
					}
				}
				$sig = trim( str_replace( '<optional>', '', preg_replace( '/^.*\[ (<required>)?([^\]]+) \]/', '$2', ReflectionParameter::export( array( $method->class, $method->name ), $parameter->getName(), true ) ) ) );
				
				if ( $sig[0] != '$' && $sig[0] != '\\' && substr_count( $sig, 'array', 0, 5 ) == 0 ) {
					$sig = '\\' . $sig;
				}
				if ( substr_count( $sig, '= Array' ) > 0 ) {
					$sig = str_replace( '= Array', ' = '.$default, $sig );
				}
				$paramSigs[] = $sig;
			}
			$paramSignature = implode( ', ', $paramSigs );
			
			$classDef .= <<<STOP

	{$modifierNames} function {$method->name}({$paramSignature}) {
			\\wfProfileIn( __METHOD__ );
			\$retVal = \\call_user_func_array( array( 'parent', '{$method->name}' ), \\func_get_args() ); 
			\\wfProfileOut( __METHOD__ );
			return \$retVal;
	}

STOP;
			
		}
		$classDef .= "\n}";
		eval( $classDef );
	}
}