<?php 
/**
 * @ingroup timedmedia
 * @author michael dale
 */
class TesVideoTranscode extends ApiTestCaseVideoUpload {
	
	/**
	 * Once video files are uploaded test transcoding
	 * 
	 *  Test if a transcode job is added for a file once requested
	 * 
	 * @dataProvider mediaFilesProvider
	 */
	function testTranscodeJobs( $file ){
		// Upload the file to the mediaWiki system 
		$result = $this->uploadFile( $file );
		
		// Check for derivatives ( should trigger adding jobs ) 
		$fileName = basename( $file['filePath'] );
		$params = array(
			'action' => 'query',
			'titles' => 'File:' . $fileName,
			'prop' => 'videoinfo',
			'viprop' => "derivatives",
		);
		list($result,,) = $this->doApiRequest( $params );
		
		// Get the $derivatives: 
		$derivatives = $this->getDerivativesFromResult( $result );		
		// Only the "source" asset will be present at first: 
		$source = current( $derivatives );
		
		// Check that the source matches the api bandwidth property:
		$this->assertEquals( $file['bandwidth'], $source['bandwidth'] );
		
		// Check if the transcode jobs were added: 
		// get results: query jobs table
		$db = wfGetDB( DB_MASTER );
		$res = $db->select( 'transcode', '*', array( 
			'transcode_image_name' => ucfirst( $fileName )
		) );
		// Make sure we target at least one ogg and one webm:
		$hasOgg = $hasWebM = false;
		$targetEncodes = array();
		foreach( $res as $row ){
			$codec = WebVideoTranscode::$derivativeSettings[ $row->transcode_key ]['videoCodec'];
			if( $codec == 'theora' ){
				$hasOgg = true;
			}
			if( $codec == 'vp8' ){
				$hasWebM = true;
			}
			$targetEncodes[ $row->transcode_key ] = $row;
		};
		// Make sure we have ogg and webm:
		$this->assertTrue( $hasOgg && $hasWebM );
		
		// Now run the transcode job queue 
		$status = $this->runTranscodeJobs();
		
		
		$res = $db->select( 'transcode', '*', array( 
			'transcode_image_name' => ucfirst( $fileName )
		) );
		
		// Now check if the derivatives were created:
		list($result,,) = $this->doApiRequest( $params );		
		$derivatives = $this->getDerivativesFromResult( $result );		
		
		// Check that every requested encode was encoded: 
		foreach( $targetEncodes as $transcodeKey => $row ){
			$targetEncodeFound = false;
			foreach( $derivatives as $derv ){
				// The transcode key is always the last part of the file name:
				if( substr( $derv['src'], -1 * strlen( $transcodeKey ) ) == $transcodeKey ){
					$targetEncodeFound = true;
				}
			} 
			// Test that target encode was found: 
			$this->assertTrue( $targetEncodeFound );
		}
		
	}
	
	// Run Transcode job
	function runTranscodeJobs(){
		$dbw = wfGetDB( DB_MASTER );
		$type = 'webVideoTranscode';		
		// Set the condition to only run the webVideoTranscode
		$conds = "job_cmd = " . $dbw->addQuotes( $type );

		while ( $dbw->selectField( 'job', 'job_id', $conds, 'runJobs.php' ) ) {
			$offset = 0;
			for ( ; ; ) {
				$job = Job::pop_type( $type );
				if ( !$job )
					break;

				wfWaitForSlaves( 5 );
				$t = microtime( true );
				$offset = $job->id;
				$status = $job->run();
				$t = microtime( true ) - $t;
				$timeMs = intval( $t * 1000 );				
			}
		}
	}
	
	function getDerivativesFromResult( $result ){
		// Only the source should be listed initially: 
		$this->assertTrue( isset( $result['query']['pages'] ) );
		$page = current( $result['query']['pages'] );
		
		$videoInfo = current( $page['videoinfo'] );
		$this->assertTrue( isset( $videoInfo['derivatives'] ) );
		
		return $videoInfo['derivatives'];
	}
}