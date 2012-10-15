<?php

class ApiRPED extends ApiBase {
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;
		/*if (!$this->userCanExecute( $wgUser )) {
			$this->displayRestrictionError();
			return;
		}*/

		if( !$wgUser->isAllowed( 'rped' ) ) {
			$this->displayRestrictionError();
			return;
		}

        #$dbw->insert('rped_pages',array('rped_page_title' => $subValue));
		$params = $this->extractRequestParams(false);
		/*foreach ($params as $key => $value) {
			$dbw->insert('rped_page',array('rped_page_title' => $key));
			$dbw->insert('rped_page',array('rped_page_title' => $value));
		}*/
		foreach( $params as $key => $value ) {
			if( $key != null && $value!= null ) {
				ApiRPED::paramProcess( $key,$value );
			}
        }
        return;
    }

	/**
	 * Insert or delete a row from the rped_page table
	 * @param key "insert" or "delete"
	 * @param $value Page name to delete
	 */
	public function paramProcess( $key,$value ){
		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );
		$myInputNum = 0;
		$strLen = strlen( $value );
		for( $count = 0; $count < $strLen; $count++ ) {
			if ( substr( $value, $count, 1 ) == '|' ){
				$myInputNum++;
			} else {
				if ( !isset( $myInput[$myInputNum] ) ) {
					$myInput[$myInputNum] = '';
				}
				if ( substr( $value, $count, 1 ) == ' ' ) {
					$myInput[$myInputNum] .= '_';
				} else {
					$myInput[$myInputNum] .= substr( $value, $count, 1 );
				}
			}
		}
		if( isset( $myInput ) ) {
			foreach( $myInput as $subValue ) {
				if ( isset( $subValue ) && $subValue !== null ) {
					$subValue=urldecode($subValue);
					$existCheck = null;
					$existCheck = $dbr->selectRow( 'rped_page', 'rped_page_title',
						array( 'rped_page_title' => $subValue ) );
					#$dbw->insert('rped_page',array('rped_page_title' => "key: ".$key));
					#$dbw->insert('rped_page',array('rped_page_title' => "subValue: ".$subValue));
					#if($key=='insert' && !isset($existCheck) && $existCheck!=null){
					if( $key == 'insert' && ( !isset( $existCheck ) || $existCheck == null ) ) {
						$dbw->insert( 'rped_page', array( 'rped_page_title' => $subValue ) );
					}
					if ($key=='delete' && isset( $existCheck ) && $existCheck != null ) {
						$dbw->delete( 'rped_page', array( 'rped_page_title' => $subValue ) );
					}
				}
			}
		}
	}

	public function getAllowedParams(){
		return array(
			'insert' => null,
			'delete' => null
		);
	}

	public function getParamDescription(){
		return array (
			'insert' => 'page name to insert',
			'delete' => 'page name to delete'
		);
	}

	public function getDescription(){
		return array (
			'This module is used to insert data into, and delete date from, ',
			'the RPED page name table.'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

	public function displayRestrictionError(){
		echo("Access denied.");
	}
}
