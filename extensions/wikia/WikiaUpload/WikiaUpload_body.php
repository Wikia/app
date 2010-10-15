<?php
class WikiaUpload extends SpecialPage {

	function WikiaUpload() {
		SpecialPage::SpecialPage("WikiaUpload");
		wfLoadExtensionMessages('WikiaUpload');
	}

	function execute( $par ) {
		global $wgRequest, $wgOut;
		$wgOut->enableRedirects(false);
		$this->setHeaders();

		$url = $wgRequest->getText('url');

		if(!empty($url)) {
			global $wgTmpDirectory;
			$local_file = tempnam( $wgTmpDirectory, 'WEBUPLOAD' );
			$uf = new UploadForm();
			$r = $uf->curlCopy($url, $local_file);

			print_pre($r);
			edit();


		}



		$data = array();
		$data['wpUpload'] = '1';
		$data['wpUploadFileURL'] = 'http://www.google.pl/intl/en_com/images/logo_plain.png';
		$data['wpSourceType'] = 'web';
		$data['wpDestFile'] = 'haha.png';


		$fauxRequest = new FauxRequest($data, true /* was posted */);

		ob_start();
		$form = new UploadForm( $fauxRequest );
		$form->mIgnoreWarning = true;
		$form->mNeverIgnoreDestWarning = true;
		$form->execute();
		ob_end_clean();

		$file = $form->mLocalFile;
		if($file->exists()) {
			echo $file->getThumbnail(250)->toHtml();
		}

		if(isset($form->mSessionKey) && !empty($form->mSessionKey)) {
			$fileObj = $_SESSION['wsUploadData'][$form->mSessionKey];
			$file2 = new FakeLocalFile(Title::newFromTexT("Image:cccotoco"), RepoGroup::singleton()->getLocalRepo());
			$file2->upload($fileObj['mTempPath'], '', '');
			echo $file2->getThumbnail(250)->toHtml();
		}
		die();


		return;

		$wgOut->addHTML( <<<EOT
<form id='upload' method='post' enctype='multipart/form-data'>
	<input type='file' name='wpUploadFile' id='wpUploadFile' />
	<input type='hidden' name='wpUpload' value='1' />
	<input type='button' id='wpUpload' value='Upload' />
</form>
<br />
<div id='uploadLog'></div>
EOT
		);

		$wgOut->addHTML( <<<EOT
<script type="text/javascript">
YAHOO.util.Event.addListener('wpUpload', 'click', WikiaUpload);
function WikiaUpload(e) {
	YAHOO.util.Connect.setForm('upload', true);
	var callback = {
		upload: function(o) {
			//res = YAHOO.Tools.JSONParse(o.responseText);
			//YAHOO.util.Dom.get('uploadLog').innerHTML = res.res;
			YAHOO.util.Dom.get('uploadLog').innerHTML = o.responseText;
		}
	}
	var cObj = YAHOO.util.Connect.asyncRequest('POST', wgScriptPath + '/index.php?action=ajax&rs=WikiaUploadAjax&actionType=upload', callback);
	YAHOO.util.Dom.get('uploadLog').innerHTML = "Uploading...";
}

</script>
EOT
		);




/*
		} else {
			global $wgMaxUploadSize;
			$wgMaxUploadSize = 99999999;
			$form = new UploadForm( $wgRequest );
			$form->execute();

			$wgOut->clearHTML();

			print_pre($form);
			print_pre($_SESSION);

			$wgOut->addHTML("SUCCESS!");
		}
*/

	}
}
