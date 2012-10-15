<?php
/**
 * DataTransclusion Source implementation
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 * Implementations of DataTransclusionSource, fetching data records via HTTP,
 * from the OpenLibrary RESTful API.
 *
 * This class provides all necessary $spec options per default. However, some
 * may be specifically useful to override:
 *
 *	 * $spec['url']: use an alternative URL to access the API. The default is
 *		http://openlibrary.org/api/books?bibkeys=ISBN:{isbn}&details=true
 *	 * $spec['httpOptions']: array of options to pass to Http::get. 
 *		For details, see Http::request.
 *	 * $spec['timeout']: seconds before the request times out. If not given,
 *		$spec['httpOptions']['timeout'] is used. If both are not givern, 
 *		5 seconds are assumed.
 *
 * Note that unless $spec['transformer'] is set, OpenLibrarySource will use
 * an OpenLibraryRecordTransformer for processing results.
 *
 * For more information on options supported by DataTransclusionSource and 
 * WebDataTransclusionSource, see the class-level documentation there.
 */
class OpenLibrarySource extends WebDataTransclusionSource {

	function __construct( $spec ) {
		if ( !isset( $spec['url'] ) ) {
			$spec['url'] = 'http://openlibrary.org/api/books?bibkeys=ISBN:{isbn}&details=true';
			//TODO: custom function to normalize ISBN (trim, strip dashes, correct checksum, etc)
			//       <^demon> Daniel_WMDE: I believe Special:BookSources has an ISBN normalization thing. Might be worth looking at.
		}

		if ( !isset( $spec['dataFormat'] ) ) {
			$spec['dataFormat'] = 'json';
		}

		if ( !isset( $spec['errorPath'] ) ) {
			$spec['errorPath'] = '?';
		}

		if ( !isset( $spec['keyFields'] ) ) {
			$spec['keyFields'] = 'isbn';
		}

		if ( !isset( $spec['fieldNames'] ) ) {
			$spec['fieldNames'] = array(
				'author',
				'date',
				'publisher',
				'title',
				'url',
				'city',
				'edition',
				'ISBN10',
				'ISBN13',
				'LCC',
				'LCCN',
				'DDC',
				'pages',
				'series',
				'subtitle',
				'language',
				'editor',
			);
		}

		if ( !isset( $spec['sourceInfo'] ) ) {
			$spec['sourceInfo'] = array();
		}

		if ( !isset( $spec['transformer'] ) ) {
			$spec['transformer'] = new OpenLibraryRecordTransformer( array() );
		}

		if ( !isset( $spec['sourceInfo']['description'] ) ) {
			$spec['sourceInfo']['description'] = 'The Open Library Project';
		}

		if ( !isset( $spec['sourceInfo']['homepage'] ) ) {
			$spec['sourceInfo']['homepage'] = 'http://openlibrary.org';
		}

		if ( !isset( $spec['sourceInfo']['license'] ) ) {
			$spec['sourceInfo']['license'] = 'PD';
		}

		WebDataTransclusionSource::__construct( $spec );
	}

}
