<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of WikiSync.
 *
 * WikiSync is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * WikiSync is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WikiSync; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * WikiSync allows an AJAX-based synchronization of revisions and files between
 * global wiki site and it's local mirror.
 *
 * To activate this extension :
 * * Create a new directory named WikiSync into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/WikiSync/WikiSync.php";
 *
 * @version 0.3.2
 * @link http://www.mediawiki.org/wiki/Extension:WikiSync
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

/* todo: use HttpRequest or curl instead */
class WikiSnoopy extends Snoopy {

	var $api_url;
	var $index_url;
	var $cookie_prefix = null;
	var $sessionid;
	var $logintoken;

	function __construct() {
		$this->passcookies = true;
		if ( WikiSyncSetup::$proxy_host !== '' ) { $this->proxy_host = WikiSyncSetup::$proxy_host; }
		if ( WikiSyncSetup::$proxy_port !== '' ) { $this->proxy_port = WikiSyncSetup::$proxy_port; }
		if ( WikiSyncSetup::$proxy_user !== '' ) { $this->proxy_user = WikiSyncSetup::$proxy_user; }
		if ( WikiSyncSetup::$proxy_pass !== '' ) { $this->proxy_pass = WikiSyncSetup::$proxy_pass; }
	}

	/**
	 * set remote context provided to simplify further access
	 * @param $rc - remote context (url of remote api and cookies to send) in PHP stdClass
	 * 	( 'wikiroot'->val, 'userid'->val, 'username'->val, 'logintoken'->val, 'cookieprefix'->val, 'sessionid'->val )
	 * 	only wikiroot is absoultely necessary, another parameters are optional
	 */
	function setContext( $rc ) {
		if ( is_string( $rc ) ) {
			$rc = FormatJson::decode( $rc, true );
		}
		if ( !isset( $rc['wikiroot'] ) ) {
			throw new MWException( 'wikiroot is undefined in ' . __METHOD__ );
		}
		if ( substr( $rc['wikiroot'], 0, 4 ) !== "http" ) {
			throw new MWException( 'api_url has unsupported schema (' . $this->api_url . ')  in ' . __METHOD__ );
		}
		$this->api_url = $rc['wikiroot'] . '/api.php';
		$this->index_url = $rc['wikiroot'] . '/index.php';
		# optionally construct session cookies
		if ( isset( $rc['cookieprefix'] ) ) {
			$this->cookie_prefix = $rc['cookieprefix'];
			$this->sessionid = $rc['sessionid'];
			$this->logintoken = $rc['logintoken'];
			$this->setCookie( '_session', $this->sessionid );
			$this->setCookie( 'UserName', $rc['username'] );
			$this->setCookie( 'UserID', $rc['userid'] );
			$this->setCookie( 'Token', $this->logintoken );
		}
	}

	function setCookie( $name, $val ) {
		if ( $this->cookie_prefix === null ) {
			throw new MWException( 'cookie_prefix was previousely not set in ' . __METHOD__ );
		}
		$this->cookies[$this->cookie_prefix . $name] = $val;
	}

	function submitToApi( array $formvars, $formfiles = '' ) {
		$this->submit( $this->api_url, $formvars, $formfiles );
	}

} /* end of WikiSnoopy class */

class WikiSyncJSONresult {

	var $encodeResult = true;
	var $jr = array(); // JSON result

	/**
	 * @param $encodeResult - boolean
	 * 	true  : JSON result encoded as string (default)
	 *		false : JSON result in PHP associative array
	 * @param $status '1' - success (jr is valid and usable), '0' - failure
	 * @param $code - string code of result
	 * @param $msg - localized explanation of code
	 */
	function __construct( $encodeResult = true, $status = '0', $code = null, $msg = null ) {
		$this->setEncodeResult( $encodeResult );
		$this->setStatus( $status );
		$this->setCode( $code, $msg );
	}

	function setEncodeResult( $value ) {
		$this->encodeResult = (boolean) $value;
	}

	function setStatus( $val ) {
		$this->jr['ws_status'] = $val;
	}

	function get( $key ) {
		return $this->jr["ws_${key}"];
	}

	function set( $key, $val ) {
		$this->jr["ws_${key}"] = $val;
	}

	/**
	 * @param $code - optionally set code value AND msg value by code value
	 * @param $msg - optionally overrides default msg value
	 */
	function setCode( $code = null, $msg = null ) {
		if ( $code !== null ) {
			$this->jr['ws_code'] = $code;
		} else {
			if ( isset( $this->jr['ws_code'] ) ) {
				$code = $this->jr['ws_code'];
			}
		}
		if ( $msg === null ) {
			if ( $code !== null ) {
				# do not overwrite previousely set message, if any
				if ( !isset( $this->jr['ws_msg'] ) ) {
					$this->jr['ws_msg'] = wfMsg( "wikisync_api_result_${code}" );
				}
			}
		} else {
			$this->jr['ws_msg'] = $msg;
		}
#		$this->jr['ws_msg'] = (($msg === null) ? (($code !==null) ? wfMsg( "wikisync_api_result_${code}" ) : '' ) : $msg);
	}

