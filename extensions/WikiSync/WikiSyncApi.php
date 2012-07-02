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

/* ugly hack, required because 1.15.x API architecture is unsuitable to our needs */
abstract class ApiWikiSync extends ApiQueryBase {

	static $unsupported = 'ApiWikiSync does not support ';

	// we construct like ApiBase, however we also use SQL select building methods from ApiQueryBase
	public function __construct( $mainModule, $moduleName, $modulePrefix = '' ) {
		// we call ApiBase only, ApiQueryBase is unsuitable to our needs
		ApiBase::__construct( $mainModule, $moduleName, $modulePrefix = '' );
		$this->mDb = null;
		$this->resetQueryParams();
	}

	public function requestExtraData($pageSet) {
		throw new MWException( self::$unsupported . __METHOD__ );
	}

	public function getQuery() {
		throw new MWException( self::$unsupported . __METHOD__ );
	}

	protected function addPageSubItems($pageId, $data) {
		throw new MWException( self::$unsupported . __METHOD__ );
	}
	
	protected function addPageSubItem($pageId, $item, $elemname = null) {
		throw new MWException( self::$unsupported . __METHOD__ );
	}

	/**
	 * Gets a default slave database connection object
	 * @return Database
	 */
	public function getDB() { // copypasted from ApiQuery class
		if (!isset ($this->mSlaveDB)) {
			$this->profileDBIn();
			$this->mSlaveDB = wfGetDB(DB_SLAVE,'api');
			$this->profileDBOut();
		}
		return $this->mSlaveDB;
	}

	public function selectNamedDB($name, $db, $groups) {
		throw new MWException( self::$unsupported . __METHOD__ );
	}

	protected function getPageSet() {
		throw new MWException( self::$unsupported . __METHOD__ );
	}

} /* end of WikiSyncQueryBuilder class */

class ApiFindSimilarRev extends ApiWikiSync {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	public function execute() {
		$db = $this->getDB();
		/* Get the parameters of the request. */
		$params = $this->extractRequestParams();

		$selectFields = array (
			'rev_id',
			'rev_page',
			'rev_timestamp',
			'rev_len',
			'rev_user_text',
			'OCTET_LENGTH( old_text ) AS text_len'
		);
		$this->addFields( $selectFields );
		$this->addTables( array( 'revision', 'text' ) );
		$this->addWhereRange( 'rev_id', $params['dir'], $params['startid'], $params['endid'] );
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addJoinConds(
			array(
				'text' => array( 'INNER JOIN', 'rev_text_id=old_id' ),
			)
		);
		$where = array();
		if ( $params['timestamp'] !== null ) {
			// wfTimestamp( TS_MW, $params['timestamp'] ) was done automatically by ApiBase
			$where['rev_timestamp'] = $params['timestamp'];
		}
		if ( $params['usertext'] !== null ) {
			$where['rev_user_text'] = $params['usertext'];
		}
		if ( count( $where ) > 0 ) {
			$this->addWhere( $where );
		}
		$dbres = $this->select(__METHOD__);

		$result = $this->getResult();
		$limit = $params['limit'];

