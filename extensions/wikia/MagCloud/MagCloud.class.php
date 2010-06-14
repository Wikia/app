<?php

class MagCloud {

	static public function addVar($vars) {
		$vars['wgEnableMagCloudExt'] = true;
		return true;
	}

	/*
	 * Read current toolbar state and inject it into HTML of the page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function injectToolbar($tpl, &$html) {
		wfProfileIn(__METHOD__);

		// detect current state
		$toolbarIsVisible = MagCloudCollection::getInstance()->getToolbarVisibleState();

		if ($toolbarIsVisible) {
			wfLoadExtensionMessages('MagCloud');
			$html .= self::renderToolbar();
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/*
	 * Add global JS variables for MagCloud
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function makeGlobalVariablesScript($vars) {
		wfProfileIn(__METHOD__);

		$magCloud = MagCloudCollection::getInstance();

		// is toolbar visible?
		if ($magCloud->getToolbarVisibleState()) {
			$vars['wgMagCloudToolbarVisible'] = true;
			$vars['wgMagCloudArticlesCount'] = count($magCloud->getArticles() );
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/*
	 * Check whether current page is Special:WikiaCollection
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function isOnSpecialPageCollection() {
		wfProfileIn(__METHOD__);

		global $wgTitle;
		$ret = ($wgTitle->getNamespace() == NS_SPECIAL) && ($wgTitle->getDBkey() == 'WikiaCollection');

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/*
	 * Add CSS/JS for MagCloud toolbar and special page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function beforePageDisplay(&$out, &$sk) {

		wfProfileIn(__METHOD__);

		global $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;

		// detect current state of toolbar
		$isToolbarVisible = MagCloudCollection::getInstance()->getToolbarVisibleState();

		// load CSS/JS for toolbar (always load this for special page)
		if ( $isToolbarVisible || self::isOnSpecialPageCollection() ) {
			$out->addExtensionStyle("{$wgExtensionsPath}/wikia/MagCloud/css/MagCloud.css?{$wgStyleVersion}");
			$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/MagCloud/js/MagCloud.js?{$wgStyleVersion}\"></script>\n");
		}

		// load CSS/JS for special page
		if (self::isOnSpecialPageCollection()) {
			$out->addExtensionStyle("{$wgExtensionsPath}/wikia/MagCloud/css/SpecialMagCloud.css?{$wgStyleVersion}");
			$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"/extensions/wikia/MagCloud/js/SpecialMagCloud.js?{$wgStyleVersion}." . mt_rand() . "\"></script>\n");

			// load jQuery UI plugin for anons
			global $wgUser;
			if ($wgUser->isAnon()) {
				$out->addScriptFile('jquery/jquery-ui-1.7.1.custom.js');
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/*
	 * Return HTML of MagCloud toolbar for given page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function renderToolbar() {

		wfProfileIn(__METHOD__);

		global $wgTitle, $wgRequest;

		$collection = MagCloudCollection::getInstance();

		// init template
		$template = new EasyTemplate(dirname(__FILE__) . '/templates');

		if (self::isOnSpecialPageCollection()) {
			$titleParts = explode('/', $wgRequest->getVal('title'));
			$stepName = isset($titleParts[1]) ? strtolower($titleParts[1]) : null;

			// Special:Collection: show process steps
			$steps = array(
				'Review list',
				'Design Cover',
				'Preview',
				'Publish',
			);

			switch($stepName) {
				default:
				case 'review_list':
					$currentStep = 1;
					break;
				case 'design_cover':
					$currentStep = 2;
					break;
				case 'preview':
					$currentStep = 3;
					break;
				case 'publish':
					$currentStep = 4;
					break;
			}

			$template->set_vars(array(
				'currentStep' => $currentStep,
				'steps' => $steps,
			));
		}
		else {
			// check if we're on existing content page
			$isContentPage = $wgTitle->isContentPage() && $wgTitle->exists();

			// check action (only render allow article to be added from view and purge)
			$action = $wgRequest->getVal('action', 'view');

			if (!in_array($action, array('view', 'purge', 'ajax'))) {
				$isContentPage = false;
			}

			if ($isContentPage) {
				// on content pages: show add "foo" to your magazine

				// check whether current article is in collection
				$isInCollection = $collection->findArticle($wgTitle->getPrefixedText()) != -1;

				$template->set_vars(array(
					'count' => $collection->countArticles(),
					'isInCollection' => $isInCollection,
					'title' => self::getAbbreviatedTitle($wgTitle),
					'magazineUrl' => Skin::makeSpecialUrl('WikiaCollection'),
				));
			}
			else {
				// on non-content pages: show some message
				$template->set_vars(array(
					'count' => $collection->countArticles(),
					'message' => 'This type of page can\'t be added. Try heading to a content page!',
					'magazineUrl' => Skin::makeSpecialUrl('WikiaCollection'),
				));
			}
		}

		// render toolbar
		$html = $template->render('toolbar');

		wfProfileOut(__METHOD__);

		return $html;
	}

	/*
 	 * Returns abbreviated version of title provided
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function getAbbreviatedTitle($title) {
		if ($title instanceof Title) {
			$pageName = $title->getPrefixedText();
		}
		else {
			$pageName = $title;
		}

		if (mb_strlen($pageName) > 25) {
			// Shahid says: the article name displayed should be abbreviated using <first x characters> ... <last x characters>
			$pageName = mb_substr($pageName, 0, 12) . '...' . mb_substr($pageName, -12);
		}

		return $pageName;
	}

	/*
	 * Try to start session for anon to bypass Varnish
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function startAnonSession() {
		global $wgUser, $wgSessionStarted;

		if ($wgUser->isAnon()) {
			if (empty($wgSessionStarted)) {
				wfDebug("MagCloud: starting session for anon...\n");

				// start session
				wfSetupSession();
				$wgSessionStarted = true;
			}
			else {
				wfDebug("MagCloud: anon has session\n");
			}
		}
	}

	/*
	 * Render PNG file with preview of given page of given PDF file
	 */
	static public function renderPreviewPage($hash, $timestamp, $pageNo) {
		global $wgCityId, $wgRequest, $wgMagCloudUploadDirectory, $wgMagCloudUploadPath;
		wfProfileIn(__METHOD__);

		if(empty($hash) || empty($timestamp) || empty($pageNo)) {
			wfProfileOut(__METHOD__);
			return array( 'msg' => 'Not enough data', 'error' => true );
		}

		// generate PDF name
		$pdfFileName = "{$wgCityId}-{$hash}-{$timestamp}.pdf";
		$pdfPath = "{$wgMagCloudUploadDirectory}/pdf/{$pdfFileName}";
		if(!file_exists($pdfPath)) {
			wfProfileOut(__METHOD__);
			return array( 'msg' => 'PDF file not found', 'error' => true );
		}

		// genrate local path to image file
		$imageFileName = sha1("{$wgCityId}-{$hash}-{$timestamp}-{$pageNo}") . '.png';
		$imagePath = "{$wgMagCloudUploadDirectory}/preview/{$imageFileName}";

		if(!file_exists($imagePath)) {
			$cmd = "/usr/local/bin/gs -sDEVICE=png16m -dNOPAUSE -dBATCH -dSAFER -dFirstPage={$pageNo} -dLastPage={$pageNo} -sOutputFile={$imagePath} -r35 {$pdfPath}";

			$result = null;
			wfShellExec($cmd, $result);

			if($result) {
				wfProfileOut(__METHOD__);
				return array( 'msg' => 'Page rendering error. (Info from gs)', 'result' => $result, 'cmd' => $cmd, 'error' => true );
			}
		}

		// generate URL to pdf
		$imageUrl = "{$wgMagCloudUploadPath}/preview/{$imageFileName}";

		wfDebug("renderPdf: image ready (URL: {$imageUrl})\n");

		wfProfileOut(__METHOD__);
		return array(
			'msg' => 'Rendering done',
			'img' => $imageUrl,
			'page' => $pageNo
		);
	}

