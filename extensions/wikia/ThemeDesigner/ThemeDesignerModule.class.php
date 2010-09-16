<?php
class ThemeDesignerModule extends Module {

	var $wgCdnRootUrl;
	var $wgBlankImgUrl;
	var $wgExtensionsPath;
	var $wgScript;
	var $wgServer;
	var $wgStylePath;
	var $wgOut;
	var $wgScriptPath;
	var $wgOasisThemes;

	var $dir;
	var $mimetype;
	var $charset;

	var $themeSettings;
	var $themeHistory;
	var $returnTo;

	public function executeIndex() {
		wfProfileIn( __METHOD__ );
		global $wgLang;

		$themeSettings = new ThemeSettings();

		// current settings
		$this->themeSettings = $themeSettings->getSettings();

		// recent versions
		$this->themeHistory = array_reverse($themeSettings->getHistory());

		// format time (for edits older than 30 days - show timestamp)
		foreach($this->themeHistory as &$entry) {
			$diff = time() - strtotime( $entry['timestamp'] );

			if($diff < 30 * 86400) {
				$entry['timeago'] = wfTimeFormatAgo($entry['timestamp']);
			} else {
				$entry['timeago'] = $wgLang->date($entry['timestamp']);
			}
		}

		// URL user should be redirected to when settings are saved
		if(isset($_SERVER['HTTP_REFERER'])) {
			$this->returnTo = $_SERVER['HTTP_REFERER'];
		} else {
			$this->returnTo = $this->wgScript;
		}

		wfProfileOut( __METHOD__ );
	}

	public function executeThemeTab() {

	}

	public function executeCustomizeTab() {

	}

	public function executeWordmarkTab() {

	}

	public function executePicker() {

	}

	public function executePreview() {

	}

	var $wordmarkImageUrl;
	var $wordmarkImageName;
	var $errors;

	public function executeWordmarkUpload() {
		global $wgRequest;

		$filename = $wgRequest->getFileName('wpUploadFile');

		// check if there is a file send
		if($filename) {

			// check if it's a PNG file (just by extension)
			if(strtolower(end(explode(".", $filename))) == 'png') {

				// check if file is in correct size
				$imageSize = getimagesize($_FILES['wpUploadFile']['tmp_name']);
				if($imageSize[0] == 250 && $imageSize[1] == 65) {

					$file = new FakeLocalFile(Title::newFromText('Temp_file_'.time(), 6), RepoGroup::singleton()->getLocalRepo());
					$file->upload($wgRequest->getFileTempName('wpUploadFile'), '', '');
					$this->wordmarkImageUrl = $file->getUrl();
					$this->wordmarkImageName = $file->getName();

				}

			}

		}

		// if wordmark url is not set then it means there was some problem
		if(empty($this->wordmarkImageUrl) || empty($this->wordmarkImageName)) {
			$this->errors = array('Incorrect file type or file dimension.');
		}

	}

	public function executeBackgroundImageUpload() {
		global $wgRequest;

		$filename = $wgRequest->getFileName('wpUploadFile');

		// check if there is a file send
		if($filename) {

			// check file type (just by extension)
			$filetype = strtolower(end(explode(".", $filename)));
			if($filetype == 'png' || $filetype == 'jpg' || $filetype == 'gif') {

				// check if file is correct file size
				$imageFileSize = filesize($_FILES['wpUploadFile']['tmp_name']);
				if ($imageFileSize < 102400) {

					// center image if wider than 1050, otherwise left align
					$imageSize = getimagesize($_FILES['wpUploadFile']['tmp_name']);
					if($imageSize[0] > 1050) {
						$this->backgroundImageAlign = "center";
					} else {
						$this->backgroundImageAlign = "left";
					}

					//save temp file				
					$file = new FakeLocalFile(Title::newFromText('Temp_file_'.time(), 6), RepoGroup::singleton()->getLocalRepo());
					$file->upload($wgRequest->getFileTempName('wpUploadFile'), '', '');
					$this->backgroundImageUrl = $file->getUrl();
					$this->backgroundImageName = $file->getName();
	
				}

			}
				
		}

		// if background image url is not set then it means there was some problem
		if(empty($this->backgroundImageUrl)) {
			$this->errors = array('Incorrect file type or file size.');
		}

	}

	public function executeSaveSettings() {
		global $wgRequest;

		wfProfileIn( __METHOD__ );

		$data = $wgRequest->getArray( 'settings' );

		$themeSettings = new ThemeSettings();
		$themeSettings->saveSettings($data);

		wfProfileOut( __METHOD__ );
	}

}
