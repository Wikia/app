<?php
/**
 * \brief A simple test to check if the binary dependencies are met.
 * \author Michał Roszka (Mix) <michal@wikia-inc.com>
 *
 * I created this test while investigating and fixing BugId:33222.
 *
 * Usage: run as www-data and check the exit status (0 if OK, 1 otherwise).
 */
$aRequiredBinaries = array(
	'/usr/bin/mysql',
	'/usr/bin/mysqldump',
	'/usr/bin/php',
	// Feel free to add to this list.
);

foreach ( $aRequiredBinaries as $sBinary ) {
	// Terminate once the first unmet dependance is found.
	if ( !file_exists( $sBinary ) || !is_executable( $sBinary ) ) {
		echo "Oh, no! {$sBinary} is inaccessible!\n";
		exit( 1 );
	}
}

echo "No unmet dependencies.\n";
exit( 0 );
