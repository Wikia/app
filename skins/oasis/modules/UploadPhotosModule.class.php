<?php
/**
 * @author Hyun Lim
 */
 
class UploadPhotosModule extends Module {

	var $wgScriptPath;
	var $licensesHtml;
	var $wgBlankImgUrl;
	
	public function executeIndex() {
		wfProfileIn(__METHOD__);
		
		$licenses = new Licenses(array('id' => 'wpLicense', 'name' => 'wpLicense'));
		$this->licensesHtml = $licenses->getInputHTML(null);
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * This method hacks the normal moduleProxy() chain because of AIM and application/json mimetype incompatibility
	 * Talk to Hyun or Inez
	 */
	public function executeUpload($params) {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgUser;
		
		if(!$wgUser->isLoggedIn()) {
			echo 'Not logged in';
			exit();
		}
		
		$this->comment = $wgRequest->getText('wpUploadDescription');
		$this->watchthis = $wgRequest->getBool('wpWatchthis') && $wgUser->isLoggedIn();
		$this->license = $wgRequest->getText('wpLicense');
		$this->copyrightstatus = $wgRequest->getText('wpUploadCopyStatus');
		$this->copyrightsource = $wgRequest->getText('wpUploadSource');
		$this->ignorewarning = $wgRequest->getCheck('wpIgnoreWarning');
		$this->defaultcaption = $wgRequest->getText('wpDefaultCaption');
		$details = null;
		$up = new UploadFromFile();
		$up->initializeFromRequest($wgRequest);
		$title = $up->getTitle();
		
		$details = $up->verifyUpload();
		
		$this->status = (is_array($details) ? $details['status'] : UploadBase::UPLOAD_VERIFICATION_ERROR);
		$this->statusMessage = '';
		
		if ($this->status > 0) {
			$this->statusMessage = $this->uploadMessage($this->status, $details);
		} else {
			$warnings = array();
			if(!$this->ignorewarning) {
				$warnings = $up->checkWarnings();
				if(!empty($warnings)) {
					$this->status = 12;
					$this->statusMessage .= $this->uploadWarning($warnings);
				}
			}
			if(empty($warnings)) {
				$pageText = SpecialUpload::getInitialPageText( $this->comment, $this->license,
					$this->copyrightstatus, $this->copyrightsource );
				$status = $up->performUpload( $this->comment, $pageText, $this->watchthis, $wgUser );
				if ($status->isGood()) {
					$aPageProps = array ( 'default_caption' => $this->defaultcaption );
					Wikia::setProps( $title->getArticleID(), $aPageProps );
				} else {
					$this->statusMessage .= "something is wrong with upload";
				}
			}
		}
	
		echo json_encode($this->getData());
		header('content-type: text/plain; charset=utf-8');
	
		wfProfileOut(__METHOD__);
		
		exit();	//end hack
	}
	
	public function executeExistsWarning($params) {
		wfProfileIn(__METHOD__);
		global $wgRequest;
		
		$this->existsWarning = SpecialUpload::ajaxGetExistsWarning($wgRequest->getVal('wpDestFile'));
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
	private function uploadMessage($statusCode, $details) {
		global $wgLang, $wgFileExtensions, $wgOut, $wgUser, $wgRequest;
		$msg = '';
		switch($statusCode) {
			case UploadBase::SUCCESS:
				break;
				
			case UploadBase::EMPTY_FILE:
				$msg = wfMsgHtml( 'emptyfile' );
				break;

			case UploadBase::MIN_LENGTH_PARTNAME:
				$msg = wfMsgHtml( 'minlength1' );
				break;

			case UploadBase::ILLEGAL_FILENAME:
				$filtered = $details['filtered'];
				$msg = wfMsgWikiHtml( 'illegalfilename', htmlspecialchars( $filtered ) );
				break;

			case UploadBase::OVERWRITE_EXISTING_FILE:
				$msg = $details['overwrite'];
				break;

			case UploadBase::FILETYPE_MISSING:
				$msg = wfMsgExt( 'filetype-missing', array ( 'parseinline' ) );
				break;

			case UploadBase::FILETYPE_BADTYPE:
				$finalExt = $details['finalExt'];
				$msg = wfMsgExt( 'filetype-banned-type',
						array( 'parseinline' ),
						htmlspecialchars( $finalExt ),
						$wgLang->commaList( $wgFileExtensions ),
						$wgLang->formatNum( count($wgFileExtensions) )
					);
				break;

			case UploadBase::VERIFICATION_ERROR:
				$msg = wfMsgHtml($details['details'][0]);
				break;

			default:
				throw new MWException( __METHOD__ . ": Unknown value `{$value}`" );
	 	}
	 	
	 	return $msg;
	}
	
	private function uploadWarning($warnings) {
		$msg = '<h2>'.wfMsgHtml('uploadwarning').'</h2><ul class="warning">';
		
		foreach($warnings as $warning => $args) {
			if( $warning == 'exists' ) {
				$msg .= "\t<li>" . SpecialUpload::getExistsWarning( $args ) . "</li>\n";
			} elseif( $warning == 'duplicate' ) {
				$msg .= SpecialUpload::getDupeWarning( $args );
			} elseif( $warning == 'duplicate-archive' ) {
				$msg .= "\t<li>" . wfMsgExt( 'file-deleted-duplicate', 'parseinline',
						array( Title::makeTitle( NS_FILE, $args )->getPrefixedText() ) )
					. "</li>\n";
			} else {
				if ( $args === true )
					$args = array();
				elseif ( !is_array( $args ) )
					$args = array( $args );
				$msg .= "\t<li>" . wfMsgExt( $warning, 'parseinline', $args ) . "</li>\n";
			}
		}
		
		$msg .= '</ul>';
		return $msg;
	}

}
