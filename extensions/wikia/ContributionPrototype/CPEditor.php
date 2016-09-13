<?php
namespace ContributionPrototype;

use Article;
use Http;
use MWHttpRequest;
use EditPage;
use OutputPage;
use Wikia;
use Wikia\Logger\Loggable;
use Wikia\Service\Gateway\UrlProvider;

class CPEditor extends EditPage {

	use Loggable;

	function __construct(Article $article) {
		parent::__construct($article);
	}

	function edit() {
		global $wgOut, $wgRequest, $wgUser;

		$wgOut->addHTML( '<div id="editarea">\n' );
	}

}