<?php
set_time_limit( 0 );

$script = realpath( dirname( __FILE__ ) . '/../../../../maintenance/wikia/task_runner.php' );

$taskId = escapeshellarg( $_POST['task_id'] );
$wikiId = escapeshellarg( $_POST['wiki_id'] );
$list = escapeshellarg( $_POST['task_list'] );
$order = escapeshellarg( $_POST['call_order'] );
$createdBy = escapeshellarg( $_POST['created_by'] );

$command = "SERVER_ID={$wikiId} php {$script} --task_id={$taskId} --task_list={$list} --call_order={$order} --created_by={$createdBy}";

// can't use globals here, this doesn't execute within mediawiki
if ( getenv( 'WIKIA_ENVIRONMENT' ) == 'dev' ) {
	require_once( __DIR__ . '/../../../../lib/Wikia/autoload.php' );
	require_once( __DIR__ . '/../../../../lib/composer/autoload.php' );

	\Wikia\Logger\WikiaLogger::instance()->setDevModeWithES();
	\Wikia\Logger\WikiaLogger::instance()->debug( $command, [
		'task_id' => $taskId
	] );
}

echo shell_exec( $command );
