<?php

class GlobalUsage {
	private $interwiki;
	private $db;

	/**
	 * Construct a GlobalUsage instance for a certain wiki.
	 *
	 * @param $interwiki string Interwiki prefix of the wiki
	 * @param $db mixed Database object
	 */
	public function __construct( $interwiki, $db ) {
		$this->interwiki = $interwiki;
		$this->db = $db;
	}

	/**
	 * Sets the images used by a certain page
	 *
	 * @param $title Title Title of the page
	 * @param $images array Array of db keys of images used
	 */
	public function insertLinks( $title, $images, $pageIdFlags = GAID_FOR_UPDATE ) {
		$insert = array();
		foreach ( $images as $name ) {
			$insert[] = array(
				'gil_wiki' => $this->interwiki,
				'gil_page' => $title->getArticleID( $pageIdFlags ),
				'gil_page_namespace_id' => $title->getNamespace(),
				'gil_page_namespace' => $title->getNsText(),
				'gil_page_title' => $title->getDBkey(),
				'gil_to' => $name
			);
		}
		$this->db->insert( 'globalimagelinks', $insert, __METHOD__ );
	}
	/**
	 * Get all global images from a certain page
	 */
	public function getLinksFromPage( $id ) {
		$res = $this->db->select( 
				'globalimagelinks', 
				'gil_to', 
				array(
					'gil_wiki' => $this->interwiki,
					'gil_page' => $id,
				),
				__METHOD__ 
		);
		
		$images = array();
		foreach ( $res as $row )
			$images[] = $row->gil_to;
		return $images;
	}
	/**
	 * Deletes all entries from a certain page to certain files
	 *
	 * @param $id int Page id of the page
	 * @param $to mixed File name(s)
	 */
	public function deleteLinksFromPage( $id, $to = null ) {
		$where = array(
				'gil_wiki' => $this->interwiki,
				'gil_page' => $id
		);
		if ( $to ) {
			$where['gil_to'] = $to;
		}
		$this->db->delete( 'globalimagelinks', $where, __METHOD__ );
	}
	/**
	 * Deletes all entries to a certain image
	 *
	 * @param $title Title Title of the file
	 */
	public function deleteLinksToFile( $title ) {
		$this->db->delete(
				'globalimagelinks',
				array(
					'gil_wiki' => $this->interwiki,
					'gil_to' => $title->getDBkey()
				),
				__METHOD__
		);
	}

	/**
	 * Copy local links to global table
	 *
	 * @param $title Title Title of the file to copy entries from.
	 */
	public function copyLocalImagelinks( $title ) {
		global $wgContLang;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
				array( 'imagelinks', 'page' ),
				array( 'il_to', 'page_id', 'page_namespace', 'page_title' ),
				array( 'il_from = page_id', 'il_to' => $title->getDBkey() ),
				__METHOD__
		);
		$insert = array();
		foreach ( $res as $row ) {
			$insert[] = array(
				'gil_wiki' => $this->interwiki,
				'gil_page' => $row->page_id,
				'gil_page_namespace_id' => $row->page_namespace,
				'gil_page_namespace' => $wgContLang->getNsText( $row->page_namespace ),
				'gil_page_title' => $row->page_title,
				'gil_to' => $row->il_to,
			);
		}
		$this->db->insert( 'globalimagelinks', $insert, __METHOD__ );
	}

	/**
	 * Changes the page title
	 * 
	 * @param $id int Page id of the page
	 * @param $title Title New title of the page
	 */
	public function moveTo( $id, $title ) {
		$this->db->update(
				'globalimagelinks',
				array(
					'gil_page_namespace_id' => $title->getNamespace(),
					'gil_page_namespace' => $title->getNsText(),
					'gil_page_title' => $title->getText()
				),
				array(
					'gil_wiki' => $this->interwiki,
					'gil_page' => $id
				),
				__METHOD__
		);
	}
}
