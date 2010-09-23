<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "fix blog comments" );
}

$userName = isset( $options['user'] ) ? $options['user'] : 'Maintenance script';

$help = isset($options['help']);
$wikia = isset($options['wikia']) ? $options['wikia'] : "";
$dry = isset($options['dry']) ? $options['dry'] : "";
$debug = isset($options['debug']) ? $options['debug'] : "";

$method = 'fixBlogComments';

function __parse($comment) {
	$count = 0;
	$titleTextStripped = str_replace('@comment-', '', $comment, $count);
	$partsOriginal = explode('/', $comment);
	$partsStripped = explode('/', $titleTextStripped);

	//count != 0 for article and == 0 for blog
	if ($count) {
		$title = implode('/', array_splice($partsOriginal, 0, -$count));
		array_splice($partsStripped, 0, -$count);
	} else {
		$title = implode('/', array_splice($partsOriginal, 0, 2));
		array_splice($partsStripped, 0, 2);
	}

	$result = array(
		'blog' => 1,
		'title' => $title,
		'partsOriginal' => $partsOriginal,
		'partsStripped' => $partsStripped
	);
	return $result;
}

function __get_page_id($title) {
	$dbw = wfGetDB( DB_SLAVE );
	$row = $dbw->selectRow(
		array( 'page' ),
		array( 'page_id'),
		array(
			'page_namespace' 	=> NS_BLOG_ARTICLE,
			'page_title'		=> $title
		),
		$method
	);	
	
	$page_id = ( isset($row) && is_object($row) ) ? $row->page_id : 0;
	return $page_id;
}

function fixAllBlogComments( $dry ) {
	global $method, $wgExternalDatawareDB, $wgCityId, $wgDBname;

	$dbw = wfGetDB( DB_SLAVE );
	$res = $dbw->select(
		array( 'recentchanges' ),
		array( 'rc_id, rc_title as page_title, rc_namespace as page_namespace'),
		array(
			'rc_namespace' => NS_BLOG_ARTICLE_TALK,
			"( rc_title not rlike '.+[0-9]+$' or rc_title not like '%@comment%' )",
			'rc_timestamp between \'20100915000000\' and \'20100917000000\''
		),
		$method
	);

	$pages = array();
	while ($row = $dbw->fetchRow($res)) {
		$pages[] = $row;
	}
	$dbw->freeResult( $res );

	if ( $debug ) 
		print sprintf("Found %s (%d): %0d pages \n", $wgDBname, $wgCityId, count($pages));

	if( !empty($pages) ) {
		foreach ( $pages as $row ) {
			if ( $debug ) 
				print "parse " . $row['page_title'] . "\n";

			$parts = __parse($row['page_title']);
			
			# check blog exists
			$blog_page_id = __get_page_id( $parts['title'] );
			
			# get page id of blog comment
			$row['page_id'] = __get_page_id( $row['page_title'] );
			
			if ( $parts['blog'] == 1 && count($parts['partsOriginal']) > 0 && $blog_page_id > 0 ) {
				$parts['parsed'] = array();
				foreach ( $parts['partsOriginal'] as $id => $title ) {
					$parts['parsed'][$id] = sprintf('%s-%s', '@comment', $title );
				}

				$newTitle = sprintf('%s/%s', $parts['title'], implode("/", $parts['parsed']) );

				if ( $dry ) {
					 print "update `$wgDBname`.`page` set page_title = '$newTitle' where page_title = '{$row['page_title']}' and page_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
				} else {
					$dbw->update(
						'page',
						array( 'page_title' => $newTitle ),
						array( 'page_title' => $row['page_title'], 'page_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}
				# update job
				if ( $dry ) {
					 print "update `$wgDBname`.`job` set job_title = '$newTitle' where job_title = '{$row['page_title']}' and job_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
				} else {
					$dbw->update(
						'job',
						array( 'job_title' => $newTitle ),
						array( 'job_title' => $row['page_title'], 'job_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}

				if( $dry ) {
					printf(
						"update `$wgDBname`.`recentchanges` set rc_title = '%s' where rc_id = %d and rc_namespace = %d\n",
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
				
				# update watchlist
				if ( $dry ) {
					 print "update `$wgDBname`.`watchlist` set wl_title = '$newTitle' where wl_title = '{$row['page_title']}' and wl_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
				} else {
					$dbw->update(
						'watchlist',
						array( 'wl_title' => $newTitle ),
						array( 'wl_title' => $row['page_title'], 'wl_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}

				# update dataware
				if ( $row['page_id'] > 0 ) {
					if ( $dry ) {
						 printf( "update pages set page_title = '%s' where page_id = %d and page_wikia_id = %d\n",
							$newTitle,
							$row['page_id'],
							$wgCityId
						);
					}
					else {
						$dbext = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
						$dbext->update(
							'pages',
							array( 'page_title' => $newTitle ),
							array( 'page_id' => $row['page_id'], "page_wikia_id" => $wgCityId ),
							$method
						);
					}
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
     global $wgCityId;
	# set wgDisableBlogComments
	#WikiFactory::setVarByName( "wgDisableBlogComments", $wgCityId, true ) ;
	#WikiFactory::clearCache( $wgCityId );

	fixAllBlogComments( $dry );

	#WikiFactory::removeVarByName( "wgDisableBlogComments", $wgCityId );
	#WikiFactory::setVarByName( "wgUseNewBlogComments", $wgCityId, true ) ;
	#WikiFactory::clearCache( $wgCityId );
}
