<?php
/**
 * File holding the SolrConnectorStore class
 *
 * @ingroup SolrStore
 * @file
 * @author Simon Bachenberg, Stephan Gambke
 */

/**
 * TODO: Insert class description
 *
 * @ingroup SolrStore
 */
class SolrConnectorStore extends SMWStore {

	static protected $smBaseStore;

	/**
	 * Get a handle for the storage backend that is used to manage the data.
	 * Currently, it just returns one globally defined object, but the
	 * infrastructure allows to set up load balancing and task-dependent use of
	 * stores (e.g. using other stores for fast querying than for storing new
	 * facts), somewhat similar to MediaWiki's DB implementation.
	 *
	 * @return SMWStore
	 */
	static function &getBaseStore() {
		global $wgscBaseStore;

		if ( self::$smBaseStore === null ) {
			self::$smBaseStore = new $wgscBaseStore();
		}

		return self::$smBaseStore;
	}

//// / Reading methods /////

	/**
	 * Retrieve all data stored about the given subject and return it as a
	 * SMWSemanticData container. There are no options: it just returns all
	 * available data as shown in the page's Factbox.
	 * $filter is an array of strings that are datatype IDs. If given, the
	 * function will avoid any work that is not necessary if only
	 * properties of these types are of interest.
	 *
	 * @note There is no guarantee that the store does not retrieve more
	 * data than requested when a filter is used. Filtering just ensures
	 * that only necessary requests are made, i.e. it improves performance.
	 */
	public function getSemanticData( SMWDIWikiPage $subject, $filter = false ) {
		return self::getBaseStore()->getSemanticData( $subject, $filter );
	}

	/**
	 * Get an array of all property values stored for the given subject and
	 * property. The result is an array of SMWDataItem objects.
	 *
	 * If called with $subject == null, all values for the given property
	 * are returned.
	 *
	 * @param $subject mixed SMWDIWikiPage or null
	 * @param $property SMWDIProperty
	 * @param $requestoptions SMWRequestOptions
	 *
	 * @return array of SMWDataItem
	 */
	public function getPropertyValues( $subject, SMWDIProperty $property, $requestoptions = null ) {
		return self::getBaseStore()->getPropertyValues( $subject, $property, $requestoptions );
	}

	/**
	 * Get an array of all subjects that have the given value for the given
	 * property. The result is an array of SMWDIWikiPage objects. If null
	 * is given as a value, all subjects having that property are returned.
	 */
	public function getPropertySubjects( SMWDIProperty $property, $value, $requestoptions = null ) {
		return self::getBaseStore()->getPropertySubjects( $property, $value, $requestoptions );
	}

	/**
	 * Get an array of all subjects that have some value for the given
	 * property. The result is an array of SMWDIWikiPage objects.
	 */
	public function getAllPropertySubjects( SMWDIProperty $property, $requestoptions = null ) {
		return self::getBaseStore()->getAllPropertySubjects( $property, $requestoptions );
	}

	/**
	 * Get an array of all properties for which the given subject has some
	 * value. The result is an array of SMWDIProperty objects.
	 *
	 * @param $subject SMWDIWikiPage denoting the subject
	 * @param $requestoptions SMWRequestOptions optionally defining further options
	 */
	public function getProperties( SMWDIWikiPage $subject, $requestoptions = null ) {
		return self::getBaseStore()->getProperties( $subject, $requestoptions );
	}

	/**
	 * Get an array of all properties for which there is some subject that
	 * relates to the given value. The result is an array of SMWDIWikiPage
	 * objects.
	 * @note In some stores, this function might be implemented partially
	 * so that only values of type Page (_wpg) are supported.
	 */
	public function getInProperties( SMWDataItem $object, $requestoptions = null ) {
		return self::getBaseStore()->getInProperties( $object, $requestoptions );
	}

//// / Writing methods /////

	/**
	 * Delete all semantic properties that the given subject has. This
	 * includes relations, attributes, and special properties. This does
	 * not delete the respective text from the wiki, but only clears the
	 * stored data.
	 *
	 * @param Title $subject
	 */
	public function deleteSubject( Title $subject ) {
		global $wgSolrTalker;
		// TODO: Update Solr to reflect the deleting of semantic properties

		$wgSolrTalker->deleteDocId( $subject );
		return self::getBaseStore()->deleteSubject( $subject );
	}

	/**
	 * Update the semantic data stored for some individual. The data is
	 * given as a SMWSemanticData object, which contains all semantic data
	 * for one particular subject.
	 *
	 * @param SMWSemanticData $data
	 */
	public function doDataUpdate( SMWSemanticData $data ) {
		global $wgSolrTalker;
		$wgSolrTalker->parseSemanticData( $data );
		return self::getBaseStore()->doDataUpdate( $data );
	}

