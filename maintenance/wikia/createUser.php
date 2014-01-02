<?php

/**
 * Maintenance script to create an account and grant it administrator rights
 *
 * @file
 * @ingroup Maintenance
 * @author Rob Church <robchur@gmail.com>
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 */

$options = array( 'help' );

ini_set( "include_path", dirname( __FILE__ ) . "/../" );
require_once( 'commandLine.inc' );

if ( isset( $options[ 'help' ] ) ) {
	showHelp();
	exit( 1 );
}

if ( count( $args ) < 3 ) {
	echo( "Please provide a username, password and email for the new account.\n" );
	die( 1 );
}

$username = $args[ 0 ];
$password = $args[ 1 ];
$email = $args[ 2 ];

echo( wfWikiID() . ": Creating User:{$username}..." );

# Validate username and check it doesn't exist
$user = User::newFromName( $username );
if ( !is_object( $user ) ) {
	echo( "invalid username.\n" );
	die( 1 );
} elseif ( 0 != $user->idForName() ) {
	echo( "account exists.\n" );
	die( 1 );
}

# Insert the account into the database
$user->addToDatabase();
$user->setEmail( $email );
$user->setPassword( $password );
$user->confirmEmail();
UserLoginHelper::removeNotConfirmedFlag( $user ); // this calls saveSettings();
if ( !ExternalUser_Wikia::addUser( $user, $password, $email, $username ) ) {
	echo "error creating external user\n";
	die( 1 );
}

# Increment site_stats.ss_users
$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
$ssu->doUpdate();

echo( "done.\n" );

function showHelp() {
	echo( <<<EOT
Create a new user account
USAGE: php createUser.php [--help] <username> <password> <email>

	--help
		Show this help information

EOT
	);
}
