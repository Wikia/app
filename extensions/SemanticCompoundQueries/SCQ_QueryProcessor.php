<?php

/**
 * Class that holds static functions for handling compound queries.
 * This class inherits from Semantic MediaWiki's SMWQueryProcessor.
 *
 * @ingroup SemanticCompoundQueries
 * 
 * @author Yaron Koren
 */
class SCQQueryProcessor extends SMWQueryProcessor {

	/**
	 * Comparison helper function, used in sorting results.
	 */
	public static function compareQueryResults( $a, $b ) {
		if ( $a->getDBKey() == $b->getDBKey() ) {
			return 0;
		}
		return ( $a->getDBKey() < $b->getDBKey() ) ? -1 : 1;
	}

	/**
	 * Handler for the #compound_query parser function.
	 * 
	 * @param Parser $parser
	 * 
	 * @return string
	 */
	public static function doCompoundQuery( Parser &$parser ) {
		global $smwgQEnabled, $smwgIQRunningNumber;

		if ( !$smwgQEnabled ) {
			return smwfEncodeMessages( array( wfMsgForContent( 'smw_iq_disabled' ) ) );
		}

		$smwgIQRunningNumber++;

		$params = func_get_args();
		array_shift( $params ); // We already know the $parser.

		$other_params = array();
		$results = array();
		$printRequests = array();
		$queryParams = array();

		foreach ( $params as $param ) {
			// Very primitive heuristic - if the parameter
			// includes a square bracket, then it's a
			// sub-query; otherwise it's a regular parameter.
			if ( strpos( $param, '[' ) !== false ) {
				$queryParams[] = $param;
			} else {
				$parts = explode( '=', $param, 2 );

				if ( count( $parts ) >= 2 ) {
					$other_params[strtolower( trim( $parts[0] ) )] = $parts[1]; // don't trim here, some params care for " "
				}
			}
		}

		foreach ( $queryParams as $param ) {
			$subQueryParams = self::getSubParams( $param );

			if ( array_key_exists( 'format', $other_params ) && !array_key_exists( 'format', $subQueryParams ) ) {
				$subQueryParams['format'] = $other_params['format'];
			}

			$next_result = self::getQueryResultFromFunctionParams(
				$subQueryParams,
				SMW_OUTPUT_WIKI
			);

			$results = self::mergeSMWQueryResults( $results, $next_result->getResults() );
			$printRequests = self::mergeSMWPrintRequests( $printRequests, $next_result->getPrintRequests() );
		}

		// Sort results so that they'll show up by page name
		uasort( $results, array( 'SCQQueryProcessor', 'compareQueryResults' ) );

		$query_result = new SCQQueryResult( $printRequests, new SMWQuery(), $results, smwfGetStore() );

		if ( version_compare( SMW_VERSION, '1.6.1', '>' ) ) {
			SMWQueryProcessor::addThisPrintout( $printRequests, $other_params );
			$other_params = parent::getProcessedParams( $other_params, $printRequests );
		}

		return self::getResultFromQueryResult(
			$query_result,
			$other_params,
			SMW_OUTPUT_WIKI
		);
	}

	/**
	 * An alternative to explode() - that function won't work here,
	 * because we don't want to split the string on all semicolons, just
	 * the ones that aren't contained within square brackets
	 * 
	 * @param string $param
	 * 
	 * @return array
	 */
	protected static function getSubParams( $param ) {
		$sub_params = array();
		$sub_param = '';
		$uncompleted_square_brackets = 0;

		for ( $i = 0; $i < strlen( $param ); $i++ ) {
			$c = $param[$i];

			if ( ( $c == ';' ) && ( $uncompleted_square_brackets <= 0 ) ) {
				$sub_params[] = trim( $sub_param );
				$sub_param = '';
			} else {
				$sub_param .= $c;

				if ( $c == '[' ) {
					$uncompleted_square_brackets++;
				}

				elseif ( $c == ']' ) {
					$uncompleted_square_brackets--;
				}
			}
		}

		$sub_params[] = trim( $sub_param );

		return $sub_params;
	}

