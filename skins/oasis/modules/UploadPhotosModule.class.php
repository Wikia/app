<?php
/**
 * @author Hyun Lim
 */
 
class UploadPhotosModule extends Module {

	var $wgScriptPath;
	var $licensesHtml;
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);
		
		$licenses = new Licenses();
		$this->licensesHtml = $licenses->getHtml();
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * This method hacks the normal moduleProxy() chain because of AIM and application/json mimetype incompatibility
	 * Talk to Hyun or Inez
	 */
	public function executeUpload($params) {
		wfProfileIn(__METHOD__);
		global $wgRequest;
		
		$details = null;
		
		$f = new UploadForm($wgRequest);
		$this->status = $f->internalProcessUpload($details);
		$this->statusMessage = '';
		
		if ($this->status > 0) {
			$this->statusMessage = $this->uploadMessage($this->status, $details, $f);
		}
	
		echo json_encode($this->getData());
		header('content-type: text/plain; charset=utf-8');
	
		wfProfileOut(__METHOD__);
		
		exit();	//end hack
	}
	
	public function executeExistsWarning($params) {
		wfProfileIn(__METHOD__);
		global $wgRequest;
		
		$this->existsWarning = UploadForm::ajaxGetExistsWarning($wgRequest->getVal('wpDestFile'));
		if(!empty($this->existsWarning) && $this->existsWarning != '&nbsp;') {
			$this->existsWarning = '<h3>'.wfMsg('uploadwarning').'</h3>'.$this->existsWarning;
		} else {
			$this->existsWarning = '';
		}
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * This is practicaly a copy of UploadForm->processUpload(SpecialUpload.php), but just handles and returns status message
	 */
	private function uploadMessage($statusCode, $details, $mwUploadForm = null) {
		global $wgLang, $wgFileExtensions, $wgOut, $wgUser, $wgRequest;
		$msg = '';
		switch($statusCode) {
			case UploadForm::SUCCESS:
				break;

			case UploadForm::BEFORE_PROCESSING:
				break;

			case UploadForm::LARGE_FILE_SERVER:
				$msg = wfMsgHtml( 'largefileserver' );
				break;

			case UploadForm::EMPTY_FILE:
				$msg = wfMsgHtml( 'emptyfile' );
				break;

			case UploadForm::MIN_LENGTH_PARTNAME:
				$msg = wfMsgHtml( 'minlength1' );
				break;

			case UploadForm::ILLEGAL_FILENAME:
				$filtered = $details['filtered'];
				$msg = wfMsgWikiHtml( 'illegalfilename', htmlspecialchars( $filtered ) );
				break;

			case UploadForm::PROTECTED_PAGE:
				$msg = $details['permissionserrors'];
				break;

			case UploadForm::OVERWRITE_EXISTING_FILE:
				$msg = $details['overwrite'];
				break;

			case UploadForm::FILETYPE_MISSING:
				$msg = wfMsgExt( 'filetype-missing', array ( 'parseinline' ) );
				break;

			case UploadForm::FILETYPE_BADTYPE:
				$finalExt = $details['finalExt'];
				$msg = wfMsgExt( 'filetype-banned-type',
						array( 'parseinline' ),
						htmlspecialchars( $finalExt ),
						$wgLang->commaList( $wgFileExtensions ),
						$wgLang->formatNum( count($wgFileExtensions) )
					);
				break;

			case UploadForm::VERIFICATION_ERROR:
				$veri = $details['veri'];
				$msg = $veri->toString();
				break;

			case UploadForm::UPLOAD_VERIFICATION_ERROR:
				$msg = $details['error'];
				break;

			case UploadForm::UPLOAD_WARNING:
				$msg = '<h3>'.wfMsg('uploadwarning').'</h3>';
				$msg .= $details['warning'];
				/*
				$tempname = 'Temp_file_'. $wgUser->getID(). '_' . time();
				$file = new FakeLocalFile(Title::newFromText($tempname, 6), RepoGroup::singleton()->getLocalRepo());
				$file->upload($wgRequest->getFileTempName('wpUploadFile'), '', '');
				$msg .= "<div class=\"original\">{$file->getThumbnail(min($file->getWidth(), 250))->toHTML()}</div>";
				*/
				break;

			case UploadForm::INTERNAL_ERROR:
				$msg = $details['internal'];
				break;

			default:
				throw new MWException( __METHOD__ . ": Unknown value `{$value}`" );
	 	}
	 	
	 	return $msg;
	}
	
}