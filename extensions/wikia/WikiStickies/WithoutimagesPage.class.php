<?php

class WithoutimagesPage extends QueryPage {

	function getName() { return 'Withoutimages'; }
	function isExpensive() { return true; }
	function isSyndicated() { return false; }

	/**
	 * Note: Getting page_namespace only works if $this->isCached() is false
	 */
	function getSQL() {
		global $wgContentNamespaces;
		return "SELECT 'Withoutimages' AS type,
		       		page_namespace AS namespace,
				page_title AS title,
				COUNT(*) as value
			FROM page
			JOIN pagelinks ON page_title = pl_title AND page_namespace = pl_namespace
			WHERE pl_from > 0 AND page_namespace IN (".implode(",", $wgContentNamespaces).") AND page_is_redirect = 0
			AND (
				( 
					SELECT i1.il_to FROM imagelinks i1 
					WHERE 20 > ANY ( 
						SELECT count(*) FROM imagelinks i2 
						WHERE i1.il_to = i2.il_to 
					) AND i1.il_from = page_id LIMIT 1 
				) IS NULL
			)
			GROUP BY page_title, page_namespace";
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
