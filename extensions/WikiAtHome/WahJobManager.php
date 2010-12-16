<?php
class WahJobManager {
	//encoding profiles (settings set in config)

	function __construct(){
	}

	public static function newFromFile(&$file, $encodeKey){
		$wjm = new WahJobManager();
		$wjm->file = $file;

		$wjm->sEncodeKey = $encodeKey;
		$wjm->sNamespace = $wjm->file->title->getNamespace();
		$wjm->sTitle 	 = $wjm->file->title->getDBkey();

		return $wjm;
	}
	public static function newFromSet( $jobSet ){
		$wjm = new WahJobManager();
		$wjm->sNamespace 	= $jobSet->set_namespace;
		$wjm->sTitle 		= $jobSet->set_title;
		$wjm->sEncodeKey 	= $jobSet->set_encodekey;
		return $wjm;
	}

	function getEncodeKey(){
		if(isset($this->sEncodeKey))
			return $this->sEncodeKey;
		return false;
	}
	function getTitle(){
		if(isset($this->sTitle))
			return $this->sTitle;
		return false;
	}
	function getNamespace(){
		if( isset( $this->sNamespace ) )
			return $this->sNamespace;
		return false;
	}
	function getSetId(){
		if( isset(  $this->sId ) )
			return $this->sId;
		$this->getSet();
		$this->sId = $this->mSetRow->sId;
		return $this->sId;
	}
	function getSet(){
		if( isset( $this->mSetRow ) )
			return $this->mSetRow;
		$dbr = &wfGetDb( DB_READ );
		//grab the jobset
		$this->mSetRow = $dbr->selectRow('wah_jobset',
			'*',
			array(
				'set_namespace' => $this->sNamespace,
				'set_title'		=> $this->sTitle,
				'set_encodekey'	=> $this->sEncodeKey
			),
			__METHOD__
		);
		return $this->mSetRow;
	}
	/*
	 * get the percentage done (return 1 if done)
	 */
	function getDonePerc(){
		$setRow = $this->getSet();
		if( !$setRow ){
			//we should setup the job:
			$this->doJobSetup();
			//return 0 percent done
			return 0;
		}else{
			$dbr = &wfGetDb( DB_READ );
			//quick check if we are done at the set level:
			if( $setRow->set_done_time ){
				if( $this->doSetFileCheck() ){
					return 1;
				}else{
					return -1;
				}
			}

			//else check how done are we:
			$this->sId = $setRow->set_id;
			$this->sJobsCount = $setRow->set_jobs_count;
			//get an estimate of how many jobs are done  (not null)
			//@@note:  estimateRowCount ~might be more appropriate
			// but it was behaving inconsistently for me~
			$doneRes = $dbr->select('wah_jobqueue',
				'job_id',
				array(
					'job_set_id' => $this->sId,
					'job_done_time IS NOT NULL'
				),
				__METHOD__
			);
			$doneCount = $dbr->numRows( $doneRes );
			if( $doneCount == $this->sJobsCount ){
				//update the job_set (should already hae been done)
				return 1;
			}
			//return 1 when doneCount == sJobCount
			//(we also set this at a higher level and avoid hitting the wah_jobqueue table alltogehter)
			return round( $doneCount / $this->sJobsCount , 2);
		}
	}
	function doSetFileCheck( ){
		//get the title:
		$fTitle = Title::newFromText( $this->getTitle(), $this->getNamespace() );
		$file = RepoGroup::singleton()->getLocalRepo()->newFile( $fTitle );
		$thumbPath = $file->getThumbPath( $this->getEncodeKey() );
		return is_file ( $thumbPath . '.ogg' );
	}
	/*
	 * returns a new job
	 *
	 * @param prefered jobset id
	 *
	 * returns the jobs object or false if no jobs are available
	 */
	static function getNewJob( $jobset_id = false , $reqMode = 'AtHome'){
		global $wgNumberOfClientsPerJobSet, $wgJobTimeOut, $wgUser, $wgJobTypeConfig;
		$dbr = wfGetDb( DB_READ );

		//its always best to assigning from jobset (since the user already has the data)
		if( $jobset_id ){
			$jobSet = WahJobManager::getJobSetById( $jobset_id );
			if(!$jobSet)
				return false; //not a valid job_set key (no jobs for you)

			//check if the jobset is an accepted job type
			if( WahJobManager::validateJobType( $jobSet->set_job_type, $reqMode) ){
				//try to get one from the current jobset
				$job = $dbr->selectRow( 'wah_jobqueue',
					'*',
					array(
						'job_set_id' =>  intval( $jobset_id ),
						'job_done_time IS NULL',
						'job_last_assigned_time < '.  $dbr->addQuotes( time() - $wgJobTimeOut )
					),
					__METHOD__
				);
				if( $job ){
					return WahJobManager::assignJob( $job );
				}
			}
		}

		//check if we already have a job given but never completed:
		$job = $dbr->selectRow( 'wah_jobqueue',
			'*',
			array(
				'job_last_assigned_user_id' => $wgUser->getId(),
				'job_done_time is NULL'
			),
		 	__METHOD__
		);
		if($job){
			$jobSet = WahJobManager::getJobSetById( $job->job_set_id );
			//make sure the job is oky to assign:
			if( WahJobManager::validateJobType( $jobSet->set_job_type, $reqMode) ){
				//re-assign the same job (don't update anything so it can timeout if they keep getting the same job)
				return WahJobManager::assignJob( $job , false, false);
			}
		}

		$conditionAry =array(
			'set_done_time IS NULL',
			'set_client_count < '.  $dbr->addQuotes( $wgNumberOfClientsPerJobSet )
		);

		//build a request to get a compatible job:
		$okyJobOrList = '';
		$or = '';
		foreach($wgJobTypeConfig as $tKey=>$tSet){
			if( $tSet['assign' . $reqMode] ){
				$okyJobOrList .= $or . ' ( set_job_type = ' . $dbr->addQuotes(  $tKey ) . ' )';
				$or = ' OR ';
			}
		}
		//no valid jobs:
		if( $okyJobOrList=='' ){
			return false;
		}
		//else add it to the sql statement :
		if( $okyJobOrList != '' ){
			//no types are assignAtHome
			$conditionAry[] = $okyJobOrList;
		}

		//just do a normal select from jobset
		$jobSet = $dbr->selectRow( 'wah_jobset',
			'*',
			$conditionAry,
			__METHOD__
		);

		if( !$jobSet ){
			//no jobs:
			return false;
		}else{
			//get a job from the jobset and increment the set_client_count
			//(if the user has an unfinished job) re assign it (in cases where job is lost in trasport)
			//get a job from the selected jobset:
			$job = $dbr->selectRow('wah_jobqueue', '*',
					array(
						'job_set_id' => $jobSet->set_id,
						'job_done_time IS NULL',
						'job_last_assigned_time IS NULL OR job_last_assigned_time < ' .
							 $dbr->addQuotes( time() - $wgJobTimeOut )
					),
					__METHOD__
			);
			if( !$job ){
				//no jobs in this jobset (return nojob)
				//@@todo we could "retry" since we will get here when a set has everything assigned in less than $wgJobTimeOut
				return false;
			}else{
				return WahJobManager::assignJob( $job , $jobSet);
			}
		}
	}
	static function validateJobType( $reqType, $reqMode ){
		global $wgJobTypeConfig;
		return $wgJobTypeConfig[ $reqType ][ 'assign' . $reqMode ];
	}
	/*
	 * assigns a job:
	 *
	 * @param $job result object
	 *
	 * returns $job result object;
	 */
	static function assignJob( & $job, $jobSet = false, $doUpdate=true ){
		global $wgUser;
		$dbr = wfGetDb( DB_READ );
		$dbw = wfGetDb( DB_WRITE );
		if( $jobSet == false ){
			$jobSet = self::getJobSetById( $job->job_set_id );
		}
		//set the title and namespace:
		$job->title = $jobSet->set_title;
		$job->ns	= $jobSet->set_namespace;

		//check if we should update the tables for the assigned Job
		if( $doUpdate ){
			//for jobqueue update: job_last_assigned_time, job_last_assigned_user_id, job_assign_count
			$dbw->update('wah_jobqueue',
				array(
					'job_last_assigned_time'	=> time(),
					'job_last_assigned_user_id'	=> $wgUser->getId(),
					'job_assign_count' 			=> $job->job_assign_count ++
				),
				array(
					'job_id'	=> $job->job_id
				),
				__METHOD__,
				array(
					'LIMIT'	=>	1
				)
			);
			//for jobset update: set_client_count  (if job was not previously assigned)
			//and if jobset is present (most repeat clients should have the data already)
			if( $jobSet && is_null( $job->job_last_assigned_user_id ) ){
				$dbw->update('wah_jobset',
					array(
						'set_client_count = set_client_count+1'
					),
					array(
						'set_id'	=>	$job->job_set_id
					),
					__METHOD__,
					array(
						'LIMIT'	=>	1
					)
				);
			}
		}
		return $job;
	}
	static function getJobSetById( $set_id ){
		$dbr = wfGetDb( DB_READ );
		return  $dbr->selectRow('wah_jobset', '*',
			array(
				'set_id' => $set_id
			),
			__METHOD__
		);
	}
	static function getJobById( $job_id ){
		$dbr = wfGetDb( DB_READ );
		return $dbr->selectRow('wah_jobqueue', '*',
			array(
				'job_id' => $job_id
			),
			__METHOD__
		);
	}
	/*
	 * setups up a new job
	 */
	function doJobSetup(){
		global $wgDerivativeSettings, $wgJobTypeConfig;
		$fname = 'WahJobManager::doJobSetup';
		$dbw = &wfGetDb( DB_WRITE );

		if( $wgJobTypeConfig[ $this->getJobTypeKey() ]['chunkDuration'] == 0){
			$set_job_count = 1;
		}else{
			//figure out how many sub-jobs we will have:
			$length = $this->file->handler->getLength( $this->file );
			$set_job_count = ceil( $length / $wgJobTypeConfig[ $jobTypeKey ]['chunkDuration'] );
		}

		//first insert the job set
		$dbw->insert('wah_jobset',
			array(
				'set_namespace' 	=> $this->sNamespace,
				'set_title'			=> $this->sTitle,
				'set_jobs_count' 	=> $set_job_count,
				'set_encodekey'		=> $this->sEncodeKey,
			  	'set_creation_time' => time()
			), $fname
		);
		$this->sId = $dbw->insertId();

		//generate the job data
		$jobInsertArray = $this->gennerateJobData();

		//now insert the jobInsertArray
		$dbw->insert( 'wah_jobqueue', $jobInsertArray, $fname );
	}
	function gennerateJobData(){
		global $wgJobTypeConfig, $wgDerivativeSettings;

		$jobTypeKey = $this->getJobTypeKey();

		//set the base encode settings:
		$encSettingsAry = $wgDerivativeSettings[ $this->sEncodeKey ];

		//init the jobs array:
		$jobInsertArray = array();

		$jobJsonAry = array(
			'jobType'			=> $jobTypeKey,
			'encodeSettings'	=> $encSettingsAry
		);

		//check if we need to split into chunks: (if chunk duration is zero don't split)
		if( $wgJobTypeConfig[ $jobTypeKey ]['chunkDuration'] == 0 ){
			$jobInsertArray[] =
				array(
					'job_set_id' 	=> $this->sId,
					'job_order_id'	=> 0,
					'job_json'	 	=> FormatJson::encode( $jobJsonAry )
				);
		}else{
			for( $i=0 ; $i < $set_job_count; $i++ ){
				//add starttime and endtime
				$jobJsonAry['encodeSettings']['starttime'] = $i * $wgJobTypeConfig[ $jobTypeKey ]['chunkDuration'];
				//should be oky that the last endtime is > than length
				$jobJsonAry['encodeSettings']['endtime'] = $encSettingsAry['starttime'] + $wgChunkDuration;
				$jobInsertArray[] =
					array(
						'job_set_id' 	=> $this->sId,
						'job_order_id'	=> $i,
						'job_json'	 	=> FormatJson::encode( $jobJsonAry )
					);
			}
		}
		return $jobInsertArray;
	}
	function getJobTypeKey(){
		//if its in the file namespace the job is a transcode
		if($this->sNamespace == NS_FILE){
			return 'transcode';
		}
		//if its in the "sequence" namespace then its a flatten job
	}
	function updateSetDone($jobSet, $user_id=0){
		$dbw = &wfGetDb( DB_WRITE );
		$dbw->update('wah_jobset',
			array(
				'set_done_time' => time()
			),
			array(
				'set_id' => $jobSet->set_id
			),
			__METHOD__,
			array(
				'LIMIT' => 1
			)
		);
	}
	function updateJobDone(&$job, $user_id=0){
		$dbw = &wfGetDb( DB_WRITE );
		//update the jobqueue table with job done time & user
		$dbw->update('wah_jobqueue',
			array(
				'job_done_user_id' 	=> $user_id,
				'job_done_time'		=> time()
			),
			array(
				'job_id'			=> $job->job_id
			),
			__METHOD__,
			array(
				'LIMIT' => 1
			)
		);

		// reduce job_client_count by 1 now that this client is "done"
		$dbw->update('wah_jobset',
			array(
				'set_client_count = set_client_count -1'
			),
			array(
				'set_id' => $job->job_set_id
			),
			__METHOD__,
			array(
				'LIMIT' => 1
			)
		);
	}

}
