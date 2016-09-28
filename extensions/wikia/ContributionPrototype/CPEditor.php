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
		global $wgOut, $wgRequest, $wgUser, $wgContributionPrototypeExternalHost;

		$wgOut->addLink([
			'rel' => 'stylesheet',
			'href'=> "{$wgContributionPrototypeExternalHost}/public/assets/styles/main.css",
		]);

		// this ends up using $wgOut, but we need it for the assets manager integration, no point in duplicating :(
		Wikia::addAssetsToOutput('contribution_prototype_scss');

		$wgOut->addHTML( '<div id="editarea">\n' );
	}

}
