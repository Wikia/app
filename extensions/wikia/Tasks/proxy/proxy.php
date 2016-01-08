<?php
set_time_limit( 0 );
ini_set('display_errors', 0);

# SEC-21: make sure that this is called internally
$headers = apache_request_headers();
if ( empty( $headers['X-Wikia-Internal-Request'] ) ) {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : null;
	trigger_error( "X-Wikia-Internal-Request header is missing (request from {$ip})", E_USER_WARNING );

	header( 'HTTP/1.1 403 Forbidden' );
	echo json_encode( [
		'status' => 'failure',
		'reason' => 'X-Wikia-Internal-Request header is missing'
	] );
	die;
}

$script = realpath( dirname( __FILE__ ) . '/../../../../maintenance/wikia/task_runner.php' );

$taskId = escapeshellarg( $_POST['task_id'] );
$wikiId = escapeshellarg( $_POST['wiki_id'] );
$list = escapeshellarg( $_POST['task_list'] );
$order = escapeshellarg( $_POST['call_order'] );
$createdBy = escapeshellarg( $_POST['created_by'] );
$createdAt = escapeshellarg( $_POST['created_at'] );

$command = "php {$script} --wiki_id={$wikiId} --task_id={$taskId} --task_list={$list} --call_order={$order} --created_by={$createdBy} --created_at={$createdAt}";

// can't use globals here, this doesn't execute within mediawiki
if ( getenv( 'WIKIA_ENVIRONMENT' ) == 'dev' ) {
	require_once( __DIR__ . '/../../../../lib/Wikia/autoload.php' );
	require_once( __DIR__ . '/../../../../lib/composer/autoload.php' );

	\Wikia\Logger\WikiaLogger::instance()->setDevModeWithES();
	\Wikia\Logger\WikiaLogger::instance()->debug( 'Tasks - proxy.php', [
		'cmd' => $command,
		'data' => $_POST,
	] );
}

echo shell_exec( $command );
