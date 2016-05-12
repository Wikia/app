<?php

/**
 * Nirvana Framework - Global registry class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 *
 *
 * @property AuthPlugin Auth
 * @property AuthPlugin auth
 * @property User $User
 * @property User $user
 * @property OutputPage $Out
 * @property OutputPage $out
 * @property Title $Title
 * @property Title $title
 * @property WebRequest $Request
 * @property WebRequest $request
 * @property WebResponse $Response
 * @property WebResponse $response
 * @property MemcachedPhpBagOStuff Memc
 * @property MemcachedPhpBagOStuff memc
 * @property Language Lang
 * @property Language ContLang
 * @property String ArticlePath
 * @property Boolean DevelEnvironment
 * @property Parser Parser
 * @property int CityId
 * @property string ExternalDatawareDB
 */
class WikiaGlobalRegistry extends WikiaRegistry {
	/* mapping for MW 1.19+ compatibility, new code should use RequestContext instances to access those globals */
	private static $requestContextMap = array(
		'wgUser' => 'User',
		'wgRequest' => 'Request',
		'wgOut' => 'Output',
		'wgLang' => 'Language',
		'wgTitle' => 'Title'
	);

	public function get($propertyName) {
		// body of this method is also copied/inlined in WikiaGlobalRegistry::__get()
		// don't forget to update it as well if you modify this one
		$this->validatePropertyName($propertyName);
		if( isset($GLOBALS[$propertyName]) )
			return $GLOBALS[$propertyName];
		return null;
	}

	public function append($propertyName, $value, $key = null) {
		$this->validatePropertyName($propertyName);
		if(is_null($key)) {
			$GLOBALS[$propertyName][] = $value;
		}
		else {
			$GLOBALS[$propertyName][$key][] = $value;
		}

		return $this;
	}

	public function set($propertyName, $value, $key = null) {
		$this->validatePropertyName($propertyName);
		if (is_null($key)) {
			//set both in RequestContext main instance and in globals to ensure values are in sync
			if ( $this->checkPropertyMapping( $propertyName ) ) {
				$this->processPropertyMapping( $propertyName, true, $value );
			}

			$GLOBALS[$propertyName] = $value;
		} else {
			$GLOBALS[$propertyName][$key] = $value;
		}
		return $this;
	}

	public function remove($propertyName) {
		$this->validatePropertyName($propertyName);

		//set both in RequestContext main instance and in globals to ensure values are in sync
		if ( $this->checkPropertyMapping( $propertyName ) ) {
			$this->processPropertyMapping( $propertyName, true, null );
		}

		unset($GLOBALS[$propertyName]);

		return $this;
	}

	public function has($propertyName) {
		$this->validatePropertyName($propertyName);
		//check both in globals and RequestContext's values
		return isset($GLOBALS[$propertyName]) || $this->checkPropertyMapping( $propertyName );
	}

	public function __get($propertyName) {
		// @author: wladek
		// inlines WikiaGlobalRegistry::get() and WikiaRegistry::validatePropertyName()
		// make sure the changes are made in both places
		$propertyName = 'wg' . ucfirst($propertyName);
		if ( empty( $propertyName ) || is_numeric( $propertyName ) ) {
			throw new WikiaException( "WikiaProperty - invalid or empty property name ({$propertyName})" );
		}
		if( isset($GLOBALS[$propertyName]) )
			return $GLOBALS[$propertyName];
		return null;
//		return $this->get( 'wg' . ucfirst($propertyName) );
	}

	public function __set($propertyName, $value) {
		$this->set( ( 'wg' . ucfirst($propertyName) ), $value );
	}

	public function __isset( $propertyName ) {
		return $this->has( 'wg' . ucfirst($propertyName) );
	}

	public function __unset( $propertyName ) {
		return $this->remove( 'wg' . ucfirst($propertyName) );
	}

	private function checkPropertyMapping( $propertyName ) {
		return array_key_exists( $propertyName, self::$requestContextMap );
	}

	//set or get value in main RequestContext instance to keep values in sync
	private function processPropertyMapping( $propertyName, $setValue = false, $value = null ) {
		$setValue = !empty( $setValue );
		$res = call_user_func(
			array(
				RequestContext::getMain(),
				( ( $setValue ) ? 'set' : 'get' ) . self::$requestContextMap[$propertyName]
			),
			$value
		);

		if ( !$setValue ) {
			return $res;
		}
		return null;
	}

}
