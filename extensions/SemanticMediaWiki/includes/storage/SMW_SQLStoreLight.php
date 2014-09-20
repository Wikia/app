<?php
/**
 * New SQL implementation of SMW's storage abstraction layer with
 * a reduced feature set for the SMWLight version. Statistic features
 * and semantic queries are completely disabled for now.
 *
 * @author Markus Krötzsch
 * @file
 * @ingroup SMWStore
 */


/**
 * Storage access class for using the standard MediaWiki SQL database
 * for keeping semantic data. This is a lightweight version of SMW's standard
 * storage implementation, providing only basic data storage and retrieval but
 * no querying (and no concept caching) or statistics.
 *
 * @todo This implementation is not completed yet and should be considered
 * experimental.
 *
 * @ingroup SMWStore
 */
class SMWSQLStoreLight extends SMWStore {

	/// Cache for SMWSemanticData objects, indexed by page ID
	protected $m_semdata = array();
	/// Like SMWSQLStoreLight::m_semdata, but containing arrays for indicating completeness of the SMWSemanticData objs
	protected $m_sdstate = array();
	/// >0 while getSemanticData runs, used to prevent nested calls from clearing the cache while another call runs and is about to fill it with data
	protected static $in_getSemanticData = 0;

	/// Data for which type ids should be stored in the special table?
	/// Special values must only have one DB key, stored as a 256byte string.
	private static $special_types = array(
		'__typ' => true, // Special type page type
		'__tls' => true, // Special type list for _rec properties
		'__sps' => true, // Special string type
		'__spu' => true, // Special uri type
		'__spf' => true, // Special form type (for Semantic Forms)
		'__imp' => true, // Special import vocabulary type
	);

///// Reading methods /////

	public function getSemanticData( $subject, $filter = false ) {
		wfProfileIn( "SMWSQLStoreLight::getSemanticData (SMW)" );
		SMWSQLStoreLight::$in_getSemanticData++; // do not clear the cache when called recursively
		// *** Find out if this subject exists ***//
		if ( $subject instanceof Title ) { /// TODO: can this still occur?
			$sid = $subject->getArticleID();
			$svalue = SMWWikiPageValue::makePageFromTitle( $subject );
		} elseif ( $subject instanceof SMWWikiPageValue ) {
			$sid = $subject->isValid() ? $subject->getTitle()->getArticleID() : 0;
			$svalue = $subject;
		} else {
			$sid = 0;
		}
		if ( $sid == 0 ) { // no data, safe our time
			SMWSQLStoreLight::$in_getSemanticData--;
			wfProfileOut( "SMWSQLStoreLight::getSemanticData (SMW)" );
			return isset( $svalue ) ? ( new SMWSemanticData( $svalue ) ) : null;
		}
		// *** Prepare the cache ***//
		if ( !array_key_exists( $sid, $this->m_semdata ) ) { // new cache entry
			$this->m_semdata[$sid] = new SMWSemanticData( $svalue, false );
			$this->m_sdstate[$sid] = array();
		}
		if ( ( count( $this->m_semdata ) > 20 ) && ( SMWSQLStoreLight::$in_getSemanticData == 1 ) ) {
			// prevent memory leak;
			// It is not so easy to find the sweet spot between cache size and performance gains (both memory and time),
			// The value of 20 was chosen by profiling runtimes for large inline queries and heavily annotated pages.
			$this->m_semdata = array( $sid => $this->m_semdata[$sid] );
			$this->m_sdstate = array( $sid => $this->m_sdstate[$sid] );
		}
		// *** Read the data ***//
		$db = wfGetDB( DB_SLAVE );
		foreach ( array( 'smwsimple_data', 'smwsimple_special' ) as $tablename ) {
			if ( array_key_exists( $tablename, $this->m_sdstate[$sid] ) ) continue;
			if ( $filter !== false ) {
				$relevant = false;
				foreach ( $filter as $typeid ) {
					$relevant = $relevant || ( $tablename == SMWSQLStoreLight::findTypeTableName( $typeid ) );
				}
				if ( !$relevant ) continue;
			}
			$res = $db->select( $tablename, array( 'propname', 'value' ), array( 'pageid' => $sid ),
			                    'SMW::getSemanticData', array( 'DISTINCT' ) );
			foreach ( $res as $row ) {
				$value = ( $tablename == 'smwsimple_special' ) ? array( $row->value ) : unserialize( $row->value );
				$this->m_semdata[$sid]->addPropertyStubValue( $row->propname, $value );
			}
			$db->freeResult( $res );
			$this->m_sdstate[$sid][$tablename] = true;
		}

		SMWSQLStoreLight::$in_getSemanticData--;
		wfProfileOut( "SMWSQLStoreLight::getSemanticData (SMW)" );
		return $this->m_semdata[$sid];
	}