		# return list of similar revisions
		$count = 0;
		foreach ( $dbres as $row ) {
			if ( ++$count > $limit ) {
				$this->setContinueEnumParameter( 'startid', intval( $row->rev_id ) );
				break;
			}
			$vals = $this->extractRowInfo( $row );
			$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $vals );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'startid', intval( $row->rev_id ) );
				break;
			}
		}
		# place result list items into attributes of <similarrev> xml tag
		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'similarrev' );
		unset( $dbres );
	}

	private function extractRowInfo( $row ) {
		$vals = array();
		$vals['revid'] = $row->rev_id;
		$vals['pageid'] = $row->rev_page;
		$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->rev_timestamp );
		$vals['revlen'] = $row->rev_len;
		$vals['textlen'] = $row->text_len;
		$vals['usertext'] = $row->rev_user_text;
		return $vals;
	}

	public function getAllowedParams() {
		return array(
			'startid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'endid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'dir' => array(
				ApiBase :: PARAM_DFLT => 'older',
				ApiBase :: PARAM_TYPE => array(
					'newer',
					'older'
				)
			),
			'limit' => array (
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'timestamp' => array(
				ApiBase :: PARAM_TYPE => 'timestamp'
			),
			'usertext' => array(
				ApiBase :: PARAM_TYPE => 'string'
			)
		);
	}

	public function getParamDescription() {
		return array (
			'startid' => 'from which revision id to start enumeration (enum)',
			'endid' => 'stop revision enumeration on this revid (enum)',
			'dir' => 'direction of enumeration - towards "newer" or "older" revisions (enum)',
			'limit' => 'limit how many revisions will be returned (enum)',
			'timestamp' => 'Timestamp of revisions to look for',
			'usertext' => 'Name of user who created the revisions to look for'
		);
	}

	public function getDescription() {
		return 'Look for revisions with particular timestamp, text length and usertext';
	}

	public function getExamples() {
		return array (
			'Most recently created revisions',
			'api.php?action=similarrev',
			'The same as it would look in JSON (use without fm postfix)',
			'api.php?action=similarrev&format=jsonfm',
			'Get first results (with continuation) of revisions created by user Syntone',
			'api.php?action=similarrev&usertext=Syntone',
			'Get first results (with continuation) of revisions created at time 2008-03-03T20:29:24Z',
			'api.php?action=similarrev&timestamp=2008-03-03T20:29:24Z',
			'Get first results (with continuation) of revisions which has been created by user Syntone, at time 2010-02-24T08:07:21Z',
			'api.php?action=similarrev&usertext=Syntone&timestamp=2010-02-24T08:07:21Z',
		);
	}

	public function getVersion() {
		return __CLASS__  . ': $Id: WikiSyncApi.php 85031 2011-03-30 18:42:27Z reedy $';
	}
} /* end of ApiFindSimilarRev class */

/**
 * Enumerate all available page revisions by order of their creation (edit history)
 *
 * @ingroup API
 */
class ApiRevisionHistory extends ApiWikiSync {

