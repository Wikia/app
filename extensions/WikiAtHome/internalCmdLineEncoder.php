<?
/*
 * this encoder is run from the command line and takes "encoding" jobs from the command line
 */

require_once ( '../../maintenance/commandLine.inc' );

//get the jobset list
//@@todo input handling

/*if ( count( $args ) == 0 || isset ( $options['help'] ) ) {
	print<<<EOT
Loads encoding jobs from the database and encodes them.
	internalCmdLineEncoder [options]
		-t [threads] how many transcode threads to run
		--runOnce  run once flag has the application run just one time
EOT;
die();
}*/

//number of threads (not yet supported)
$wahNumberOfThreads = 1;

//single run flag
$wahRunOnce = true;

//delay between job searches
$wahJobDelay = 10;

$wahStatusOutput = true;

//make sure we have wikiAtHome
if( !class_exists(WikiAtHome) ){
	die( ' "WikiAtHome" is required for the internal encoder');
}


doJobLoop();
function doJobLoop(){
	global $wgJobTypeConfig, $wahJobDelay, $wahRunOnce, $wahStatusOutput;

	//look for jobs (sleep for $wahJobDelay if none found)
	$job = WahJobManager :: getNewJob(false, 'Internal');
	if(!$job && $wahRunOnce == false){
		if($wahStatusOutput)
			print "no jobs found waiting $wahJobDelay \n";
		sleep($wahJobDelay);
		return doJobLoop();
	}else if(!$job  && $wahRunOnce == true){
		if($wahStatusOutput)
			print "no job found \n";
		return ;
	}

	$jobSet = WahJobManager ::getJobSetById( $job->job_set_id );
	$jobDetails = FormatJson::decode( $job->job_json ) ;

	//get the title (so we can access the source file)
	$fTitle = Title::newFromText( $job->title, $job->ns );
	$file = wfLocalFile( $fTitle );
	$thumbPath = $file->getThumbPath( $jobSet->set_encodekey );
	//make sure the directory is ready:
	wfMkdirParents( $thumbPath );

	$destTarget = $thumbPath . '.ogg';
	//issue the encoding command
	if($wahStatusOutput) print "Running Encode Command...\n";
	wahDoEncode($file->getPath(), $destTarget, $jobDetails->encodeSettings );

	//once done with encode update the status:
	WahJobManager :: updateJobDone($job);
	//update set done (if only one item in the set)
	$wjm = WahJobManager::newFromSet( $jobSet );
	$percDone = $wjm->getDonePerc();
	if( $percDone == 1 ){
		WahJobManager :: updateSetDone( $jobSet );
	}else{
		if($wahStatusOutput)
			print "job not complete? (might be mixing chunkDuration types?) ";
	}
}

?>