	/**
	 * appends JSON result from API to our JSON result
	 * @param $json_result JSON result we got from API call
	 */
	function append( array $json_result ) {
		# check for key conflicts
		if ( count( array_intersect_key( $this->jr, $json_result ) ) > 0 ) {
			throw new MWException( 'JSON keys conflict in ' . __METHOD__ );
		}
		$this->jr = array_merge( $this->jr, $json_result );
	}

	function getResult( $code = null, $msg = null ) {
		$this->setCode( $code, $msg );
		if ( $this->encodeResult ) {
			return FormatJson::encode( $this->jr );
		} else {
			return $this->jr;
		}
	}

} /* end of WikiSyncJSONresult class */

class WikiSyncClient {

	const RESULT_JSON_STRING = 0;
	const RESULT_JSON_ARRAY = 1;
	const RESULT_SNOOPY = 2;

	# direction of xml synchronization:
	# true - from remote wiki to local wiki, false - from local wiki to remote wiki
	static $directionToLocal;
	# remote context as encoded JSON string
	static $remoteContextJSON;
	# client's WikiSyncJSONresult instance to return
	static $json_result;
	# client "mini-api" parameters for validation
	static $client_params;

	static $parameters_validator = array(
		'transferFileBlock' => array(
			'title' => 'string',
			'timestamp' => 'timestamp',
			'offset' => 'int',
			'blocklen' => 'int'
		),
		'syncXMLchunk' => array(
			'startid' => 'int',
			'limit' => 'int',
			'dst_import_token' => 'string'
		),
		'findNewFiles' => array(
			'chunk_files' => 'array'
		),
		'uploadLocalFile' => array(
			'file_name' => 'string',
			'file_size' => 'int',
			'file_timestamp' => 'timestamp'
		)
	);

	/**
	 * WikiSync own client parameters check (a kind of mini-api)
	 * @param $client_key - method key to have the parameters to be validated against
	 */
	static function checkClientParameters( $client_key ) {
		if ( !is_array( self::$client_params ) ) {
			return "Submitted parameters (" . self::$client_params . ") are not valid JSON";
		}
		foreach ( self::$parameters_validator[$client_key] as $key => $type ) {
			if ( !isset( self::$client_params[$key] ) ) {
				return "Parameter $key is undefined in $client_key(), should have type $type";
			}
			$value = self::$client_params[$key];
			$error = "Parameter $key has value ($value) should have type $type";
			switch ( $type ) {
			case 'bool' :
				if ( !is_bool( $value ) ) { return $error; }
				break;
			case 'string' :
				if ( !is_string( $value ) ) { return $error; }
				break;
			case 'array' :
				if ( !is_array( $value ) ) { return $error; }
				break;
			case 'timestamp' :
				if ( wfTimestamp( TS_UNIX, $value ) === 0 ) { return $error; }
				break;
			case 'int' :
				if ( !is_int( $value ) ) { return $error; }
				break;
			case 'int_string' :
				if ( intval( $value ) != $value ) { return $error; }
				break;
			case 'user' :
				if ( is_null( Title::makeTitleSafe( NS_USER, $value ) ) ) { return $error; }
				break;
			}
		}
		return true;
	}
	
