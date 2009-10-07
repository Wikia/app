<?php

class WikiaCollection extends SpecialPage {

	private $mTemplate = null;

	public function __construct() {
		// initialise messages
		wfLoadExtensionMessages( 'MagCloud' );

		parent::__construct( 'WikiaCollection' /*class*/, '' /*restriction*/, true );
	}

	public function execute($sSubpage) {
		global $wgUser, $wgOut, $wgRequest, $wgUser;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if(!$wgUser->isAllowed('magcloud')) {
			$this->displayRestrictionError();
			return;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'WikiaCollection' );
		$wgOut->setPageTitle( wfMsg('magcloud-special-collection-title') );

		// template
		$this->mTemplate = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$this->mTemplate->set_vars(array(
			'isAnon' => $wgUser->isAnon(),
			'title' => $this->mTitle,
		));

		// perform action
		$sAction = $wgRequest->getVal('action', null);

		if($sAction == 'getCover') {
			$sHtml = $this->renderCover();
		}
		else if($sAction == 'getBody') {
			$sHtml = $this->renderBody();
		}
		else {
			// check articles count
			$oCollection = MagCloudCollection::getInstance();

			if ($oCollection->countArticles() == 0) {
				$sHtml = wfMsg('magcloud-special-collection-empty');
			}
			else {
				// no action, get current step from url
				switch(strtolower($sSubpage)) {
					case 'design_cover':
						$sHtml = $this->renderDesignCoverForm();
						break;
					case 'preview':
						$sHtml = $this->renderPreview();
						break;
					case 'publish':
						$sHtml = $this->renderPublish();
						break;
					case 'review_list':
					default:
						$sHtml = $this->renderReviewListForm();
				}
			}
		}
		$wgOut->addHTML( $sHtml );
	}

	private function renderReviewListForm() {
		$oCollection = MagCloudCollection::getInstance();

		$this->mTemplate->set('collection', $oCollection);

		// covers in tips box
		global $wgExtensionsPath;
		$this->mTemplate->set('coverExamplesSrc', "{$wgExtensionsPath}/wikia/MagCloud/images/MagCloudTipsCovers.gif");

		return $this->mTemplate->execute('collection-review-list');
	}

	private function renderDesignCoverForm() {

		// init Wikia Mini Upload
		WMUSetup(false);

		// path to layout's preview images
		global $wgExtensionsPath;
		$layoutPreviewImage = "{$wgExtensionsPath}/wikia/MagCloud/images/MagCloudCoverLayout\$1.png";

		$coverData = MagCloudCollection::getInstance()->getCoverData();

		// setup template vars
		$this->mTemplate->set_vars(array(
			'image' => $coverData['image'],
			'layoutPreviewImage' => $layoutPreviewImage,
			'magazineTitle' => $coverData['title'],
			'magazineSubtitle' => $coverData['subtitle'],
			'selectedTheme' => $coverData['theme'],
			'selectedLayout' => $coverData['layout'],
			'themes' => MagCloud::getColorThemes(),
		));

		return $this->mTemplate->execute('collection-design-cover');
	}

	private function renderPreview() {
		global $wgMagCloudPublicApiKey, $wgServer;

		//store collection session into database before rendering pdf
		$collection = MagCloudCollection::getInstance();
		$collection->save();

		$this->mTemplate->set_vars(array(
			'collectionHash' => $collection->getHash(),
			'collectionTimestamp' => $collection->getTimestamp(),

			'publicApiKey' => $wgMagCloudPublicApiKey,
			"server"       =>  preg_replace("/^http:\/\//", "", $wgServer),
		));

		return $this->mTemplate->execute('collection-preview');
	}

	private function renderPublish() {
		$collection = MagCloudCollection::getInstance();

		$this->mTemplate->set_vars(array(
			'collectionHash' => $collection->getHash(),
			'collectionTimestamp' => $collection->getTimestamp(),
		));

		global $wgRequest;
		$token   = $wgRequest->getVal("token",   null);
		$success = $wgRequest->getVal("success", 0);

		// simulate errors
		$breakMe = $wgRequest->getVal('breakme');

		$this->mTemplate->set_vars(array(
			'token' => $token,
			'success' => $success,
			'breakMe' => !empty($breakMe),
		));

		return $this->mTemplate->execute('collection-publish');
	}