	var $xmlDumpMode = false;
	var $rawOutputMode = false;

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	public function execute() {
		/* Get the parameters of the request. */
		$params = $this->extractRequestParams();
		$db = $this->getDB();
		# next line is required, because getCustomPrinter() is not being executed from FauxRequest
		$this->xmlDumpMode = $params['xmldump'];

		$selectFields = array (
			'rev_id',
			'rev_page',
			'rev_timestamp',
			'rev_len',
			'rev_user_text',
			'OCTET_LENGTH( old_text ) AS text_len'
		);
		$this->addTables( array( 'revision', 'text' ) );
		$this->addWhereRange( 'rev_id', $params['dir'], $params['startid'], $params['endid'] );
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		if ( $params['exclude_user'] !== null ) {
			# we are not including revisions created by WikiSyncBot, which are created in
			# ImportReporter::reportPage to log the reason of import (set by constructors of
			# WikiSyncImportReporter / ImportReporter)
			# otherwise, fake reverse synchronizations might occur
			$this->addWhere( 'rev_user_text != ' . $db->addQuotes( $params['exclude_user'] ) );
		}
		$this->addJoinConds(
			array(
				'text' => array( 'INNER JOIN', 'rev_text_id=old_id' )
			)
		);
		if ( $params['pageinfo'] === true ) {
			$this->addTables( 'page' );
			$this->addJoinConds(
				array(
					'page' => array( 'INNER JOIN', 'page_id=rev_page' ),
				)
			);
			$selectFields = array_merge( $selectFields,
				array( 'page_namespace', 'page_title', 'page_latest' )
			);
		}
		$this->addFields( $selectFields );
		$dbres = $this->select(__METHOD__);
		$limit = $params['limit'];
		$result = $this->getResult();

		if ( $this->xmlDumpMode ) {
			# use default IIS / Apache execution time limit which much larger than default PHP limit
			set_time_limit( 300 );
			$count = $db->numRows( $dbres );
			$db->dataSeek( $dbres, $count - 1 );
			$last_row = $db->fetchObject( $dbres );
			$db->dataSeek( $dbres, 0 );
			$this->addOption( 'LIMIT', $params['limit'] );
			$selectFields = array_merge( $selectFields,
				array( 'page_id',
					'page_restrictions',
					'page_is_redirect',
					'rev_user',
					'rev_text_id',
					'rev_deleted',
					'rev_minor_edit',
					'rev_comment',
					'old_text' )
			);
			if ( $params['pageinfo'] !== true ) {
				$this->addTables( 'page' );
				$this->addJoinConds(
					array(
						'page' => array( 'INNER JOIN', 'page_id=rev_page' ),
					)
				);
				$selectFields = array_merge( $selectFields,
					array( 'page_namespace', 'page_title', 'page_latest' )
				);
			}
			$this->addFields( $selectFields );
			$dbres = $this->select(__METHOD__);
			if ( !$this->rawOutputMode ) {
				while ( $row = $db->fetchObject( $dbres ) ) {
					$vals = $this->extractRowInfo( $row );
					$result->addValue( array( 'query', $this->getModuleName() ), null, $vals );
				}
				$db->dataSeek( $dbres, 0 );
			}
			$exporter = new WikiSyncExporter( $db );
			$exportxml = $exporter->dumpDBresult( $dbres );
			if ( $this->rawOutputMode ) {
				// Don't check the size of exported stuff
				// It's not continuable, so it would cause more
				// problems than it'd solve
				$result->disableSizeCheck();
				$result->reset();
				// Raw formatter will handle this
				$result->addValue(null, 'text', $exportxml);
				$result->addValue(null, 'mime', 'text/xml');
				$result->enableSizeCheck();
				return;
			}
			$result->addValue( 'query', 'exportxml', $exportxml );
			if ( $count > $limit ) {
				$this->setContinueEnumParameter( 'startid', intval( $last_row->rev_id ) );
			}
		} else {
			# revisions edit history mode
			$count = 0;
			foreach ( $dbres as $row ) {
				if ( ++$count > $limit ) {
					$this->setContinueEnumParameter( 'startid', intval( $row->rev_id ) );
					break;
				}
				$vals = $this->extractRowInfo( $row );
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $vals );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'startid', intval( $row->rev_id ) );
					break;
				}
			}
			# place result list items into attributes of <revision> xml tag
			$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'revision' );