	/**
	 * called via AJAX to perform remote login via the API
	 * @param $args[0] : remote wiki root
	 * @param $args[1] : remote wiki user
	 * @param $args[2] : remote wiki password
	 * @param $args[3] : string "boolean", whether the login / password should be stored
	 *     in cookies; "true" - yes, "false" - not
	 * @return JSON result of second phase login (token confirmed, used logged in) from the remote API
	 */
	static function remoteLogin() {
		/*
		 * '_status' success means that both HTTP request and API request were successful
		 * '_code' is provided as an reason for 'status'
		 * '_msg' is almost always provided to display in JS log (error, success)
		 */
		$args = func_get_args();
		$json_result = new WikiSyncJSONresult();
		if ( is_string( $iu = WikiSyncSetup::initUser() ) ) {
			# not enough priviledges to run this method
			return $json_result->getResult( 'noaccess', $iu );
		}
		$store_rlogin = count( $args ) > 3 && $args[3] === 'true';
		if ( !$store_rlogin ) {
			// unset cookies, if there were any
			WikiSyncSetup::setCookie( 'ruser', '', 0 );
			WikiSyncSetup::setCookie( 'rpass', '', 0 );
		}
		$snoopy = new WikiSnoopy();
		list( $remote_wiki_root, $remote_wiki_user, $remote_wiki_password ) = $args;
		$snoopy->setContext( array( 'wikiroot'=>$remote_wiki_root ) );
		# request login token
		$api_params = array( 'action'=>'login', 'lgname'=>$remote_wiki_user, 'lgpassword'=>$remote_wiki_password, 'format'=>'json' );
		$snoopy->submitToApi( $api_params );
		# transport level error ?
		if ( $snoopy->error != '' ) {
			return $json_result->getResult( 'http', $snoopy->error );
		}
		$response = FormatJson::decode( $snoopy->results );
		# proxy returned html instead of json ?
		if ( $response === null ) {
			return $json_result->getResult( 'http' );
		}
		if ( $response->login->result !== 'NeedToken' ) {
			if ( $response->login->result === 'Success' ) {
				# mediawiki version < 1.15
				$response->login->result = 'Unsupported';
			}
			return $json_result->getResult( $response->login->result );
		}
		if ( !isset( $response->login->token ) ||
				!isset( $response->login->cookieprefix ) ||
				!isset( $response->login->sessionid ) ) {
			# mediawiki version < 1.15.5 ?
			return $json_result->getResult( 'Unsupported' );
		}
		# login with token given
		$api_params['lgtoken'] = $response->login->token;
		$session_cookie_name = $response->login->cookieprefix . '_session';
		# construct session cookies
		$snoopy->cookies[$session_cookie_name] = $response->login->sessionid;
		$snoopy->submitToApi( $api_params );
		# transport level error ?
		if ( $snoopy->error != '' ) {
			return $json_result->getResult( 'http', $snoopy->error );
		}
		$response = FormatJson::decode( $snoopy->results );
		# proxy returned html instead of json ?
		if ( $response === null ) {
			return $json_result->getResult( 'http' );
		}
		if ( $response->login->result === 'Success' ) {
			$json_result->setStatus( '1' ); // success
			if ( $store_rlogin ) {
				WikiSyncSetup::setCookie( 'ruser', $remote_wiki_user, time() + WikiSyncSetup::COOKIE_EXPIRE_TIME );
				WikiSyncSetup::setCookie( 'rpass', $remote_wiki_password, time() + WikiSyncSetup::COOKIE_EXPIRE_TIME );
			}
			$r = array(
				'userid' => $response->login->lguserid,
				'username' => $response->login->lgusername, // may return a different one ?
				'token' => $response->login->lgtoken,
				'cookieprefix' => $response->login->cookieprefix,
				'sessionid' => $response->login->sessionid );
			$json_result->append( $r );
		}
		return $json_result->getResult( $response->login->result );
	}

	/**
	 * Access to local API
	 * @param $api_params string in JSON format {key:val} or PHP array ($key=>val)
	 * @return result of local API query
	 */
	static function localAPIwrap( $api_params ) {
		global $wgEnableWriteAPI;
		if ( is_string( $api_params ) ) {
			$api_params = FormatJson::decode( $api_params, true );
		}
		$req = new FauxRequest( $api_params );
		$api = new ApiMain( $req, $wgEnableWriteAPI );
		$api->execute();
		return $api->getResultData();
	}

	/**
	 * called via AJAX to perform API request on local wiki (HTTP GET)
	 * @param $args[0] : API query parameters line in JSON format {'key':'val'} or PHP associative array
	 * @param $args[1] : optional, type of result:
	 *     RESULT_JSON_STRING : return encoded JSON string (default)
	 *     RESULT_JSON_ARRAY  : return JSON result in PHP array
	 * @return JSON result of local API query
	 */
	static function localAPIget() {
		# get params
		$args = func_get_args();
		$resultEncoding = self::RESULT_JSON_STRING;
		if ( count( $args ) > 1 ) {
			$resultEncoding = (int) $args[1];
		}
		if ( !in_array( $resultEncoding, array( self::RESULT_JSON_STRING, self::RESULT_JSON_ARRAY ) ) ) {
			throw new MWException( 'Unsupported type of result (' . htmlspecialchars( $resultEncoding, ENT_COMPAT, 'UTF-8' ) . ' ) in ' . __METHOD__ );
		}
		$json_result = new WikiSyncJSONresult( $resultEncoding == self::RESULT_JSON_STRING );
		if ( is_string( $iu = WikiSyncSetup::initUser() ) ) {
			# not enough priviledges to run this method
			return $json_result->getResult( 'noaccess', $iu );
		}
		$api_params = is_array( $args[0] ) ? $args[0] : FormatJson::decode( $args[0], true );
		try {
			$response = self::localAPIwrap( $api_params );
		} catch ( Exception $e ) {
			if ( $e instanceof MWException ) {
				wfDebugLog( 'exception', $e->getLogMessage() );
			}
			return $json_result->getResult( 'exception', $e->getMessage() );
		}
		$json_result->append( $response ); // no HTTP error & valid AJAX
		if ( isset( $response['error'] ) ) {
			return $json_result->getResult( $response['error']['code'], $response['error']['info'] ); // API reported error
		}
		$json_result->setStatus( '1' ); // API success
		return $json_result->getResult();
	}