	public function getPropertyValues( $subject, SMWDIProperty $property, $requestoptions = null, $outputformat = '' ) {
		wfProfileIn( "SMWSQLStoreLight::getPropertyValues (SMW)" );
		if ( $property->isInverse() ) { // inverses are working differently
			$noninverse = clone $property;
			$noninverse->setInverse( false );
			$result = $this->getPropertySubjects( $noninverse, $subject, $requestoptions );
		} elseif ( $subject !== null ) { // subject given, use semantic data cache:
			$sd = $this->getSemanticData( $subject, array( $property->getPropertyTypeID() ) );
			$result = $this->applyRequestOptions( $sd->getPropertyValues( $property ), $requestoptions );
			if ( $outputformat !== '' ) { // reformat cached values
				$newres = array();
				foreach ( $result as $dv ) {
					$ndv = clone $dv;
					$ndv->setOutputFormat( $outputformat );
					$newres[] = $ndv;
				}
				$result = $newres;
			}
		} else { // no subject given, get all values for the given property
			$tablename = SMWSQLStoreLight::findPropertyTableName( $property );
			$db = wfGetDB( DB_SLAVE );
			$res = $db->select( $tablename, array( 'value' ), array( 'propname' => $property->getDBkey() ),
			                    'SMW::getPropertyValues', $this->getSQLOptions( $requestoptions, 'value' ) + array( 'DISTINCT' ) );
			$result = array();
			foreach ( $res as $row ) {
				$dv = SMWDataValueFactory::newPropertyObjectValue( $property );
				if ( $outputformat !== '' ) $dv->setOutputFormat( $outputformat );
				$dv->setDBkeys( ( $tablename == 'smwsimple_special' ) ? array( $row->value ) : unserialize( $row->value ) );
				$result[] = $dv;
			}
			$db->freeResult( $res );
		}
		wfProfileOut( "SMWSQLStoreLight::getPropertyValues (SMW)" );
		return $result;
	}

	public function getPropertySubjects( SMWDIProperty $property, $value, $requestoptions = null ) {
		wfProfileIn( "SMWSQLStoreLight::getPropertySubjects (SMW)" );
		if ( $property->isInverse() ) { // inverses are working differently
			$noninverse = clone $property;
			$noninverse->setInverse( false );
			$result = $this->getPropertyValues( $value, $noninverse, $requestoptions );
			wfProfileOut( "SMWSQLStoreLight::getPropertySubjects (SMW)" );
			return $result;
		}

		// ***  First build $select, $from, and $where for the DB query  ***//
		$tablename = SMWSQLStoreLight::findPropertyTableName( $property );
		$db = wfGetDB( DB_SLAVE );
		$from = $db->tableName( 'page' ) . " AS p INNER JOIN " . $db->tableName( $tablename ) . " AS t ON t.pageid=p.page_id";
		$where = 't.propname=' . $db->addQuotes( $property->getDBkey() );
		if ( $value !== null ) {
			$valuestring = ( $tablename == 'smwsimple_special' ) ? reset( $value->getDBkeys() ) : serialize( $value->getDBkeys() );
			$where .= ' AND t.value=' . $db->addQuotes( $valuestring );
		}
		$select = array( 'p.page_title AS title', 'p.page_namespace AS namespace' );
		// ***  Now execute the query and read the results  ***//
		$result = array();
		$res = $db->select( $from, $select,
		                    $where . $this->getSQLConditions( $requestoptions, 'p.page_title', 'p.page_title' ),
							'SMW::getPropertySubjects',
		                    $this->getSQLOptions( $requestoptions, 'p.page_title' ) + array( 'DISTINCT' ) );
		foreach ( $res as $row ) {
			$result[] = SMWWikiPageValue::makePage( $row->title, $row->namespace, $row->title );
		}
		$db->freeResult( $res );
		wfProfileOut( "SMWSQLStoreLight::getPropertySubjects (SMW)" );
		return $result;
	}

