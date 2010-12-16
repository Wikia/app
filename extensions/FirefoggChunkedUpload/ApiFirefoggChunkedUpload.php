<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * @copyright Copyright © 2010 Mark A. Hershberger <mah@everybody.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class ApiFirefoggChunkedUpload extends ApiUpload {
	/* public function __construct( $main, $action ) { */
	/* 	parent::__construct( $main, $action ); */
	/* } */

	public function execute() {
		global $wgUser;

		// Check whether upload is enabled
		if ( !UploadBase::isEnabled() ) {
			$this->dieUsageMsg( array( 'uploaddisabled' ) );
		}

		$this->mParams = $this->extractRequestParams();

		$this->validateParams( $this->mParams );

		$request = $this->getMain()->getRequest();
		$this->mUpload = new FirefoggChunkedUploadHandler;

		$status = $this->mUpload->initialize(
			$request->getVal( 'done', null ),
			$request->getVal( 'filename', null ),
			$request->getVal( 'chunksession', null ),
			$request->getFileTempName( 'chunk' ),
			$request->getFileSize( 'chunk' ),
			$request->getSessionData( 'wsUploadData' )
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

	public function getUpload() { return $this->mUpload; }

	public function performUploadInit($comment, $pageText, $watch, $user) {
		$check = $this->mUpload->validateNameAndOverwrite();
		if( $check !== true ) {
			$this->getVerificationError( $check );
		}

		$session = $this->mUpload->setupChunkSession( $comment, $pageText, $watch );
		return array('uploadUrl' =>
			wfExpandUrl( wfScript( 'api' ) ) . "?" .
			wfArrayToCGI( array(
				'action' => 'firefoggupload',
				'token' => $user->editToken(),
				'format' => 'json',
				'chunksession' => $session,
				'filename' => $this->mUpload->getDesiredName(),
			) ) );
	}

	public function performUploadChunk() {
		$this->mUpload->setupChunkSession();
		$status = $this->mUpload->appendChunk();
		if ( !$status->isOK() ) {
			$this->dieUsage($status->getWikiText(), 'error');
		}
		return array('result' => 1, 'filesize' => $this->mUpload->getFileSize() );
	}

	public function performUploadDone($user) {
		$this->mUpload->finalizeFile();
		$status = parent::performUpload( $this->comment, $this->pageText, $this->watch, $user );

		if ( $status['result'] !== 'Success' ) {
			return $status;
		}
		$file = $this->mUpload->getLocalFile();
		return array('result' => 1, 'done' => 1, 'resultUrl' =>  wfExpandUrl( $file->getDescriptionUrl() ) );
	}

	/**
	 * Handle a chunk of the upload.  Overrides the parent method
	 * because Chunked Uploading clients (i.e. Firefogg) require
	 * specific API responses.
	 * @see UploadBase::performUpload
	 */
	public function performUpload( ) {
		wfDebug( "\n\n\performUpload(chunked): comment: " . $this->comment .
				 ' pageText: ' . $this->pageText . ' watch: ' . $this->watch );
		$ret = "unknown error";

		global $wgUser;
		if ( $this->mUpload->getChunkMode() == FirefoggChunkedUploadHandler::INIT ) {
			$ret = $this->performUploadInit($this->comment, $this->pageText, $this->watch, $wgUser);
		} else if ( $this->mUpload->getChunkMode() == FirefoggChunkedUploadHandler::CHUNK ) {
			$ret = $this->performUploadChunk();
		} else if ( $this->mUpload->getChunkMode() == FirefoggChunkedUploadHandler::DONE ) {
			$ret = $this->performUploadDone($user);
		}

		return $ret;
	}

	/**
	 * Produce the usage error
	 * After 1.16, this function is in UploadBase
	 *
	 * @param $verification array an associative array with the status
	 * key
	 */
	public function getVerificationError( $verification ) {
		// TODO: Move them to ApiBase's message map
		switch( $verification['status'] ) {
			case UploadBase::EMPTY_FILE:
				$this->dieUsage( 'The file you submitted was empty', 'empty-file' );
				break;
			case UploadBase::FILETYPE_MISSING:
				$this->dieUsage( 'The file is missing an extension', 'filetype-missing' );
				break;
			case UploadBase::FILETYPE_BADTYPE:
				global $wgFileExtensions;
				$this->dieUsage( 'This type of file is banned', 'filetype-banned',
						0, array(
							'filetype' => $verification['finalExt'],
							'allowed' => $wgFileExtensions
						) );
				break;
			case UploadBase::MIN_LENGTH_PARTNAME:
				$this->dieUsage( 'The filename is too short', 'filename-tooshort' );
				break;
			case UploadBase::ILLEGAL_FILENAME:
				$this->dieUsage( 'The filename is not allowed', 'illegal-filename',
						0, array( 'filename' => $verification['filtered'] ) );
				break;
			case UploadBase::OVERWRITE_EXISTING_FILE:
				$this->dieUsage( 'Overwriting an existing file is not allowed', 'overwrite' );
				break;
			case UploadBase::VERIFICATION_ERROR:
				$this->getResult()->setIndexedTagName( $verification['details'], 'detail' );
				$this->dieUsage( 'This file did not pass file verification', 'verification-error',
						0, array( 'details' => $verification['details'] ) );
				break;
			case UploadBase::HOOK_ABORTED:
				$this->dieUsage( "The modification you tried to make was aborted by an extension hook",
						'hookaborted', 0, array( 'error' => $verification['error'] ) );
				break;
			default:
				$this->dieUsage( 'An unknown error occurred', 'unknown-error',
						0, array( 'code' =>  $verification['status'] ) );
				break;
		}
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	protected function validateParams( $params ) {
		if( $params['done'] ) {
			$required[] = 'chunksession';
		}
		if( $params['chunksession'] === null ) {
			$required[] = 'filename';
			$required[] = 'comment';
			$required[] = 'watch';
			$required[] = 'ignorewarnings';
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
			'watch' => false,
			'ignorewarnings' => false,
			'chunksession' => null,
			'chunk' => null,
			'done' => false,
		);
	}

	public function getParamDescription() {
		return array(
			'filename' => 'Target filename',
			'token' => 'Edit token. You can get one of these through prop=info',
			'comment' => 'Upload comment',
			'watch' => 'Watch the page',
			'ignorewarnings' => 'Ignore any warnings',
			'chunksession' => 'The session key, established on the first contact during the chunked upload',
			'chunk' => 'The data in this chunk of a chunked upload',
			'done' => 'Set to 1 on the last chunk of a chunked upload',
		);
	}

	public function getDescription() {
		return array(
			'Upload a file in chunks using the protocol documented at http://firefogg.org/dev/chunk_post.html'
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
			'api.php?action=firefoggupload&filename=Wiki.png',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
