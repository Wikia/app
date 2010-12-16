<?php

require( dirname(__FILE__).'/../cli.inc' );

$voters = array();
$batchSize = 1000;
$wikis = $wgLocalDatabases;

foreach ( $wikis as $wikiId ) {
	$lb = wfGetLB( $wikiId );
	$db = $lb->getConnection( DB_SLAVE, array(), $wikiId );

	if ( !$db->tableExists( 'securepoll_lists' ) ) {
		$lb->reuseConnection( $db );
		continue;
	}

	$wikiName = WikiMap::getWikiName( $wikiId );
	$userId = 0;
	while ( true ) {
		$res = $db->select(
			array( 'securepoll_lists', 'user' ),
			array( 'user_id', 'user_name', 'user_email', 'user_email_authenticated' ),
			array( 
				'user_id=li_member',
				'li_member > ' . $db->addQuotes( $userId )
			),
			__METHOD__,
			array( 'ORDER BY' => 'li_member', 'LIMIT' => $batchSize )
		);
		if ( !$res->numRows() ) {
			break;
		}
		foreach ( $res as $row ) {
			$userId = $row->user_id;
			if ( !$row->user_email || !$row->user_email_authenticated ) {
				continue;
			}
			if ( isset( $voters[$row->user_email] ) ) {
				$voters[$row->user_email]['wikis'] .= ', ' . $wikiName;
			} else {
				$voters[$row->user_email] = array(
					'wikis' => $wikiName,
					'name' => $row->user_name
				);
			}
		}
		fwrite( STDERR, "Found " . count( $voters ) . " voters with email addresses\n" );
	}
	$lb->reuseConnection( $db );
}

foreach ( $voters as $email => $info ) {
	echo "{$info['name']} <$email>\n";
}