	public function getAllPropertySubjects( SMWDIProperty $property, $requestoptions = null ) {
		wfProfileIn( "SMWSQLStoreLight::getAllPropertySubjects (SMW)" );
		$result = $this->getPropertySubjects( $property, null, $requestoptions );
		wfProfileOut( "SMWSQLStoreLight::getAllPropertySubjects (SMW)" );
		return $result;
	}

	/**
	 * @todo Restrict this function to SMWWikiPageValue subjects.
	 */
	public function getProperties( $subject, $requestoptions = null ) {
		wfProfileIn( "SMWSQLStoreLight::getProperties (SMW)" );
		$sid = $subject->getTitle()->getArticleID();
		if ( $sid == 0 ) { // no id, no page, no properties
			wfProfileOut( "SMWSQLStoreLight::getProperties (SMW)" );
			return array();
		}

		$db = wfGetDB( DB_SLAVE );
		$result = array();
		if ( $requestoptions !== null ) { // potentially need to get more results, since options apply to union
			$suboptions = clone $requestoptions;
			$suboptions->limit = $requestoptions->limit + $requestoptions->offset;
			$suboptions->offset = 0;
		} else {
			$suboptions = null;
		}
		foreach ( array( 'smwsimple_data', 'smwsimple_special' ) as $tablename ) {
			$res = $db->select( $tablename, 'DISTINCT propname',
				'pageid=' . $db->addQuotes( $sid ) . $this->getSQLConditions( $suboptions, 'propname', 'propname' ),
				'SMW::getProperties', $this->getSQLOptions( $suboptions, 'propname' ) );
			foreach ( $res as $row ) {
				$result[] = new SMWDIProperty( $row->propname );
			}
			$db->freeResult( $res );
		}
		$result = $this->applyRequestOptions( $result, $requestoptions ); // apply options to overall result
		wfProfileOut( "SMWSQLStoreLight::getProperties (SMW)" );
		return $result;
	}

	/**
	 * Implementation of SMWStore::getInProperties(). This function is meant to
	 * be used for finding properties that link to wiki pages.
	 * @todo When used for other datatypes, the function may return too many
	 * properties since it selects results by comparing the stored information
	 * (DB keys) only, while not currently comparing the type of the returned
	 * property to the type of the queried data. So values with the same DB keys
	 * can be confused. This is a minor issue now since no code is known to use
	 * this function in cases where this occurs.
	 */
	public function getInProperties( SMWDataValue $value, $requestoptions = null ) {
		wfProfileIn( "SMWSQLStoreLight::getInProperties (SMW)" );
		$db = wfGetDB( DB_SLAVE );
		$result = array();
		$typeid = $value->getTypeID();

		if ( $requestoptions !== null ) { // potentially need to get more results, since options apply to union
			$suboptions = clone $requestoptions;
			$suboptions->limit = $requestoptions->limit + $requestoptions->offset;
			$suboptions->offset = 0;
		} else {
			$suboptions = null;
		}
		foreach ( array( 'smwsimple_data', 'smwsimple_special' ) as $tablename ) {
			if ( SMWSQLStoreLight::findTypeTableName( $typeid ) != $tablename ) continue;
			$valuestring = ( $tablename == 'smwsimple_special' ) ? reset( $value->getDBkeys() ) : serialize( $value->getDBkeys() );
			$where = 'value=' . $db->addQuotes( $valuestring );
			$res = $db->select( $tablename, 'DISTINCT propname', // select sortkey since it might be used in ordering (needed by Postgres)
								$where . $this->getSQLConditions( $suboptions, 'propname', 'propname' ),
								'SMW::getInProperties', $this->getSQLOptions( $suboptions, 'propname' ) );
			foreach ( $res as $row ) {
				$result[] = new SMWDIProperty( $row->propname );
			}
			$db->freeResult( $res );
		}
		$result = $this->applyRequestOptions( $result, $requestoptions ); // apply options to overall result
		wfProfileOut( "SMWSQLStoreLight::getInProperties (SMW)" );
		return $result;
	}

///// Writing methods /////

