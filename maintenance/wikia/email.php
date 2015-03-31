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
	protected $to = '';
	protected $type = '';
	protected $argString = '';
	protected $list = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
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

		$this->addOption( 'to', 'Address to send email to',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_HAS_ARG
		);
		$this->addOption( 'type', 'Type of email to send',
			Maintenance::PARAM_OPTIONAL,
			Maintenance::PARAM_HAS_ARG
		);
		$this->addOption( 'args', 'Arguments for email type',
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

			echo "Email sent as '$this->to' successfully!\n";
			exit( 0 );
		} catch ( Exception $e ) {
			echo "An error occurred:\n";
			echo $e->getMessage() . "\n";
			exit( 1 );
		}
	}

	protected function initOptions() {
		$this->test = $this->hasOption( 'test' );
		$this->verbose = $this->hasOption( 'verbose' );
		$this->to = $this->getOption( 'to', '' );
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

		if ( !empty( $this->to ) && !empty( $this->type ) ) {
			return;
		}

		throw new OptionException( 'Either --list or both --to and --type options are required' );
	}

	protected function setupUser() {
		// We either have a user ID or a user name
		if ( preg_match( '/^\d+$/', $this->to ) ) {
			$userObject = User::newFromId( $this->to );
		} else {
			$userObject = User::newFromName( $this->to );
		}

		if ( empty( $userObject ) ) {
			throw new OptionException( 'Could not find matching user for name/ID: ' . $this->to );
		}

		F::app()->wg->User = $userObject;
	}

	protected function argStringToArray( $argString ) {
		$paramPairs = explode( ',', $argString );

		$param = [];
		foreach ( $paramPairs as $pair ) {
			list( $key, $value ) = explode( '=', $pair );
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

class OptionException extends Exception {};
class RequestException extends Exception {};

global $maintClass;
$maintClass = 'EmailCLI';
require_once( RUN_MAINTENANCE_IF_MAIN );

