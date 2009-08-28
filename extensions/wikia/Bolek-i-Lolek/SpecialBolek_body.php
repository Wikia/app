<?php

class BolekPage extends UnlistedSpecialPage {
	function  __construct() {
		parent::__construct("Bolek");
	}

	public function execute() {
		global $wgRequest, $wgUser, $wgOut, $wgCookiePrefix;

		if ($wgUser->isBlocked()) {
			$wgOut->blockedPage();
			return;
		}
		if (wfReadOnly()) {
			$wgOut->readOnlyPage();
			return;
		}

		$action  = $wgRequest->getVal("action",  "view");

		// totally different wrokflow, almost separate application
		if (in_array($action, array("print", "cover"))) {
			if (!empty($_COOKIE["{$wgCookiePrefix}bolek"])) {
				$bolek_id = $_COOKIE["{$wgCookiePrefix}bolek"];
			} else {
				$bolek_id = $wgRequest->getVal("bolek_id",  null); // FIXME add a secret hash (from lolek)?
			}

		if ("print" == $action) {
			$this->_print($bolek_id);
			return;
		}
		if ("cover" == $action) {
			$this->_cover($bolek_id);
			return;
		}

		}

		if (!in_array($wgUser->getName(), array("Ppiotr", "Angies", "Shahid", "VickyBC", "Eloy.wikia"))) {
			$this->displayRestrictionError();
			return;
		}

		if (!empty($_COOKIE["{$wgCookiePrefix}bolek"])) {
			$bolek_id = $_COOKIE["{$wgCookiePrefix}bolek"];
		} else {
			$bolek_id = md5(uniqid(mt_rand(), true));

			$expire = time()+3600*24*365;
			WebResponse::setcookie("bolek", $bolek_id, $expire);
		}

		switch ($action) {
			default:
			case "view":
				$result = "(empty action)";

				break;
			case "add":
				$result = Bolek::addPage($bolek_id, $wgRequest->getVal("page_id",  null));

				break;
			case "clear":
				$result = Bolek::clearCollection($bolek_id);

				break;
			case "remove":
				$result = Bolek::removePage($bolek_id, $wgRequest->getVal("page_id",  null));

				break;
			case "customize":
				$result = Bolek::customizeCover($bolek_id, $wgRequest->getArray("cover",  null));

				break;
		}

		$tmpl = new EasyTemplate(dirname(__FILE__));
		$tmpl->set_vars(array(
			"action"     => $action,
			"result"     => $result,
			"collection" =>  Bolek::getCollection($bolek_id),
			"url"        => $this->getTitle()->getFullURL(),
			"bolek_id"   => $bolek_id,
			"timestamp"  =>  Bolek::getTimestamp($bolek_id),
			"cover"      =>  Bolek::getCover($bolek_id),
		));

		$wgOut->addHTML($tmpl->execute("specialbolek"));
	}

	private function _print($bolek_id) {
		$collection = Bolek::getCollection($bolek_id);

		global $wgOut;
		$wgOut->addHTML("<div id=\"bolek\">\n");
		$bibliography = array();
		foreach ($collection as $page_id) {
			$article = Article::newFromID($page_id);
			$title   = $article->getTitle()->getPrefixedText();

			$wgOut->addHTML("<h1 style=\"page-break-before: always\">{$title}</h1>");

			$article->doPurge(); // FIXME do it only for page_touched older than date of efBolekTemplate deployment
			$article->view();

			$bibliography[] = $title;
		}

		if (sizeOf($bibliography)) {
			$wgOut->addHTML("<h1 style=\"page-break-before: always\">Bibliography</h1>");
			
			$wgOut->addHTML("<ul>");
			foreach ($bibliography as $title) {
				$wgOut->addHTML("<li>{$title}</li>");
			}
			$wgOut->addHTML("</ul>");
		}

		global $wgRequest;
		$add = $wgRequest->getVal("add", 0);
		for ($i = 1; $i <= $add; $i++) {
			$wgOut->addHTML("<p style=\"page-break-before: always\">&nbsp;</p>");
			$wgOut->addHTML("<p>Debug: empty page added ({$i}/{$add}).</p>");
		}

		$wgOut->addHTML("<div style=\"page-break-before: always\">");
		$wgOut->addHTML("<img src=\"http://images.wikia.com/common/skins/monaco/images/wikia_logo.png?1\" width=\"397\" height=\"100\"/>");
		$wgOut->addHTML("</div>");

		$wgOut->addHTML("</div>\n");

		$wgOut->addHTML("<script type=\"text/javascript\">/*<![CDATA[*/
			var content = $('#bolek');
			$('body').replaceWith(content);
			$('table#toc, span.editsection').remove();
			$('div.bolek-remove').text('Debug: blacklisted template removed.');
			/* $('div.tleft, div.tright').css({'float': 'none', 'clear': 'none'}); */
			/*]]>*/</script>\n");

		return;
	}

	private function _cover($bolek_id) {
		$cover = Bolek::getCover($bolek_id);

		global $wgOut;
		$wgOut->addHTML("<div id=\"bolek\">\n");

		$wgOut->addHTML("<div style=\"background-color: {$cover['background_color']}\">");
		$wgOut->addHTML("<div style=\"color: {$cover['title_color']}; font-size: {$cover['title_size']}\">{$cover['title']}</div>");
		$wgOut->addHTML("<div style=\"color: {$cover['subtitle_color']}; font-size: {$cover['subtitle_size']}; text-transform: uppercase\">{$cover['subtitle']}</div>");
		$wgOut->addHTML("<img src=\"{$cover['image']}\"/>");
		$wgOut->addHTML("</div>");
		$wgOut->addHTML("<img src=\"http://images.wikia.com/common/skins/monaco/images/wikia_logo.png?1\" width=\"159\" height=\"40\"/>");

		$wgOut->addHTML("</div>\n");

		$wgOut->addHTML("<script type=\"text/javascript\">/*<![CDATA[*/
			var content = $('#bolek');
			$('body').replaceWith(content);
			/*]]>*/</script>\n");

		return;
	}
}
