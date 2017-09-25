<?php
/**
 * @author Hyun Lim
 */

class UploadPhotosController extends WikiaController {
	const UPLOAD_WARNING = -2;
	const UPLOAD_PERMISSION_ERROR = -1;

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		$licenses = new Licenses(array('id' => 'wpLicense', 'name' => 'wpLicense', 'fieldname' => 'wpLicense'));
		$this->licensesHtml = $licenses->getInputHTML(null);

		wfProfileOut(__METHOD__);
	}

	/**
	 * This method hacks the normal nirvana dispatcher chain because of AIM and application/json mimetype incompatibility
	 * Talk to Hyun or Inez
	 */
	public function upload() {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgUser;

		if(!$wgUser->isLoggedIn()) {
			echo 'Not logged in';
			exit();
		}

		$this->checkWriteRequest();

		$this->watchthis = $wgRequest->getBool('wpWatchthis') && $wgUser->isLoggedIn();
		$this->license = $wgRequest->getText('wpLicense');
		$this->copyrightstatus = $wgRequest->getText('wpUploadCopyStatus');
		$this->copyrightsource = $wgRequest->getText('wpUploadSource');
		$this->ignorewarning = $wgRequest->getCheck('wpIgnoreWarning');
		$this->overwritefile = $wgRequest->getCheck('wpDestFileWarningAck');
		$this->defaultcaption = $wgRequest->getText('wpUploadDescription');
		$details = null;
		$up = new UploadFromFile();
		$up->initializeFromRequest($wgRequest);
		$permErrors = $up->verifyPermissions($wgUser);

		if ( $permErrors !== true ) {
			$this->status = self::UPLOAD_PERMISSION_ERROR;
			$this->statusMessage = $this->uploadMessage( $this->status, null );
		} else if (empty($this->wg->EnableUploads)) {
			// BugId:6122
			$this->statusMessage = wfMessage('uploaddisabled')->text();
		} else {
			$details = $up->verifyUpload();

			$this->status = (is_array($details) ? $details['status'] : UploadBase::UPLOAD_VERIFICATION_ERROR);
			$this->statusMessage = '';

			if ($this->status > 0) {
				$this->statusMessage = $this->uploadMessage($this->status, $details);
			} else {
				$warnings = array();
				if(!$this->ignorewarning) {
					$warnings = $up->checkWarnings();

					// BugId:3325 - add handling for "Overwrite File" checkbox
					if ($this->overwritefile && !empty($warnings['exists'])) {
						unset($warnings['exists']);
					}

					if(!empty($warnings)) {
						$this->status = self::UPLOAD_WARNING;
						$this->statusMessage .= $this->uploadWarning($warnings);
					}
				}
				if(empty($warnings)) {
					$pageText = SpecialUpload::getInitialPageText( $this->defaultcaption, $this->license,
						$this->copyrightstatus, $this->copyrightsource );
					$status = $up->performUpload( $this->defaultcaption, $pageText, $this->watchthis, $wgUser );
					if ($status->isGood()) {
						$aPageProps = array ( 'default_caption' => $this->defaultcaption );
						Wikia::setProps( $up->getTitle()->getArticleID(), $aPageProps );
					} else {
						$this->statusMessage .= "something is wrong with upload";
					}
				}
			}
		}

		echo json_encode($this->getResponse()->getData());
		header('content-type: text/plain; charset=utf-8');

		wfProfileOut(__METHOD__);

		exit();	//end hack
	}

	public function executeExistsWarning($params) {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$existsWarning = SpecialUpload::ajaxGetExistsWarning($wgRequest->getVal('wpDestFile'));
		if(!empty($existsWarning) && $existsWarning != '&#160;') {
			$existsWarning = '<h3>'.wfMessage('uploadwarning')->text().'</h3>'.$existsWarning;
		} else {
			$existsWarning = '';
		}
		$this->existsWarning = $existsWarning;
		wfProfileOut(__METHOD__);
	}

	/**
	 * This is practicaly a copy of UploadForm->processUpload(SpecialUpload.php), but just handles and returns status message
	 */
	private function uploadMessage($statusCode, $details) {
		global $wgLang, $wgFileExtensions;
		$msg = '';
		switch($statusCode) {
			case UploadBase::SUCCESS:
				break;

			case UploadBase::EMPTY_FILE:
				$msg = wfMessage( 'emptyfile' )->escaped();
				break;

			case UploadBase::MIN_LENGTH_PARTNAME:
				$msg = wfMessage( 'minlength1' )->escaped();
				break;

			case UploadBase::ILLEGAL_FILENAME:
				$filtered = $details['filtered'];
				$msg = wfMessage('illegalfilename', htmlspecialchars( $filtered ))->parse();
				break;

			case UploadBase::OVERWRITE_EXISTING_FILE:
				$msg = $details['overwrite'];
				break;

			case UploadBase::FILETYPE_MISSING:
				$msg = wfMessage( 'filetype-missing' )->escaped();
				break;

			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $details['finalExt'];
				$msg = wfMessage( 'filetype-banned-type',
					htmlspecialchars( $finalExt ),
					$wgLang->commaList( $wgFileExtensions ),
					$wgLang->formatNum( count($wgFileExtensions) )
				)->parse();
				break;

			case UploadBase::VERIFICATION_ERROR:
				$msg = wfMessage($details['details'][0])->escaped();
				break;

			case UploadBase::UPLOAD_VERIFICATION_ERROR:
				$msg = $details['error'];
				break;

			case UploadBase::FILE_TOO_LARGE:
				$msg = wfMessage( 'largefileserver' )->escaped();
				break;

			case self::UPLOAD_PERMISSION_ERROR:
				$msg = wfMessage( 'badaccess' )->escaped();
				break;

			default:
				throw new MWException( __METHOD__ . ": Unknown value `{$statusCode}`" );
	 	}

	 	return $msg;
	}

	private function uploadWarning($warnings) {
		$msg = '<h2>'.wfMessage('uploadwarning')->escaped().'</h2><ul class="warning">';

		foreach($warnings as $warning => $args) {
			if( $warning == 'exists' ) {
				$msg .= "\t<li>" . SpecialUpload::getExistsWarning( $args ) . "</li>\n";
			} elseif( $warning == 'duplicate' ) {
				$msg .= SpecialUpload::getDupeWarning( $args );
			} elseif( $warning == 'duplicate-archive' ) {
				$msg .= "\t<li>" . wfMessage( 'file-deleted-duplicate',
						array( Title::makeTitle( NS_FILE, $args )->getPrefixedText() ) )->parse()
					. "</li>\n";
			} else {
				if ( $args === true )
					$args = array();
				elseif ( !is_array( $args ) )
					$args = array( $args );
				$msg .= "\t<li>" . wfMessage( $warning, $args )->parse() . "</li>\n";
			}
		}

		$msg .= '</ul>';
		return $msg;
	}

}
