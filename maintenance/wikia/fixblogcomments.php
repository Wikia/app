<?php

//error_reporting(E_ALL);
require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "fix blog comments" );
}

$userName = isset( $options['user'] ) ? $options['user'] : 'Maintenance script';

$help = isset($options['help']);
$wikia = isset($options['wikia']) ? $options['wikia'] : "";
$dry = isset($options['dry']) ? $options['dry'] : "";

$method = 'fixBlogComments';

function fixAllBlogComments() {
	global $method, $wgDBname;

	$db = wfGetDB(DB_SLAVE, array(), $wgDBname);
	$res = $db->select(
		array( 'page' ),
		array( 'page_id, page_title, page_namespace'),
		array(
			'page_namespace' => NS_BLOG_ARTICLE_TALK
		),
		$method,
		array('ORDER BY' => 'page_id')
	);

	$pages = array();
	while ($row = $db->fetchRow($res)) {
		$pages[] = $row;
	}
	$db->freeResult( $res );

	print sprintf("Found %0d pages \n", count($pages));

	if ( !empty($pages) ) {
		foreach ( $pages as $row ) {
			print "parse " . $row['page_title'] . "\n";

			$parts = ArticleComment::explode($row['page_title']);
			if ( $parts['blog'] == 1 && count($parts['partsOriginal']) > 0 ) {
				$parts['parsed'] = array();
				foreach ( $parts['partsOriginal'] as $id => $title ) {
					list ($user, $date) = explode( '-', $title );
					$parts['parsed'][$id] = sprintf('%s%s-%s', '@comment-', $user, $date); 
				}

				$newTitle = sprintf('%s/%s', $parts['title'], implode("/", $parts['parsed']) );

				# we have a new Title - $newTitle - update it everywhere
				# update page
				$dbw = wfGetDB( DB_MASTER );
				$dbext = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB);

				if ( $dry ) {
					 print "update page set page_title = '$newTitle' where page_title = '{$row['page_title']}' and page_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
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
					 print "update job set job_title = '$newTitle' where job_title = '{$row['page_title']}' and job_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
				} else {
					$dbw->update(
						'job',
						array( 'job_title' => $newTitle ),
						array( 'job_title' => $row['page_title'], 'job_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}

				# update watchlist
				if ( $dry ) {
					 print "update watchlist set wl_title = '$newTitle' where wl_title = '{$row['page_title']}' and wl_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
				} else {
					$dbw->update(
						'watchlist',
						array( 'wl_title' => $newTitle ),
						array( 'wl_title' => $row['page_title'], 'wl_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}

				# update dataware
				if ( $dry ) {
					 print "update pages set page_title = '$newTitle' where page_title = '{$row['page_title']}' and page_namespace = '".NS_BLOG_ARTICLE_TALK."' \n";
				} else {
					$dbext->update(
						'pages',
						array( 'page_title' => $newTitle ),
						array( 'page_title' => $row['page_title'], 'page_namespace' => NS_BLOG_ARTICLE_TALK ),
						$method
					);
				}
			}
		}
	}
}

function runUpdate($city_id, $dry, $user) {
	global $IP, $wgWikiaLocalSettingsPath;

	$script_path = $_SERVER['PHP_SELF'];
	$path = "SERVER_ID={$city_id} php {$script_path} --conf {$wgWikiaLocalSettingsPath} --wikia={$city_id} --user={$user} ";
	if ( $dry ) {
		$path .= " --dry";
	}
	#echo $path . " \n";
	$return = wfShellExec( $path );
	echo $return;
}

if ( $help ) {
	echo <<<TEXT
Usage:
    php fixblogcomments.php --help
    php fixblogcomments.php --parse=CITY_ID --dry

    --help         : This help message
    --wikia=S      : Run script for Wikia (city_id)
    --dry		   : generate SQL commands (do not update in database)
TEXT;
	exit(0);
} elseif ( !empty($wikia) ) {
	// update on Wikia
	print "Processed Wikia: $wikia";

	$city_id = $wikia;
	$wgUser = User::newFromName( $userName );
	if ( !$wgUser ) {
		print "Invalid username\n";
		exit( 1 );
	}

	# set wgDisableBlogComments
	$res = WikiFactory::setVarByName('wgDisableBlogComments', $city_id, 1);
	WikiFactory::clearCache( $city_id );

	# find all blog comments;


} else {

	print "Fetch wikis with blog comments \n";

	$db = wfGetDB(DB_MASTER, array(), $wgStatsDB);
	$res = $db->select(
		array( '`stats`.`events`' ),
		array( 'distinct wiki_id'),
		array(
			'page_ns' => NS_BLOG_ARTICLE_TALK
		),
		$method
	);

	$wikis = array();
	while ($row = $db->fetchRow($res)) {
		$wikis[] = $row['wiki_id'];
	}
	$db->freeResult( $res );

	print sprintf("Found %d wikis \n", count($wikis));

	foreach ( $wikis as $wiki_id ) {
		$res = runUpdate($wiki_id, $dry);
	}
}
