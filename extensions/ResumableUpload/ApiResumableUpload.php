<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * @copyright Copyright © 2010 Mark A. Hershberger <mah@everybody.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class ApiResumableUpload extends ApiUpload {
	protected $mUpload = null, $mParams = null;

	public function execute() {
		global $wgUser;

		// Check whether upload is enabled
		if ( !UploadBase::isEnabled() ) {
			$this->dieUsageMsg( array( 'uploaddisabled' ) );
		}

		$this->mParams = $this->extractRequestParams();

		$this->validateParams( $this->mParams );

		$request = $this->getMain()->getRequest();
		$this->mUpload = new ResumableUploadHandler;

		$status = $this->mUpload->initialize(
			$request->getVal( 'done', null ),
			$request->getVal( 'offset', null ),
			$request->getVal( 'filename', null ),
			$request->getVal( 'chunksession', null ),
			$request->getFileTempName( 'chunk' ),
			$request->getFileSize( 'chunk' ),
			$request->getSessionData( UploadBase::getSessionKeyname() )
		);

		if ( $status !== true ) {
			$this->dieUsage(  $status, 'chunk-init-error' );
		}

		$ret = $this->performUpload( );

		if(is_array($ret)) {
			foreach($ret as $key => $val) {
				$this->getResult()->addValue(null, $key, $val);
			}
		} else {
			$this->dieUsage($ret, 'error');
		}
	}

	public function getUpload() { 
		return $this->mUpload; 
	}

	public function performUploadInit($comment, $pageText, $watchlist, $user) {
		// Verify the initial upload request
		$this->verifyUploadInit();
		
		$session = $this->mUpload->setupChunkSession( $comment, $pageText, $watchlist );
		return array('uploadUrl' =>
			wfExpandUrl( wfScript( 'api' ) ) . "?" .
			wfArrayToCGI( array(
				'action' => 'resumableupload',
				'token' => $user->editToken(),
				'format' => 'json',
				'chunksession' => $session,
				'filename' => $this->mUpload->getDesiredName(),
			) ) );
	}
	
	/**
	 * Check the upload 
	 */
	public function verifyUploadInit(){

		// Check for valid name: 
		$check = $this->mUpload->validateName();
		if( $check !== true ) {
			return $this->getVerificationError( $check );
		}
		
		// Check proposed file size
		$maxSize = $this->getMaxUploadSize( '*' );
		if( $this->mFileSize > $maxSize ) {
			// We have to return an array here instead of getVerificationError so that we can include
			// the max size info. 
			return array(
				'status' => self::FILE_TOO_LARGE,
				'max' => $maxSize,
			);
		}
		
		return true;
	}

	public function performUploadChunk() {
		$this->mUpload->setupChunkSession();
		$status = $this->mUpload->appendChunk();
		if ( !$status->isOK() ) {
			$this->dieUsage($status->getWikiText(), 'error');
		}
		return array( 'result' => 1, 'filesize' => $this->mUpload->getFileSize() );
	}

	public function performUploadDone( $user ) {
		$this->mUpload->finalizeFile();
		$status = parent::performUpload( $this->comment, $this->pageText, $this->watchlist, $user );

		if ( $status['result'] !== 'Success' ) {
			return $status;
		}
		$file = $this->mUpload->getLocalFile();
		return array('result' => 1, 'done' => 1, 'resultUrl' =>  wfExpandUrl( $file->getDescriptionUrl() ) );
	}

	/**
	 * Handle a chunk of the upload.  
	 * @see UploadBase::performUpload
	 */
	public function performUpload( ) {
		wfDebug( "\n\n\performUpload(chunked): comment: " . $this->comment .
				 ' pageText: ' . $this->pageText . ' watch: ' . $this->watchlist );
		$ret = "unknown error";

		global $wgUser;
		switch( $this->mUpload->getChunkMode() ){
			case ResumableUploadHandler::INIT:
				return $this->performUploadInit($this->comment, $this->pageText, $this->watchlist, $wgUser);
				break;
			case  ResumableUploadHandler::CHUNK:
				return $this->performUploadChunk();
				break;
			case ResumableUploadHandler::DONE:
				return $this->performUploadDone($wgUser);;
				break;
		}
		return $ret;
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	protected function validateParams( $params ) {
		$required = array();
		// Check required params for each upload mode:
		switch( $this->mUpload->getChunkMode() ){
			case ResumableUploadHandler::INIT:
				$required[] = 'filename';
				$required[] = 'comment';
				$required[] = 'token';
				$required[] = 'filesize';
				break;
			case  ResumableUploadHandler::CHUNK:
				$required[] = 'offset';
				$required[] = 'chunksession';
				// The actual file payload:
				$required[] = 'chunk';
				break;
			case ResumableUploadHandler::DONE:
				$required[] = 'chunksession';
				break;
		}
		foreach( $required as $arg ) {
			if ( !isset( $params[$arg] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $arg ) );
			}
		}
	}

	public function getAllowedParams() {
		return array(
			'filename' => null,
			'token' => null,
			'comment' => null,
			'ignorewarnings' => false,
			'chunksession' => null,
			'chunk' => null,
			'offset' => null,
			'done' => false,
			'watchlist' => array(
				ApiBase::PARAM_DFLT => 'preferences',
				ApiBase::PARAM_TYPE => array(
					'watch',
					'unwatch',
					'preferences',
					'nochange'
				),
			),
		);
	}

	public function getParamDescription() {		
		return array(
			'filename' => 'Target filename',
			'filesize' => 'The total size of the file being uploaded',
			'token' => 'Edit token. You can get one of these through prop=info',
			'comment' => 'Upload comment',
			'watchlist' => 'Unconditionally add or remove the page from your watchlist, use preferences or do not change watch',
			'ignorewarnings' => 'Ignore any warnings',
			'chunksession' => 'The session key, established on the first contact during the chunked upload',
			'chunk' => 'The data in this chunk of a chunked upload',
			'offset' => 'The start offset of the current chunk in bytes',
			'done' => 'Set to 1 on the last chunk of a chunked upload',
		
			'sessionkey' => 'Session key that identifies a previous upload that was stashed temporarily.',
			'stash' => 'If set, the server will not add the file to the repository and stash it temporarily.',
		);
	}

	public function getDescription() {
		return array(
			'Upload a file in chunks'
		);
	}

	public function getPossibleErrors() {
		return array_merge(
			parent::getPossibleErrors(),
			array(
				array( 'missingparam' ),
				array( 'chunk-init-error' ),
				array( 'code' => 'chunk-init-error', 'info' => 'Insufficient information for initialization.' ),
				array( 'code' => 'chunked-error', 'info' => 'There was a problem initializing the chunked upload.' ),
			)
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=resumableupload&filename=Wiki.png',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiResumableUpload.php 83770 2011-03-12 18:09:59Z reedy $';
	}
}
