<?php

// ------------------------------------------- Main -------------------------------------------------


require_once( "helper.php" );
ini_set( "include_path", dirname( __FILE__ ) . "/../../../../maintenance/" );
require_once( "commandLine.inc" );

// select * from wall_history where wall_wiki_id = 509;

/*
 *
 * old table
+--------------------+--------------+------+-----+-------------------+-----------------------------+
| Field              | Type         | Null | Key | Default           | Extra                       |
+--------------------+--------------+------+-----+-------------------+-----------------------------+
| wall_user_id       | int(11)      | YES  |     | NULL              |                             |
| wall_user_ip       | varchar(16)  | YES  | MUL | NULL              |                             |
| wiki_id            | int(11)      | YES  | MUL | NULL              |                             |
| post_user_id       | int(11)      | YES  |     | NULL              |                             |
| post_user_ip       | varchar(16)  | YES  |     | NULL              |                             |
| is_reply           | int(1)       | YES  |     | NULL              |                             |
| action             | int(3)       | YES  |     | NULL              |                             |
| metatitle          | varchar(201) | YES  |     | NULL              |                             |
| page_id            | int(11)      | YES  |     | NULL              |                             |
| parent_page_id     | int(11)      | YES  |     | NULL              |                             |
| event_date         | timestamp    | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
| reason             | varchar(100) | YES  |     | NULL              |                             |
| revision_id        | int(11)      | YES  |     | NULL              |                             |
| deleted_or_removed | int(1)       | YES  |     | 0                 |                             |
| post_ns            | int(11)      | YES  |     | 1200              |                             |
| migrated           | int(1)       | YES  | MUL | 0                 |                             |
+--------------------+--------------+------+-----+-------------------+------------------------------
*/

$history = new WallHistory();
$dbw = $history->getDatawareDB();

$res = $dbw->select(
	'wall_history',
	array(
		'post_user_id',
		'post_user_ip',
		'is_reply',
		'post_ns',
		'page_id',
		'parent_page_id',
		'metatitle',
		'deleted_or_removed',
		'event_date',
		'reason',
		'action',
		'revision_id',
		'deleted_or_removed'
	),
	array(
		'migrated' => 0,
		'wiki_id' => $wgCityId
	),
	__METHOD__
);

$in = array();

$db = $history->getDB( DB_MASTER );

$dir = dirname( __FILE__ );


if ( !$db->tableExists( 'wall_history' ) ) {
	echo "Try to create table\'n";
	$db->sourceFile( $IP . "/extensions/wikia/Wall/sql/wall_history_local.sql" );
}

while ( $row = $dbw->fetchRow( $res ) ) {
	if ( $row['action'] == WH_NEW || $row['action'] == WH_EDIT ) {

		$pagesRow = $db->selectRow(
			'revision',
			array(
				'rev_timestamp'
			),
			array(
				'rev_id' => $row['revision_id']
			)
		);

		$row['event_date'] = wfTimestamp( TS_DB, $pagesRow->rev_timestamp );
	}

	$mw = WallMessage::newFromId( $row['page_id'] );

	if ( empty( $mw ) ) {
		continue;
	}

/*	$history->internalAdd(
	$parentPageId,
	$postUserId,
	$postUserName, $
	isReply, $commentId, $ns, $parentCommentId, $metatitle, $action, $reason, $revId, $deletedOrRemoved );
*/
	if ( $mw->isMain() ) {
		$parentCommentId = $row['page_id'];
		$commentId = $row['page_id'];
	} else {
		$parentCommentId = $row['parent_page_id'];
		$commentId = $row['page_id'];
	}

	$db->insert(
		'wall_history',
		array(
			'parent_page_id' => $mw->getArticleTitle()->getArticleId(),
			'parent_comment_id' => $parentCommentId,
			'comment_id' => $commentId,

			'post_user_id' => $row['post_user_id'],
			'post_user_ip' => $row['post_user_ip'],

			'post_ns' => MWNamespace::getSubject( $row['post_ns'] ),
			'is_reply' => $row['is_reply'],
			'metatitle' => $row['metatitle'],
			'reason' => $row['reason'],
			'action' => $row['action'],
			'revision_id' => $row['revision_id'],
			'deleted_or_removed' => $row['deleted_or_removed'],
			'event_date' => $row['event_date']
		)
	);

	$dbw->update(
		'wall_history',
		array( 'migrated' => 1 ),
		array(
			'page_id' => $commentId,
			'migrated' => 0,
			'wiki_id' => $wgCityId
		),
		__METHOD__
	);

}

echo "DONE";