	/**
	 * called via AJAX to perform API request on remote wiki (HTTP GET/POST)
	 * @param $args[0] : remote context in JSON format, keys
	 * 	{ 'wikiroot':val, 'userid':val, 'username':val, 'logintoken':val, 'cookieprefix':val, 'sessionid':val }
	 * @param $args[1] : API query parameters string in JSON format {'key':'val'}, or PHP associative array
	 * @param $args[2] : optional, file list to upload in PHP array ('myfile' => '/dir/filename.ext');
	 *     (will use POST method and 'multipart/form-data' encoding in such case)
	 *     default '' - empty string value to use GET method
	 * @param $args[3] : optional, type of result:
	 *     RESULT_JSON_STRING : return encoded JSON string (default)
	 *     RESULT_JSON_ARRAY  : return JSON result in PHP array
	 *     RESULT_SNOOPY      : return WikiSnoopy instance instead (raw result)
	 *          (warning: in case '2' JSON in PHP array will be returned in case of error)
	 * @return JSON result of local API query
	 */
	static function remoteAPIget() {
		# get params
		$args = func_get_args();
		// by default will encode JSON result to string
		$resultEncoding = self::RESULT_JSON_STRING;
		if ( count( $args ) > 3 ) {
			$resultEncoding = (int) $args[3];
		}
		$api_files = count( $args ) > 2 ? $args[2] : '';
		# when there are files posted, use only 'multipart/form-data'
		$useMultipart = is_array( $api_files );
		$json_result = new WikiSyncJSONresult( $resultEncoding == self::RESULT_JSON_STRING );
		if ( is_string( $iu = WikiSyncSetup::initUser() ) ) {
			# not enough priviledges to run this method
			return $json_result->getResult( 'noaccess', $iu );
		}
		# snoopy api_params are associative array
		$api_params = is_array( $args[1] ) ? $args[1] : FormatJson::decode( $args[1], true );
		$snoopy = new WikiSnoopy();
		$snoopy->setContext( $args[0] );
		# we always use POST method because it's less often cached by proxies
		# HTTP caching is real evil for AJAX calls
		$snoopy->httpmethod = 'POST';
		if ( $useMultipart ) {
			$snoopy->set_submit_multipart();
		} else {
			$snoopy->set_submit_normal();
		}
		$snoopy->submitToApi( $api_params, $api_files );
		# transport level error ?
		if ( $snoopy->error != '' ) {
			return $json_result->getResult( 'http', $snoopy->error );
		}
		if ( $resultEncoding == self::RESULT_SNOOPY ) {
			return $snoopy;
		}
		$response = FormatJson::decode( $snoopy->results, true );
		# proxy returned html instead of json ?
		if ( $response === null ) {
			return $json_result->getResult( 'http' );
		}
		$json_result->append( $response ); // no HTTP error & valid AJAX
		if ( isset( $response['error'] ) ) {
			return $json_result->getResult( $response['error']['code'], $response['error']['info'] ); // API reported error
		}
		$json_result->setStatus( '1' ); // API success
		return $json_result->getResult();
	}

	static function sourceAPIget( $APIparams ) {
		if ( self::$directionToLocal ) {
			$jr = self::remoteAPIget( self::$remoteContextJSON, $APIparams, '', self::RESULT_JSON_ARRAY );
		} else {
			$jr = self::localAPIget( $APIparams, self::RESULT_JSON_ARRAY );
		}
		return $jr;
	}

	static function destinationAPIget( $APIparams ) {
		if ( self::$directionToLocal ) {
			$jr = self::localAPIget( $APIparams, self::RESULT_JSON_ARRAY );
		} else {
			$jr = self::remoteAPIget( self::$remoteContextJSON, $APIparams, '', self::RESULT_JSON_ARRAY );
		}
		return $jr;
	}

	static function tempnam_sfx( $path, $suffix ) {
		for ( $i = 0; $i < 10; $i++ ) {
			$fname = $path . mt_rand( 10000, 99999 ) . $suffix;
			$fp = @fopen( $fname, 'x' );
			if ( $fp !== false ) {
				break;
			}
		}
		if ( $fp === false ) {
			throw new MWException( 'Cannot create temporary file in ' . __METHOD__ . ' Please make sure you have writing permissions in \'' . $path . '\'' );
		}
		return array( $fname, $fp );
	}

