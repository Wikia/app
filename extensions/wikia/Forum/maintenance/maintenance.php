<?php

// ------------------------------------------- Main -------------------------------------------------


require_once( "helper.php" );
ini_set( "include_path", dirname( __FILE__ ) . "/../../../../maintenance/" );
require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php maintenance.php [--dry-run] [--forum] [--wall] [--skip_reset] [--from_id=12345] [--to_id=12345] [--insert_data] [--help]
		--dryrun			dry run
		--forum				only forum
		--wall				only wall pages
		--skip_reset		skip delete data from comments_index table
		--from_id			from page id
		--to_id				to page id
		--insert_data		only insert data to comments_index table
		--help				you are reading it right now\n\n" );
}

$app = F::app();
if ( empty( $app->wg->CityId ) ) {
	die( "Error: Invalid wiki id." );
}

if ( wfReadOnly() ) {
	die( "Error: In read only mode." );
}

$isDryrun = ( isset( $options['dryrun'] ) ) ? true : false ;
$forumOnly = ( isset( $options['forum'] ) ) ? true : false ;
$wallOnly = ( isset( $options['wall'] ) ) ? true : false ;
$skipReset = ( isset( $options['skip_reset'] ) ) ? true : false ;
$insertDataOnly = ( isset( $options['insert_data'] ) ) ? true : false ;
$fromId = ( isset( $options['from_id'] ) ) ? intval( $options['from_id'] ) : null ;
$toId = ( isset( $options['to_id'] ) ) ? intval( $options['to_id'] ) : null ;

echo "Wiki $wgCityId:\n";

$db = wfGetDB( DB_MASTER );

if ( !$isDryrun && !$insertDataOnly ) {
	// create table or patch table schema
	$commentsIndex = ( new CommentsIndex );

	echo "Updated database schema for comment_index table.\n";

	// clear data in the table
	//		if ( !$skipReset ) {
	//			$db->delete( 'comments_index', '*' );
	//		}

	echo "Removed data from comments_index table.\n";
}

$cmdOptions = '';

// set where clauses
$sqlWhereBase = array(
	'page.page_title ' . $db->buildLike( $db->anyString(), sprintf( "/%s", ARTICLECOMMENT_PREFIX ), $db->anyString() ),
	'page_latest > 0'	// BugId:22821
);

if ( $wallOnly ) {
	$sqlWhereBase['page_namespace'] = NS_USER_WALL_MESSAGE;
	$cmdOptions .= ' --wall';
}

if ( $forumOnly ) {
	$sqlWhereBase['page_namespace'] = NS_WIKIA_FORUM_BOARD_THREAD;
	$cmdOptions .= ' --forum';
}


// range just executs workers
// get min/max comments
if ( is_null( $fromId ) || is_null( $toId ) ) {
	$row = $db->selectRow(
	array( 'page' ),
	array( 'min(page_id) min_id, max(page_id) max_id' ),
	$sqlWhereBase,
	__METHOD__
	);

	$fromId = ( $row ) ? intval( $row->min_id ) : 0 ;
	if ( $fromId > 0 ) {
		$fromId = $fromId - 1;
	}

	$toId = ( $row ) ? intval( $row->max_id ) : 0 ;


	echo "LOOP: From ID $fromId to ID $toId (To ID = $toId).\n";

	$processes = array();

	$jump = 200;

	if ( ( $toId - $fromId ) / $jump > 20 ) {
		$jump = ceil( ( $toId - $fromId ) / 20 );
	}

	echo "JUMP OF QUERY:" . $jump . "\n";
	for ( $i = $fromId; $i < $toId; $i += $jump ) {
		$cmd = 'SERVER_ID=' . $app->wg->CityId . ' php ' . $IP . '/extensions/wikia/Forum/maintenance/maintenance.php ' .
			'--conf=' . $app->wg->WikiaLocalSettingsPath . ' --from_id=' . $i . ' --to_id=' . ( $i + $jump ) .
		$cmdOptions . ' --insert_data';// > /tmp/forum'.$fromId.'_'.$toId.'.log ';
		echo "command: $cmd\n";
		$handle = popen( "$cmd 2>&1", 'r' );
		$processes[] = $handle;
		echo "processes: " . count( $processes ) . "\n";
	}

	$working = true;
	while ( $working ) {
		$working = false;
		foreach ( $processes as $handle ) {
			if ( !feof( $handle ) ) {
				echo fgets( $handle );
				$working = true;
			}
		}
	}

	exit;
}


$cnt = 0;
$failed = 0;
$range = 1000;

$sqlWhere = array(
	'page_id > ' . $fromId,
	'page_id <= ' . $toId
);
$sqlWhere = array_merge( $sqlWhereBase, $sqlWhere );

// get comment list
$result = $db->select(
	array( 'page' ),
	array( 'page_id',
		'page_title',
		'page_namespace',
		'page_len',
		'page_is_redirect',
		'page_latest'
	),
	$sqlWhere,
	__METHOD__,
	array( 'ORDER BY' => 'page_id ASC' )
);

$commentList = array();
while ( $row = $db->fetchObject( $result ) ) {
	$commentList[$row->page_id] = $row;
}
$db->freeResult( $result );

// collect and insert data
foreach ( $commentList as $comment ) {
	$cnt++;
	echo "$cnt [$fromId-$toId]: ID $comment->page_id(NS $comment->page_namespace): $comment->page_title";

	$title = Title::newFromRow( $comment );
	$articleComment = ArticleComment::newFromTitle( $title );
	$articleComment->load();

	// parent page id
	$parentPageId = getParentPage( $articleComment );
	if ( empty( $parentPageId ) ) {
		echo ".....Parent page NOT found.\n";
		$failed++;
		continue;
	}

	// get parent comment id
	$parentCommentObj = $articleComment->getTopParentObj();
	if ( $parentCommentObj instanceof ArticleComment ) { // posts/replies
		$parentCommentId = $parentCommentObj->getTitle()->getArticleID();
		$lastChildCommentId = 0;
	} else { // main comments
		$parentCommentId = 0;
		$lastChildCommentId = getLastChildCommentId( $articleComment );
	}

	// insert main comment
	insertIntoCommentsIndex( $parentPageId, $articleComment, $parentCommentId, $lastChildCommentId );
	echo ".....DONE.\n";
}

WikiFactory::setVarByName( "wgWallIndexed", $wgCityId, true );

echo "TOTAL: " . $cnt . ", SUCCESS: " . ( $cnt -$failed ) . ", FAILED: $failed\n\n";
echo "#DONE !!!\n";