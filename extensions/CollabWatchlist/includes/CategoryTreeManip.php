<?php

/**
 * This class is used to build a category tree and manipulate it.
 * It currently supports building the tree from a list of categories.
 * You can then disable categories by id and request a list of
 * enabled categories and subcategories. This is useful for selecting
 * pages by categories and their subcategories without specifying the
 * subcategories.
 * @author fhackenberger
 */
class CategoryTreeManip {
	const CACHE_KEY = 'categorytree';
	const CACHE_KEY_CHILDCATEGORIES = 'childcats';
	const CACHE_KEY_CATEGORYPAGEID = 'catpageid';
	// How long the cache for child categories and category page ids should last
	protected $cacheDurationSec;
	// Whether the cache should be used to speed up building the tree
	// We always fill the cache, though
	protected $cacheEnabled = true;
	// The depth of the tree we are building. -1 means infinite
	// 0 fetches no child categories at all
	protected $maxDepth = -1;
	protected $root;
	public $name;
	public $id;
	// Maps from the page id of a category to instances of this class
	protected $catPageIdToNode = array();
	protected $parents = array();
	protected $enabled = true;
	protected $children = array();

	/**
	 * Constructor
	 */
	function __construct( $id = null, $name = null, $root = null, $parents = array() ) {
		$this->cacheDurationSec = 15 * 60;
		$this->id = $id;
		$this->name = $name;
		if ( !is_null( $root ) ) {
			$this->root = $root;
		} else {
			$this->root = $this;
		}
		$this->parents = $parents;
	}
	
	public function getCacheEnabled() {
		return $this->cacheEnabled;
	}
	
	public function setCacheEnabled( $enabled ) {
		$this->cacheEnabled = $enabled;
	}
	
	public function getMaxDepth() {
		return $this->maxDepth;
	}
	
	public function setMaxDepth( $maxDepth ) {
		$this->maxDepth = $maxDepth;
	}

	private function addChildren( $children ) {
		if ( !is_array( $children ) )
		throw new Exception( 'Argument must be an array' );
		foreach ( $children as $child ) {
			$this->children[$child->id] = $child;
		}
	}

	private function addParents( $parents ) {
		if ( !is_array( $parents ) )
		throw new Exception( 'Argument must be an array' );
		foreach ( $parents as $parent ) {
			$this->parents[$parent->id] = $parent;
		}
	}

	/** Disable this category node and all subcategory nodes
	 * @return
	 */
	public function disable() {
		$this->recursiveDisable();
	}

	/** Disable the given categories (by id) and all their subcategories
	 *
	 * @param array $catPageIds The page ids of the categories to disable
	 */
	public function disableCategoryIds( $catPageIds ) {
		foreach ( $catPageIds as $catId ) {
			$node = $this->getNodeForCatPageId( $catId );
			if ( isset( $node ) ) {
				$node->disable();
			}
		}
	}

	private function recursiveDisable( $visitedNodeIds = array() ) {
		if ( !$this->enabled || array_key_exists( $this->id, $visitedNodeIds ) )
		return; # Break the recursion
		$this->enabled = false;
		$visitedNodeIds[] = $this->id;
		foreach ( $this->children as $cat ) {
			$cat->recursiveDisable( $visitedNodeIds );
		}
	}

	/** Returns a list of enables category names, including
	 * all subcategories.
	 *
	 * @return array An array of category names
	 */
	public function getEnabledCategoryNames() {
		$enabledNodes = $this->getEnabledNodeMap();
		$enabledCategories = array();
		foreach ( $enabledNodes as $nodeId => $node ) {
			$enabledCategories[] = $node->name;
		}
		return $enabledCategories;
	}

	/** Returns a map of enabled categories, including
	 * all subcategories.
	 *
	 * @return array An array mapping from category page ids to CategoryTreeManip objects
	 */
	public function getEnabledNodeMap() {
		return $this->root->recursiveGetEnabledNodeMap();
	}

	private function recursiveGetEnabledNodeMap( &$foundNodes = array() ) {
		if ( isset( $this->id ) ) {
			if ( !$this->enabled || array_key_exists( $this->id, $foundNodes ) )
			return $foundNodes; # Break the recursion
			$foundNodes[$this->id] = $this;
		}
		foreach ( $this->children as $cat ) {
			$cat->recursiveGetEnabledNodeMap( $foundNodes );
		}
		return $foundNodes;
	}

