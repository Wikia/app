<?php
/**
 * WikiaApiQueryCategoryIntersection - get list of articles which belong to ALL of the provided categories
 *
 * @author Sean Colombo <sean@wikia.com>
 *
 * This extension was initially written for LyricWiki, but should be able to work on other wikis.
 *
 * The structure of the result and parameters were chosen to be similar to 'categorymembers': http://www.mediawiki.org/wiki/API:Categorymembers
 * One notable difference is that categorymembers has a prefix of "cm" on all of its parameters, while this extension does not have a prefix.
 * For example, the limit is "cmlimit" for CategoryMembers and just "limit" here.
 */

$wgAPIListModules[ "categoryintersection" ] = "WikiaApiQueryCategoryIntersection";

class WikiaApiQueryCategoryIntersection extends ApiQueryGeneratorBase {
    /**
     * constructor
     */
	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName);
	}

	public function execute() {
		$this->getCategoryIntersection();
	}

    /**
     * dispatcher
     */
	public function executeGenerator( $resultPageSet ) {
		$this->getCategoryIntersection( $resultPageSet );

	} // end execute()

	/**
	 * TODO: DOCUMENT
	 */
	private function getCategoryIntersection( $resultPageSet = null ) {
		wfProfileIn( __METHOD__ );
		
		// We need to set something as requiring an API key to test that with Fastly.  Since I don't think anyone external is using this function
		// and it technically could be resource intensive if someone outside wikia tried to run this code (and didn't have SSDs), this function is it!
		header( 'X-Requires-ApiKey: 1' );

		$params = $this->extractRequestParams();

		if ( !isset( $params['categories'] ) || is_null( $params['categories'] ) ){
			$this->dieUsage( "The categories parameter is required", 'notitle' );
		}

		$prop = array_flip( $params['prop'] );
		$fld_ids = isset( $prop['ids'] );
		$fld_title = isset( $prop['title'] );
		$fld_sortkey = isset( $prop['sortkey'] );
		$fld_timestamp = isset( $prop['timestamp'] );

		if ( is_null( $resultPageSet ) ) {
			$this->addFields( array( 'cl_from', 'cl_sortkey', 'page_namespace', 'page_title' ) );
			$this->addFieldsIf( 'page_id', $fld_ids );
		} else {
			$this->addFields( $resultPageSet->getPageTableFields() ); // will include page_ id, ns, title
			$this->addFields( array( 'cl_from', 'cl_sortkey' ) );
		}

		$this->addFieldsIf( 'cl_timestamp', $fld_timestamp || $params['sort'] == 'timestamp' );
		$this->addTables( array( 'page', 'categorylinks' ) );	// must be in this order for 'USE INDEX'
		// MW: Not needed after bug 10280 is applied to servers
		if ( $params['sort'] == 'timestamp' ){
			$this->addOption( 'USE INDEX', 'cl_timestamp' );
		} else {
			$this->addOption( 'USE INDEX', 'cl_sortkey' );
		}

		$this->addWhere( 'page_id=cl_from' );
		$this->setContinuation( $params['continue'], $params['dir'] );

		/*
		# Example of rather-fast query after trying several different queries			
		SELECT page_title FROM
			categorylinks, page
			WHERE page_id=cl_from
			AND cl_to='Hometown/United_States' # my guess is that if we do a pre-query to find the size of each category, it'd be best to put the biggest one here since the other categories are inside inner-queries which I THINK involves writing temp tables to disks (containing their results).
			AND cl_from in ( SELECT cl_from FROM categorylinks WHERE cl_to='Genre/Rock' )
			AND cl_from in ( SELECT cl_from FROM categorylinks WHERE cl_to='Artists_T' )
		*/
		
		// PERFORMANCE NOTE: If we end up doing another query ahead of time to determine the sizes of each of the categories, I _think_ the fastest query
		// would be to have the category w/the most items be in the conditional by itself since the other categories are in nested queries which I think
		// create temp tables which are potentailly written to disk.  Currently, the queries run so fast that testing this isn't resulting in any visible
		// differences.

		$isFirst = true;
		$categories = explode("|", $params['categories']);
		foreach($categories as $category){
			$categoryTitle = Title::newFromText( $category );
			if ( is_null( $categoryTitle ) || $categoryTitle->getNamespace() != NS_CATEGORY ){
				$this->dieUsage( "The category name you entered is not valid", 'invalidcategory' );
			}
			
			if($isFirst){
				$this->addWhereFld( 'cl_to', $categoryTitle->getDBkey() );
				$isFirst = false;
			} else {
				// TODO: FIXME: Is there any way to do this which isn't SQL-specific?

				$tableName = "categorylinks"; // TODO: FIXME: make this work with table prefixes.
				$this->addWhere( "cl_from IN ( SELECT cl_from FROM $tableName WHERE cl_to='".addslashes($categoryTitle->getDBkey())."' )");
			}
		}

		// Scanning large datasets for rare categories sucks, and I already told 
		// how to have efficient subcategory access :-) ~~~~ (oh well, domas)
		global $wgMiserMode;
		$miser_ns = array();
		if ( $wgMiserMode ) {
			$miser_ns = $params['namespace'];
		} else {
			$this->addWhereFld( 'page_namespace', $params['namespace'] );
		}
		if ( $params['sort'] == 'timestamp' )
			$this->addWhereRange( 'cl_timestamp', ( $params['dir'] == 'asc' ? 'newer' : 'older' ), $params['start'], $params['end'] );
		else
		{
			$this->addWhereRange( 'cl_sortkey', ( $params['dir'] == 'asc' ? 'newer' : 'older' ), $params['startsortkey'], $params['endsortkey'] );
			$this->addWhereRange( 'cl_from', ( $params['dir'] == 'asc' ? 'newer' : 'older' ), null, null );
		}

		$limit = $params['limit'];
		$this->addOption( 'LIMIT', $limit + 1 );

		$db = $this->getDB();

		$data = array ();
		$count = 0;
		$lastSortKey = null;
		$res = $this->select( __METHOD__ );
		while ( $row = $db->fetchObject( $res ) ) {
			if ( ++ $count > $limit ) {
				// We've reached the one extra which shows that there are additional pages to be had. Stop here...
				// TODO: Security issue - if the user has no right to view next title, it will still be shown
				if ( $params['sort'] == 'timestamp' )
					$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->cl_timestamp ) );
				else
					$this->setContinueEnumParameter( 'continue', $this->getContinueStr( $row, $lastSortKey ) );
				break;
			}

			// Since domas won't tell anyone what he told long ago, apply 
			// cmnamespace here. This means the query may return 0 actual 
			// results, but on the other hand it could save returning 5000 
			// useless results to the client. ~~~~
			if ( count( $miser_ns ) && !in_array( $row->page_namespace, $miser_ns ) )
				continue;

			if ( is_null( $resultPageSet ) ) {
				$vals = array();
				if ( $fld_ids )
					$vals['pageid'] = intval( $row->page_id );
				if ( $fld_title ) {
					$title = Title :: makeTitle( $row->page_namespace, $row->page_title );
					ApiQueryBase::addTitleInfo( $vals, $title );
				}
				if ( $fld_sortkey )
					$vals['sortkey'] = $row->cl_sortkey;
				if ( $fld_timestamp )
					$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->cl_timestamp );
				$fit = $this->getResult()->addValue( array( 'query', $this->getModuleName() ),
						null, $vals );
				if ( !$fit )
				{
					if ( $params['sort'] == 'timestamp' )
						$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->cl_timestamp ) );
					else
						$this->setContinueEnumParameter( 'continue', $this->getContinueStr( $row, $lastSortKey ) );
					break;
				}
			} else {
				$resultPageSet->processDbRow( $row );
			}
			$lastSortKey = $row->cl_sortkey;	// detect duplicate sortkeys
		}
		$db->freeResult( $res );

		if ( is_null( $resultPageSet ) ) {
			$this->getResult()->setIndexedTagName_internal(
					 array( 'query', $this->getModuleName() ), 'cm' );
		}

		wfProfileOut( __METHOD__ );
	} // end getCategoryIntersection()
	
	private function getContinueStr( $row, $lastSortKey ) {
		$ret = $row->cl_sortkey . '|';
		if ( $row->cl_sortkey == $lastSortKey )	// duplicate sort key, add cl_from
			$ret .= $row->cl_from;
		return $ret;
	}
	
	/**
	 * Add DB WHERE clause to continue previous query based on 'continue' parameter
	 */
	private function setContinuation( $continue, $dir ) {
		if ( is_null( $continue ) )
			return;	// This is not a continuation request

		$pos = strrpos( $continue, '|' );
		$sortkey = substr( $continue, 0, $pos );
		$fromstr = substr( $continue, $pos + 1 );
		$from = intval( $fromstr );

		if ( $from == 0 && strlen( $fromstr ) > 0 )
			$this->dieUsage( "Invalid continue param. You should pass the original value returned by the previous query", "badcontinue" );

		$encSortKey = $this->getDB()->addQuotes( $sortkey );
		$encFrom = $this->getDB()->addQuotes( $from );
		
		$op = ( $dir == 'desc' ? '<' : '>' );

		if ( $from != 0 ) {
			// Duplicate sort key continue
			$this->addWhere( "cl_sortkey$op$encSortKey OR (cl_sortkey=$encSortKey AND cl_from$op=$encFrom)" );
		} else {
			$this->addWhere( "cl_sortkey$op=$encSortKey" );
		}
	}

	/**
	 * Description for automatic documentation
	 */
	protected function getQueryDescription() {
		return 'Get articles which are in the intersection of multiple categories (ie: they belong to ALL of the provided categories).';
	}

	/**
	 * Parameters
	 */
	protected function getParamQueryDescription() {
		return 	array (
			'categories' => 'A pipe delimited list of '
		);
	}
	public function getParamDescription() {
		$desc = array (
			'categories' => 'A pipe delimited list of categories.  The returned articles will only be articles which are in ALL of the provided categories. Must include Category: prefix',
			'prop' => 'What pieces of information to include',
			'namespace' => 'Only include pages in these namespaces',
			'sort' => 'Property to sort by',
			'dir' => 'In which direction to sort',
			'start' => 'Timestamp to start listing from. Can only be used with cmsort=timestamp',
			'end' => 'Timestamp to end listing at. Can only be used with cmsort=timestamp',
			'startsortkey' => 'Sortkey to start listing from. Can only be used with cmsort=sortkey',
			'endsortkey' => 'Sortkey to end listing at. Can only be used with cmsort=sortkey',
			'continue' => 'For large categories, give the value retured from previous query',
			'limit' => 'The maximum number of pages to return.',
		);
		return $desc;
	}

	/**
	 * Allowed parameters
	 */
	//protected function getAllowedQueryParams() {
	public function getAllowedParams() {
		return array (
			'categories' => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			'prop' => array (
				ApiBase :: PARAM_DFLT => 'ids|title',
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => array (
					'ids',
					'title',
					'sortkey',
					'timestamp',
				)
			),
			'namespace' => array (
				ApiBase :: PARAM_ISMULTI => true,
				ApiBase :: PARAM_TYPE => 'namespace',
			),
			'continue' => null,
			'limit' => array (
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'sort' => array(
				ApiBase :: PARAM_DFLT => 'sortkey',
				ApiBase :: PARAM_TYPE => array(
					'sortkey',
					'timestamp'
				)
			),
			'dir' => array(
				ApiBase :: PARAM_DFLT => 'asc',
				ApiBase :: PARAM_TYPE => array(
					'asc',
					'desc'
				)
			),
			'start' => array(
				ApiBase :: PARAM_TYPE => 'timestamp'
			),
			'end' => array(
				ApiBase :: PARAM_TYPE => 'timestamp'
			),
			'startsortkey' => null,
			'endsortkey' => null,
		);
	}

	/**
	 * Examples
	 */
	protected function getQueryExamples() {
		return array (
			'api.php?action=query&list=categoryintersection&categories=Category:Artists_C|Category:Hometown/United_States/California/San_Francisco', // simple result
			'api.php?action=query&list=categoryintersection&categories=Category:Artist|Category:Hometown/United_States/Pennsylvania/Pittsburgh&limit=50', // there are less than 50 results (at the moment)
 			'api.php?action=query&list=categoryintersection&categories=Category:Artist|Category:Hometown/Sweden/Stockholm&limit=100', // there are more than 100 resutls
			'api.php?action=query&list=categoryintersection&categories=Category:Artists_T|Category:Hometown/United_States|Category:Genre/Progressive_Rock&limit=25', // three categories
		);
	}

	/**
	 * Version
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
};
