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

	var $dir;
	var $mimetype;
	var $charset;

	var $themeSettings;
	var $themeHistory;
	var $returnTo;

	public function executeIndex() {
		wfProfileIn( __METHOD__ );
		global $wgLang;

		$settings = new ThemeSettings();

		// current settings
		$this->themeSettings = $settings->getAll();

		// recent versions
		$this->themeHistory = $settings->getHistory();

		// format time (for edits older than 30 days - show timestamp)
		foreach ( $this->themeHistory as &$entry ) {
			$diff = time() - strtotime( $entry['timestamp'] );

			if ( $diff < 30 * 86400 ) {
				$entry['timeago'] = wfTimeFormatAgo( $entry['timestamp'] );
			}
			else {
				$entry['timeago'] = $wgLang->date( $entry['timestamp'] );
			}
		}

		// URL user should be redirected to when settings are saved
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$this->returnTo = $_SERVER['HTTP_REFERER'];
		}
		else {
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

	public function executeWordmarkUpload() {
		global $wgRequest;

		// check if there is a file send
		if($wgRequest->getFileName('wpUploadFile')) {

			// check if file is in correct size
			$imageSize = getimagesize($_FILES['wpUploadFile']['tmp_name']);
			if($imageSize[0] == 300 && $imageSize[1] == 60) {
				$file = new FakeLocalFile(Title::newFromText('Temp_file_'.time(), 6), RepoGroup::singleton()->getLocalRepo());
				$file->upload($wgRequest->getFileTempName('wpUploadFile'), '', '');


print_pre($file->getURL());


			}

		}

		exit();


	}

}
