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
	 * @param int $db
	 * @param int $namespace
	 * @return array List of board IDs
	 */
	public function getList( $db = DB_SLAVE, $namespace = NS_USER_WALL ) {
		wfProfileIn( __METHOD__ );

		/** @var TitleBatch $titleBatch */
		$titleBatch = $this->getTitlesForNamespace( $db, $namespace );

		wfProfileOut( __METHOD__ );

		return $titleBatch->getArticleIds();
	}

	/**
	 * Get list of Title objects representing existing boards
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 *
	 * @param int $db
	 * @param int $namespace
	 * @return TitleBatch $titleBatch List of board IDs
	 */
	public function getTitlesForNamespace( $db = DB_SLAVE, $namespace = NS_USER_WALL ) {
		wfProfileIn( __METHOD__ );

		/** @var TitleBatch $titleBatch */
		$titleBatch = TitleBatch::newFromConds( 'page_wikia_props', [
				'page.page_namespace' => $namespace,
				'page_wikia_props.page_id = page.page_id'
		],
			__METHOD__,
			[ 'ORDER BY' => 'page_title' ],
			$db
		);

		wfProfileOut( __METHOD__ );

		return $titleBatch;
	}

}
