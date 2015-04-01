<?php
/**
 * Email
 *
 * This sends an email type (defined in extensions/wikia/Email) to the email address of your
 * choice
 *
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

// Eliminate the need to set this on the command line
if ( !getenv( 'SERVER_ID' ) ) {
	putenv( "SERVER_ID=177" );
}

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class Email\CLI
 */
class EmailCLI extends Maintenance {

	protected $verbose = false;
	protected $test = false;
	protected $user = '';
	protected $type = '';
	protected $argString = '';
	protected $list = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Test sending email via the Email extension";
		$this->addOption( 'test', 'Test mode; make no changes',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_IS_FLAG,
			't'
		);
		$this->addOption( 'verbose', 'Show extra debugging output',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_IS_FLAG,
			'v'
		);

		$this->addOption( 'user', 'Masquerade as this user when sending email. Can be username or ID.',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_HAS_ARG
		);
		$this->addOption( 'type', 'Type of email to send',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_HAS_ARG
		);
		$this->addOption( 'args', 'Arguments for email type as comma separated, key=value (e.g. name=foo,admin=0)',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_HAS_ARG
		);
		$this->addOption( 'list', 'List email types',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_IS_FLAG
		);
	}

	public function execute() {
		try {
			$this->initOptions();

			if ( $this->list ) {
				$this->showValidEmailTypes();
				exit( 0 );
			}

			// The controller class should end with 'Controller'
			$controllerClass = 'Email\\Controller\\' . $this->type . 'Controller';
			$this->assertControllerExists( $controllerClass );

			$params = $this->argStringToArray( $this->argString );
			$resp = F::app()->sendRequest( $controllerClass, 'handle', $params, true );

			$this->assertSuccessfulEmail( $resp );

			echo "Email sent as '$this->user' successfully!\n";
			exit( 0 );
		} catch ( EmailCLIException $e ) {
			echo "An error occurred:\n";
			echo $e->getMessage() . "\n";
			exit( 1 );
		}
	}

	protected function initOptions() {
		$this->test = $this->hasOption( 'test' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->user = $this->getOption( 'user', '' );
		$this->type = $this->getOption( 'type', '' );
		$this->argString = $this->getOption( 'args', '' );
		$this->list = $this->getOption( 'list', false );

		$this->assertRequiredOptionsExist();

		// The list functionality doesn't need an email address
		if ( !$this->list ) {
			$this->setupUser();
		}
	}

	protected function assertRequiredOptionsExist() {
		if ( $this->list ) {
			return;
		}

		if ( !empty( $this->user ) && !empty( $this->type ) ) {
			return;
		}

		throw new OptionException( 'Either --list or both --to and --type options are required' );
	}

	protected function setupUser() {
		// We either have a user ID or a user name
		if ( filter_var( $this->user, FILTER_VALIDATE_INT ) ) {
			$userObject = User::newFromId( $this->user );
		}

		// Try this as a user name next if we still didn't find what we want.
		if ( empty( $userObject ) ) {
			$userObject = User::newFromName( $this->user );
		}

		if ( empty( $userObject ) ) {
			throw new OptionException( 'Could not find matching user for name/ID: ' . $this->user );
		}

		F::app()->wg->User = $userObject;
	}

	protected function argStringToArray( $argString ) {
		$paramPairs = explode( ',', $argString );

		$param = [];
		foreach ( $paramPairs as $pair ) {
			if ( empty( $pair ) ) {
				continue;
			}

			list( $key, $value ) = explode( '=', $pair );
			if ( empty( $value ) ) {
				echo "WARNING: argument '$key' had no value\n";
				continue;
			}
			if ( empty( $key ) ) {
				echo "WARNING: missing key for value '$value'\n";
				continue;
			}
			$param[$key] = $value;
		}

		return $param;
	}

	protected function assertControllerExists( $controllerClass ) {
		if ( !class_exists( $controllerClass ) ) {
			throw new OptionException( "Can't find $controllerClass to handle this email type\n" );
		}
	}

	protected function assertSuccessfulEmail( WikiaResponse $resp = null ) {
		if ( empty( $resp ) ) {
			throw new RequestException( "Got empty response from the $this->type email controller\n" );
		}

		$data = $resp->getData();

		if ( empty( $data[ 'result' ] ) || $data[ 'result' ] != 'ok' ) {
			throw new RequestException( "Failed to send email:\n" . print_r( $data, true ) );
		}
	}

	protected function showValidEmailTypes() {
		echo "The following can be passed to --type:\n";

		$classes = \F::app()->wg->AutoloadClasses;
		foreach ( $classes as $className => $classPath ) {
			if ( preg_match( "/^Email\\\\Controller\\\\(.+)Controller$/", $className, $matches ) ) {
				$shortName = $matches[1];
				echo "\t* $shortName\n";

			}
		}
	}
}

class EmailCLIException extends Exception {};
class OptionException extends EmailCLIException {};
class RequestException extends EmailCLIException {};

global $maintClass;
$maintClass = 'EmailCLI';
require_once( RUN_MAINTENANCE_IF_MAIN );

