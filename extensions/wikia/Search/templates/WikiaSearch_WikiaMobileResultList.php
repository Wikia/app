<?php
if ( count( $results ) ) {
    $pos = 0;
    foreach( $results as $result ){
        $pos++;

		$props = array(
			'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
			'query' => $query,
			'isInterWiki' => $isInterWiki,
		);

        if($result instanceof \Wikia\Search\ResultSet\Grouping) {
			$props['resultSet'] = $result;
            echo $app->getView( 'WikiaSearch', 'WikiaMobileResultSet', $props);
        }
        else {
			$props['result'] = $result;
			$props['qpos'] = 0;
            echo $app->getView( 'WikiaSearch', 'WikiaMobileResult', $props);
        }
    }
}
