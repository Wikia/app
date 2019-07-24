<?php

namespace Wikia\Search\IndexService;

use ImageServing;

/**
 * This is intended to provide core article content.
 * It has been copy pasted from DefaultContent.php but also includes full_html, so that it can be parsed by
 * an article snippet parser.
 *
 * @subpackage IndexService
 */
class FullContent extends AbstractService {
	const SPACE_SEQUENCE_REGEXP = "/\s+/";

	/**
	 * Text from selectors in this list should be removed during HTML stripping.
	 *
	 * @var array
	 */
	protected $garbageSelectors = [
		'span.editsection',
		'img',
		'noscript',
		'div.picture-attribution',
		'table#toc',
		'ol.references',
		'sup.reference',
		'script',
		'style',
	];

	/**
	 * We remove these selectors since they are unreliable indicators of textual content
	 *
	 * @var array
	 */
	protected $asideSelectors = [ 'table', 'figure', 'div.noprint', 'div.quote', '.dablink' ];

	/**
	 * Returns the fields required to make the document searchable (specifically, wid and title and body content)
	 *
	 * @return array
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 */
	public function execute() {
		$service = $this->getService();
		$pageId = $service->getCanonicalPageIdFromPageId( $this->currentPageId );
		// we still assume the response is the same format as MediaWiki's
		$response = $service->getParseResponseFromPageId( $pageId );

		// ensure the response is an array, even if empty.
		$response = empty( $response ) ? [] : $response;
		$titleStr = $service->getTitleStringFromPageId( $pageId );


		$imageServing = new ImageServing( [ $pageId ] );
		$images = $imageServing->getImages( 1 );
		$image = isset( $images[$pageId][0]['url'] ) ? $images[$pageId][0]['url'] : null;

		return array_merge( $this->getPageContentFromParseResponse( $response ), [
			'wid' => $service->getWikiId(),
			'pageid' => $pageId,
			'title' => $titleStr,
			'redirect_titles' => $service->getRedirectTitlesForPageId( $pageId ),
			'url' => $service->getUrlFromPageId( $pageId ),
			'ns' => $service->getNamespaceFromPageId( $pageId ),
			'lang' => $service->getSimpleLanguageCode(),
			'iscontent' => $service->isPageIdContent( $pageId ) ? 'true' : 'false',
			'is_main_page' => $service->isPageIdMainPage( $pageId ) ? 'true' : 'false',
			'image' => $image,
		] );
	}

	/**
	 * Wraps logic for creating the initial result array, based on which implementation we're using.
	 * The old version strips HTML from the backend; the new version strips HTML within the IndexService.
	 *
	 * @param array $response
	 *
	 * @return array
	 */
	protected function getPageContentFromParseResponse( array $response ) {
		$html = $response['parse']['text']['*'] ?? '';
		$html = str_replace( [ "&lt;", "&gt;" ], "", $html );
		$encoded = html_entity_decode( $html, ENT_COMPAT, 'UTF-8' );

		return [
			'full_html' => $encoded,
		];
	}

	/**
	 * @param string $html
	 *
	 * @return array
	 */
	protected function prepValuesFromHtml( $html ) {
		// workaround for bug in html_entity_decode that truncates the text

	}
}
