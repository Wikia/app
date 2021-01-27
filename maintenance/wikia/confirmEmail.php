<?php
/**
 * NAME
 *
 *   confirmEmail.php
 *
 * USAGE
 *
 *   php confirmEmail USERNAME
 *   php confirmEmail ID
 *
 * Confirm the email of a user given by their username or ID
 *
 * OPTIONS
 *
 *  --force : [OPTIONAL] Force the confirmation (even if its already confirmed)
 *
 *    --test : [OPTIONAL] A flag to run in test mode.  Your class::method must support this.
 *
 * --verbose : [OPTIONAL] A flag to output more verbose messages.
 */

// Eliminate the need to set this on the command line
if ( !getenv( 'SERVER_ID' ) ) {
	putenv( "SERVER_ID=2393201" );
}

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ERROR );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class RunOnCluster
 */
class ConfirmEmail extends Maintenance {

	protected $verbose = false;
	protected $test = false;
	protected $force = false;
	protected $userIdentifier = null;

	/**
	 * Define available options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run generic code on a single cluster from on PHP process";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'force' , 'Force an update', false, false, 'f' );
	}

	/**
	 * Execute the script
	 */
	public function execute() {
		// Collect options
		$this->test = $this->hasOption( 'test' ) ? true : false;
		$this->verbose = $this->hasOption( 'verbose' ) ? true : false;
		$this->force = $this->hasOption( 'force' ) ? true : false;
		$this->userIdentifier = $this->getArg();

		if ( empty( $this->userIdentifier ) ) {
			print "A username or ID is required.\n\n";
			print "\tphp confirmEmail.php USERNAME\n";
			print "\tphp confirmEmail.php ID\n\n";
			exit(0);
		}

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug( "(debugging output enabled)\n" );

		$userFromName = User::newFromName( $this->userIdentifier );

		$userFromId = null;
		if ( preg_match("/^[0-9]+$/", $this->userIdentifier ) ) {
		     $userFromId = User::newFromId( $this->userIdentifier );
		}

		if ( $userFromName && $userFromId ) {
			print "Found users with '" . $this->userIdentifier . "' as both username and ID.\n";
			print "Using user having it as a username ...\n";
			$user = $userFromName;
		} elseif ( $userFromName ) {
			$user = $userFromName;
		} elseif ( $userFromId ) {
			$user = $userFromId;
		} else {
			print "Could not find user identified by '". $this->userIdentifier ."'\n";
			exit(0);
		}

		if ( $user->isEmailConfirmed() && !$this->force ) {
			print "This user's email (" . $user->getEmail() . ") is already confirmed.\n";
			print "Use the --force option to force a reconfirmation\n";
			exit(0);
		}

		print "Confirming email for:\n";
		print "\tName: " . $user->getRealName() . "\n";
		print "\tID: " . $user->getId() . "\n";
		print "\tEmail: " . $user->getEmail() . "\n";

		if ( !$this->test ) {
			$user->confirmEmail();
			$user->saveSettings();
		}

		print "\nDone\n\n";
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}
}

$maintClass = "ConfirmEmail";
require_once( RUN_MAINTENANCE_IF_MAIN );
