<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * @copyright Copyright © 2010 Mark A. Hershberger <mah@everybody.org>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class ResumableUploadHandler extends UploadBase {
	const INIT = 1;
	const CHUNK = 2;
	const DONE = 3;

	protected $chunkMode; // INIT, CHUNK, DONE
	protected $sessionKey;
	protected $comment;
	protected $repoPath;
	protected $pageText;
	protected $watchlist;

	public $status;
 
	public function initializeFromRequest(&$request) {}
	public function getChunkMode() {return $this->chunkMode;}
	public function getDesiredName() {return $this->mDesiredDestName;}

	/**
	 * Set session information for chunked uploads and allocate a unique key.
	 * @param $comment string
	 * @param $pageText string
	 * @param $watchlist bodolean
	 *
	 * @return string the session key for this chunked upload
	 */
	public function setupChunkSession( $comment, $pageText, $watchlist ) {
		if ( !isset( $this->sessionKey ) ) {
			$this->sessionKey = $this->getSessionKey();
		}
		foreach ( array( 'mFilteredName', 'repoPath', 'mFileSize', 'mDesiredDestName' )
				as $key ) {
			if ( isset( $this->$key ) ) {
				$_SESSION[UploadBase::SESSION_KEYNAME][$this->sessionKey][$key] = $this->$key;
			}
		}
		if ( isset( $comment ) ) {
			$_SESSION[UploadBase::SESSION_KEYNAME][$this->sessionKey]['commment'] = $comment;
		}
		if ( isset( $pageText ) ) {
			$_SESSION[UploadBase::SESSION_KEYNAME][$this->sessionKey]['pageText'] = $pageText;
		}
		if ( isset( $watchlist ) ) {
			$_SESSION[UploadBase::SESSION_KEYNAME][$this->sessionKey]['watchlist'] = $watchlist;
		}
		$_SESSION[UploadBase::SESSION_KEYNAME][$this->sessionKey]['version'] = UploadBase::SESSION_VERSION;

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
	public function initialize( $done, $chunkOffset, $filename, $sessionKey, $path, $chunkSize, $sessionData ) {
		if( $filename ) $this->mDesiredDestName = $filename;
		$this->mTempPath = $path;
		$this->mChunkOffset = $chunkOffset;

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
	 * @return void
	 */
	protected function initFromSessionKey( $sessionKey, $sessionData, $fileSize ) {
		// testing against null because we don't want to cause obscure
		// bugs when $sessionKey is full of "0"
		$this->sessionKey = $sessionKey;

		if ( isset( $sessionData[$this->sessionKey]['version'] )
			&& $sessionData[$this->sessionKey]['version'] == UploadBase::SESSION_VERSION )
		{
			foreach ( array( 'comment', 'pageText', 'watchlist', 'mFilteredName', 'repoPath', 'mFileSize', 'mDesiredDestName' )
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
				$_SESSION[UploadBase::SESSION_KEYNAME][$this->sessionKey]['repoPath'] = $this->repoPath;
			}
			return $this->status;
		}
		
		if ( $this->getRealPath( $this->repoPath ) ) {
		    if ( $this->getSize( $this->repoPath ) == $this->mChunkOffset ) {
			    $this->status = $this->appendToUploadFile( $this->mTempPath, $this->repoPath );
			    if ( $this->mFileSize >	$wgMaxUploadSize )
				    $this->status = Status::newFatal( 'largefileserver' );
		    } else {
			    $this->status = Status::newFatal( 'failed, chunk offset does not match file' );
		    }

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
		$this->appendFinal( $this->repoPath );
		$this->mTempPath = $this->getRealPath( $this->repoPath );
	}
}