	/**
	 * @param $args array of AJAX arguments call
	 * @param $min_args minimal number of $args method requires
	 * @return true on success; false on error
	 * @modifies self::$json_result, self::$remoteContextJSON, self::$client_params, self::$directionToLocal
	 */
	static function initClient( $args, $min_args, $client_name ) {
		# use default IIS / Apache execution time limit which is much larger than default PHP limit
		set_time_limit( 300 );
		self::$json_result = new WikiSyncJSONresult();
		if ( count( $args ) < $min_args ) {
			self::$json_result->setCode( 'init_client', 'Not enough number of parameters in ' . __METHOD__ );
			return false;
		}
		# remote context; used for remote API calls
		self::$remoteContextJSON = $args[0];
		self::$client_params = FormatJson::decode( $args[1], true );
		if ( ($check_result = self::checkClientParameters( $client_name )) !== true ) {
			self::$json_result->setCode( 'init_client', $check_result );
			return false;
		}
		if ( !isset( self::$client_params['direction_to_local'] ) ) {
			self::$json_result->setCode( 'init_client', 'direction_to_local was not passed for ' . $client_name );
			return false;
		}
		self::$directionToLocal = self::$client_params['direction_to_local'];
		if ( is_string( $iu = WikiSyncSetup::initUser( self::$directionToLocal ) ) ) {
			# not enough priviledges to run this method
			self::$json_result->setCode( 'noaccess', $iu );
			return false;
		}
		return true;
	}

	/**
	 * import xml data either into local or remote wiki, depending on self::$directionToLocal value
	 */
	static function importXML( $dstImportToken, $xmldata ) {
		global $wgUser, $wgTmpDirectory;
		// {{{ bugfixes
		global $wgSMTP;
//		global $wgMaxArticleSize, $wgMaxPPNodeCount, $wgMaxTemplateDepth, $wgMaxPPExpandDepth;
		global $wgEnableEmail, $wgEnableUserEmail;
		// }}}
		list( $fname, $fp ) = self::tempnam_sfx( $wgTmpDirectory . '/', '.xml' );
		$flen = strlen( $xmldata );
		if ( @fwrite( $fp, $xmldata, $flen ) !== $flen ) {
			throw new MWException( 'Cannot write xmldata to file ' . $fname . ' in ' . __METHOD__ . ' disk full?' );
		}
		fclose( $fp );
		if ( self::$directionToLocal ) {
			# suppress "pear mail" possible smtp fatal errors
			# in EmailNotification::actuallyNotifyOnPageChange()
			$wgSMTP = false;
			$wgEnableEmail = false;
			$wgEnableUserEmail = false;
			/*
			if ( $wgMaxArticleSize < 8192 ) {
				$wgMaxArticleSize = 8192;
			}
			*/
			$json_result = new WikiSyncJSONresult( false );
			$json_result->setCode( 'import' );
			if( !$wgUser->isAllowed( 'importupload' ) ) {
				@unlink( $fname );
				return $json_result->getResult( 'no_import_rights' );
			}
			$source = ImportStreamSource::newFromFile( $fname );
			$err_msg = null;
			if ( $source instanceof Status ) {
				if ( $source->isOK() ) {
					$source = $source->value;
				} else {
					$err_msg = $source->getWikiText();
				}
			} elseif ( $source instanceof WikiErrorMsg || WikiError::isError( $source ) ) {
				$err_msg = $source->getMessage();
			}
			if ( $err_msg !== null ) {
				@unlink( $fname );
				return $json_result->getResult( 'import',  $err_msg );
			}
			$importer = new WikiImporter( $source );
			$reporter = new WikiSyncImportReporter( $importer, false, '', wfMsg( 'wikisync_log_imported_by' ) );
			$result = $importer->doImport();
			@fclose( $source->mHandle );
			if ( !WikiSyncSetup::$debug_mode ) {
				@unlink( $fname );
			}
			if ( $result instanceof WikiXmlError ) {
				$r =
					array(
						'line' => $result->mLine,
						'column' => $result->mColumn,
						'context' => $result->mByte . $result->mContext,
						'xmlerror' => xml_error_string( $result->mXmlError )
					);
				$json_result->append( $r );
				return $json_result->getResult( 'import', $result->getMessage() );
			} elseif ( WikiError::isError( $result ) ) {
				return $json_result->getResult( 'import', $source->getMessage() );
			}
			$resultData = $reporter->getData();
			$json_result->setStatus( '1' ); // API success
			return $json_result->getResult();
		} else {
			$APIparams = array(
				'action' => 'syncimport',
				'format' => 'json',
				'token' => $dstImportToken,
			);
			$APIfiles = array(
				'xml'=>$fname
			);
			// will POST 'multipart/form-data', because $APIfiles are defined
			$jr = self::remoteAPIget( self::$remoteContextJSON, $APIparams, $APIfiles, self::RESULT_JSON_ARRAY );
			@unlink( $fname );
			return $jr;
		}
	}

