<?php

class SharingToolbarModule extends Module {

	var $shareButtons;

	/**
	 * Check whether sharing toolbar can be shown on the current page
	 *
	 * @return boolean show toolbar?
	 */
	private function canBeShown() {
		// generate list of namespaces toolbar can be shown on
		$allowedNamespaces = $this->app->wg->ContentNamespaces;
		$allowedNamespaces[] = NS_FILE;
		if (defined('NS_VIDEO')) {
			$allowedNamespaces[] = intval(NS_VIDEO);
		}

		$title = $this->app->wg->Title;
		$namespace = ($title instanceof Title) ? $title->getNamespace() : -1;

		$ret = in_array($namespace, $allowedNamespaces) && !empty($this->app->wg->EnableSharingToolbar);

		return $ret;
	}

	public function executeIndex() {
		if (!$this->canBeShown()) {
			// don't render the toolbar
			return false;
		}

		$shareNetworks = array(
			'Twitter',
			'Facebook',
		);

		$this->shareButtons = array();

		foreach($shareNetworks as $network) {
			$instance = F::build('ShareButton', array($this->app, $network), 'factory');

			if ($instance instanceof ShareButton) {
				$this->shareButtons[] = $instance;
			}
		}
	}

	public function executeSendMail() {
		global $wgRequest, $wgTitle, $wgNoReplyAddress, $wgUser, $wgNoReplyAddress;
		wfProfileIn(__METHOD__);
		$user = $wgUser->getId();
		
		if (empty($user)) {
			$res = array(
					'result' => 0,
					'info-caption' => wfMsg('lightbox-share-email-error-caption'),
					'info-content' => wfMsg('lightbox-share-email-error-login')
			);
			wfProfileOut(__METHOD__);
			return $res;
		}
		
		$addresses = $wgRequest->getVal('addresses');
		$countMails = 0;
		if (!empty($addresses) && !$wgUser->isBlockedFromEmailuser() ) {
			$addresses = explode(',', $addresses);
			$countMails = count($addresses);

			$res = array(
				'result' => 1,
				'info-caption' => wfMsg('lightbox-share-email-ok-caption'),
				'info-content' => wfMsgExt('lightbox-share-email-ok-content', array('parsemag'), $countMails)
			);

			//generate shared link
			$pageName = $wgRequest->getVal('pageName');
			$currentTitle = Title::newFromText($pageName);
			if (empty($currentTitle)) {
				//should not happen, ever
				throw new MWException("Could not create Title from $pageName\n");
			}
			$imageTitle = $wgTitle->getText();
			$imageParam = preg_replace('/[^a-z0-9_]/i', '-', Sanitizer::escapeId($imageTitle));
			$linkStd = $currentTitle->getFullURL();

			//send mails
			$sender = new MailAddress($wgNoReplyAddress, 'Wikia');	//TODO: use some standard variable for 'Wikia'?
			$messagesSubjectArray = array(
				wfMsg('lightbox-share-email-subject', array("$1" => $wgUser->getName())),
				wfMsg('oasis-sharing-toolbar-mail-subject', array("$1" => $wgUser->getName()))
			);
			$messagesBodyArray = array(
				wfMsg('lightbox-share-email-body', $linkStd),
				wfMsg(
					'oasis-sharing-toolbar-mail-body',
					array(
						"$1" => $wgUser->getName(),
						"$2" => $linkStd,
						"$3" => $linkStd
					)
				)
			);
			foreach ($addresses as $address) {
				$to = new MailAddress($address);

				//TODO: support sendHTML
				$result = UserMailer::send(
					$to,
					$sender,
					$messagesSubjectArray[$wgRequest->getVal('messageId')],
					$messagesBodyArray[$wgRequest->getVal('messageId')],
					null,
					null,
					'ImageLightboxShare'
				);
				if (WikiError::isError($result)) {
					$res = array(
						'result' => 0,
						'info-caption' => wfMsg('lightbox-share-email-error-caption'),
						'info-content' => wfMsgExt('lightbox-share-email-error-content', array('parsemag'), $countMails, $result->toString())
					);
				}
			}
		} else {
			$res = array(
				'result' => 0,
				'info-caption' => wfMsg('lightbox-share-email-error-caption'),
				'info-content' => wfMsgExt('lightbox-share-email-error-content', array('parsemag'), $countMails, wfMsg('lightbox-share-email-error-noaddress'))
			);
		}

		$this->response->setVal('result', $res);
		wfProfileOut(__METHOD__);
		return $res;
	}
}