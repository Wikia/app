<?php

/**
 * this class provides basic information about all the walls existing in system
 */

class Walls extends WikiaModel {

	/**
	 * Get list of existing board IDs
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 *
	 * @return array List of board IDs
	 */
	public function getList( $db = DB_SLAVE, $namespace = NS_USER_WALL ) {
		wfProfileIn( __METHOD__ );

		$titles = $this->getListTitles( $db, $namespace );

		$boards = array();
		/** @var $title Title */
		foreach ( $titles as $title ) {
			$boards[] = $title->getArticleID();
		}

		wfProfileOut( __METHOD__ );

		return $boards;
	}

	/**
	 * Get list of Title objects representing existing boards
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 *
	 * @return array List of board IDs
	 */
	public function getListTitles( $db = DB_SLAVE, $namespace = NS_USER_WALL ) {
		wfProfileIn( __METHOD__ );

		$titles = TitleBatch::newFromConds( 'page_wikia_props', array(
				'page.page_namespace' => $namespace,
				'page_wikia_props.page_id = page.page_id'
			),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' ),
			$db
		);

		wfProfileOut( __METHOD__ );

		return $titles;
	}

}
