<?php

class SharingToolbarController extends WikiaController {
	private static $assets;
	private static $shareButtons;
	private static $shareNetworks = array(
		'Twitter',
		'Facebook',
		'Mail',
	);

	/**
	 * Check whether sharing toolbar can be shown on the current page
	 *
	 * @return boolean show toolbar?
	 */
	private function canBeShown() {
		// generate list of namespaces toolbar can be shown on
		$allowedNamespaces = $this->app->wg->ContentNamespaces;
		$allowedNamespaces = array_merge($allowedNamespaces, array(
			NS_USER,
			NS_USER_TALK,
			NS_FILE,
			NS_CATEGORY,
		));

		if( defined('NS_VIDEO') ) {
			$allowedNamespaces[] = intval(NS_VIDEO);
		}

		if( defined('NS_BLOG_LISTING') ) {
			$allowedNamespaces[] = intval(NS_BLOG_LISTING);
		}

		if( !empty($this->app->wg->EnableWallExt) ) {
			$allowedNamespaces[] = intval(NS_USER_WALL_MESSAGE);
		}

		if( !empty($this->app->wg->EnableTopListsExt) ) {
			$allowedNamespaces[] = intval(NS_TOPLIST);
		}

		if( !empty($this->app->wg->EnableWikiaQuiz) ) {
			$allowedNamespaces[] = intval(NS_WIKIA_PLAYQUIZ);
		}

		$title = $this->app->wg->Title;
		$namespace = ($title instanceof Title) ? $title->getNamespace() : -1;

		$ret = in_array($namespace, $allowedNamespaces) && !empty($this->app->wg->EnableSharingToolbar);

		return $ret;
	}

	public function getShareButtons() {
		if ( !self::$shareButtons ) {
			$app = F::app();
			$shareButtons = array();

			foreach( self::$shareNetworks as $network ) {
				$shareButton = F::build( 'ShareButton', array( $app, $network ), 'factory' );

				if ( $shareButton instanceof ShareButton ) {
					$shareButtons[] = $shareButton;
				}
			}

			self::$shareButtons = $shareButtons;
		}

		return self::$shareButtons;
	}

	public static function getAssets() {
		if ( !self::$assets ) {
			$assets = array();

			foreach( self::getShareButtons() as $shareButton ) {
				$assets = array_merge( $assets, (array) $shareButton->getAssets() );
			}

			self::$assets = array_unique( $assets );
		}

		return self::$assets;
	}

	public function index() {
		$this->response->setVal( 'shareButtons', self::getShareButtons() );
	}

	// Returning false will prevent the button from being shown
	public function shareButton() {
		return $this->canBeShown();
	}

	public function sendMail() {
		global $wgRequest, $wgTitle, $wgUser, $wgNoReplyAddress;
		wfProfileIn(__METHOD__);
		$user = $wgUser->getId();

		if (empty($user)) {
			$res = array(
					'info-caption' => wfMsg('lightbox-share-email-error-caption'),
					'info-content' => wfMsg('lightbox-share-email-error-login')
			);
			$this->response->setVal('result', $res);
			wfProfileOut(__METHOD__);
			return $res;
		}

		$addresses = $wgRequest->getVal('addresses');
		$countMails = 0;
		if (!empty($addresses) && !$wgUser->isBlockedFromEmailuser() ) {
			$addresses = explode(',', $addresses);
			$countMails = count($addresses);

			$res = array(
				'success' => true,
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
			$linkStd = $currentTitle->getFullURL();

			//send mails
			$sender = new MailAddress($wgNoReplyAddress, 'Wikia');	//TODO: use some standard variable for 'Wikia'?
			$messagesSubjectArray = array(
				wfMsg('lightbox-share-email-subject', array("$1" => $wgUser->getName())),
				wfMsg('oasis-sharing-toolbar-mail-subject', array("$1" => $wgUser->getName()))
			);
			$messagesBodyArray = array(
				wfMsg('lightbox-share-email-body', $linkStd),
				wfMsgExt(
					'oasis-sharing-toolbar-mail-body',
					array('parsemag'),
					array(
						"$1" => $wgUser->getName(),
						"$2" => $linkStd
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
				if (!$result->isOK()) {
					$res = array(
						'info-caption' => wfMsg('lightbox-share-email-error-caption'),
						'info-content' => wfMsgExt('lightbox-share-email-error-content', array('parsemag'), $countMails, $result->toString())
					);
				}
			}
		} else {
			$res = array(
				'info-caption' => wfMsg('lightbox-share-email-error-caption'),
				'info-content' => wfMsgExt('lightbox-share-email-error-content', array('parsemag'), $countMails, wfMsg('lightbox-share-email-error-noaddress'))
			);
		}

		$this->response->setVal('result', $res);
		wfProfileOut(__METHOD__);
		return $res;
	}
}