<?php
namespace Wikia\Template;

/**
 * Base class for Wikia Template System.
 *
 * Simple usage
 * ------------
 * Rendering a single template requiring a few values:
 *
 * 	(new Wikia\Template\PHPEngine)
 * 		->setValues( [
 * 			'name' => 'John',
 * 			'nick' => 'GIJoe',
 * 			'email' => 'GIJoe@anotherplace.com'
 * 		] )
 * 		->render( dirname(__FILE__) . '/templates/hello.php' )
 *
 * Intermediate usage
 * ------------------
 * Using a single instance for rendering multiple templates
 * in the same folder, e.g. from different methods in a class:
 *
 * 	class A {
 * 		private $tplEngine;
 *
 * 		function __construct(){
 * 			//pay the instantiation fee only once
 * 			$this->tplEngine = (new Wikia\Template\PHPEngine)
 * 				->setPrefix( dirname(__FILE__) . '/templates' );
 * 		}
 *
 * 		function foo(){
 * 			//renders templates/foo.php
 * 			return $this->tplEngine
 * 				//optional, removes all the values set by another call
 * 				->clearValues()
 * 				->render( 'foo' );
 * 		}
 *
 * 		function bar(){
 * 			//renders templates/bar.php
 * 			return $this->tplEngine
 * 				//replaces the whole set of values, safe for reuse
 * 				->setValues( ['one' => 1, 'two' => 2] );
 * 				->render( 'bar' );
 * 		}
 * 	}
 *
 * Advanced usage
 * --------------
 * Using a single instance for rendering multiple templates
 * in the same folder with shared values:
 *
 * 	$family = [
 * 		['name' => 'Fred'   , 'birthdate' => '01/01/10000 BC'],
 * 		['name' => 'Wilma'  , 'birthdate' => '05/02/9994 BC' ],
 * 		['name' => 'Pebbles', 'birthdate' => '10/7/9963 BC'  ]
 * 	];
 *
 * 	//render the list of the Flinstones family members in Bedrock
 * 	$tplEngine = (new Wikia\Template\MustacheEngine)
 * 		->setPrefix( dirname(__FILE__) . '/templates' )
 * 		//shared values across render calls
 * 		->setValues( [
 * 			'familyName' => 'Flinstone',
 * 			'city' => 'Bedrock'
 * 		] );
 *
 * 	//use the shared values for the header of the list
 *
 * 	//templates/header.mustache:
 * 	//List of {{familyName}} inhabitants of {{city}}
 * 	$output = $tplEngine->render( 'header.mustache' );
 *
 * 	foreach ( $family as $member ) {
 * 		//templates/item.mustache:
 * 		//* {{name}} {{familyName}}, born in {{birthdate}}
 *
 * 		//add/update the values keeping those set previously
 * 		$output .= $tplEngine->updateValues(
 * 			['name' => $member['name], 'birthdate' => $member['birthdate']]
 * 		)->render( 'item.mustache' ) . "\n";
 * 	}
 *
 * @package Wikia\Template
 * @author Federico "Lox" Lucignano
 */
abstract class Engine {
	protected $values = [];
	protected $prefix = '';

	/**
	 * Renders the template as a string.
	 *
	 * @param string $template The name of the template, will be combined with
	 * the value passed to Engine::setPrefix().
	 * In case of FileSystem-based engines it should be the filename
	 * either alone (Engine::setPrefix()) or the full path, both need to
	 * include the file's extension.
	 *
	 * @return string The rendered template
	 */
	public abstract function render( $template );

	/**
	 * Checks if a template exists.
	 *
	 * @param string $template The name of the template, will be combined with
	 * the value passed to Engine::setPrefix().
	 * In case of FileSystem-based engines it should be the filename
	 * either alone (Engine::setPrefix()) or the full path, both need to
	 * include the file's extension.
	 *
	 * @return bool Wether the template was found or not
	 */
	public abstract function exists( $template );

	/**
	 * Sets the base path for this instance.
	 *
	 * @param string $prefix The prefix to append to the template
	 * name passed as a parameter to Engine::render(), e.g. the path
	 * to a folder containing template files for filesystem-based
	 * engines.
	 *
	 * @return Engine The current instance
	 */
	public function setPrefix ( $prefix ) {
		$this->prefix = (string) $prefix;
		return $this;
	}

	/**
	 * Returns the base path set for this instance.
	 *
	 * @return string|null
	 */
	public function getPrefix() {
		return $this->prefix;
	}

	/**
	 * Sets multiple values to be passed to a template at once.
	 *
	 * @param array $values The values to be passed to a template
	 * in the form of an associative array, i.e. [IDENTIFIER => VALUE]
	 *
	 * @return Engine The current instance
	 *
	 * @see Engine::setVal() if you need to set only one value
	 */
	public function setData( Array $values ) {
		$this->values = $values;
		return $this;
	}

	/**
	 * Add/overwrites multiple values in the collection of the current instance
	 * to be passed to a template.
	 *
	 * @param array $values The values to be added/updated in the form of an
	 * associative array, i.e. [IDENTIFIER => VALUE]
	 *
	 * @return Engine The current instance
	 *
	 * * @see Engine::setVal() if you need to add/overwrite only one value
	 */
	public function updateData( Array $values ) {
		wfProfileIn( __METHOD__ );

		$this->values = array_merge( $this->values, $values );

		wfProfileOut( __METHOD__ );
		return $this;
	}

	/**
	 * Empties the collection of values stored in an instance
	 *
	 * @return Engine The current instance
	 *
	 * @see Engine::clearVal() if you need to clear only one value
	 */
	public function clearData(){
		$this->values = [];
		return $this;
	}

	/**
	 * Returns the values set for this instance to be passed to a template.
	 *
	 * @return array The values set for this instance, null if the collection
	 * wasn't set
	 *
	 * @see Engine::getVal() if you need to get only one value
	 */
	public function getData() {
		return $this->values;
	}

	/**
	 * Sets/add a value in the collection to be passed to a template.
	 *
	 * @param string $name The name of the value
	 * @param mixed $value The real value
	 *
	 * @return Engine The current instance
	 *
	 * @see Engine::setData() if you need to set multiple values instead
	 * of calling this method multiple times
	 */
	public function setVal( $name, $value ) {
		$this->values[$name] = $value;
		return $this;
	}

	/**
	 * Removed a value from he collection to be passed to a template.
	 *
	 * @param string $name The name of the value
	 *
	 * @return Engine The current instance
	 *
	 * @see Engine::clearData() if you need to clear the whole collection
	 * instead of calling this method multiple times
	 */
	public function clearVal( $name ){
		unset( $this->values[$name] );
		return $this;
	}

	/**
	 * Returns a value in the collection to be passed to a template.
	 *
	 * @param string $name The name of the value
	 *
	 * @return mixed|null The current instance
	 *
	 * @see Engine::setData() if you need to get multiple values instead
	 * of calling this method multiple times
	 */
	public function getVal( $name ) {
		return isset($this->values[$name]) ? $this->values[$name]: null;
	}
}