	public function deleteSubject( Title $subject ) {
		wfProfileIn( 'SMWSQLStoreLight::deleteSubject (SMW)' );
		wfRunHooks( 'SMWSQLStoreLight::deleteSubjectBefore', array( $this, $subject ) );
		$this->deleteSemanticData( SMWWikiPageValue::makePageFromTitle( $subject ) );
		/// FIXME: if a property page is deleted, more pages may need to be updated by jobs!
		/// TODO: who is responsible for these updates? Some update jobs are currently created in SMW_Hooks, some internally in the store
		/// FIXME: clean internal caches here
		wfRunHooks( 'SMWSQLStoreLight::deleteSubjectAfter', array( $this, $subject ) );
		wfProfileOut( 'SMWSQLStoreLight::deleteSubject (SMW)' );
	}

	public function doDataUpdate( SMWSemanticData $data ) {
		wfProfileIn( "SMWSQLStoreLight::updateData (SMW)" );
		wfRunHooks( 'SMWSQLStoreLight::updateDataBefore', array( $this, $data ) );
		$subject = $data->getSubject();
		$this->deleteSemanticData( $subject );
		$sid = $subject->getTitle()->getArticleID();
		$updates = array(); // collect data for bulk updates; format: tableid => updatearray
		foreach ( $data->getProperties() as $property ) {
			$tablename = SMWSQLStoreLight::findPropertyTableName( $property );
			if ( $tablename === '' ) continue;
			foreach ( $data->getPropertyValues( $property ) as $dv ) {
				if ( !$dv->isValid() ) continue;
				if ( $dv instanceof SMWContainerValue ) {
					continue;  // subobjects not supported in this store right now; maybe could simply be PHP serialized
				} else {
					$uvals = array( 'pageid' => $sid, 'propname' => $property->getDBkey(),
					                'value' => ( $tablename == 'smwsimple_special' ? reset( $dv->getDBkeys() ) : serialize( $dv->getDBkeys() ) ) );
				}
				if ( !array_key_exists( $tablename, $updates ) ) $updates[$tablename] = array();
				$updates[$tablename][] = $uvals;
			}
		}
		$db = wfGetDB( DB_MASTER );
		foreach ( $updates as $tablename => $uvals ) {
 			$db->insert( $tablename, $uvals, "SMW::updateData$tablename" );
		}

		// Finally update caches (may be important if jobs are directly following this call)
		$this->m_semdata[$sid] = clone $data;
		$this->m_sdstate[$sid] = array( 'smwsimple_data' => true , 'smwsimple_special' => true ); // everything that one can know

		wfRunHooks( 'SMWSQLStoreLight::updateDataAfter', array( $this, $data ) );
		wfProfileOut( "SMWSQLStoreLight::updateData (SMW)" );
	}

	public function changeTitle( Title $oldtitle, Title $newtitle, $pageid, $redirid = 0 ) {
		// Nothing needs to be done here: MediaWiki makes sure that the page keeps the same page
		// id before and after a move, so all SMW data is indirectly moved along with the page
		// contents.
		// If SMW would store data for redirect pages, then this data could become orphaned in this
		// operation, since MW moves over redirects without notice. None of the parameters of this
		// hook tells us which id the deleted (moved-over) redirect had, so we could not do anything
		// simple to keep the store consistent in this case.
		// This also shows why using MW page ids as values of properties that point to pages would
		// be problematic unless further hooks would be provided by MW to track the change/destruction
		// of page ids like when moving over an existing page.
	}

///// Query answering /////

	function getQueryResult( SMWQuery $query ) {
		return null; // not supported by this store
	}

///// Special page functions /////

	public function getPropertiesSpecial( $requestoptions = null ) {
		return array(); // not supported by this store
	}

	public function getUnusedPropertiesSpecial( $requestoptions = null ) {
		return array(); // not supported by this store
	}

	public function getWantedPropertiesSpecial( $requestoptions = null ) {
		return array(); // not supported by this store
	}

	public function getStatistics() {
		return array( 'PROPUSES' => 0, 'USEDPROPS' => 0, 'DECLPROPS' => 0 ); // not supported by this store
	}

///// Setup store /////

	public function setup( $verbose = true ) {
		$this->reportProgress( "Setting up standard database configuration for SMW ...\n\n", $verbose );
		$this->reportProgress( "Selected storage engine is \"SMWSQLStoreLight\" (or an extension thereof)\n\n", $verbose );
		$db = wfGetDB( DB_MASTER );
		$this->setupTables( $verbose, $db );
		return true;
	}

