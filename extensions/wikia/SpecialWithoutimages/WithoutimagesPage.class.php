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
			'tables' => [ 'page' ],
			'fields' => [ "'Withoutimages' as type", 'page_namespace as namespace', 'page_title as title', 'count(*) as value' ],
			'options' => [ 'GROUP BY' => 'page_title, page_namespace' ],
			// Note that querycache table contains rows with qc_type equal to MostimagesInContent only when given image
			// is included in more than one article, that is why the condition is in form of `il_to not in ...`
			// and then `qc_value >= 20`
			'conds' => [
				'page_id > 0',
				'page_namespace' => MWNamespace::getContentNamespaces(),
				'page_is_redirect' => 0,
				"page_id NOT IN (
				    SELECT DISTINCT il_from
				    FROM imagelinks
				    WHERE il_to not in (
				      SELECT qc_title
				      FROM querycache
				      WHERE qc_type = 'MostimagesInContent'
				        AND qc_value >= 20
				    )
				)"
			]
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