	/**
	 * called via AJAX to perform synchronization of one XML chunk from source to destination wiki
	 * @param $args[0] : remote context in JSON format, keys
	 * 	{ 'wikiroot':val, 'userid':val, 'username':val, 'logintoken':val, 'cookieprefix':val, 'sessionid':val }
	 * @param $args[1] : client parameters line in JSON format {'key':'val'}
	 * @return JSON result query (success/error status and the continuation revid, when available)
	 */
	static function syncXMLchunk() {
		if ( !self::initClient( func_get_args(), 2, 'syncXMLchunk' ) ) {
			return self::$json_result->getResult();
		}
		$json_result = self::$json_result;
		$client_params = self::$client_params;
		$APIparams = array(
			'action' => 'revisionhistory',
			'format' => 'json',
			'exclude_user' => WikiSyncSetup::$remote_wiki_user,
			'xmldump' => '',
			'dir' => 'newer',
			'startid' => $client_params['startid'],
			'limit' => $client_params['limit']
		);
		$result = self::sourceAPIget( $APIparams );
		if ( $result['ws_status'] === '0' ) {
			$result['ws_msg'] = 'source: ' . $result['ws_msg'] . ' (' . __METHOD__ . ')';
			return FormatJson::encode( $result );
		}
		# collect the file titles that exist in current chunk's revisions
		$files = array();
		foreach ( $result['query']['revisionhistory'] as $entry ) {
			if ( $entry['namespace'] == NS_FILE && $entry['redirect'] === '0' ) {
				$files[] = $entry;
			}
		}
		if ( count( $files ) > 0 ) {
			$json_result->append( array( 'files' => $files ) );
		}
		if ( isset( $result['query-continue'] ) ) {
			$json_result->set( 'continue_startid', $result['query-continue']['revisionhistory']['startid'] );
		}
		$result = self::importXML( $client_params['dst_import_token'], $result['query']['exportxml'] );
		if ( $result['ws_status'] === '0' ) {
			$result['ws_msg'] = 'destination: ' . $result['ws_msg'] . ' (' . __METHOD__ . ')';
			return FormatJson::encode( $result );
		}
		$json_result->setStatus( '1' ); // API success
		return $json_result->getResult();
	}

	static function transformImageInfoResult( $result ) {
		$titles = $sha1 = $sizes = $timestamps = array();
		foreach ( $result['query']['pages'] as $entry ) {
			if ( isset( $entry['imageinfo'] ) ) {
				$titles[] = $entry['title'];
				$sha1[] = $entry['imageinfo'][0]['sha1'];
				$sizes[] = $entry['imageinfo'][0]['size'];
				$timestamps[] = $entry['imageinfo'][0]['timestamp'];
			}
		}
		return array( 'titles'=>$titles, 'sha1'=>$sha1, 'sizes'=>$sizes, 'timestamps'=>$timestamps );
	}

	/**
	 * called via AJAX to compare source and destination list of files
	 * @param $args[0] : remote context in JSON format, keys
	 * 	{ 'wikiroot':val, 'userid':val, 'username':val, 'logintoken':val, 'cookieprefix':val, 'sessionid':val }
	 * @param $args[1] : client parameters line in JSON format {'key':'val'}
	 * @return JSON result query (success/error status and the list of changed files that has to be uploaded, when available)
	 */
	static function findNewFiles() {
		if ( !self::initClient( func_get_args(), 2, 'findNewFiles' ) ) {
			return self::$json_result->getResult();
		}
		$json_result = self::$json_result;
		$client_params = self::$client_params;
		$filelist = array();
		foreach ( $client_params['chunk_files'] as &$entry ) {
			$title = 'File:' . $entry['title'];
			if ( array_search( $title, $filelist ) === false ) {
				$filelist[] = $title;
			}
		}
		$APIparams = array(
			'action' => 'query',
			'format' => 'json',
			'prop' => 'imageinfo',
			'titles' => implode( '|', $filelist ),
			'iiprop' => 'timestamp|user|size|sha1'
		);
		$src_result = self::sourceAPIget( $APIparams );
		if ( $src_result['ws_status'] === '0' ||
				!isset( $src_result['query'] ) ||
				!isset( $src_result['query']['pages'] ) ) {
			$src_result['ws_msg'] = 'source: ' . $src_result['ws_msg'] . ' (' . __METHOD__ . ')';
			return FormatJson::encode( $src_result );
		}
		$src_result = self::transformImageInfoResult( $src_result );
		$dst_result = self::destinationAPIget( $APIparams );
		if ( $dst_result['ws_status'] === '0' ||
				!isset( $dst_result['query'] ) ||
				!isset( $dst_result['query']['pages'] ) ) {
			$dst_result['ws_msg'] = 'destination: ' . $dst_result['ws_msg'] . ' (' . __METHOD__ . ')';
			return FormatJson::encode( $dst_result );
		}
		$dst_result = self::transformImageInfoResult( $dst_result );
		$new_files = array();
		foreach ( $src_result['titles'] as $src_key => &$src_title ) {
			if ( ( $dst_key = array_search( $src_title, $dst_result['titles'] ) ) === false ||
					$dst_result['sha1'][$dst_key] !== $src_result['sha1'][$src_key] ||
					$dst_result['sizes'][$dst_key] !== $src_result['sizes'][$src_key] ||
					$dst_result['timestamps'][$dst_key] !== $src_result['timestamps'][$src_key] ) {
				$new_files[] = array(
					'title' => $src_title,
					'size' => $src_result['sizes'][$src_key],
					'timestamp' => $src_result['timestamps'][$src_key]
				);
			}
		}
		if ( count( $new_files ) > 0 ) {
			$json_result->append( array( 'new_files' => $new_files ) );
		}
		$json_result->setStatus( '1' ); // API success
		return $json_result->getResult();
	}

