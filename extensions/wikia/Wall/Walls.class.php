<?php

/**
 * this class provieds basic information about all the walls existing in system
 */

class Walls extends WikiaModel {
	/**
	 * get list of board
	 * @return array boards
	 */
	public function getList( $db = DB_SLAVE, $namespace = NS_USER_WALL ) {
		$this->wf->profileIn( __METHOD__ );

		$dbw = $this->wf->GetDB( $db );

		$titles = TitleBatch::newFromConds('page_wikia_props',array(
				'page.page_namespace' => $namespace,
				'page_wikia_props.page_id = page.page_id'
			),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);

		$boards = array();
		/** @var $title Title */
		foreach ($titles as $title) {
			$boards[] = $title->getArticleID();
		}

		$this->wf->profileOut( __METHOD__ );

		return $boards;
	}
}