//			$this->getResult()->setIndexedTagName( $resultData, 'page' );
//			$this->getResult()->addValue( null, $this->getModuleName(), $resultData );
			unset( $dbres );
		}
	}

	private function extractRowInfo( $row ) {
		$vals = array();
		$vals['revid'] = $row->rev_id;
		$vals['pageid'] = $row->rev_page;
		$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->rev_timestamp );
		$vals['revlen'] = $row->rev_len;
		$vals['textlen'] = $row->text_len;
		$vals['usertext'] = $row->rev_user_text;
		if ( isset( $row->page_namespace ) ) {
			$vals['namespace'] = intval( $row->page_namespace );
		}
		if ( isset( $row->page_title ) ) {
			$vals['title'] = $row->page_title;
		}
		if ( isset( $row->page_is_redirect ) ) {
			$vals['redirect'] = $row->page_is_redirect;
		}
		if ( isset( $row->page_latest ) ) {
			$vals['latest'] = $row->page_latest;
		}
		return $vals;
	}

	public function getCustomPrinter() {
		# If &xmldump and &rawxml are passed in request, use the raw formatter
		if ( $this->xmlDumpMode = $this->getParameter( 'xmldump' ) ) {
			# please note that this method is not called from FauxRequest
			# so local API calls cannot be in rawxml mode
			if ( $this->rawOutputMode = $this->getParameter( 'rawxml' ) ) {
				return new ApiFormatRaw( $this->getMain(), $this->getMain()->createPrinterByName( 'xml' ) );
			}
		}
		return null;
	}

	public function getAllowedParams() {
		return array(
			'startid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'endid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'dir' => array(
				ApiBase :: PARAM_DFLT => 'older',
				ApiBase :: PARAM_TYPE => array(
					'newer',
					'older'
				)
			),
			'limit' => array (
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'exclude_user' => array(
				ApiBase :: PARAM_TYPE => 'user'
			),
			'pageinfo' => false,
			'xmldump' => false,
			'rawxml' => false
		);
	}

	public function getParamDescription() {
		return array (
			'startid' => 'from which revision id to start enumeration (enum)',
			'endid' => 'stop revision enumeration on this revid (enum)',
			'dir' => 'direction of enumeration - towards "newer" or "older" revisions (enum)',
			'limit' => 'limit how many revisions will be returned (enum)',
			'exclude_user' => 'exclude revisions created by particular user',
			'pageinfo' => 'return also information about pages associated with selected revisions',
			'xmldump' => 'return also xml dump of selected revisions',
			'rawxml' => 'return xml dump as raw xml'
		);
	}

	public function getDescription() {
		return 'Enumerate all available page revisions by order of their creation (edit history)';
	}

	public function getExamples() {
		return array (
			'Most recently created revisions',
			'api.php?action=revisionhistory',
			'The same as it would look in JSON (use without fm postfix)',
			'api.php?action=revisionhistory&format=jsonfm',
			'The same with associated page info (use without fm postfix)',
			'api.php?action=revisionhistory&pageinfo&format=jsonfm',
			'Most recently created revisions with no revisions created by WikiSyncBot',
			'api.php?action=revisionhistory&exclude_user=WikiSyncBot',
			'Get first results (with continuation) of revisions with id from 20000 to 19000',
			'api.php?action=revisionhistory&startid=20000&endid=19000',
			'Get first results (with continuation) of revisions with id values from 19000 to 20000 in reverse order',
			'api.php?action=revisionhistory&startid=19000&endid=20000&dir=newer',
			'Get xml dump of first results (with continuation) of revisions with id values from 19000 (wrap)',
			'api.php?action=revisionhistory&startid=19000&dir=newer&xmldump&format=jsonfm',
			'Get xml dump of first results (with continuation) of revisions with id values from 19000 (wrap) with associated page info',
			'api.php?action=revisionhistory&startid=19000&dir=newer&xmldump&format=jsonfm',
			'Get xml dump of first results (no continuation) of revisions with id values from 19000 (raw xml)',
			'api.php?action=revisionhistory&startid=19000&dir=newer&xmldump&rawxml',
			'Standard api xml export in nowrap mode (just for comparsion)',
			'api.php?action=query&export&exportnowrap'
		);
	}

	public function getVersion() {
		return __CLASS__  . ': $Id: WikiSyncApi.php 85031 2011-03-30 18:42:27Z reedy $';
	}
} /* end of ApiRevisionHistory class */

class ApiGetFile extends ApiBase {