	static function chunkFilePath( WikiSnoopy $snoopy, $chunk_fname ) {
		global $wgTmpDirectory;
		return $wgTmpDirectory . '/' . $snoopy->logintoken . '_' . $snoopy->sessionid . '_' . $chunk_fname;
	}

	/**
	 * called via AJAX to transfer one chunk of file from source to destination wiki
	 * @param $args[0] : remote context in JSON format, keys
	 * 	{ 'wikiroot':val, 'userid':val, 'username':val, 'logintoken':val, 'cookieprefix':val, 'sessionid':val }
	 * @param $args[1] : client parameters line in JSON format {'key':'val'}
	 * @return JSON result query (success/error status and the offset of next chunk, if available; offset = -1 when transfer is complete)
	 */
	static function transferFileBlock() {
		if ( !self::initClient( func_get_args(), 2, 'transferFileBlock' ) ) {
			return self::$json_result->getResult();
		}
		$json_result = self::$json_result;
		$client_params = self::$client_params;
		if ( self::$directionToLocal ) {
			# transfer the chunk of file from remote wiki to temporary local file via api
			$APIparams = array(
				'action' => 'getfile',
				'format' => 'json',
				'title' => $client_params['title'],
				'timestamp' => $client_params['timestamp'],
				'offset' => $client_params['offset'],
				'blocklen' => $client_params['blocklen']
			);
			$snoopy = self::remoteAPIget( self::$remoteContextJSON, $APIparams, '', self::RESULT_SNOOPY );
			$error = true;
			$content_length = 0;
			$content_length_header = 'Content-Length: ';
			$chunk_fname = urlencode( $client_params['title'] );
			if ( !isset( $snoopy->headers ) ) {
				return $json_result->getResult( 'api_getfile', 'Recieved response without HTTP headers: ' . $snoopy->results );
			}
			$transfer_is_done = true;
			foreach ( $snoopy->headers as &$header ) {
				if ( strpos( $header, 'Content-Type: application/x-wiki' ) === 0 ) {
					$error = false;
					continue;
				}
				if ( strpos( $header, $content_length_header ) === 0 ) {
					$content_length = (int) trim( substr( $header, strlen( $content_length_header ) ) );
					continue;
				}
				preg_match( '`Content-Disposition: inline;filename\*=utf-8\'[A-Za-z_]{1,}?\'(.*)`', $header, $matches );
				if ( count( $matches ) > 1 ) {
					$chunk_fname = trim( $matches[1] );
					continue;
				}
				preg_match( '`Content-Range: bytes (\d{1,}?)-(\d{1,}?)/(\d{1,})`', $header, $matches );
				if ( count( $matches ) > 3 ) {
					$end_of_content = (int) $matches[2];
					$end_of_file = (int) $matches[3];
					# partial content found, check, whether the transferred chunk is the last one
					if ( $end_of_content + 1 < $end_of_file ) {
						$transfer_is_done = false;
					}
					continue;
				}
			}
			# series of bugchecks to prevent file corruption
			if ( !$error ) {
				if ( strlen( $snoopy->results ) !== $content_length ) {
					$error = true;
					$snoopy->results = "Truncated remote file block recieved in " . __METHOD__;
					$json_result->append( array( 'ws_auto_retry' => '' ) );
				}
			}
			if ( $error ) {
				return $json_result->getResult( 'api_getfile', $snoopy->results );
			}
			$chunk_fpath = self::chunkFilePath( $snoopy, $chunk_fname );
			$offset = $client_params['offset'];
			$open_mode = ( $offset === 0 ) ? 'wb' : 'cb';
			if ( ( $f = @fopen( $chunk_fpath, $open_mode ) ) === false ) {
				return $json_result->getResult( 'fopen', 'Cannot create / open temporary file ' . $chunk_fpath . ' in ' . __METHOD__ );
			}
			$stat = fstat( $f );
			if ( $stat['size'] !== $offset ) {
				@fclose( $f );
				return $json_result->getResult( 'fstat', 'Temporary file ' . $chunk_fpath . ' cannot be sparse. Current file size is (' . $stat['size'] . '), trying to write at pos (' . $offset . ') , in ' . __METHOD__ );
			}
			if ( @fseek( $f, $offset ) !== 0 ) {
				@fclose( $f );
				return $json_result->getResult( 'fopen', 'Cannot seek temporary file ' . $chunk_fpath . ' pos ' . $offset . ' in ' . __METHOD__ );
			}
			if ( @fwrite( $f, $snoopy->results, $content_length ) !== $content_length ) {
				@fclose( $f );
				return $json_result->getResult( 'fwrite', 'Error writing to ' . $chunk_fpath . ' Disk full? in ' . __METHOD__ );
			}
			@fclose( $f );
			// API success
			$result = array(
				// return number of bytes read
				'numread' => $content_length,
				// used to reconstruct temporary file path in uploader
				'chunk_fname' => $chunk_fname
			);
			if ( $transfer_is_done ) {
				$result['done'] = '';
			}
			$json_result->append( $result );
			$json_result->setStatus( '1' ); // API success
			return $json_result->getResult();
		} else {
			# transfer the chunk of file from local wiki to temporary remote file via api
			return $json_result->getResult( 'unimplemented', 'Synchronization of files from local to remote wiki is not implemented yet. Please turn off file synchronization and try again.' );
		}
	}

