<?php

namespace Wikia\Search\IndexService;


class Evaluation extends AbstractService {


	/**
	 * @return array
	 */
	public function execute() {

		$service = $this->getService();
		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );

		$page = \WikiPage::newFromID( $pageId );
		$text = $page->getRawText();

		$titleStr = $service->getTitleStringFromPageId( $pageId );

		return [
			'wiki_id' => $service->getWikiId(),
			'page_id' => $pageId,
			'title' => $titleStr,
			'url' => $service->getUrlFromPageId( $pageId ),
			'ns' => $service->getNamespaceFromPageId( $pageId ),
			'lang' => $service->getSimpleLanguageCode(),
			'indexed' => gmdate( "Y-m-d\TH:i:s\Z" ),
			'content' => $text,
		];
	}
}
