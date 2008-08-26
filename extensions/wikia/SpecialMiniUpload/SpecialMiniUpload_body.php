<?php
if(!defined('MEDIAWIKI')) {
	die();
}
class MiniUpload extends SpecialPage {

	function loadMessages() {
		static $messagesLoaded = false;
		global $wgMessageCache;
		if($messagesLoaded) {
			return;
		}
		$messagesLoaded = true;

		require(dirname(__FILE__).'/SpecialMiniUpload.i18n.php');
		foreach($allMessages as $lang => $langMessages) {
			$wgMessageCache->addMessages($langMessages, $lang);
		}
        return true;
	}

	function MiniUpload() {
		SpecialPage::SpecialPage("MiniUpload");
		self::loadMessages();
	}

	function execute() {
		$licenses = new Licenses(); // Just a weird fix
		global $wgRequest, $wgOut;

		# Set OutputPage object to contain only article body,
		# without skin parts (header&footer)
		$wgOut->setArticleBodyOnly(true);

		# Disable redirects - this is what standard UploadForm do after succesfull
		# upload of file
		$wgOut->enableRedirects(false);

		# Create UploadForm object (standard Special:Upload) and pass to it
		# request object which was sent to this page
		$form = new UploadForm( $wgRequest );
		$form->execute();

		# Get whole output (HTML) from above initializated UploadForm object
		$html = $wgOut->getHTML();

		# Clear HTML output for OutputPage object
		$wgOut->clearHTML();

		if(is_object($form->mLocalFile)) {

			$img = $form->mLocalFile;

			$tmpl2 = new EasyTemplate(dirname( __FILE__ ));
			$tmpl2->set_vars(array(
				'width' => $img->getWidth(),
				'height' => $img->getHeight(),
				'url' => $img->getFullUrl(),
				'name' => $img->getName(),
			));
			$html = $tmpl2->execute('SpecialMiniUpload_success');

		} else {

			# Replace links (especially form action) to call Special:MiniUpload
			# instead of Special:Upload
			$uploadTitleObj = SpecialPage::getTitleFor('Upload');
			$miniUploadTitleObj = SpecialPage::getTitleFor('MiniUpload');
			$html = str_replace($uploadTitleObj->escapeLocalURL(), $miniUploadTitleObj->escapeLocalURL(), $html);
			$html = str_replace($uploadTitleObj->escapeLocalURL('action'), $miniUploadTitleObj->escapeLocalURL('action'), $html);

		}

		$tmpl = new EasyTemplate(dirname( __FILE__ ));
		$tmpl->set_vars(array('body' => $html));
		$wgOut->addHtml($tmpl->execute('SpecialMiniUpload'));

	}
}