	/*
	 * Render PDF file from given collection
	 */
	static public function renderPdf($hash, $timestamp) {
		wfProfileIn(__METHOD__);

		if(empty($timestamp) ||empty($hash)) {
			wfProfileOut(__METHOD__);
			return array( 'msg' => 'Not enough data.' );
		}

		// URL of Special:WikiaCollection
		$url =  Title::newFromText('WikiaCollection', NS_SPECIAL)->getFullUrl();

		// generate PDF name
		global $wgCityId;
		$fname = "{$wgCityId}-{$hash}-{$timestamp}.pdf";

		// genrate local path to PDF file
		global $wgMagCloudUploadDirectory;
		$pdf = "{$wgMagCloudUploadDirectory}/pdf/{$fname}";

		wfDebug("renderPdf: rendering {$fname} -> {$pdf}\n");

		if(!file_exists($pdf)) {
			$add = 0;
			$iteration = 3; // prevent infinite loop
			global $wgSitename;
			do {
				$cmd = Wikia::binWkhtmltopdf() . " --page-size Letter --header-line --header-center \"{$wgSitename}, from Wikia\" --footer-line --footer-center \"- [page] -\" --margin-bottom 20mm --margin-left 20mm --margin-right 20mm --margin-top 20mm --cover \"{$url}?action=getCover&hash={$hash}\" \"{$url}?action=getBody&add={$add}&hash={$hash}\" {$pdf}";
				//$cmd = "/users/ADi/wkhtmltopdf --page-size Letter --footer-left \"{$debug}\" --cover \"{$url}?action=getCover&hash={$hash}\" \"{$url}?action=getBody&add={$add}&hash={$hash}\" {$wgUploadDirectory}/lolek/{$fname}";
				//echo $cmd;

				$result = null;
				wfShellExec($cmd, $result);

				if($result) {
					wfDebug("renderPdf: rendering error (#{$result})\n");
					return array( 'msg' => "Pdf rendering error. (Info from wkhtmltopdf.)", 'result' => $result );
				}

				$cmd = "/usr/bin/pdfinfo {$pdf}";
				$output = wfShellExec($cmd, $result);

				if($result || !preg_match("/Pages: *([0-9]+)\n/", $output, $matches)) {
					wfDebug("renderPdf: broken / no pdf\n");

					wfProfileOut(__METHOD__);
					return array( 'msg' => "Broken or no pdf. (Info from pdfinfo.)", 'cmd' => $cmd, 'cmdOutput' => $output );
				}

				$pages = intval( trim($matches[1]) );

				$reminder = $matches[1] % 4;
				$add = $reminder ? 4 - $reminder : 0;
			} while(--$iteration && $add);

			if($add) {
				wfProfileOut(__METHOD__);
				return array( 'msg' => "Pdf generation error, can't reach mod 4 pages. (+{$add} page(s) needed.)" );
			}
		}
		else {
			// get number of pages
			$cmd = "/usr/bin/pdfinfo {$pdf}";
			$output = wfShellExec($cmd, $result);

			preg_match("/Pages: *([0-9]+)\n/", $output, $matches);

			$pages = intval( trim($matches[1]) );
		}

		// generate URL to pdf
		global $wgMagCloudUploadPath;
		$pdfUrl = "{$wgMagCloudUploadPath}/pdf/{$fname}";

		wfDebug("renderPdf: PDF ready (URL: {$pdfUrl})\n");

		// generate msg
		$msg = wfMsg('magcloud-preview-done');

		// debug
		global $wgDevelEnvironment;
		if (!empty($wgDevelEnvironment)) {
			$msg .= " <small>{$pages} pages | <a href=\"{$pdfUrl}\">download it</a></small>";
		}
		else {
			// hide PDF url
			$pdfUrl = false;
		}

		wfProfileOut(__METHOD__);

		return array(
			'msg' => $msg,
			'pdf' => $pdfUrl,
			'pages' => $pages,
		);
	}

