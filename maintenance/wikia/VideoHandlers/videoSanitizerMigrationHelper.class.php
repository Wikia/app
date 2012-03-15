<?php

class videoSanitizerMigrationHelper { 

	private $city_id;
	
	
	public function __construct($city_id, $city_name, $wgExternalDatawareDB) {
		if(!isset($_SERVER['QUERY_STRING'])) {
			$_SERVER['QUERY_STRING'] = '(maintenance script)';
		}
		$this->dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$this->city_id = (int)$city_id;
		$this->city_name = $city_name;
	}
	
	/*
	 * Returns an array of old/new video titles
	 * @param string $key - old|new - structure of returned array will be:
	 * if $key==old: array[old_name] = new_name
	 * if $key==new: array[new_name] = old_name
	 * @param string $filter - extra param to where statment
	 */
	public function getRenamedVideos($key="old", $filter=" 1=1") {
		
		$rows = $this->dbw_dataware->query( "SELECT old_title, sanitized_title 
											 FROM video_migration_sanitization
											 WHERE city_id=".$this->city_id." AND $filter" );
		$rowCount = $rows->numRows();
		$result = array();
		if ( $rowCount ) {
			
			while( $row = $this->dbw_dataware->fetchObject( $rows ) ) {
				if ( $key=="old" ) {
					$result[ $row->old_title ] = $row->sanitized_title;
				} else {
					$result[ $row->sanitized_title ] = $row->old_title;
				}
			}			
		}
		$this->dbw_dataware->freeResult( $rows );
		return $result;
	}
	
	/*
	 * Logs old title to DB
	 * @param string $oldTitle
	 * @param string $sanitizedTitle
	 * @param string $operationStatus (UNKNOWN,OK,FAIL) - status of appending changes to articles and related tables
	 */
	public function logVideoTitle($oldTitle, $sanitizedTitle, $operationStatus="UNKNOWN", $articleTitle="") {
		
		$this->dbw_dataware->replace('video_migration_sanitization',
			array( 'city_id', 'old_title' ),
			array(
				'city_id'			=> $this->city_id,
				'old_title'			=> $oldTitle,
				'sanitized_title'	=> $sanitizedTitle,
				'operation_status'	=> $operationStatus,
				'operation_time'	=> date("YmdHis"),
				'article_title'		=> $articleTitle
			),
			'videoSanitizerMigrationHelper::logVideoTitle'
		);
		
	}


	public function logFailedEdit($articleId, $articleTitleText, $articleNamespace, $from, $to) {

		$this->dbw_dataware->insert('video_sanitization_failededit',
			array(
				'city_id'			=> $this->city_id,
				'city_name'			=> $this->city_name,
				'article_id'		=> $articleId,
				'article_title'		=> $articleTitleText,
				'article_namespace'	=> $articleNamespace,
				'rename_from'		=> $from,
				'rename_to'			=> $to,
			),
			'videoSanitizerMigrationHelper::logFailedEdit'
		);

	}

	
}




?>
