<?php 
/**
 * Allows for api queries to get detailed information about the transcode state of a particular
 * media asset. ( basically directly returns the transcode status table )  
 * 
 * This information can be used to generate status tables similar to the one seen 
 * on the image page.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once( "ApiBase.php" );
}

class ApiTranscodeStatus extends ApiQueryBase {
	public function execute() {
		$pageIds = $this->getPageSet()->getAllTitlesByNamespace();
		// Make sure we have files in the title set: 
		if ( !empty( $pageIds[NS_FILE] ) ) {
			$titles = array_keys( $pageIds[NS_FILE] );
			asort( $titles ); // Ensure the order is always the same
			
			$result = $this->getResult();
			$images = RepoGroup::singleton()->findFiles( $titles );
			foreach ( $images as $img ) {
				// if its a "transcode" add the transcode status table output
				if( TimedMediaHandlerHooks::isTranscodableTitle( $img->getTitle() ) ){
					$transcodeStatus = WebVideoTranscode::getTranscodeState( $img->getTitle()->getDBKey() );
					// remove useless properties 
					foreach($transcodeStatus as $key=>&$val ){
						unset( $val['id'] );
						unset( $val['image_name']);
						unset( $val['key'] );
					}
					$result->addValue( array( 'query', 'pages', $img->getTitle()->getArticleID() ), 'transcodestatus', $transcodeStatus );
				}
			}
		}
	}
	public function getCacheMode( $params ) {
		return 'public';
	}
	public function getAllowedParams() {
		return array();
	}

	public function getDescription() {
		return array(
			'Get transcode status for a given file page'
		);
	}
	
	public function getExamples() {
		return array (
			'api.php?action=query&prop=transcodestatus&titles=File:Clip.webm',
		);
	}
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryFlagged.php 85713 2011-04-09 04:30:07Z aaron $';
	}
}