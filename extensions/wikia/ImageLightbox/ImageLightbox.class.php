<?php

class ImageLightbox {
	const MIN_HEIGHT = 300;
	const MIN_WIDTH = 300;

	/**
	 * Add global JS variable indicating this extension is enabled (RT #47665)
	 */
	static public function addJSVariable(Array &$vars) {
		$vars['wgEnableImageLightboxExt'] = true;
		return true;
	}

	/**
	 * Handle AJAX request and return bigger version of requested image
	 */
	static public function ajax() {
		global $wgTitle, $wgBlankImgUrl, $wgRequest, $wgServer, $wgStylePath, $wgExtensionsPath, $wgSitename;
		wfProfileIn(__METHOD__);

		// limit dimensions of returned image to fit browser's viewport
		$maxWidth = $wgRequest->getInt('maxwidth', 500) - 20;
		$maxHeight = $wgRequest->getInt('maxheight', 300) - 150;
		$showShareTools = $wgRequest->getInt('share', 0);
		$pageName = $wgRequest->getVal('pageName');


		$image = wfFindFile($wgTitle);

		if (empty($image)) {
			wfProfileOut(__METHOD__);
			return array();
		}

		if ( WikiaFileHelper::isFileTypeVideo( $image ) ) {
			if ( !empty($wgTitle) ) {
				wfProfileOut(__METHOD__);
				return self::videoLightbox($image);
			}
		}

		// get original dimensions of an image
		$width = $image->getWidth();
		$height = $image->getHeight();

		// don't try to make image larger
		if ($width > $maxWidth or $height > $maxHeight) {
			$width = $maxWidth;
			$height = $maxHeight;
		}

		// generate thumbnail
		$thumb = $image->transform( array( 'width' => $width, 'height' => $height ) );

		$thumbHeight = $thumb->getHeight();
		$thumbWidth = $thumb->getWidth();

		// lightbox should not be smaller then 200x200
		$wrapperHeight = max($thumbHeight, self::MIN_HEIGHT);
		$wrapperWidth = max($thumbWidth, self::MIN_WIDTH);

		//generate share links
		$currentTitle = Title::newFromText($pageName);
		if (empty($currentTitle)) {
			//should not happen, ever
			throw new MWException("Could not create Title from $pageName\n");
		}

		$thumbUrl = $thumb->getUrl();
		$imageTitle = $wgTitle->getText();
		$imageParam = preg_replace('/[^a-z0-9_]/i', '-', Sanitizer::escapeId($imageTitle));
		$linkStd = $currentTitle->getFullURL("image=$imageParam");
		$linkMail = $currentTitle->getFullURL("image=$imageParam&open=email");
		$linkWWW = "<a href=\"$linkStd\"><img width=\"" . $thumb->getWidth() . "\" height=\"" . $thumb->getHeight() . "\" src=\"$thumbUrl\"/></a>";
		$linkBBcode = "[url=$linkStd][img]{$thumbUrl}[/img][/url]";

		$linkStdEncoded = rawurlencode($linkStd);
		$linkDescription = wfMsg('lightbox-share-description', $currentTitle->getText(), $wgSitename);
		$shareButtons = array();
		$shareNetworks = SocialSharingService::getInstance()->getNetworks( array(
			'facebook',
			'twitter',
			'stumbleupon',
			'reddit'
		) );

		foreach ( $shareNetworks as $n) {
			$type = $n->getId();
			$shareButtons[] = array(
				'class' => 'share-' . $type,
				'text' => ucfirst( $type ),
				'type' => $type,
				'url' => $n->getUrl( $linkStdEncoded , $linkDescription )
			);
		}

		// FB like - generate URL and check lightness of skin theme
		$likeHref = $linkStd;
		$likeTheme = SassUtil::isThemeDark() ? 'dark' : 'light';

		// render HTML

		$tmpl = new EasyTemplate(dirname(__FILE__));
		$tmpl->set_vars(array(
			'href' => $wgTitle->getLocalUrl(),
			'likeHref' => $likeHref,
			'likeTheme' => $likeTheme,
			'linkBBcode' => $linkBBcode,
			'linkStd' => $linkStd,
			'linkWWW' => $linkWWW,
			'name' => $imageTitle,
			'shareButtons' => $shareButtons,
			'showShareTools' => $showShareTools,
			'stylePath' => $wgStylePath,
			'thumbHeight' => $thumbHeight,
			'thumbUrl' => $thumbUrl,
			'thumbWidth' => $thumbWidth,
			'wgBlankImgUrl' => $wgBlankImgUrl,
			'wgExtensionsPath' => $wgExtensionsPath,
			'wrapperHeight' => $wrapperHeight,
			'wrapperWidth' => $wrapperWidth,
			'linkMail' => $linkMail,
		));

		$html = $tmpl->render('ImageLightbox');

		$res = array(
			'html' => $html,
			'title' => $wgTitle->getText(),
			'titleKey' => $wgTitle->getDBKey(),
			'type' => 'image',
			'provider' => null,
			'width' => $wrapperWidth,
		);

		wfProfileOut(__METHOD__);
		return $res;
	}


