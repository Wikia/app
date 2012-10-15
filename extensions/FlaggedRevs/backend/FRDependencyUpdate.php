<?php
/**
 * Class containing update methods for tracking links that
 * are only in the stable version of pages. Used only for caching.
 */
class FRDependencyUpdate {
	protected $title;
	protected $sLinks;
	protected $sTemplates;
	protected $sImages;
	protected $sCategories;
	protected $dbw;

	public function __construct( Title $title, ParserOutput $stableOutput ) {
		$this->title = $title;
		# Stable version links
		$this->sLinks = $stableOutput->getLinks();
		$this->sTemplates = $stableOutput->getTemplates();
		$this->sImages = $stableOutput->getImages();
		$this->sCategories = $stableOutput->getCategories();
	}

	public function doUpdate() {
		$deps = array();
		# Get any links that are only in the stable version...
		$cLinks = $this->getCurrentVersionLinks();
		foreach ( $this->sLinks as $ns => $titles ) {
			foreach ( $titles as $title => $pageId ) {
				if ( !isset( $cLinks[$ns][$title] ) ) {
					self::addDependency( $deps, $ns, $title );
				}
			}
		}
		# Get any images that are only in the stable version...
		$cImages = $this->getCurrentVersionImages();
		foreach ( $this->sImages as $image => $n ) {
			if ( !isset( $cImages[$image] ) ) {
				self::addDependency( $deps, NS_FILE, $image );
			}
		}
		# Get any templates that are only in the stable version...
		$cTemplates = $this->getCurrentVersionTemplates();
		foreach ( $this->sTemplates as $ns => $titles ) {
			foreach ( $titles as $title => $id ) {
				if ( !isset( $cTemplates[$ns][$title] ) ) {
					self::addDependency( $deps, $ns, $title );
				}
			}
		}
		# Get any categories that are only in the stable version...
		$cCategories = $this->getCurrentVersionCategories();
		foreach ( $this->sCategories as $category => $sort ) {
			if ( !isset( $cCategories[$category] ) ) {
				self::addDependency( $deps, NS_CATEGORY, $category );
			}
		}
		# Get any dependency tracking changes
		$existing = $this->getExistingDeps();
		# Do incremental updates...
		if ( $existing != $deps ) {
			$existing = $this->getExistingDeps( FR_MASTER );
			$insertions = $this->getDepInsertions( $existing, $deps );
			$deletions = $this->getDepDeletions( $existing, $deps );
			$dbw = wfGetDB( DB_MASTER );
			# Delete removed links
			if ( $deletions ) {
				$dbw->delete( 'flaggedrevs_tracking', $deletions, __METHOD__ );
			}
			# Add any new links
			if ( $insertions ) {
				$dbw->insert( 'flaggedrevs_tracking', $insertions, __METHOD__, 'IGNORE' );
			}
		}
	}

	/*
	 * Get existing cache dependancies
	 * @param int $flags FR_MASTER
	 * @return array (ns => dbKey => 1)
	 */
	protected function getExistingDeps( $flags = 0 ) {
		$db = ( $flags & FR_MASTER ) ?
			wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		$res = $db->select( 'flaggedrevs_tracking',
			array( 'ftr_namespace', 'ftr_title' ),
			array( 'ftr_from' => $this->title->getArticleId() ),
			__METHOD__
		);
		$arr = array();
		foreach( $res as $row ) {
			if ( !isset( $arr[$row->ftr_namespace] ) ) {
				$arr[$row->ftr_namespace] = array();
			}
			$arr[$row->ftr_namespace][$row->ftr_title] = 1;
		}
		return $arr;
	}

	/*
	 * Get INSERT rows for cache dependancies in $new but not in $existing
	 * @return array
	 */
	protected function getDepInsertions( array $existing, array $new ) {
		$arr = array();
		foreach ( $new as $ns => $dbkeys ) {
			if ( isset( $existing[$ns] ) ) {
				$diffs = array_diff_key( $dbkeys, $existing[$ns] );
			} else {
				$diffs = $dbkeys;
			}
			foreach ( $diffs as $dbk => $id ) {
				$arr[] = array(
					'ftr_from'      => $this->title->getArticleId(),
					'ftr_namespace' => $ns,
					'ftr_title'     => $dbk
				);
			}
		}
		return $arr;
	}

	/*
	 * Get WHERE clause to delete items in $existing but not in $new
	 * @return mixed (array/false)
	 */
	protected function getDepDeletions( array $existing, array $new ) {
		$del = array();
		foreach ( $existing as $ns => $dbkeys ) {
			if ( isset( $new[$ns] ) ) {
				$del[$ns] = array_diff_key( $existing[$ns], $new[$ns] );
			} else {
				$del[$ns] = $existing[$ns];
			}
		}
		if ( $del ) {
			$clause = self::makeWhereFrom2d( $del, wfGetDB( DB_MASTER ) );
			if ( $clause ) {
				return array( $clause, 'ftr_from' => $this->title->getArticleId() );
			}
		}
		return false;
	}

	// Make WHERE clause to match $arr titles
	protected static function makeWhereFrom2d( &$arr, $db ) {
		$lb = new LinkBatch();
		$lb->setArray( $arr );
		return $lb->constructSet( 'ftr', $db );
	}

	protected static function addDependency( array &$deps, $ns, $dbKey ) {
		if ( !isset( $deps[$ns] ) ) {
			$deps[$ns] = array();
		}
		$deps[$ns][$dbKey] = 1;
	}

	/**
	 * Get an array of existing links, as a 2-D array
	 * @return array (ns => dbKey => 1)
	 */
	protected function getCurrentVersionLinks() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'pagelinks',
			array( 'pl_namespace', 'pl_title' ),
			array( 'pl_from' => $this->title->getArticleId() ),
			__METHOD__
		);
		$arr = array();
		foreach( $res as $row ) {
			if ( !isset( $arr[$row->pl_namespace] ) ) {
				$arr[$row->pl_namespace] = array();
			}
			$arr[$row->pl_namespace][$row->pl_title] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing templates, as a 2-D array
	 * @return array (ns => dbKey => 1)
	 */
	protected function getCurrentVersionTemplates() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'templatelinks',
			array( 'tl_namespace', 'tl_title' ),
			array( 'tl_from' => $this->title->getArticleId() ),
			__METHOD__
		);
		$arr = array();
		foreach( $res as $row ) {
			if ( !isset( $arr[$row->tl_namespace] ) ) {
				$arr[$row->tl_namespace] = array();
			}
			$arr[$row->tl_namespace][$row->tl_title] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing images, image names in the keys
	 * @return array (dbKey => 1)
	 */
	protected function getCurrentVersionImages() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'imagelinks',
			array( 'il_to' ),
			array( 'il_from' => $this->title->getArticleId() ),
			__METHOD__
		);
		$arr = array();
		foreach( $res as $row ) {
			$arr[$row->il_to] = 1;
		}
		return $arr;
	}

	/**
	 * Get an array of existing categories, with the name in the key and sort key in the value.
	 * @return array (category => sortkey)
	 */
	protected function getCurrentVersionCategories() {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'categorylinks',
			array( 'cl_to', 'cl_sortkey' ),
			array( 'cl_from' => $this->title->getArticleId() ),
			__METHOD__
		);
		$arr = array();
		foreach( $res as $row ) {
			$arr[$row->cl_to] = $row->cl_sortkey;
		}
		return $arr;
	}
}