	/*
	 * Upload PDF to MagCloud
	 */
	static public function publish($hash, $timestamp, $token) {

		if (empty($hash) || empty($timestamp) || empty($token)) {
			return array("msg" => "Not enough data.");
		}

		# c&p'ed from MagCloud::renderPdf(), factor it out FIXME
		// generate PDF name
		global $wgCityId;
		$fname = "{$wgCityId}-{$hash}-{$timestamp}.pdf";

		global $wgMagCloudUploadDirectory;
		$pdf = "{$wgMagCloudUploadDirectory}/pdf/{$fname}";

		if (!file_exists($pdf)) {
			return array("msg" => "No pdf. Please create it first.");
		}

		// rt#24491 add page > 100 check FIXME

		$tags = array();

		global $wgCityId;
		$cat = WikiFactory::getCategory($wgCityId);
		if (is_array($cat)) list($cat_id, $cat_name) = $cat;
		if (!empty($cat_name)) $tags[] = $cat_name;

		global $wgSitename;
		$tags[] = $wgSitename;

#echo "<pre>";
#$d = fopen("/tmp/curl.log", "w");


		$res = MagCloudApi::LoginAs($token);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'login', 'code' => $res->code);
		}

		$username   = $res->user->username;
		$authTicket = $res->authTicket;

		$res = MagCloudApi::getPublications($authTicket, $username);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'getPublications', 'code' => $res->code);
		}

		$publicationId = 0;

		// FIXME test if no publication!
		if (!empty($res->publication)) {
			foreach ($res->publication as $r) {
				if (MagCloudApi::PUB_NAME == "{$r->name}") {
#print_r(array("r->name" => $r->name, "r->id" => $r->id)); echo "\n";
					$publicationId = $r->id;
					break;
				}
			}
		}
