<?php

class WithoutimagesPage extends QueryPage {

	function getName() { return 'Withoutimages'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	/**
	 * Note: Getting page_namespace only works if $this->isCached() is false
	 */
	function getQueryInfo() {
		return array(
			'tables' => array( 'page', 'pagelinks' ),
			'fields' => array( "'Withoutimages' as type", 'page_namespace as namespace', 'page_title as title', 'count(*) as value' ),
			'options' => array( 'GROUP BY' => 'page_title, page_namespace' ),
			'join_conds' => array(
				'pagelinks' => array( 'JOIN', 'page_title = pl_title AND page_namespace = pl_namespace' )
			),
			'conds' => array( 
				'pl_from > 0',
				'page_namespace' => MWNamespace::getContentNamespaces(),
				'page_is_redirect' => 0,
				'( 
					( 
						SELECT i1.il_to 
						FROM imagelinks i1 
						WHERE 20 > ANY ( 
							SELECT count(*) 
							FROM imagelinks i2 
							WHERE i1.il_to = i2.il_to 
						) AND i1.il_from = page_id 
						LIMIT 1 
					) IS NULL 
				)'
			)
		);
	}

	/**
	 * Pre-fill the link cache
	 */
	function preprocessResults( $db, $res ) {
		if( $db->numRows( $res ) > 0 ) {
			$linkBatch = new LinkBatch();
			while( $row = $db->fetchObject( $res ) )
				$linkBatch->add( $row->namespace, $row->title );
			$db->dataSeek( $res, 0 );
			$linkBatch->execute();
		}
	}

	/**
	 * Make links to the page corresponding to the item
	 *
	 * @param $skin Skin to be used
	 * @param $result Result row
	 * @return string
	 */
	function formatResult( $skin, $result ) {
		global $wgLang;
		$title = Title::makeTitleSafe( $result->namespace, $result->title );
		$link = $skin->makeLinkObj( $title );
		return wfSpecialList( $link, '' );
	}

}