	function videoLightbox($img) {

		global $wgTitle, $wgRequest, $wgExtensionsPath, $wgBlankImgUrl;

		if ( !empty($wgTitle) ) {
			wfProfileIn(__METHOD__);

			$revisionTimestamp = $wgRequest->getInt('t', 0);

			if ( $revisionTimestamp > 0 ) { // support for old video revision

				$image = wfFindFile( $wgTitle, $revisionTimestamp );
				if ( !($image instanceof LocalFile && $image->exists()) ) {
					wfProfileOut( __METHOD__ );
					return array();
				}
			} else {
				$image = $img;
			}

			$maxWidth = $wgRequest->getInt('maxwidth', 500);

			$embedCode = $image->getEmbedCode( $maxWidth, true, true );

			$tmpl = new EasyTemplate(dirname(__FILE__));

			// Make it possible to assign a subheader with link.
			if($wgRequest->getVal('wikiAddress') && $wgRequest->getVal('wikiAddress') != 'false') {
				$subHeaderText = wfMsg('lightbox-visit-the-wiki');
				$subHeaderLinkAnchor = $wgRequest->getVal('wikiAddress');
				$parsedUrl = parse_url($subHeaderLinkAnchor);
				$subHeaderLinkText = (!empty($parsedUrl['host']))?($parsedUrl['host']):$subHeaderLinkAnchor;
			} else {
				$subHeaderText = null;
				$subHeaderLinkText = null;
				$subHeaderLinkAnchor = null;
			}

			$tmpl->set_vars(array(
				'showShareTools' => $wgRequest->getInt('share', 0),
				'linkStd' => $wgTitle->getFullURL(),
				'wgExtensionsPath' => $wgExtensionsPath,
				'wgBlankImgUrl' => $wgBlankImgUrl,
				'subHeaderText' => $subHeaderText,
				'subHeaderLinkText' => $subHeaderLinkText,
				'subHeaderLinkAnchor' => $subHeaderLinkAnchor,
				'showEmbedCodeInstantly' => $wgRequest->getVal('showEmbedCodeInstantly')
			));

			$htmlUnderPlayer = $tmpl->render('VideoLightbox');

			$res = array(
				'html' => $htmlUnderPlayer,
				'embedCode' => $embedCode,
				'title' => $wgTitle->getText(),
				'titleKey' => $wgTitle->getDBKey(),
				'type' => 'video',
				'provider' => $image->getProviderName(),
				'width' => $maxWidth,
			);

			wfProfileOut(__METHOD__);
			return $res;
		}
	}


	/**
 	 * AJAX function for sending share e-mails
	 *
	 * @author Marooned
	 */
	static function sendMail() {
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
			$linkStd = $currentTitle->getFullURL("image=$imageParam");

			//send mails
			$sender = new MailAddress($wgNoReplyAddress, 'Wikia');	//TODO: use some standard variable for 'Wikia'?
			foreach ($addresses as $address) {
				$to = new MailAddress($address);

				//TODO: support sendHTML
				$result = UserMailer::send(
					$to,
					$sender,
					wfMsg('lightbox-share-email-subject', array("$1" => $wgUser->getName())),
					wfMsg('lightbox-share-email-body', $linkStd),
					null,
					null,
					'ImageLightboxShare'
				);
				if (!$result->isOK()) {
					$res = array(
						'result' => 0,
						'info-caption' => wfMsg('lightbox-share-email-error-caption'),
						'info-content' => wfMsgExt('lightbox-share-email-error-content', array('parsemag'), $countMails, $result->toString())
					);
				}
			}
		} else {
			$countMails = 0;

			$res = array(
				'result' => 0,
				'info-caption' => wfMsg('lightbox-share-email-error-caption'),
				'info-content' => wfMsgExt('lightbox-share-email-error-content', array('parsemag'), $countMails, wfMsg('lightbox-share-email-error-noaddress'))
			);
		}

		wfProfileOut(__METHOD__);
		return $res;
	}
}
