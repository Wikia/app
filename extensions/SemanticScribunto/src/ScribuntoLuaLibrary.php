<?php

namespace SMW\Scribunto;

use Scribunto_LuaLibraryBase;
use SMW\DIProperty;
use SMW\ApplicationFactory;
use SMWQueryResult as QueryResult;
use SMWOutputs;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class ScribuntoLuaLibrary extends Scribunto_LuaLibraryBase {

	/**
	 * @var LibraryFactory
	 */
	private $libraryFactory;

	/**
	 * This is the name of the key for error messages
	 *
	 * @var string
	 * @since 1.0
	 */
	const SMW_ERROR_FIELD = 'error';

	/**
	 * @since 1.0
	 */
	public function register() {

		$lib = [
			'ask'             => [ $this, 'ask' ],
			'getPropertyType' => [ $this, 'getPropertyType' ],
			'getQueryResult'  => [ $this, 'getQueryResult' ],
			'info'            => [ $this, 'info' ],
			'set'             => [ $this, 'set' ],
			'subobject'       => [ $this, 'subobject' ],
		];

		$this->getEngine()->registerInterface( __DIR__ . '/' . 'mw.smw.lua', $lib, [] );
	}

	/**
	 * This mirrors the functionality of the parser function #ask and makes it
	 * available in lua.
	 *
	 * @since 1.0
	 *
	 * @param string|array $arguments parameters passed from lua, string or array depending on call
	 *
	 * @return array    array( null ) or array[]
	 */
	public function ask( $arguments = null ) {

		$queryResult = $this->getLibraryFactory()->newQueryResultFrom(
			$this->processLuaArguments( $arguments )
		);

		if ( !$this->isAQueryResult( $queryResult ) ) {
			return [ $queryResult ];
		}

		$luaResultProcessor = $this->getLibraryFactory()->newLuaAskResultProcessor(
			$queryResult
		);

		$result = $luaResultProcessor->getQueryResultAsTable();

		return [ $this->convertArrayToLuaTable( $result ) ];
	}

	/**
	 * Returns property type
	 *
	 * @since 1.0
	 *
	 * @param string $propertyName
	 *
	 * @return array
	 */
	public function getPropertyType( $propertyName = null ) {

		$this->checkType( 'getPropertyType', 1, $propertyName, 'string' );
		$propertyName = trim( $propertyName );

		if ( $propertyName === '' ) {
			return [ null ];
		}

		$property = DIProperty::newFromUserLabel( $propertyName );

		if ( $property === null ) {
			return [ null ];
		}

		return [ $property->findPropertyTypeID() ];
	}

	/**
	 * Returns query results in for of the standard API return format
	 *
	 * @since 1.0
	 *
	 * @param string|array $arguments
	 *
	 * @return array
	 */
	public function getQueryResult( $arguments = null ) {

		$queryResult = $this->getLibraryFactory()->newQueryResultFrom(
			$this->processLuaArguments( $arguments )
		);

		if ( !$this->isAQueryResult( $queryResult ) ) {
			return [ $queryResult ];
		}

		$result = $queryResult->toArray();

		if( !empty( $result["results"] ) ) {
			// as of now, "results" has page names as keys. lua is not very good, keeping non-number keys in order
			// so replace string keys with the corresponding number, starting with 0.
		    $result["results"] = array_combine( range( 0, count( $result["results"] ) - 1 ), array_values( $result["results"] ) );
		}

		return [ $this->convertArrayToLuaTable( $result ) ];
	}

	/**
	 * This mirrors the functionality of the parser function #info and makes it
	 * available to lua.
	 *
	 * @since 1.0
	 *
	 * @param string $text text to show inside the info popup
	 * @param string $icon identifier for the icon to use
	 *
	 * @return string[]
	 */
	public function info( $text, $icon = 'info' ) {

		// do some parameter processing
		if ( ! trim( $text ) || ! is_string( $text ) ) {
			// no info-text present, or wrong type. abort
			return null;
		}

		// check if icon is set and valid
		if ( !is_string( $icon ) || !in_array( $icon, [ 'note', 'warning' ] ) ) {
			$icon = 'info';
		}

		// the actual info message is easy to create:
		$result = smwfEncodeMessages(
			[ $text ],
			$icon,
			' <!--br-->',
			false // No escaping.
		);

		// to have all necessary data committed to output, use SMWOutputs::commitToParser()
		SMWOutputs::commitToParser(
			$this->getEngine()->getParser()
		);

		return [ $this->doPostProcessParserFunctionCallResult( $result ) ];
	}

	/**
	 * This mirrors the functionality of the parser function #set and makes it
	 * available in lua.
	 *
	 * @since 1.0
	 *
	 * @param string|array $arguments arguments passed from lua, string or array depending on call
	 *
	 * @return null|array|array[]
	 */
	public function set( $arguments ) {

		$arguments = $this->processLuaArguments( $arguments );

		$setParserFunction = $this->getLibraryFactory()->newSetParserFunction(
			$this->getEngine()->getParser()
		);

		$parserFunctionCallResult = $setParserFunction->parse(
			$this->getLibraryFactory()->newParserParameterProcessorFrom( $arguments )
		);

		// get usable result
		$result = $this->doPostProcessParserFunctionCallResult(
			$parserFunctionCallResult
		);

		if ( strlen( $result ) ) {
			// if result is a non empty string, assume an error message
			return [ [ 1 => false, self::SMW_ERROR_FIELD => preg_replace( '/<[^>]+>/', '', $result ) ] ];
		}

		// on success, return true
		return [ 1 => true ];
	}

	/**
	 * This mirrors the functionality of the parser function #subobject and
	 * makes it available to lua.
	 *
	 * @param string|array $arguments arguments passed from lua, string or array depending on call
	 * @param string $subobjectId if you need to manually assign an id, do this here
	 *
	 * @return null|array|array[]
	 */
	public function subobject( $arguments, $subobjectId = null ) {

		$arguments = $this->processLuaArguments( $arguments );

		// parameters[0] would be the subobject id, so unshift
		array_unshift( $arguments, null );

		// if subobject id was set, put it on position 0
		if ( !is_null( $subobjectId ) && $subobjectId ) {
			// user deliberately set an id for this subobject
			$arguments[0] = $subobjectId;

			// we need to ksort, otherwise ParameterProcessorFactory doesn't
			// recognize the id
			ksort( $arguments );
		}

		// prepare subobjectParserFunction object
		$subobjectParserFunction = $this->getLibraryFactory()->newSubobjectParserFunction(
			$this->getEngine()->getParser()
		);

		$parserFunctionCallResult = $subobjectParserFunction->parse(
			 $this->getLibraryFactory()->newParserParameterProcessorFrom( $arguments )
		);

		if ( strlen( $result = $this->doPostProcessParserFunctionCallResult( $parserFunctionCallResult ) ) ) {
			// if result a non empty string, assume an error message
			return [ [ 1 => false, self::SMW_ERROR_FIELD => preg_replace( '/<[^>]+>/', '', $result ) ] ];
		}

		// on success, return true
		return [ 1 => true ];
	}

	/**
	 * This takes an array and converts it so, that the result is a viable lua table.
	 * I.e. the resulting table has its numerical indices start with 1
	 * If `$ar` is not an array, it is simply returned
	 * @param mixed $ar
	 * @return mixed array
	 */
	private function convertArrayToLuaTable( $ar ) {

		if ( is_array( $ar) ) {
			foreach ( $ar as $key => $value ) {
				$ar[$key] = $this->convertArrayToLuaTable( $value );
			}
			array_unshift( $ar, '' );
			unset( $ar[0] );
		}
		return $ar;
	}

	/**
	 * Takes a result returned from a parser function call and prepares it to be
	 * used as parsed string.
	 *
	 * @since 1.0
	 *
	 * @param string|array $parserFunctionResult
	 *
	 * @return string
	 */
	private function doPostProcessParserFunctionCallResult( $parserFunctionResult ) {

		// parser function call can return string or array
		if ( is_array( $parserFunctionResult ) ) {
			$result = $parserFunctionResult[0];
			$noParse = isset( $parserFunctionResult['noparse'] ) ? $parserFunctionResult['noparse'] : true;
		} else {
			$result = $parserFunctionResult;
			$noParse = true;
		}

		if ( !$noParse ) {
			$result = $this->getEngine()->getParser()->recursiveTagParseFully( $result );
		}

		return trim( $result );
	}

	/**
	 * Returns the LibraryFactory singleton (and creates it first, if not already present)
	 *
	 * @since 1.0
	 *
	 * @return LibraryFactory
	 */
	private function getLibraryFactory() {

		if ( $this->libraryFactory !== null ) {
			return $this->libraryFactory;
		}

		$this->libraryFactory = new LibraryFactory(
			ApplicationFactory::getInstance()->getStore()
		);

		return $this->libraryFactory;
	}

	/**
	 * Tests, if supplied parameter `$queryResult` is a valid {@see QueryResult}
	 *
	 * @since 1.0
	 *
	 * @param mixed $queryResult
	 *
	 * @return bool
	 */
	private function isAQueryResult( $queryResult ) {
		return is_a( $queryResult, QueryResult::class );
	}

	/**
	 * Takes the $arguments passed from lua and pre-processes them: make sure,
	 * we have a sequence array (not associative)
	 *
	 * @since 1.0
	 *
	 * @param string|array $arguments
	 *
	 * @return array
	 */
	private function processLuaArguments( $arguments ) {

		// make sure, we have an array of parameters
		if ( !is_array( $arguments ) ) {
			$arguments = preg_split( "/(?<=[^\|])\|(?=[^\|])/", $arguments );
		}

		// if $arguments were supplied as key => value pair (aka associative array),
		// we rectify this here
		$processedArguments = [];
		foreach ( $arguments as $key => $value ) {
			if ( !is_int( $key ) && !preg_match( '/[0-9]+/', $key ) ) {
				$value = (string) $key . '=' . (string) $value;
			}
			$processedArguments[] = $value;
		}

		return $processedArguments;
	}

}
