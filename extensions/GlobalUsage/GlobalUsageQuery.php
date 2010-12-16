<?php
/**
 * A helper class to query the globalimagelinks table
 * 
 */
class GlobalUsageQuery {
	private $limit = 50;
	private $offset;
	private $hasMore = false;
	private $filterLocal = false;
	private $result;
	private $continue;
	private $reversed = false;

	/**
	 * @param $target mixed Title or db key, or array of db keys of target(s)
	 */
	public function __construct( $target ) {
		global $wgGlobalUsageDatabase;
		$this->db = wfGetDB( DB_SLAVE, array(), $wgGlobalUsageDatabase );
		if ( $target instanceof Title )
			$this->target = $target->getDBKey();
		else
			$this->target = $target;
		$this->offset = array();

	}

	/**
	 * Set the offset parameter
	 *
	 * @param $offset string offset
	 * @param $reversed bool True if this is the upper offset
	 */
	public function setOffset( $offset, $reversed = null ) {
		if ( !is_null( $reversed ) )
			$this->reversed = $reversed;
		
		if ( !is_array( $offset ) )
			$offset = explode( '|', $offset );

		if ( count( $offset ) == 3 ) {
			$this->offset = $offset;
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Return the offset set by the user
	 *
	 * @return array offset
	 */
	public function getOffsetString() {
		return implode( '|', $this->offset );
	}
	/**
	 * Is the result reversed
	 * 
	 * @return bool
	 */
	public function isReversed() {
		return $this->reversed;
	}
	/**
	 * Returns the string used for continuation
	 * 
	 * @return string
	 * 
	 */
	public function getContinueString() {
		if ( $this->hasMore() )
			return "{$this->lastRow->gil_to}|{$this->lastRow->gil_wiki}|{$this->lastRow->gil_page}";
		else
			return '';
	}

	/**
	 * Set the maximum amount of items to return. Capped at 500.
	 *
	 * @param $limit int The limit
	 */
	public function setLimit( $limit ) {
		$this->limit = min( $limit, 500 );
	}
	/**
	 * Returns the user set limit
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * Set whether to filter out the local usage
	 */
	public function filterLocal( $value = true ) {
		$this->filterLocal = $value;
	}


	/**
	 * Executes the query
	 */
	public function execute() {
		/* Construct a where clause */
		// Add target image(s)
		$where = array( 'gil_to' => $this->target );
		
		if ( $this->filterLocal )
			// Don't show local file usage
			$where[] = 'gil_wiki != ' . $this->db->addQuotes( wfWikiId() );

		// Set the continuation condition
		$order = 'ASC';
		if ( $this->offset ) {
			$qTo = $this->db->addQuotes( $this->offset[0] );
			$qWiki = $this->db->addQuotes( $this->offset[1] );
			$qPage = intval( $this->offset[2] );
			
			// Check which limit we got in order to determine which way to traverse rows
			if ( $this->reversed ) {
				// Reversed traversal; do not include offset row
				$op1 = '<';
				$op2 = '<';
				$order = 'DESC';
			} else {
				// Normal traversal; include offset row
				$op1 = '>';
				$op2 = '>=';
				$order = 'ASC';
			}
			
			$where[] = "(gil_to $op1 $qTo) OR " .
				"(gil_to = $qTo AND gil_wiki $op1 $qWiki) OR " .
				"(gil_to = $qTo AND gil_wiki = $qWiki AND gil_page $op2 $qPage)";
		}

		/* Perform select (Duh.) */
		$res = $this->db->select( 'globalimagelinks',
				array(
					'gil_to',
					'gil_wiki',
					'gil_page',
					'gil_page_namespace',
					'gil_page_title' 
				),
				$where,
				__METHOD__,
				array( 
					'ORDER BY' => "gil_to $order, gil_wiki $order, gil_page $order",
					// Select an extra row to check whether we have more rows available
					'LIMIT' => $this->limit + 1,
				)
		);

		/* Process result */
		// Always return the result in the same order; regardless whether reversed was specified
		// reversed is really only used to determine from which direction the offset is
		$rows = array();
		foreach ( $res as $row )
			$rows[] = $row;
		if ( $this->reversed )
			$rows = array_reverse( $rows );
		
		// Build the result array
		$count = 0;
		$this->hasMore = false;
		$this->result = array();
		foreach ( $rows as $row ) {
			$count++;
			if ( $count > $this->limit ) {
				// We've reached the extra row that indicates that there are more rows
				$this->hasMore = true;
				$this->lastRow = $row;
				break;
			}

			if ( !isset( $this->result[$row->gil_to] ) )
				$this->result[$row->gil_to] = array();
			if ( !isset( $this->result[$row->gil_to][$row->gil_wiki] ) )
				$this->result[$row->gil_to][$row->gil_wiki] = array();

			$this->result[$row->gil_to][$row->gil_wiki][] = array(
				'image'	=> $row->gil_to,
				'id' => $row->gil_page,
				'namespace' => $row->gil_page_namespace,
				'title' => $row->gil_page_title,
				'wiki' => $row->gil_wiki,
			);
		}
	}
	/**
	 * Returns the result set. The result is a 4 dimensional array
	 * (file, wiki, page), whose items are arrays with keys:
	 *   - image: File name 
	 *   - id: Page id
	 *   - namespace: Page namespace text
	 *   - title: Unprefixed page title
	 *   - wiki: Wiki id
	 * 
	 * @return array Result set
	 */
	public function getResult() {
		return $this->result;
	}
	/**
	 * Returns a 3 dimensional array with the result of the first file. Useful
	 * if only one image was queried.
	 * 
	 * For further information see documentation of getResult()
	 * 
	 * @return array Result set
	 */
	public function getSingleImageResult() {
		if ( $this->result )
			return current( $this->result );
		else
			return array();
	}

	/**
	 * Returns whether there are more results
	 *
	 * @return bool
	 */
	public function hasMore() {
		return $this->hasMore;
	}

	/**
	 * Returns the result length
	 * 
	 * @return int
	 */
	public function count() {
		return count( $this->result );
	}
}