#print_r(array("publicationId" => $publicationId)); echo "\n";

		if (empty($publicationId)) {

		$res = MagCloudApi::Publication($authTicket);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'publication', 'code' => $res->code);
		}

		$publicationId = $res->id;

		}

		// FIXME skip this step for new publication
		$res = MagCloudApi::getIssues($authTicket, $publicationId);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'getIssues', 'code' => $res->code);
		}

		$title_i = 0;
		// FIXME test if no issue!
		if (!empty($res->issue)) {
			foreach ($res->issue as $r) {
				if (preg_match("/^{$magazineTitle}(?: \(([0-9]+)\))?$/", "{$r->name}", $match)) {
#print_r(array("r->name" => $r->name, "match" => $match)); echo "\n";
					if (empty($match[1])) $match[1] = 1;
					if ($title_i < $match[1]) $title_i = $match[1];
				}
			}
		}

		if (!empty($title_i)) $magazineTitle .= " (" . ++$title_i . ")";

		$res = MagCloudApi::Issue($authTicket, $publicationId, $magazineTitle, $magazineSubtitle);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'issue', 'code' => $res->code);
		}

		$issueId = $res->id;

		$iteration = 3;
		do {
			sleep(3);

		$res = MagCloudApi::IssueUpload($authTicket, $issueId, $pdf);
#print_r($res); echo "\n";

		} while (--$iteration && empty($res->code));

		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'issueUpload', 'code' => $res->code);
		}

		$uploadJobId = $res->uploadJobId;

		$iteration = 20; // prevent infinite loop
		do {
			sleep(3);

			$res = MagCloudApi::UploadStatus($authTicket, $uploadJobId);
#print_r($res); echo "\n";
			if (!empty($res->code)) {
				return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'UploadStatus', 'code' => $res->code);
			}

			$processingFinished = ("{$res->processingFinished}" == "True") ? true : false;
			$rasterizationFinished = ("{$res->rasterizationFinished}" == "True") ? true : false;
		} while (--$iteration && !($processingFinished && $rasterizationFinished));

		if (!$processingFinished) {
			return array("msg" => "Remote backend processing not finished in allotted time.");
		}
# Don't treat it as fatal
#		if (!$rasterizationFinished) {
#			return array("msg" => "Remote backend rasterization not finished in allotted time.");
#		}

		$res = MagCloudApi::IssuePublish($authTicket, $issueId);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'issuePublish', 'code' => $res->code);
		}

#fclose($d);
#echo "</pre>";
#exit;

