<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * @copyright Copyright © 2010 Mark A. Hershberger <mah@everybody.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class FirefoggChunkedUploadHandler extends UploadBase {
	const INIT = 1;
	const CHUNK = 2;
	const DONE = 3;

	protected $chunkMode; // INIT, CHUNK, DONE
	protected $sessionKey;
	protected $comment;
	protected $repoPath;
	protected $pageText;
	protected $watch;

	public $status;

	public function initializeFromRequest(&$request) {}
	public function getChunkMode() {return $this->chunkMode;}
	public function getDesiredName() {return $this->mDesiredDestName;}

	/**
	 * Set session information for chunked uploads and allocate a unique key.
	 * @param $comment string
	 * @param $pageText string
	 * @param $watch bodolean
	 *
	 * @returns string the session key for this chunked upload
	 */
	public function setupChunkSession( $comment, $pageText, $watch ) {
		if ( !isset( $this->sessionKey ) ) {
			$this->sessionKey = $this->getSessionKey();
		}
		foreach ( array( 'mFilteredName', 'repoPath', 'mFileSize', 'mDesiredDestName' )
				as $key ) {
			if ( isset( $this->$key ) ) {
				$_SESSION['wsUploadData'][$this->sessionKey][$key] = $this->$key;
			}
		}
		if ( isset( $comment ) ) {
			$_SESSION['wsUploadData'][$this->sessionKey]['commment'] = $comment;
		}
		if ( isset( $pageText ) ) {
			$_SESSION['wsUploadData'][$this->sessionKey]['pageText'] = $pageText;
		}
		if ( isset( $watch ) ) {
			$_SESSION['wsUploadData'][$this->sessionKey]['watch'] = $watch;
		}
		$_SESSION['wsUploadData'][$this->sessionKey]['version'] = self::SESSION_VERSION;

		return $this->sessionKey;
	}

	/**
	 * Initialize a request
	 * @param $done boolean Set if this is the last chunk
	 * @param $filename string The desired filename, set only on first request.
	 * @param $sessionKey string The chunksession parameter
	 * @param $path string The path to the temp file containing this chunk
	 * @param $chunkSize integer The size of this chunk
	 * @param $sessionData array sessiondata
	 *
	 * @return mixed True if there was no error, otherwise an error description suitable for passing to dieUsage()
	 */
	public function initialize( $done, $filename, $sessionKey, $path, $chunkSize, $sessionData ) {
		if( $filename ) $this->mDesiredDestName = $filename;
		$this->mTempPath = $path;

		if ( $sessionKey !== null ) {
			$status = $this->initFromSessionKey( $sessionKey, $sessionData, $chunkSize );
			if( $status !== true ) {
				return $status;
			}

			if ( $done ) {
				$this->chunkMode = self::DONE;
			} else {
				$this->mTempPath = $path;
				$this->chunkMode = self::CHUNK;
			}
		} else {
			// session key not set, init the chunk upload system:
			$this->chunkMode = self::INIT;
		}

		if ( $this->mDesiredDestName === null ) {
			return 'Insufficient information for initialization.';
		}

		return true;
	}

	/**
	 * Initialize a continuation of a chunked upload from a session key
	 * @param $sessionKey string
	 * @param $request WebRequest
	 * @param $fileSize int Size of this chunk
	 *
	 * @returns void
	 */
	protected function initFromSessionKey( $sessionKey, $sessionData, $fileSize ) {
		// testing against null because we don't want to cause obscure
		// bugs when $sessionKey is full of "0"
		$this->sessionKey = $sessionKey;

		if ( isset( $sessionData[$this->sessionKey]['version'] )
			&& $sessionData[$this->sessionKey]['version'] == self::SESSION_VERSION )
		{
			foreach ( array( 'comment', 'pageText', 'watch', 'mFilteredName', 'repoPath', 'mFileSize', 'mDesiredDestName' )
					as $key ) {
				if ( isset( $sessionData[$this->sessionKey][$key] ) ) {
					$this->$key = $sessionData[$this->sessionKey][$key];
				}
			}

			$this->mFileSize += $fileSize;
		} else {
			return 'Not a valid session key';
		}

		return true;
	}

	/**
	 * Return the file size
	 * After 1.16, this function is in UploadBase
	 *
	 * @return integer
	 */
	public function getFileSize() {
		return $this->mFileSize;
	}

	/**
	 * Append a file to the Repo file
	 * After 1.16, this function is in UploadBase
	 *
	 * @param string $srcPath Path to source file
	 * @param string $toAppendPath Path to the Repo file that will be appended to.
	 * @return Status Status
	 */
	protected function appendToUploadFile( $srcPath, $toAppendPath ) {
		$repo = RepoGroup::singleton()->getLocalRepo();
		$status = $repo->append( $srcPath, $toAppendPath );
		return $status;
	}

	/**
	 * Append a chunk to the temporary file.
	 *
	 * @return void
	 */
	public function appendChunk() {
		global $wgMaxUploadSize;

		if ( !$this->repoPath ) {
			$this->status = $this->saveTempUploadedFile( $this->mDesiredDestName, $this->mTempPath );

			if ( $this->status->isOK() ) {
				$this->repoPath = $this->status->value;
				$_SESSION['wsUploadData'][$this->sessionKey]['repoPath'] = $this->repoPath;
			}
			return $this->status;
		}
		if ( $this->getRealPath( $this->repoPath ) ) {
			$this->status = $this->appendToUploadFile( $this->repoPath, $this->mTempPath );

			if ( $this->mFileSize >	$wgMaxUploadSize )
				$this->status = Status::newFatal( 'largefileserver' );

		} else {
			$this->status = Status::newFatal( 'filenotfound', $this->repoPath );
		}
		return $this->status;
	}

	/**
	 * Append the final chunk and ready file for parent::performUpload()
	 * @return void
	 */
	public function finalizeFile() {
		$this->appendChunk();
		$this->mTempPath = $this->getRealPath( $this->repoPath );
	}

	/**
	 * Check if there's an overwrite conflict and, if so, if restrictions
	 * forbid this user from performing the upload.
	 * After 1.16, this function is in UploadBase
	 *
	 * @return mixed true on success, error string on failure
	 */
	private function checkOverwrite() {
		global $wgUser;
		// First check whether the local file can be overwritten
		$file = $this->getLocalFile();
		if( $file->exists() ) {
			if( !self::userCanReUpload( $wgUser, $file ) ) {
				return 'fileexists-forbidden';
			} else {
				return true;
			}
		}

		/* Check shared conflicts: if the local file does not exist, but
		 * wfFindFile finds a file, it exists in a shared repository.
		 */
		$file = wfFindFile( $this->getTitle() );
		if ( $file && !$wgUser->isAllowed( 'reupload-shared' ) ) {
			return 'fileexists-shared-forbidden';
		}

		return true;
	}

	/**
	 * Verify that the name is valid and, if necessary, that we can overwrite
	 * After 1.16, this function is in UploadBase
	 *
	 * @return mixed true if valid, otherwise and array with 'status'
	 * and other keys
	 **/
	public function validateNameAndOverwrite() {
		$nt = $this->getTitle();
		if( is_null( $nt ) ) {
			$result = array( 'status' => $this->mTitleError );
			if( $this->mTitleError == self::ILLEGAL_FILENAME ) {
				$result['filtered'] = $this->mFilteredName;
			}
			if ( $this->mTitleError == self::FILETYPE_BADTYPE ) {
				$result['finalExt'] = $this->mFinalExtension;
			}
			return $result;
		}
		$this->mDestName = $this->getLocalFile()->getName();

		/**
		 * In some cases we may forbid overwriting of existing files.
		 */
		$overwrite = $this->checkOverwrite();
		if( $overwrite !== true ) {
			return array(
				'status' => self::OVERWRITE_EXISTING_FILE,
				'overwrite' => $overwrite
			);
		}
		return true;
	}
}