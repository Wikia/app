<?php
/**
 * Updates infoboxes of Pages with Census data enabled
 *
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @since Nov 2012 | MediaWiki 1.19
 *
 */
require __DIR__ . '/../../../../maintenance/commandLine.inc';
$dbr = wfGetDB( DB_SLAVE );
$namespace = NS_MAIN;
$conds = array(
	'page_namespace' => $namespace
);

$res = $dbr->select( 'page',
	array( 'page_namespace', 'page_title', 'page_is_redirect', 'page_id' ),
	$conds,
	__METHOD__,
	array(
		'ORDER BY'  => 'page_title',
		'USE INDEX' => 'name_title',
	)
);

if( $res->numRows() > 0 ) {
	$cdr = new CensusDataRetrieval(Title::newFromText('thenamedoesntmatter'));
	$i=0;
	while( $s = $res->fetchObject() ) {
		$t = Title::newFromRow( $s );
		$key = array_search(strtolower($t->getDBKey()), $cdr->censusDataArr);
		if ($key) {
			$key = explode('.', $key);
			$i++;
			echo $t->getDBKey()." (".$key[0].")\n";
		}
	}
	echo "Found objects: ".$i."\n";
	echo "Total objects: ".$res->numRows()."\n";
}


exit( 0 );