	/** Returns a CategoryTreeManip node, given a category page id
	 *
	 * @param $catPageId The page id of the category to retrieve
	 * @return CategoryTreeManip The node
	 */
	public function getNodeForCatPageId( $catPageId ) {
		if ( array_key_exists( $catPageId, $this->root->catPageIdToNode ) )
		return $this->root->catPageIdToNode[$catPageId];
	}

	private function addNode( $node ) {
		$this->root->catPageIdToNode[$node->id] = $node;
	}
	
	public function printTree() {
		print "all categories:\n";
		foreach( $this->catPageIdToNode as $catPageId => $node ) {
			print $catPageId . ": " . $node->name . " enabled: " . $node->enabled . "\n";
		}
		print "child categories:\n";
		$this->printTreeRecursive( $this->root, '' );
	}
	
	protected function printTreeRecursive( $node, $prefix ) {
		if( $node->id ) {
			print $prefix . $node->id . ": " . $node->name . " enabled: " . $node->enabled . "\n";
		}
		foreach( $node->children as $child ) {
			$this->printTreeRecursive( $child, $prefix . "  " );
		}
	}

	/** Build the category tree, given a list of category names.
	 * All categories and subcategories are enabled by default.
	 *
	 * @param array $catNames An array of strings representing category names (without namespace prefix)
	 * @return
	 */
	public function initialiseFromCategoryNames( $catNames ) {
		$currDepth = 0;
		// This method builds the category tree breadth-first in an
		// iterative fashion.
		while ( $catNames ) {
			if($this->maxDepth > 0 && $currDepth > $this->maxDepth)
				break;
			// Get a list of child categories (array of hashmaps)
			$res = $this->getChildCategories( $catNames );
			// Maps parent category name -> array ( array ( child id , child name ) )
			$parentList = array();
			// Maps child category id -> array( child id, array ( parent name, ... ) )
			$childList = array();
			// Build $parentList and $childList
			foreach ( $res as $row ) {
				$parentList[$row['parName']][] = array( $row['childId'], $row['childName'] );
				if ( array_key_exists( $row['childId'], $childList ) ) {
					$childEntry = $childList[$row['childId']];
					$childEntry[1][] = $row['parName'];
				} else {
					$childList[$row['childId']] = array( $row['childName'], array( $row['parName'] ) );
				}
			}

			// Fetch the page ids of the $catNames and build the node objects for them
			if ( !isset( $parentNameToNode ) && !empty( $parentList ) ) {
				$res = $this->getCategoryPageIds( array_keys( $parentList ) );
				$parentNameToNode = array();
				foreach ( $res as $row ) {
					$node = $this->getNodeForCatPageId( $row['page_id'] );
					if ( !isset( $node ) ) {
						$node = new CategoryTreeManip( $row['page_id'], $row['page_title'], $this->root );
						$this->addNode( $node );
						$this->addChildren( array( $node ) );
					}
					$parentNameToNode[$row['page_title']] = $node;
				}
			}

			$newChildNameToNode = array();
			// Create and add the new node objects for all child categories
			foreach ( $childList as $childPageId => $childInfo ) {
				$childNode = $this->getNodeForCatPageId( $childPageId );
				if ( !isset( $childNode ) ) {
					$childNode = new CategoryTreeManip( $childPageId, $childInfo[0], $this->root );
					$this->addNode( $childNode );
					$newChildNameToNode[$childInfo[0]] = $childNode;
				}
				foreach ( $childInfo[1] as $parentName ) {
					$parent = $parentNameToNode[$parentName];
					$parent->addChildren( array( $childNode ) );
					$childNode->addParents( array( $parent ) );
				}
			}

			// Prepare for the next loop
			$parentNameToNode = $newChildNameToNode;
			$catNames = array_keys( $parentNameToNode );
			$currDepth++;
		}
	}
	
