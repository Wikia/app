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
		foreach ($collection as $page_id) {
			$article = Article::newFromID($page_id);

			#$wgOut->setPageTitle( $this->mTitle->getPrefixedText() );
			$wgOut->addHTML("<h1 style=\"page-break-before: always\">{$article->getTitle()->getPrefixedText()}</h1>");

			$article->doPurge(); // FIXME do it only for page_touched older than date of efBolekTemplate deployment
			$article->view();
		}

		$add = $wgRequest->getVal("add", 0);
		for ($i = 1; $i <= $add; $i++) {
			$wgOut->addHTML("<p style=\"page-break-before: always\">&nbsp;</p>");
			$wgOut->addHTML("<p>Debug: empty page added ({$i}/{$add}).</p>");
		}
		$wgOut->addHTML("</div>\n");

		$wgOut->addHTML("<script type=\"text/javascript\">/*<![CDATA[*/
			var content = $('#bolek');
			$('body').replaceWith(content);
			$('table#toc, span.editsection').remove();
			$('div.bolek-remove').text('Debug: blacklisted template removed.');
			/*]]>*/</script>\n");

		return;
	}
}
