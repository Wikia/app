<?php
/**
 * @addtogroup Maintenance
 * @author Roan Kattouw
 */

define( 'REPORTING_INTERVAL', 1000 );

function populateCategorySearch( $begin, $maxlag, $throttle, $force ) {
	$dbw = wfGetDB( DB_MASTER );

	if( !$force ) {
		$row = $dbw->selectRow(
			'updatelog',
			'1',
			array( 'ul_key' => 'populate categorysearch' ),
			__FUNCTION__
		);
		if( $row ) {
			echo "Categorysearch table already populated.  Use php ".
			"maintenance/populateCategorySearch.php\n--force from the command line ".
			"to override.\n";
			return true;
		}
	}

	$maxlag = intval( $maxlag );
	$throttle = intval( $throttle );
	$force = (bool)$force;
	if( $begin !== '' ) {
		$where = 'page_id > '.$dbw->addQuotes( $begin );
	} else {
		$where = null;
	}
	$i = 0;

	while(true) {
		# Get the next page ID
		$row = $dbw->selectRow(
			'page',
			'page_id',
			$where,
			__FUNCTION__,
			array('ORDER BY' => 'page_id')
		);
		if(!$row)
			# We're done
			break;
		$pageid = intval($row->page_id);
		$where = 'page_id > ' . $pageid;
		
		# Get all categories this page is in
		$res = $dbw->select(
			'categorylinks',
			'cl_to',
			array('cl_from' => $pageid),
			__FUNCTION__
		);
		$categories = array();
		while(($row = $dbw->fetchObject($res)))
			$categories[] = $row->cl_to;
		$ctext = implode(' ', $categories);
		AdvancedSearchCategoryIntersector::update($pageid, $categories);
		$i++;
		if(!($i % REPORTING_INTERVAL))
		{
			echo "$pageid\n";
			wfWaitForSlaves($maxlag);
		}
		usleep($throttle*1000);
	}

	if( $dbw->insert(
			'updatelog',
			array( 'ul_key' => 'populate categorysearch' ),
			__FUNCTION__,
			'IGNORE'
		)
	) {
		echo "Categorysearch population complete.\n";
		return true;
	} else {
		echo "Could not insert categorysearch population row.\n";
		return false;
	}
}
