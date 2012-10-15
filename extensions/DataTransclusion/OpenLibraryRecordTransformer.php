<?php
/**
 * Record transformer for the OpenLibrary API
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
 * Implementations of RecordTransformer for processing data from the OpenLibrary web API.
 * No configuration options are needed.
 */
class OpenLibraryRecordTransformer extends RecordTransformer {

	/**
	 * Initializes the RecordTransformer from the given parameter array.
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		RecordTransformer::__construct( $spec );
	}

	public function transform( $rec ) {
		$r = array();

		$r['date'] = @$rec['details']['publish_date']; //TODO: split into year/month/day

		$r['title'] = $rec['details']['title'];
		if ( @$rec['details']['title_prefix'] ) {
			$r['title'] = trim( $rec['details']['title_prefix'] ) 
					. ' ' . trim( $r['title'] );
		}

		$r['url'] = $rec['info_url'];

		$r['pages'] = @$rec['details']['number_of_pages'];
		$r['edition'] = @$rec['details']['edition_name'];

		$r['publisher'] = "";
		if ( isset( $rec['details']['publishers'] ) ) {
			foreach ( $rec['details']['publishers'] as $publisher ) {
				if ( $r['publisher'] != "" ) $r['publisher'] .= '; ';
				$r['publisher'] .= $publisher;
			}
		}

		$r['author'] = "";
		if ( isset( $rec['details']['authors'] ) ) {
			foreach ( $rec['details']['authors'] as $author ) {
				if ( $r['author'] != "" ) $r['author'] .= ', ';

				if ( $author['key'] != "/authors/OL2693863A" ) { //"Journal" is not a real author.
					$r['author'] .= $author['name'];
				}
			}
		}

		$r['editor'] = "";
		if ( isset( $rec['details']['editors'] ) ) {
			foreach ( $rec['details']['editors'] as $editor ) {
				if ( $r['editor'] != "" ) $r['editor'] .= ', ';
				$r['editor'] .= $editor;
			}
		}

		if ( empty( $r['author'] ) && empty( $r['editor'] ) ) {
			if ( isset( $rec['details']['by_statement'] ) ) {
				$r['author'] = $rec['details']['by_statement']; //XXX ugly...
			}
		}

		$r['city'] = "";
		if ( isset( $rec['details']['publish_places'] ) ) {
			foreach ( $rec['details']['publish_places'] as $place ) {
				if ( $r['city'] != "" ) $r['city'] .= '/';
				$r['city'] .= $place;
			}
		}

		$r['LCC'] = "";
		if ( isset( $rec['details']['lc_classifications'] ) ) {
			foreach ( $rec['details']['lc_classifications'] as $place ) {
				if ( $r['LCC'] != "" ) $r['LCC'] .= ' / ';
				$r['LCC'] .= $place;
			}
		}

		$r['DDC'] = "";
		if ( isset( $rec['details']['dewey_decimal_class'] ) ) {
			$r['DDC'] .= $rec['details']['dewey_decimal_class'][ 0 ];
		}
	      
		$r['LCCN'] = "";
		if ( isset( $rec['details']['lccn'] ) ) {
			$r['LCCN'] .= $rec['details']['lccn'][ 0 ];
		}
	      
		$r['ISBN10'] = "";
		if ( isset( $rec['details']['isbn_10'] ) ) {
			$r['ISBN10'] .= $rec['details']['isbn_10'][ 0 ];
		}
	      
		$r['ISBN13'] = "";
		if ( isset( $rec['details']['isbn_13'] ) ) {
			$r['ISBN13'] .= $rec['details']['isbn_13'][ 0 ];
		}
	      
		$r['series'] = "";
		if ( isset( $rec['details']['series'] ) ) {
			$r['series'] .= $rec['details']['series'][ 0 ];
		}
	      
		$r['language'] = "";
		if ( isset( $rec['details']['languages'] ) ) {
			$r['language'] .= $rec['details']['languages'][ 0 ][ 'key' ];
			$r['language'] = preg_replace( '!^.*/!', '', $r['language'] );
		}
	      
		return $r;
	}

	public function extractError( $data ) {
		if ( !$this->extractRecord( $data ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function extractRecord( $data ) {
		$data = array_values( $data );

		$rec = $data[0];
		return $rec;
	}

}