	/*
	 * Return HTML of magazine cover
	 *
	 * Paper size is US Letter (215,9 mm x 279,4 mm)
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	private function renderCover() {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgStyleVersion;


		$collection = $this->getCollection();
		$cover = $collection->getCoverData();

		// get color theme
		$themes = MagCloud::getColorThemes();
		$colors = $themes[ $cover['theme'] ];

		//print_pre($cover); print_pre($colors);

		// render cover image
		if ($cover['image'] != '') {
			$thumb = wfFindFile( Title::newFromText($cover['image']) );

			if (empty($thumb)) {
				$image = array();
			}
			else {
				$thumb = $thumb->getThumbnail(400, 450);

				$image = array(
					'html' => $thumb->toHtml(),
					'height' => $thumb->getHeight(),
					'width' => $thumb->getWidth(),
				);
			}
		}
		else {
			$image = array();
		}

		// setup template vars
		$this->mTemplate->set_vars(array(
			'colors' => $colors,
			'css' => "{$wgExtensionsPath}/wikia/MagCloud/css/cover.css?{$wgStyleVersion}",
			'cover' => $cover,
			'image' => $image,
		));

		$body = $this->mTemplate->execute('cover');

		// render cover only
		$wgOut->setArticleBodyOnly(true);
		$wgOut->clearHTML();

		wfProfileOut(__METHOD__);

		return $body;
	}

	private function renderBody() {
		global $wgRequest, $wgOut, $wgExtensionsPath;

		$collection = $this->getCollection();

		$wgOut->addHTML("<div id=\"bolek\">\n");

		$bibliography = array();
		foreach($collection->getArticles() as $articleData) {
			$oTitle = Title::newFromText($articleData['title']);
			$oArticle = Article::newFromID($oTitle->getArticleID());
			$sTitle = $oArticle->getTitle()->getPrefixedText();
			$sUrl   = $oArticle->getTitle()->getFullURL();

			$wgOut->addHTML("<h1 style=\"page-break-before: always\">" . $sTitle . "</h1>");

			$oArticle->doPurge(); // FIXME do it only for page_touched older than date of efBolekTemplate deployment
			$oArticle->view();

			$bibliography[$sTitle] = $sUrl;
		}

		if(sizeOf($bibliography)) {
			$wgOut->addHTML("<h1 style=\"page-break-before: always\">Bibliography</h1>");
			$wgOut->addHTML("<ul>");
			foreach($bibliography as $title => $url) {
				$wgOut->addHTML("<li>" . $title . "<br/><small>" . $url . "</small></li>");
			}
			$wgOut->addHTML("</ul>");
		}

		$currentDate =  wfTimestamp(TS_RFC2822);

		global $wgSitename;
		$currentWiki = htmlspecialchars($wgSitename);

		$username    = "";
		#list($user_id, $user_name) = Bolek::getUser($bolek_id);          // FIXME
		#if ($user_id) $username = " by " . htmlspecialchars($user_name); // FIXME

		$wgOut->addHTML("<p>All articles were compiled {$username} on {$currentDate} from {$currentWiki} - a list of authors is available at the URLs listed above.</p>");

		global $wgRightsText;
		$wgOut->addHTML("<p>This content is available under a {$wgRightsText} license.</p>");

		$add = $wgRequest->getVal("add", 0);
		for ($i = 1; $i <= $add; $i++) {
			$wgOut->addHTML("<p style=\"page-break-before: always\">&nbsp;</p>");
			// $wgOut->addHTML("<p>Debug: empty page added (" . $i . "/" . $add . ").</p>");
		}

		$wgOut->addHTML("<div style=\"page-break-before: always\">");
		$wgOut->addHTML("<img src=\"http://images.wikia.com/central/images/1/1e/Official_wikia_logo.png\" width=\"400\" height=\"101\" style=\"margin: 250px 0 0 125px\" />");
		$wgOut->addHTML("</div>");

		$wgOut->addHTML("</div>\n");

		$wgOut->addHTML("<script type=\"text/javascript\">/*<![CDATA[*/
			var content = $('#bolek');
			$('body').replaceWith(content);
			$('table#toc, span.editsection').remove();
			$('div.bolek-remove').replaceWith('');
			$('div.tleft, div.tright').each(function (e) {
				var img = $(this).find('img.thumbimage');
				var width = img.width();
				var height = img.height();
				var next = $(this).next('p, div.quote, ul');
				if (next.length) {
					next.prepend('<img src=\"http://images.wikia.com/common/trunk/skins/monobook/blank.gif\" width=\"' + width + '\" height=\"' + height + '\" style=\"float: left; margin-right: 10px\" />');
					next.css({'margin-top': -(height + 2) + 'px'});
					$(this).prev('p, div.quote, ul').append('<br clear=\"left\" />');
					$(this).replaceWith(img);
				} else {
					$(this).replaceWith('');
				}
			});
			$('#bolek').css({'font-family': 'Utopia'});
			$('a').css({'color': 'black'});
			/*]]>*/</script>\n");

		return '';
	}

	private function getCollection() {
		global $wgRequest;

		$hash = $wgRequest->getVal('hash', 0);

		$collection = MagCloudCollection::getInstance();
		if(!empty($hash)) {
			$collection->restore($hash);
		}

		return $collection;
	}

}
