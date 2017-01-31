<?php

class FindWikiForumActivity {
	public static function run( DatabaseBase $db, $verbose = false, $test = false, $params = [] ) {
		//echo "Default code : Running ".__METHOD__."\n";
		$sql = "
SELECT IF(page_namespace=110,'wf', 'tf') AS type, MAX(page_touched) AS updated
FROM page
WHERE page_namespace IN (110, 2001, 2002)
GROUP BY type";
		$result = $db->query( $sql, __METHOD__ );

		$stats = [
			"wf" => 0,
		    "tf" => 0,
		];
		while ( $row = $db->fetchObject( $result ) ) {
			$stats[$row->type] = $row->updated;
		}

		echo implode( "\t",[ $params["cityId"], $stats["wf"], $stats["tf"] ] )
		     ."\n";
	}
}