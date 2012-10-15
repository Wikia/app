<?php 
/**
 * Simple job runner demon suitable to be run from the can be run from the command line with a 
 * virtual session using a unix utility such as screen.
 * 
 * This could be replaced by a cron job shell script that did something similar. 
 */
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class WebVideoJobRunner extends Maintenance {
	// Default number of simultaneous transcoding threads  
	var $threads = 2;
	
	// How often ( in seconds ) the script checks for $threads transcode jobs to be active. 
	var $checkJobsFrequency = 5;
	
	public function __construct() {
		parent::__construct();
		$this->addOption( "threads", "The number of simultaneous transcode threads to run", false, true );
		$this->addOption( "frequency", "How often the script checks for job threads to be active", false, true );
		$this->mDescription = "Transcode job running demon, continuously runs transcode jobs";
	}
	public function execute() {		
		if ( $this->hasOption( "threads" ) ) {
			$this->threads = $this->getOption( 'threads' ) ;
		}
		if ( $this->hasOption( "wiki" ) ) {
			$this->wiki = $this->getOption( 'wiki' ) ;
		} else {
			$this->wiki = false;
		}
		// Check if WebVideoJobRuner is already running:
		$jobRunnerCount = 0;
		$fistPid = null;
		foreach( $this->getProcessList() as $pid => $proc ){
			if( strpos( $proc['args'], 'WebVideoJobRunner.php' ) !== false ){
				if( intval( $proc['time'] ) != 0 ){
					$this->error( "WebVideoJobRunner.php is already running on this box with pid $pid and $fistPid" );
					exit(1);
				}
			}
		}
		// Main runCheckJobThreadsLoop 
		while( true ){		
			$this->runCheckJobThreadsLoop();
			// Check again in $checkJobsFrequency seconds:
			sleep( $this->checkJobsFrequency );
		}		
	}
	function runCheckJobThreadsLoop(){
		global $IP, $wgTranscodeBackgroundTimeLimit;
		// Check if we have $threads number of webTranscode jobs running else sleep
		$runingJobsCount = 0;
		foreach( $this->getProcessList() as $pid => $proc ){
			// Check that the process is a "runJobs.php" action with type webVideoTranscode argument  			
			if( strpos( $proc['args'], 'runJobs.php' ) !== false && 
				strpos( $proc['args'], '--type webVideoTranscode' ) !== false 
			){
				if( TimedMediaHandler::parseTimeString( $proc['time'] ) > $wgTranscodeBackgroundTimeLimit ){	
					// should probably "kill" the process 
					$killSuccess = posix_kill( $pid );
					$this->output( "Trying to expire transcode job: " . $pid . " result:" . $killSuccess );
				} else {
					// Job is oky add to count: 
					$runingJobsCount++;
				}				
			}
		}
		if( $runingJobsCount < $this->threads ){
			// Add one process:
			$parameters = array();
			if( $this->wiki ) {
				$parameters[] = '--wiki';
				$parameters[] = $this->wiki;
			}
			$parameters[] = '--type';
			$parameters[] = 'webVideoTranscode';
			$parameters[] = '--maxjobs';
			$parameters[] = '1';
			$parameters[] = '--maxtime';
			$parameters[] = $wgTranscodeBackgroundTimeLimit;
			$cmd = wfShellMaintenanceCmd("$IP/maintenance/runJobs.php", $parameters);
			$status = $this->runBackgroundProc( $cmd );
			$this->output( "$runingJobsCount existing job runners, Check for new transcode jobs:  " );
		} else {
			// Just output a "tick"
			$this->output( "$runingJobsCount transcode jobs active:\n" );
		}
	}
	
	function runBackgroundProc($command, $priority = 19 ){
		$out = wfShellExec("nohup nice -n $priority $command > /dev/null & echo $!");
		return trim( $out );
	}
	
	/**
	 * Gets a list of php process
	 */
	function getProcessList(){
		// Get all the php process except for 
		$pList = wfShellExec( 'ps axo pid,etime,args | grep php | grep -v grep' );
		$pList = explode("\n", $pList );
		$namedProccessList = array();		
		foreach( $pList as $key => $val ){
			if( trim( $val) == '' )
				continue;
				
			// Split the process id			
			//$matchStatus = preg_match('/\s([0-9]+)\s+([0-9]+:?[0-9]+:[0-9]+)+\s+([^\s]+)\s(.*)/', $val, $matches);
			$matchStatus = preg_match('/\s*([0-9]+)\s+([0-9]+:?[0-9]+:[0-9]+)+\s+([^\s]+)\s(.*)/', $val, $matches);
			if( !$matchStatus ){
				continue;
			}
			$namedProccessList[ $matches[1] ] = array(
				'pid' => $matches[1],
				'time' => $matches[2],
				'args' => $matches[4],				 			
			);
		}
		return $namedProccessList;
	}	
}

$maintClass = "WebVideoJobRunner";
require_once( RUN_MAINTENANCE_IF_MAIN );

