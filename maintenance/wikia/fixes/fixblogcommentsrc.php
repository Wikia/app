<?php

ini_set( "include_path", dirname(__FILE__)."/../../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "fix blog comments" );
}

$help = isset($options['help']);
$dry = isset($options['dry']) ? $options['dry'] : "";

$method = 'fixBlogCommentsRC';

function fixAllBlogCommentsRC( $dry ) {
	global $method, $wgExternalDatawareDB, $wgCityId;

	# select rc_title from recentchanges where rc_namespace = 501 and ( rc_title not rlike '.+[0-9]+$' or rc_title not like '%@comment%' );

	$dbw = wfGetDB( DB_MASTER );
	$res = $dbw->select(
		array( 'recentchanges' ),
		array( 'rc_id, rc_title, rc_namespace'),
		array(
			'rc_namespace' => NS_BLOG_ARTICLE_TALK,
			"( rc_title not rlike '.+[0-9]+$' or rc_title not like '%@comment%' )"
		),
		$method
	);

	$pages = array();
	while( $row = $dbw->fetchRow($res) ) {
		$pages[] = $row;
	}
	$dbw->freeResult( $res );

	print sprintf("Found %0d pages \n", count( $pages ) );

	if( !empty($pages) ) {
		foreach ( $pages as $row ) {
			print "parse {$row['rc_title']}\n";

			$parts = ArticleComment::explode( $row[ 'rc_title' ] );
			if( $parts['blog'] == 1 && count( $parts['partsOriginal'] ) > 0 ) {
				$parts['parsed'] = array();
				foreach ( $parts['partsOriginal'] as $id => $title ) {
					$parts['parsed'][$id] = sprintf('%s-%s', '@comment', $title );
				}

				$newTitle = sprintf('%s/%s', $parts['title'], implode( "/", $parts['parsed']) );

				if( $dry ) {
					printf(
						"update recentchanges set rc_title = '%s' where rc_id = %d and rc_namespace = %d\n",
						$newTitle,
						$row['rc_id'],
						NS_BLOG_ARTICLE_TALK
					);
				}
				else {
					$dbw->update(
						'recentchanges',
						array( 'rc_title' => $newTitle ),
						array( 'rc_id' => $row['rc_id'], 'rc_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}
			}
		}
	}
}


if ( $help ) {
	echo <<<TEXT
Usage:
    php fixblogcomments.php --help
    php fixblogcomments.php --parse=CITY_ID --dry

    --help         : This help message
    --dry		   : generate SQL commands (do not update in database)
TEXT;
	exit(0);
}
else {
	fixAllBlogCommentsRC( $dry );
}