	/**
	 * called via AJAX to store previousely uploaded temporary file into local repository
	 * @param $args[0] : remote context in JSON format, keys
	 * 	{ 'wikiroot':val, 'userid':val, 'username':val, 'logintoken':val, 'cookieprefix':val, 'sessionid':val }
	 * @param $args[1] : client parameters line in JSON format {'key':'val'}
	 * @return JSON result query (success/error status and the offset of next chunk, if available; offset = -1 when transfer is complete)
	 */
	static function uploadLocalFile() {
		if ( !self::initClient( func_get_args(), 2, 'uploadLocalFile' ) ) {
			return self::$json_result->getResult();
		}
		$json_result = self::$json_result;
		$client_params = self::$client_params;
		if ( self::$directionToLocal ) {
			# upload temporary local file on local wiki to current local file
			$snoopy = new WikiSnoopy();
			# todo: currently, we are using remote context to build local file name
			$snoopy->setContext( self::$remoteContextJSON );
			$chunk_fpath = self::chunkFilePath( $snoopy, $client_params['file_name'] );
			if ( !file_exists( $chunk_fpath ) ) {
				return $json_result->getResult( 'chunk_file', 'Temporary file ' . $chunk_fpath . ' does not exists in ' . __METHOD__ );
			}
			$filesize = filesize( $chunk_fpath );
			# return resulting file size
			$json_result->append( array( 'tmp_file_size' => $filesize ) );
			if ( $filesize !== $client_params['file_size'] ) {
				# append for error reporting in JS part
				$json_result->append( array( 'chunk_fpath' => $chunk_fpath ) );
			}
			$localFileTitle = Title::newFromText( urldecode( $client_params['file_name'] ), NS_FILE );
			if ( !($localFileTitle instanceof Title) ) {
				return $json_result->getResult( 'local_file', 'Specified title ' . $client_params['file_name'] . ' is invalid in ' . __METHOD__ );
			}
			$localFile = wfLocalFile( $localFileTitle );
			$status = $localFile->upload( $chunk_fpath, wfMsg( 'wikisync_log_uploaded_by' ), '', 0, false, wfTimestamp( TS_MW, $client_params['file_timestamp'] ) );
			if ( !$status->isGood() ) {
				return $json_result->getResult( 'upload', $status->getWikiText() );
			}
			if ( !@unlink( $chunk_fpath ) ) {
				return $json_result->getResult( 'chunk_file', 'Cannot unlink temporary file ' . $chunk_fpath . ' in ' . __METHOD__ );
			}
			// API success
			$json_result->setStatus( '1' ); // API success
			return $json_result->getResult();
		} else {
			# upload temporary remote file on remote wiki to current remote file via api
			return $json_result->getResult( 'unimplemented', 'Uploading of files from local to remote wiki is not implemented yet. Please turn off file synchronization and try again.' );
		}
	}

} /* end of WikiSyncClient class */
