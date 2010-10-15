<?php

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = dirname(__FILE__).'/';

$wgAutoloadClasses['WikiaUpload'] = $dir.'WikiaUpload_body.php';
$wgExtensionMessagesFiles['WikiaUpload'] = $dir.'WikiaUpload.i18n.php';
$wgSpecialPages['WikiaUpload'] = 'WikiaUpload';
$wgAjaxExportList[] = 'WikiaUploadAjax';

function WikiaUploadAjax() {

	global $wgRequest, $wgUser;

	$response = array();

	if($wgUser->isLoggedIn()) {
		$actionType = $wgRequest->getVal('actionType');
		if($actionType == 'upload') {
			ob_start();
			$form = new UploadForm( $wgRequest );
			$form->mIgnoreWarning = true;
			$form->mNeverIgnoreDestWarning = true;
			$form->execute();
			ob_end_clean();

			if($form->mUploadStatus === 0) { // SUCCESS
				$file = $form->mLocalFile;
				if($file->exists()) {
					echo $file->getThumbnail(250)->toHtml();
					die();
				}
			} else if($form->mUploadStatus === 12) {
				$file = $form->mLocalFile;
				if($file->exists()) {
					echo 'Old one: <br/>';
					echo $file->getThumbnail(250)->toHtml();
				}

				$fileObj = $_SESSION['wsUploadData'][$form->mSessionKey];

				$file2 = new FakeLocalFile(Title::newFromTexT("Image:cccotoco"), RepoGroup::singleton()->getLocalRepo());
				$file2->upload($fileObj['mTempPath'], '', '');


				echo '<br/>New one: <br/>';
				echo $file2->getThumbnail(190)->toHtml();

				die();
			}
		}
	}

	return new AjaxResponse(Wikia::json_encode($response));
}