#echo $issueId;
		return array('msg' => wfMsg('magcloud-publish-done'), 'issue' => intval($issueId));
	}

	static public function publish2($hash, $timestamp, $token) {
		global $wgRequest;

		$c = MagCloudCollection::getInstance();
		$c->restore($hash);

		$state = $wgRequest->getVal("state", null);
		switch ($state) {
			default:
				$msg = "Error: Unknown state.";
				$next_state = null;
				$continue = false;

				break;
			case "initialize":

		if (empty($hash) || empty($timestamp) || empty($token)) {
			return array("msg" => "Not enough data.");
		}

		# c&p'ed from MagCloud::renderPdf(), factor it out FIXME
		// generate PDF name
		global $wgCityId;
		$fname = "{$wgCityId}-{$hash}-{$timestamp}.pdf";

		global $wgMagCloudUploadDirectory;
		$pdf = "{$wgMagCloudUploadDirectory}/pdf/{$fname}";

		if (!file_exists($pdf)) {
			return array("msg" => "No pdf. Please create it first.");
		}

				$c->setPublishData("pdf", $pdf);

		// rt#24491 add page > 100 check FIXME

		$tags = array();

		global $wgCityId;
		$cat = WikiFactory::getCategory($wgCityId);
		if (is_array($cat)) list($cat_id, $cat_name) = $cat;
		if (!empty($cat_name)) $tags[] = $cat_name;

		global $wgSitename;
		$tags[] = $wgSitename;

				$msg = wfMsg("magcloud-publish-ajax-{$state}");
				$next_state = "login";
				$continue = true;

				break;
			case "login":

#echo "<pre>";
#$d = fopen("/tmp/curl.log", "w");

		$res = MagCloudApi::LoginAs($token);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'login', 'code' => $res->code);
		}

		$username   = $res->user->username;
		$authTicket = $res->authTicket;

				$c->setPublishData("username",   "{$username}");
				$c->setPublishData("authTicket", "{$authTicket}");

				$msg = wfMsg("magcloud-publish-ajax-{$state}");
				$next_state = "publication";
				$continue = true;

				break;
			case "publication":

				$username   = $c->getPublishData("username");
				$authTicket = $c->getPublishData("authTicket");

		$res = MagCloudApi::getPublications($authTicket, $username);
#print_r($res); echo "\n";

		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'getPublications', 'code' => $res->code);
		}

		$publicationId = 0;

		// FIXME test if no publication!
		if (!empty($res->publication)) {
			foreach ($res->publication as $r) {
				if (MagCloudApi::PUB_NAME == "{$r->name}") {
#print_r(array("r->name" => $r->name, "r->id" => $r->id)); echo "\n";
					$publicationId = $r->id;
					break;
				}
			}
		}
#print_r(array("publicationId" => $publicationId)); echo "\n";

		if (empty($publicationId)) {

		$res = MagCloudApi::Publication($authTicket);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'publication', 'code' => $res->code);
		}

		$publicationId = $res->id;

		}

				$c->setPublishData("publicationId", "{$publicationId}");

				$msg = wfMsg("magcloud-publish-ajax-{$state}");
				$next_state = "issue";
				$continue = true;

				break;
			case "issue":

				$authTicket    = $c->getPublishData("authTicket");
				$publicationId = $c->getPublishData("publicationId");

		// FIXME skip this step for new publication
		$res = MagCloudApi::getIssues($authTicket, $publicationId);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'getIssues', 'code' => $res->code);
		}

