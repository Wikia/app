<?php

namespace Wikia\Search\IndexService;

use ImageServing;
use simple_html_dom;

/**
 * This is intended to provide core article content.
 * It has been copy pasted from DefaultContent.php but also includes full_html, so that it can be parsed by
 * an article snippet parser.
 *
 * @subpackage IndexService
 */
class FullContent extends AbstractService {
	/**
	 * Text from selectors in this list should be removed during HTML stripping.
	 *
	 * @var array
	 */
	protected $garbageSelectors = [
		'span[class~="DiscordIntegrator"]',
		'div[class~="embeddable-discussions-module"]',
		'span.editsection',
		'img',
		'noscript',
		'div.picture-attribution',
		'table#toc',
		'ol.references',
		'sup.reference',
		'script',
		'style',
		'comment',
	];

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
			'sitename' => $service->getGlobal( 'Sitename' ),
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
		$html = empty( $response['parse']['text']['*'] ) ? '' : $response['parse']['text']['*'];

		return $this->prepValuesFromHtml( $html );
	}

	/**
	 * Allows us to strip and parse HTML
	 * By the way, if every document on the site was as big as the Jim Henson page,
	 * then it would take under two minutes to parse them all using this function.
	 * So this scales on the application side. I promise. I mathed it.
	 *
	 * @param string $html
	 *
	 * @return array
	 */
	protected function prepValuesFromHtml( $html ) {
		// workaround for bug in html_entity_decode that truncates the text
		$html = str_replace( [ "&lt;", "&gt;" ], "", $html );

		$dom = new \simple_html_dom( html_entity_decode( $html, ENT_COMPAT, 'UTF-8' ) );

		if ( $dom->root ) {
			$this->removeGarbageFromDom( $dom );
			$html = $dom->save();
		}
		return ['full_html' => html_entity_decode( $html, ENT_COMPAT, 'UTF-8' )];
	}

	/**
	 * Iterates through UI remnants and removes them from the dom.
	 * Removed type hinting due to testing requirements and WikiaMockProxy
	 *
	 * @param simple_html_dom $dom
	 */
	protected function removeGarbageFromDom( $dom ) {
		foreach ( $this->garbageSelectors as $selector ) {
			foreach ( $dom->find( $selector ) as $node ) {
				$node->outertext = ' ';
			}
		}
	}
}
