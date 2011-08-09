<?php
/**
 * cleanMediaWikiProtection
 *
 * @brief Deletes entries from page_restrictions which correspond to NS_MEDIAWIKI pages.
 * 
 * @package MediaWiki
 * @subpackage Maintenance
 *
 * @author: Michał Roszka <michal@wikia-inc.com>
 *
 */
ini_set( 'include_path', dirname( __FILE__ ) . '/../' );
require 'commandLine.inc';

if ( isset( $options['help'] ) ) {
	exit(
		"\nDeletes entries from page_restrictions which correspond to NS_MEDIAWIKI pages.\n\n"
		. "Usage: php cleanMediaWikiProtection.php [--quiet]\n"
		. "\t--help   give this help\n"
		. "\t--quiet  suppress all messages\n\n"
	);
}

echo "\nCleaning protections for SERVER_ID={$_ENV['SERVER_ID']}...\n";
$dbr = wfGetDB( DB_MASTER );
$query =  'DELETE FROM page_restrictions WHERE pr_page IN ( SELECT page_id FROM page WHERE page_namespace = ' . NS_MEDIAWIKI . ' )';
wfWaitForSlaves( 5 );
$oRes = $dbr->query( $query );

// Exit with status 1 on error.
if ( true !== $oRes ) {
	if ( !isset( $options['quiet'] ) ) {
		echo "Query: $query\nCleanup failed.\n\n";
	}
	exit( 1 );
}

// Exit with status 0 on success.
$rows = $dbr->affectedRows( $oRes );
if ( !isset( $options['quiet'] ) ) {
	echo "Query: $query\nCleanup succeded, $rows row(s) deleted.\n\n";
}
exit( 0 );