	/**
	 * Create required SQL tables. This function also performs upgrades of table contents
	 * when required.
	 */
	protected function setupTables( $verbose, $db ) {
		$reportTo = $verbose ? $this : null; // Use $this to report back from static SMWSQLHelpers.

		SMWSQLHelpers::setupTable( // table for most data
			'smwsimple_data',
			array(
				'pageid' => SMWSQLHelpers::getStandardDBType( 'id' ) . ' NOT NULL',
				'propname' => SMWSQLHelpers::getStandardDBType( 'title' ) . ' NOT NULL',
				'value' => SMWSQLHelpers::getStandardDBType( 'blob' ) . ' NOT NULL'
			),
			$db,
			$reportTo
		);
		SMWSQLHelpers::setupIndex( 'smwsimple_data', array( 'pageid', 'propname', 'propname,value(256)' ), $db );
		SMWSQLHelpers::setupTable( // table for data that is needed frequently and looked-up often, e.g. property type declarations
			'smwsimple_special',
			array(
				'pageid' => SMWSQLHelpers::getStandardDBType( 'id' ) . ' NOT NULL',
				'propname' => SMWSQLHelpers::getStandardDBType( 'title' ) . ' NOT NULL',
				'value' => SMWSQLHelpers::getStandardDBType( 'title' ) . ' NOT NULL'
			),
			$db,
			$reportTo
		);
		SMWSQLHelpers::setupIndex( 'smwsimple_special', array( 'pageid', 'pageid,propname', 'propname', 'propname,value' ), $db );

		$this->reportProgress( "Database initialised successfully.\n\n", $verbose );
	}

	public function drop( $verbose = true ) {
		global $wgDBtype;
		$this->reportProgress( "Deleting all database content and tables generated by SMW ...\n\n", $verbose );
		$db = wfGetDB( DB_MASTER );
		$tables = array( 'smwsimple_data', 'smwsimple_special' );
		foreach ( $tables as $table ) {
			$name = $db->tableName( $table );
			$db->query( 'DROP TABLE' . ( $wgDBtype == 'postgres' ? '':' IF EXISTS' ) . $name, 'SMWSQLStoreLight::drop' );
			$this->reportProgress( " ... dropped table $name.\n", $verbose );
		}
		$this->reportProgress( "All data removed successfully.\n", $verbose );
		return true;
	}

	public function refreshData( &$index, $count, $namespaces = false, $usejobs = true ) {
		$updatejobs = array();
		$emptyrange = true; // was nothing found in this run?

		// update by MediaWiki page id --> make sure we get all pages
		$tids = array();
		for ( $i = $index; $i < $index + $count; $i++ ) { // array of ids
			$tids[] = $i;
		}
		$titles = Title::newFromIDs( $tids );
		foreach ( $titles as $title ) {
			if ( ( $namespaces == false ) || ( in_array( $title->getNamespace(), $namespaces ) ) ) {
				// wikia change start - jobqueue migration
				$task = new \Wikia\Tasks\Tasks\JobWrapperTask();
				$task->call( 'SMWUpdateJob', $title );
				$updatejobs[] = $task;
				// wikia change end

				$emptyrange = false;
			}
		}

		wfRunHooks( 'smwRefreshDataJobs', array( &$updatejobs ) );

		if ( $usejobs ) {
			// wikia change start - jobqueue migration
			\Wikia\Tasks\Tasks\BaseTask::batch( $updatejobs );
			// wikia change end
		} else {
			foreach ( $updatejobs as $job ) {
				// wikia change start - jobqueue migration
				/** @var \Wikia\Tasks\Tasks\JobWrapperTask $job */
				try {
					$job->init();
				} catch ( Exception $e ) {
					continue;
				}

				$job->wrap( 'SMWUpdateJob' );
				// wikia change end
			}
		}

		$db = wfGetDB( DB_SLAVE );
		$nextpos = $index + $count;
		if ( $emptyrange ) { // nothing found, check if there will be more pages later on
			$nextpos = $db->selectField( 'page', 'page_id', "page_id >= $nextpos", __METHOD__, array( 'ORDER BY' => "page_id ASC" ) );
		}
		$maxpos = $db->selectField( 'page', 'MAX(page_id)', '', __METHOD__ );
		$index = $nextpos ? $nextpos : -1;
		return ( $index > 0 ) ? ( $index / $maxpos ) : 1;
	}


///// Concept caching /////