/*
		// get magazine title / subtitle
		$collection = MagCloudCollection::getInstance();
		$collection->restore($hash);

		$coverData = $collection->getCoverData();
*/
		$coverData = $c->getCoverData();

		$magazineTitle = $coverData['title'];
		$magazineSubtitle = $coverData['subtitle'];

		$title_i = 0;
		// FIXME test if no issue!
		if (!empty($res->issue)) {
			foreach ($res->issue as $r) {
				if (preg_match("/^{$magazineTitle}(?: \(([0-9]+)\))?$/", "{$r->name}", $match)) {
#print_r(array("r->name" => $r->name, "match" => $match)); echo "\n";
					if (empty($match[1])) $match[1] = 1;
					if ($title_i < $match[1]) $title_i = $match[1];
				}
			}
		}

		if (!empty($title_i)) $magazineTitle .= " (" . ++$title_i . ")";

		$res = MagCloudApi::Issue($authTicket, $publicationId, $magazineTitle, $magazineSubtitle);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'issue', 'code' => $res->code);
		}

		$issueId = $res->id;

				$c->setPublishData("issueId", "{$issueId}");

				$msg = wfMsg("magcloud-publish-ajax-{$state}");
				$next_state = "upload";
				$continue = true;

				break;
			case "upload":

				$authTicket = $c->getPublishData("authTicket");
				$issueId    = $c->getPublishData("issueId");
				$pdf        = $c->getPublishData("pdf");

		$iteration = 3;
		do {
			sleep(3);

		$res = MagCloudApi::IssueUpload($authTicket, $issueId, $pdf);
#print_r($res); echo "\n";

		} while (--$iteration && empty($res->code));

		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'issueUpload', 'code' => $res->code);
		}

		$uploadJobId = $res->uploadJobId;

				$c->setPublishData("uploadJobId", "{$uploadJobId}");

				$msg = wfMsg("magcloud-publish-ajax-{$state}");
				$next_state = "processing";
				$continue = true;

				break;
			case "processing":

				$authTicket  = $c->getPublishData("authTicket");
				$uploadJobId = $c->getPublishData("uploadJobId");

		$iteration = 20; // prevent infinite loop
		do {
			sleep(3);

			$res = MagCloudApi::UploadStatus($authTicket, $uploadJobId);
#print_r($res); echo "\n";
			if (!empty($res->code)) {
				return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'UploadStatus', 'code' => $res->code);
			}

			$processingFinished = ("{$res->processingFinished}" == "True") ? true : false;
			$rasterizationFinished = ("{$res->rasterizationFinished}" == "True") ? true : false;
		} while (--$iteration && !($processingFinished && $rasterizationFinished));

		if (!$processingFinished) {
			return array("msg" => "Remote backend processing not finished in allotted time.");
		}
# Don't treat it as fatal
#		if (!$rasterizationFinished) {
#			return array("msg" => "Remote backend rasterization not finished in allotted time.");
#		}

				$msg = wfMsg("magcloud-publish-ajax-{$state}");
				$next_state = "publish";
				$continue = true;

				break;
			case "publish":

				$authTicket = $c->getPublishData("authTicket");
				$issueId    = $c->getPublishData("issueId");

		$res = MagCloudApi::IssuePublish($authTicket, $issueId);
#print_r($res); echo "\n";
		if (!empty($res->code)) {
			return array("msg" => "Error {$res->code}: {$res->message}.", 'step' => 'issuePublish', 'code' => $res->code);
		}

#fclose($d);
#echo "</pre>";
#exit;

#echo $issueId;
		return array('msg' => wfMsg('magcloud-publish-done'), 'issue' => intval($issueId));

				$msg = "All done. Check your issue at http://magcloud.com/browse/Issue/{$issueId}";
				$next_state = null;
				$continue = false;

				break;
		}

		return array("msg" => $msg, "state" => $next_state, "continue" => $continue);
	}

	/*
	 * Get color themes used by cover preview and PDF rendering code
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	static public function getColorThemes() {
		// list of themes and their colors in following order:
		// bg of bar with Wikia logo, cover bg, title box bg
		return array(
			'beach' => array('3e2a18', 'b0d9f3', '42779e'),
			'stark' => array('555', 'fff', 'b41212'),
			'buzzbee' => array('fff', 'f3f3f3', '000'),
			'austin' => array('758c51', 'fff', '555931'),
		);
	}

	/*
	 * Set Last-Modified header to time when collection was last modified
	 */
	static public function setLastModified( &$modifiedTimes ) {
		$collection = MagCloudCollection::getInstance();
		//if($collection->getToolbarVisibleState()) {
		$modifiedTimes['magcloud'] = wfTimestamp( TS_MW, $collection->getTimestamp() );;
		//}
		return true;
	}
}
