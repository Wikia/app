<?php

class BolekPage extends UnlistedSpecialPage {
	function  __construct() {
		parent::__construct("Bolek");
	}

	public function execute() {
		global $wgRequest, $wgUser, $wgOut;

		$action  = $wgRequest->getVal("action",  "view");

		// totally different wrokflow, almost separate application
		if ("print" == $action) {
			$this->_print();
			return;
		}
		// too many exceptions... )-: rethink, refactor
		if ("cover" == $action) {
			$this->_cover();
			return;
		}

		if (!in_array($wgUser->getName(), array("Ppiotr", "Angies", "Shahid", "VickyBC", "Eloy.wikia"))) {
			$this->displayRestrictionError();
			return;
		}

		switch ($action) {
			default:
			case "view":
				$result = "(empty action)";

				break;
			case "add":
				$result = Bolek::addPage($wgRequest->getVal("page_id",  null));

				break;
			case "clear":
				$result = Bolek::clearCollection();

				break;
			case "remove":
				$result = Bolek::removePage($wgRequest->getVal("page_id",  null));

				break;
		}

		$tmpl = new EasyTemplate(dirname(__FILE__));
		$tmpl->set_vars(array(
			"action"     => $action,
			"result"     => $result,
			"collection" =>  Bolek::getCollection(),
			"url"        => $this->getTitle()->getFullURL(),
			"user_id"    => $wgUser->getId(),
			"timestamp"  =>  Bolek::getCollectionTimestamp(),
		));

		$wgOut->addHTML($tmpl->execute("specialbolek"));
	}

	private function _print() {
		global $wgRequest;
		$user_id = $wgRequest->getVal("user_id",  null);
		$collection = Bolek::getCollection($user_id);

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

	private function _cover() {
		global $wgOut;
		$wgOut->addHTML("<div id=\"bolek\">\n");

		$wgOut->addHTML("<div style=\"background-color: #FF6600\">");
		$wgOut->addHTML("<div style=\"color: #FFF; font-size: 80pt\">Magazine Title</div>");
		$wgOut->addHTML("<div style=\"color: #FFF505; font-size: 28pt; text-transform: uppercase\">Subtitle which will be slightly longer</div>");
		$wgOut->addHTML("<img src=\"http://images.wikia.com/muppet/images/7/79/Kermit-the-frog.jpg\"/>");
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