	/**
	 * Refresh the concept cache for the given concept.
	 *
	 * @param $concept Title
	 */
	public function refreshConceptCache( $concept ) {
		return false; // not supported by this store
	}

	/**
	 * Delete the concept cache for the given concept.
	 *
	 * @param $concept Title
	 */
	public function deleteConceptCache( $concept ) {
		return false; // not supported by this store
	}

	/**
	 * Return status of the concept cache for the given concept as an array
	 * with key 'status' ('empty': not cached, 'full': cached, 'no': not
	 * cachable). If status is not 'no', the array also contains keys 'size'
	 * (query size), 'depth' (query depth), 'features' (query features). If
	 * status is 'full', the array also contains keys 'date' (timestamp of
	 * cache), 'count' (number of results in cache).
	 *
	 * @param $concept Title or SMWWikiPageValue
	 */
	public function getConceptCacheStatus( $concept ) {
		return array( 'status' => 'no' ); // not supported by this store
	}


///// Helper methods, mostly protected /////

	/**
	 * Transform input parameters into a suitable array of SQL options.
	 * The parameter $valuecol defines the string name of the column to which
	 * sorting requests etc. are to be applied.
	 */
	protected function getSQLOptions( $requestoptions, $valuecol = '' ) {
		$sql_options = array();
		if ( $requestoptions !== null ) {
			if ( $requestoptions->limit > 0 ) {
				$sql_options['LIMIT'] = $requestoptions->limit;
			}
			if ( $requestoptions->offset > 0 ) {
				$sql_options['OFFSET'] = $requestoptions->offset;
			}
			if ( ( $valuecol !== '' ) && ( $requestoptions->sort ) ) {
				$sql_options['ORDER BY'] = $requestoptions->ascending ? $valuecol : $valuecol . ' DESC';
			}
		}
		return $sql_options;
	}

	/**
	 * Transform input parameters into a suitable string of additional SQL conditions.
	 * The parameter $valuecol defines the string name of the column to which
	 * value restrictions etc. are to be applied.
	 * @param $requestoptions object with options
	 * @param $valuecol name of SQL column to which conditions apply
	 * @param $labelcol name of SQL column to which string conditions apply, if any
	 * @param $addand Boolean to indicate whether the string should begin with " AND " if non-empty
	 */
	protected function getSQLConditions( $requestoptions, $valuecol = '', $labelcol = '', $addand = true ) {
		$sql_conds = '';
		if ( $requestoptions !== null ) {
			$db = wfGetDB( DB_SLAVE ); /// TODO avoid doing this here again, all callers should have one
			if ( ( $valuecol !== '' ) && ( $requestoptions->boundary !== null ) ) { // apply value boundary
				if ( $requestoptions->ascending ) {
					$op = $requestoptions->include_boundary ? ' >= ':' > ';
				} else {
					$op = $requestoptions->include_boundary ? ' <= ':' < ';
				}
				$sql_conds .= ( $addand ? ' AND ':'' ) . $valuecol . $op . $db->addQuotes( $requestoptions->boundary );
			}
			if ( $labelcol !== '' ) { // apply string conditions
				foreach ( $requestoptions->getStringConditions() as $strcond ) {
					$string = str_replace( '_', '\_', $strcond->string );
					switch ( $strcond->condition ) {
						case SMWStringCondition::STRCOND_PRE:  $string .= '%'; break;
						case SMWStringCondition::STRCOND_POST: $string = '%' . $string; break;
						case SMWStringCondition::STRCOND_MID:  $string = '%' . $string . '%'; break;
					}
					$sql_conds .= ( ( $addand || ( $sql_conds !== '' ) ) ? ' AND ':'' ) . $labelcol . ' LIKE ' . $db->addQuotes( $string );
				}
			}
		}
		return $sql_conds;
	}

