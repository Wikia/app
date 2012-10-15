<?php
/**
 * the api module responsible for dishing out jobs, and taking in results.
 */

if (!defined('MEDIAWIKI')) {
  die();
}

/**
 * A module that allows for distributing wikimedia workload with a present focus on transcoding
 *
 * @ingroup API
 */
class ApiWikiAtHome extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute(){
		$this->getMain()->isWriteMode();
		$this->mParams = $this->extractRequestParams();
		$request = $this->getMain()->getRequest();

		//do actions:
		if( $this->mParams['getnewjob'] ){
			//do job req:
			return $this->proccessJobReq();

		}elseif ( $this->mParams['jobkey'] ){
			//process a completed job:
			return $this->doProccessJobKey ( $this->mParams['jobkey'] ) ;
		}
	}
	/**
	 * Process a newJob req:
	 */
	function proccessJobReq(){

		if( isset( $this->mParams['jobset']) && $this->mParams['jobset']){
			$job = WahJobManager::getNewJob( $this->mParams['jobset'] );
		}else{
			$job = WahJobManager::getNewJob();
		}

		if(!$job){
			return $this->getResult()->addValue( null, $this->getModuleName(),
					array(
						'nojobs' => true
					)
				);
		}else{
			$job4Client = array();
			//unpack the $job_json
			$job4Client['job_json'] 	= FormatJson::decode( $job->job_json ) ;
			//we set the job key to job_id _ sha1
			$job4Client['job_key'] 		= $job->job_id . '_'. sha1( $job->job_json );
			$job4Client['job_title']	= $job->title;
			$job4Client['job_ns']		= $job->ns;
			$job4Client['job_set_id'] 	= $job->job_set_id;

			$tTitle = Title::newFromText($job->title, $job->ns);

			$job4Client['job_fullTitle'] = $tTitle->getFullText();

			//@@todo avoid an api round trip return url here:
			//$job4Client['job_url'] = $file->getFullURL();

			$this->getResult()->addValue(
				null,
				$this->getModuleName(),
				array(
					'job' => $job4Client
				)
			);
		}
	}
	/**
	 * process the submitted job:
	 */
	function doProccessJobKey( $job_key ){
		global $wgRequest, $wgUser;
		//check if its a valid job key (job_number _ sh1(job_json) )
		list($job_id, $json_sha1) = explode( '_', $job_key );

		//get the job object
		$job = WahJobManager::getJobById( $job_id );

		if( !$job || sha1($job->job_json) != $json_sha1){
			//die on bad job key
			return $this->dieUsage('Bad Job key', 'badjobkey') ;
		}

		$jobSet =  WahJobManager::getJobSetById( $job->job_set_id );

		//check if its a valid video ogg file (ffmpeg2theora --info)
		$uploadedJobFile = $wgRequest->getFileTempname('file');
		$mediaMeta = wahGetMediaJsonMeta( $uploadedJobFile );

		if( !$mediaMeta ){
			//failed basic ffmpeg2theora video validation
			return $this->dieUsage("Not a valid Video file", 'badfile');
		}

		//gab the ogg types from OggHandler.php
		global $wgOggVideoTypes, $wgOggAudioTypes;
		//check for theora and vorbis streams in the metadata output of the file:
		if( isset($wgOggVideoTypes) && isset($wgOggAudioTypes) ){
			$isOgg = false;

			foreach ( $mediaMeta->video as $videoStream ) {
				if(in_array( ucfirst( $videoStream->codec ),  $wgOggVideoTypes))
					$isOgg =true;
			}
			foreach ( $mediaMeta->audio as $audioStream ) {
				if(in_array( ucfirst( $audioStream->codec ),  $wgOggAudioTypes))
					$isOgg = true;
			}
			if(!$isOgg){
				return $this->dieUsage( 'Not a valid Ogg file', 'badfile' );
			}
		}

		//all good so far put it into the derivative temp folder by with each piece as it job_id name
		//@@todo need to rework this a bit for flattening "sequences"
		$fTitle = Title::newFromText( $jobSet->set_title, $jobSet->set_namespace );
		$file = wfLocalFile( $fTitle );
		$thumbPath = $file->getThumbPath( $jobSet->set_encodekey );

		$destTarget = $thumbPath .'/'. $job->job_order_id . '.ogg';
		if( is_file( $destTarget ) ){
			//someone else beat this user to finish the job? or out-of-sync file system?
			//kind of tricky to tie the old file to a particular user so lets just:
			unlink($destTarget);
			//compare the oshashes? take the later file if they don't match
			/*$metaDest = wahGetMediaJsonMeta( $destTarget );
			if( $mediaMeta->oshash == $metaDest->oshash ){

				return $this->dieUsage( 'The target upload file already exists', 'alreadydone' );
			}else{
				//old exipred file? or someone order a job to override? remove old chunk and continue proccessing:
				unlink($destTarget);
			}*/
		}
		//move the current chunk to that path:
		//@@todo use Repo methods (this is failing atm)
		/*$status = RepoGroup::singleton()->getLocalRepo()->store(
			$uploadedJobFile,
			'thumb',
			$destTarget
		);
		if( !$status->isGood() ){
			return $this->dieUsageMsg( array('code'=>'fileerror', 'info'=>'Could Not Move The Uploaded File') );
		}*/
		wfMkdirParents( $thumbPath, null, __METHOD__ );
		if( !move_uploaded_file($uploadedJobFile, $destTarget) ){
			return $this->dieUsage( 'Could Not Move The Uploaded File', 'fileerror' );
		}
		//issue the jobDone to the Manager:
		WahJobManager :: updateJobDone($job, $wgUser->getId());
		$dbw = wfGetDB( DB_SLAVE );

		//check if its the "last" job shell out a Join command
		$wjm = WahJobManager::newFromSet( $jobSet );
		$percDone = $wjm->getDonePerc();
		if($percDone != 1){
			//the stream is not done but success on chunk
			return $this->getResult()->addValue( null, $this->getModuleName(),
					array(
						'chunkaccepted' => true,
						'setdone'		=> false
					)
				);
		}elseif( $percDone == 1 ){
			//all the files are "done" according to the DB:
			//make sure all the files exist in the
			$fileList = array();
			for( $i=0; $i < $jobSet->set_jobs_count ; $i++ ){
				//make sure all the files are present:
				if(!is_file( "$thumbPath/{$i}.ogg" )){
					wfDebug('Missing wikiAtHome chunk $i');
					//unset the job complete state
					$dbw->update( 'wah_jobqueue',
						array(
							'job_done_time = NULL',
							'job_done_user_id = NULL'
						),
						array(
							'job_set_id' 	=> $jobSet->set_id,
							'job_order_id' 	=> $i
						),
						__METHOD__,
						array(
							'LIMIT' => 1
						)
					);
					//make sure jobset is not tagged done either:
					$dbw->update( 'wah_jobset',
						array(
							'set_done_time = NULL'
						),
						array(
							'set_id' 		=> $jobSet->set_id,
						),
						__METHOD__,
						array(
							'LIMIT' => 1
						)
					);
					//return missing files (maybe something is ~broken~)
					wfDebug("WikiAtHome database out of sync with file system?\nFile: $thumbPath/{$i}.ogg missing, re-adding job");
					return $this->getResult()->addValue( null, $this->getModuleName(),
						array(
							'chunkaccepted' => true,
							'setdone'		=> false
						)
					);
				}
				//else add it to the combine list:
				$fileList[] = "{$thumbPath}/{$i}.ogg";
			}
			$finalDestTarget = "{$thumbPath}.ogg";
			//make sure we have a set of thumbs to merge:
			if( count( $fileList )  > 1 ){
				//do merge request
				//@@todo do this in a background shell task
				//( if the files are very large video could take longer than 30 seconds to concatenate )
				wahDoOggCat( $finalDestTarget, $fileList);
			}else{
				//rename to $finalDestTarget
				$curThumbPath = current( $fileList );
				rename($curThumbPath, $finalDestTarget);
			}
			//if the file got created tag the jobset as done:
			if( is_file( $finalDestTarget )){
				//@@do some more checks (like length is accurate and is ogg video)

				//update jobSet done:
				WahJobManager :: updateSetDone( $jobSet );
				//send out stream done
				return $this->getResult()->addValue( null, $this->getModuleName(),
					array(
						'chunkaccepted' => true,
						'setdone'		=> true
					)
				);
			}else{
				wfDebug( "Concatenation Failed. Tag job as failed?");
				//tag the job as failed ( also put in the fail time )
				$dbw->update('wah_jobset',
					array(
						'set_done_time' => time(),
						'set_failed' => 1
					),
					array(
						'set_id' => $jobSet->set_id
					),
					__METHOD__,
					array(
						'LIMIT' => 1
					)
				);
				//send join failed
				return $this->dieUsage("Concatenation Failed: $curThumbPath to $finalDestTarget" . count( $fileList ) . ' ' .print_r( $fileList ), 'catfail');


			}
		}

		//return success

	}
	public function getAllowedParams() {
		return array(
			'file' 		=> null,
			'jobkey'	=> null,
			'getnewjob'	=> null,
			'jobset' 	=> null,
			'token' 	=> null
		);
	}

	public function getParamDescription() {
		return array(
			'file' 		=> 'the file or data being uploaded for a given job',
			'jobkey'	=> 'used to submit the resulting file of a given job key',
			'getnewjob'	=> 'set to ture to get a new job',
			'jobset' 	=> array('jobset used with getnewjob to set jobset. ',
								 '(this lets you work on jobs that use set data that you already have)'),
			'token' 	=> 'the edittoken (needed to submit job chunks)'
		);
	}

	public function getDescription() {
		return array(
			'Wiki@Home enables you to help with resource intensive operations at home ;)',
			' First login to the server. Then request a newjob.',
			' Process the job and send it back to the server.',
			' On subquent queries you can use "jobset" to request a job on data you already have downloaded',
			'Note that the HTTP POST must be done as a file upload (i.e. using multipart/form-data)'
		);
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getExamples() {
		return array(
			'Get A Job:',
			'    api.php?action=wikiathome&getnewjob=new',
			'Submit a Job:',
			'	 api.php?action=wikiathome&job_key=343&file={file_data}'
		);
	}
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiWikiAtHome.php 51812 2009-06-12 23:45:20Z dale $';
	}
}
