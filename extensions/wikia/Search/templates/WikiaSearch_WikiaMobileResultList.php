<?php
if ( count( $results ) ) {
    $pos = 0;
    foreach( $results as $result ){
        $pos++;

		$props = array(
			'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
			'query' => $query,
			'isInterWiki' => $isInterWiki,
			'relevancyFunctionId' => $relevancyFunctionId
		);

        if($result instanceof WikiaSearchResultSet) {
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