	/**
	 * Not in all cases can requestoptions be forwarded to the DB using
	 * getSQLConditions() and getSQLOptions(): some data comes from caches that
	 * do not respect the options yet. This method takes an array of results
	 * (SMWDataValue objects) *of the same type* and applies the given
	 * requestoptions as appropriate.
	 */
	protected function applyRequestOptions( $data, $requestoptions ) {
		wfProfileIn( "SMWSQLStoreLight::applyRequestOptions (SMW)" );
		if ( ( count( $data ) == 0 ) || ( $requestoptions === null ) ) {
			wfProfileOut( "SMWSQLStoreLight::applyRequestOptions (SMW)" );
			return $data;
		}
		$result = array();
		$sortres = array();
		$tablename = SMWSQLStoreLight::findTypeTableName( reset( $data )->getTypeID() );

		$i = 0;
		foreach ( $data as $item ) {
			$ok = true; // keep datavalue only if this remains true
			$value = ( $tablename == 'smwsimple_special' ) ? reset( $item->getDBkeys() ) : serialize( $item->getDBkeys() );
			if ( $requestoptions->boundary !== null ) { // apply value boundary
				$strc = strcmp( $value, $requestoptions->boundary );
				if ( $requestoptions->ascending ) {
					if ( $requestoptions->include_boundary ) {
						$ok = ( $strc >= 0 );
					} else {
						$ok = ( $strc > 0 );
					}
				} else {
					if ( $requestoptions->include_boundary ) {
						$ok = ( $strc <= 0 );
					} else {
						$ok = ( $strc < 0 );
					}
				}
			}
			foreach ( $requestoptions->getStringConditions() as $strcond ) { // apply string conditions
				switch ( $strcond->condition ) {
					case SMWStringCondition::STRCOND_PRE:
						$ok = $ok && ( strpos( $value, $strcond->string ) === 0 );
						break;
					case SMWStringCondition::STRCOND_POST:
						$ok = $ok && ( strpos( strrev( $value ), strrev( $strcond->string ) ) === 0 );
						break;
					case SMWStringCondition::STRCOND_MID:
						$ok = $ok && ( strpos( $value, $strcond->string ) !== false );
						break;
				}
			}
			if ( $ok ) {
				$result[$i] = $item;
				$sortres[$i] = $value; // maybe $value could also be used as array key here
				$i++;
			}
		}
		if ( $requestoptions->sort ) {
			$flag = SORT_LOCALE_STRING;
			if ( $requestoptions->ascending ) {
				asort( $sortres, $flag );
			} else {
				arsort( $sortres, $flag );
			}
			$newres = array();
			foreach ( $sortres as $key => $value ) {
				$newres[] = $result[$key];
			}
			$result = $newres;
		}
		if ( $requestoptions->limit > 0 ) {
			$result = array_slice( $result, $requestoptions->offset, $requestoptions->limit );
		} else {
			$result = array_slice( $result, $requestoptions->offset );
		}
		wfProfileOut( "SMWSQLStoreLight::applyRequestOptions (SMW)" );
		return $result;
	}

	/**
	 * Print some output to indicate progress. The output message is given by
	 * $msg, while $verbose indicates whether or not output is desired at all.
	 */
	public function reportProgress( $msg, $verbose = true ) {
		if ( $verbose ) {
			if ( ob_get_level() == 0 ) { // be sure to have some buffer, otherwise some PHPs complain
				ob_start();
			}
			print $msg;
			ob_flush();
			flush();
		}
	}

	/**
	 * Retrieve the name of the property table that is to be used for storing
	 * values for the given property object.
	 */
	public static function findPropertyTableName( $property ) {
		return SMWSQLStoreLight::findTypeTableName( $property->getPropertyTypeID() );
	}

	/**
	 * Retrieve the name of the property table that is to be used for storing
	 * values for the given property object.
	 */
	public static function findTypeTableName( $typeid ) {
		if ( array_key_exists( $typeid, SMWSQLStoreLight::$special_types ) ) {
			return 'smwsimple_special';
		} else {
			return 'smwsimple_data';
		}
	}

	/**
	 * Delete all semantic data stored for the given subject. Used for update
	 * purposes.
	 */
	protected function deleteSemanticData( SMWWikiPageValue $subject ) {
		$db = wfGetDB( DB_MASTER );
		$id = $subject->getTitle()->getArticleID();
		if ( $id == 0 ) return; // no data can be deleted (and hopefully no data exists)
		foreach ( array( 'smwsimple_data', 'smwsimple_special' ) as $tablename ) {
			$db->delete( $tablename, array( 'pageid' => $id ), 'SMW::deleteSemanticData' );
		}
		wfRunHooks( 'smwDeleteSemanticData', array( $subject ) );
	}

}