	var $dbkey = ''; // a dbkey name of file
	var $fpath; // a filesystem path to file
	var $block = ''; // empty block by default
	var $stat; // file stats, false if error
	var $offset = 0; // file offset

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action );
	}

	private function sendFile( $error_block = '' ) {
		global $wgContLanguageCode;
		if ( headers_sent() ) {
			# there already was sent an error, no need to send anything
			exit();
		}
		if ( $error_block !== '' ) {
			# there was an error, send $error_block message instead of real block
			$this->stat = false;
			$this->block = $error_block;
			$content_type = 'text/plain';
		} else {
			# indicates there is no error
			$content_type = 'application/x-wiki';
		}
		$blocklen = strlen( $this->block );
		# Cancel output buffering and gzipping if set
		wfResetOutputBuffers();
		if ( $this->stat !== false ) {
			$partial_content = ($this->offset !== 0 || $this->stat['size'] !== $blocklen);
			if ( $partial_content ) {
				header( 'HTTP/1.1 206 Partial content' );
				header( 'Accept-Ranges: bytes' );
			}
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $this->stat['mtime'] ) . ' GMT' );
		}
		header( 'Cache-Control: no-cache' );
		header( 'Content-type: ' . $content_type );
		if ( $this->stat !== false ) {
			header( "Content-Disposition: inline;filename*=utf-8'$wgContLanguageCode'" . urlencode( $this->dbkey ) );
			if ( $partial_content ) {
				header( "Content-Range: bytes " . $this->offset . "-" . ( $this->offset + $blocklen - 1 ) . "/" . $this->stat['size'] );
			}
		}
		header( 'Content-Length: ' . $blocklen );
		echo $this->block;
		exit();
	}

	public function execute() {
		/* Get the parameters of the request. */
		$params = $this->extractRequestParams();
		/*
		if( is_null( $params['token'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'token' ) );
		}
		if( !$wgUser->matchEditToken( $params['token'] ) ) {
			$this->dieUsageMsg( array( 'sessionfailure' ) );
		}
		*/
		if( !isset( $params['title'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'title' ) );
		}
		if( !isset( $params['timestamp'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'timestamp' ) );
		}
		if ( !$this->getMain()->canApiHighLimits() ) {
			// throttle a non-priviledged user
			sleep( 1 );
		}
		$title = Title::newFromText( $params['title'], NS_FILE );
		if ( $title instanceof Title ) {
			$this->dbkey = $title->getDBkey();
		} else {
			$this->sendFile( 'Requested title ' . urlencode( $params['title'] ) . ' is invalid' );
		}
		$title = null;
		$file = wfFindFile( $this->dbkey, $params['timestamp'] );
		// only local files are supported, yet
		if ( $file === false ||
				!( $file instanceof LocalFile ) ||
				!$file->exists() ) {
			$this->sendFile( 'Requested file ' . urlencode( $params['title'] ) . ' does not exist or is not an instance of LocalFile' );
		}
		$file->lock();
		if ( $file->isOld() ) {
			$this->fpath = $file->getArchivePath( $file->getArchiveName() );
		} else {
			$this->fpath = $file->getPath();
		}
		if ( ( $f = @fopen( $this->fpath, 'rb' ) ) === false ) {
			$file->unlock();
			$this->sendFile( 'Cannot open file ' . urlencode( $this->fpath ) );
		}
		$this->stat = fstat( $f );
		$this->offset = isset( $params['offset'] ) ? (int) $params['offset'] : 0;
		if ( $this->offset < 0 ) {
			$this->dieUsageMsg( array( 'missingparam', 'offset' ) );
		}
		if ( @fseek( $f, $this->offset ) !== 0 ) {
			fclose( $f );
			$file->unlock();
			$this->sendFile( 'Cannot seek file ' . urlencode( $this->fpath ) );
		}
		$this->block = @fread( $f, $params['blocklen'] );
		fclose( $f );
		if ( $this->block === false ) {
			$this->block = '';
			fclose( $f );
			$file->unlock();
			$this->sendFile( 'Cannot read block ' . urlencode( $params['blocklen'] ) . ' from file ' . urlencode( $this->fpath ) );
		}
		// success
		$file->unlock();
		$this->sendFile();
	}

	public function getAllowedParams() {
		return array(
#			'token' => null,
			'title' => null,
			'timestamp' => array(
				ApiBase :: PARAM_TYPE => 'timestamp'
			),
			'offset' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
			'blocklen' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => 1024 * 1024,
				ApiBase::PARAM_MAX2 => 2 * 1024 * 1024
			)
		);
	}

	public function getParamDescription() {
		return array (
#			'token' => 'Edit token. You can get one of these through prop=info',
			'title' => 'title of file to get',
			'timestamp' => 'timestamp of archived file (to make sure the file hasn\'t been changed while getting the chunks)',
			'offset' => 'start offset in file to get (default 0)',
			'blocklen' => 'length of block to get (omit to get all the file)'
		);
	}

	public function getDescription() {
		return 'Transfers file from remote wiki in chunks. Requires valid session id and login token. Always returns raw HTTP data. HTTP header \'Content-type: application/x-wiki\' indicates valid file chunk. Otherwise, if there is no such header, body contains error message.';
	}

	public function getExamples() {
		return array (
			'Get the chunk of new / archived file specified by timestamp',
			'api.php?action=getfile&format=json&title=File:Myfile.jpg&timestamp=2010-10-28T10:15:22Z&offset=512&blocklen=1024'
		);
	}

	public function getVersion() {
		return __CLASS__  . ': $Id: WikiSyncApi.php 85031 2011-03-30 18:42:27Z reedy $';
	}

} /* end of ApiGetFile class */

