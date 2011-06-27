<?php

/**
 * @file
 * @ingroup SMW
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * wikia settings which differ from default.
 */


switch( $wgCityId ) {

	// familypedia3/mysql
	case 233065:
		break;

	// familypedia2/allegrograph
	case 232959:
		$smwgDefaultStore = "SMWSparqlStore";
		$smwgSparqlQueryEndpoint = 'http://smw:smw@localhost:10035/repositories/smw';
		$smwgSparqlUpdateEndpoint = 'http://smw:smw@localhost:10035/repositories/smw';
		$smwgSparqlDataEndpoint = ''; // can be empty
		break;

	default:
		$smwgDefaultStore = "SMWSparqlStore";
		$smwgSparqlDatabase = 'SMWSparqlDatabase4Store';
		$smwgSparqlQueryEndpoint = 'http://localhost:9000/sparql/';
		$smwgSparqlUpdateEndpoint = 'http://localhost:9000/update/';
		$smwgSparqlDataEndpoint = 'http://localhost:9000/data/';
}

