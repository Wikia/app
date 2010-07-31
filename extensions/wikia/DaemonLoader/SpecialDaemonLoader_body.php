<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class DaemonLoader extends SpecialPage {
	/**
	 * Constructor
	 */
	static $oName = 'DaemonLoader';
	static $paramsRows = 10;
	static $paramsType = array();

	function __construct() {
		parent::__construct( self::$oName, 'daemonloader' );
		wfLoadExtensionMessages( self::$oName );
	}

	/**
	 * main()
	 */
	function execute( $par = null ) {
		global $wgVersion, $wgRequest, $wgOut, $wgContLang, $wgUser;

		wfLoadExtensionMessages( self::$oName );

		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			$wgOut->permissionRequired( 'daemonloader' );
			return;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, self::$oName );
		$wgOut->setPageTitle( wfMsg( "daemonloader_pagetitle" ) );
		$wgOut->setRobotpolicy( "noindex,nofollow" );

		self::$paramsType = array (
			'1' => wfMsg( 'daemonloader_string' ),
			'2' => wfMsg( 'daemonloader_number' ),
			'3' => wfMsg( 'daemonloader_date_yyyymmdd' ),
			'4' => wfMsg( 'daemonloader_date_yyyymm' ),
			'5' => wfMsg( 'daemonloader_date_yyyy' ),
			'6' => wfMsg( 'daemonloader_wikilist' ),
		);

		$action = $wgRequest->getVal( 'dt_action' );
		if ( $wgRequest->wasPosted() && ( in_array( $action, array( 'save', 'savetask' ) ) ) ) {
			$res = false;
			switch ( $action ) {
				case "save" : {
					$res = $this->saveDaemon();
					$res = ( !empty( $res ) ) ? 1 : "";
					break;
				}
				case "savetask" : {
					$res = $this->saveTask();
					$res = ( !empty( $res ) ) ? 2 : "";
					break;
				}
			}
			$titleObj = Title::makeTitle( NS_SPECIAL, 'DaemonLoader' );
			$saved = "saved=" . ( ( empty( $res ) ) ? "-1" : $res );
			$check = $titleObj->getFullURL( $saved );
			return $wgOut->redirect( $check );
		} elseif ( $par == 'report' ) {
			$job_id = $wgRequest->getVal( 'id' );
			$fileNbr = $wgRequest->getVal( 'file' );
			if ( !empty( $job_id ) && !empty( $fileNbr ) ) {
				$res = $this->getXLSFile( $job_id, $fileNbr );
				if ( $res === false ) {
					return $wgOut->redirect( Title::makeTitle( NS_SPECIAL, 'DaemonLoader' )->getFullURL() );
				}
			}
		}

		$oTaskHTML = new DaemonLoaderHTML();
		$sHtml = "";
		if ( $oTaskHTML ) {
			$sHtml = $oTaskHTML->outputHTML();
		}

		$wgOut->addHTML( $sHtml );
	}

	static public function getAllDaemons( $dt_id = 0 ) {
		global $wgMemc, $wgExternalDatawareDB;
		global $wgCityId;
        wfProfileIn( __METHOD__ );
		$aResult = array();
		$memkey = wfForeignMemcKey( $wgExternalDatawareDB, null, "getAllDaemons", $dt_id );
		$cached = $wgMemc->get( $memkey );
		if ( !is_array ( $cached ) ) {
			$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
			if ( !is_null( $dbs ) ) {
				$where = ( $dt_id > 0 ) ? " and dt_id = " . intval( $dt_id ) : "";
				$oRes = $dbs->select(
					array( "daemon_tasks" ),
					array( "dt_id, dt_name, dt_script, dt_desc, dt_input_params" ),
					array( "dt_name != '' $where and dt_visible = 1" ),
					__METHOD__,
					array( "ORDER BY" => "dt_name" )
				);
				while ( $oRow = $dbs->fetchObject( $oRes ) ) {
					$aResult[$oRow->dt_id] = array(
						'dt_id' => $oRow->dt_id,
						'dt_name' => $oRow->dt_name,
						'dt_script' => $oRow->dt_script,
						'dt_desc' => $oRow->dt_desc,
						'dt_input_params' => $oRow->dt_input_params
					);
				}
				$dbs->freeResult( $oRes );
				$wgMemc->set( $memkey, $aResult, 60 * 60 );
			}
		} else {
			$aResult = $cached;
		}

        wfProfileOut( __METHOD__ );
		return $aResult;
	}

	static public function getAllJobs( $dj_id = 0, $orderby = 'dj_id', $limit = 30, $offset = 0, $desc = 0 ) {
		global $wgExternalDatawareDB, $wgCityId;
        wfProfileIn( __METHOD__ );
		$aResult = array();
		$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		if ( !is_null( $dbs ) ) {
			$orderby = ( empty( $orderby ) ) ? "dj_id" : $orderby;
			$where = ( $dj_id > 0 ) ? " and dj_id = " . intval( $dj_id ) : "";
			$oRes = $dbs->select(
				array( "daemon_tasks_jobs" ),
				array( "dj_id, dj_dt_id, date_format(dj_start, '%Y-%m-%d') as st, date_format(dj_end, '%Y-%m-%d') as end, dj_frequency, dj_visible, dj_param_values, dj_result_file, dj_result_emails, dj_createdby, dj_added" ),
				array( "dj_dt_id > 0 $where and dj_visible = 1" ),
				__METHOD__,
				array( "ORDER BY" => $orderby . ( ( $desc == 0 ) ? " asc" : " desc" ), 'LIMIT' => $limit, 'OFFSET' => intval( $offset ) * $limit, 'SQL_CALC_FOUND_ROWS' )
			);
			$aResult = array();
			while ( $oRow = $dbs->fetchObject( $oRes ) ) {
				$oUser = User::newFromId( $oRow->dj_createdby );
				$xlsFiles = self::listXLSFiles( $oRow->dj_id, $oRow->dj_result_file );
				$aResult[] = array(
					'id' => $oRow->dj_id,
					'dt_id' => $oRow->dj_dt_id,
					'frequency' => $oRow->dj_frequency,
					'visible' => $oRow->dj_visible,
					'param_values' => $oRow->dj_param_values,
					'result_file' => $oRow->dj_result_file,
					'result_xls_files' => $xlsFiles,
					'result_emails' => $oRow->dj_result_emails,
					'createdby' => $oUser,
					'start' => $oRow->st,
					'end' => $oRow->end,
					'added' => $oRow->dj_added
				);
			}
			$dbs->freeResult( $oRes );

			# nbr all records
			$oRes = $dbs->query( 'SELECT FOUND_ROWS() as rowcount' );
			$oRow = $dbs->fetchObject ( $oRes );
			$cnt = $oRow->rowcount;
			$dbs->freeResult( $oRes );

			$aResult = array( 0 => $cnt, 1 => $aResult );
		}

        wfProfileOut( __METHOD__ );
		return $aResult;
	}

	public function saveDaemon() {
		global $wgCityId, $wgUser;
		global $wgRequest;
		global $wgExternalDatawareDB;
		$res = true;
        wfProfileIn( __METHOD__ );
		$dbs = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$dt_id = intval( $wgRequest->getVal( "dt_id" ) );
		$dt_name = $wgRequest->getVal( "dt_name" );
		$dt_script = $wgRequest->getVal( "dt_script" );
		$dt_desc = $wgRequest->getVal( "dt_desc" );
		# -- params
		$params = array();
		for ( $i = 0; $i < self::$paramsRows; $i++ ) {
			$paramName = $wgRequest->getVal( "dt_param_name_" . $i );
			if ( isset( $paramName ) ) {
				$descParam = $wgRequest->getVal( "dt_param_desc_" . $i );
				$defParam = $wgRequest->getVal( "dt_param_defvalue_" . $i );
				$typeParam = $wgRequest->getVal( "dt_param_type_" . $i );
				if ( !$wgRequest->getCheck( "dt_param_remove_" . $i ) ) {
					$params[$paramName] = array(
						'desc' => $descParam,
						'default' => $defParam,
						'type' => $typeParam
					);
				}
			}
		}
		$dt_params = @serialize( $params );

		$dbs->begin();
		if ( empty( $dt_id ) ) {
			$dbs->insert(
				"daemon_tasks",
				array(
					"dt_name" => $dt_name,
					"dt_script" => $dt_script,
					"dt_desc" => $dt_desc,
					"dt_input_params" => $dt_params,
					"dt_addedby" => $wgUser->getId(),
					"dt_added" => wfTimestamp(),
				),
				__METHOD__
			);
		} else {
			if ( $wgRequest->getVal( "dt_remove", false ) ) {
				// remove (so set as non-visible)
				$dbs->update(
					"daemon_tasks",
					array( "dt_visible" => 0 ),
					array( "dt_id" => $dt_id ),
					__METHOD__
				);
			} elseif ( $wgRequest->getVal( "dt_submit", false ) ) {
				// update
				$dbs->update(
					"daemon_tasks",
					array(
						"dt_name" => $dt_name,
						"dt_script" => $dt_script,
						"dt_desc" => $dt_desc,
						"dt_input_params" => $dt_params,
						"dt_addedby" => $wgUser->getId(),
					),
					array( "dt_id" => $dt_id ),
					__METHOD__
				);
			} else {
				// invalid action
			}
		}
		$dbs->commit();

        wfProfileOut( __METHOD__ );

		return $res;
	}

	public static function closeJob( $dj_id ) {
		$res = 0;
		if ( $dj_id > 0 ) {
			global $wgExternalDatawareDB;
			$dbs = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
			$dbs->begin();
			$dbs->update(
				"daemon_tasks_jobs",
				array( "dj_visible" => 0 ),
				array( "dj_id" => $dj_id ),
				__METHOD__
			);
			$dbs->commit();
			$res = 1;
		}

		return $res;
	}

	public function saveTask() {
		global $wgCityId, $wgUser;
		global $wgRequest;
		global $wgExternalDatawareDB;
		$res = false;
		wfProfileIn( __METHOD__ );

		$daemon_id = intval( $wgRequest->getVal( "dt-daemons" ) );
		if ( $daemon_id != 0 ) {
			$daemon = $this->getAllDaemons( $daemon_id );
			if ( !empty( $daemon ) && !empty( $daemon[$daemon_id] ) ) {
				# set params
				$saveParams = "";
				$aParams = @unserialize( $daemon[$daemon_id]['dt_input_params'] );
				if ( !empty( $aParams ) && is_array( $aParams ) ) {
					$_tmp = array();
					foreach ( $aParams as $key => $values ) {
						$keyValue = $wgRequest->getVal( $key );
						$keyValue = str_replace( " ", "", $keyValue );
						if ( isset( $keyValue ) && !empty( $keyValue ) ) {
							$_tmp[] = "--$key=$keyValue";
						}
					}
					$saveParams = implode( " ", $_tmp );
				}
				# other task params
				$dt_start = trim( $wgRequest->getVal( "dt_start" ) );
				$dt_end = trim( $wgRequest->getVal( "dt_end" ) );
				$dt_frequency = $wgRequest->getVal( "dt_frequency" );
				$dt_emails = $wgRequest->getVal( "dt_emails" );

				if ( empty( $dt_start ) || ( strlen( $dt_start ) != 8 ) ) {
					$dt_start = date( "Ymd", mktime( 0, 0, 0, date( "m" ), date( "d" ) + 1, date( "Y" ) ) );
				}
				if ( empty( $dt_end ) || ( strlen( $dt_end ) != 8 ) ) {
					$dt_end = date( "Ymd", mktime( 0, 0, 0, date( "m" ) + 6, date( "d" ), date( "Y" ) ) );
				}

				$dbs = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
				$dbs->begin();
				$dbs->insert(
					"daemon_tasks_jobs",
					array(
						"dj_dt_id" => $daemon_id,
						"dj_start" => trim( $dt_start ),
						"dj_end" => trim( $dt_end ),
						"dj_frequency" => $dt_frequency,
						"dj_visible" => 1,
						"dj_param_values" => $saveParams,
						"dj_result_emails" => trim( $dt_emails ),
						"dj_createdby" => $wgUser->getId(),
						"dj_added" => wfTimestamp()
					),
					__METHOD__
				);
				$dbs->commit();
				$res = true;
			}
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getXLSFile ( $dj_id, $index = 0 ) {
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname;
		global $wgContLang, $wgOut;
        wfProfileIn( __METHOD__ );

		$res = false;
		list ( , $oRows ) = $this->getAllJobs( $dj_id );
		if ( !empty( $oRows ) && is_array( $oRows[0] ) ) {
			$sFiles = $oRows[0]['result_file'];
        	$aFiles = explode( ",", $sFiles );
        	krsort( $aFiles );
        	$aUrls = array();
        	$loop = 0; $fileToSave = "";
        	foreach ( $aFiles as $id => $fileName ) {
        		if ( !empty( $fileName ) ) {
        			$aFileInfo = pathinfo( $fileName );
        			$loop++;
        			if ( $index == $loop ) {
        				$fileToSave = $fileName;
        				break;
					}
				}
			}
			if ( !empty( $fileToSave ) ) {
				$this->getFileFromServer( $fileToSave );
			}
		}
        wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getFileFromServer ( $path ) {
        wfProfileIn( __METHOD__ );
		if ( !file_exists( $path ) ) {
	        wfProfileOut( __METHOD__ );
			exit;
		}

		$size = filesize( $path );
		$file = basename( $path );
		$time = date( 'r', filemtime( $path ) );
		$fm = @fopen( $path, 'rb' );
		if ( !$fm ) {
	        wfProfileOut( __METHOD__ );
			exit;
		}

		$beginSize = 0;
		$endSize = $size;

		if ( isset( $_SERVER['HTTP_RANGE'] ) ) {
			if ( preg_match( '/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches ) ) {
				$beginSize = intval( $matches[0] );
				if ( !empty( $matches[1] ) ) {
					$endSize = intval( $matches[1] );
				}
			}
		}

		if ( $beginSize > 0 || $endSize < $size ) {
			header( 'HTTP/1.0 206 Partial Content' );
		} else {
			header( 'HTTP/1.0 200 OK' );
		}

		header( "Content-Type: application/octet-stream" );
		header( 'Cache-Control: public, must-revalidate, max-age=0' );
		header( 'Pragma: no-cache' );
		header( 'Accept-Ranges: bytes' );
		header( 'Content-Length:' . ( $endSize - $beginSize ) );
		header( "Content-Range: bytes $beginSize - $endSize/$size" );
		header( "Content-Disposition: inline; filename=$file" );
		header( "Content-Transfer-Encoding: binary\n" );
		header( "Last-Modified: $time" );
		header( 'Connection: close' );
		$curSeek  = $beginSize;
		fseek( $fm, $beginSize, 0 );
		while ( !feof( $fm ) && $curSeek < $endSize && ( connection_status() == 0 ) ) {
			print fread( $fm, min( 1024 * 16, $endSize - $curSeek ) );
			$curSeek += 1024 * 16;
			flush();
        	ob_flush();
		}
		fclose( $fm );
        wfProfileOut( __METHOD__ );
		exit;
	}

	public function getXLSHeader( $filename ) {
        wfProfileIn( __METHOD__ );
		$len = filesize( $filename );
		$file = basename( $filename );
		$ctype = "application/x-gzip";

		header( "HTTP/1.0 200 OK" );
		header( "Pragma: public" );
		header( "Expires: 0" );
		header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header( "Cache-Control: public" );
		header( "Content-Description: File Transfer" );
		header( "Content-Type: $ctype" );
		header( "Content-Disposition: attachment; filename=" . $file . ";" );
		header( "Content-Transfer-Encoding: binary" );
		header( "Content-Length: " . $len );
		@readfile( $filename );
        wfProfileOut( __METHOD__ );
		exit;
	}

	public static function listXLSFiles( $jobId, $sFiles ) {
		global $wgUser, $wgExtensionsPath;

        wfProfileIn( __METHOD__ );
        $res = "";
        if ( !empty( $sFiles ) ) {
        	$sk = $wgUser->getSkin();
        	$aFiles = explode( ",", $sFiles );
        	krsort( $aFiles );
        	$aUrls = array();
        	$loop = 0;
        	foreach ( $aFiles as $id => $fileName ) {
        		if ( !empty( $fileName ) ) {
        			$aFileInfo = pathinfo( $fileName );
        			$loop++;
        			$oTitle = Title::newFromText( self::$oName . "/report", NS_SPECIAL );
        			if ( $oTitle instanceof Title ) {
						$aUrls[] = $sk->makeLinkObj(
							$oTitle,
							Xml::element( "img", array( "src" => "$wgExtensionsPath/wikia/" . self::$oName . "/images/xls.gif", "border" => "0", "title" => $aFileInfo['basename'] ) ),
							"id=$jobId&file=$loop"
						);
					}
				}
			}
			$res = implode( " &#183; ", $aUrls );
		}
        wfProfileOut( __METHOD__ );
		return $res;
	}

	public static function axShowDaemon ( $dt_id ) {
		global $wgRequest, $wgUser,	$wgCityId, $wgDBname;
		global $wgContLang, $wgOut;

		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			return "";
		}

		$res = array( 'nbr_records' => 0, 'data' => array() );
		if ( ( !empty( $wgUser ) ) && ( !$wgUser->isBlocked() ) ) {
			wfLoadExtensionMessages( self::$oName );
			$data = self::getAllDaemons( $dt_id );

			if ( !empty( $data ) && is_array( $data ) && !empty( $data[$dt_id] ) ) {
				$res['nbr_records'] = count( $data[$dt_id] );
				foreach ( $data[$dt_id] as $key => $value ) {
					if ( $key == 'dt_input_params' ) {
						$res['data']['dt_params'] = @unserialize( $value );
					} else {
						$res['data'][$key] = $value;
					}
				}
			}
		}

		if ( !function_exists( 'json_encode' ) ) {
			$oJson = new Services_JSON();
			return $oJson->encode( $res );
		} else {
			return json_encode( $res );
		}
	}

	public static function axJobsList( $limit = 30, $offset = 0, $order = 'dj_id', $desc = 0 ) {
		global $wgUser;

		$res = "";
		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			return $res;
		}

		$res = array( 'nbr_records' => 0, 'data' => array(), 'limit' => $limit, 'page' => $offset, 'order' => $order, 'desc' => $desc );
		if ( ( !empty( $wgUser ) ) && ( !$wgUser->isBlocked() ) ) {
			wfLoadExtensionMessages( self::$oName );
			$data = self::getAllJobs( 0, $order, $limit, $offset, $desc );

			if ( !empty( $data ) && is_array( $data ) ) {
				list ( $count, $aData ) = $data;
				$oTaskHTML = new DaemonLoaderHTML();
				$sHtml = "";
				if ( $oTaskHTML ) {
					$sHtml = $oTaskHTML->jobsListTableForm( $aData );
					$res['data'] = $sHtml;
					$res['nbr_records'] = $count;
				}
			}
		}

		if ( !function_exists( 'json_encode' ) ) {
			$oJson = new Services_JSON();
			return $oJson->encode( $res );
		} else {
			return json_encode( $res );
		}
	}

	public static function axGetJobInfo( $id ) {
		global $wgUser;

		$res = "";
		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			return $res;
		}

		if ( empty( $id ) ) {
			return $res;
		}

		$res = array( 'nbr_records' => 0, 'data' => array() );
		if ( ( !empty( $wgUser ) ) && ( !$wgUser->isBlocked() ) ) {
			$data = self::getAllJobs( $id );

			if ( !empty( $data ) && is_array( $data ) ) {
				list ( $count, $aData ) = $data;
				$info = $aData[0];
				$params = $info['param_values'];
				if ( !empty( $params ) ) {
					$info['param_values'] = self::parseParams( $params );
				}
				$res['data'] = $info;
				$res['nbr_records'] = $count;
			}
		}

		if ( !function_exists( 'json_encode' ) ) {
			$oJson = new Services_JSON();
			return $oJson->encode( $res );
		} else {
			return json_encode( $res );
		}
	}

	public static function axGetWikiList ( $name, $value ) {
		global $wgUser;

		$res = "";
		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			return $res;
		}

		if ( ( !empty( $wgUser ) ) && ( !$wgUser->isBlocked() ) ) {
			wfLoadExtensionMessages( self::$oName );
			$wikiOptions = self::getWikisDB( $value );
			$res = Xml::openElement( 'select', array( 'name' => 'dt-select-' . $name, 'id' => 'dt-select-' . $name ) ) . $wikiOptions . Xml::closeElement( 'select' );
		}
		return $res;
	}

	public static function axGetTaskParams ( ) {
		global $wgUser;

		$res = "";
		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			return $res;
		}

		if ( ( !empty( $wgUser ) ) && ( !$wgUser->isBlocked() ) ) {
			wfLoadExtensionMessages( self::$oName );
			$oTaskHTML = new DaemonLoaderHTML();
			if ( $oTaskHTML ) {
				$res = $oTaskHTML->taskParamsForm();
			}
		}
		return $res;
	}

	public static function axRemoveJobsList( $id ) {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'daemonloader' ) ) {
			return "";
		}

		$res = array( 'nbr_records' => 0 );
		if ( ( !empty( $wgUser ) ) && ( !$wgUser->isBlocked() ) ) {
			$res['nbr_records'] = self::closeJob( $id );
		}

		if ( !function_exists( 'json_encode' ) ) {
			$oJson = new Services_JSON();
			return $oJson->encode( $res );
		} else {
			return json_encode( $res );
		}
	}

	private static function parseParams( $sParams ) {
		wfProfileIn( __METHOD__ );
		$aParams = array();
		if ( !empty( $sParams ) ) {
			$matches = preg_split( '/\s/', $sParams );
			if ( !empty( $matches ) && is_array( $matches ) ) {
				foreach ( $matches as $id => $str ) {
					if ( preg_match( '/^\-\-(.*)\=(.*)?/', $str, $m ) ) {
						list ( , $key, $value ) = $m;
						$aParams[trim( $key )] = trim( $value );
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );
		error_log ( print_r( $aParams, true ) );
		return $aParams;
	}

	function getWikisDB( $name ) {
		global $wgExternalSharedDB, $wgMemc;
		wfProfileIn( __METHOD__ );

		$limit = ( empty( $name ) ) ? "search" : "search$name";
		$memkey = wfForeignMemcKey( $wgExternalSharedDB, $limit, __METHOD__ );
		$domains = ""; # $wgMemc->get($memkey);
		if ( empty( $domains ) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			$oRes = $dbr->select(
				array( "city_list" ),
				array( "city_dbname, city_url" ),
				array( "city_public" => 1, "city_url like '%" . $dbr->escapeLike( $name ) . "%'" ),
				__METHOD__,
				array( "ORDER BY" => "city_url" )
			);

			$domains = "";
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ( strpos( $oRow->city_url, 'http://' ) === false ) {
					$oRow->city_url = "http://" . $oRow->city_url;
				}
				$aUrl = parse_url( $oRow->city_url );
				$url = ( $aUrl['path'] == '/' ) ? $aUrl['host'] : $aUrl['host'] . $aUrl['path'];
				$domains .= Xml::option( $url, $oRow->city_dbname, false );
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $memkey, $domains, 60 * 60 );
		}

		wfProfileOut( __METHOD__ );
		return $domains;
	}

}

class DaemonLoaderHTML extends DaemonLoader {

	function __contruct() {
		// contructor
	}

	function outputHTML( ) {
		global $wgOut, $wgLang, $wgUser;
		global $wgStylePath, $wgStyleVersion;
		global $wgRequest, $wgDaemonLoaderAdmins;

		$saved = $wgRequest->getVal( 'saved' );

		$wgOut->addScript( "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgStylePath}/common/yui_2.5.2/tabview/assets/skins/sam/tabview.css?{$wgStyleVersion}\" />" );
		$wgOut->addScript( "<script type=\"text/javascript\" src=\"/skins/common/yui_2.5.2/tabview/tabview-min.js?{$wgStyleVersion}\"></script>" );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"addDaemonForm"		=> $this->addScriptForm(),
			"createTaskForm"	=> $this->createTaskForm(),
			"listTaskTab"		=> $this->taskListForm(),
			"saved" 			=> $saved,
			"wgUser" 			=> $wgUser,
			"wgDaemonLoaderAdmins" => $wgDaemonLoaderAdmins
		) );
		$wgOut->addHTML( $oTmpl->execute( "main-form" ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * add daemon tab
	 *
	 * @access private
	 */
	function addScriptForm() {
		global $wgLang, $wgCityId, $wgDBname, $wgUser;
        wfProfileIn( __METHOD__ );

		$aDaemons = self::getAllDaemons();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgLang"		=> $wgLang,
			"wgUser"		=> $wgUser,
			"aDaemons"		=> $aDaemons,
			"paramsRows"	=> self::$paramsRows,
			"class"			=> $this,
        ) );
        $res = $oTmpl->execute( "addscript" );
        wfProfileOut( __METHOD__ );
        return $res;
	}

	function paramTypeSelector( $i ) {
        wfProfileIn( __METHOD__ );

		$paramTypeOption = null;
		foreach ( self::$paramsType as $index => $paramType ) {
			$paramTypeOption .= Xml::option( $paramType, $index, false );
		}

		$name = 'dt_param_type_' . $i;
		$result = Xml::openElement( 'select', array( 'name' => $name, 'id' => $name ) ) . $paramTypeOption . Xml::closeElement( 'select' );

        wfProfileOut( __METHOD__ );
        return $result;
	}

	/**
	 * create task tab
	 *
	 * @access private
	 */
	function createTaskForm() {
		global $wgLang, $wgCityId, $wgDBname, $wgUser;
        wfProfileIn( __METHOD__ );

		$aDaemons = self::getAllDaemons();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgLang"		=> $wgLang,
			"wgUser"		=> $wgUser,
			"aDaemons"		=> $aDaemons,
			"paramsRows"	=> self::$paramsRows,
        ) );
        $res = $oTmpl->execute( "createtask" );
        wfProfileOut( __METHOD__ );
        return $res;
	}

	/**
	 * task params
	 *
	 * @access private
	 */
	function taskParamsForm() {
		global $wgLang, $wgCityId, $wgDBname, $wgUser;
        wfProfileIn( __METHOD__ );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgLang"		=> $wgLang,
			"wgUser"		=> $wgUser,
        ) );
        $res = $oTmpl->execute( "task-params" );
        wfProfileOut( __METHOD__ );
        return $res;
	}

	/**
	 * task jobs list
	 *
	 * @access private
	 */
	function taskListForm() {
		global $wgLang, $wgCityId, $wgDBname, $wgUser;
        wfProfileIn( __METHOD__ );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgLang"		=> $wgLang,
			"wgUser"		=> $wgUser,
			"allJobs"		=> self::getAllJobs(),
			"allDaemons"	=> self::getAllDaemons()
        ) );
        $res = $oTmpl->execute( "jobs-list" );
        wfProfileOut( __METHOD__ );
        return $res;
	}

	/**
	 * task jobs list
	 *
	 * @access private
	 */
	function jobsListTableForm( $data ) {
		global $wgLang, $wgCityId, $wgDBname, $wgUser;
        wfProfileIn( __METHOD__ );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgLang"		=> $wgLang,
			"wgUser"		=> $wgUser,
			"allJobs"		=> $data,
			"allDaemons"	=> self::getAllDaemons()
        ) );
        $res = $oTmpl->execute( "jobs-list-table" );
        wfProfileOut( __METHOD__ );
        return $res;
	}

}