	/**
	 * Update the store to reflect a renaming of some article. Normally
	 * this happens when moving pages in the wiki, and in this case there
	 * is also a new redirect page generated at the old position. The title
	 * objects given are only used to specify the name of the title before
	 * and after the move -- do not use their IDs for anything! The ID of
	 * the moved page is given in $pageid, and the ID of the newly created
	 * redirect, if any, is given by $redirid. If no new page was created,
	 * $redirid will be 0.
	 */
	public function changeTitle( Title $oldtitle, Title $newtitle, $pageid, $redirid = 0 ) {
		// TODO: Update Solr to reflect a renaming of some article
		return self::getBaseStore()->changeTitle( $oldtitle, $newtitle, $pageid, $redirid );
	}

//// / Query answering /////

	/**
	 * Execute the provided query and return the result as an
	 * SMWQueryResult if the query was a usual instance retrieval query. In
	 * the case that the query asked for a plain string (querymode
	 * MODE_COUNT or MODE_DEBUG) a plain wiki and HTML-compatible string is
	 * returned.
	 *
	 * @param SMWQuery $query
	 *
	 * @return SMWQueryResult
	 */
	public function getQueryResult( SMWQuery $query ) {
		// IF YOU SEE THIS HERE PLEASE IGNORE IT!
		// Our first approach was to create new SMWStore for querying data
		// but we had big problems recreating and parsing the SMW query syntax,
		// so we just stopped at this point here.
		// Maybe we will finish it someday
		$wgSolrTalker = new SolrTalker();
		if ( property_exists( $query, 'params' ) &&
				array_key_exists( 'source', $query->params ) &&
				$query->params['source'] == 'solr' ) {

			$results = array();
			$dbkey = '';
			$namespace = 0;
			$interwiki = '';

			echo( "SOLR query: {$query->getQueryString()}\n" );

			echo 'Search is powered by Solr!';
			echo $queryStr = urldecode( $wgSolrTalker->parseSolrQuery( $query->getQueryString() ) );

			// Get sort parameters and add them to the query string
			if ( $query->sort ) {
				// TODO: Der Inhalt von Sort muss genau der Name eines der Felder von Solr sein
				//	  um danach Sortieren zu können. Deshalb Wird eine Liste alle Solr Felder
				//	  Benötigt um Festzustellen welches Feld gemeint ist bzw. welche _XYZ Endung
				//	  an dem Ende des Feldes angehängt wurde.
				//
				$sort = $wgSolrTalker->findField( $query->params['sort'], $query->params['order'] );
				$queryStr .= '&sort%3D' . $sort . '+' . trim( $query->params['order'] );
				//  $queryStr = $queryStr . '&sort=' . trim($sort . '+' . trim($query->params['order']));
				// TODO: Mehrer Sort parameter auslesen wenn sie vorhanden sind.
			} //else {
//				$queryStr = $queryStr . '&sort=pagetitle';
//			}

			// TODO: Prüfen wieso nur 1 Ergebniss ausgegeben wird
			echo 'Query Limit:' . $query->getLimit();

			echo ( 'SEARCHRESULT: ' . $xml = $wgSolrTalker->solrQuery( $queryStr, $query->getOffset(), $query->getLimit() ) );
			echo '<br />';
			// TODO: Move this code to parseSolrResult
			$numFound = $xml->result['numFound'];
			foreach ( $xml->result->doc as $doc ) {
				foreach ( $doc->str as $field ) {
					switch ( $field['name'] ) {
						case 'dbkey':
							$dbkey = $field;
							break;
						case 'interwiki':
							$interwiki = $field;
							break;
						case 'namespace':
							$namespace = $field;
							break;
					}
				}
				// Multivalue fields
				foreach ( $doc->arr as $field ) {
					switch ( $field['name'] ) {
						case 'dbkey':
							$dbkey = $field;
							break;
						case 'interwiki':
							$interwiki = $field;
							break;
						case 'namespace':
							$namespace = $field;
							break;
					}
					foreach ( $field->str as $value ) {
						$value;
					}
				}
				$results[] = new SMWDIWikiPage( $dbkey, $namespace, $interwiki );
			}

			// Do we have more results?
			$more = false;
			// TODO: Does this work?
			echo 'Number of records: ' . $numFound;
			if ( $numFound > 10 ) {
				$more = true;
			}

			// return new SMWQueryResult($printRequests, $query, $results, $store);
			return new SMWQueryResult( $query->getDescription()->getPrintrequests(), $query, $results, $this, $more );
		} else {
			return self::getBaseStore()->getQueryResult( $query );
		}
	}

//// / Special page functions /////