	/**
	 * @param $rawparams
	 * @param $outputmode
	 * @param $context
	 * @param $showmode
	 * 
	 * @return SMWQueryResult
	 */
	protected static function getQueryResultFromFunctionParams( $rawparams, $outputmode, $context = SMWQueryProcessor::INLINE_QUERY, $showmode = false ) {
		$printouts = null;
		self::processFunctionParams( $rawparams, $querystring, $params, $printouts, $showmode );
		return self::getQueryResultFromQueryString( $querystring, $params, $printouts, SMW_OUTPUT_WIKI, $context );
	}

	/**
	 * Combine two arrays of SMWWikiPageValue objects into one
	 * 
	 * @param array $result1
	 * @param array $result2
	 * 
	 * @return array
	 */
	protected static function mergeSMWQueryResults( $result1, $result2 ) {
		if ( $result1 == null ) {
			return $result2;
		}

		$existing_page_names = array();
		foreach ( $result1 as $r1 ) {
			$existing_page_names[] = $r1->getDBkey();
		}

		foreach ( $result2 as $r2 ) {
			$page_name = $r2->getDBkey();
			if ( ! in_array( $page_name, $existing_page_names ) ) {
				$result1[] = $r2;
			}
		}

		return $result1;
	}

	protected static function mergeSMWPrintRequests( $printRequests1, $printRequests2 ) {
		$existingPrintoutLabels = array();
		foreach ( $printRequests1 as $p1 ) {
			$existingPrintoutLabels[] = $p1->getLabel();
		}

		foreach ( $printRequests2 as $p2 ) {
			$label = $p2->getLabel();
			if ( ! in_array( $label, $existingPrintoutLabels ) ) {
				$printRequests1[] = $p2;
			}
		}
		return $printRequests1;
	}

	/**
	 * @param $querystring
	 * @param array $params
	 * @param $extraprintouts
	 * @param $outputmode
	 * @param $context
	 * 
	 * @return SMWQueryResult
	 */
	protected static function getQueryResultFromQueryString( $querystring, array $params, $extraprintouts, $outputmode, $context = SMWQueryProcessor::INLINE_QUERY ) {
		wfProfileIn( 'SCQQueryProcessor::getQueryResultFromQueryString' );

		if ( version_compare( SMW_VERSION, '1.6.1', '>' ) ) {
			SMWQueryProcessor::addThisPrintout( $extraprintouts, $params );
			$params = self::getProcessedParams( $params, $extraprintouts, false );
		}

		$query = self::createQuery( $querystring, $params, $context, null, $extraprintouts );
		$query_result = smwfGetStore()->getQueryResult( $query );

		foreach ( $query_result->getResults() as $wiki_page ) {
			$wiki_page->display_options = $params;
		}

		wfProfileOut( 'SCQQueryProcessor::getQueryResultFromQueryString' );

		return $query_result;
	}

	/**
	 * Matches getResultFromQueryResult() from SMWQueryProcessor,
	 * except that formats of type 'debug' and 'count' aren't handled.
	 * 
	 * @param SCQQueryResult $res
	 * @param array $params These need to be the result of a list fed to getProcessedParams as of SMW 1.6.2
	 * @param $outputmode
	 * @param $context
	 * @param string $format
	 * 
	 * @return string
	 */
	protected static function getResultFromQueryResult( SCQQueryResult $res, array $params, $outputmode, $context = SMWQueryProcessor::INLINE_QUERY, $format = '' ) {
		wfProfileIn( 'SCQQueryProcessor::getResultFromQueryResult' );

		if ( version_compare( SMW_VERSION, '1.6.1', '>' ) ) {
			$format = $params['format'];
		} else {
			$format = self::getResultFormat( $params );
		}

		$printer = self::getResultPrinter( $format, $context, $res );
		$result = $printer->getResult( $res, $params, $outputmode );

		wfProfileOut( 'SCQQueryProcessor::getResultFromQueryResult' );

		return $result;
	}

}
