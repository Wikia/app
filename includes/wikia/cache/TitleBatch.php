<?php

/**
 * Class provides an easy interface to preload requested data
 * in the given collection of Title objects
 * doing it in a batch in a single db query
 *
 * @author Władysław Bodzek
 */
class TitleBatch {

	protected $titles = array();
	protected $articleIds = false;
	protected $restrictionsLoaded = false;

	/**
	 * Creates a new TitleBatch object
	 *
	 * @param $titles array List of Title objects or title texts
	 */
	public function __construct( $titles ) {
		foreach ($titles as $k => $title) {
			if ( $title instanceof Title ) {
				// nothing to do...
			} elseif ( is_string($title) ) {
				$titles[$k] = Title::newFromText($title);
			} else {
				wfDebug( "Warning: TitleBatch::__construct got invalid title object/text\n" );
			}
		}
		$this->titles = $titles;
	}

	/**
	 * Get a list of article ids for titles that exist
	 *
	 * @return array List of article ids
	 */
	protected function getArticleIds() {
		wfProfileIn( __METHOD__ );
		if ( $this->articleIds === false ) {
			wfProfileIn( __METHOD__ . '::CacheMiss' );
			$ids = array();
			foreach ($this->titles as $title) {
				$id = $title->getArticleID();
				if ( $id > 0 ) {
					$ids[] = $id;
				}
			}
			$this->articleIds = $ids;
			wfProfileOut( __METHOD__ . '::CacheMiss' );
		}
		wfProfileOut( __METHOD__ );

		return $this->articleIds;
	}

	/**
	 * Prefetch information about page restrictions and feed
	 * that into the Title objects
	 *
	 * @return TitleBatch Provides fluent interface
	 */
	public function loadRestrictions() {
		wfProfileIn( __METHOD__ );
		if ( !$this->restrictionsLoaded ) {
			wfProfileIn( __METHOD__ . '::CacheMiss' );
			$articleIds = $this->getArticleIds();

			$dbr = wfGetDB( DB_SLAVE );

			// load rows from page_restrictions
			$res = $dbr->select(
				'page_restrictions',
				'*',
				array( 'pr_page' => $articleIds ),
				__METHOD__
			);
			$byArticle = array();
			foreach ($res as $row) {
				$id = $row->pr_page;
				if ( !isset($byArticle[$id]) ) {
					$byArticle[$id] = array();
				}
				$byArticle[$id][] = $row;
			}
			$res->free();

			// load rows from page.page_restriction
			$res = $dbr->select(
				'page',
				array( 'page_id', 'page_restrictions' ),
				array( 'page_id' => $articleIds ),
				__METHOD__
			);
			$oldFashioned = array();
			foreach ($res as $row) {
				$oldFashioned[$row->page_id] = (string)$row->page_restrictions;
			}
			$res->free();

			// feed fetched data to Title objects
			foreach ($this->titles as $title) {
				$id = $title->getArticleID();
				$restrictions = isset($byArticle[$id]) ? $byArticle[$id] : array();
				$old = isset($oldFashioned[$id]) ? $oldFashioned[$id] : '';
				$title->loadRestrictionsFromRows($restrictions,$old);
			}
			wfProfileOut( __METHOD__ . '::CacheMiss' );
		}
		wfProfileOut( __METHOD__ );

		return $this;
	}

	/**
	 * Get the collection of Title objects
	 *
	 * @return array List of Title objects
	 */
	public function getAll() {
		return $this->titles;
	}

}