<?php

namespace SMW\Scribunto;

use SMWQueryProcessor as QueryProcessor;
use SMWQuery as Query;
use SMW\Store;
use SMW\ApplicationFactory;
use SMW\ParameterProcessorFactory;
use Parser;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class LibraryFactory {

	/**
	 *@var Store
	 */
	private $store;

	/**
	 * @since 1.0
	 *
	 * @param Store $store
	 */
	public function __construct( Store $store ) {
		$this->store = $store;
	}

	/**
	 * Creates a new SMWQueryResult from passed arguments,
	 * utilizing the {@see SMWQueryProcessor}
	 *
	 * @since 1.0
	 *
	 * @param array $rawParameters
	 *
	 * @return \SMWQueryResult
	 */
	public function newQueryResultFrom( $rawParameters ) {

		list( $queryString, $parameters, $printouts ) = QueryProcessor::getComponentsFromFunctionParams(
			$rawParameters,
			false
		);

		QueryProcessor::addThisPrintout( $printouts, $parameters );

		$query = QueryProcessor::createQuery(
			$queryString,
			QueryProcessor::getProcessedParams( $parameters, $printouts ),
			QueryProcessor::SPECIAL_PAGE,
			'',
			$printouts
		);

		if ( defined( 'SMWQuery::PROC_CONTEXT' ) ) {
			$query->setOption( Query::PROC_CONTEXT, 'SSC.LibraryFactory' );
		}

		return $this->store->getQueryResult( $query );
	}

	/**
	 * @since 1.0
	 *
	 * @param \SMWQueryResult|string $queryResult
	 *
	 * @return LuaAskResultProcessor
	 */
	public function newLuaAskResultProcessor( $queryResult ) {
		return new LuaAskResultProcessor( $queryResult );
	}

	/**
	 * Creates a new ParserParameterProcessor from passed arguments
	 *
	 * @since 1.0
	 *
	 * @param array $arguments
	 *
	 * @return \SMW\ParserParameterProcessor
	 */
	public function newParserParameterProcessorFrom( $arguments ) {
		return ParameterProcessorFactory::newFromArray( $arguments );
	}

	/**
	 * Creates a new SetParserFunction utilizing a Parser
	 *
	 * @since 1.0
	 *
	 * @param Parser $parser
	 *
	 * @return \SMW\SetParserFunction
	 */
	public function newSetParserFunction( Parser $parser ) {
		return ApplicationFactory::getInstance()->newParserFunctionFactory( $parser )->newSetParserFunction( $parser );
	}

	/**
	 * Creates a new SubobjectParserFunction utilizing a Parser
	 *
	 * @since 1.0
	 *
	 * @param Parser $parser
	 *
	 * @return \SMW\SubobjectParserFunction
	 */
	public function newSubobjectParserFunction( Parser $parser ) {
		return ApplicationFactory::getInstance()->newParserFunctionFactory( $parser )->newSubobjectParserFunction( $parser );
	}
}
