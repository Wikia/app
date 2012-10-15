<?php
/**
 * Connect with one 'Simple Farm' farm member and start several maintenance
 * scripts from there to maintain several farm members at the same time.
 * 
 * @file maintainFarm.php
 * @ingroup Maintenance
 * @ingroup SimpleFarm
 * 
 * @author Daniel Werner < danweetz@web.de >
 */

require_once dirname( __FILE__ ) . '/../../../maintenance/Maintenance.php';
require_once dirname( __FILE__ ) . '/../SimpleFarm_Classes.php';

/**
 * 'Simple Farm' maintenance handler
 * 
 * @since 0.1
 */
class SimpleFarmerMaintenance extends Maintenance {
	
	function __construct() {
		SimpleFarm::$maintenanceIsRunning = true;
		parent::__construct();
		
		$this->mDescription = "'Simple Farm' farmer script for maintaining several farm members with just one command";
		$this->addOption( 'farmexclude', 'comma-separated list of wikis to deselect for farming (by database name)' );
		$this->addOption( 'farmonly', 'comma-separated list of wikis to select for doing some farming on (by database name)' );
		$this->addOption( 'farmpreview', 'if set this will output all selected wikis for farming without running any further action' );
		$this->addArg( 'command', 'the command-line command to execute for each selected farm member', false );
	}
	
	public function getDbType() {
		return Maintenance::DB_NONE;
	}
	
	public function execute() {
		global $egSimpleFarmWikiSelectEnvVarName;
		
		$prfx = '~~ '; // prefix in front of each line to make an optical difference to passthru scripts
		
		$selected = SimpleFarm::getMembers();		
		$totalMembers = count( $selected );
		
		// farmexclude:
		$excluded = preg_split( '/\s*,\s*/', trim( $this->getOption( 'farmexclude', '' ) ) );
		$selected = array_diff_key( $selected, array_flip( $excluded ) );
		
		// farmonly:
		if( $this->getOption( 'farmonly' ) !== null ) {
			$only = preg_split( '/\s*,\s*/', trim( $this->getOption( 'farmonly', '' ) ) );
			$selected = array_intersect_key( $selected, array_flip( $only ) );
		}

		// information about how many are selected:
		$selectedMembers = count( $selected );
		if( $selectedMembers === 0 ) {
			$this->output( "\n{$prfx}None of the $totalMembers farm members are selected!" );
		}
		elseif( $totalMembers === $selectedMembers ) {
			$this->output( "\n{$prfx}All $totalMembers members of the farm are selected:" );
		}
		else {
			$this->output( "\n{$prfx}The following $selectedMembers out of $totalMembers farm members are selected:" );
		}

		// print selected members:
		$longest = 0;
		foreach( $selected as $member ) {				
			if( ( $currLen = strlen( $member->getName() ) ) > $longest )
				$longest = $currLen;
		}
		
		$i = 0;
		foreach( $selected as $member ) {
			$i++;
			$this->output( "\n{$prfx}($i) Name: " . str_pad( "'{$member->getName()}'", $longest + 2, ' ', STR_PAD_RIGHT ) . " DB: '{$member->getDB()}'" );
		}
		
		// if we are in preview mode, just display what has been selected and end:
		if( $this->getOption( 'farmpreview' ) !== null )
			return; // no further action
		
		// finally, run the script for each:		
		$script = $this->getArg( 0 );		
		if( $script === null ) {
			$this->error( "\n{$prfx}No maintaining command has been set! Argument <command> required!", true );
		}
		
		$this->output( "\n\n{$prfx}Start maintaining selected 'Simple Farm' members:" );
		$this->output( "\n{$prfx}Command: '{$script}'" );
		$i = 0;
		$failed = 0;
		
		foreach( $selected as $member ) {			
			$i++;
			$this->output( "\n\n{$prfx}({$i}/{$selectedMembers}) Running command for member '{$member->getName()}' ({$egSimpleFarmWikiSelectEnvVarName}={$member->getDB()})...\n\n" );
			putenv( SIMPLEFARM_ENVVAR . "={$member->getDB()}" );
			$fail = null;
			passthru( $script, $fail );
			if( $fail ) { // value other than 0 implies an error
				$failed++;
			}
		}
				
		$this->output( "\n\n{$prfx}Finished! All {$selectedMembers} selected 'Simple Farm' members have been maintained" );
		
		// check whether we had any errors along the way:
		if( $failed > 0 ) {
			// send out some warning!
			$this->output( "\n{$prfx}WARNING: {$failed} of the command executions have returned a value implying an error. See output above!\n" );
		}
		else {
			// success!
			$this->output( "\n{$prfx}Apparently, no error has occured during command executions :-)\n" );
		}
	}
}

$maintClass = 'SimpleFarmerMaintenance';
require_once( RUN_MAINTENANCE_IF_MAIN );