	/** Retrieve a list of child categories for all the given category names
	 * Uses the cache if enabled
	 * @param $catNames Array: List of category names
	 * @return Mixed: Array of Maps with keys: parName, childId, childName
	 */
	protected function getChildCategories( $catNames ) {
		global $wgMemc;
		$childList = array();
		$nonCachedCatNames = array();
		// Try cache first
		if( $this->cacheEnabled ) {
			foreach( $catNames as $catName ) {
				$key = wfMemcKey( self::CACHE_KEY, self::CACHE_KEY_CHILDCATEGORIES, $catName );
				$res = $wgMemc->get( $key );
				if( $res != '' ) {
					$childList = array_merge( $childList, $res );
				} else {
					$nonCachedCatNames[$catName] = false;
				}
			}
		} else {
			$nonCachedCatNames = array_fill_keys( $catNames, false );
		}

		// Select the child categories of all categories we have not found in the cache
		$res = array();
		if( !empty( $nonCachedCatNames ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			// Select the direct child categories of all category names
			// I.e. category name, child category id and child category name
			// select cp.page_title AS parName, cl.cl_from AS childId, p.page_title AS childName 
			// from page cp join categorylinks cl on cp.page_title = cl.cl_to
			// join page p on p.page_id = cl.cl_from where p.page_namespace = '14';
			$res = $dbr->select( array( 'cp' => 'page', 'cl' => 'categorylinks', 'p' => 'page' ), # Tables
				array( 'cp.page_title AS parName', 'cl.cl_from AS childId', 'p.page_title AS childName' ), # Fields
				array( 'cp.page_title' => array_keys($nonCachedCatNames), 'cp.page_namespace' => NS_CATEGORY ),  # Conditions
				__METHOD__, array( 'GROUP BY' => 'cl_to' ), # Options
				array( 'cl' => array( 'JOIN', 'cp.page_title = cl.cl_to' ), 'p' => array( 'JOIN', 'p.page_id = cl.cl_from') ) # Join conditions
			);
		}
		
		// Prepare and store cache objects
		$cacheObj = array();
		foreach ( $res as $row ) {
			unset($nonCachedCatNames[$row->parName]);
			if( !isset( $currCatName ) )
				$currCatName = $row->parName;
			if( $currCatName != $row->parName ) {
				$key = wfMemcKey( self::CACHE_KEY, self::CACHE_KEY_CHILDCATEGORIES, $currCatName );
				$wgMemc->set( $key, $cacheObj, $this->cacheDurationSec );
				$childList = array_merge( $childList, $cacheObj );
				$cacheObj = array();
				$currCatName = $row->parName;
			}
			$cacheObj[] = array( 'parName' => $row->parName, 'childId' => $row->childId, 'childName' => $row->childName );
		}
		// Store the last bunch
		if( !empty( $cacheObj ) ) {
			$key = wfMemcKey( self::CACHE_KEY, self::CACHE_KEY_CHILDCATEGORIES, $currCatName );
			$wgMemc->set( $key, $cacheObj, $this->cacheDurationSec );
			$childList = array_merge( $childList, $cacheObj );
		}
		// Store empty values for leaf categories, otherwise we would query the DB because we did not find a cache entry
		foreach( array_keys($nonCachedCatNames ) as $currCatName ) {
			$key = wfMemcKey( self::CACHE_KEY, self::CACHE_KEY_CHILDCATEGORIES, $currCatName );
			$wgMemc->set( $key, array(), $this->cacheDurationSec );
		}
		return $childList;
	}
	
	/** Retrieve the page ids of the category pages for the given categories
	 * 
	 * @param $catNames Array: A list of category names you would like to query for
	 * @return Array: An array of maps with keys: page_id, page_title
	 */
	protected function getCategoryPageIds( $catNames ) {
		global $wgMemc;
		$pageInfo = array();
		$nonCachedCatNames = array();
		// Try cache first
		if( $this->cacheEnabled ) {
			foreach( $catNames as $catName ) {
				$res = $wgMemc->get( wfMemcKey( self::CACHE_KEY, self::CACHE_KEY_CATEGORYPAGEID, $catName ) );
				if( $res != '' ) {
					$pageInfo[] = array( 'page_id' => $res, 'page_title' => $catName );
				} else {
					$nonCachedCatNames[] = $catName;
				}
			}
		}
		// Select the child categories of all categories we have not found in the cache
		$res = array();
		if( !empty( $nonCachedCatNames ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( array( 'page' ), # Tables
				array( 'page_id, page_title' ), # Fields
				array( 'page_title' => $nonCachedCatNames )  # Conditions
			);
		}
		// Prepare and store cache object
		foreach ( $res as $row ) {
			$pageInfo[] = array( 'page_id' => $row->page_id, 'page_title' => $row->page_title );
			$wgMemc->set( wfMemcKey( self::CACHE_KEY, self::CACHE_KEY_CATEGORYPAGEID, $row->page_title ), $row->page_id, $this->cacheDurationSec );
		}
		return $pageInfo;
	}

}
