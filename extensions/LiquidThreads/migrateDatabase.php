<?php

// Utility script to update your LiquidThreads installation by batch-running lazy updates
//  normally done on-demand when a thread is loaded. Also runs any necessary database updates.

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );

$db = wfGetDB( DB_MASTER );

$wgTitle = SpecialPage::getTitleFor( 'LiquidThreads' );

// Do database updates
$threadFieldUpdates = array(
	'thread_article_namespace' => 'split-thread_article.sql',
	'thread_article_title' => 'split-thread_article.sql',
	'thread_ancestor' => 'normalise-ancestry.sql',
	'thread_parent' => 'normalise-ancestry.sql',
	'thread_modified' => 'split-timestamps.sql',
	'thread_created' => 'split-timestamps.sql',
	'thread_editedness' => 'store-editedness.sql',
	'thread_subject' => 'store_subject-author.sql',
	'thread_author_id' => 'store_subject-author.sql',
	'thread_author_name' => 'store_subject-author.sql',
	'thread_sortkey' => 'new-sortkey.sql',
	'thread_replies' => 'store_reply_count.sql',
	'thread_article_id' => 'store_article_id.sql',
);

$threadIndexUpdates = array( 'thread_summary_page' => 'index-summary_page.sql' );

$newTableUpdates = array( 'thread_history' => 'thread_history_table.sql' );

foreach ( $threadFieldUpdates as $field => $patch ) {
	if ( !$db->fieldExists( 'thread', $field, 'lqt-update-script' ) ) {
		$db->sourceFile( dirname( __FILE__ ) . '/schema-changes/' . $patch );
	}
}

foreach ( $threadIndexUpdates as $index => $patch ) {
	if ( !$db->indexExists( 'thread', $index, 'lqt-update-script' ) ) {
		$db->sourceFile( dirname( __FILE__ ) . '/schema-changes/' . $patch );
	}
}

foreach ( $newTableUpdates as $table => $patch ) {
	if ( !$db->tableExists( $table, 'lqt-update-script' ) ) {
		$db->sourceFile( dirname( __FILE__ ) . '/schema-changes/' . $patch );
	}
}

// Batch lazy updates
$upTo = $lastUpTo = 0;

do {
	$lastUpTo = $upTo;

	$db->begin();

	// Read 500 rows
	$res = $db->select(
		'thread', '*', array( 'thread_id>' . $db->addQuotes( $upTo ) ),
		'lqt-update-script',
		array( 'LIMIT' => 500, 'FOR UPDATE', 'ORDER BY' => 'thread_id asc' )
	);

	$threads = Threads::loadFromResult( $res, $db );

	foreach ( $threads as $thread ) {
		$thread->doLazyUpdates();
		$thread->updateHistory();

		if ( $thread->id() > $upTo ) {
			$upTo = $thread->id();
		}
	}

	$db->commit();

} while ( $lastUpTo != $upTo );