	/**
	 * Return all properties that have been used on pages in the wiki. The
	 * result is an array of arrays, each containing a property title and a
	 * count. The expected order is alphabetical w.r.t. to property title
	 * texts.
	 *
	 * @param SMWRequestOptions $requestoptions
	 *
	 * @return array
	 */
	public function getPropertiesSpecial( $requestoptions = null ) {
		return self::getBaseStore()->getPropertiesSpecial( $requestoptions );
	}

	/**
	 * Return all properties that have been declared in the wiki but that
	 * are not used on any page. Stores might restrict here to those
	 * properties that have been given a type if they have no efficient
	 * means of accessing the set of all pages in the property namespace.
	 *
	 * @param SMWRequestOptions $requestoptions
	 *
	 * @return array of SMWDIProperty
	 */
	public function getUnusedPropertiesSpecial( $requestoptions = null ) {
		return self::getBaseStore()->getUnusedPropertiesSpecial( $requestoptions );
	}

	/**
	 * Return all properties that are used on some page but that do not
	 * have any page describing them. Stores that have no efficient way of
	 * accessing the set of all existing pages can extend this list to all
	 * properties that are used but do not have a type assigned to them.
	 *
	 * @param SMWRequestOptions $requestoptions
	 *
	 * @return array of array( SMWDIProperty, int )
	 */
	public function getWantedPropertiesSpecial( $requestoptions = null ) {
		return self::getBaseStore()->getWantedPropertiesSpecial( $requestoptions );
	}

	/**
	 * Return statistical information as an associative array with the
	 * following keys:
	 * - 'PROPUSES': Number of property instances (value assignments) in the datatbase
	 * - 'USEDPROPS': Number of properties that are used with at least one value
	 * - 'DECLPROPS': Number of properties that have been declared (i.e. assigned a type)
	 *
	 * @return array
	 */
	public function getStatistics() {
		return self::getBaseStore()->getStatistics();
	}

//// / Setup store /////

	/**
	 * Setup all storage structures properly for using the store. This
	 * function performs tasks like creation of database tables. It is
	 * called upon installation as well as on upgrade: hence it must be
	 * able to upgrade existing storage structures if needed. It should
	 * return "true" if successful and return a meaningful string error
	 * message otherwise.
	 *
	 * The parameter $verbose determines whether the procedure is allowed
	 * to report on its progress. This is doen by just using print and
	 * possibly ob_flush/flush. This is also relevant for preventing
	 * timeouts during long operations. All output must be valid in an HTML
	 * context, but should preferrably be plain text, possibly with some
	 * linebreaks and weak markup.
	 *
	 * @param boolean $verbose
	 */
	public function setup( $verbose = true ) {
		// TODO: Setup data structures on the the Solr server, if necessary
		return self::getBaseStore()->setup( $verbose );
	}

	/**
	 * Drop (delete) all storage structures created by setup(). This will
	 * delete all semantic data and possibly leave the wiki uninitialised.
	 *
	 * @param boolean $verbose
	 */
	public function drop( $verbose = true ) {
		global $wgSolrTalker;
		$wgSolrTalker->deleteAllDocs();
		// Drop all data from Solr

		return self::getBaseStore()->drop( $verbose );
	}

	/**
	 * Refresh some objects in the store, addressed by numerical ids. The
	 * meaning of the ids is private to the store, and does not need to
	 * reflect the use of IDs elsewhere (e.g. page ids). The store is to
	 * refresh $count objects starting from the given $index. Typically,
	 * updates are achieved by generating update jobs. After the operation,
	 * $index is set to the next index that should be used for continuing
	 * refreshing, or to -1 for signaling that no objects of higher index
	 * require refresh. The method returns a decimal number between 0 and 1
	 * to indicate the overall progress of the refreshing (e.g. 0.7 if 70%
	 * of all objects were refreshed).
	 *
	 * The optional parameter $namespaces may contain an array of namespace
	 * constants. If given, only objects from those namespaces will be
	 * refreshed. The default value FALSE disables this feature.
	 *
	 * The optional parameter $usejobs indicates whether updates should be
	 * processed later using MediaWiki jobs, instead of doing all updates
	 * immediately. The default is TRUE.
	 *
	 * @param $index integer
	 * @param $count integer
	 * @param $namespaces mixed array or false
	 * @param $usejobs boolean
	 *
	 * @return decimal between 0 and 1 to indicate the overall progress of the refreshing
	 */
	public function refreshData( &$index, $count, $namespaces = false, $usejobs = true ) {
		// TODO: Do we need to do something here for Solr? Can we do something?
		return self::getBaseStore()->refreshData( $index, $count, $namespaces, $usejobs );
	}

}