class ApiSyncImport extends ApiImport {

	public function __construct($main, $action) {
		parent :: __construct($main, $action);
	}

	public function execute() {
		global $wgUser;
		if ( !$wgUser->isAllowed( 'import' ) ) {
			$this->dieUsageMsg( array('cantimport') );
		}
		$params = $this->extractRequestParams();
		if ( !isset( $params['token'] ) ) {
			$this->dieUsageMsg( array('missingparam', 'token') );
		}
		if ( !$wgUser->matchEditToken( $params['token'] ) ) {
			$this->dieUsageMsg( array('sessionfailure') );
		}

		if ( !$wgUser->isAllowed( 'importupload' ) ) {
			$this->dieUsageMsg( array('cantimport-upload') );
		}
		$source = ImportStreamSource::newFromUpload( 'xml' );
		if ( $source instanceof Status ) {
			if ( $source->isOK() ) {
				$source = $source->value;
			} else {
				$this->dieUsageMsg( array('import-unknownerror', $source->getWikiText() ) );
			}
		} elseif ( $source instanceof WikiErrorMsg ) {
			$this->dieUsageMsg( array_merge( array($source->getMessageKey()), $source->getMessageArgs() ) );
		} elseif ( WikiError::isError( $source ) ) {
			// This shouldn't happen
			$this->dieUsageMsg( array('import-unknownerror', $source->getMessage() ) );
		}
		$importer = new WikiImporter( $source );
		$reporter = new WikiSyncImportReporter( $importer, true, '', wfMsg( 'wikisync_log_imported_by' ) );

		$result = $importer->doImport();
		if ( $result instanceof WikiXmlError ) {
			$this->dieUsageMsg( array('import-xml-error',
				$result->mLine,
				$result->mColumn,
				$result->mByte . $result->mContext,
				xml_error_string($result->mXmlError) ) );
		} elseif ( WikiError::isError( $result ) ) {
			// This shouldn't happen
			$this->dieUsageMsg( array('import-unknownerror', $result->getMessage() ) );
		}
		$resultData = $reporter->getData();
		$this->getResult()->setIndexedTagName( $resultData, 'page' );
		$this->getResult()->addValue( null, $this->getModuleName(), $resultData );
	}

	public function getAllowedParams() {
		global $wgImportSources;
		return array (
			'token' => null,
			'xml' => null,
		);
	}

	public function getParamDescription() {
		return array (
			'token' => 'Import token obtained through prop=info',
			'xml' => 'Uploaded XML file',
		);
	}

	public function getDescription() {
		return array (
			'Import a page from XML file, with suppressing of creation of informational null revisions'
		);
	}

	public function getExamples() {
		return array();
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiSyncApi.php 85031 2011-03-30 18:42:27Z reedy $';
	}

} /* end of ApiSyncImport class */
